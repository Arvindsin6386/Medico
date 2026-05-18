@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <h2>Medicine DOcuments</h2>

        <form action="{{ route('admin.medicines.images.store', ['id' => $medicine->id]) }}" method="POST"
            enctype="multipart/form-data">

            @csrf
            <input type="hidden" name="medicine_id" value="{{ $medicine?->id }}">
            <div class="mb-3">
                <label class="form-label fw-semibold">
                    Upload Images
                    <small class="text-muted fw-normal">(jpg, jpeg, png, webp — multiple allowed)</small>
                </label>
                <input type="file" name="images[]" class="form-control" multiple
                    accept="image/jpg,image/jpeg,image/png,image/webp" required>
            </div>
            <button class="btn btn-primary btn-sm">
                <i class="bi bi-upload"></i> Upload Images
            </button>
        </form>

        <hr>

        {{-- ALL UPLOADED IMAGES GRID
                                                     Bug fix: was using $img->image — wrong field name.
                                                     Correct: $img->image_path (matches your MedicineImages model/controller)
                                                --}}
        <div class="row">
            @forelse($medicine->images as $img)
                <div class="col-md-3 mb-3 text-center">

                    {{-- Full size view — open in new tab, no JS needed --}}
                    <a href="{{ asset('storage/' . $img->image_path) }}" target="_blank">
                        <img src="{{ asset('storage/' . $img->image_path) }}" class="img-fluid rounded shadow"
                            style="height:150px; width:100%; object-fit:cover; cursor:pointer;">
                    </a>

                    {{-- DELETE single image
                                                                 Controller: MedicineImagesController@destroy($img->id)
                                                                 Deletes only this one image from storage + DB
                                                            --}}
                    <form action="{{ route('admin.medicines.images.destroy', [$medicine->id, $img->id]) }}" method="POST"
                        class="mt-2">
                         @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm w-100" onclick="return confirm('Delete this image?')">
                            <i class="bi bi-trash"></i> Delete
                        </button>
                    </form>

                </div>
            @empty
                <div class="col-12">
                    <p class="text-muted">No images uploaded yet.</p>
                </div>
            @endforelse
        </div>
    </div>
@endsection
