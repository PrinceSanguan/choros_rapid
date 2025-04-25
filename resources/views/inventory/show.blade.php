@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <i class="fa fa-cube me-2"></i>
                            <h5 class="d-inline-block mb-0">PRODUCT DETAILS</h5>
                        </div>
                        <div>
                            <a href="{{ route('inventory.index') }}" class="btn btn-sm btn-secondary">
                                <i class="fa fa-arrow-left"></i> Back to Inventory
                            </a>
                            <a href="{{ route('inventory.edit', $inventory) }}" class="btn btn-sm btn-primary">
                                <i class="fa fa-edit"></i> Edit
                            </a>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 mb-4">
                            @if($inventory->photo)
                                <img src="{{ asset('storage/' . $inventory->photo) }}"
                                    alt="{{ $inventory->product_title }}"
                                    class="img-fluid rounded">
                            @else
                                <div class="text-center p-5 bg-light rounded">
                                    <i class="fa fa-image fa-3x text-muted"></i>
                                    <p class="mt-2 text-muted">No image available</p>
                                </div>
                            @endif
                        </div>
                        <div class="col-md-8">
                            <h4>{{ $inventory->product_title }}</h4>
                            <div class="badge bg-info mb-3">{{ $inventory->category }}</div>

                            @if($inventory->description)
                            <div class="mb-4">
                                <h6>Description</h6>
                                <p>{{ $inventory->description }}</p>
                            </div>
                            @endif

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <h6>Stock Information</h6>
                                    <table class="table table-borderless table-sm">
                                        <tr>
                                            <td>Quantity:</td>
                                            <td><strong>{{ $inventory->quantity }}</strong></td>
                                        </tr>
                                        <tr>
                                            <td>In Stock:</td>
                                            <td>
                                                <strong>{{ $inventory->in_stock }}</strong>
                                                @if($inventory->in_stock > 0)
                                                    <span class="badge bg-success ms-2">Available</span>
                                                @else
                                                    <span class="badge bg-danger ms-2">Out of Stock</span>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Date Added:</td>
                                            <td>{{ $inventory->created_at->format('M d, Y') }}</td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="col-md-6">
                                    <h6>Price Information</h6>
                                    <table class="table table-borderless table-sm">
                                        <tr>
                                            <td>Buying Price:</td>
                                            <td><strong>{{ $inventory->formatted_buying_price }}</strong></td>
                                        </tr>
                                        <tr>
                                            <td>Selling Price:</td>
                                            <td><strong>{{ $inventory->formatted_selling_price }}</strong></td>
                                        </tr>
                                        <tr>
                                            <td>Profit Margin:</td>
                                            <td>
                                                <strong>{{ $inventory->profit_margin }}</strong>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>

                            @if($inventory->supplier)
                            <div class="row">
                                <div class="col-md-12">
                                    <h6>Supplier Information</h6>
                                    <table class="table table-borderless table-sm">
                                        <tr>
                                            <td width="150">Supplier Name:</td>
                                            <td><strong>{{ $inventory->supplier->name }}</strong></td>
                                        </tr>
                                        <tr>
                                            <td>Contact Person:</td>
                                            <td>{{ $inventory->supplier->contact_person ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <td>Contact Info:</td>
                                            <td>
                                                @if($inventory->supplier->email)
                                                    <i class="fa fa-envelope me-1"></i> {{ $inventory->supplier->email }}
                                                @endif
                                                @if($inventory->supplier->email && $inventory->supplier->phone)
                                                    <span class="mx-2">|</span>
                                                @endif
                                                @if($inventory->supplier->phone)
                                                    <i class="fa fa-phone me-1"></i> {{ $inventory->supplier->phone }}
                                                @endif
                                                @if(!$inventory->supplier->email && !$inventory->supplier->phone)
                                                    N/A
                                                @endif
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
