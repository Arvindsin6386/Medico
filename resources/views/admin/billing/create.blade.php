@extends('layouts.app')

@section('content')
    <style>
        @import url('https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600&family=DM+Mono:wght@400;500&display=swap');

        .billing-wrap {
            font-family: 'DM Sans', sans-serif;
            max-width: 720px;
            margin: 0 auto;
            padding: 2rem 1.5rem;
        }

        .billing-wrap h2 {
            font-size: 22px;
            font-weight: 600;
            color: #1a1a1a;
            margin: 0 0 2rem;
            letter-spacing: -0.3px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .billing-wrap h2::before {
            content: '';
            display: inline-block;
            width: 4px;
            height: 22px;
            background: #1D9E75;
            border-radius: 2px;
        }

        .card-section {
            background: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            padding: 1.25rem 1.5rem;
            margin-bottom: 1rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
        }

        .section-label {
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: #6b7280;
            margin: 0 0 1rem;
        }

        .field-group {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
        }

        .field {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .field label {
            font-size: 13px;
            font-weight: 500;
            color: #6b7280;
        }

        .field input,
        .field select {
            font-family: 'DM Sans', sans-serif;
            font-size: 14px;
            color: #111827;
            background: #f9fafb;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            padding: 8px 12px;
            outline: none;
            transition: border-color 0.15s, box-shadow 0.15s;
            height: 38px;
            width: 100%;
            box-sizing: border-box;
            appearance: none;
            -webkit-appearance: none;
        }

        .field select {
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%236b7280' stroke-width='2'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 12px center;
            padding-right: 32px;
        }

        .field input:focus,
        .field select:focus {
            border-color: #1D9E75;
            box-shadow: 0 0 0 3px rgba(29, 158, 117, 0.12);
            background: #fff;
        }

        .medicines-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1rem;
        }

        .medicines-header h4 {
            font-size: 15px;
            font-weight: 600;
            color: #111827;
            margin: 0;
        }

        .med-row {
            display: grid;
            grid-template-columns: 1fr 140px;
            gap: 10px;
            align-items: end;
            margin-bottom: 10px;
            position: relative;
            padding-left: 28px;
        }

        .med-row:last-of-type {
            margin-bottom: 0;
        }

        .row-num {
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            font-size: 11px;
            font-family: 'DM Mono', monospace;
            color: #9ca3af;
            font-weight: 500;
        }

        .qty-field {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .qty-field label {
            font-size: 13px;
            font-weight: 500;
            color: #6b7280;
        }

        .qty-field input {
            font-family: 'DM Mono', monospace;
            font-size: 14px;
            color: #111827;
            background: #f9fafb;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            padding: 8px 12px;
            outline: none;
            transition: border-color 0.15s, box-shadow 0.15s;
            height: 38px;
            width: 100%;
            box-sizing: border-box;
            text-align: right;
        }

        .qty-field input:focus {
            border-color: #1D9E75;
            box-shadow: 0 0 0 3px rgba(29, 158, 117, 0.12);
            background: #fff;
        }

        .btn-generate {
            font-family: 'DM Sans', sans-serif;
            font-size: 14px;
            font-weight: 600;
            color: #fff;
            background: #1D9E75;
            border: none;
            border-radius: 8px;
            padding: 0 24px;
            height: 42px;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: background 0.15s, transform 0.1s;
            margin-top: 1.25rem;
        }

        .btn-generate:hover {
            background: #0F6E56;
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
    </style>

    <div class="billing-wrap">

        <h2>Multi Medicine Billing</h2>

        <form method="POST" action="{{ route('admin.billing.store') }}">

            @csrf

            {{-- Customer Details --}}
            <div class="card-section">
                <p class="section-label">Customer Details</p>
                <div class="field-group">

                    <div class="field">
                        <label for="customer_name">Customer Name</label>
                        <input type="text" id="customer_name" name="customer_name" placeholder="e.g. Rahul Sharma">
                    </div>

                    <div class="field">
                        <label for="customer_phone">Customer Phone</label>
                        <input type="text" id="customer_phone" name="customer_phone" placeholder="+91 00000 00000">
                    </div>

                </div>
            </div>

            {{-- Medicines --}}
            <div class="card-section">

                <div class="medicines-header">

                    <h4>Medicines</h4>

                    {{-- Add Medicine Button --}}
                    <button type="button" id="addMedicine"
                        style="
                    background: #1D9E75;
                    color: #fff;
                    border: none;
                    border-radius: 8px;
                    padding: 8px 14px;
                    font-size: 13px;
                    font-weight: 600;
                    cursor: pointer;
                ">

                        + Add Medicine

                    </button>

                </div>

                {{-- Medicine Container --}}
                <div id="medicine-container">

                    {{-- Medicine Row --}}
                    <div class="med-row">

                        <span class="row-num">01</span>

                        <div class="field">

                            <label>Medicine</label>

                            <select name="medicine_id[]">

                                <option value="">Select Medicine</option>

                                @foreach ($medicines as $medicine)
                                    <option value="{{ $medicine->id }}">

                                        {{ $medicine->name }} — Stock: {{ $medicine->stock }}

                                    </option>
                                @endforeach

                            </select>

                        </div>

                        <div class="qty-field">

                            <label>Quantity</label>

                            <input type="number" name="quantity[]" class="form-control" min="1" value="1"
                            >
                        </div>

                        {{-- Remove Button --}}
                        <button type="button" class="removeMedicine"
                            style="
                        background: #dc2626;
                        color: white;
                        border: none;
                        border-radius: 8px;
                        padding: 0 12px;
                        height: 38px;
                        cursor: pointer;
                        margin-bottom: 1px;
                    ">

                            Remove

                        </button>
                        <button type="submit" class="btn-generate">

                            <svg viewBox="0 0 24 24" aria-hidden="true">
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

            </div>
        @endsection
