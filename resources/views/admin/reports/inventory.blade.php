@extends('layouts.app')

@section('title', 'Inventory Report')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-6">

    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-semibold">Inventory Report</h1>
        <a href="{{ route('admin.reports.index') }}" class="text-sm text-gray-500 hover:underline">← Back</a>
    </div>

    {{-- Filters --}}
    <form method="GET" class="bg-white p-4 rounded-lg shadow mb-6 flex gap-3 flex-wrap">
        <div>
            <label class="text-xs text-gray-500 block mb-1">Category</label>
            <select name="category_id" class="border rounded px-3 py-1.5 text-sm">
                <option value="">All Categories</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" @selected(request('category_id') == $cat->id)>{{ $cat->name }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="text-xs text-gray-500 block mb-1">Company / Brand</label>
            <input type="text" name="company" value="{{ request('company') }}"
                   placeholder="e.g. Cipla"
                   class="border rounded px-3 py-1.5 text-sm">
        </div>
        <div>
            <label class="text-xs text-gray-500 block mb-1">Filter</label>
            <select name="filter" class="border rounded px-3 py-1.5 text-sm">
                <option value="">All Stock</option>
                <option value="low_stock"    @selected(request('filter')=='low_stock')>Low Stock (≤10)</option>
                <option value="out_of_stock" @selected(request('filter')=='out_of_stock')>Out of Stock</option>
            </select>
        </div>
        <div class="flex items-end">
            <button class="bg-green-600 text-white px-4 py-1.5 rounded text-sm">Filter</button>
        </div>
    </form>

    {{-- Stock Value Summary --}}
    <div class="bg-green-50 rounded-lg p-4 mb-6 inline-block">
        <p class="text-xs text-green-600">Total Inventory Value</p>
        <p class="text-2xl font-semibold text-green-800">₹{{ number_format($totalStockValue) }}</p>
    </div>

    {{-- Table --}}
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="min-w-full text-sm divide-y divide-gray-200">
            <thead class="bg-gray-50 text-xs uppercase text-gray-500">
                <tr>
                    <th class="px-5 py-3 text-left">#</th>
                    <th class="px-5 py-3 text-left">Medicine</th>
                    <th class="px-5 py-3 text-left">Company</th>
                    <th class="px-5 py-3 text-left">Category</th>
                    <th class="px-5 py-3 text-left">Stock</th>
                    <th class="px-5 py-3 text-left">Price (₹)</th>
                    <th class="px-5 py-3 text-left">Stock Value</th>
                    <th class="px-5 py-3 text-left">Expiry</th>
                    <th class="px-5 py-3 text-left">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($medicines as $med)
                <tr class="hover:bg-gray-50">
                    <td class="px-5 py-3 text-gray-500">{{ $loop->iteration }}</td>
                    <td class="px-5 py-3 font-medium">{{ $med->name }}</td>
                    <td class="px-5 py-3 text-gray-600">{{ $med->company ?? '—' }}</td>
                    <td class="px-5 py-3 text-gray-600">{{ $med->category->name ?? '—' }}</td>
                    <td class="px-5 py-3 font-medium">{{ $med->stock }}</td>
                    <td class="px-5 py-3">₹{{ number_format($med->price) }}</td>
                    <td class="px-5 py-3 text-blue-700 font-medium">₹{{ number_format($med->stock * $med->price) }}</td>
                    <td class="px-5 py-3 text-gray-500">
                        {{ $med->expiry_data ? $med->expiry_data->format('d M Y') : '—' }}
                    </td>
                    <td class="px-5 py-3">
                        @if($med->stock == 0)
                            <span class="px-2 py-0.5 bg-red-100 text-red-700 rounded-full text-xs">Out of Stock</span>
                        @elseif($med->stock <= 10)
                            <span class="px-2 py-0.5 bg-yellow-100 text-yellow-700 rounded-full text-xs">Low Stock</span>
                        @else
                            <span class="px-2 py-0.5 bg-green-100 text-green-700 rounded-full text-xs">In Stock</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr><td colspan="9" class="px-5 py-8 text-center text-gray-400">No medicines found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $medicines->withQueryString()->links() }}</div>
</div>
@endsection