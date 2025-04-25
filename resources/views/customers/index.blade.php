@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <i class="fa fa-users me-2"></i>
                            <h5 class="d-inline-block mb-0">CUSTOMERS</h5>
                        </div>
                        <div>
                            <a href="{{ route('customers.create') }}" class="btn btn-primary">
                                <i class="fa fa-plus-circle me-1"></i> Add New Customer
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
                                    <th>Name</th>
                                    <th>Company</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Projects</th>
                                    <th>Created</th>
                                    <th width="150">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($customers as $customer)
                                <tr>
                                    <td>{{ $customer->id }}</td>
                                    <td>{{ $customer->name }}</td>
                                    <td>{{ $customer->company_name ?: 'N/A' }}</td>
                                    <td>{{ $customer->email ?: 'N/A' }}</td>
                                    <td>{{ $customer->phone ?: 'N/A' }}</td>
                                    <td>{{ $customer->projects->count() }}</td>
                                    <td>{{ $customer->created_at->format('M d, Y') }}</td>
                                    <td>
                                        <a href="{{ route('customers.show', $customer) }}" class="btn btn-sm btn-info">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                        <a href="{{ route('customers.edit', $customer) }}" class="btn btn-sm btn-primary">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        <button type="button" class="btn btn-sm btn-danger"
                                                data-bs-toggle="modal"
                                                data-bs-target="#deleteModal{{ $customer->id }}">
                                            <i class="fa fa-trash"></i>
                                        </button>

                                        <!-- Delete Modal -->
                                        <div class="modal fade" id="deleteModal{{ $customer->id }}" tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Confirm Delete</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>Are you sure you want to delete customer <strong>{{ $customer->name }}</strong>?</p>
                                                        <p class="text-danger"><small>This will also delete all related records.</small></p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                        <form action="{{ route('customers.destroy', $customer) }}" method="POST" class="d-inline">
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
                                    <td colspan="8" class="text-center py-4">
                                        <div class="d-flex flex-column align-items-center">
                                            <i class="fa fa-users fa-3x text-muted mb-3"></i>
                                            <h5>No customers found</h5>
                                            <p class="text-muted">Start by adding a new customer</p>
                                            <a href="{{ route('customers.create') }}" class="btn btn-primary mt-2">
                                                <i class="fa fa-plus-circle me-1"></i> Add New Customer
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-center mt-4">
                        {{ $customers->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
