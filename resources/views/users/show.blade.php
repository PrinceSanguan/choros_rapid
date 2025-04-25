@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">User Details</h5>
                        <div>
                            <a href="{{ route('users.edit', $user) }}" class="btn btn-primary">Edit</a>
                            <a href="{{ route('users.index') }}" class="btn btn-secondary">Back to Users</a>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-4 font-weight-bold">ID:</div>
                        <div class="col-md-8">{{ $user->id }}</div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4 font-weight-bold">Name:</div>
                        <div class="col-md-8">{{ $user->name }}</div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4 font-weight-bold">Email:</div>
                        <div class="col-md-8">{{ $user->email }}</div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4 font-weight-bold">Position:</div>
                        <div class="col-md-8">{{ ucfirst($user->position) }}</div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4 font-weight-bold">Created At:</div>
                        <div class="col-md-8">{{ $user->created_at->format('F d, Y H:i A') }}</div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4 font-weight-bold">Last Updated:</div>
                        <div class="col-md-8">{{ $user->updated_at->format('F d, Y H:i A') }}</div>
                    </div>

                    <div class="mt-4">
                        <form action="{{ route('users.destroy', $user) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this user?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete User</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
