@extends('admin.layout.dashboard')

@section('content')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">All Transactions</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item active">All Ordering Transactions</li>
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
                    <a href="{{ url('/admin/reporters') }}" class="btn btn-primary"><i
                            class="bx bx-search-alt-2 align-middle font-size-24"></i> Show newest transactions</a>
                </div>
            </div>
        </div><!--end col-->
    </div><!--end row-->

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <h4 class="card-title">All Transactions</h4>
                    <hr>

                    <table id="datatable" class="table table-bordered dt-responsive  nowrap w-100">
                        <thead>
                            <tr>
                                <th>Customer ID</th>
                                <th>Order ID</th>
                                <th>Amount Paid</th>
                                <th>Promo Amount</th>
                                <th>Status</th>
                                <th>Payment Method</th>
                                <th>Date</th>
                                {{-- <th>Price</th> --}} <th>Action</th>
                            </tr>
                        </thead>


                        <tbody>
                            @foreach ($transactions as $transaction)
                                <tr>

                                    <td>{{ $transaction->customer_id }}</td>
                                    <td>{{ $transaction->order_id }}</td>
                                    <td>{{ $transaction->amount_paid }}</td>
                                    <td>{{ $transaction->promo_amount }}</td>
                                    <td>{{ $transaction->status }}</td>
                                    <td>{{ $transaction->payment_method }}</td>
                                    <td>{{ $transaction->created_at }}</td>

                                    <td>
                                        <div class="text-end">

                                            <a class="btn btn-outline-primary btn-sm edit" title="Edit"
                                                href="{{ url('/admin/viewTransaction/' . $transaction->slug) }}">
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
