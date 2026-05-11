@extends('layouts.app')
@section('title', 'Reports Dashboard')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-6">

    <h1 class="text-2xl font-semibold mb-2">Reports</h1>
    <p class="text-gray-500 text-sm mb-6">Medical shop overview for {{ now()->format('F Y') }}</p>

    {{-- Navigation Tabs --}}
    <div class="flex gap-2 flex-wrap mb-6">
        @foreach([
            ['route' => 'admin.reports.sales',     'label' => 'Sales',       'color' => 'blue'],
            ['route' => 'admin.reports.inventory',  'label' => 'Inventory',   'color' => 'green'],
            ['route' => 'admin.reports.expiry',     'label' => 'Expiry',      'color' => 'red'],
            ['route' => 'admin.reports.purchases',  'label' => 'Purchases',   'color' => 'yellow'],
            ['route' => 'admin.reports.profit',     'label' => 'Profit & Loss','color' => 'purple'],
        ] as $tab)
        <a href="{{ route($tab['route']) }}"
           class="px-4 py-2 rounded-lg text-sm font-medium
                  bg-{{ $tab['color'] }}-50 text-{{ $tab['color'] }}-700
                  hover:bg-{{ $tab['color'] }}-100 border border-{{ $tab['color'] }}-200">
            {{ $tab['label'] }}
        </a>
        @endforeach
    </div>

    {{-- Summary Cards --}}
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4 mb-8">
        <div class="bg-blue-50 rounded-lg p-4 col-span-1">
            <p class="text-xs text-blue-500 mb-1">Sales (This Month)</p>
            <p class="text-xl font-semibold text-blue-800">₹{{ number_format($totalSalesAmount) }}</p>
        </div>
        <div class="bg-green-50 rounded-lg p-4">
            <p class="text-xs text-green-500 mb-1">Orders</p>
            <p class="text-xl font-semibold text-green-800">{{ $totalOrders }}</p>
        </div>
        <div class="bg-yellow-50 rounded-lg p-4">
            <p class="text-xs text-yellow-500 mb-1">Low Stock</p>
            <p class="text-xl font-semibold text-yellow-800">{{ $lowStockCount }}</p>
        </div>
        <div class="bg-gray-50 rounded-lg p-4">
            <p class="text-xs text-gray-500 mb-1">Out of Stock</p>
            <p class="text-xl font-semibold text-gray-800">{{ $outOfStockCount }}</p>
        </div>
        <div class="bg-orange-50 rounded-lg p-4">
            <p class="text-xs text-orange-500 mb-1">Expiring (30d)</p>
            <p class="text-xl font-semibold text-orange-800">{{ $expiringCount }}</p>
        </div>
        <div class="bg-red-50 rounded-lg p-4">
            <p class="text-xs text-red-500 mb-1">Expired</p>
            <p class="text-xl font-semibold text-red-800">{{ $expiredCount }}</p>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

        {{-- Top Selling --}}
        <div class="bg-white rounded-lg shadow p-5">
            <h2 class="text-sm font-semibold mb-4 text-gray-700">Top Selling This Month</h2>
            @forelse($topMedicines as $item)
            <div class="flex justify-between items-center py-2 border-b last:border-0">
                <div>
                    <p class="text-sm font-medium text-gray-800">{{ $item->medicine->name }}</p>
                    <p class="text-xs text-gray-400">{{ $item->total_qty }} units sold</p>
                </div>
                <span class="text-sm font-semibold text-green-700">₹{{ number_format($item->revenue) }}</span>
            </div>
            @empty
            <p class="text-sm text-gray-400">No sales this month.</p>
            @endforelse
        </div>

        {{-- Expiring Soon --}}
        <div class="bg-white rounded-lg shadow p-5">
            <h2 class="text-sm font-semibold mb-4 text-gray-700">Expiring in 30 Days</h2>
            @forelse($expiringList as $med)
            @php $daysLeft = now()->diffInDays($med->expiry_data, false); @endphp
            <div class="flex justify-between items-center py-2 border-b last:border-0">
                <div>
                    <p class="text-sm font-medium text-gray-800">{{ $med->name }}</p>
                    <p class="text-xs text-gray-400">{{ $med->company ?? 'N/A' }} · Stock: {{ $med->stock }}</p>
                </div>
                <span class="text-xs px-2 py-0.5 rounded-full
                    {{ $daysLeft <= 7 ? 'bg-red-100 text-red-700' : 'bg-yellow-100 text-yellow-700' }}">
                    {{ $daysLeft }}d left
                </span>
            </div>
            @empty
            <p class="text-sm text-gray-400">No medicines expiring soon.</p>
            @endforelse
        </div>

        {{-- Low Stock --}}
        <div class="bg-white rounded-lg shadow p-5">
            <h2 class="text-sm font-semibold mb-4 text-gray-700">Low Stock Alert</h2>
            @forelse($lowStockList as $med)
            <div class="flex justify-between items-center py-2 border-b last:border-0">
                <div>
                    <p class="text-sm font-medium text-gray-800">{{ $med->name }}</p>
                    <p class="text-xs text-gray-400">{{ $med->category->name ?? 'N/A' }}</p>
                </div>
                <span class="text-xs px-2 py-0.5 rounded-full
                    {{ $med->stock == 0 ? 'bg-red-100 text-red-700' : 'bg-yellow-100 text-yellow-700' }}">
                    {{ $med->stock == 0 ? 'Out' : $med->stock.' left' }}
                </span>
            </div>
            @empty
            <p class="text-sm text-gray-400">All medicines have sufficient stock.</p>
            @endforelse
        </div>

    </div>
</div>
@endsection