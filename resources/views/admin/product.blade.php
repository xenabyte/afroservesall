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
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <h4 class="card-title">Basic Information</h4>
                    <p class="card-title-desc">Fill all information below</p>

                    <form action="{{ url('/admin/addProduct') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label for="productname">Product Name</label>
                                    <input id="name" name="name" type="text" class="form-control" placeholder="Product Name">
                                </div>
                                <div class="mb-3">
                                    <label for="price">Price</label>
                                    <input id="price" name="price" type="text" class="form-control" placeholder="Price">
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label class="control-label">Product Type</label>
                                    <select class="form-control select2">
                                        <option>Select</option>
                                        <option value="FA">Hair</option>
                                        <option value="EL">Food</option>
                                    </select>
                                </div>                                
                            </div>
                            <div class="mb-12">
                                <label for="productdesc">Product Description</label>
                                <textarea class="form-control" id="description" name="description" rows="5" placeholder="Product Description"></textarea>
                            </div>
                        </div>
                        <br>

                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title mb-3">Product Image</h4>
            
                                <div class="dropzone">
                                    <div class="fallback">
                                        <input type="file" name="image">
                                    </div>
                                    <div class="dz-message needsclick">
                                        <div class="mb-3">
                                            <i class="display-4 text-muted bx bxs-cloud-upload"></i>
                                        </div>
                                
                                        <h4>Drop files here or click to upload.</h4>
                                    </div>
                                </div>
                                
                                <ul class="list-unstyled mb-0" id="dropzone-preview">
                                    <li class="mt-2" id="dropzone-preview-list">
                                        <!-- This is used as the file preview template -->
                                        <div class="border rounded">
                                            <div class="d-flex p-2">
                                                <div class="flex-shrink-0 me-3">
                                                    <div class="avatar-sm bg-light rounded">
                                                        <img data-dz-thumbnail class="img-fluid rounded d-block" src="{{asset('../../../img.themesbrand.com/judia/new-document.png')}}" alt="Dropzone-Image">
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <div class="pt-1">
                                                        <h5 class="fs-md mb-1" data-dz-name>&nbsp;</h5>
                                                        <p class="fs-sm text-muted mb-0" data-dz-size></p>
                                                        <strong class="error text-danger" data-dz-errormessage></strong>
                                                    </div>
                                                </div>
                                                <div class="flex-shrink-0 ms-3">
                                                    <button data-dz-remove class="btn btn-sm btn-danger">Delete</button>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
            
                        </div> <!-- end card-->

                        <div class="d-flex flex-wrap gap-2">
                            <button type="submit" class="btn btn-primary waves-effect waves-light">Save Changes</button>
                            <button type="button" class="btn btn-secondary waves-effect waves-light">Cancel</button>
                        </div>
                    </form>

                </div>
            </div>

            
        </div>
    </div>
    <!-- end row -->

   


<footer class="footer">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <script>document.write(new Date().getFullYear())</script> © Skote.
            </div>
            <div class="col-sm-6">
                <div class="text-sm-end d-none d-sm-block">
                    Design & Develop by Themesbrand
                </div>
            </div>
        </div>
    </div>
</footer>
@endsection
