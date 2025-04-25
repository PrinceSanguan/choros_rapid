@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>{{ __('Suppliers') }}</span>
                    <a href="{{ route('supplier.create') }}" class="btn btn-sm btn-primary">Add New Supplier</a>
                </div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Contact Person</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($suppliers as $supplier)
                                    <tr>
                                        <td>{{ $supplier->name }}</td>
                                        <td>{{ $supplier->contact_person }}</td>
                                        <td>{{ $supplier->email }}</td>
                                        <td>{{ $supplier->phone }}</td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('supplier.show', $supplier) }}" class="btn btn-sm btn-info">View</a>
                                                <a href="{{ route('supplier.edit', $supplier) }}" class="btn btn-sm btn-warning">Edit</a>
                                                <form action="{{ route('supplier.destroy', $supplier) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this supplier?');" style="display: inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center">No suppliers found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-center mt-4">
                        {{ $suppliers->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
