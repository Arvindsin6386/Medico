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
    // Opens Add Medicine form 
    // Called when "Add Medicine" clicked in sidebar
    public function create()
    {
        $categories    = Category::where('status', 'active')->latest()->get();
        $subcategories = Subcategory::where('status', 'active')->latest()->get();
        return view('admin.medicines.create', compact('categories', 'subcategories'));
    }

    // Shows all medicines
    // Called when "Manage Medicines" clicked in sidebar 
    public function index()
    {
        $medicines     = Medicine::with('category', 'subcategory')->latest()->get();
        $categories    = Category::where('status', 'active')->get();
        $subcategories = Subcategory::where('status', 'active')->get();
        return view('admin.medicines.index', compact('medicines', 'categories', 'subcategories'));
    }

    // Saves new medicine to DB
    // Called when Add Medicine form submitted
    public function store(Request $request)
    {
        $request->validate([
            'category_id'    => 'required|exists:categories,id',
            'subcategory_id' => 'required|exists:subcategories,id',
            'name'           => 'required|string|max:255|unique:medicines,name',
            'selling_price'  => 'nullable|numeric|min:0',
            'purchase_price' => 'nullable|numeric|min:0',
            'stock'          => 'nullable|integer|min:0',
        ]);

        // Handle image upload
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('medicines', 'public');
        }

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
            'expiry_date'      => $request->expiry_date,
            'status'           => $request->status ?? 'active',
            'image'            => $imagePath,
            'description'      => $request->description,
        ]);

        return redirect()->route('admin.medicines.index')
            ->with('success', 'Medicine added successfully!');
    }

    // Updates medicine in DB
    // Called when Edit form submitted in Manage Medicines
    public function update(Request $request, Medicine $medicine)
    {
        $request->validate([
            'category_id'    => 'required|exists:categories,id',
            'subcategory_id' => 'required|exists:subcategories,id',
            'name'           => 'required|string|max:255|unique:medicines,name,' . $medicine->id,
            'selling_price'  => 'nullable|numeric|min:0',
            'purchase_price' => 'nullable|numeric|min:0',
            'stock'          => 'nullable|integer|min:0',
        ]);

        // Handle image — delete old, save new
        $imagePath = $medicine->image;
        if ($request->hasFile('image')) {
            if ($medicine->image) {
                Storage::disk('public')->delete($medicine->image);
            }
            $imagePath = $request->file('image')->store('medicines', 'public');
        }

        $medicine->update([
            'category_id'      => $request->category_id,
            'subcategory_id'   => $request->subcategory_id,
            'name'             => $request->name,
            'brand_name'       => $request->brand_name,
            'medicine_type'    => $request->medicine_type,
            'unit'             => $request->unit,
            'purchase_price'   => $request->purchase_price,
            'selling_price'    => $request->selling_price,
            'stock'            => $request->stock,
            'batch_number'     => $request->batch_number,
            'manufacture_date' => $request->manufacture_date,
            'expiry_date'      => $request->expiry_date,
            'status'           => $request->status,
            'image'            => $imagePath,
            'description'      => $request->description,
        ]);

        return redirect()->back()->with('success', 'Medicine updated successfully!');
    }

    // Deletes medicine from DB
    // Called when Delete button clicked
    public function destroy(Medicine $medicine)
    {
        if ($medicine->image) {
            Storage::disk('public')->delete($medicine->image);
        }
        $medicine->delete();
        return redirect()->back()->with('success', 'Medicine deleted successfully!');
    }
}
