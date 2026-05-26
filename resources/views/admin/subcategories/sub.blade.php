@extends('layouts.app')

@section('content')
    <div class="container-fluid py-4">

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

        {{-- PAGE HEADER --}}
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div>
                <h5 class="fw-bold mb-0" style="color:#0d2b24;">Manage Subcategories</h5>
                <p class="text-muted mb-0" style="font-size:13px;">
                    Total: {{ $subcategories->count() }} subcategories
                </p>
            </div>
            <button class="btn btn-sm px-4" style="background:#1D9E75; color:#fff; border-radius:10px;"
                data-bs-toggle="modal" data-bs-target="#addSubcategoryModal">
                + Add Subcategory
            </button>
        </div>

        {{-- STAT CARDS --}}
        <div class="row g-3 mb-4">
            <div class="col-md-4 col-6">
                <div class="p-3 rounded-3" style="background:#e1f5ee; border:1px solid #9FE1CB;">
                    <p class="mb-1 text-muted" style="font-size:12px;">Total Subcategories</p>
                    <h4 class="fw-bold mb-0" style="color:#085041;">{{ $subcategories->count() }}</h4>
                </div>
            </div>
            <div class="col-md-4 col-6">
                <div class="p-3 rounded-3" style="background:#e1f5ee; border:1px solid #9FE1CB;">
                    <p class="mb-1 text-muted" style="font-size:12px;">Active</p>
                    <h4 class="fw-bold mb-0" style="color:#085041;">{{ $subcategories->where('status', 'active')->count() }}
                    </h4>
                </div>
            </div>
            <div class="col-md-4 col-6">
                <div class="p-3 rounded-3" style="background:#fcebeb; border:1px solid #F7C1C1;">
                    <p class="mb-1 text-muted" style="font-size:12px;">Inactive</p>
                    <h4 class="fw-bold mb-0" style="color:#A32D2D;">
                        {{ $subcategories->where('status', 'inactive')->count() }}</h4>
                </div>
            </div>
        </div>

        {{-- SEARCH & FILTER BAR --}}
        <div class="card border-0 shadow-sm mb-3">
            <div class="card-body py-2">
                <div class="row g-2 align-items-center">
                    <div class="col-md-4">
                        <input type="text" id="searchInput" class="form-control form-control-sm"
                            placeholder="Search subcategory name...">
                    </div>
                    <div class="col-md-3">
                        <select id="filterCategory" class="form-control form-control-sm">
                            <option value="">All Categories</option>
                            @foreach ($categories as $category)
                                <option value="{{ strtolower($category->name) }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select id="filterStatus" class="form-control form-control-sm">
                            <option value="">All Status</option>
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button id="resetBtn" class="btn btn-sm btn-outline-secondary w-100">Reset</button>
                    </div>
                </div>
            </div>
        </div>

        {{-- SUBCATEGORIES TABLE --}}
        <div class="card border-0 shadow-sm">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0" style="font-size:13px;">
                        <thead style="background:#f0f4f3;">
                            <tr>
                                <th class="px-3 py-3" style="font-size:11px; color:#6b9e93;">#</th>
                                <th class="py-3" style="font-size:11px; color:#6b9e93;">Image</th>
                                <th class="py-3" style="font-size:11px; color:#6b9e93;">Category</th>
                                <th class="py-3" style="font-size:11px; color:#6b9e93;">Name</th>
                                <th class="py-3" style="font-size:11px; color:#6b9e93;">Description</th>
                                <th class="py-3" style="font-size:11px; color:#6b9e93;">Status</th>
                                <th class="py-3" style="font-size:11px; color:#6b9e93;">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="subcategoryTableBody">
                            @forelse($subcategories as $index => $subcategory)
                               {{-- // {{ dd($subcategory->image) }} --}}
                                <tr class="subcategory-row" data-name="{{ strtolower($subcategory->name) }}"
                                    data-category="{{ strtolower($subcategory->category->name ?? '') }}"
                                    data-status="{{ $subcategory->status }}">

                                    <td class="px-3 py-3" style="color:#6b9e93;">{{ $index + 1 }}</td>

                                    <td class="py-3">
                                        @if ($subcategory->image)
                                            <img src="{{ Str::startsWith($subcategory->image, 'http') ? $subcategory->image : asset('storage/' . $subcategory->image) }}"
                                                alt="{{ $subcategory->name }}"
                                                style="width:40px; height:40px; object-fit:cover; border-radius:8px;">
                                        @else
                                            <div
                                                style="width:40px; height:40px; background:#e1f5ee;
                                                border-radius:8px; display:flex;
                                                  align-items:center; justify-content:center;">
                                                <i class="bi bi-image text-muted" style="font-size:16px;"></i>
                                            </div>
                                        @endif
                                    </td>

                                    <td class="py-3" style="color:#0d2b24;">
                                        {{ $subcategory->category->name ?? '—' }}
                                    </td>

                                    <td class="py-3">
                                        <p class="mb-0 fw-semibold" style="color:#0d2b24;">{{ $subcategory->name }}</p>
                                    </td>

                                    <td class="py-3" style="color:#0d2b24;">
                                        {{ Str::limit($subcategory->description, 40) ?? '—' }}
                                    </td>

                                    <td class="py-3">
                                        @if ($subcategory->status === 'active')
                                            <span class="badge rounded-pill px-2 py-1"
                                                style="background:#e1f5ee; color:#085041; font-size:11px;">Active</span>
                                        @else
                                            <span class="badge rounded-pill px-2 py-1"
                                                style="background:#fcebeb; color:#A32D2D; font-size:11px;">Inactive</span>
                                        @endif
                                    </td>

                                    <td class="py-3">
                                        <div class="d-flex gap-2">
                                            <button class="btn btn-sm px-2 py-1"
                                                style="background:#e1f5ee; color:#085041; border-radius:8px; font-size:12px;"
                                                data-bs-toggle="modal"
                                                data-bs-target="#editSubcategory{{ $subcategory->id }}">
                                                <i class="bi bi-pencil"></i>
                                            </button>
                                            <button type="button" class="btn btn-sm px-2 py-1 delete-btn"
                                                style="background:#fcebeb; color:#A32D2D; border-radius:8px; font-size:12px;"
                                                data-id="{{ $subcategory->id }}"
                                                data-url="{{ route('admin.subcategories.destroy', $subcategory->id) }}">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>

                                {{-- ============================
                                     EDIT MODAL
                                     ============================ --}}
                                <div class="modal fade" id="editSubcategory{{ $subcategory->id }}" tabindex="-1">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">

                                            <div class="modal-header" style="border-bottom:1px solid #e2ece9;">
                                                <h5 class="modal-title fw-bold" style="color:#0d2b24; font-size:15px;">
                                                    Edit Subcategory
                                                </h5>
                                                <button type="button" class="btn-close"
                                                    data-bs-dismiss="modal"></button>
                                            </div>

                                            <form action="{{ route('admin.subcategories.update', $subcategory->id) }}"
                                                method="POST" enctype="multipart/form-data">
                                                @csrf
                                                @method('PUT')

                                                {{-- CHANGE 1: hidden field so we know which modal to reopen --}}
                                                <input type="hidden" name="_edit_id" value="{{ $subcategory->id }}">

                                                <div class="modal-body">
                                                    <div class="row g-3">

                                                        {{-- CATEGORY --}}
                                                        <div class="col-md-6">
                                                            <label class="form-label"
                                                                style="font-size:13px; font-weight:500;">
                                                                Category <span class="text-danger">*</span>
                                                            </label>
                                                            {{-- CHANGE 3: old() keeps the user's selected value after error --}}
                                                            <select name="category_id"
                                                                class="form-control {{ $errors->has('category_id') && old('_edit_id') == $subcategory->id ? 'is-invalid' : '' }}"
                                                                required>
                                                                <option value="">-- Select Category --</option>
                                                                @foreach ($categories as $category)
                                                                    <option value="{{ $category->id }}"
                                                                        {{ old('category_id', $subcategory->category_id) == $category->id ? 'selected' : '' }}>
                                                                        {{ $category->name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                            {{-- CHANGE 2: show error only for THIS subcategory's modal --}}
                                                            @if ($errors->has('category_id') && old('_edit_id') == $subcategory->id)
                                                                <span class="text-danger" style="font-size:12px;">
                                                                    {{ $errors->first('category_id') }}
                                                                </span>
                                                            @endif
                                                        </div>

                                                        {{-- STATUS --}}
                                                        <div class="col-md-6">
                                                            <label class="form-label"
                                                                style="font-size:13px; font-weight:500;">
                                                                Status <span class="text-danger">*</span>
                                                            </label>
                                                            <select name="status"
                                                                class="form-control {{ $errors->has('status') && old('_edit_id') == $subcategory->id ? 'is-invalid' : '' }}"
                                                                required>
                                                                <option value="active"
                                                                    {{ old('status', $subcategory->status) === 'active' ? 'selected' : '' }}>
                                                                    Active
                                                                </option>
                                                                <option value="inactive"
                                                                    {{ old('status', $subcategory->status) === 'inactive' ? 'selected' : '' }}>
                                                                    Inactive
                                                                </option>
                                                            </select>
                                                            @if ($errors->has('status') && old('_edit_id') == $subcategory->id)
                                                                <span class="text-danger" style="font-size:12px;">
                                                                    {{ $errors->first('status') }}
                                                                </span>
                                                            @endif
                                                        </div>

                                                        {{-- NAME --}}
                                                        <div class="col-md-6">
                                                            <label class="form-label"
                                                                style="font-size:13px; font-weight:500;">
                                                                Subcategory Name <span class="text-danger">*</span>
                                                            </label>
                                                            <input type="text" name="name"
                                                                class="form-control {{ $errors->has('name') && old('_edit_id') == $subcategory->id ? 'is-invalid' : '' }}"
                                                                value="{{ old('name', $subcategory->name) }}" required>
                                                            @if ($errors->has('name') && old('_edit_id') == $subcategory->id)
                                                                <span class="text-danger" style="font-size:12px;">
                                                                    {{ $errors->first('name') }}
                                                                </span>
                                                            @endif
                                                        </div>

                                                        {{-- DESCRIPTION --}}
                                                        <div class="col-md-6">
                                                            <label class="form-label"
                                                                style="font-size:13px; font-weight:500;">
                                                                Description
                                                            </label>
                                                            <input type="text" name="description"
                                                                class="form-control {{ $errors->has('description') && old('_edit_id') == $subcategory->id ? 'is-invalid' : '' }}"
                                                                value="{{ old('description', $subcategory->description) }}">
                                                            @if ($errors->has('description') && old('_edit_id') == $subcategory->id)
                                                                <span class="text-danger" style="font-size:12px;">
                                                                    {{ $errors->first('description') }}
                                                                </span>
                                                            @endif
                                                        </div>

                                                        {{-- IMAGE --}}
                                                        <div class="col-md-12">
                                                            <label class="form-label"
                                                                style="font-size:13px; font-weight:500;">
                                                                Image
                                                            </label>

                                                            @if ($subcategory->image)
                                                                <div class="mb-2">
                                                                    <img src="{{ Str::startsWith($subcategory->image, 'http') ? $subcategory->image : asset('storage/' . $subcategory->image) }}"
                                                                        alt="{{ $subcategory->name }}"
                                                                        style="width:40px; height:40px; object-fit:cover; border-radius:8px;">
                                                                </div>
                                                            @else
                                                                <img id="editPreview{{ $subcategory->id }}"
                                                                    src="#" alt="Preview"
                                                                    style="display:none; margin-bottom:8px; height:60px; border-radius:8px;">
                                                            @endif

                                                            <input type="file" name="image"
                                                                class="form-control image-input"
                                                                accept="image/jpg,image/jpeg,image/png,image/webp"
                                                                data-preview="editPreview{{ $subcategory->id }}">

                                                            @if ($errors->has('image') && old('_edit_id') == $subcategory->id)
                                                                <span class="text-danger" style="font-size:12px;">
                                                                    {{ $errors->first('image') }}
                                                                </span>
                                                            @endif
                                                        </div>

                                                    </div>
                                                </div>

                                                <div class="modal-footer" style="border-top:1px solid #e2ece9;">
                                                    <button type="button" class="btn btn-sm btn-secondary"
                                                        data-bs-dismiss="modal">Cancel</button>
                                                    <button type="submit" class="btn btn-sm px-4"
                                                        style="background:#1D9E75; color:#fff;">
                                                        Update Subcategory
                                                    </button>
                                                </div>

                                            </form>
                                        </div>
                                    </div>
                                </div>
                                {{-- END EDIT MODAL --}}

                            @empty
                                <tr id="emptyRow">
                                    <td colspan="7" class="text-center py-5">
                                        <i class="bi bi-diagram-3 fs-1 text-muted"></i>
                                        <p class="text-muted mt-2">No subcategories found.</p>
                                        <button class="btn btn-sm px-4"
                                            style="background:#1D9E75; color:#fff; border-radius:10px;"
                                            data-bs-toggle="modal" data-bs-target="#addSubcategoryModal">
                                            + Add First Subcategory
                                        </button>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

    {{-- ADD SUBCATEGORY MODAL --}}
    <div class="modal fade" id="addSubcategoryModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header" style="border-bottom:1px solid #e2ece9;">
                    <h5 class="modal-title fw-bold" style="color:#0d2b24; font-size:15px;">Add Subcategory</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('admin.subcategories.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="row g-3">

                            <div class="col-md-6">
                                <label class="form-label" style="font-size:13px; font-weight:500;">
                                    Category <span class="text-danger">*</span>
                                </label>
                                <select name="category_id"
                                    class="form-control {{ $errors->has('category_id') && !old('_edit_id') ? 'is-invalid' : '' }}"
                                    required>
                                    <option value="">-- Select Category --</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}"
                                            {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @if ($errors->has('category_id') && !old('_edit_id'))
                                    <span class="text-danger"
                                        style="font-size:12px;">{{ $errors->first('category_id') }}</span>
                                @endif
                            </div>

                            <div class="col-md-6">
                                <label class="form-label" style="font-size:13px; font-weight:500;">
                                    Status <span class="text-danger">*</span>
                                </label>
                                <select name="status"
                                    class="form-control {{ $errors->has('status') && !old('_edit_id') ? 'is-invalid' : '' }}"
                                    required>
                                    <option value="">-- Select --</option>
                                    <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active
                                    </option>
                                    <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive
                                    </option>
                                </select>
                                @if ($errors->has('status') && !old('_edit_id'))
                                    <span class="text-danger"
                                        style="font-size:12px;">{{ $errors->first('status') }}</span>
                                @endif
                            </div>

                            <div class="col-md-6">
                                <label class="form-label" style="font-size:13px; font-weight:500;">
                                    Subcategory Name <span class="text-danger">*</span>
                                </label>
                                <input type="text" name="name"
                                    class="form-control {{ $errors->has('name') && !old('_edit_id') ? 'is-invalid' : '' }}"
                                    placeholder="e.g. Painkillers" value="{{ old('name') }}" required>
                                @if ($errors->has('name') && !old('_edit_id'))
                                    <span class="text-danger" style="font-size:12px;">{{ $errors->first('name') }}</span>
                                @endif
                            </div>

                            <div class="col-md-6">
                                <label class="form-label" style="font-size:13px; font-weight:500;">Description</label>
                                <input type="text" name="description"
                                    class="form-control {{ $errors->has('description') && !old('_edit_id') ? 'is-invalid' : '' }}"
                                    placeholder="Optional short description" value="{{ old('description') }}">
                                @if ($errors->has('description') && !old('_edit_id'))
                                    <span class="text-danger"
                                        style="font-size:12px;">{{ $errors->first('description') }}</span>
                                @endif
                            </div>

                            <div class="col-md-12">
                                <label class="form-label" style="font-size:13px; font-weight:500;">Image</label>
                                <input type="file" name="image" class="form-control image-input"
                                    accept="image/jpg,image/jpeg,image/png,image/webp" data-preview="addPreview">
                                @if ($errors->has('image') && !old('_edit_id'))
                                    <span class="text-danger"
                                        style="font-size:12px;">{{ $errors->first('image') }}</span>
                                @endif
                                <img id="addPreview" src="#" alt="Preview"
                                    style="display:none; margin-top:8px; width:60px; height:60px;
                                           object-fit:cover; border-radius:8px;">
                            </div>

                        </div>
                    </div>
                    <div class="modal-footer" style="border-top:1px solid #e2ece9;">
                        <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-sm px-4" style="background:#1D9E75; color:#fff;">
                            Add Subcategory
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {

            // =========================================
            // SEARCH FUNCTION
            // =========================================

            $('#searchInput').on('keyup', function() {

                // Get search text
                var search = $(this).val().toLowerCase();

                // Loop all rows
                $('.subcategory-row').each(function() {

                    // Get row name
                    var name = $(this).data('name');

                    // Check search match
                    if (name.includes(search)) {

                        // Show row
                        $(this).show();

                    } else {

                        // Hide row
                        $(this).hide();
                    }
                });
            });



            // =========================================
            // RESET BUTTON
            // =========================================

            $('#resetBtn').click(function() {

                // Empty search box
                $('#searchInput').val('');

                // Show all rows
                $('.subcategory-row').show();
            });



            // =========================================
            // DELETE USING AJAX
            // =========================================

            $('.delete-btn').click(function() {

                // Get delete URL
                var url = $(this).data('url');

                // Current row
                var row = $(this).closest('tr');


                // Confirm delete
                if (confirm('Are you sure?')) {

                    $.ajax({

                        url: url,

                        type: 'POST',

                        data: {

                            _method: 'DELETE',

                            _token: '{{ csrf_token() }}'
                        },

                        success: function() {

                            // Remove row
                            row.remove();

                            alert('Deleted Successfully');
                        },

                        error: function() {

                            alert('Delete Failed');
                        }

                    });
                }
            });



            // =========================================
            // IMAGE PREVIEW
            // =========================================

            $('.image-input').change(function() {

                // Selected file
                var file = this.files[0];

                // Preview image id
                var preview = $(this).data('preview');


                // Check file selected
                if (file) {

                    // Read image
                    var reader = new FileReader();

                    reader.onload = function(e) {

                        // Show image preview
                        $('#' + preview)
                            .attr('src', e.target.result)
                            .show();
                    };

                    reader.readAsDataURL(file);
                }
            });

        });
    </script>

    {{-- REOPEN EDIT MODAL AFTER VALIDATION ERROR --}}
    <script>
        window.onload = function() {

            @if ($errors->any())

                // Get old edit modal id
                var editId = "{{ old('_edit_id') }}";

                // Check edit modal exists
                if (editId) {

                    // Create modal id
                    var modalId = 'editSubcategory' + editId;

                    // Find modal
                    var modalElement =
                        document.getElementById(modalId);

                    // Open modal
                    if (modalElement) {

                        setTimeout(function() {

                            var modal =
                                new bootstrap.Modal(modalElement);

                            modal.show();

                        }, 300);
                    }

                } else {

                    // OPEN ADD MODAL IF ADD FORM HAS ERROR
                    var addModal =
                        document.getElementById('addSubcategoryModal');

                    if (addModal) {

                        setTimeout(function() {

                            var modal =
                                new bootstrap.Modal(addModal);

                            modal.show();

                        }, 300);
                    }
                }
            @endif

        };
    </script>

@endsection
