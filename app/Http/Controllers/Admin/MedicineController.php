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

    public function getmedicine(Request $request) // ajaxList()
    {
        if ($request->ajax()) {

            $query = Medicine::with('category', 'subcategory');

            if (!empty($request->category)) {
                $query->where('category_id', $request->category);
            }
            if(!empty($request->stock)){
               if($request->stock == 'low'){
                $query->where('stock', '<=' , '5');
               }

               if($request->stock == 'out'){
                $query->where('stock' , '=' , 0);
               }

               if($request->stock == 'avilable'){
                $query->where('stcok' , '>' , 0);
               }

            }

            if(!empty($request->search)){
                $query->where('name');
            }

            $medicine = $query->latest()->get();

            return DataTables::of($medicine)
                ->addIndexColumn()

                // IMAGE
                ->addColumn('image', function ($row) {
                    if ($row->image) {
                        return '<img src="' . asset("storage/" . $row->image) . '" width="40" height="40" style="border-radius:6px;">';
                    }
                    return '<div style="width:40px;height:40px;background:#eee;border-radius:6px;"></div>';
                })

                // CATEGORY
                ->addColumn('category', function ($row) {
                    return $row->category->name ?? '-';
                })

                // SUBCATEGORY
                ->addColumn('subcategory', function ($row) {
                    return $row->subcategory->name ?? '-';
                })

                // STATUS
                ->addColumn('status', function ($row) {
                    return $row->status == 'active'
                        ? '<span class="badge bg-success">Active
                        </span>'
                        : '<span class="badge bg-danger">Inactive</span>';
                })

                // ACTION (THIS IS WHERE YOUR IMAGE BUTTON GOES)
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
                ->rawColumns(['image', 'status', 'action'])
                ->make(true);
        }
    }

    // Store Medicine
    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'subcategory_id' => 'required|exists:subcategories,id',
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $imagePath = null;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('medicines', 'public');
        }

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
            'expiry_date' => $request->expiry_date,
            'status' => 'active',
            'image' => $imagePath,
            'description' => $request->description,
        ]);

        return redirect()->route('admin.medicines.index')
            ->with('success', 'Medicine Added Successfully');
    }
    public function edit($id)
    {
        $medicine = Medicine::findOrFail($id);
        $categories = Category::all();
        $subcategories = Subcategory::all();

        return view('admin.medicines.edit', compact(
            'medicine',
            'categories',
            'subcategories'
        ));
    }

    public function update(Request $request, Medicine $medicine)
    {
        $request->validate([
            'name'           => 'required|string|max:255',
            'category_id'    => 'required|exists:categories,id',
            'subcategory_id' => 'required|exists:subcategories,id',
            'selling_price'  => 'nullable|numeric|min:0',
            'purchase_price' => 'nullable|numeric|min:0',
            'stock'          => 'nullable|integer|min:0',
            'image'          => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

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

        // IMAGE
        if ($request->hasFile('image')) {

            if ($medicine->image && Storage::disk('public')->exists($medicine->image)) {
                Storage::disk('public')->delete($medicine->image);
            }

            $data['image'] = $request->file('image')->store('medicines', 'public');
        }

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

    public function view($id)
    {
        $medicine = Medicine::with('images')->findOrFail($id);
        //  $medicine = Medicine::all();
        return view('admin.medicines.medicine-view', compact('medicine'));
    }
}
