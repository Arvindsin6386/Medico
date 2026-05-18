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
            'name' => 'required',
            'status' => 'required',
            'images.*' => 'image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $images = [];

        if ($request->hasFile('images')) {

            foreach ($request->file('images') as $file) {

                $path = $file->store('categories', 'public');

                $images[] = $path;

                //
            }
        }

        //dd($images);

        $category = Category::create([
            'name' => $request->name,
            'description' => $request->description,
            'status' => $request->status,
            'images' => $images,
        ]);
                //dd($category->toArray());


        return redirect()->back()->with('success', 'Category Added');
    }


    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name'        => 'required|string|max:255|unique:categories,name,' . $category->id,
            'description' => 'nullable|string|max:500',
            'status'      => 'required|in:active,inactive',
            'images.*'    => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $images = $category->images ?? [];

        if ($request->hasFile('images')) {

            // delete old images
            if (!empty($category->images)) {
                foreach ($category->images as $old) {
                    Storage::disk('public')->delete($old);
                }
            }

            $images = [];

            foreach ($request->file('images') as $image) {
                $images[] = $image->store('categories', 'public');
            }
        }

        $category->update([
            'name'        => $request->name,
            'description' => $request->description,
            'status'      => $request->status,
            'images'      => $images,
        ]);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Category Updated Successfully');
    }

    public function destroy(Category $category)
    {
        // delete images
        if ($category->images) {

            foreach ($category->images as $image) {

                if (Storage::disk('public')->exists($image)) {

                    Storage::disk('public')->delete($image);
                }
            }
        }

        $category->delete();

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Category Deleted Successfully');
    }
}
