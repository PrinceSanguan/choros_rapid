@extends('layouts.app')

@section('content')
<div class="content-main">
    <div class="content-title">Add New Supplier</div>

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

    <form action="{{ route('suppliers.store') }}" method="POST" style="max-width: 800px;">
        @csrf
        <div style="margin-bottom: 15px;">
            <label for="name" style="display: block; margin-bottom: 5px; font-weight: 500;">Supplier Name:</label>
            <input type="text" name="name" id="name" value="{{ old('name') }}" required
                style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
        </div>

        <div style="margin-bottom: 15px;">
            <label for="email" style="display: block; margin-bottom: 5px; font-weight: 500;">Email:</label>
            <input type="email" name="email" id="email" value="{{ old('email') }}" required
                style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
        </div>

        <div style="margin-bottom: 15px;">
            <label for="phone" style="display: block; margin-bottom: 5px; font-weight: 500;">Phone:</label>
            <input type="text" name="phone" id="phone" value="{{ old('phone') }}"
                style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
        </div>

        <div style="margin-bottom: 15px;">
            <label for="address" style="display: block; margin-bottom: 5px; font-weight: 500;">Address:</label>
            <textarea name="address" id="address" rows="3"
                style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">{{ old('address') }}</textarea>
        </div>

        <div style="margin-bottom: 15px;">
            <label for="description" style="display: block; margin-bottom: 5px; font-weight: 500;">Description:</label>
            <textarea name="description" id="description" rows="4"
                style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">{{ old('description') }}</textarea>
        </div>

        <div style="margin-top: 20px;">
            <button type="submit" class="action-button" style="padding: 10px 20px;">Save Supplier</button>
        </div>
    </form>
</div>
@endsection
