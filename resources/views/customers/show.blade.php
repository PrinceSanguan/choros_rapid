@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <i class="fa fa-user me-2"></i>
                            <h5 class="d-inline-block mb-0">CUSTOMER DETAILS</h5>
                        </div>
                        <div>
                            <a href="{{ route('customers.index') }}" class="btn btn-secondary">
                                <i class="fa fa-arrow-left me-1"></i> Back to List
                            </a>
                            <a href="{{ route('customers.edit', $customer) }}" class="btn btn-primary">
                                <i class="fa fa-edit me-1"></i> Edit
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card mb-3">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0">Customer Information</h6>
                                </div>
                                <div class="card-body">
                                    <table class="table table-bordered">
                                        <tr>
                                            <th width="40%">Name</th>
                                            <td>{{ $customer->name }}</td>
                                        </tr>
                                        <tr>
                                            <th>Company</th>
                                            <td>{{ $customer->company_name ?: 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Contact Person</th>
                                            <td>{{ $customer->contact_person ?: 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Email</th>
                                            <td>{{ $customer->email ?: 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Phone</th>
                                            <td>{{ $customer->phone ?: 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Address</th>
                                            <td>{{ $customer->address ?: 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Created</th>
                                            <td>{{ $customer->created_at->format('M d, Y H:i') }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0">Customer Projects</h6>
                                </div>
                                <div class="card-body">
                                    @if ($customer->projects->count() > 0)
                                    <div class="table-responsive">
                                        <table class="table table-hover">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>Project</th>
                                                    <th>Status</th>
                                                    <th>Date</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($customer->projects as $project)
                                                <tr>
                                                    <td>{{ $project->name }}</td>
                                                    <td>
                                                        @if(isset($project->status))
                                                        <span class="badge {{ $project->status == 'completed' ? 'bg-success' : ($project->status == 'in-progress' ? 'bg-primary' : 'bg-warning') }}">
                                                            {{ ucfirst($project->status) }}
                                                        </span>
                                                        @else
                                                        <span class="badge bg-secondary">Not Set</span>
                                                        @endif
                                                    </td>
                                                    <td>{{ $project->date ? $project->date->format('M d, Y') : 'N/A' }}</td>
                                                    <td>
                                                        <a href="{{ route('projects.show', $project) }}" class="btn btn-sm btn-info">
                                                            <i class="fa fa-eye"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    @else
                                    <div class="text-center py-3">
                                        <i class="fa fa-project-diagram fa-3x text-muted mb-3"></i>
                                        <p>No projects found for this customer.</p>
                                    </div>
                                    @endif
                                </div>
                            </div>

                            <div class="card mt-3">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0">Billing Transactions</h6>
                                </div>
                                <div class="card-body">
                                    @if ($customer->billingTransactions->count() > 0)
                                    <div class="table-responsive">
                                        <table class="table table-hover">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>Invoice #</th>
                                                    <th>Amount</th>
                                                    <th>Status</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($customer->billingTransactions as $billing)
                                                <tr>
                                                    <td>{{ $billing->invoice_number }}</td>
                                                    <td>₱{{ number_format($billing->amount, 2) }}</td>
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
                                                    <td>
                                                        <a href="{{ route('billings.show', $billing) }}" class="btn btn-sm btn-info">
                                                            <i class="fa fa-eye"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    @else
                                    <div class="text-center py-3">
                                        <i class="fa fa-file-invoice-dollar fa-3x text-muted mb-3"></i>
                                        <p>No billing transactions found for this customer.</p>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
