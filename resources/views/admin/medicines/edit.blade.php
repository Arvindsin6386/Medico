@extends('layouts.app')

@section('content')
    <div class="container py-4" style="max-width: 700px;">

        {{-- EDIT MEDICINE CARD --}}
        <div class="card shadow-sm border-0 rounded-3">
            <div class="card-header bg-success text-white py-3 px-4 rounded-top-3">
                <h5 class="mb-0">✏️ Edit Medicine</h5>
            </div>

            <div class="card-body px-4 py-4">

                <form action="{{ route('admin.medicines.update', $medicine->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    {{-- NAME --}}
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Medicine Name *</label>
                            <input type="text" name="name" class="form-control"
                                value="{{ old('name', $medicine->name) }}" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Generic Name</label>
                            <input type="text" name="generic_name" class="form-control"
                                value="{{ old('generic_name', $medicine->generic_name) }}">
                        </div>
                    </div>

                    {{-- CATEGORY --}}
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Category *</label>
                            <select name="category_id" class="form-select" required>
                                <option value="">Select</option>
                                @foreach ($categories as $cat)
                                    <option value="{{ $cat->id }}"
                                        {{ $medicine->category_id == $cat->id ? 'selected' : '' }}>
                                        {{ $cat->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Sub Category</label>
                            <select name="subcategory_id" class="form-select">
                                <option value="">Select</option>
                                @foreach ($subcategories as $sub)
                                    <option value="{{ $sub->id }}"
                                        {{ $medicine->subcategory_id == $sub->id ? 'selected' : '' }}>
                                        {{ $sub->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    {{-- PRICE --}}
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Purchase Price *</label>
                            <input type="number" name="purchase_price" class="form-control"
                                value="{{ $medicine->purchase_price }}" step="0.01" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Selling Price *</label>
                            <input type="number" name="selling_price" class="form-control"
                                value="{{ $medicine->selling_price }}" step="0.01" required>
                        </div>
                    </div>

                    {{-- STOCK --}}
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Stock *</label>
                            <input type="number" name="stock" class="form-control" value="{{ $medicine->stock }}"
                                required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Expiry Date</label>
                            <input type="date" name="expiry_date" class="form-control"
                                value="{{ optional($medicine->expiry_date)->format('Y-m-d') }}">
                        </div>
                    </div>

                    <button type="submit" class="btn btn-success px-4">
                        Update Medicine
                    </button>

                    <a href="{{ route('admin.medicines.index') }}" class="btn btn-secondary">
                        Back
                    </a>

                </form>

            </div>
        </div>

        {{-- IMAGE UPLOAD SECTION --}}
        <div class="card shadow-sm border-0 rounded-3 mt-4">
            <div class="card-header bg-primary text-white py-3 px-4 rounded-top-3">
                <h5 class="mb-0">🖼️ Medicine Images</h5>
            </div>

            <div class="card-body px-4 py-4">

                {{-- UPLOAD FORM --}}
                <form action="{{ route('admin.medicines.images.store', $medicine->id) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf

                    <input type="file" name="images[]" class="form-control mb-3" multiple accept="image/*" required>

                    <button class="btn btn-primary btn-sm">
                        Upload Images
                    </button>
                </form>

                <hr>

                {{-- SHOW IMAGES --}}

                <div class="row">

                    @forelse ($medicine->images as $img)
                        <div class="col-md-3 mb-3 text-center">

                            <img src="{{ Str::startsWith($img->image_path, 'http') ? $img->image_path : asset('storage/' . $img->image_path) }}"
                                alt="Medicine Image" class="img-fluid rounded shadow"
                                style="height:150px; width:100%; object-fit:cover;">

                            <form action="{{ route('admin.medicines.images.destroy', [$medicine->id, $img->id]) }}"
                                method="POST" class="mt-2">

                                @csrf
                                @method('DELETE')

                                <button class="btn btn-danger btn-sm w-100" onclick="return confirm('Delete this image?')">

                                    🗑 Delete

                                </button>

                            </form>

                        </div>

                    @empty

                        <div class="col-12 text-muted">
                            No images uploaded yet.
                        </div>
                    @endforelse

                </div>

            </div>
        </div>

    </div>
@endsection
