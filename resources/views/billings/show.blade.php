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
                            <h5 class="d-inline-block mb-0">BILLING DETAILS</h5>
                        </div>
                        <div>
                            <a href="{{ route('billings.index') }}" class="btn btn-secondary">
                                <i class="fa fa-arrow-left me-1"></i> Back to List
                            </a>
                            <a href="{{ route('billings.edit', $billing) }}" class="btn btn-primary">
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
                                    <h6 class="mb-0">Billing Information</h6>
                                </div>
                                <div class="card-body">
                                    <table class="table table-bordered">
                                        <tr>
                                            <th width="40%">Invoice Number</th>
                                            <td>{{ $billing->invoice_number }}</td>
                                        </tr>
                                        <tr>
                                            <th>Amount</th>
                                            <td>${{ number_format($billing->amount, 2) }}</td>
                                        </tr>
                                        <tr>
                                            <th>Status</th>
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
                                        </tr>
                                        <tr>
                                            <th>Payment Method</th>
                                            <td>{{ $billing->payment_method }}</td>
                                        </tr>
                                        <tr>
                                            <th>Due Date</th>
                                            <td>{{ $billing->due_date ? $billing->due_date->format('M d, Y') : 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Created At</th>
                                            <td>{{ $billing->created_at->format('M d, Y H:i') }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="card mb-3">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0">Customer & Project Details</h6>
                                </div>
                                <div class="card-body">
                                    <table class="table table-bordered">
                                        <tr>
                                            <th width="40%">Customer</th>
                                            <td>
                                                @if($billing->customer)
                                                    <a href="{{ route('customers.show', $billing->customer) }}">
                                                        {{ $billing->customer->name }}
                                                    </a>
                                                @else
                                                    N/A
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Project</th>
                                            <td>
                                                @if($billing->project)
                                                    <a href="{{ route('projects.show', $billing->project) }}">
                                                        {{ $billing->project->name }}
                                                    </a>
                                                @else
                                                    N/A
                                                @endif
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>

                            <div class="card">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0">Description</h6>
                                </div>
                                <div class="card-body">
                                    <p>{{ $billing->description ?? 'No description provided.' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if($billing->notes)
                    <div class="row mt-3">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0">Internal Notes</h6>
                                </div>
                                <div class="card-body">
                                    <p>{{ $billing->notes }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
