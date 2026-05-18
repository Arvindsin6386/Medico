@extends('layouts.app')

@section('content')
<div class="container">

    <div class="card">
        <div class="card-header">
            <h5>Edit Medicine</h5>
        </div>

        <div class="card-body">

            <form action="{{ route('admin.medicines.update', $medicine->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label>Name</label>
                    <input type="text" name="name" class="form-control" value="{{ $medicine->name }}">
                </div>

                <div class="mb-3">
                    <label>Stock</label>
                    <input type="number" name="stock" class="form-control" value="{{ $medicine->stock }}">
                </div>

                <div class="mb-3">
                    <label>Price</label>
                    <input type="number" name="selling_price" class="form-control" value="{{ $medicine->selling_price }}">
                </div>

                <button class="btn btn-success">Update</button>
                <a href="{{ route('admin.medicines.index') }}" class="btn btn-secondary">Back</a>

            </form>

        </div>
    </div>

</div>
@endsection