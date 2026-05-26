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
        {{-- <div class="card border-0 shadow-sm mb-3">
            <div class="card-body py-2">
                <div class="row g-2 align-items-center">
                    <div class="col-md-4">
                        <input type="text" id="searchInput" class="form-control form-control-sm"
                            placeholder="Search medicine or brand name...">
                    </div> --}}
        <div class="row g-2 align-items-center flex-nowrap">
            <div class="col-md-3">
                <select id="filterCategory" class="form-control form-control-sm">
                    <option value="">All Categories</option>
                    @foreach ($categories as $cat)
                        <option value="{{ strtolower($cat->id) }}">{{ $cat->name }}</option>
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
                <button id="resetBtn" class="btn btn-sm btn-outline-secondary w-100">
                    Reset
                </button>
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
            // list function
            function listFunction() {
                if ($.fn.DataTable.isDataTable('#medicineTable')) {
                    $('#medicineTable').DataTable().destroy();
                }
                let table = $('#medicineTable').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: "{{ route('admin.medicines.data') }}",
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
                            data: 'name',
                            name: 'name'
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

            }

            // On page load
            listFunction();

            // On category change
            $('#filterCategory').change(function() {
                listFunction();
            });

            $('#filterStock').change(function() {
                listFunction();

            });

            $('#searchInput').change(function() {
                listFunction();

            });



        });
    </script>



    <script>
        $(document).on('click', '.deleteBtn', function() {

            let id = $(this).data('id');

            if (!confirm('Are you sure you want to delete this medicine?')) {
                return;
            }

            $.ajax({
                url: '/admin/medicines/' + id,
                type: 'DELETE',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    alert(response.message);
                    $('#medicineTable').DataTable().ajax.reload();
                },
                error: function(xhr) {
                    alert(xhr.responseJSON.message ?? 'Delete failed');
                }
            });

        });
    </script>
@endsection
