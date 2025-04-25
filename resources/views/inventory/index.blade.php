@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <i class="fa fa-cubes me-2"></i>
                            <h5 class="d-inline-block mb-0">INVENTORY MANAGEMENT</h5>
                        </div>
                        <div>
                            <a href="{{ route('inventory.create') }}" class="btn btn-primary">
                                <i class="fa fa-plus-circle me-1"></i> Add New Product
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>ID</th>
                                    <th>Product</th>
                                    <th>Category</th>
                                    <th>Quantity</th>
                                    <th>In Stock</th>
                                    <th>Buying Price</th>
                                    <th>Selling Price</th>
                                    <th>Date Added</th>
                                    <th width="150">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($inventories as $item)
                                <tr>
                                    <td>{{ $item->id }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="me-2" style="width: 40px; height: 40px; overflow: hidden;">
                                                @if($item->photo)
                                                    <img src="{{ asset('storage/' . $item->photo) }}"
                                                        alt="{{ $item->product_title }}"
                                                        style="width: 100%; height: 100%; object-fit: cover;"
                                                        class="rounded">
                                                @else
                                                    <div class="bg-light rounded d-flex align-items-center justify-content-center"
                                                        style="width: 100%; height: 100%;">
                                                        <i class="fa fa-image text-muted"></i>
                                                    </div>
                                                @endif
                                            </div>
                                            <span>{{ $item->product_title }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-info">{{ $item->category }}</span>
                                    </td>
                                    <td>{{ $item->quantity }}</td>
                                    <td>
                                        @if($item->in_stock > 0)
                                            <span class="badge bg-success">{{ $item->in_stock }} in stock</span>
                                        @else
                                            <span class="badge bg-danger">Out of stock</span>
                                        @endif
                                    </td>
                                    <td>{!! str_replace('$', '<span class="naira-symbol">$</span>', $item->formatted_buying_price) !!}</td>
                                    <td>{!! str_replace('$', '<span class="naira-symbol">$</span>', $item->formatted_selling_price) !!}</td>
                                    <td>{{ $item->created_at->format('M d, Y') }}</td>
                                    <td>
                                        <a href="{{ route('inventory.show', $item) }}" class="btn btn-sm btn-info">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                        <a href="{{ route('inventory.edit', $item) }}" class="btn btn-sm btn-primary">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        <button type="button" class="btn btn-sm btn-danger"
                                                data-bs-toggle="modal"
                                                data-bs-target="#deleteModal{{ $item->id }}">
                                            <i class="fa fa-trash"></i>
                                        </button>

                                        <!-- Delete Modal -->
                                        <div class="modal fade" id="deleteModal{{ $item->id }}" tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Confirm Delete</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>Are you sure you want to delete <strong>{{ $item->product_title }}</strong>?</p>
                                                        <p class="text-danger"><small>This action cannot be undone.</small></p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                        <form action="{{ route('inventory.destroy', $item) }}" method="POST" class="d-inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger">Delete</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="9" class="text-center py-4">
                                        <div class="d-flex flex-column align-items-center">
                                            <i class="fa fa-box-open fa-3x text-muted mb-3"></i>
                                            <h5>No products found</h5>
                                            <p class="text-muted">Start by adding products to your inventory</p>
                                            <a href="{{ route('inventory.create') }}" class="btn btn-primary mt-2">
                                                <i class="fa fa-plus-circle me-1"></i> Add New Product
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-center mt-4">
                        {{ $inventories->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .naira-symbol {
        font-family: Arial, sans-serif;
        font-weight: bold;
    }
</style>
@endsection
