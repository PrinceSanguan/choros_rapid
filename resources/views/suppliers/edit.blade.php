@extends('layouts.app')

@section('content')
<div class="content-main">
    <div class="content-title">Edit Supplier</div>

    <div style="margin-bottom: 20px;">
        <a href="{{ route('suppliers.index') }}" class="action-button" style="background-color: #6c757d;">Back to List</a>
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

    <form action="{{ route('suppliers.update', $supplier->id) }}" method="POST" style="max-width: 800px;">
        @csrf
        @method('PUT')

        <div style="margin-bottom: 15px;">
            <label for="name" style="display: block; margin-bottom: 5px; font-weight: 500;">Supplier Name:</label>
            <input type="text" name="name" id="name" value="{{ old('name', $supplier->name) }}" required
                style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
        </div>

        <div style="margin-bottom: 15px;">
            <label for="email" style="display: block; margin-bottom: 5px; font-weight: 500;">Email:</label>
            <input type="email" name="email" id="email" value="{{ old('email', $supplier->email) }}" required
                style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
        </div>

        <div style="margin-bottom: 15px;">
            <label for="phone" style="display: block; margin-bottom: 5px; font-weight: 500;">Phone:</label>
            <input type="text" name="phone" id="phone" value="{{ old('phone', $supplier->phone) }}"
                style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
        </div>

        <div style="margin-bottom: 15px;">
            <label for="address" style="display: block; margin-bottom: 5px; font-weight: 500;">Address:</label>
            <textarea name="address" id="address" rows="3"
                style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">{{ old('address', $supplier->address) }}</textarea>
        </div>

        <div style="margin-bottom: 15px;">
            <label for="description" style="display: block; margin-bottom: 5px; font-weight: 500;">Description:</label>
            <textarea name="description" id="description" rows="4"
                style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">{{ old('description', $supplier->description) }}</textarea>
        </div>

        <div style="margin-bottom: 15px;">
            <label style="display: block; margin-bottom: 5px; font-weight: 500;">Status:</label>
            <div style="display: flex; gap: 20px;">
                <div>
                    <input type="radio" id="active" name="is_active" value="1" {{ (old('is_active', $supplier->is_active) ? 'checked' : '') }}>
                    <label for="active">Active</label>
                </div>
                <div>
                    <input type="radio" id="inactive" name="is_active" value="0" {{ (!old('is_active', $supplier->is_active) ? 'checked' : '') }}>
                    <label for="inactive">Inactive</label>
                </div>
            </div>
        </div>

        <div style="margin-top: 20px;">
            <button type="submit" class="action-button" style="padding: 10px 20px;">Update Supplier</button>
        </div>
    </form>
</div>
@endsection
