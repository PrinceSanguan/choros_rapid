@extends('layouts.app')

@section('content')
<div class="content-main">
    <div class="content-title">Supplier Details</div>

    <div style="margin-bottom: 20px;">
        <a href="{{ route('suppliers.index') }}" class="action-button" style="background-color: #6c757d;">Back to List</a>
        <a href="{{ route('suppliers.edit', $supplier->id) }}" class="action-button" style="margin-left: 10px;">Edit Supplier</a>
    </div>

    <div style="max-width: 800px; margin-bottom: 30px;">
        <div style="background-color: white; padding: 20px; border-radius: 4px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); margin-bottom: 20px;">
            <div style="display: flex; justify-content: space-between; margin-bottom: 15px;">
                <h2 style="margin: 0;">{{ $supplier->name }}</h2>
                <span style="padding: 2px 8px; border-radius: 12px; font-size: 12px; background-color: {{ $supplier->is_active ? '#d4edda' : '#f8d7da' }}; color: {{ $supplier->is_active ? '#155724' : '#721c24' }};">
                    {{ $supplier->is_active ? 'Active' : 'Inactive' }}
                </span>
            </div>

            <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px; margin-bottom: 20px;">
                <div>
                    <h3 style="margin-top: 0; font-size: 16px; border-bottom: 1px solid #eee; padding-bottom: 5px; margin-bottom: 10px;">Contact Information</h3>

                    <div style="margin-bottom: 10px;">
                        <strong>Email:</strong> {{ $supplier->email }}
                    </div>

                    <div style="margin-bottom: 10px;">
                        <strong>Phone:</strong> {{ $supplier->phone ?: 'N/A' }}
                    </div>

                    <div style="margin-bottom: 10px;">
                        <strong>Address:</strong> {{ $supplier->address ?: 'N/A' }}
                    </div>
                </div>

                <div>
                    <h3 style="margin-top: 0; font-size: 16px; border-bottom: 1px solid #eee; padding-bottom: 5px; margin-bottom: 10px;">Additional Information</h3>

                    <div style="margin-bottom: 10px;">
                        <strong>Added By:</strong> {{ $supplier->addedBy->name ?? 'N/A' }}
                    </div>

                    <div style="margin-bottom: 10px;">
                        <strong>Created At:</strong> {{ $supplier->created_at->format('F j, Y, g:i a') }}
                    </div>

                    <div style="margin-bottom: 10px;">
                        <strong>Last Updated:</strong> {{ $supplier->updated_at->format('F j, Y, g:i a') }}
                    </div>
                </div>
            </div>

            <div>
                <h3 style="margin-top: 0; font-size: 16px; border-bottom: 1px solid #eee; padding-bottom: 5px; margin-bottom: 10px;">Description</h3>
                <p style="white-space: pre-line;">{{ $supplier->description ?: 'No description provided.' }}</p>
            </div>
        </div>

        <div style="background-color: white; padding: 20px; border-radius: 4px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
            <h3 style="margin-top: 0; font-size: 18px; margin-bottom: 15px;">Recent Orders/Products</h3>

            <p>Connect supplier to products here in future updates.</p>

            <!-- Future feature: Add supplier products or orders listing here -->
            <div style="text-align: center; padding: 20px; background-color: #f8f9fa; border-radius: 4px;">
                <p style="color: #6c757d;">No products or orders data available for this supplier yet.</p>
            </div>
        </div>
    </div>
</div>
@endsection
