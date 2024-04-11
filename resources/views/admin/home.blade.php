@php
    $admin = Auth::guard('admin')->user();
    $customers = \App\Models\Customer::all();
    $products = \App\Models\Product::all();
    $totalTransactions = \App\Models\Transaction::all();
    $isAuthenticated = !empty($admin) ? true : false;
    $name = !empty($admin) ? $admin->lastname . ' ' . $admin->othernames : null;
    $email = !empty($admin) ? $admin->email : null;
    $addresses = !empty($admin) ? $admin->addresses : null;
    $orders = !empty($admin) ? $admin->orders : null;
    $transactions = !empty($admin) ? $admin->transactions : null;

    $transactions_order = \App\Models\Transaction::with('order')->get();
    $totalOrders = \App\Models\Order::all()->count();
    // foreach (
    //     $totalTransactions->map(function ($transaction) {
    //         return \App\Models\Transaction::with('order')->find($transaction->id);
    //     })
    //     as $transaction_order
    // ) {
    // }

    // foreach ($transactions_order as $transaction) {
    //     if ($transaction->order) {

    //         dd($transaction->order->sku);
    //     }
    // }

    $totalRevenue = !empty($totalTransactions)
        ? $totalTransactions->where('status', 'completed')->sum('amount_paid')
        : 0;

    // we need to resedule the address to collect the city or state also
    // $topState = \App\Models\Order::join('addresses', 'orders.address_id', '=', 'addresses.id')
    //     ->select('addresses.state', DB::raw('count(*) as total'))
    //     ->groupBy('addresses.state')
    //     ->orderBy('total', 'desc')
    //     ->get();

    $topPaymentMethods = $totalTransactions
        ->groupBy('payment_method')
        ->map(function ($group) {
            return $group->count();
        })
        ->sortDesc();

    $averageRevenuePerMonth = $totalRevenue / 12;

    $earningsPerMonth = $totalTransactions
        ->filter(function ($transaction) {
            return $transaction->status == 'completed';
        })
        ->groupBy(function ($transaction) {
            return $transaction->created_at->format('Y-m');
        })
        ->map(function ($group) {
            return $group->sum('amount_paid');
        });

    $keys = $earningsPerMonth->keys();
    $currentMonth = $keys->last();
    $previousMonth = $keys->slice(-2, 1)->first();
    $currentMonthEarnings = $earningsPerMonth[$currentMonth]??0;
    $previousMonthEarnings = $earningsPerMonth[$previousMonth] ?? 0;

    $percentageChange =
        $previousMonthEarnings != 0
            ? (($currentMonthEarnings - $previousMonthEarnings) / $previousMonthEarnings) * 100
            : 0;

    $averagePrice = $totalTransactions
        ->filter(function ($transaction) {
            return $transaction->status == 'completed';
        })
        ->avg('amount_paid');

    // For the event -> will it will be needed
    // $eventCustomer = event(new App\Events\CustomerActivity(Auth::guard('customer')->user(), 'Cart done adding'));

@endphp


@extends('admin.layout.dashboard')

@section('content')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Dashboard</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                </div>



            </div>
            <div class="row">
                <div class="col-xl-4">
                    <div class="card overflow-hidden">
                        <div class="bg-primary-subtle">
                            <div class="row">
                                <div class="col-7">
                                    <div class="text-primary p-3">
                                        <h5 class="text-primary">Welcome Back !</h5>
                                        <p>Skote Dashboard</p>
                                    </div>
                                </div>
                                <div class="col-5 align-self-end">
                                    <img src="{{ asset('assets/images/profile-img.png') }}" alt=""
                                        class="img-fluid">
                                </div>
                            </div>
                        </div>
                        <div class="card-body pt-0">
                            <div class="row">
                                <div class="col-sm-4">
                                    <img src="{{ asset('assets/images/users/avatar.png') }}" alt=""
                                        class="img-thumbnail rounded-circle">
                                    <h5 class="font-size-15 text-truncate">{{ $name }}</h5>
                                    <p class="text-muted w-fit mb-0 text" style="width: fit-content">{{ $email }}
                                        <br>
                                        {{ $admin->phone }}
                                    </p>
                                </div>

                                <div class="col-sm-8">
                                    <div class="pt-4">

                                        <div class="row">
                                            <div class="col-6">
                                                <h5 class="font-size-15">

                                                    {{ $totalOrders }}



                                                </h5>
                                                <p class="text-muted mb-0">Order</p>
                                            </div>
                                            <div class="col-6">
                                                <h5 class="font-size-15">$1245</h5>
                                                <p class="text-muted mb-0">Revenue</p>
                                            </div>
                                        </div>
                                        <div class="mt-4">
                                            <a href="/customer/profile"
                                                class="btn btn-primary waves-effect waves-light btn-sm">View Profile <i
                                                    class="mdi mdi-arrow-right ms-1"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title mb-4">Monthly Earning</h4>
                            <div class="row">
                                <div class="col-sm-6">
                                    <p class="text-muted">This month</p>
                                    <h3>
                                        £{{ number_format($currentMonthEarnings, 2) }}


                                    </h3>
                                    <p class="text-muted">
                                        <span class="{{ $percentageChange >= 0 ? 'text-success' : 'text-danger' }} me-2">
                                            {{ ceil($percentageChange) }}%
                                            <i
                                                class="mdi {{ $percentageChange >= 0 ? 'mdi-arrow-up' : 'mdi-arrow-down' }}"></i>
                                        </span>
                                        From previous period
                                    </p>

                                    <div class="mt-4">
                                        <a href="javascript: void(0);"
                                            class="btn btn-primary waves-effect waves-light btn-sm">View More <i
                                                class="mdi mdi-arrow-right ms-1"></i></a>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="mt-4 mt-sm-0">
                                        <div id="radialBar-chart" data-colors='["--bs-primary"]' class="apex-charts"></div>
                                    </div>
                                </div>
                            </div>
                            <p class="text-muted mb-0">We craft digital, graphic and dimensional thinking.</p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-8">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="card mini-stats-wid">
                                <div class="card-body">
                                    <div class="d-flex">
                                        <div class="flex-grow-1">
                                            <p class="text-muted fw-medium">Orders</p>
                                            <h4 class="mb-0">{{ $totalOrders }}</h4>
                                        </div>

                                        <div class="flex-shrink-0 align-self-center">
                                            <div class="mini-stat-icon avatar-sm rounded-circle bg-primary">
                                                <span class="avatar-title">
                                                    <i class="bx bx-copy-alt font-size-24"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card mini-stats-wid">
                                <div class="card-body">
                                    <div class="d-flex">
                                        <div class="flex-grow-1">
                                            <p class="text-muted fw-medium">Revenue</p>
                                            <h4 class="mb-0">£{{ $totalRevenue }}</h4>
                                        </div>

                                        <div class="flex-shrink-0 align-self-center ">
                                            <div class="avatar-sm rounded-circle bg-primary mini-stat-icon">
                                                <span class="avatar-title rounded-circle bg-primary">
                                                    <i class="bx bx-archive-in font-size-24"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card mini-stats-wid">
                                <div class="card-body">
                                    <div class="d-flex">
                                        <div class="flex-grow-1">
                                            <p class="text-muted fw-medium">Average Price</p>
                                            <h4 class="mb-0">£{{ $averagePrice }}</h4>
                                        </div>

                                        <div class="flex-shrink-0 align-self-center">
                                            <div class="avatar-sm rounded-circle bg-primary mini-stat-icon">
                                                <span class="avatar-title rounded-circle bg-primary">
                                                    <i class="bx bx-purchase-tag-alt font-size-24"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end row -->

                    <div class="card">
                        <div class="card-body">
                            <div class="d-sm-flex flex-wrap">
                                <h4 class="card-title mb-4">Email Sent</h4>
                                <div class="ms-auto">
                                    <ul class="nav nav-pills">
                                        <li class="nav-item">
                                            <a class="nav-link" href="#">Week</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#">Month</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link active" href="#">Year</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <div id="stacked-column-chart" class="apex-charts"
                                data-colors='["--bs-primary", "--bs-warning", "--bs-success"]' dir="ltr"></div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end row -->

            {{-- Start latest transaction row --}}
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title mb-4">Latest Transaction</h4>
                            <div class="table-responsive">
                                <table class="table align-middle table-nowrap mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th style="width: 20px;">
                                                <div class="form-check font-size-16 align-middle">
                                                    <input class="form-check-input" type="checkbox"
                                                        id="transactionCheck01">
                                                    <label class="form-check-label" for="transactionCheck01"></label>
                                                </div>
                                            </th>
                                            <th class="align-middle">Order ID</th>
                                            <th class="align-middle">Billing Name</th>
                                            <th class="align-middle">Date</th>
                                            <th class="align-middle">Total</th>
                                            <th class="align-middle">Payment Status</th>
                                            <th class="align-middle">Payment Method</th>
                                            <th class="align-middle">View Details</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($totalTransactions as $transaction)
                                            <tr>
                                                <td>
                                                    <div class="form-check font-size-16">
                                                        <input class="form-check-input" type="checkbox"
                                                            id="transactionCheck02">
                                                        <label class="form-check-label" for="transactionCheck02"></label>
                                                    </div>
                                                </td>
                                                <td><a href="javascript: void(0);"
                                                        class="text-body fw-bold">#{{ $transaction->order_id }}</a>
                                                </td>
                                                <td>{{ optional($transaction->customer)->lastname . ' ' . optional($transaction->customer)->othernames }}
                                                </td>
                                                <td>
                                                    {{ $transaction->created_at->format('j F, Y') }}
                                                </td>
                                                <td>
                                                    {{ $transaction->amount_paid }}
                                                </td>
                                                <td>
                                                    <span
                                                        class="badge badge-pill badge-soft-success font-size-11">{{ $transaction->status }}</span>
                                                </td>
                                                <td>
                                                    <i class="fab fa-cc-mastercard me-1"></i>
                                                    {{ $transaction->payment_method }}
                                                </td>
                                                <td>
                                                    <!-- Button trigger modal -->
                                                    <button type="button"
                                                        class="btn btn-primary btn-sm btn-rounded waves-effect waves-light view-details-button"
                                                        data-bs-toggle="modal"
                                                        data-bs-target=".transaction-detailModal{{ $transaction->id }}">
                                                        View Details
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <!-- end table-responsive -->
                        </div>
                    </div>
                </div>
            </div>
            {{-- End latest transaction row --}}
            <!-- Transaction Modal -->
            @foreach ($totalTransactions as $transaction)
                <div class="modal fade transaction-detailModal{{ $transaction->id }}" tabindex="-1" role="dialog"
                    aria-labelledby="transaction-detailModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="transaction-detailModalLabel">Order Details</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">

                                <p class="mb-2">Product id: <span class="text-primary">{{ $transaction->id }}</span>
                                </p>
                                <p class="mb-4">Billing Name: <span class="text-primary">{{ $transaction->id }}</span>
                                </p>

                                <div class="table-responsive">
                                    <table class="table align-middle table-nowrap">
                                        <thead>
                                            <tr>
                                                <th scope="col">Product</th>
                                                <th scope="col">Product Name</th>
                                                <th scope="col">Price</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            <tr>

                                                <th scope="row">
                                                    <div>
                                                        <img src="assets/images/product/img-4.png" alt=""
                                                            class="avatar-sm">
                                                    </div>
                                                </th>
                                                <td>
                                                    <div>
                                                        <h5 class="text-truncate font-size-14">Phone patterned
                                                            cases
                                                        </h5>
                                                        <p class="text-muted mb-0">$ {{ $transaction->amount_paid }} x
                                                            1
                                                        </p>
                                                    </div>
                                                </td>
                                                <td>$ {{ $transaction->amount_paid }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="2">
                                                    <h6 class="m-0 text-right">Sub Total:</h6>
                                                </td>
                                                <td>
                                                    $ {{ $transaction->amount_paid }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="2">
                                                    <h6 class="m-0 text-right">Shipping:</h6>
                                                </td>
                                                <td>
                                                    Free
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="2">
                                                    <h6 class="m-0 text-right">Total:</h6>
                                                </td>
                                                <td>
                                                    $ {{ $transaction->amount_paid }}
                                                </td>
                                            </tr>

                                        </tbody>

                                    </table>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

            <!-- end modal -->
        </div>


        <script src="{{ asset('assets/js/libs/apexcharts/apexcharts.min.js') }}"></script>
        <script>
            var options = {
                chart: {
                    height: 320,
                    type: 'radialBar',
                },
                plotOptions: {
                    radialBar: {
                        hollow: {
                            size: '70%',
                        },
                    },
                },
                colors: ['#727cf5'],
                series: [{{ $currentMonthEarnings }}],
                labels: ['Current Month'],
            };
        </script>
    @endsection
