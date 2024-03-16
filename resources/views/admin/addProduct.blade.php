@extends('admin.layout.dashboard')
@section('content')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Add Product</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item active">Add Product</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        <div class="col-8 offset-2">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Product Basic Information</h4>
                    <p class="card-title-desc">Fill all information below</p>
                    <hr>
                </div>
                <div class="card-body">
                    <form action="{{ url('/admin/addProduct') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="productname">Product Name</label>
                                    <input id="name" name="name" type="text" class="form-control" placeholder="Product Name" required>
                                </div>
                            </div>
                            {{-- <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="price">Price</label>
                                    <div class="input-group">
                                        <span class="input-group-text">$</span> <!-- Dollar sign prefix -->
                                        <input id="price" name="price" type="number" step="0.01" class="form-control" placeholder="Price">
                                    </div>
                                </div>
                            </div> --}}
                            
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="control-label">Product Type</label>
                                    <select class="form-control" name="product_type_id" required>
                                        <option value="" selected>Select Produt Type</option>
                                        @foreach($productTypes as $productType)<option value="{{ $productType->id }}">{{ $productType->type }}</option>@endforeach
                                    </select>
                                </div>                                
                            </div>

                            <div class="mb-12">
                                <label for="productdesc">Product Description</label>
                                <textarea class="form-control" id="description" name="description" rows="5" placeholder="Product Description"></textarea>
                                <hr>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="image">Product Image</label>
                                    <input id="image" name="image" type="file" class="form-control">
                                </div>
                            </div>
                            <hr>
                        </div>

                        <div class="d-flex flex-wrap gap-2">
                            <button type="submit" class="btn btn-primary waves-effect waves-light">Create Product</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
    <!-- end row -->
@endsection
