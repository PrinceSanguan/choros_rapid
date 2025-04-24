@extends('layouts.app')

@section('content')
<div class="content-main">
    <div class="content-title">Inventory Item Details</div>

    <div style="margin-bottom: 20px;">
        <a href="{{ route('inventory.index') }}" class="action-button" style="background-color: #6c757d;">Back to List</a>
        <a href="{{ route('inventory.edit', $inventory->id) }}" class="action-button" style="margin-left: 10px;">Edit Item</a>
    </div>

    <div style="max-width: 800px; margin-bottom: 30px;">
        @if($inventory->photo)
            <div style="text-align: center; margin-bottom: 20px;">
                <img src="{{ $inventory->photo }}" alt="{{ $inventory->product_title }}" style="max-width: 300px; max-height: 300px; border: 1px solid #ddd; padding: 5px; border-radius: 4px;">
            </div>
        @endif

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
            <div style="background-color: white; padding: 15px; border-radius: 4px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
                <h3 style="margin-top: 0; border-bottom: 1px solid #eee; padding-bottom: 10px; margin-bottom: 15px;">Basic Information</h3>

                <div style="margin-bottom: 10px;">
                    <strong>Product Title:</strong> {{ $inventory->product_title }}
                </div>

                <div style="margin-bottom: 10px;">
                    <strong>Category:</strong> {{ $inventory->category->name ?? 'N/A' }}
                </div>

                <div style="margin-bottom: 10px;">
                    <strong>In Stock:</strong> {{ $inventory->in_stock }}
                </div>
            </div>

            <div style="background-color: white; padding: 15px; border-radius: 4px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
                <h3 style="margin-top: 0; border-bottom: 1px solid #eee; padding-bottom: 10px; margin-bottom: 15px;">Pricing Information</h3>

                <div style="margin-bottom: 10px;">
                    <strong>Buying Price:</strong> ${{ number_format($inventory->buying_price, 2) }}
                </div>

                <div style="margin-bottom: 10px;">
                    <strong>Selling Price:</strong> ${{ number_format($inventory->selling_price, 2) }}
                </div>

                <div style="margin-bottom: 10px;">
                    <strong>Profit Margin:</strong>
                    @php
                        $profit = $inventory->selling_price - $inventory->buying_price;
                        $margin = $inventory->buying_price > 0 ? ($profit / $inventory->buying_price) * 100 : 0;
                    @endphp
                    {{ number_format($margin, 2) }}%
                    (${{ number_format($profit, 2) }} per unit)
                </div>
            </div>
        </div>

        <div style="background-color: white; padding: 15px; border-radius: 4px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); margin-bottom: 20px;">
            <h3 style="margin-top: 0; border-bottom: 1px solid #eee; padding-bottom: 10px; margin-bottom: 15px;">Description</h3>
            <p style="white-space: pre-line;">{{ $inventory->description ?: 'No description provided.' }}</p>
        </div>

        <div style="background-color: white; padding: 15px; border-radius: 4px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
            <h3 style="margin-top: 0; border-bottom: 1px solid #eee; padding-bottom: 10px; margin-bottom: 15px;">Additional Information</h3>

            <div style="margin-bottom: 10px;">
                <strong>Added By:</strong> {{ $inventory->addedBy->name ?? 'N/A' }}
            </div>

            <div style="margin-bottom: 10px;">
                <strong>Created At:</strong> {{ $inventory->created_at->format('F j, Y, g:i a') }}
            </div>

            <div style="margin-bottom: 10px;">
                <strong>Last Updated:</strong> {{ $inventory->updated_at->format('F j, Y, g:i a') }}
            </div>
        </div>
    </div>
</div>
@endsection
