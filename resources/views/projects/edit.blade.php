@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <h5>Edit Project</h5>
                <a href="{{ route('projects.index') }}" class="btn btn-light" id="backButton">Back to Projects</a>
            </div>

            <hr class="mt-0 mb-3">

            @if ($errors->any())
                <div class="alert alert-danger" id="errorAlert">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="alert alert-success" id="successAlert" style="display:none;">
                Project updated successfully!
            </div>

            <form method="POST" action="{{ route('projects.update', $project) }}" id="updateProjectForm">
                @csrf
                @method('PUT')

                <div class="row mb-3">
                    <div class="col-md-3">
                        <label for="name" class="form-label">Project Name</label>
                    </div>
                    <div class="col-md-5">
                        <input id="name" type="text" class="form-control bg-light @error('name') is-invalid @enderror" name="name" value="{{ old('name', $project->name) }}" required style="background-color: #ffcba4 !important;">
                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="col-md-1">
                        <label for="date" class="form-label">Date</label>
                    </div>
                    <div class="col-md-3">
                        <input id="date" type="date" class="form-control bg-light @error('date') is-invalid @enderror" name="date" value="{{ old('date', $project->date ? $project->date->format('Y-m-d') : '') }}" required style="background-color: #ffcba4 !important;">
                        @error('date')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-3">
                        <label for="location" class="form-label">Location</label>
                    </div>
                    <div class="col-md-9">
                        <input id="location" type="text" class="form-control bg-light @error('location') is-invalid @enderror" name="location" value="{{ old('location', $project->location) }}" required style="background-color: #ffcba4 !important;">
                        @error('location')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-3">
                        <label for="contractor" class="form-label">Contractor</label>
                    </div>
                    <div class="col-md-9">
                        <input id="contractor" type="text" class="form-control bg-light @error('contractor') is-invalid @enderror" name="contractor" value="{{ old('contractor', $project->contractor) }}" required style="background-color: #ffcba4 !important;">
                        @error('contractor')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-3">
                        <label for="size" class="form-label">Project Size</label>
                    </div>
                    <div class="col-md-9">
                        <input id="size" type="text" class="form-control bg-light @error('size') is-invalid @enderror" name="size" value="{{ old('size', $project->size) }}" required style="background-color: #ffcba4 !important;">
                        @error('size')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <!-- Additional fields shown in the image -->
                <div class="row mb-3">
                    <div class="col-md-3">
                        <label for="start_date" class="form-label">Start Date</label>
                    </div>
                    <div class="col-md-9">
                        <input id="start_date" type="date" class="form-control @error('start_date') is-invalid @enderror" name="start_date" value="{{ old('start_date', $project->start_date ? $project->start_date->format('Y-m-d') : '') }}">
                        @error('start_date')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-3">
                        <label for="customer_id" class="form-label">Customer</label>
                    </div>
                    <div class="col-md-9">
                        <select id="customer_id" class="form-control @error('customer_id') is-invalid @enderror" name="customer_id">
                            <option value="">Select Customer</option>
                            @foreach($customers as $customer)
                                <option value="{{ $customer->id }}" {{ (old('customer_id', $project->customer_id) == $customer->id) ? 'selected' : '' }}>
                                    {{ $customer->name }} {{ $customer->company_name ? '(' . $customer->company_name . ')' : '' }}
                                </option>
                            @endforeach
                        </select>
                        @error('customer_id')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-3">
                        <label for="project_manager" class="form-label">Project Manager</label>
                    </div>
                    <div class="col-md-9">
                        <input id="project_manager" type="text" class="form-control @error('project_manager') is-invalid @enderror" name="project_manager" value="{{ old('project_manager', $project->project_manager) }}">
                        @error('project_manager')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-3">
                        <label for="description" class="form-label">Description</label>
                    </div>
                    <div class="col-md-9">
                        <textarea id="description" class="form-control @error('description') is-invalid @enderror" name="description" rows="4">{{ old('description', $project->description) }}</textarea>
                        @error('description')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 text-end">
                        <button type="submit" class="btn btn-primary" id="updateButton">Update Project</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const form = document.getElementById('updateProjectForm');
        const successAlert = document.getElementById('successAlert');
        const errorAlert = document.getElementById('errorAlert');
        const backButton = document.getElementById('backButton');

        form.addEventListener('submit', function (e) {
            e.preventDefault();

            // Clear previous alerts
            if (errorAlert) errorAlert.style.display = 'none';

            const formData = new FormData(form);

            fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Show success message
                    successAlert.style.display = 'block';

                    // Scroll to top for user to see message
                    window.scrollTo(0, 0);

                    // Redirect to projects page after a short delay
                    setTimeout(function() {
                        window.location.href = "{{ route('projects.index') }}";
                    }, 1500);
                } else {
                    // Handle errors
                    if (data.errors) {
                        let errorHtml = '<ul class="mb-0">';
                        for (const error of Object.values(data.errors)) {
                            errorHtml += `<li>${error}</li>`;
                        }
                        errorHtml += '</ul>';

                        if (errorAlert) {
                            errorAlert.innerHTML = errorHtml;
                            errorAlert.style.display = 'block';
                        } else {
                            const newErrorAlert = document.createElement('div');
                            newErrorAlert.className = 'alert alert-danger';
                            newErrorAlert.id = 'errorAlert';
                            newErrorAlert.innerHTML = errorHtml;
                            form.parentNode.insertBefore(newErrorAlert, form);
                        }

                        window.scrollTo(0, 0);
                    }
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        });
    });
</script>
@endsection
