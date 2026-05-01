<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;



class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('subcategories')->get();
        return view('admin.categories.index', compact('categories'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
            'description' => 'nullable|string|max:500',
            'status'      => 'required|in:active,inactive',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',

        ]);
        // save to database
        $miagepath = null;
        if ($request->hasFile('image')) {
            $miagepath = $request->file('image')->store('categories', 'public');
        }
        Category::create([
            'name' => $request->name,
            'description' => $request->description,
            'status' => $request->status,
            'image' => $miagepath,

        ]);
        return redirect()->back()->with('success', 'Category Add Successfully');
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
            'description' => 'nullable|string|max:500',
            'status'      => 'required|in:active,inactive',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',

        ]);
        // image upload — delete old image if new one is uploaded
        $imagePath = $category->image;  
        if ($request->hasFile('image')) {        // check user uplode file in image path 
            if ($category->image && Storage::disk('public')->exists($category->image)) {    // check DB existe image 
                Storage::disk('public')->delete($category->image);    // delete image
            }
            $imagePath = $request->file('image')->store('categories', 'public');    // store new image
        }
        $category->update([
            'name' => $request->name,
            'description' => $request->description,
            'status'      => $request->status,
            'image'       => $imagePath,

        ]);
        return redirect()->back()
            ->with('success', 'Category updated successfully!');
    }

    public function destroy(Category $category)
    {
        $category->delete();

        return redirect()->back()
            ->with('success', 'Category deleted successfully!');
    }
}
