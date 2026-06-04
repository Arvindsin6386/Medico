@extends('layouts.app')

@section('content')
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=IBM+Plex+Sans:wght@300;400;500;600&family=IBM+Plex+Mono:wght@400;500&display=swap');

        :root {
            --ink: #0f172a;
            --ink-muted: #334155;
            --ink-faint: #94a3b8;
            --paper: #f1f5f9;
            --paper-dark: #e2e8f0;
            --rule: #cbd5e1;
            --accent: #f97316;
            --accent-light: #fff7ed;
            --accent-hover: #ea6c0a;
            --danger: #ef4444;
            --danger-hover: #dc2626;
            --shadow-sm: 0 1px 4px rgba(15, 23, 42, 0.08);
            --shadow-md: 0 4px 16px rgba(15, 23, 42, 0.10);
            --shadow-lg: 0 12px 40px rgba(15, 23, 42, 0.13);
            --page-bg: #0f172a;
        }

        /* ── PAGE ── */
        body {
            background: var(--page-bg) !important;
            background-image: radial-gradient(ellipse at 20% 10%, #1e3a5f 0%, transparent 55%),
                radial-gradient(ellipse at 80% 90%, #1a2744 0%, transparent 55%) !important;
            min-height: 100vh;
        }

        .billing-wrap {
            font-family: 'IBM Plex Sans', sans-serif;
            max-width: 760px;
            margin: 2.5rem auto;
            padding: 0 1.5rem 4rem;
            background: transparent;
        }

        /* ── HEADER ── */
        .billing-wrap h2 {
            font-family: 'Playfair Display', Georgia, serif;
            font-size: 28px;
            font-weight: 700;
            color: #f8fafc;
            margin: 0 0 0.25rem;
            letter-spacing: -0.5px;
            display: flex;
            align-items: baseline;
            gap: 12px;
        }

        .billing-wrap h2::before {
            content: none;
        }

        .billing-wrap h2 .bill-number {
            font-family: 'IBM Plex Mono', monospace;
            font-size: 12px;
            font-weight: 400;
            color: rgba(255, 255, 255, 0.5);
            letter-spacing: 0.12em;
            text-transform: uppercase;
            border: 1px solid rgba(255, 255, 255, 0.2);
            padding: 3px 8px;
            border-radius: 3px;
            background: rgba(255, 255, 255, 0.08);
            position: relative;
            top: -2px;
        }

        .bill-meta {
            display: flex;
            align-items: center;
            gap: 16px;
            margin-bottom: 2.25rem;
            padding-bottom: 1.5rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.15);
        }

        .bill-meta-date {
            font-family: 'IBM Plex Mono', monospace;
            font-size: 12px;
            color: rgba(255, 255, 255, 0.55);
            letter-spacing: 0.06em;
        }

        .bill-meta-dot {
            width: 3px;
            height: 3px;
            background: rgba(255, 255, 255, 0.3);
            border-radius: 50%;
        }

        /* ── SECTIONS ── */
        .card-section {
            background: var(--paper);
            border: 1px solid var(--rule);
            border-radius: 4px;
            padding: 1.5rem 1.75rem;
            margin-bottom: 1px;
            box-shadow: 0 4px 24px rgba(0, 0, 0, 0.30), 0 1px 4px rgba(0, 0, 0, 0.20);
            position: relative;
        }

        .card-section:first-of-type {
            border-radius: 4px 4px 0 0;
        }

        .card-section:last-of-type {
            border-radius: 0 0 4px 4px;
            border-top: none;
        }

        .card-section:only-of-type {
            border-radius: 4px;
        }

        /* corner stamp effect on first section */
        .card-section.customer-section::after {
            content: 'CUSTOMER';
            position: absolute;
            top: 14px;
            right: 18px;
            font-family: 'IBM Plex Mono', monospace;
            font-size: 9px;
            letter-spacing: 0.18em;
            color: #94a3b8;
            text-transform: uppercase;
        }

        .section-label {
            font-family: 'IBM Plex Mono', monospace;
            font-size: 10px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.14em;
            color: #475569;
            margin: 0 0 1.1rem;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .section-label::after {
            content: '';
            flex: 1;
            height: 1px;
            background: var(--rule);
        }

        .field-group {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.25rem;
        }

        /* ── FIELDS ── */
        .field {
            display: flex;
            flex-direction: column;
            gap: 5px;
        }

        .field label {
            font-size: 12px;
            font-weight: 600;
            color: #1e293b;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            font-family: 'IBM Plex Mono', monospace;
        }

        .field input,
        .field select {
            font-family: 'IBM Plex Sans', sans-serif;
            font-size: 14px;
            color: #0f172a;
            background: #ffffff;
            border: 1.5px solid #94a3b8;
            border-radius: 3px;
            padding: 9px 13px;
            outline: none;
            transition: border-color 0.15s, box-shadow 0.15s;
            height: 40px;
            width: 100%;
            box-sizing: border-box;
            appearance: none;
            -webkit-appearance: none;
            box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.06);
        }

        .field select {
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%231e293b' stroke-width='2'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 12px center;
            padding-right: 32px;
        }

        .field input::placeholder {
            color: #64748b;
            font-style: italic;
        }

        .field input:focus,
        .field select:focus {
            border-color: var(--accent);
            box-shadow: 0 0 0 3px rgba(249, 115, 22, 0.15), inset 0 1px 2px rgba(0, 0, 0, 0.02);
            background: #fff;
        }

        /* ── MEDICINES SECTION ── */
        .medicines-section {
            border-top: none;
        }

        .medicines-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1.25rem;
        }

        .medicines-header h4 {
            font-family: 'IBM Plex Mono', monospace;
            font-size: 10px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.14em;
            color: #475569;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .medicines-header h4::after {
            content: '';
            flex: 1;
            display: block;
            width: 200px;
            height: 1px;
            background: var(--rule);
        }

        /* ── TABLE HEADER ── */
        .med-table-head {
            display: grid;
            grid-template-columns: 28px 1fr 120px 40px;
            gap: 10px;
            padding: 0 0 8px;
            border-bottom: 1px dashed var(--rule);
            margin-bottom: 8px;
        }

        .med-table-head span {
            font-family: 'IBM Plex Mono', monospace;
            font-size: 9px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.12em;
            color: #475569;
        }

        .med-table-head span:nth-child(3) {
            text-align: right;
        }

        /* ── MED ROW ── */
        .med-row {
            display: grid;
            grid-template-columns: 28px 1fr 120px 40px;
            gap: 10px;
            align-items: end;
            margin-bottom: 10px;
            position: relative;
            padding-left: 0;
        }

        .med-row:last-of-type {
            margin-bottom: 0;
        }

        .row-num {
            position: static;
            transform: none;
            font-size: 11px;
            font-family: 'IBM Plex Mono', monospace;
            color: #475569;
            font-weight: 500;
            align-self: center;
            padding-bottom: 2px;
            text-align: center;
        }

        /* ── QTY FIELD ── */
        .qty-field {
            display: flex;
            flex-direction: column;
            gap: 5px;
        }

        .qty-field label {
            font-size: 12px;
            font-weight: 600;
            color: #1e293b;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            font-family: 'IBM Plex Mono', monospace;
        }

        .qty-field input {
            font-family: 'IBM Plex Mono', monospace;
            font-size: 14px;
            color: #0f172a;
            background: #ffffff;
            border: 1.5px solid #94a3b8;
            border-radius: 3px;
            padding: 9px 12px;
            outline: none;
            transition: border-color 0.15s, box-shadow 0.15s;
            height: 40px;
            width: 100%;
            box-sizing: border-box;
            text-align: right;
            box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.06);
        }

        .qty-field input:focus {
            border-color: var(--accent);
            box-shadow: 0 0 0 3px rgba(249, 115, 22, 0.15);
            background: #fff;
        }

        /* ── GENERATE BUTTON ── */
        .btn-generate {
            font-family: 'IBM Plex Sans', sans-serif;
            font-size: 13px;
            font-weight: 600;
            letter-spacing: 0.04em;
            color: #fff;
            background: var(--accent);
            border: none;
            border-radius: 3px;
            padding: 0 28px;
            height: 44px;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            transition: background 0.15s, transform 0.1s, box-shadow 0.15s;
            margin-top: 1.5rem;
            box-shadow: 0 2px 8px rgba(249, 115, 22, 0.28), 0 1px 2px rgba(249, 115, 22, 0.18);
            text-transform: uppercase;
        }

        .btn-generate:hover {
            background: var(--accent-hover);
            box-shadow: 0 4px 14px rgba(249, 115, 22, 0.35), 0 1px 3px rgba(249, 115, 22, 0.2);
        }

        .btn-generate:active {
            transform: scale(0.98);
        }

        .btn-generate svg {
            width: 16px;
            height: 16px;
            stroke: #fff;
            fill: none;
            stroke-width: 2;
            stroke-linecap: round;
            stroke-linejoin: round;
        }

        /* ── MEDICINE SEARCH ── */
        .medicine-wrapper {
            position: relative;
            width: 100%;
        }

        .medicine-search {
            width: 100%;
            font-family: 'IBM Plex Sans', sans-serif;
            font-size: 14px;
            color: #0f172a;
            background: #ffffff;
            border: 1.5px solid #94a3b8;
            border-radius: 3px;
            padding: 9px 13px;
            outline: none;
            transition: border-color 0.15s, box-shadow 0.15s;
            height: 40px;
            box-sizing: border-box;
            box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.06);
        }

        .medicine-search::placeholder {
            color: #64748b;
            font-style: italic;
        }

        .medicine-search:focus {
            border-color: var(--accent);
            box-shadow: 0 0 0 3px rgba(13, 110, 253, 0.15);
        }

        .medicine-results {
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            background: #fff;
            border: 1px solid var(--rule);
            border-top: 2px solid var(--accent);
            border-radius: 0 0 4px 4px;
            margin-top: 0;
            max-height: 220px;
            overflow-y: auto;
            display: none;
            z-index: 9999;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.10);
        }

        .medicine-item {
            padding: 10px 12px;
            cursor: pointer;
            font-size: 13px;
            color: var(--ink);
            border-bottom: 1px solid var(--paper-dark);
            transition: background 0.1s;
        }

        .medicine-item:last-child {
            border-bottom: none;
        }

        .medicine-item:hover {
            background: var(--accent-light);
        }

        /* ── REMOVE BUTTON ── */
        .removeMedicine {
            width: 40px;
            height: 40px;
            border: 1px solid #e8d5d3;
            border-radius: 3px;
            background: #fdf4f3;
            color: var(--danger);
            cursor: pointer;
            font-size: 13px;
            font-weight: 600;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.15s;
            align-self: center;
        }

        .removeMedicine:hover {
            background: var(--danger);
            color: #fff;
            border-color: var(--danger);
        }

        /* ── SELECTED MEDICINES (CHIPS) ── */
        #selected-medicines {
            margin-top: 6px;
        }

        .selected-medicine {
            background: var(--accent-light);
            border: 1px solid rgba(249, 115, 22, 0.2);
            border-left: 3px solid var(--accent);
            border-radius: 3px;
            padding: 8px 12px;
            font-size: 13px;
            color: #0f172a;
            margin-top: 6px;
        }

        .selected-medicine strong {
            font-weight: 600;
            color: #c2410c;
        }

        .selected-medicine input[type="number"] {
            font-family: 'IBM Plex Mono', monospace;
            font-size: 13px;
            border: 1px solid rgba(249, 115, 22, 0.25);
            border-radius: 3px;
            padding: 3px 8px;
            margin-top: 6px;
            color: var(--ink);
            background: #fff;
            width: 70px;
            text-align: right;
        }

        /* ── CUSTOMER AUTOCOMPLETE LIST ── */
        #customer_list {
            position: absolute;
            z-index: 9999;
            background: #fff;
            /* border: 1px solid var(--rule);
            border-top: 2px solid var(--accent); */
            border-radius: 0 0 4px 4px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.10);
            width: 100%;
            left: 0;
        }

        .customer-item {
            padding: 10px 13px;
            cursor: pointer;
            font-size: 13px;
            color: var(--ink);
            border-bottom: 1px solid var(--paper-dark);
            transition: background 0.1s;
            font-family: 'IBM Plex Sans', sans-serif;
        }

        .customer-item:hover {
            background: var(--accent-light);
        }

        /* ── DIVIDER LINE between sections ── */
        .section-divider {
            border: none;
            border-top: 1px dashed var(--rule);
            margin: 1.25rem 0;
        }

        /* ── BILL FOOTER WATERMARK ── */
        .bill-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 2rem;
            padding-top: 1rem;
            border-top: 1px solid var(--rule);
        }

        .bill-footer-note {
            font-family: 'IBM Plex Mono', monospace;
            font-size: 10px;
            color: #475569;
            letter-spacing: 0.08em;
        }
    </style>

    <div class="billing-wrap">

        <h2>
            New Bill
            <span class="bill-number">DRAFT</span>
        </h2>

        <div class="bill-meta">
            <span class="bill-meta-date" id="bill-date"></span>
            <span class="bill-meta-dot"></span>
            <span class="bill-meta-date">Medicine Billing System</span>
        </div>

        <form method="POST" action="{{ route('admin.billing.store') }}">

            @csrf

            {{-- Customer Details --}}
            <div class="card-section customer-section">
                <p class="section-label">Customer Details</p>
                <div class="field-group">

                    {{-- Phone FIRST --}}
                    <div class="field" style="position: relative;">
                        <label for="customer_phone">Customer Phone</label>
                        <input type="text" id="customer_phone" name="customer_phone" placeholder="+91 00000 00000"
                            autocomplete="off">
                        {{-- <small id="customerMessage"></small> --}}
                        <div id="customer_list"></div>
                    </div>

                    {{-- Name SECOND --}}
                    <div class="field">
                        <label for="customer_name">Customer Name</label>
                        <input type="text" id="customer_name" name="customer_name" placeholder="e.g. Rahul Sharma"
                            autocomplete="off">
                    </div>

                </div>
            </div>

            <div class="card-section medicines-section">

                <div class="medicines-header">
                    <h4>Medicines</h4>
                </div>

                <div class="med-table-head">
                    <span>#</span>
                    <span>Item</span>
                    <span></span>
                    <span></span>
                </div>

                <div id="medicine-container">

                    <div class="med-row">

                        <span class="row-num">01</span>

                        <div class="field">

                            <div class="medicine-wrapper">

                                <input type="text" class="medicine-search" placeholder="Search medicine name…">

                                <div class="medicine-results"></div>

                            </div>

                            <!-- Selected medicines will appear here -->
                            <div id="selected-medicines"></div>

                        </div>

                        {{-- <button type="button" class="removeMedicine"> </button> --}}

                    </div>

                </div>

                <hr class="section-divider">

                <div class="bill-footer">
                    <span class="bill-footer-note">All prices inclusive of GST &nbsp;•&nbsp; Thank you for your
                        purchase</span>

                    <button type="submit" class="btn-generate">

                        <svg viewBox="0 0 24 24">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                            <polyline points="14 2 14 8 20 8" />
                            <line x1="16" y1="13" x2="8" y2="13" />
                            <line x1="16" y1="17" x2="8" y2="17" />
                            <polyline points="10 9 9 9 8 9" />
                        </svg>

                        Generate Bill

                    </button>
                </div>

            </div>

        </form>

    </div>

    <script>
        // Set today's date in header
        document.getElementById('bill-date').textContent = new Date().toLocaleDateString('en-IN', {
            weekday: 'long',
            year: 'numeric',
            month: 'long',
            day: 'numeric'
        }).toUpperCase();
    </script>
@endsection
@section('scripts')
    <script>
        $(document).on('click', '.medicine-item', function() {

            let id = $(this).data('id');
            let name = $(this).data('name');
            let category = $(this).data('category');
            let subcategory = $(this).data('subcategory');

            $('#selected-medicines').append(`
        <div class="selected-medicine">

            <strong>${name}</strong><br>
            Category: ${category}<br>
            Subcategory: ${subcategory}<br>

            <input type="hidden"
                   name="medicine_id[]"
                   value="${id}">

            <input type="number"
                   name="quantity[]"
                   value="1"
                   min="1">

            <button type="button" class="removeMedicine">
                Remove
            </button>

        </div>
    `);

            $('.medicine-search').val('');
            $('.medicine-results').hide().html('');
        });


        $(document).on('click', '.removeMedicine', function() {

            $(this).closest('.selected-medicine').remove();

        });
        /*
        |--------------------------------------------------------------------------
        | CUSTOMER SEARCH (AUTO FILL)
        |--------------------------------------------------------------------------
        | When user types phone number:
        | - wait 300ms
        | - check database
        | - auto fill customer name
        */
        let timer;
        $('#customer_phone').on('keyup', function() {
            let phone = $(this).val().trim();
            if (phone.length < 2) {
                $('#customer_list').hide().html('');
                return;
            }
            timer = setTimeout(function() {
                $.ajax({
                    url: "{{ route('admin.billing.customer.search') }}",
                    type: "GET",
                    data: {
                        search: phone
                    },
                    success: function(response) {
                        let html = '';
                        response.forEach(function(customer) {
                            html += `
                        <div class="customer-item"
                             data-name="${customer.name}"
                             data-phone="${customer.phone}">
                            ${customer.name} - ${customer.phone}
                        </div>
                    `;
                        });
                        $('#customer_list').html(html).show();
                    },

                    error: function(xhr) {
                        console.log(xhr.responseText);
                    }
                });
            }, 300);
        });
        $(document).on('click', '.customer-item', function() {
            $('#customer_name').val($(this).data('name'));
            $('#customer_phone').val($(this).data('phone'));
            $('#customer_list').html('');
        });
        /*
        |--------------------------------------------------------------------------
        | MEDICINE SEARCH (LIVE AUTOCOMPLETE)
        |--------------------------------------------------------------------------
        | User types medicine name → get matching medicines from server
        */
        $(document).on('keyup', '.medicine-search', function() {

            let search = $(this).val();
            let parent = $(this).closest('.medicine-wrapper');

            // Hide dropdown if less than 2 characters
            if (search.length < 2) {
                parent.find('.medicine-results').hide().html('');
                return;
            }

            $.ajax({
                url: "{{ route('admin.billing.medicine.search') }}",
                type: "GET",
                data: {
                    search: search
                },

                success: function(response) {

                    let html = '';

                    response.forEach(function(medicine) {

                        html += `
                    <div class="medicine-item"
                         data-id="${medicine.id}"
                         data-name="${medicine.name}"
                      data-category="${medicine.category.name}"
                       data-subcategory="${medicine.subcategory.name}">

                        <div style="display:flex;align-items:center;gap:10px;padding:8px;">

                            <img src="/storage/${medicine.image}"
                                 width="50"
                                 height="50"
                                 style="object-fit:cover;border-radius:3px;">

                            <div>
                                <strong>${medicine.name}</strong><br>
                              Category: ${medicine.category.name}<br>
                              Subcategory: ${medicine.subcategory.name}
                            </div>

                        </div>
                    </div>
                `;
                    });

                    parent.find('.medicine-results')
                        .html(html)
                        .show();
                }
            });
        });
        /*
        |--------------------------------------------------------------------------
        | SELECT MEDICINE FROM LIST
        |--------------------------------------------------------------------------
        | When user clicks a medicine:
        | - fill name in input
        | - store id in hidden field
        | - hide dropdown
        */
        $(document).on('click', '.medicine-item', function() {
            let id = $(this).data('id');
            let name = $(this).data('name');
            let parent = $(this).closest('.medicine-wrapper');
            // Fill selected medicine name
            parent.find('.medicine-search').val(name);
            // Store medicine ID (important for backend)
            parent.find('.medicine-id').val(id);
            // Hide dropdown
            parent.find('.medicine-results').hide();

        });
    </script>
@endsection
