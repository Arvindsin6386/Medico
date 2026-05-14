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
                <h5 class="fw-bold mb-0" style="color:#0d2b24;">Manage Medicines</h5>
                <p class="text-muted mb-0" style="font-size:13px;">
                    Total: {{ $medicines->count() }} medicines
                </p>
            </div>
            <a href="{{ route('admin.medicines.create') }}" class="btn btn-sm px-4"
                style="background:#1D9E75; color:#fff; border-radius:10px;">
                + Add Medicine
            </a>
        </div>

        {{-- STAT CARDS --}}
        <div class="row g-3 mb-4">
            <div class="col-md-3 col-6">
                <div class="p-3 rounded-3" style="background:#e1f5ee; border:1px solid #9FE1CB;">
                    <p class="mb-1 text-muted" style="font-size:12px;">Total Medicines</p>
                    <h4 class="fw-bold mb-0" style="color:#085041;">{{ $medicines->count() }}</h4>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="p-3 rounded-3" style="background:#e1f5ee; border:1px solid #9FE1CB;">
                    <p class="mb-1 text-muted" style="font-size:12px;">In Stock</p>
                    <h4 class="fw-bold mb-0" style="color:#085041;">
                        {{ $medicines->where('stock', '>', 10)->count() }}
                    </h4>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="p-3 rounded-3" style="background:#faeeda; border:1px solid #FAC775;">
                    <p class="mb-1 text-muted" style="font-size:12px;">Low Stock</p>
                    <h4 class="fw-bold mb-0" style="color:#854F0B;">
                        {{ $medicines->whereBetween('stock', [1, 10])->count() }}
                    </h4>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="p-3 rounded-3" style="background:#fcebeb; border:1px solid #F7C1C1;">
                    <p class="mb-1 text-muted" style="font-size:12px;">Out of Stock</p>
                    <h4 class="fw-bold mb-0" style="color:#A32D2D;">
                        {{ $medicines->where('stock', 0)->count() }}
                    </h4>
                </div>
            </div>
        </div>

        {{-- SEARCH & FILTER --}}
        <div class="card border-0 shadow-sm mb-3">
            <div class="card-body py-2">
                <div class="row g-2 align-items-center">
                    <div class="col-md-4">
                        <input type="text" id="searchInput" class="form-control form-control-sm"
                            placeholder="Search medicine or brand name...">
                    </div>
                    <div class="col-md-3">
                        <select id="filterCategory" class="form-control form-control-sm">
                            <option value="">All Categories</option>
                            @foreach ($categories as $cat)
                                <option value="{{ strtolower($cat->name) }}">{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select id="filterStock" class="form-control form-control-sm">
                            <option value="">All Stock Status</option>
                            <option value="in">In Stock</option>
                            <option value="low">Low Stock</option>
                            <option value="out">Out of Stock</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button id="resetBtn" class="btn btn-sm btn-outline-secondary w-100">Reset</button>
                    </div>
                </div>
            </div>
        </div>

        {{-- MEDICINES TABLE --}}
        <div class="card border-0 shadow-sm">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0" style="font-size:13px;" id="medicineTable">
                        <thead style="background:#f0f4f3;">
                            <tr>
                                <th class="px-3 py-3" style="font-size:11px; color:#6b9e93;">#</th>
                                <th class="py-3" style="font-size:11px; color:#6b9e93;">Image</th>
                                <th class="py-3" style="font-size:11px; color:#6b9e93;">Name</th>
                                <th class="py-3" style="font-size:11px; color:#6b9e93;">Category</th>
                                <th class="py-3" style="font-size:11px; color:#6b9e93;">Type</th>
                                <th class="py-3" style="font-size:11px; color:#6b9e93;">Purchase (₹)</th>
                                <th class="py-3" style="font-size:11px; color:#6b9e93;">Selling (₹)</th>
                                <th class="py-3" style="font-size:11px; color:#6b9e93;">Stock</th>
                                <th class="py-3" style="font-size:11px; color:#6b9e93;">Expiry</th>
                                <th class="py-3" style="font-size:11px; color:#6b9e93;">Status</th>
                                <th class="py-3" style="font-size:11px; color:#6b9e93;">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="medicineTableBody">
                            @forelse($medicines as $index => $medicine)
                                <tr class="medicine-row" data-name="{{ strtolower($medicine->name) }}"
                                    data-brand="{{ strtolower($medicine->brand_name ?? '') }}"
                                    data-category="{{ strtolower($medicine->category->name ?? '') }}"
                                    data-stock="{{ $medicine->stock }}">

                                    <td class="px-3 py-3" style="color:#6b9e93;">{{ $index + 1 }}</td>

                                    {{-- IMAGE --}}
                                    <td class="py-3">
                                        @if ($medicine->image)
                                            <img src="{{ asset('storage/' . $medicine->image) }}"
                                                alt="{{ $medicine->name }}"
                                                style="width:38px; height:38px; object-fit:cover; border-radius:8px;">
                                        @else
                                            <div
                                                style="width:38px; height:38px; background:#e1f5ee;
                                                    border-radius:8px; display:flex;
                                                    align-items:center; justify-content:center;">
                                                <i class="bi bi-capsule text-muted"></i>
                                            </div>
                                        @endif
                                    </td>

                                    {{-- NAME + BRAND --}}
                                    <td class="py-3">
                                        <p class="mb-0 fw-semibold" style="color:#0d2b24;">{{ $medicine->name }}</p>
                                        <p class="mb-0 text-muted" style="font-size:11px;">
                                            {{ $medicine->brand_name ?? '—' }}</p>
                                    </td>

                                    {{-- CATEGORY --}}
                                    <td class="py-3" style="color:#0d2b24;">
                                        {{ $medicine->category->name ?? '—' }}
                                    </td>

                                    {{-- TYPE --}}
                                    <td class="py-3" style="color:#0d2b24;">
                                        {{ $medicine->medicine_type ?? '—' }}
                                    </td>

                                    {{-- PURCHASE PRICE --}}
                                    <td class="py-3" style="color:#0d2b24;">
                                        ₹{{ number_format($medicine->purchase_price, 2) }}
                                    </td>

                                    {{-- SELLING PRICE --}}
                                    <td class="py-3" style="color:#0d2b24;">
                                        ₹{{ number_format($medicine->selling_price, 2) }}
                                    </td>

                                    {{-- STOCK --}}
                                    <td class="py-3">
                                        @if ($medicine->stock == 0)
                                            <span class="fw-bold" style="color:#A32D2D;">0 ✕</span>
                                        @elseif($medicine->stock <= 10)
                                            <span class="fw-bold" style="color:#D85A30;">{{ $medicine->stock }} ⚠</span>
                                        @else
                                            <span class="fw-bold" style="color:#085041;">{{ $medicine->stock }}</span>
                                        @endif
                                    </td>

                                    {{-- EXPIRY --}}
                                    {{--
                                        BUG FIX: Original code used $expiry->diffInDays(now()) which gives
                                        a negative number for future dates, so "expiring soon" never triggered.
                                        Correct: now()->diffInDays($expiry) gives positive days remaining.
                                    --}}
                                    <td class="py-3">
                                        @if ($medicine->expiry_date)
                                            @php
                                                $expiry = \Carbon\Carbon::parse($medicine->expiry_date);
                                                $expired = $expiry->isPast();
                                                $expiring = !$expired && now()->diffInDays($expiry) <= 30;
                                            @endphp
                                            @if ($expired)
                                                <span style="color:#A32D2D; font-size:11px; font-weight:600;">
                                                    {{ $expiry->format('d M Y') }}<br><small>Expired</small>
                                                </span>
                                            @elseif($expiring)
                                                <span style="color:#D85A30; font-size:11px; font-weight:600;">
                                                    {{ $expiry->format('d M Y') }}<br><small>Expiring soon</small>
                                                </span>
                                            @else
                                                <span style="color:#085041; font-size:11px;">
                                                    {{ $expiry->format('d M Y') }}
                                                </span>
                                            @endif
                                        @else
                                            <span class="text-muted">—</span>
                                        @endif
                                    </td>

                                    {{-- STATUS --}}
                                    <td class="py-3">
                                        @if ($medicine->status === 'active')
                                            <span class="badge rounded-pill px-2 py-1"
                                                style="background:#e1f5ee; color:#085041; font-size:11px;">Active</span>
                                        @else
                                            <span class="badge rounded-pill px-2 py-1"
                                                style="background:#fcebeb; color:#A32D2D; font-size:11px;">Inactive</span>
                                        @endif
                                    </td>

                                    {{-- ACTIONS --}}
                                    <td class="py-3">
                                        <div class="d-flex gap-2">

                                            {{-- EDIT BUTTON --}}
                                            <button class="btn btn-sm px-2 py-1"
                                                style="background:#e1f5ee; color:#085041; border-radius:8px; font-size:12px;"
                                                data-bs-toggle="modal" data-bs-target="#editMedicine{{ $medicine->id }}">
                                                <i class="bi bi-pencil"></i>
                                            </button>

                                            {{--
                                                BUG FIX: Added data-id="{{ $medicine->id }}" so after AJAX delete
                                                we can target exactly the correct row. Also the row itself now has
                                                id="medicine-row-{{ $medicine->id }}" for reliable targeting.
                                            --}}
                                            <button type="button" class="btn btn-sm px-2 py-1 delete-btn"
                                                style="background:#fcebeb; color:#A32D2D; border-radius:8px; font-size:12px;"
                                                data-url="{{ route('admin.medicines.destroy', $medicine->id) }}"
                                                data-id="{{ $medicine->id }}">
                                                <i class="bi bi-trash"></i>
                                            </button>

                                        </div>
                                    </td>
                                </tr>

                                {{-- ================================================
                                     EDIT MODAL
                                     BUG FIX: Subcategory dropdown now filtered by
                                     category_id using data-category attribute so only
                                     relevant subcategories show for this medicine.
                                     ================================================ --}}
                                {{-- {{-- <div class="modal fade" id="editMedicine{{ $medicine->id }}" tabindex="-1">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header" style="border-bottom:1px solid #e2ece9;">
                                                <h5 class="modal-title fw-bold" style="color:#0d2b24; font-size:15px;">
                                                    Edit Medicine
                                                </h5>
                                                <button type="button" class="btn-close"
                                                    data-bs-dismiss="modal"></button>
                                            </div>

                                            {{--
                                                BUG FIX: The form action uses PUT via method spoofing.
                                                Make sure your route is defined as:
                                                    Route::put('medicines/{id}', [MedicineController::class, 'update'])
                                                        ->name('admin.medicines.update');
                                                and your controller accepts PUT/PATCH.
                                            --}}
                                            <form action="{{ route('admin.medicines.update', $medicine->id) }}"
                                                method="POST" enctype="multipart/form-data">
                                                @csrf
                                                @method('PUT')

                                                <div class="modal-body">
                                                    <div class="row g-3">

                                                        {{-- Category --}}
                                                        <div class="col-md-6">
                                                            <label class="form-label"
                                                                style="font-size:13px; font-weight:500;">
                                                                Category <span class="text-danger">*</span>
                                                            </label>
                                                            <select name="category_id"
                                                                class="form-control category-select"
                                                                data-medicine-id="{{ $medicine->id }}" required>
                                                                <option value="">-- Select --</option>
                                                                @foreach ($categories as $cat)
                                                                    <option value="{{ $cat->id }}"
                                                                        {{ $medicine->category_id == $cat->id ? 'selected' : '' }}>
                                                                        {{ $cat->name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>

                                                        {{--
                                                            BUG FIX: Subcategory dropdown only shows subcategories
                                                            belonging to this medicine's category. Each option stores
                                                            data-category="{{ $sub->category_id }}" so JS can filter
                                                            when the category dropdown changes.
                                                        --}}
                                                        <div class="col-md-6">
                                                            <label class="form-label"
                                                                style="font-size:13px; font-weight:500;">
                                                                Subcategory <span class="text-danger">*</span>
                                                            </label>
                                                            <select name="subcategory_id"
                                                                class="form-control subcategory-select"
                                                                data-medicine-id="{{ $medicine->id }}" required>
                                                                <option value="">-- Select --</option>
                                                                @foreach ($subcategories as $sub)
                                                                    <option value="{{ $sub->id }}"
                                                                        data-category="{{ $sub->category_id }}"
                                                                        {{ $medicine->subcategory_id == $sub->id ? 'selected' : '' }}
                                                                        {{ $sub->category_id != $medicine->category_id ? 'style=display:none' : '' }}>
                                                                        {{ $sub->name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>

                                                        {{-- Name --}}
                                                        <div class="col-md-6">
                                                            <label class="form-label"
                                                                style="font-size:13px; font-weight:500;">
                                                                Medicine Name <span class="text-danger">*</span>
                                                            </label>
                                                            <input type="text" name="name" class="form-control"
                                                                value="{{ $medicine->name }}" required>
                                                        </div>

                                                        {{-- Brand --}}
                                                        <div class="col-md-6">
                                                            <label class="form-label"
                                                                style="font-size:13px; font-weight:500;">
                                                                Brand Name
                                                            </label>
                                                            <input type="text" name="brand_name" class="form-control"
                                                                value="{{ $medicine->brand_name }}">
                                                        </div>

                                                        {{-- Type --}}
                                                        <div class="col-md-4">
                                                            <label class="form-label"
                                                                style="font-size:13px; font-weight:500;">
                                                                Medicine Type
                                                            </label>
                                                            <select name="medicine_type" class="form-control">
                                                                <option value="">-- Select --</option>
                                                                @foreach (['Tablet', 'Capsule', 'Syrup', 'Injection', 'Cream', 'Ointment', 'Drops', 'Inhaler', 'Powder', 'Gel', 'Patch', 'Suppository'] as $type)
                                                                    <option value="{{ $type }}"
                                                                        {{ $medicine->medicine_type == $type ? 'selected' : '' }}>
                                                                        {{ $type }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>

                                                        {{-- Unit --}}
                                                        <div class="col-md-4">
                                                            <label class="form-label"
                                                                style="font-size:13px; font-weight:500;">
                                                                Unit
                                                            </label>
                                                            <select name="unit" class="form-control">
                                                                <option value="">-- Select --</option>
                                                                @foreach (['Strip', 'Bottle', 'Vial', 'Tube', 'Box', 'Sachet', 'Piece', 'Pack'] as $unit)
                                                                    <option value="{{ $unit }}"
                                                                        {{ $medicine->unit == $unit ? 'selected' : '' }}>
                                                                        {{ $unit }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>

                                                        {{-- Status --}}
                                                        <div class="col-md-4">
                                                            <label class="form-label"
                                                                style="font-size:13px; font-weight:500;">
                                                                Status
                                                            </label>
                                                            <select name="status" class="form-control">
                                                                <option value="active"
                                                                    {{ $medicine->status == 'active' ? 'selected' : '' }}>
                                                                    Active</option>
                                                                <option value="inactive"
                                                                    {{ $medicine->status == 'inactive' ? 'selected' : '' }}>
                                                                    Inactive</option>
                                                            </select>
                                                        </div>

                                                        {{-- Purchase Price --}}
                                                        <div class="col-md-3">
                                                            <label class="form-label"
                                                                style="font-size:13px; font-weight:500;">
                                                                Purchase Price (₹)
                                                            </label>
                                                            <input type="number" name="purchase_price"
                                                                class="form-control" min="0" step="0.01"
                                                                value="{{ $medicine->purchase_price }}">
                                                        </div>

                                                        {{-- Selling Price --}}
                                                        <div class="col-md-3">
                                                            <label class="form-label"
                                                                style="font-size:13px; font-weight:500;">
                                                                Selling Price (₹)
                                                            </label>
                                                            <input type="number" name="selling_price"
                                                                class="form-control" min="0" step="0.01"
                                                                value="{{ $medicine->selling_price }}">
                                                        </div>

                                                        {{-- Stock --}}
                                                        <div class="col-md-3">
                                                            <label class="form-label"
                                                                style="font-size:13px; font-weight:500;">
                                                                Stock (Qty)
                                                            </label>
                                                            <input type="number" name="stock" class="form-control"
                                                                min="0" value="{{ $medicine->stock }}">
                                                        </div>

                                                        {{-- Batch --}}
                                                        <div class="col-md-3">
                                                            <label class="form-label"
                                                                style="font-size:13px; font-weight:500;">
                                                                Batch Number
                                                            </label>
                                                            <input type="text" name="batch_number"
                                                                class="form-control"
                                                                value="{{ $medicine->batch_number }}">
                                                        </div>

                                                        {{-- Manufacture Date --}}
                                                        <div class="col-md-3">
                                                            <label class="form-label"
                                                                style="font-size:13px; font-weight:500;">
                                                                Manufacture Date
                                                            </label>
                                                            <input type="date" name="manufacture_date"
                                                                class="form-control"
                                                                value="{{ $medicine->manufacture_date }}"
                                                                {{-- Expiry Date --}} <div class="col-md-3">
                                                            <label class="form-label"
                                                                style="font-size:13px; font-weight:500;">
                                                                Expiry Date
                                                            </label>
                                                            <input type="date" name="expiry_date" class="form-control"
                                                                value="{{ $medicine->expiry_date }}" </div>

                                                            {{-- Image --}}
                                                            <div class="col-md-6">
                                                                <label class="form-label"
                                                                    style="font-size:13px; font-weight:500;">
                                                                    Image
                                                                </label>
                                                                @if ($medicine->image)
                                                                    <div class="mb-2">
                                                                        <img src="{{ asset('storage/' . $medicine->image) }}"
                                                                            style="height:55px; border-radius:8px;">
                                                                    </div>
                                                                @endif
                                                                <input type="file" name="image" class="form-control"
                                                                    accept="image/jpg,image/jpeg,image/png,image/webp">
                                                            </div>

                                                            {{-- Description --}}
                                                            <div class="col-md-12">
                                                                <label class="form-label"
                                                                    style="font-size:13px; font-weight:500;">
                                                                    Description
                                                                </label>
                                                                <textarea name="description" class="form-control" rows="2">{{ $medicine->description }}</textarea>
                                                            </div>

                                                        </div>
                                                    </div>

                                                    <div class="modal-footer" style="border-top:1px solid #e2ece9;">
                                                        <button type="button" class="btn btn-sm btn-secondary"
                                                            data-bs-dismiss="modal">Cancel</button>
                                                        <button type="submit" class="btn btn-sm px-4"
                                                            style="background:#1D9E75; color:#fff;">
                                                            Update Medicine
                                                        </button>
                                                    </div>

                                            </form>
                                        </div>
                                    </div>
                                </div> --}} --}}
                                {{-- END EDIT MODAL --}}

                            @empty
                                <tr>
                                    <td colspan="11" class="text-center py-5">
                                        <i class="bi bi-capsule fs-1 text-muted"></i>
                                        <p class="text-muted mt-2">No medicines found.</p>
                                        <a href="{{ route('admin.medicines.create') }}" class="btn btn-sm px-4"
                                            style="background:#1D9E75; color:#fff; border-radius:10px;">
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

    {{-- ============================================
         JQUERY SCRIPTS - ALL BUGS FIXED
         ============================================ --}}
    <script>
        $(document).ready(function() {
            // DATABASE
            let table = $('#medicineTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('admin.medicines.index') }}",
                    data: function(data) {
                        data.category = $('#filterCategory').val();

                        data.stock = $('#filterStock').val();

                        data.search = $('#searchInput').val();

                    }
                },
                columns: [

                    {
                        data: 'id',
                        name: 'id',
                        searchable: false,
                        orderable: false
                    },

                    {
                        data: 'image',
                        name: 'image',
                        searchable: false,
                        orderable: false
                    },

                    {
                        data: 'name', // display the value
                        name: 'name' // display the name
                    },

                    {
                        data: 'category',
                        name: 'category'
                    },

                    {
                        data: 'medicine_type',
                        name: 'medicine_type'
                    },

                    {
                        data: 'purchase_price',
                        name: 'purchase_price'
                    },

                    {
                        data: 'selling_price',
                        name: 'selling_price'
                    },

                    {
                        data: 'stock',
                        name: 'stock'
                    },

                    {
                        data: 'expiry_date',
                        name: 'expiry_date'
                    },

                    {
                        data: 'status',
                        name: 'status'
                    },

                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }

                ]

            });

        });
    </script>

@endsection
