@extends('admin.layout.dashboard')

@section('content')
<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0 font-size-18">Saloon Booking Products</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item active">Saloon Booking Products</li>
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

                <h4 class="card-title">Saloon Booking Products</h4>
                <hr>

                <table id="datatable" class="table table-bordered dt-responsive  nowrap w-100">
                    <thead>
                    <tr>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Action</th>
                    </tr>
                    </thead>


                    <tbody>
                    @foreach($hairProducts as $hairProduct)
                    <tr>
                        <td>
                            @if(!empty($hairProduct->image))
                            <img src="{{ asset($hairProduct->image) }}" alt="" class="rounded avatar-lg">
                            @endif
                        </td>
                        <td>{{ $hairProduct->name }}</td>
                        <td>{{ $hairProduct->description }}</td>
                        <td>
                            <div class="text-end">

                                <a class="btn btn-outline-primary btn-sm edit" title="Edit" href="{{ url('/admin/viewProduct/'.$hairProduct->slug) }}">
                                    <i class="fas fa-eye"></i>
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
