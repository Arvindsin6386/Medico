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
    // opens the Add Medicine page with category form

    public function create()
    {
        $categories = Category::where('status', 'active')->latest()->get();
        $subcategories = Subcategory::where('status', 'active')->latest()->get();
        return view('admin.medicines.create', compact('categories', 'subcategories'));
    }

    public function index()
    {
        $medicines     = Medicine::with('category', 'subcategory')->latest()->get();
        $categories    = Category::where('status', 'active')->get();
        $subcategories = Subcategory::where('status', 'active')->get();
        return view('admin.medicines.index', compact('medicines', 'categories', 'subcategories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id'    => 'required|exists:categories,id',
            'subcategory_id' => 'required|exists:subcategories,id',
            'name'           => 'required|string|max:255|unique:medicines,name',
            'stock'          => 'nullable|integer|min:0',

        ]);

        Medicine::create([
            'category_id'    => $request->category_id,
            'subcategory_id' => $request->subcategory_id,
            'name'           => $request->name,
            'stock'          => $request->stock ?? 0,

        ]);

        return redirect()->route('admin.dashboard')->with('success', 'Medicine added successfully!');
    }

    public function update(Request $request, Medicine $medicine)
    {
        $request->validate([
            'category_id'    => 'required|exists:categories,id',
            'subcategory_id' => 'required|exists:subcategories,id',
            'name'           => 'required|string|max:255|unique:medicines,name,' . $medicine->id,
        ]);

        $medicine->update([
            'category_id'    => $request->category_id,
            'subcategory_id' => $request->subcategory_id,
            'name'           => $request->name,
        ]);

        return redirect()->back()->with('success', 'Medicine updated successfully!');
    }

    public function destroy(Medicine $medicine)
    {
        $medicine->delete();
        return redirect()->back()->with('success', 'Medicine deleted successfully!');
    }
}
