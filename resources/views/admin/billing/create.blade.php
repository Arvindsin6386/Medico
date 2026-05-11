@extends('layouts.app')

@section('content')

<div class="container">

    <h2>Multi Medicine Billing</h2>

    <form method="POST" action="{{ route('admin.billing.store') }}">

        @csrf

        {{-- Customer Name --}}
        <div class="mb-3">
            <label>Customer Name</label>

            <input type="text"
                   name="customer_name"
                   class="form-control">
        </div>

        {{-- Customer Phone --}}
        <div class="mb-3">
            <label>Customer Phone</label>

            <input type="text"
                   name="customer_phone"
                   class="form-control">
        </div>

        <hr>

        <h4>Medicines</h4>

        {{-- Medicine 1 --}}
        <div class="row mb-3">

            <div class="col-md-6">

                <select name="medicine_id[]" class="form-control">

                    <option value="">Select Medicine</option>

                    @foreach($medicines as $medicine)

                        <option value="{{ $medicine->id }}">

                            {{ $medicine->name }}
                            |
                            Stock: {{ $medicine->stock }}

                        </option>

                    @endforeach

                </select>

            </div>

            <div class="col-md-3">

                <input type="number"
                       name="quantity[]"
                       class="form-control"
                       placeholder="Quantity">

            </div>

        </div>

        {{-- Medicine 2 --}}
        <div class="row mb-3">

            <div class="col-md-6">

                <select name="medicine_id[]" class="form-control">

                    <option value="">Select Medicine</option>

                    @foreach($medicines as $medicine)

                        <option value="{{ $medicine->id }}">

                            {{ $medicine->name }}
                            |
                            Stock: {{ $medicine->stock }}

                        </option>

                    @endforeach

                </select>

            </div>

            <div class="col-md-3">

                <input type="number"
                       name="quantity[]"
                       class="form-control"
                       placeholder="Quantity">

            </div>

        </div>

        <button class="btn btn-primary">

            Generate Bill

        </button>

    </form>

</div>

@endsection