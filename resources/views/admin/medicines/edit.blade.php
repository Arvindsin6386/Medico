@extends('layouts.app')

@section('content')
    <div class="container py-4" style="max-width: 700px;">

        <div class="card shadow-sm border-0 rounded-3">
            <div class="card-header bg-success text-white py-3 px-4 rounded-top-3">
                <h5 class="mb-0">✏️ Edit Medicine</h5>
            </div>

            <div class="card-body px-4 py-4">
                <form action="{{ route('admin.medicines.update', $medicine->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    {{-- Row 1 --}}
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Medicine Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control"
                                value="{{ old('name', $medicine->name) }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Generic Name</label>
                            <input type="text" name="generic_name" class="form-control"
                                value="{{ old('generic_name', $medicine->generic_name ?? '') }}"
                                placeholder="e.g. Paracetamol">
                        </div>
                    </div>

                    {{-- Row 2 --}}
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Category <span class="text-danger">*</span></label>
                            <select name="category_id" class="form-select" required>
                                <option value="">— Select Category —</option>
                                @foreach ($categories as $cat)
                                    <option value="{{ $cat->id }}"
                                        {{ old('category_id', $medicine->category_id) == $cat->id ? 'selected' : '' }}>
                                        {{ $cat->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Sub-Category</label>
                            <select name="subcategory_id" class="form-select">
                                <option value="">— Select Sub-Category —</option>
                                @foreach ($subcategories as $sub)
                                    <option value="{{ $sub->id }}"
                                        {{ old('subcategory_id', $medicine->subcategory_id) == $sub->id ? 'selected' : '' }}>
                                        {{ $sub->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    {{-- Row 3 --}}
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Purchase Price (₹) <span
                                    class="text-danger">*</span></label>
                            <input type="number" name="purchase_price" class="form-control" step="0.01" min="0"
                                value="{{ old('purchase_price', $medicine->purchase_price ?? '') }}" placeholder="0.00"
                                required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Selling Price (₹) <span
                                    class="text-danger">*</span></label>
                            <input type="number" name="selling_price" class="form-control" step="0.01" min="0"
                                value="{{ old('selling_price', $medicine->selling_price ?? '') }}" placeholder="0.00"
                                required>
                        </div>
                    </div>

                    {{-- Row 4 --}}
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Stock <span class="text-danger">*</span></label>
                            <input type="number" name="stock" class="form-control" min="0"
                                value="{{ old('stock', $medicine->stock) }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Expiry Date</label>
                            <input type="date" name="expiry_date" class="form-control"
                                value="{{ old('expiry_date', optional($medicine->expiry_date)->format('Y-m-d') ?? '') }}">
                        </div>
                    </div>

                    <hr class="my-3">

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-success px-4">Update</button>
                        <a href="{{ route('admin.medicines.index') }}" class="btn btn-secondary">Back</a>
                    </div>

                </form>
            </div>
        </div>

    </div>


    <hr class="my-3">

    <div class="d-flex gap-2">
        {{-- <button type="submit" class="btn btn-success px-4">Update</button> --}}
        <a href="{{ route('admin.medicines.index') }}" class="btn btn-secondary">Back</a>
    </div>

    </form>
    </div>
    </div>

    {{-- Medicine Images Section --}}
    <div class="card shadow-sm border-0 rounded-3 mt-4">
        <div class="card-header bg-primary text-white py-3 px-4 rounded-top-3">
            <h5 class="mb-0">🖼️ Medicine Documents</h5>
        </div>

        <div class="card-body px-4 py-4">
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

            <div class="row">
                @forelse($medicine->images as $img)
                    <div class="col-md-3 mb-3 text-center">
                        <a href="{{ asset('storage/' . $img->image_path) }}" target="_blank">
                            <img src="{{ asset('storage/' . $img->image_path) }}" class="img-fluid rounded shadow"
                                style="height:150px; width:100%; object-fit:cover; cursor:pointer;">
                        </a>
                        <form action="{{ route('admin.medicines.images.destroy', [$medicine->id, $img->id]) }}"
                            method="POST" class="mt-2">
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
    </div>

    </div>
@endsection
