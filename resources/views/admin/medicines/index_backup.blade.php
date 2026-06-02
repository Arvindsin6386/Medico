@extends('layouts.app')

@section('content')

    <div class="container py-4">

        {{-- ALERTS --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="d-flex justify-content-between mb-3">
            <h4>Manage Medicines</h4>
            <a href="{{ route('medicines.create') }}" class="btn btn-success">
                Add Medicine
            </a>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered align-middle">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Category</th>
                                <th>Stock</th>
                                <th>Price</th>
                                <th width="150">Action</th>
                            </tr>
                        </thead>
                        <tbody>

                            @forelse($medicines as $medicine)
                                <tr>
                                    <td>
                                        {{ dd($medicine->masterImage) }}

                                        @if ($medicine->masterImage)
                                            <img src="{{ asset('storage/' . $medicine->masterImage->image_path) }}"
                                                alt="Medicine Image" width="60" height="60" class="img-thumbnail"
                                                style="object-fit:cover; cursor:pointer;" data-bs-toggle="modal"
                                                data-bs-target="#imageModal{{ $medicine->id }}">
                                        @else
                                            <span class="text-muted" style="font-size:12px;">
                                                No Image
                                            </span>
                                        @endif

                                    </td>

                                    <td>{{ $medicine->name }}</td>

                                    <td>{{ $medicine->category->name ?? '-' }}</td>

                                    <td>{{ $medicine->stock }}</td>

                                    <td>₹{{ $medicine->selling_price }}</td>

                                    <td>

                                        {{-- MANAGE IMAGES BUTTON --}}
                                        <button class="btn btn-sm px-2 py-1"
                                            style="background:#fff3cd; color:#856404; border-radius:8px;"
                                            data-bs-toggle="modal" data-bs-target="#imageModal{{ $medicine->id }}"
                                            title="Manage Images">
                                            <i class="bi bi-image"></i>
                                        </button>

                                        {{-- EDIT --}}
                                        <a href="{{ route('medicines.edit', $medicine->id) }}"
                                            class="btn btn-success btn-sm">
                                            Edit
                                        </a>

                                        {{-- DELETE --}}
                                        <form action="{{ route('medicines.destroy', $medicine->id) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm"
                                                onclick="return confirm('Delete this medicine?')">
                                                Delete
                                            </button>
                                        </form>

                                    </td>
                                </tr>

                                {{-- ============================================================
                                     IMAGE MODAL — one per medicine
                                     Opened by:
                                       1. Clicking the thumbnail image in the table
                                       2. Clicking the yellow image button in actions
                                     No JS needed — pure Bootstrap data-bs-toggle/target
                                ============================================================ --}}
                                <div class="modal fade" id="imageModal{{ $medicine->id }}" tabindex="-1">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">

                                            <div class="modal-header">
                                                <h5 class="modal-title">
                                                    {{ $medicine->name }} — Images
                                                    <small class="text-muted" style="font-size:13px;">
                                                        ({{ $medicine->images->count() }} uploaded)
                                                    </small>
                                                </h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>

                                            <div class="modal-body">

                                                {{-- UPLOAD MORE IMAGES
                                                     Bug fix: was using route('admin.medicines.store') — wrong.
                                                     Correct: medicines.images.store with medicine id in URL.
                                                     Controller: MedicineImagesController@store($id)
                                                --}}
                                                <form action="{{ route('medicines.images.store', $medicine->id) }}"
                                                    method="POST" enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="mb-3">
                                                        <label class="form-label fw-semibold">
                                                            Upload Images
                                                            <small class="text-muted fw-normal">(jpg, jpeg, png, webp —
                                                                multiple allowed)</small>
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
                                                            <a href="{{ asset('storage/' . $img->image_path) }}"
                                                                target="_blank">
                                                                <img src="{{ asset('storage/' . $img->image_path) }}"
                                                                    class="img-fluid rounded shadow"
                                                                    style="height:150px; width:100%; object-fit:cover; cursor:pointer;">
                                                            </a>

                                                            {{-- DELETE single image
                                                                 Controller: MedicineImagesController@destroy($img->id)
                                                                 Deletes only this one image from storage + DB
                                                            --}}
                                                            <form
                                                                action="{{ route('medicines.images.destroy', $img->id) }}"
                                                                method="POST" class="mt-2">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button class="btn btn-danger btn-sm w-100"
                                                                    onclick="return confirm('Delete this image?')">
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
                                </div>
                                {{-- END IMAGE MODAL --}}

                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-4">
                                        <i class="bi bi-capsule fs-1 text-muted"></i>
                                        <p class="text-muted mt-2">No medicines found.</p>
                                        <a href="{{ route('medicines.create') }}" class="btn btn-success btn-sm">
                                            + Add First Medicine
                                        </a>
                                    </td>
                                </tr>
                            @endforelse

                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

@endsection
