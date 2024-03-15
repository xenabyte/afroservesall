@extends('admin.layout.dashboard')

@section('content')
<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0 font-size-18">Food Ordering Products</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item active">Food Ordering Products</li>
                </ol>
            </div>

        </div>
    </div>
</div>
<hr>

<div class="row mb-4">
    <div class="col-lg-12">
        <div class="d-flex align-items-center">
            <div class="ms-3 flex-grow-1">
                
            </div>
            <div>
                <a href="{{ url('/admin/addProduct') }}" class="btn btn-primary"><i class="bx bx-plus align-middle"></i> Add a Product</a>
            </div>
        </div>
    </div><!--end col-->
</div><!--end row-->

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">

                <h4 class="card-title">Food Ordering Products</h4>
                <hr>

                <table id="datatable" class="table table-bordered dt-responsive  nowrap w-100">
                    <thead>
                    <tr>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Price</th>
                        <th>Action</th>
                    </tr>
                    </thead>


                    <tbody>
                    @foreach($foodProducts as $foodProduct)
                    <tr>
                        <td>
                            <img src="{{ asset($foodProduct->image) }}" alt="" class="rounded avatar-lg">
                        </td>
                        <td>{{ $foodProduct->name }}</td>
                        <td>{{ $foodProduct->description }}</td>
                        <td>${{ $foodProduct->price }}</td>
                        <td>
                            <div class="text-end">

                                <a class="btn btn-outline-primary btn-sm edit" title="Edit" href="{{ url('/admin/viewProduct/'.$foodProduct->slug) }}">
                                    <i class="fas fa-pencil-alt"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>

            </div>
        </div>
    </div> <!-- end col -->
</div> <!-- end row -->
@endsection
