@extends('layouts.app')

@section('content')

<div class="container">

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    {{-- Add Category Form --}}
    <div class="card mb-4">
        <div class="card-header">Add Category</div>
        <div class="card-body">
            <form action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">

                    {{-- Name --}}
                    <div class="col-md-3">
                        <label>Name</label>
                        <input type="text" name="name" class="form-control" placeholder="Enter category name" required>
                        @error('name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Description --}}
                    <div class="col-md-3">
                        <label>Description</label>
                        <input type="text" name="description" class="form-control" placeholder="Enter description">
                        @error('description')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Status --}}
                    <div class="col-md-2">
                        <label>Status</label>
                        <select name="status" class="form-control" required>
                            <option value="">-- Select --</option>
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                        @error('status')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Image --}}
                    <div class="col-md-2">
                        <label>Image</label>
                        <input type="file" name="image" class="form-control" accept="image/*"
                               onchange="previewImage(event, 'addPreview')">
                        @error('image')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                        <img id="addPreview" src="#" alt="Preview"
                             style="display:none; margin-top:8px; width:60px; height:60px; object-fit:cover; border-radius:6px;">
                    </div>

                    {{-- Submit --}}
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary w-100">Add</button>
                    </div>

                </div>
            </form>
        </div>
    </div>

    {{-- Category Table --}}
    <div class="card">
        <div class="card-header">All Categories</div>
        <div class="card-body">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Subcategories</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($categories as $index => $category)
                    <tr>
                        <td>{{ $index + 1 }}</td>

                        {{-- Image --}}
                        <td>
                            @if($category->image)
                                <img src="{{ asset('storage/' . $category->image) }}"
                                     alt="{{ $category->name }}"
                                     width="50" height="50"
                                     style="object-fit:cover; border-radius:6px;">
                            @else
                                <span class="text-muted">No image</span>
                            @endif
                        </td>

                        <td>{{ $category->name }}</td>
                        <td>{{ $category->description ?? '—' }}</td>
                        <td>{{ $category->subcategories_count }}</td>

                        {{-- Status --}}
                        <td>
                            <span class="badge bg-{{ $category->status === 'active' ? 'success' : 'secondary' }}">
                                {{ ucfirst($category->status) }}
                            </span>
                        </td>

                        {{-- Actions --}}
                        <td>
                            <button class="btn btn-sm btn-warning"
                                data-bs-toggle="modal"
                                data-bs-target="#editCategory{{ $category->id }}">
                                Edit
                            </button>

                            <form action="{{ route('admin.categories.destroy', $category->id) }}"
                                  method="POST" style="display:inline"
                                  onsubmit="return confirm('Are you sure?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>

                    {{-- Edit Modal --}}
                    <div class="modal fade" id="editCategory{{ $category->id }}" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Edit Category</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <form action="{{ route('admin.categories.update', $category->id) }}"
                                      method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-body">

                                        {{-- Name --}}
                                        <div class="mb-3">
                                            <label>Name</label>
                                            <input type="text" name="name" class="form-control"
                                                   value="{{ $category->name }}" required>
                                        </div>

                                        {{-- Description --}}
                                        <div class="mb-3">
                                            <label>Description</label>
                                            <input type="text" name="description" class="form-control"
                                                   value="{{ $category->description }}">
                                        </div>

                                        {{-- Status --}}
                                        <div class="mb-3">
                                            <label>Status</label>
                                            <select name="status" class="form-control" required>
                                                <option value="active"   {{ $category->status === 'active'   ? 'selected' : '' }}>Active</option>
                                                <option value="inactive" {{ $category->status === 'inactive' ? 'selected' : '' }}>Inactive</option>
                                            </select>
                                        </div>

                                        {{-- Image --}}
                                        <div class="mb-3">
                                            <label>Image</label>
                                            <input type="file" name="image" class="form-control" accept="image/*"
                                                   onchange="previewImage(event, 'editPreview{{ $category->id }}')">

                                            {{-- Current Image Preview --}}
                                            @if($category->image)
                                                <img id="editPreview{{ $category->id }}"
                                                     src="{{ asset('storage/' . $category->image) }}"
                                                     alt="Preview"
                                                     style="margin-top:8px; width:70px; height:70px; object-fit:cover; border-radius:6px;">
                                            @else
                                                <img id="editPreview{{ $category->id }}" src="#" alt="Preview"
                                                     style="display:none; margin-top:8px; width:70px; height:70px; object-fit:cover; border-radius:6px;">
                                            @endif
                                        </div>

                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                        <button type="submit" class="btn btn-primary">Update</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    {{-- End Edit Modal --}}

                    @empty
                    <tr>
                        <td colspan="7" class="text-center">No categories found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

{{-- Image Preview Script --}}
<script>
    function previewImage(event, previewId) {
        const preview = document.getElementById(previewId);
        const file    = event.target.files[0];

        if (file) {
            const reader  = new FileReader();
            reader.onload = function(e) {
                preview.src             = e.target.result;
                preview.style.display   = 'block';
            };
            reader.readAsDataURL(file);
        }
    }
</script>

@endsection