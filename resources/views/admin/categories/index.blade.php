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
        {{-- Validation error --}}
        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif


        {{-- PAGE HEADER --}}
        <div class="d-flex align-items-center justify-content-between mb-4">

            <div>
                <h5 class="fw-bold mb-0" style="color:#0d2b24;">
                    Manage Categories
                </h5>

                <p class="text-muted mb-0" style="font-size:13px;">
                    Total: {{ $categories->count() }} categories
                </p>
            </div>

            <button class="btn btn-sm px-4" style="background:#1D9E75; color:#fff; border-radius:10px;"
                data-bs-toggle="modal" data-bs-target="#addCategoryModal">

                + Add Category

            </button>

        </div>

        {{-- STAT CARDS --}}
        <div class="row g-3 mb-4">

            {{-- TOTAL --}}
            <div class="col-md-4 col-6">
                <div class="p-3 rounded-3" style="background:#e1f5ee; border:1px solid #9FE1CB;">

                    <p class="mb-1 text-muted" style="font-size:12px;">
                        Total Categories
                    </p>

                    <h4 class="fw-bold mb-0" style="color:#085041;">
                        {{ $categories->count() }}
                    </h4>

                </div>
            </div>

            {{-- ACTIVE --}}
            <div class="col-md-4 col-6">
                <div class="p-3 rounded-3" style="background:#e1f5ee; border:1px solid #9FE1CB;">

                    <p class="mb-1 text-muted" style="font-size:12px;">
                        Active
                    </p>

                    <h4 class="fw-bold mb-0" style="color:#085041;">
                        {{ $categories->where('status', 'active')->count() }}
                    </h4>

                </div>
            </div>

            {{-- INACTIVE --}}
            <div class="col-md-4 col-6">
                <div class="p-3 rounded-3" style="background:#fcebeb; border:1px solid #F7C1C1;">

                    <p class="mb-1 text-muted" style="font-size:12px;">
                        Inactive
                    </p>

                    <h4 class="fw-bold mb-0" style="color:#A32D2D;">
                        {{ $categories->where('status', 'inactive')->count() }}
                    </h4>

                </div>
            </div>

        </div>

        {{-- SEARCH BAR --}}
        <div class="card border-0 shadow-sm mb-3">

            <div class="card-body py-2">

                <div class="row g-2 align-items-center">

                    <div class="col-md-4">
                        <input type="text" id="searchInput" class="form-control form-control-sm"
                            placeholder="Search category name...">

                    </div>

                    <div class="col-md-3">
                        <select id="filterStatus" class="form-control form-control-sm">

                            <option value="">All Status</option>
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>

                        </select>
                    </div>

                    <div class="col-md-2">
                        <button onclick="resetFilters()" class="btn btn-sm btn-outline-secondary w-100">

                            Reset

                        </button>
                    </div>

                </div>

            </div>

        </div>

        {{-- TABLE --}}
        <div class="card border-0 shadow-sm">

            <div class="card-body p-0">

                <div class="table-responsive">

                    <table class="table table-hover mb-0" style="font-size:13px;">

                        <thead style="background:#f0f4f3;">

                            <tr>

                                <th class="px-3 py-3" style="font-size:11px; color:#6b9e93;">
                                    #
                                </th>

                                <th class="py-3" style="font-size:11px; color:#6b9e93;">
                                    Image
                                </th>

                                <th class="py-3" style="font-size:11px; color:#6b9e93;">
                                    Name
                                </th>

                                <th class="py-3" style="font-size:11px; color:#6b9e93;">
                                    Description
                                </th>

                                <th class="py-3" style="font-size:11px; color:#6b9e93;">
                                    Subcategories
                                </th>

                                <th class="py-3" style="font-size:11px; color:#6b9e93;">
                                    Status
                                </th>

                                <th class="py-3" style="font-size:11px; color:#6b9e93;">
                                    Actions
                                </th>

                            </tr>

                        </thead>

                        <tbody>

                            @forelse($categories as $index => $category)
                                <tr class="category-row" data-name="{{ strtolower($category->name) }}"
                                    data-status="{{ $category->status }}">

                                    {{-- ID --}}
                                    <td class="px-3 py-3" style="color:#6b9e93;">
                                        {{ $index + 1 }}
                                    </td>

                                    {{-- IMAGE --}}
                                    <td class="py-3">

                                        @if ($category->image)
                                            <img src="{{ asset('storage/' . $category->image) }}" alt="Image"
                                                style="width:40px;
                                                       height:40px;
                                                       object-fit:cover;
                                                       border-radius:8px;">
                                        @else
                                            <div
                                                style="width:40px;
                                                        height:40px;
                                                        background:#e1f5ee;
                                                        border-radius:8px;
                                                        display:flex;
                                                        align-items:center;
                                                        justify-content:center;">

                                                <i class="bi bi-image text-muted"></i>

                                            </div>
                                        @endif

                                    </td>

                                    {{-- NAME --}}
                                    <td class="py-3">

                                        <p class="mb-0 fw-semibold" style="color:#0d2b24;">

                                            {{ $category->name }}

                                        </p>

                                    </td>

                                    {{-- DESCRIPTION --}}
                                    <td class="py-3" style="color:#0d2b24;">

                                        {{ Str::limit($category->description, 40) ?? '—' }}

                                    </td>

                                    {{-- SUBCATEGORY COUNT --}}
                                    <td class="py-3">

                                        <span class="badge rounded-pill px-2 py-1"
                                            style="background:#e1f5ee;
                                                   color:#085041;
                                                   font-size:11px;">

                                            {{ $category->subcategories_count }} subcategories

                                        </span>

                                    </td>

                                    {{-- STATUS --}}
                                    <td class="py-3">

                                        @if ($category->status === 'active')
                                            <span class="badge rounded-pill px-2 py-1"
                                                style="background:#e1f5ee;
                                                       color:#085041;
                                                       font-size:11px;">

                                                Active

                                            </span>
                                        @else
                                            <span class="badge rounded-pill px-2 py-1"
                                                style="background:#fcebeb;
                                                       color:#A32D2D;
                                                       font-size:11px;">

                                                Inactive

                                            </span>
                                        @endif

                                    </td>

                                    {{-- ACTIONS --}}
                                    <td class="py-3">

                                        <div class="d-flex gap-2">

                                            {{-- EDIT --}}
                                            <button class="btn btn-sm px-2 py-1"
                                                style="background:#e1f5ee;
                                                       color:#085041;
                                                       border-radius:8px;
                                                       font-size:12px;"
                                                data-bs-toggle="modal" data-bs-target="#editCategory{{ $category->id }}">

                                                <i class="bi bi-pencil"></i>

                                            </button>

                                            {{-- DELETE --}}
                                            <form action="{{ route('admin.categories.destroy', $category->id) }}"
                                                method="POST" onsubmit="return confirm('Delete this category?')">

                                                @csrf
                                                @method('DELETE')

                                                <button type="submit" class="btn btn-sm px-2 py-1"
                                                    style="background:#fcebeb;
                                                           color:#A32D2D;
                                                           border-radius:8px;
                                                           font-size:12px;">

                                                    <i class="bi bi-trash"></i>

                                                </button>

                                            </form>

                                        </div>

                                    </td>

                                </tr>

                                {{-- EDIT MODAL --}}
                                <div class="modal fade" id="editCategory{{ $category->id }}" tabindex="-1">

                                    <div class="modal-dialog modal-lg">

                                        <div class="modal-content">

                                            <div class="modal-header" style="border-bottom:1px solid #e2ece9;">

                                                <h5 class="modal-title fw-bold" style="color:#0d2b24; font-size:15px;">

                                                    Edit Category

                                                </h5>

                                                <button type="button" class="btn-close"
                                                    data-bs-dismiss="modal"></button>

                                            </div>

                                            <form action="{{ route('admin.categories.update', $category->id) }}"
                                                method="POST" enctype="multipart/form-data">

                                                @csrf
                                                @method('PUT')

                                                <div class="modal-body">

                                                    <div class="row g-3">

                                                        {{-- NAME --}}
                                                        <div class="col-md-6">

                                                            <label class="form-label"
                                                                style="font-size:13px; font-weight:500;">

                                                                Category Name

                                                            </label>

                                                            <input type="text" name="name" class="form-control"
                                                                value="{{ $category->name }}" required>

                                                        </div>

                                                        {{-- STATUS --}}
                                                        <div class="col-md-6">

                                                            <label class="form-label"
                                                                style="font-size:13px; font-weight:500;">

                                                                Status

                                                            </label>

                                                            <select name="status" class="form-control" required>

                                                                <option value="active"
                                                                    {{ $category->status == 'active' ? 'selected' : '' }}>

                                                                    Active

                                                                </option>

                                                                <option value="inactive"
                                                                    {{ $category->status == 'inactive' ? 'selected' : '' }}>

                                                                    Inactive

                                                                </option>

                                                            </select>

                                                        </div>

                                                        {{-- IMAGE --}}
                                                        <div class="col-md-12">

                                                            <label class="form-label"
                                                                style="font-size:13px; font-weight:500;">

                                                                Image

                                                            </label>

                                                            @if ($category->image)
                                                                <div class="mb-3">

                                                                    <img src="{{ asset('storage/' . $category->image) }}"
                                                                        style="width:80px;
                                                                               height:80px;
                                                                               object-fit:cover;
                                                                               border-radius:10px;">

                                                                </div>
                                                            @endif

                                                            <input type="file" name="image" class="form-control"
                                                                accept="image/jpg,image/jpeg,image/png,image/webp">

                                                        </div>

                                                        {{-- DESCRIPTION --}}
                                                        <div class="col-md-12">

                                                            <label class="form-label"
                                                                style="font-size:13px; font-weight:500;">

                                                                Description

                                                            </label>

                                                            <textarea name="description" class="form-control" rows="3">{{ $category->description }}</textarea>

                                                        </div>

                                                    </div>

                                                </div>

                                                <div class="modal-footer" style="border-top:1px solid #e2ece9;">

                                                    <button type="button" class="btn btn-sm btn-secondary"
                                                        data-bs-dismiss="modal">

                                                        Cancel

                                                    </button>

                                                    <button type="submit" class="btn btn-sm px-4"
                                                        style="background:#1D9E75; color:#fff;">

                                                        Update Category

                                                    </button>

                                                </div>

                                            </form>

                                        </div>

                                    </div>

                                </div>

                            @empty

                                <tr>

                                    <td colspan="7" class="text-center py-5">

                                        <i class="bi bi-tags fs-1 text-muted"></i>

                                        <p class="text-muted mt-2">
                                            No categories found.
                                        </p>

                                    </td>

                                </tr>
                            @endforelse

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </div>

    {{-- ADD CATEGORY MODAL --}}
    <div class="modal fade" id="addCategoryModal" tabindex="-1">

        <div class="modal-dialog modal-lg">

            <div class="modal-content">

                <div class="modal-header" style="border-bottom:1px solid #e2ece9;">

                    <h5 class="modal-title fw-bold" style="color:#0d2b24; font-size:15px;">

                        Add Category

                    </h5>

                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>

                </div>

                <form action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data">

                    @csrf

                    <div class="modal-body">

                        <div class="row g-3">

                            {{-- NAME --}}
                            <div class="col-md-6">

                                <label class="form-label" style="font-size:13px; font-weight:500;">

                                    Category Name

                                </label>

                                <input type="text" name="name" class="form-control" required>

                            </div>

                            {{-- STATUS --}}
                            <div class="col-md-6">

                                <label class="form-label" style="font-size:13px; font-weight:500;">

                                    Status

                                </label>

                                <select name="status" class="form-control" required>

                                    <option value="active">Active</option>
                                    <option value="inactive">Inactive</option>

                                </select>

                            </div>

                            {{-- IMAGE --}}
                            <div class="col-md-12">

                                <label class="form-label" style="font-size:13px; font-weight:500;">

                                    Image

                                </label>

                                <input type="file" name="image" class="form-control"
                                    accept="image/jpg,image/jpeg,image/png,image/webp">

                            </div>

                            {{-- DESCRIPTION --}}
                            <div class="col-md-12">

                                <label class="form-label" style="font-size:13px; font-weight:500;">

                                    Description

                                </label>

                                <textarea name="description" class="form-control" rows="3"></textarea>

                            </div>

                        </div>

                    </div>

                    <div class="modal-footer" style="border-top:1px solid #e2ece9;">

                        <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">

                            Cancel

                        </button>

                        <button type="submit" class="btn btn-sm px-4" style="background:#1D9E75; color:#fff;">

                            Add Category

                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>

    {{-- SEARCH SCRIPT --}}
    <script>
        document.getElementById('searchInput')
            .addEventListener('input', filterTable);

        document.getElementById('filterStatus')
            .addEventListener('change', filterTable);

        function filterTable() {

            const search = document.getElementById('searchInput')
                .value.toLowerCase();

            const status = document.getElementById('filterStatus')
                .value.toLowerCase();

            document.querySelectorAll('.category-row')
                .forEach(row => {

                    const name = row.dataset.name;
                    const rowStatus = row.dataset.status;

                    const matchSearch = name.includes(search);

                    const matchStatus = status === '' ||
                        rowStatus === status;

                    row.style.display =
                        (matchSearch && matchStatus) ?
                        '' :
                        'none';
                });
        }

        function resetFilters() {

            document.getElementById('searchInput').value = '';

            document.getElementById('filterStatus').value = '';

            filterTable();
        }
    </script>
@endsection
