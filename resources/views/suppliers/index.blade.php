@extends('layouts.app')

@section('content')
<div class="content-main">
    <div class="content-title">Suppliers Management</div>

    <div style="display: flex; justify-content: space-between; margin-bottom: 20px;">
        <div>
            <h2>Suppliers List</h2>
        </div>
        <div>
            <a href="{{ route('suppliers.create') }}" class="action-button">Add New Supplier</a>
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
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Status</th>
                <th>Added By</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($suppliers as $supplier)
            <tr>
                <td>{{ $supplier->name }}</td>
                <td>{{ $supplier->email }}</td>
                <td>{{ $supplier->phone ?? 'N/A' }}</td>
                <td>
                    <span style="padding: 2px 8px; border-radius: 12px; font-size: 12px; background-color: {{ $supplier->is_active ? '#d4edda' : '#f8d7da' }}; color: {{ $supplier->is_active ? '#155724' : '#721c24' }};">
                        {{ $supplier->is_active ? 'Active' : 'Inactive' }}
                    </span>
                </td>
                <td>{{ $supplier->addedBy->name ?? 'N/A' }}</td>
                <td class="action-links">
                    <a href="{{ route('suppliers.show', $supplier->id) }}" class="view">View</a> |
                    <a href="{{ route('suppliers.edit', $supplier->id) }}" class="edit">Edit</a> |
                    <a href="#" class="delete" onclick="event.preventDefault(); if(confirm('Are you sure you want to delete this supplier?')) document.getElementById('delete-form-{{ $supplier->id }}').submit();">Delete</a>
                    <form id="delete-form-{{ $supplier->id }}" action="{{ route('suppliers.destroy', $supplier->id) }}" method="POST" style="display: none;">
                        @csrf
                        @method('DELETE')
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" style="text-align: center;">No suppliers found</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="pagination" style="margin-top: 20px;">
        {{ $suppliers->links() }}
    </div>
</div>
@endsection
