@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>{{ __('Supplier Details') }}</span>
                    <div>
                        <a href="{{ route('supplier.edit', $supplier) }}" class="btn btn-sm btn-warning">Edit</a>
                        <a href="{{ route('supplier.index') }}" class="btn btn-sm btn-secondary">Back to Suppliers</a>
                    </div>
                </div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="row">
                        <div class="col-md-8">
                            <table class="table">
                                <tr>
                                    <th style="width: 200px;">Supplier Name:</th>
                                    <td>{{ $supplier->name }}</td>
                                </tr>
                                <tr>
                                    <th>Contact Person:</th>
                                    <td>{{ $supplier->contact_person ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Email:</th>
                                    <td>{{ $supplier->email ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Phone:</th>
                                    <td>{{ $supplier->phone ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Address:</th>
                                    <td>{{ $supplier->address ?? 'N/A' }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    @if($supplier->inventories->count() > 0)
                    <div class="mt-4">
                        <h5>Products Supplied</h5>
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Product</th>
                                        <th>Category</th>
                                        <th>Quantity</th>
                                        <th>Buying Price</th>
                                        <th>Selling Price</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($supplier->inventories as $item)
                                    <tr>
                                        <td>
                                            <a href="{{ route('inventory.show', $item) }}">{{ $item->product_title }}</a>
                                        </td>
                                        <td>{{ $item->category }}</td>
                                        <td>{{ $item->quantity }}</td>
                                        <td>{{ $item->formatted_buying_price }}</td>
                                        <td>{{ $item->formatted_selling_price }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @else
                    <div class="alert alert-info mt-4">
                        No products have been supplied by this supplier yet.
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
