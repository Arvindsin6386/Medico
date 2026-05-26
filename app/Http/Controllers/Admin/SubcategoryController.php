<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class SubcategoryController extends Controller
{
    public function index()
    {
        $subcategories = Subcategory::with('category')->latest()->get();
        $categories    = Category::where('status', 'active')->latest()->get();
        return view('admin.subcategories.sub', compact('subcategories', 'categories'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255|unique:subcategories,name',
            'description' => 'nullable|string|max:500',
            'status'      => 'required|in:active,inactive',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',

        ]);
        $imagepath = null;
        if ($request->hasFile('image')) {
            $imagepath = $request->file('image')->store('subcategories', 'public');
        }

        Subcategory::create([
            'category_id' => $request->category_id,
            'name'        => $request->name,
            'description' => $request->description,
            'status'      => $request->status,
            'image'       => $imagepath,

        ]);
        return redirect()->back()->with('success', 'Subcategory added successfully!');
    }

    public function update(Request $request, Subcategory $subcategory)
    {


        $request->validate([

            'category_id' => 'required|exists:categories,id',

            'name' => [
                'required',
                'max:255',
                Rule::unique('subcategories', 'name')
                    ->ignore($subcategory->id),
            ],

            'description' => 'nullable|string|max:500',

            'status' => 'required|in:active,inactive',

            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',

        ]);


        // Old image
        $imagePath = $subcategory->image;


        // Upload new image
        if ($request->hasFile('image')) {

            // Delete old image
            if (
                $subcategory->image &&
                Storage::disk('public')->exists($subcategory->image)
            ) {

                Storage::disk('public')
                    ->delete($subcategory->image);
            }

            // Store new image
            $imagePath = $request->file('image')
                ->store('subcategories', 'public');
        }


        // Update data
        $updated = $subcategory->update([

            'category_id' => $request->category_id,

            'name' => $request->name,

            'description' => $request->description,

            'status' => $request->status,

            'image' => $imagePath,

        ]);



        if ($updated) {

            return redirect()->back()
                ->with('success', 'Subcategory updated successfully!');
        } else {

            return redirect()->back()
                ->with('error', 'Subcategory not updated!');
        }
    }

    public function destroy(Subcategory $subcategory)
    {
        // delete image from storage on soft delete
        if ($subcategory->image && Storage::disk('public')->exists($subcategory->image)) {
            Storage::disk('public')->delete($subcategory->image);
        }

        $subcategory->delete();

        return redirect()->back()->with('success', 'Subcategory deleted successfully!');
    }
}
