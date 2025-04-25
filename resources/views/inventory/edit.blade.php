@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-white">
                    <div class="d-flex align-items-center">
                        <i class="fa fa-edit me-2"></i>
                        <h5 class="mb-0">EDIT PRODUCT</h5>
                    </div>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('inventory.update', $inventory) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row mb-4">
                            <div class="col-md-12">
                                <div class="input-group">
                                    <span class="input-group-text" id="basic-product-title">
                                        <i class="fa fa-cube"></i>
                                    </span>
                                    <input type="text" class="form-control @error('product_title') is-invalid @enderror"
                                        name="product_title" value="{{ old('product_title', $inventory->product_title) }}"
                                        placeholder="Product Title" aria-label="Product Title"
                                        aria-describedby="basic-product-title">
                                    @error('product_title')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <select class="form-select @error('category') is-invalid @enderror"
                                    name="category" aria-label="Select Product Category">
                                    <option value="">Select Product Category</option>
                                    <option value="Electronics" {{ old('category', $inventory->category) == 'Electronics' ? 'selected' : '' }}>Electronics</option>
                                    <option value="Clothing" {{ old('category', $inventory->category) == 'Clothing' ? 'selected' : '' }}>Clothing</option>
                                    <option value="Food" {{ old('category', $inventory->category) == 'Food' ? 'selected' : '' }}>Food</option>
                                    <option value="Furniture" {{ old('category', $inventory->category) == 'Furniture' ? 'selected' : '' }}>Furniture</option>
                                    <option value="Other" {{ old('category', $inventory->category) == 'Other' ? 'selected' : '' }}>Other</option>
                                </select>
                                @error('category')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <div class="input-group">
                                    <input type="file" class="form-control @error('photo') is-invalid @enderror"
                                        name="photo" id="photo">
                                    <label class="input-group-text" for="photo">Select Product Photo</label>
                                    @error('photo')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                @if($inventory->photo)
                                    <div class="mt-2">
                                        <img src="{{ asset('storage/' . $inventory->photo) }}" alt="{{ $inventory->product_title }}" height="50" class="rounded">
                                        <span class="ms-2">Current photo</span>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="description" class="form-label">Description</label>
                                    <textarea class="form-control @error('description') is-invalid @enderror"
                                        id="description" name="description" rows="3">{{ old('description', $inventory->description) }}</textarea>
                                    @error('description')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-3">
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fa fa-shopping-cart"></i>
                                    </span>
                                    <input type="number" class="form-control @error('quantity') is-invalid @enderror"
                                        name="quantity" value="{{ old('quantity', $inventory->quantity) }}"
                                        placeholder="Product Quantity" min="0">
                                    @error('quantity')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fa fa-cube"></i>
                                    </span>
                                    <input type="number" class="form-control @error('in_stock') is-invalid @enderror"
                                        name="in_stock" value="{{ old('in_stock', $inventory->in_stock) }}"
                                        placeholder="In Stock" min="0">
                                    @error('in_stock')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="input-group">
                                    <span class="input-group-text">₦</span>
                                    <input type="number" step="0.01" min="0"
                                        class="form-control @error('buying_price') is-invalid @enderror"
                                        name="buying_price" value="{{ old('buying_price', $inventory->buying_price) }}"
                                        placeholder="Buying Price">
                                    @error('buying_price')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="input-group">
                                    <span class="input-group-text">₦</span>
                                    <input type="number" step="0.01" min="0"
                                        class="form-control @error('selling_price') is-invalid @enderror"
                                        name="selling_price" value="{{ old('selling_price', $inventory->selling_price) }}"
                                        placeholder="Selling Price">
                                    @error('selling_price')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="supplier_id" class="form-label">Supplier</label>
                                    <select class="form-select @error('supplier_id') is-invalid @enderror"
                                        id="supplier_id" name="supplier_id">
                                        <option value="">None</option>
                                        @foreach($suppliers as $supplier)
                                            <option value="{{ $supplier->id }}"
                                                {{ old('supplier_id', $inventory->supplier_id) == $supplier->id ? 'selected' : '' }}>
                                                {{ $supplier->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('supplier_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary">
                                    Update product
                                </button>
                                <a href="{{ route('inventory.index') }}" class="btn btn-secondary">Cancel</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
