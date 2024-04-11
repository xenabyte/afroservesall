@extends('admin.layout.dashboard')
@section('content')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Product</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item active">Product</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        <div class="col-6">
            <div class="card">
                <!-- Nav tabs -->
                <ul class="nav nav-tabs nav-tabs-custom justify-content-center pt-2" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-bs-toggle="tab" href="#all-post" role="tab">
                           View and Edit Product
                        </a>
                    </li>
                </ul>
    
                <!-- Tab panes -->
                <div class="tab-content p-4">
                    <div class="tab-pane active" id="all-post" role="tabpanel">
                        <div>
                            <div class="row justify-content-center">
                                <div class="col-xl-12">
                                    <div>
                                        <div class="row align-items-center">
                                            <div class="col-4">
                                                <div>
                                                    <h5 class="mb-0">Product Details</h5>
                                                </div>
                                            </div>
                
                                            <hr>
    
                                            <div>
                                                @if(!empty($product->slug))
                                                <div class="text-center">
                                                    <div class="mb-4">
                                                        <a href="javascript: void(0);" class="badge bg-light font-size-12">
                                                            <i class="bx bx-purchase-tag-alt align-middle text-muted me-1"></i> {{ !empty($product->product_type_id)?$product->type->type:null }}
                                                        </a>
                                                    </div>
                                                    <h4>{{ $product->name }}</h4>
                                                    <p class="text-muted mb-4"><i class="mdi mdi-calendar me-1"></i> {{ $product->created_at }}</p>
                                                </div>
                                                @endif
    
                                                <hr>
                                                <div class="text-center">
                                                    <div class="row">
                                                        <div class="col-8 offset-2">
                                                            <div>
                                                                <p class="text-muted mb-2">Product Type</p>
                                                                <h5 class="font-size-15">{{ !empty($product->product_type_id)?$product->type->type:null }}</h5>
                                                            </div>
                                                        </div>
                                                        
                                                    </div>
                                                </div>
                                                <hr>
    
                                                <div class="my-5">
                                                    <img src="{{ asset($product->image) }}" alt="" class="img-thumbnail mx-auto d-block">
                                                </div>
    
                                                <hr>
    
                                                <div class="mt-4">
                                                    <div class="text-muted font-size-14">
                                                        {!! $product->description !!}
                                                    </div>
    
                                                </div>
                                                
                                            </div>
                                            
                                        </div>
                                        <!-- end row -->
    
                                    </div>
                                </div>

                                <div class="col-xl-12 mt-5">
                                    <div class="row align-items-center mt-5">
                                        <div class="col-12 mt-2 mb-3">
                                            <div>
                                                <h5 class="mb-0">Product Options</h5>
                                                <div class="text-end">
                                                    <button type="button" class="btn btn-primary waves-effect waves-light" data-bs-toggle="modal" data-bs-target=".addProductOption">Add Product Option</button>
                                                </div>
                                            </div>
                                        </div>
                                        <hr>
                                        <table id="datatable" class="table table-bordered dt-responsive  nowrap w-100">
                                            <thead>
                                            <tr>
                                                <th>Product Option</th>
                                                <th>Description</th>
                                                <th>Price</th>
                                                <th>Action</th>
                                            </tr>
                                            </thead>


                                            <tbody>
                                            @foreach($product->features as $feature)
                                            <tr>
                                                
                                                <td>{{ $feature->feature }}</td>
                                                <td>{{ $feature->description }}</td>
                                                <td>£{{ $feature->price }}</td>
                                                <td>
                                                    <div class="text-end">

                                                        <a class="btn btn-outline-secondary btn-sm edit" title="manage" data-bs-toggle="modal" data-bs-target="#editFeature{{ $feature->id }}">
                                                            <i class="fas fas fa-cogs"></i>
                                                        </a> 
                            
                                                        <a class="btn btn-outline-danger btn-sm edit" title="delete" data-bs-toggle="modal" data-bs-target="#deleteFeature{{ $feature->id }}">
                                                            <i class="fas fa-trash"></i>
                                                        </a>
                                                    </div>
                                                </td>

                                                <!-- Static Backdrop Modal -->
                                                <div class="modal fade" id="deleteFeature{{ $feature->id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="deleteFeature" aria-hidden="true">
                                                    <div class="modal-dialog modal-md modal-dialog-centered" role="document">
                                                        <div class="modal-content">
                                                        
                                                            <form action="{{ url('/admin/deleteProductFeature') }}" method="POST">
                                                                @csrf
                                                                <div class="modal-body">
                                                                    <p class="text-center"> Are you sure you want to delete {{ $feature->feature }}</p>
                                                                    <input type="hidden" name="product_feature_id" value="{{ $feature->id }}">
                                                                </div>
                                                                
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Close</button>
                                                                    <button type="submit" class="btn btn-danger">Yes, Delete</button>
                                                                </div>
                                                            </form>
                                                            
                                                        </div>
                                                    </div>
                                                </div>
                        
                                                <!-- Static Backdrop Modal -->
                                                <div class="modal fade" id="editFeature{{ $feature->id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="editFeature" aria-hidden="true">
                                                    <div class="modal-dialog modal-md modal-dialog-centered" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Update Product Option</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                        
                                                            <form action="{{ url("/admin/editProductFeature") }}" method="post">
                                                                @csrf
                                                                <input type="hidden" name="product_feature_id" value="{{ $feature->id }}">
                        
                                                                <div class="modal-body">
                                                                    <div class="form-floating mb-3">
                                                                        <input type="text" class="form-control" id="name" name="feature" value="{{ $feature->feature }}">
                                                                        <label for="name">Product Option Name</label>
                                                                    </div>

                                                                    <div class="mb-3">
                                                                        <label for="price">Price</label>
                                                                        <div class="input-group">
                                                                            <span class="input-group-text">£</span> <!-- Dollar sign prefix -->
                                                                            <input id="price" name="price" type="number" step="0.01" class="form-control" value="{{ $feature->price }}" required>
                                                                        </div>
                                                                    </div>
                                        
                                                                    <div class="mb-12">
                                                                        <label for="productdesc">Product Option Description</label>
                                                                        <textarea class="form-control" id="description" name="description" rows="5" placeholder="Product Description">{{ $feature->description }}</textarea>
                                                                        <hr>
                                                                    </div>
                                                                    
                                                                </div>
                                                                
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                                                                    <button type="submit" class="btn btn-primary">Save Changes</button>
                                                                </div>
                                                            </form>
                                                            
                                                        </div>
                                                    </div>
                                                </div>
                                            </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
    
                </div>
                
            </div>
        </div>

        <div class="col-5 offset-1">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Product Basic Information</h4>
                    <hr>
                </div>
                <div class="card-body">
                    <form action="{{ url('/admin/editProduct') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="productname">Product Name</label>
                                    <input id="name" name="name" type="text" class="form-control" value="{{ $product->name }}" required>
                                </div>
                            </div>
                            {{-- <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="price">Price</label>
                                    <div class="input-group">
                                        <span class="input-group-text">$</span> <!-- Dollar sign prefix -->
                                        <input id="price" name="price" type="number" step="0.01" class="form-control" value="{{ $product->price }}" required>
                                    </div>
                                </div>
                            </div> --}}
                            
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="control-label">Product Type</label>
                                    <select class="form-control" name="product_type_id" required>
                                        @foreach($productTypes as $productType)<option @if($productType->id == $product->product_type_id) selected @endif value="{{ $productType->id }}">{{ $productType->type }}</option>@endforeach
                                    </select>
                                </div>                                
                            </div>

                            <div class="mb-12">
                                <label for="productdesc">Product Description</label>
                                <textarea class="form-control" id="description" name="description" rows="5" placeholder="Product Description">{{ $product->description }}</textarea>
                                <hr>
                            </div>

                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="image">Product Image</label>
                                    <input id="image" name="image" type="file" class="form-control">
                                </div>
                            </div>
                            <hr>
                        </div>

                        <div class="d-flex flex-wrap gap-2">
                            <button type="submit" class="btn btn-primary waves-effect waves-light">Save Changes</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
    <!-- end row -->

    <div class="modal fade bs-example-modal-center" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Delete  Product</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <p> Are you sure you wante to delete <strong>{{  $product->name }}</strong></p>
                    <form action="{{ url('/admin/deleteProduct') }}" method="post">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-danger">Yes, Delete</button>
                        </div>
                    </form>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <div class="modal fade addProductOption" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Product Option</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ url('/admin/addProductFeature') }}" method="post">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">

                        <div class="mb-3 form-floating">
                            <input id="name" name="feature" type="text" class="form-control" placeholder="Product Option" required>
                            <label for="productname">Product Option Name</label>
                        </div>

                        <div class="mb-3">
                            <label for="price">Price</label>
                            <div class="input-group">
                                <span class="input-group-text">£</span> <!-- pounds sign prefix -->
                                <input id="price" name="price" type="number" step="0.01" class="form-control" required>
                            </div>
                        </div>

                        <div class="mb-12">
                            <label for="productdesc">Product Description</label>
                            <textarea class="form-control" id="description" name="description" rows="5" placeholder="Product Option Description"></textarea>
                            <hr>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Add Option</button>
                        </div>
                    </form>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
@endsection
