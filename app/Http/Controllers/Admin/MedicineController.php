<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\Medicine;
use App\Models\MedicineImages;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class MedicineController extends Controller
{
    // =========================================
    // CREATE PAGE
    // =========================================
    public function create()
    {
        $categories = Category::where('status', 'active')
            ->latest()
            ->get();

        $subcategories = Subcategory::where('status', 'active')
            ->latest()
            ->get();

        return view('admin.medicines.create', compact(
            'categories',
            'subcategories'
        ));
    }

    // =========================================
    // INDEX PAGE
    // =========================================
    public function index()
    {
        $medicines = Medicine::with([
            'category',
            'subcategory',
            'masterImage'
        ])->latest()->get();

        $categories = Category::where('status', 'active')->get();

        $subcategories = Subcategory::where('status', 'active')->get();

        return view('admin.medicines.index', compact(
            'medicines',
            'categories',
            'subcategories'
        ));
    }

    // =========================================
    // DATATABLE AJAX
    // =========================================
    public function getmedicine(Request $request)
    {
        if ($request->ajax()) {

            $query = Medicine::with([
                'category',
                'subcategory',
                'masterImage'
            ]);

            // CATEGORY FILTER
            if (!empty($request->category)) {
                $query->where('category_id', $request->category);
            }

            // STOCK FILTER
            if (!empty($request->stock)) {

                if ($request->stock == 'low') {
                    $query->whereBetween('stock', [1, 5]);
                }

                if ($request->stock == 'out') {
                    $query->where('stock', 0);
                }

                if ($request->stock == 'in') {
                    $query->where('stock', '>', 5);
                }
            }

            // SEARCH
            if (!empty($request->search)) {

                $query->where('name', 'like', '%' . $request->search . '%');

            }

            $medicine = $query->latest()->get();

            return DataTables::of($medicine)

                ->addIndexColumn()

                // =========================================
                // IMAGE COLUMN
                // =========================================
                ->addColumn('image', function ($row) {
                    
                    if ($row->masterImage) {

                        return '
                            <img src="' . asset('storage/' . $row->masterImage->image_path) . '"
                                width="50"
                                height="50"
                                style="
                                    border-radius:8px;
                                    object-fit:cover;
                                    border:1px solid #ddd;
                                ">
                        ';
                    } elseif(count($row->images) > 0){
                         return '
                            <img src="' . asset('storage/' . $$row->images->first()?->image_path) . '"
                                width="50"
                                height="50"
                                style="
                                    border-radius:8px;
                                    object-fit:cover;
                                    border:1px solid #ddd;
                                ">
                        ';
                    }

                    return '
                        <div style="
                            width:50px;
                            height:50px;
                            background:#f1f1f1;
                            border-radius:8px;
                        "></div>
                    ';
                })

                // =========================================
                // CATEGORY
                // =========================================
                ->addColumn('category', function ($row) {

                    return $row->category->name ?? '-';

                })

                // =========================================
                // TYPE
                // =========================================
                ->addColumn('medicine_type', function ($row) {

                    return $row->medicine_type ?? '-';

                })

                // =========================================
                // STOCK
                // =========================================
                ->addColumn('stock', function ($row) {

                    if ($row->stock == 0) {

                        return '<span class="badge bg-danger">Out of Stock</span>';

                    } elseif ($row->stock <= 5) {

                        return '<span class="badge bg-warning text-dark">Low Stock</span>';

                    }

                    return '<span class="badge bg-success">In Stock</span>';

                })

                // =========================================
                // STATUS
                // =========================================
                ->addColumn('status', function ($row) {

                    return $row->status == 'active'
                        ? '<span class="badge bg-success">Active</span>'
                        : '<span class="badge bg-danger">Inactive</span>';

                })

                // =========================================
                // ACTION
                // =========================================
                ->addColumn('action', function ($row) {

                    return '

                        <a href="' . route('admin.medicine.view', $row->id) . '"
                            class="btn btn-sm btn-success">

                            View

                        </a>

                        <a href="' . route('admin.medicines.edit', $row->id) . '"
                            class="btn btn-sm btn-primary">

                            Edit

                        </a>

                        <button class="btn btn-sm btn-danger deleteBtn"
                            data-id="' . $row->id . '">

                            Delete

                        </button>

                    ';
                })

                ->rawColumns([
                    'image',
                    'stock',
                    'status',
                    'action'
                ])

                ->make(true);
        }
    }

    // =========================================
    // STORE MEDICINE
    // =========================================
    public function store(Request $request)
    {
        $request->validate([

            'category_id' => 'required|exists:categories,id',

            'subcategory_id' => 'required|exists:subcategories,id',

            'name' => 'required|string|max:255',

            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',

        ]);

        $imagePath = null;

        // STORE IMAGE
        if ($request->hasFile('image')) {

            $imagePath = $request->file('image')
                ->store('medicines', 'public');

        }

        // CREATE MEDICINE
        $medicine = Medicine::create([

            'category_id' => $request->category_id,

            'subcategory_id' => $request->subcategory_id,

            'name' => $request->name,

            'brand_name' => $request->brand_name,

            'medicine_type' => $request->medicine_type,

            'unit' => $request->unit,

            'purchase_price' => $request->purchase_price ?? 0,

            'selling_price' => $request->selling_price ?? 0,

            'stock' => $request->stock ?? 0,

            'batch_number' => $request->batch_number,

            'manufacture_date' => $request->manufacture_date,

            'expiry_date' => $request->expiry_date,

            'status' => 'active',

            'description' => $request->description,

        ]);

        // SAVE IMAGE IN medicine_images TABLE
        if ($imagePath) {

            MedicineImages::create([

                'medicine_id' => $medicine->id,

                'image_path' => $imagePath,

                'is_master' => true,

            ]);
        }

        return redirect()
            ->route('admin.medicines.index')
            ->with('success', 'Medicine Added Successfully');
    }

    // =========================================
    // EDIT PAGE
    // =========================================
    public function edit($id)
    {
        $medicine = Medicine::with('images')
            ->findOrFail($id);

        $categories = Category::all();

        $subcategories = Subcategory::all();

        return view('admin.medicines.edit', compact(
            'medicine',
            'categories',
            'subcategories'
        ));
    }

    // =========================================
    // UPDATE
    // =========================================
    public function update(Request $request, Medicine $medicine)
    {
        $request->validate([

            'name' => 'required|string|max:255',

            'category_id' => 'required|exists:categories,id',

            'subcategory_id' => 'required|exists:subcategories,id',

        ]);

        $medicine->update([

            'category_id' => $request->category_id,

            'subcategory_id' => $request->subcategory_id,

            'name' => $request->name,

            'purchase_price' => $request->purchase_price,

            'selling_price' => $request->selling_price,

            'stock' => $request->stock,

            'expiry_date' => $request->expiry_date,

            'description' => $request->description,

        ]);

        return redirect()
            ->route('admin.medicines.index')
            ->with('success', 'Medicine updated successfully.');
    }

    // =========================================
    // DELETE
    // =========================================
    public function destroy($id)
    {
        $medicine = Medicine::findOrFail($id);

        if ($medicine->billItems()->exists()) {

            return response()->json([

                'success' => false,

                'message' => 'Cannot delete this medicine. It is linked to bills.'

            ], 422);
        }

        $medicine->delete();

        return response()->json([

            'success' => true,

            'message' => 'Medicine deleted successfully.'

        ]);
    }

    // =========================================
    // VIEW PAGE
    // =========================================
    public function view($id)
    {
        $medicine = Medicine::with('images')
            ->findOrFail($id);

        return view('admin.medicines.medicine-view', compact('medicine'));
    }
}