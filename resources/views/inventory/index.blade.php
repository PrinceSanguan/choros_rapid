@extends('layouts.app')

@section('content')
<div class="content-main">
    <div class="content-title">Inventory Management</div>

    <div style="display: flex; justify-content: space-between; margin-bottom: 20px;">
        <div>
            <h2>Product List</h2>
        </div>
        <div>
            <a href="{{ route('inventory.create') }}" class="action-button">Add New Product</a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success" style="padding: 10px; background-color: #d4edda; border-color: #c3e6cb; color: #155724; margin-bottom: 15px; border-radius: 4px;">
            {{ session('success') }}
        </div>
    @endif

    <table class="data-table">
        <thead>
            <tr>
                <th>Product Title</th>
                <th>Category</th>
                <th>In Stock</th>
                <th>Buying Price</th>
                <th>Selling Price</th>
                <th>Added By</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($inventory as $item)
            <tr>
                <td>{{ $item->product_title }}</td>
                <td>{{ $item->category->name ?? 'N/A' }}</td>
                <td>{{ $item->in_stock }}</td>
                <td>${{ number_format($item->buying_price, 2) }}</td>
                <td>${{ number_format($item->selling_price, 2) }}</td>
                <td>{{ $item->addedBy->name ?? 'N/A' }}</td>
                <td class="action-links">
                    <a href="{{ route('inventory.show', $item->id) }}" class="view">View</a> |
                    <a href="{{ route('inventory.edit', $item->id) }}" class="edit">Edit</a> |
                    <a href="#" class="delete" onclick="event.preventDefault(); if(confirm('Are you sure you want to delete this item?')) document.getElementById('delete-form-{{ $item->id }}').submit();">Delete</a>
                    <form id="delete-form-{{ $item->id }}" action="{{ route('inventory.destroy', $item->id) }}" method="POST" style="display: none;">
                        @csrf
                        @method('DELETE')
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" style="text-align: center;">No inventory items found</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="pagination" style="margin-top: 20px;">
        {{ $inventory->links() }}
    </div>
</div>
@endsection
