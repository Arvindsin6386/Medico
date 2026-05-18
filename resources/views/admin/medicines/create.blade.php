@extends('layouts.app')

@section('content')
    <div class="container py-4">

        <div class="card">
            <div class="card-header">
                <h5>Add Medicine</h5>
            </div>

            <div class="card-body">

                <form action="{{ route('admin.medicines.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    {{-- CATEGORY + SUBCATEGORY --}}
                    <div class="row">

                        <div class="col-md-6 mb-3">
                            <label>Category</label>
                            <select name="category_id" id="category_id" class="form-control" required>
                                <option value="">Select</option>
                                @foreach ($categories as $cat)
                                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>Subcategory</label>
                            <select name="subcategory_id" id="subcategory_id" class="form-control">
                                <option value="">Select</option>
                                @foreach ($subcategories as $sub)
                                    <option value="{{ $sub->id }}" data-category="{{ $sub->category_id }}">
                                        {{ $sub->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                    </div>

                    {{-- NAME --}}
                    <div class="mb-3">
                        <label>Medicine Name</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>

                    {{-- BRAND + TYPE + UNIT --}}
                    <div class="row">

                        <div class="col-md-4 mb-3">
                            <label>Brand Name</label>
                            <input type="text" name="brand_name" class="form-control">
                        </div>

                        <div class="col-md-4 mb-3">
                            <label>Medicine Type</label>
                            <select name="medicine_type" class="form-control">
                                <option value="">Select</option>
                                <option>Tablet</option>
                                <option>Capsule</option>
                                <option>Syrup</option>
                                <option>Injection</option>
                            </select>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label>Unit</label>
                            <select name="unit" class="form-control">
                                <option value="">Select</option>
                                <option>Strip</option>
                                <option>Bottle</option>
                                <option>Box</option>
                            </select>
                        </div>

                    </div>

                    {{-- PRICES --}}
                    <div class="row">

                        <div class="col-md-6 mb-3">
                            <label>Purchase Price</label>
                            <input type="number" name="purchase_price" class="form-control">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>Selling Price</label>
                            <input type="number" name="selling_price" class="form-control">
                        </div>

                    </div>

                    {{-- STOCK + EXPIRY --}}
                    <div class="row">

                        <div class="col-md-6 mb-3">
                            <label>Stock</label>
                            <input type="number" name="stock" class="form-control" value="0">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>Expiry Date</label>
                            <input type="date" name="expiry_date" class="form-control">
                        </div>
                        {{-- IMAGE --}}
                        <div class="mb-3">
                            <label>Medicine Image</label>

                            <input type="file" name="image" class="form-control"
                                accept="image/jpg,image/jpeg,image/png,image/webp">

                            @error('image')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                    </div>

                    <button class="btn btn-success">Save Medicine</button>
                </form>

            </div>
        </div>

    </div>

    {{-- SUBCATEGORY FILTER --}}
    <script>
        document.getElementById('category_id').addEventListener('change', function() {

            let categoryId = this.value;
            let sub = document.getElementById('subcategory_id');

            Array.from(sub.options).forEach(opt => {
                opt.style.display = (opt.dataset.category == categoryId || opt.value == "") ?
                    "block" :
                    "none";
            });

        });
    </script>
@endsection
