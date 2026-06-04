@extends('layouts.app')

@section('content')
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Sora:wght@300;400;500;600;700&family=JetBrains+Mono:wght@400;500&display=swap');

        :root {
            --bg: #f0f4f8;
            --surface: #ffffff;
            --border: #e2e8f0;
            --text: #0f172a;
            --text-muted: #64748b;
            --text-faint: #94a3b8;
            --accent: #0ea5e9;
            --accent-dark: #0284c7;
            --accent-bg: #e0f2fe;
            --green: #10b981;
            --green-bg: #d1fae5;
            --green-border: #6ee7b7;
            --yellow: #f59e0b;
            --yellow-bg: #fef3c7;
            --yellow-border: #fcd34d;
            --red: #ef4444;
            --red-bg: #fee2e2;
            --red-border: #fca5a5;
            --shadow: 0 1px 3px rgba(15,23,42,0.08), 0 1px 2px rgba(15,23,42,0.06);
            --shadow-md: 0 4px 6px rgba(15,23,42,0.07), 0 2px 4px rgba(15,23,42,0.06);
            --shadow-lg: 0 10px 25px rgba(15,23,42,0.1), 0 4px 10px rgba(15,23,42,0.06);
        }

        body {
            background: var(--bg) !important;
            font-family: 'Sora', sans-serif !important;
            color: var(--text) !important;
        }

        /* ── PAGE WRAPPER ── */
        .med-page {
            padding: 2rem 2rem 4rem;
            max-width: 1400px;
            margin: 0 auto;
        }

        /* ── TOP HEADER BAR ── */
        .page-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1.75rem;
        }

        .page-header-left h1 {
            font-size: 22px;
            font-weight: 700;
            color: var(--text);
            margin: 0 0 2px;
            letter-spacing: -0.4px;
        }

        .page-header-left p {
            font-size: 13px;
            color: var(--text-muted);
            margin: 0;
            font-weight: 400;
        }

        .btn-add {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            background: var(--accent);
            color: #fff;
            font-family: 'Sora', sans-serif;
            font-size: 13px;
            font-weight: 600;
            padding: 9px 20px;
            border-radius: 8px;
            border: none;
            text-decoration: none;
            box-shadow: 0 2px 8px rgba(14,165,233,0.35);
            transition: background 0.15s, box-shadow 0.15s, transform 0.1s;
            letter-spacing: 0.01em;
        }

        .btn-add:hover {
            background: var(--accent-dark);
            color: #fff;
            box-shadow: 0 4px 14px rgba(14,165,233,0.4);
            text-decoration: none;
        }

        .btn-add:active { transform: scale(0.97); }

        .btn-add svg {
            width: 15px;
            height: 15px;
            stroke: #fff;
            fill: none;
            stroke-width: 2.5;
            stroke-linecap: round;
        }

        /* ── ALERT ── */
        .med-alert {
            border-radius: 8px;
            padding: 12px 16px;
            font-size: 13px;
            font-weight: 500;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 10px;
            border: 1px solid transparent;
        }

        .med-alert.success {
            background: var(--green-bg);
            border-color: var(--green-border);
            color: #065f46;
        }

        .med-alert.danger {
            background: var(--red-bg);
            border-color: var(--red-border);
            color: #991b1b;
        }

        .med-alert .close-btn {
            margin-left: auto;
            background: none;
            border: none;
            font-size: 16px;
            cursor: pointer;
            color: inherit;
            opacity: 0.6;
            line-height: 1;
        }

        /* ── STAT CARDS ── */
        .stat-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .stat-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 1.1rem 1.25rem;
            box-shadow: var(--shadow);
            display: flex;
            align-items: center;
            gap: 14px;
            transition: box-shadow 0.15s, transform 0.15s;
        }

        .stat-card:hover {
            box-shadow: var(--shadow-md);
            transform: translateY(-1px);
        }

        .stat-icon {
            width: 44px;
            height: 44px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .stat-icon svg {
            width: 20px;
            height: 20px;
            fill: none;
            stroke-width: 2;
            stroke-linecap: round;
            stroke-linejoin: round;
        }

        .stat-icon.blue  { background: var(--accent-bg);  } .stat-icon.blue  svg { stroke: var(--accent); }
        .stat-icon.green { background: var(--green-bg);   } .stat-icon.green svg { stroke: var(--green); }
        .stat-icon.yellow{ background: var(--yellow-bg);  } .stat-icon.yellow svg{ stroke: var(--yellow); }
        .stat-icon.red   { background: var(--red-bg);     } .stat-icon.red   svg { stroke: var(--red); }

        .stat-info p {
            font-size: 11px;
            font-weight: 500;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 0.07em;
            margin: 0 0 3px;
        }

        .stat-info h3 {
            font-size: 26px;
            font-weight: 700;
            color: var(--text);
            margin: 0;
            font-family: 'JetBrains Mono', monospace;
            letter-spacing: -1px;
        }

        /* ── FILTER BAR ── */
        .filter-bar {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 10px;
            padding: 0.85rem 1.25rem;
            margin-bottom: 1rem;
            box-shadow: var(--shadow);
            display: flex;
            align-items: center;
            gap: 10px;
            flex-wrap: wrap;
        }

        .filter-bar label {
            font-size: 11px;
            font-weight: 600;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 0.08em;
            margin: 0;
            white-space: nowrap;
        }

        .filter-select {
            font-family: 'Sora', sans-serif;
            font-size: 13px;
            color: var(--text);
            background: var(--bg);
            border: 1px solid var(--border);
            border-radius: 7px;
            padding: 7px 32px 7px 12px;
            outline: none;
            cursor: pointer;
            appearance: none;
            -webkit-appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%2364748b' stroke-width='2'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 10px center;
            transition: border-color 0.15s;
            min-width: 160px;
        }

        .filter-select:focus {
            border-color: var(--accent);
            box-shadow: 0 0 0 3px rgba(14,165,233,0.12);
        }

        .filter-divider {
            width: 1px;
            height: 24px;
            background: var(--border);
            flex-shrink: 0;
        }

        .btn-reset {
            font-family: 'Sora', sans-serif;
            font-size: 12px;
            font-weight: 600;
            color: var(--text-muted);
            background: transparent;
            border: 1px solid var(--border);
            border-radius: 7px;
            padding: 7px 16px;
            cursor: pointer;
            transition: all 0.15s;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            white-space: nowrap;
        }

        .btn-reset:hover {
            background: var(--bg);
            border-color: #cbd5e1;
            color: var(--text);
        }

        .btn-reset svg {
            width: 13px;
            height: 13px;
            stroke: currentColor;
            fill: none;
            stroke-width: 2;
            stroke-linecap: round;
        }

        /* ── TABLE CARD ── */
        .table-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 12px;
            overflow: hidden;
            box-shadow: var(--shadow-md);
        }

        /* ── DataTables overrides ── */
        #medicineTable {
            font-family: 'Sora', sans-serif !important;
            font-size: 13px !important;
            width: 100% !important;
            border-collapse: collapse !important;
        }

        #medicineTable thead tr {
            background: #f8fafc !important;
            border-bottom: 2px solid var(--border) !important;
        }

        #medicineTable thead th {
            font-size: 10px !important;
            font-weight: 700 !important;
            color: var(--text-muted) !important;
            text-transform: uppercase !important;
            letter-spacing: 0.1em !important;
            padding: 13px 14px !important;
            border: none !important;
            white-space: nowrap;
        }

        #medicineTable tbody tr {
            border-bottom: 1px solid #f1f5f9 !important;
            transition: background 0.1s !important;
        }

        #medicineTable tbody tr:hover {
            background: #f8fafc !important;
        }

        #medicineTable tbody tr:last-child {
            border-bottom: none !important;
        }

        #medicineTable tbody td {
            padding: 12px 14px !important;
            color: var(--text) !important;
            border: none !important;
            vertical-align: middle !important;
        }

        /* medicine image in table */
        #medicineTable tbody td img {
            width: 40px;
            height: 40px;
            object-fit: cover;
            border-radius: 8px;
            border: 1px solid var(--border);
        }

        /* medicine name bold */
        .med-name {
            font-weight: 600;
            color: var(--text);
            font-size: 13px;
        }

        /* category pill */
        .cat-pill {
            display: inline-block;
            padding: 3px 10px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 600;
            background: var(--accent-bg);
            color: var(--accent-dark);
            letter-spacing: 0.02em;
        }

        /* price mono */
        .price-val {
            font-family: 'JetBrains Mono', monospace;
            font-size: 13px;
            font-weight: 500;
            color: var(--text);
        }

        /* stock badge */
        .stock-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 4px 10px;
            border-radius: 6px;
            font-size: 11px;
            font-weight: 700;
            font-family: 'JetBrains Mono', monospace;
            letter-spacing: 0.03em;
        }

        .stock-badge.in    { background: var(--green-bg);  color: #065f46; border: 1px solid var(--green-border); }
        .stock-badge.low   { background: var(--yellow-bg); color: #92400e; border: 1px solid var(--yellow-border); }
        .stock-badge.out   { background: var(--red-bg);    color: #991b1b; border: 1px solid var(--red-border); }

        .stock-dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            flex-shrink: 0;
        }

        .stock-badge.in  .stock-dot { background: var(--green); }
        .stock-badge.low .stock-dot { background: var(--yellow); }
        .stock-badge.out .stock-dot { background: var(--red); }

        /* status pill */
        .status-pill {
            display: inline-block;
            padding: 3px 10px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 600;
        }

        .status-pill.active   { background: var(--green-bg);  color: #065f46; }
        .status-pill.inactive { background: #f1f5f9; color: var(--text-muted); }

        /* expiry date */
        .expiry-val {
            font-family: 'JetBrains Mono', monospace;
            font-size: 12px;
            color: var(--text-muted);
        }

        /* action buttons */
        .action-group {
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .act-btn {
            width: 32px;
            height: 32px;
            border-radius: 7px;
            border: 1px solid var(--border);
            background: var(--bg);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.15s;
        }

        .act-btn svg {
            width: 14px;
            height: 14px;
            fill: none;
            stroke-width: 2;
            stroke-linecap: round;
            stroke-linejoin: round;
        }

        .act-btn.edit svg   { stroke: var(--accent); }
        .act-btn.delete svg { stroke: var(--red); }

        .act-btn.edit:hover   { background: var(--accent-bg); border-color: #bae6fd; }
        .act-btn.delete:hover { background: var(--red-bg);    border-color: var(--red-border); }

        /* ── DataTables pagination & info ── */
        .dataTables_wrapper .dataTables_info,
        .dataTables_wrapper .dataTables_length,
        .dataTables_wrapper .dataTables_filter {
            font-family: 'Sora', sans-serif !important;
            font-size: 12px !important;
            color: var(--text-muted) !important;
            padding: 12px 16px !important;
        }

        .dataTables_wrapper .dataTables_filter input {
            font-family: 'Sora', sans-serif !important;
            font-size: 13px !important;
            border: 1px solid var(--border) !important;
            border-radius: 7px !important;
            padding: 6px 12px !important;
            outline: none !important;
            color: var(--text) !important;
            background: var(--bg) !important;
        }

        .dataTables_wrapper .dataTables_filter input:focus {
            border-color: var(--accent) !important;
            box-shadow: 0 0 0 3px rgba(14,165,233,0.12) !important;
        }

        .dataTables_wrapper .dataTables_length select {
            font-family: 'Sora', sans-serif !important;
            border: 1px solid var(--border) !important;
            border-radius: 7px !important;
            padding: 5px 8px !important;
            color: var(--text) !important;
            background: var(--bg) !important;
        }

        .dataTables_wrapper .dataTables_paginate {
            padding: 10px 16px !important;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button {
            font-family: 'Sora', sans-serif !important;
            font-size: 12px !important;
            border-radius: 6px !important;
            padding: 4px 10px !important;
            border: 1px solid transparent !important;
            color: var(--text-muted) !important;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            background: var(--accent) !important;
            border-color: var(--accent) !important;
            color: #fff !important;
            box-shadow: 0 2px 6px rgba(14,165,233,0.3) !important;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button:hover:not(.current):not(.disabled) {
            background: var(--bg) !important;
            border-color: var(--border) !important;
            color: var(--text) !important;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button.disabled {
            color: var(--text-faint) !important;
        }

        .dataTables_wrapper .dt-layout-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-top: 1px solid var(--border);
            flex-wrap: wrap;
        }

        /* ── processing overlay ── */
        .dataTables_processing {
            font-family: 'Sora', sans-serif !important;
            font-size: 13px !important;
            color: var(--accent) !important;
            background: rgba(255,255,255,0.9) !important;
            border: 1px solid var(--border) !important;
            border-radius: 8px !important;
            box-shadow: var(--shadow-md) !important;
        }

        @media (max-width: 768px) {
            .stat-grid { grid-template-columns: repeat(2, 1fr); }
            .med-page { padding: 1rem 1rem 3rem; }
            .page-header { flex-wrap: wrap; gap: 12px; }
        }
    </style>

    <div class="med-page">

        {{-- ALERTS --}}
        @if (session('success'))
            <div class="med-alert success">
                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><polyline points="20 6 9 17 4 12"/></svg>
                {{ session('success') }}
                <button class="close-btn" onclick="this.parentElement.remove()">×</button>
            </div>
        @endif
        @if (session('error'))
            <div class="med-alert danger">
                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                {{ session('error') }}
                <button class="close-btn" onclick="this.parentElement.remove()">×</button>
            </div>
        @endif

        {{-- PAGE HEADER --}}
        <div class="page-header">
            <div class="page-header-left">
                <h1>Medicines</h1>
                <p>{{ $medicines->count() }} total medicines in inventory</p>
            </div>
            <a href="{{ route('admin.medicines.create') }}" class="btn-add">
                <svg viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                Add Medicine
            </a>
        </div>

        {{-- STAT CARDS --}}
        <div class="stat-grid">
            <div class="stat-card">
                <div class="stat-icon blue">
                    <svg viewBox="0 0 24 24"><path d="M9 3H5a2 2 0 0 0-2 2v4m6-6h10a2 2 0 0 1 2 2v4M9 3v18m0 0h10a2 2 0 0 0 2-2V9M9 21H5a2 2 0 0 1-2-2V9m0 0h18"/></svg>
                </div>
                <div class="stat-info">
                    <p>Total Medicines</p>
                    <h3>{{ $medicines->count() }}</h3>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon green">
                    <svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                </div>
                <div class="stat-info">
                    <p>In Stock</p>
                    <h3>{{ $medicines->where('stock', '>', 10)->count() }}</h3>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon yellow">
                    <svg viewBox="0 0 24 24"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
                </div>
                <div class="stat-info">
                    <p>Low Stock</p>
                    <h3>{{ $medicines->whereBetween('stock', [1, 10])->count() }}</h3>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon red">
                    <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="4.93" y1="4.93" x2="19.07" y2="19.07"/></svg>
                </div>
                <div class="stat-info">
                    <p>Out of Stock</p>
                    <h3>{{ $medicines->where('stock', 0)->count() }}</h3>
                </div>
            </div>
        </div>

        {{-- FILTER BAR --}}
        <div class="filter-bar">
            <label>Filter by</label>

            <select id="filterCategory" class="filter-select">
                <option value="">All Categories</option>
                @foreach ($categories as $cat)
                    <option value="{{ strtolower($cat->id) }}">{{ $cat->name }}</option>
                @endforeach
            </select>

            <select id="filterStock" class="filter-select">
                <option value="">All Stock Status</option>
                <option value="in">In Stock</option>
                <option value="low">Low Stock</option>
                <option value="out">Out of Stock</option>
            </select>

            <div class="filter-divider"></div>

            <button id="resetBtn" class="btn-reset">
                <svg viewBox="0 0 24 24"><polyline points="1 4 1 10 7 10"/><path d="M3.51 15a9 9 0 1 0 .49-3.49"/></svg>
                Reset
            </button>
        </div>

        {{-- TABLE --}}
        <div class="table-card">
            <div class="table-responsive">
                <table class="table mb-0" id="medicineTable">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Category</th>
                            <th>SubCategory</th>
                            <th>Type</th>
                            <th>Purchase (₹)</th>
                            <th>Selling (₹)</th>
                            <th>Stock</th>
                            <th>Expiry</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                </table>
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
                            data: 'subcategory',
                            name: 'subcategory'
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