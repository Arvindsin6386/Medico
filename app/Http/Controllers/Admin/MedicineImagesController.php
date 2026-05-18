<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Medicine;
use App\Models\MedicineImage;
use Illuminate\Support\Facades\Storage;

class MedicineImagesController extends Controller
{public function index($id)
{
    $medicine = Medicine::findOrFail($id);
    $medicine->load('images');
    return view('admin.medicines.documents', compact('medicine'));
}

    public function store(Request $request, $id)
    {
           // dd($request->all(), $request->hasFile('images'), $request->files->all());

        $request->validate([
            'images.*' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048'
        ]);

        $medicine = Medicine::findOrFail($id);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $path = $file->store('medicines', 'public');
                $medicine->images()->create(['image_path' => $path]);
            }
        }

        return back()->with('success', 'Images uploaded successfully');
    }

    public function update(Request $request, $id)
    {
        $medicine = Medicine::findOrFail($id);

        if ($request->hasFile('images')) {
            foreach ($medicine->images as $img) {
                Storage::disk('public')->delete($img->image_path);
                $img->delete();
            }

            foreach ($request->file('images') as $image) {
                $path = $image->store('medicines', 'public');
                $medicine->images()->create(['image_path' => $path]);
            }
        }

        return back()->with('success', 'Images updated');
    }

public function destroy($id, $imageId)
{
    $image = Medicine::findOrFail($imageId);

    // Only delete file if image_path exists
    if ($image->image_path && Storage::disk('public')->exists($image->image_path)) {
        Storage::disk('public')->delete($image->image_path);
    }

    $image->delete();

    return back()->with('success', 'Image deleted successfully');
}
}