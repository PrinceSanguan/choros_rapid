@extends('layouts.app')

@section('content')
<div class="form-container">
    <h2>Edit User</h2>

    <div class="card">
        <div class="card-header">Edit User Information</div>
        <div class="card-body">
            <form method="POST" action="{{ route('users.update', $user->id) }}">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="name">Fullname</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $user->name) }}" required>
                    @error('name')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="email">Username</label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $user->email) }}" required>
                    @error('email')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password">Password (leave empty to keep current)</label>
                    <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password">
                    @error('password')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password_confirmation">Confirm Password</label>
                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
                </div>

                <div class="form-group">
                    <label for="position">Position</label>
                    <select class="form-control @error('position') is-invalid @enderror" id="position" name="position" required>
                        <option value="">Select Position</option>
                        @foreach($positions as $label => $value)
                            <option value="{{ $value }}" {{ old('position', $user->position) == $value ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                    @error('position')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-actions">
                    <button type="submit" class="action-button">Update</button>
                    <a href="{{ route('users.index') }}" class="btn-cancel">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .form-container {
        width: 100%;
        padding-left: 20px;
    }

    .card {
        max-width: 600px;
        margin-bottom: 20px;
        border: 1px solid #ddd;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        display: block;
        margin-bottom: 5px;
        font-weight: 500;
        color: #333;
    }

    .form-control {
        width: 100%;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 4px;
        background-color: #f5f8ff;
        height: 42px;
        box-sizing: border-box;
    }

    .form-control.is-invalid {
        border-color: #dc3545;
    }

    .invalid-feedback {
        color: #dc3545;
        font-size: 14px;
        margin-top: 5px;
        display: block;
    }

    .form-actions {
        margin-top: 30px;
        display: flex;
        gap: 10px;
    }

    .action-button {
        background-color: #FF8000;
        color: white;
        border: none;
        padding: 8px 20px;
        border-radius: 4px;
        cursor: pointer;
        font-weight: 500;
        text-decoration: none;
    }

    .action-button:hover {
        background-color: #e67300;
    }

    .btn-cancel {
        background-color: #f8f9fa;
        border: 1px solid #ddd;
        color: #333;
        padding: 8px 20px;
        border-radius: 4px;
        text-decoration: none;
        font-weight: 500;
        display: inline-block;
    }

    .btn-cancel:hover {
        background-color: #e9ecef;
    }

    .card-header {
        background-color: #f8f9fa;
        font-weight: 600;
        padding: 15px 20px;
    }

    h2 {
        margin-bottom: 20px;
        font-size: 24px;
        font-weight: 600;
    }
</style>
@endsection
 