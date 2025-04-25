@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <i class="fa fa-money-bill me-2"></i>
                            <h5 class="d-inline-block mb-0">BILLING TRANSACTIONS</h5>
                        </div>
                        <div>
                            <a href="{{ route('billings.create') }}" class="btn btn-primary">
                                <i class="fa fa-plus-circle me-1"></i> Add New Billing
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
                                    <th>Invoice #</th>
                                    <th>Project</th>
                                    <th>Customer</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                    <th>Due Date</th>
                                    <th width="150">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($billings as $billing)
                                <tr>
                                    <td>{{ $billing->id }}</td>
                                    <td>{{ $billing->invoice_number }}</td>
                                    <td>{{ $billing->project ? $billing->project->name : 'N/A' }}</td>
                                    <td>{{ $billing->customer ? $billing->customer->name : 'N/A' }}</td>
                                    <td>${{ number_format($billing->amount, 2) }}</td>
                                    <td>
                                        @php
                                            $statusClass = [
                                                'pending' => 'bg-warning',
                                                'paid' => 'bg-success',
                                                'overdue' => 'bg-danger',
                                                'cancelled' => 'bg-secondary'
                                            ];
                                        @endphp
                                        <span class="badge {{ $statusClass[$billing->status] ?? 'bg-info' }}">
                                            {{ ucfirst($billing->status) }}
                                        </span>
                                    </td>
                                    <td>{{ $billing->due_date ? $billing->due_date->format('M d, Y') : 'N/A' }}</td>
                                    <td>
                                        <a href="{{ route('billings.show', $billing) }}" class="btn btn-sm btn-info">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                        <a href="{{ route('billings.edit', $billing) }}" class="btn btn-sm btn-primary">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        <button type="button" class="btn btn-sm btn-danger"
                                                data-bs-toggle="modal"
                                                data-bs-target="#deleteModal{{ $billing->id }}">
                                            <i class="fa fa-trash"></i>
                                        </button>

                                        <!-- Delete Modal -->
                                        <div class="modal fade" id="deleteModal{{ $billing->id }}" tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Confirm Delete</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>Are you sure you want to delete invoice <strong>{{ $billing->invoice_number }}</strong>?</p>
                                                        <p class="text-danger"><small>This action cannot be undone.</small></p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                        <form action="{{ route('billings.destroy', $billing) }}" method="POST" class="d-inline">
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
                                            <i class="fa fa-file-invoice-dollar fa-3x text-muted mb-3"></i>
                                            <h5>No billing transactions found</h5>
                                            <p class="text-muted">Start by adding a new billing transaction</p>
                                            <a href="{{ route('billings.create') }}" class="btn btn-primary mt-2">
                                                <i class="fa fa-plus-circle me-1"></i> Add New Billing
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-center mt-4">
                        {{ $billings->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
