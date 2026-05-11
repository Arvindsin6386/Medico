@extends('layouts.app')

@section('title', 'Purchase Reports')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">

            {{-- ✅ Back Button --}}
            <div class="mb-3">
                <a href="{{ url()->previous() }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Back
                </a>
            </div>

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Purchase Reports</h3>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Medicine</th>
                                <th>Company</th>
                                <th>Stock</th>
                                <th>Price</th>
                                <th>Expiry Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($medicines as $medicine)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $medicine->name }}</td>
                                <td>{{ $medicine->company }}</td>
                                <td>{{ $medicine->stock }}</td>
                                <td>{{ $medicine->price }}</td>
                                <td>{{ $medicine->expiry_date }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center">No records found.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection