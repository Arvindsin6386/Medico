@extends('layouts.app')

@section('title', 'Expiry Report')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-6">

    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-semibold">Expiry Report</h1>
        <a href="{{ route('admin.reports.index') }}" class="text-sm text-gray-500 hover:underline">← Back</a>
    </div>

    <form method="GET" class="flex gap-3 mb-6 flex-wrap">
        <select name="filter" class="border rounded px-3 py-2 text-sm">
            <option value="expiring" @selected($filter=='expiring')>Expiring Soon</option>
            <option value="expired"  @selected($filter=='expired')>Already Expired</option>
        </select>
        @if($filter === 'expiring')
        <select name="days" class="border rounded px-3 py-2 text-sm">
            <option value="7"  @selected($days==7)>Next 7 days</option>
            <option value="15" @selected($days==15)>Next 15 days</option>
            <option value="30" @selected($days==30)>Next 30 days</option>
            <option value="60" @selected($days==60)>Next 60 days</option>
        </select>
        @endif
        <button class="bg-red-600 text-white px-4 py-2 rounded text-sm">Filter</button>
    </form>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="min-w-full text-sm divide-y divide-gray-200">
            <thead class="bg-gray-50 text-xs uppercase text-gray-500">
                <tr>
                    <th class="px-5 py-3 text-left">#</th>
                    <th class="px-5 py-3 text-left">Medicine</th>
                    <th class="px-5 py-3 text-left">Company</th>
                    <th class="px-5 py-3 text-left">Category</th>
                    <th class="px-5 py-3 text-left">Stock</th>
                    <th class="px-5 py-3 text-left">Price</th>
                    <th class="px-5 py-3 text-left">Expiry Date</th>
                    <th class="px-5 py-3 text-left">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($medicines as $med)
                @php
                    $daysLeft = now()->diffInDays($med->expiry_data, false);
                @endphp
                <tr class="hover:bg-gray-50">
                    <td class="px-5 py-3 text-gray-500">{{ $loop->iteration }}</td>
                    <td class="px-5 py-3 font-medium">{{ $med->name }}</td>
                    <td class="px-5 py-3 text-gray-600">{{ $med->company ?? '—' }}</td>
                    <td class="px-5 py-3 text-gray-600">{{ $med->category->name ?? '—' }}</td>
                    <td class="px-5 py-3">{{ $med->stock }}</td>
                    <td class="px-5 py-3">₹{{ number_format($med->price) }}</td>
                    <td class="px-5 py-3">
                        {{ $med->expiry_data ? $med->expiry_data->format('d M Y') : '—' }}
                    </td>
                    <td class="px-5 py-3">
                        @if($filter === 'expired')
                            <span class="px-2 py-0.5 bg-red-100 text-red-700 rounded-full text-xs">Expired</span>
                        @elseif($daysLeft <= 7)
                            <span class="px-2 py-0.5 bg-red-100 text-red-700 rounded-full text-xs">Critical · {{ $daysLeft }}d</span>
                        @elseif($daysLeft <= 15)
                            <span class="px-2 py-0.5 bg-orange-100 text-orange-700 rounded-full text-xs">Urgent · {{ $daysLeft }}d</span>
                        @else
                            <span class="px-2 py-0.5 bg-yellow-100 text-yellow-700 rounded-full text-xs">Warning · {{ $daysLeft }}d</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="px-5 py-8 text-center text-gray-400">
                        No medicines found for this filter.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $medicines->withQueryString()->links() }}</div>
</div>
@endsection