@extends('layouts.app')

@section('content')
    <div class="container">

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Add Medicine</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.medicines.store') }}" method="POST">
                    @csrf
                    <div class="row">

                        {{-- Category --}}
                        <div class="col-md-6 mb-3">
                            <label>Category <span class="text-danger">*</span></label>
                            <select name="category_id" id="category_id" class="form-control" required>
                                <option value="">-- Select Category --</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}"
                                        {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Subcategory --}}
                        <div class="col-md-6 mb-3">
                            <label>Subcategory <span class="text-danger">*</span></label>
                            <select name="subcategory_id" id="subcategory_id" class="form-control" required>
                                <option value="">-- Select Subcategory --</option>
                                @foreach ($subcategories as $subcategory)
                                    <option value="{{ $subcategory->id }}" data-category="{{ $subcategory->category_id }}"
                                        {{ old('subcategory_id') == $subcategory->id ? 'selected' : '' }}>
                                        {{ $subcategory->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('subcategory_id')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                    </div>

                    {{-- Step 3: Medicine Name --}}
                    <div class="mb-3">
                        <label>Medicine Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" placeholder="Enter medicine name"
                            value="{{ old('name') }}" required>
                        @error('name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label>Stock Quantity</label>
                        <input type="number" name="stock" class="form-control" placeholder="e.g. 100"
                            value="{{ old('stock', 0) }}" min="0">
                        @error('stock')
                            <span class="text-danger" style="font-size:12px;">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="row">

                        {{-- Price --}}
                        <div class="col-md-6 mb-3">
                            <label>Price <span class="text-danger">*</span></label>
                            <input type="number" name="price" class="form-control" placeholder="Enter price"
                                value="{{ old('price') }}" required>
                            @error('price')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
 
                        {{-- Description --}}
                        <div class="col-md-6 mb-3">
                            <label>Description</label>
                            <input type="text" name="description" class="form-control" placeholder="Enter description"
                                value="{{ old('description') }}">
                            @error('description')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                    </div>

                    <button type="submit" class="btn btn-primary">Add Medicine</button>
                    <a href="{{ route('admin.medicines.index') }}" class="btn btn-secondary">View All</a>

                </form>
            </div>
        </div>

    </div>

    {{-- Filter subcategory based on selected category --}}
    <script>
        const categorySelect = document.getElementById('category_id');
        const subcategorySelect = document.getElementById('subcategory_id');
        const allOptions = Array.from(subcategorySelect.options);

        categorySelect.addEventListener('change', function() {
            const selectedCategory = this.value;

            // reset subcategory
            subcategorySelect.innerHTML = '<option value="">-- Select Subcategory --</option>';

            allOptions.forEach(option => {
                if (option.dataset.category === selectedCategory || option.value === '') {
                    subcategorySelect.appendChild(option.cloneNode(true));
                }
            });
        });
    </script>
@endsection
