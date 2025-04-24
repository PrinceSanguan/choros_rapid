@extends('layouts.app')

@section('content')
<div class="content-main">
    <div class="content-title">Add New Inventory Item</div>

    <div style="margin-bottom: 20px;">
        <a href="{{ route('inventory.index') }}" class="action-button" style="background-color: #6c757d;">Back to List</a>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger" style="padding: 10px; background-color: #f8d7da; border-color: #f5c6cb; color: #721c24; margin-bottom: 15px; border-radius: 4px;">
            <ul style="margin: 0; padding-left: 20px;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('inventory.store') }}" method="POST" enctype="multipart/form-data" style="max-width: 800px;">
        @csrf
        <div style="margin-bottom: 15px;">
            <label for="product_title" style="display: block; margin-bottom: 5px; font-weight: 500;">Product Title:</label>
            <input type="text" name="product_title" id="product_title" value="{{ old('product_title') }}" required
                style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
        </div>

        <div style="margin-bottom: 15px;">
            <label for="category_id" style="display: block; margin-bottom: 5px; font-weight: 500;">Category:</label>
            <select name="category_id" id="category_id" required
                style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
                <option value="">Select Category</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div style="margin-bottom: 15px;">
            <label for="in_stock" style="display: block; margin-bottom: 5px; font-weight: 500;">In Stock:</label>
            <input type="number" name="in_stock" id="in_stock" value="{{ old('in_stock', 0) }}" min="0" required
                style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
        </div>

        <div style="margin-bottom: 15px;">
            <label for="buying_price" style="display: block; margin-bottom: 5px; font-weight: 500;">Buying Price ($):</label>
            <input type="number" name="buying_price" id="buying_price" value="{{ old('buying_price', 0) }}" min="0" step="0.01" required
                style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
        </div>

        <div style="margin-bottom: 15px;">
            <label for="selling_price" style="display: block; margin-bottom: 5px; font-weight: 500;">Selling Price ($):</label>
            <input type="number" name="selling_price" id="selling_price" value="{{ old('selling_price', 0) }}" min="0" step="0.01" required
                style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
        </div>

        <div style="margin-bottom: 15px;">
            <label for="description" style="display: block; margin-bottom: 5px; font-weight: 500;">Description:</label>
            <textarea name="description" id="description" rows="4"
                style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">{{ old('description') }}</textarea>
        </div>

        <div style="margin-bottom: 15px;">
            <label for="photo" style="display: block; margin-bottom: 5px; font-weight: 500;">Product Photo:</label>
            <input type="file" name="photo" id="photo" accept="image/*"
                style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
        </div>

        <div style="margin-top: 20px;">
            <button type="submit" class="action-button" style="padding: 10px 20px;">Save Inventory Item</button>
        </div>
    </form>
</div>
@endsection
