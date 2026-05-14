<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\Medicine;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class MedicineController extends Controller
{
    // Show Add Medicine Form
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

    // Show All Medicines
    public function index()
    {
        $medicines = Medicine::with(['category', 'subcategory'])
            ->latest()
            ->get();

        $categories = Category::where('status', 'active')->get();

        $subcategories = Subcategory::where('status', 'active')->get();

        return view('admin.medicines.index', compact(
            'medicines',
            'categories',
            'subcategories'
        ));
    }

    public function getmedicine(Request $request)
    {
        if ($request->ajax()) {
            $medicine = Medicine::with('Category')->latest();
            return DataTables::of($medicine)
                ->addIndexColumn()
                ->addColumn('image', function ($row) {
                    if ($row->image) {

                        return '<img src="' . asset('storage/' . $row->image) . '"
                            width="40"
                            height="40"
                            style="border-radius:6px;">';
                    }

                    return 'No Image';
                })
                ->addColumn('category', function ($row) {
                    return $row->category->name ?? '-';
                })

                ->addColumn('suncategory' , function ($row){
                    return $row->subcategory->name ?? '-';
                })

                ->addcolumn('status', function ($row) {
                    if ($row->status == 'active') {

                        return '<span class="badge bg-success">Active</span>';
                    }

                    return '<span class="badge bg-danger">Inactive</span>';
                })
                ->addColumn('action', function ($row) {

                    $editBtn = '
                    <a href="' . route('admin.medicines.edit', $row->id) . '"
                        class="btn btn-sm btn-success">
                        Edit
                    </a>
                ';

                    $deleteBtn = '
                    <button class="btn btn-sm btn-danger deleteBtn"
                        data-id="' . $row->id . '">
                        Delete
                    </button>
                ';

                    return $editBtn . ' ' . $deleteBtn;
                })
                ->rawColumns(['image', 'status', 'action'])

                ->make(true);
        }
    }

    // Store Medicine
    public function store(Request $request)
    {
        // Validation
        $request->validate([
            'category_id'    => 'required|exists:categories,id',
            'subcategory_id' => 'required|exists:subcategories,id',
            'name'           => 'required|string|max:255|unique:medicines,name',
            'selling_price'  => 'nullable|numeric|min:0',
            'purchase_price' => 'nullable|numeric|min:0',
            'stock'          => 'nullable|integer|min:0',
            'expiry_data'    => 'nullable|date',
            'manufacture_date' => 'nullable|date',
            'image'          => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Image Upload
        $imagePath = null;

        if ($request->hasFile('image')) {

            $imagePath = $request->file('image')
                ->store('medicines', 'public');
        }

        // Save Medicine
        Medicine::create([

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

            'expiry_date' => $request->expiry_data,

            'status' => $request->status ?? 'active',

            'image' => $imagePath,

            'description' => $request->description,
        ]);

        return redirect()
            ->route('admin.medicines.index')
            ->with('success', 'Medicine added successfully!');
    }

    public function update(Request $request, $id)
    {
        $medicine = Medicine::findOrFail($id);

        // Validation
        $request->validate([
            'name'           => 'required|string|max:255',
            'category_id'    => 'required|exists:categories,id',
            'subcategory_id' => 'required|exists:subcategories,id',
            'selling_price'  => 'nullable|numeric|min:0',
            'purchase_price' => 'nullable|numeric|min:0',
            'stock'          => 'nullable|integer|min:0',
            'image'          => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        // Data
        $data = [

            'category_id'      => $request->category_id,

            'subcategory_id'   => $request->subcategory_id,

            'name'             => $request->name,

            'purchase_price'   => $request->purchase_price,

            'selling_price'    => $request->selling_price,

            'stock'            => $request->stock,

            'batch_number'     => $request->batch_number,

            'manufacture_date' => $request->manufacture_date,

            'expiry_date'      => $request->expiry_date,

            'description'      => $request->description,
        ];

        // Image Upload
        if ($request->hasFile('image')) {

            if ($medicine->image && Storage::disk('public')->exists($medicine->image)) {
                Storage::disk('public')->delete($medicine->image);
            }

            $data['image'] = $request->file('image')
                ->store('medicines', 'public');
        }

        // Update
        $medicine->update($data);

        return redirect()
            ->route('admin.medicines.index')
            ->with('success', 'Medicine updated successfully.');
    }

    // Delete Medicine
    public function destroy($id)
    {
        $medicine = Medicine::findOrFail($id);

        // Check if this medicine is used in any bill
        if ($medicine->billItems()->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot delete this medicine. It is linked to existing bill records.'
            ], 422);
        }

        $medicine->delete();
        return response()->json(['success' => true, 'message' => 'Medicine deleted successfully.']);
    }
}
