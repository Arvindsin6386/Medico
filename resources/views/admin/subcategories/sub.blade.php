@extends('layouts.app')

@section('content')

<div class="container">

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    {{-- Add Subcategory Form --}}
    <div class="card mb-4">
        <div class="card-header">Add Subcategory</div>
        <div class="card-body">
            <form action="{{ route('admin.subcategories.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">

                    {{-- Category Dropdown --}}
                    <div class="col-md-3">
                        <label>Category <span class="text-danger">*</span></label>
                        <select name="category_id" class="form-control" required>
                            <option value="">-- Select Category --</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Name --}}
                    <div class="col-md-3">
                        <label>Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control"
                               placeholder="Enter subcategory name"
                               value="{{ old('name') }}" required>
                        @error('name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Description --}}
                    <div class="col-md-3">
                        <label>Description</label>
                        <input type="text" name="description" class="form-control"
                               placeholder="Enter description"
                               value="{{ old('description') }}">
                        @error('description')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Status --}}
                    <div class="col-md-2">
                        <label>Status <span class="text-danger">*</span></label>
                        <select name="status" class="form-control" required>
                            <option value="">-- Select --</option>
                            <option value="active"   {{ old('status') == 'active'   ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                        @error('status')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                </div>

                <div class="row mt-3">

                    {{-- Image --}}
                    <div class="col-md-3">
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

    {{-- Subcategory Table --}}
    <div class="card">
        <div class="card-header">All Subcategories</div>
        <div class="card-body">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Image</th>
                        <th>Category</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($subcategories as $index => $subcategory)
                    <tr>
                        <td>{{ $index + 1 }}</td>

                        {{-- Image --}}
                        <td>
                            @if($subcategory->image)
                                <img src="{{ asset('storage/' . $subcategory->image) }}"
                                     alt="{{ $subcategory->name }}"
                                     width="50" height="50"
                                     style="object-fit:cover; border-radius:6px;">
                            @else
                                <span class="text-muted">No image</span>
                            @endif
                        </td>

                        <td>{{ $subcategory->category->name }}</td>
                        <td>{{ $subcategory->name }}</td>
                        <td>{{ $subcategory->description ?? '—' }}</td>

                        {{-- Status --}}
                        <td>
                            <span class="badge bg-{{ $subcategory->status === 'active' ? 'success' : 'secondary' }}">
                                {{ ucfirst($subcategory->status) }}
                            </span>
                        </td>

                        {{-- Actions --}}
                        <td>
                            <button class="btn btn-sm btn-warning"
                                data-bs-toggle="modal"
                                data-bs-target="#editSubcategory{{ $subcategory->id }}">
                                Edit
                            </button>

                            <form action="{{ route('admin.subcategories.destroy', $subcategory->id) }}"
                                  method="POST" style="display:inline"
                                  onsubmit="return confirm('Are you sure?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>

                    {{-- Edit Modal --}}
                    <div class="modal fade" id="editSubcategory{{ $subcategory->id }}" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Edit Subcategory</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <form action="{{ route('admin.subcategories.update', $subcategory->id) }}"
                                      method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-body">

                                        {{-- Category --}}
                                        <div class="mb-3">
                                            <label>Category <span class="text-danger">*</span></label>
                                            <select name="category_id" class="form-control" required>
                                                <option value="">-- Select Category --</option>
                                                @foreach($categories as $category)
                                                    <option value="{{ $category->id }}"
                                                        {{ $subcategory->category_id == $category->id ? 'selected' : '' }}>
                                                        {{ $category->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        {{-- Name --}}
                                        <div class="mb-3">
                                            <label>Name <span class="text-danger">*</span></label>
                                            <input type="text" name="name" class="form-control"
                                                   value="{{ $subcategory->name }}" required>
                                        </div>

                                        {{-- Description --}}
                                        <div class="mb-3">
                                            <label>Description</label>
                                            <input type="text" name="description" class="form-control"
                                                   value="{{ $subcategory->description }}">
                                        </div>

                                        {{-- Status --}}
                                        <div class="mb-3">
                                            <label>Status <span class="text-danger">*</span></label>
                                            <select name="status" class="form-control" required>
                                                <option value="active"   {{ $subcategory->status === 'active'   ? 'selected' : '' }}>Active</option>
                                                <option value="inactive" {{ $subcategory->status === 'inactive' ? 'selected' : '' }}>Inactive</option>
                                            </select>
                                        </div>

                                        {{-- Image --}}
                                        <div class="mb-3">
                                            <label>Image</label>
                                            <input type="file" name="image" class="form-control" accept="image/*"
                                                   onchange="previewImage(event, 'editPreview{{ $subcategory->id }}')">

                                            @if($subcategory->image)
                                                <img id="editPreview{{ $subcategory->id }}"
                                                     src="{{ asset('storage/' . $subcategory->image) }}"
                                                     alt="Preview"
                                                     style="margin-top:8px; width:70px; height:70px; object-fit:cover; border-radius:6px;">
                                            @else
                                                <img id="editPreview{{ $subcategory->id }}" src="#" alt="Preview"
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
                        <td colspan="7" class="text-center">No subcategories found.</td>
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
                preview.src           = e.target.result;
                preview.style.display = 'block';
            };
            reader.readAsDataURL(file);
        }
    }
</script>

@endsection