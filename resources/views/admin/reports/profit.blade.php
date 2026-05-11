

@extends('layouts.app')

@section('title', 'Profit & Loss')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-6">

    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-semibold">Profit & Loss Report</h1>
        <a href="{{ route('admin.reports.index') }}" class="text-sm text-gray-500 hover:underline">← Back</a>
    </div>

    <form method="GET" class="flex gap-3 mb-6">
        <select name="month" class="border rounded px-3 py-2 text-sm">
            @foreach(range(1,12) as $m)
                <option value="{{ $m }}" @selected($month == $m)>{{ date('F', mktime(0,0,0,$m,1)) }}</option>
            @endforeach
        </select>
        <select name="year" class="border rounded px-3 py-2 text-sm">
            @foreach(range(now()->year, now()->year - 3) as $y)
                <option value="{{ $y }}" @selected($year == $y)>{{ $y }}</option>
            @endforeach
        </select>
        <button class="bg-purple-600 text-white px-4 py-2 rounded text-sm">View</button>
    </form>

    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-green-50 rounded-lg p-4">
            <p class="text-xs text-green-600 mb-1">Total Revenue</p>
            <p class="text-xl font-semibold text-green-800">₹{{ number_format($revenue) }}</p>
        </div>
        <div class="bg-red-50 rounded-lg p-4">
            <p class="text-xs text-red-600 mb-1">Total Purchase Cost</p>
            <p class="text-xl font-semibold text-red-800">₹{{ number_format($cost) }}</p>
        </div>
        <div class="{{ $profit >= 0 ? 'bg-blue-50' : 'bg-red-50' }} rounded-lg p-4">
            <p class="text-xs {{ $profit >= 0 ? 'text-blue-600' : 'text-red-600' }} mb-1">
                Net {{ $profit >= 0 ? 'Profit' : 'Loss' }}
            </p>
            <p class="text-xl font-semibold {{ $profit >= 0 ? 'text-blue-800' : 'text-red-800' }}">
                ₹{{ number_format(abs($profit)) }}
            </p>
        </div>
        <div class="bg-purple-50 rounded-lg p-4">
            <p class="text-xs text-purple-600 mb-1">Profit Margin</p>
            <p class="text-xl font-semibold text-purple-800">{{ $margin }}%</p>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-sm font-semibold mb-4">Detailed Summary</h2>
        <table class="w-full text-sm">
            <tr class="border-b">
                <td class="py-3 text-gray-600">Sales Revenue</td>
                <td class="py-3 text-right font-medium text-green-700">+ ₹{{ number_format($revenue) }}</td>
            </tr>
            <tr class="border-b">
                <td class="py-3 text-gray-600">Purchase / Stock Cost</td>
                <td class="py-3 text-right font-medium text-red-700">− ₹{{ number_format($cost) }}</td>
            </tr>
            <tr class="border-t-2">
                <td class="py-3 font-semibold text-gray-800">Net Profit / Loss</td>
                <td class="py-3 text-right text-lg font-bold {{ $profit >= 0 ? 'text-blue-700' : 'text-red-700' }}">
                    ₹{{ number_format(abs($profit)) }}
                    @if($profit < 0) <span class="text-sm">(Loss)</span> @endif
                </td>
            </tr>
            <tr>
                <td class="py-2 text-gray-500 text-xs">Profit Margin</td>
                <td class="py-2 text-right text-xs text-gray-500">{{ $margin }}%</td>
            </tr>
        </table>
    </div>
</div>
@endsection