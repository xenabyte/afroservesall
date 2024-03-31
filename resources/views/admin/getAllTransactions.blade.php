@extends('admin.layout.dashboard')

@section('content')
<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0 font-size-18">Transactions</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item active">Transactions</li>
                </ol>
            </div>

        </div>
    </div>
</div>
<hr>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">

                <h4 class="card-title">Transactions</h4>
                <hr>

                <table id="datatable" class="table table-bordered dt-responsive  nowrap w-100">
                    <thead>
                    <tr>
                        <th class="bg-dark text-white">#</th>
                        <th class="bg-primary text-white">SKU</th>
                        <th class="bg-warning text-white">Name</th>
                        <th class="bg-info text-white">Reference</th>
                        <th class="bg-success text-white">Price</th>
                        <th>Status</th>
                    </tr>
                    </thead>


                    <tbody>
                    @foreach($getAllTransactions as $getAllTransaction)
                    <tr>
                        <td class="bg-dark-subtle">{{ $loop->iteration }}</td>
                        <td class="bg-primary-subtle">{{ $getAllTransaction->order->sku }}</td>
                        <td class="bg-warning-subtle">{{ ucwords($getAllTransaction->customer->lastname.' '.$getAllTransaction->customer->othernames) }}</td>
                        <td class="bg-info-subtle">{{ $getAllTransaction->reference }}</td>
                        <td class="bg-success-subtle">${{ number_format($getAllTransaction->amount_paid/100, 2) }}</td>
                        <td>
                            <span class="btn btn-primary waves-effect waves-light">
                                {{ ucwords($getAllTransaction->status) }}
                            </span>
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
