<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\Medicine;
use Illuminate\Support\Facades\Storage;

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

            'category_id'      => $request->category_id,

            'subcategory_id'   => $request->subcategory_id,

            'name'             => $request->name,

            'brand_name'       => $request->brand_name,

            'medicine_type'    => $request->medicine_type,

            'unit'             => $request->unit,

            'purchase_price'   => $request->purchase_price,

            'selling_price'    => $request->selling_price,

            'stock'            => $request->stock ?? 0,

            'batch_number'     => $request->batch_number,

            'manufacture_date' => $request->manufacture_date,

            // IMPORTANT FIX
            'expiry_data'      => $request->expiry_data,

            'status'           => $request->status ?? 'active',

            'image'            => $imagePath,

            'description'      => $request->description,
        ]);

        return redirect()
            ->route('admin.medicines.index')
            ->with('success', 'Medicine added successfully!');
    }

    // Update Medicine
    public function update(Request $request, Medicine $medicine)
    {
        // Validation
        $request->validate([
            'category_id'    => 'required|exists:categories,id',
            'subcategory_id' => 'required|exists:subcategories,id',
            'name'           => 'required|string|max:255|unique:medicines,name,' . $medicine->id,
            'selling_price'  => 'nullable|numeric|min:0',
            'purchase_price' => 'nullable|numeric|min:0',
            'stock'          => 'nullable|integer|min:0',
            'expiry_data'    => 'nullable|date',
            'manufacture_date' => 'nullable|date',
            'image'          => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Keep old image
        $imagePath = $medicine->image;

        // Upload new image
        if ($request->hasFile('image')) {

            // Delete old image
            if ($medicine->image) {

                Storage::disk('public')
                    ->delete($medicine->image);
            }

            // Store new image
            $imagePath = $request->file('image')
                ->store('medicines', 'public');
        }

        // Update Medicine
        $medicine->update([

            'category_id'      => $request->category_id,

            'subcategory_id'   => $request->subcategory_id,

            'name'             => $request->name,

            'brand_name'       => $request->brand_name,

            'medicine_type'    => $request->medicine_type,

            'unit'             => $request->unit,

            'purchase_price'   => $request->purchase_price,

            'selling_price'    => $request->selling_price,

            'stock'            => $request->stock ?? 0,

            'batch_number'     => $request->batch_number,

            'manufacture_date' => $request->manufacture_date,

            // IMPORTANT FIX
            'expiry_data'      => $request->expiry_data,

            'status'           => $request->status ?? 'active',

            'image'            => $imagePath,

            'description'      => $request->description,
        ]);

        return redirect()
            ->back()
            ->with('success', 'Medicine updated successfully!');
    }

    // Delete Medicine
    public function destroy(Medicine $medicine)
    {
        // Delete image
        if ($medicine->image) {

            Storage::disk('public')
                ->delete($medicine->image);
        }

        // Delete medicine
        $medicine->delete();

        return redirect()
            ->back()
            ->with('success', 'Medicine deleted successfully!');
    }
}