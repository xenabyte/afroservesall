@php
    $admin = Auth::guard('admin')->user();
    $customers = \App\Models\Customer::all();
    $products = \App\Models\Product::all();
    $totalTransactions = \App\Models\Transaction::all();
    $isAuthenticated = !empty($admin) ? true : false;
    $name = !empty($admin) ? $admin->lastname . ' ' . $admin->othernames : null;
    $email = !empty($admin) ? $admin->email : null;
    $addresses = !empty($admin) ? $admin->addresses : null;
    $transactions = !empty($admin) ? $admin->transactions : null;
    $orders = \App\Models\Order::with('customer', 'cartItems', 'customer')->where('status', '!=', 'completed')->orderBy('id', 'desc')->get();

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
    $currentMonthEarnings = isset($earningsPerMonth[$currentMonth]) ? $earningsPerMonth[$currentMonth] : 0;
    $previousMonthEarnings = isset($earningsPerMonth[$previousMonth]) ? $earningsPerMonth[$previousMonth] : 0;


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
                                        <p>{{ env('APP_NAME') }} Dashboard</p>
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
                                                <h5 class="font-size-15">£{{ number_format($totalRevenue/100, 2) }}</h5>
                                                <p class="text-muted mb-0">Revenue</p>
                                            </div>
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
                                            <h4 class="mb-0">£{{ number_format($totalRevenue/100, 2) }}</h4>
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
                                            <h4 class="mb-0">£{{ number_format($averagePrice/100, 2) }}</h4>
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
                        <h4 class="card-title m-4">Pending Order(s)/Booking(s)</h4>
                        <hr style="color:brown">
                        <div class="card-body">
                            <table class="table table-bordered dt-responsive  nowrap w-100">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col" class="bg-primary text-white">SKU</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Phone</th>
                                        <th scope="col">Delivery Type</th>
                                        <th scope="col">Order Type</th>
                                        <th scope="col">Delivery Date</th>
                                        <th scope="col">Order Date</th>
                                        <th scope="col">Status</th>
                                        <th scope="col"></th>
                                    </tr>
                                </thead>
            
            
                                <tbody>
                                @foreach($orders as $order)
                                <tr>
                                    <th scope="row">{{ $loop->iteration }}</th>
                                    <td class="bg-primary-subtle">{{ $order->sku }}</td>
                                    <td>{{ ucwords($order->customer->lastname.' '.$order->customer->othernames) }}</td>
                                    <td>{{ $order->customer->phone }}</td>
                                    <td>{{ ucwords($order->delivery_type) }}</td>
                                    <td>{{ ucwords($order->product_type) }}</td>
                                    <td>{{ date('F d, Y h:i:s A', strtotime($order->booking_date)) }}</td>
                                    <td>{{ date('F d, Y h:i:s A', strtotime($order->created_at)) }}</td>
                                    <td>
                                        @if($order->status == 'pending')
                                        <span class="btn btn-primary waves-effect waves-light">
                                            Pending
                                        </span>
                                        @elseif($order->status == 'completed')
                                        <span class="btn btn-success waves-effect waves-light">
                                            Completed
                                        </span>
                                        @else
                                        <span class="btn btn-warning waves-effect waves-light">
                                            {{ $order->status }}
                                        </span>
                                        @endif
                                    </td>
                                    <td>
                                        <a class="btn btn-outline-secondary btn-sm edit" data-bs-toggle="modal" data-bs-target="#viewOrder{{ $order->id }}" title="view">
                                            <i class="fas fa-eye"></i>
                                        </a>
            
                                        <!-- Static Backdrop Modal -->
                                        <div class="modal fade" id="viewOrder{{ $order->id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                            <div class="modal-dialog .modal-dialog-scrollable modal-xl modal-dialog-centered" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="staticBackdropLabel">Order Information</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body row">
                                                        <div class="col-xl-8">
                                                            <div class="card">
                                                                <div class="card-body">
                                                                    <div class="table-responsive">
                                                                        <table class="table align-middle mb-0 table-nowrap">
                                                                            <thead class="table-light">
                                                                                <tr>
                                                                                    <th>#</th>
                                                                                    <th>Product</th>
                                                                                    <th>Quantity</th>
                                                                                    <th>Price</th>
                                                                                    <th colspan="2">Total</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                                @foreach($order->cartItems as $cartItem)
                                                                                <tr class="product">
                                                                                    <td>{{ $loop->iteration }}</td>
                                                                                    <td>
                                                                                        <h5 class="font-size-14 text-truncate"><a href="#" class="text-dark">{{ $cartItem->name }}</a></h5>
                                                                                        <p class="mb-0">{{ $cartItem->description }}</p>
                                                                                    </td>
                                                                                    <td><span class="product-price">{{ $cartItem->quantity }}</span></td>
                                                                                    <td>£<span class="product-line-price">{{ $cartItem->price/number_format($cartItem->quantity) }}</span></td>
                                                                                    <td>£<span class="product-line-price">{{ $cartItem->price }}</span> </td>
                                                                                </tr>
                                                                                @endforeach
                                                                            
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                </div>
                                                                <div class="card-body">
                                                                    @if($order->address)
                                                                    <p class="mb-0">Address : <span class="fw-medium">{{ $order->address->address_1.' '.$order->address->address_2 }}</span></p>
                                                                    <p class="mb-0">Phone Number : <span class="fw-medium">{{ $order->address->phone_number }}</span></p>
                                                                    @endif
                                                                    <p class="mb-0">Additional Information : <span class="fw-medium">{{ $order->additional_information }}</span></p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-xl-4">
                                                            <div class="card">
                                                                <div class="card-body">
                                                                    <h4 class="card-title mb-3">Order Summary</h4>
                                                                    <hr>
                                                                    <div class="table-responsive">
                                                                        <table class="table mb-0">
                                                                            <tbody>
                                                                                <tr>
                                                                                    <td>Grand Total :</td>
                                                                                    <td id="cart-subtotal">£{{ number_format($order->amount_paid/100, 2) }}</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td>Service Charge : </td>
                                                                                    <td id="cart-discount">£0.50</td>
                                                                                </tr>
                                                                                @if($order->product_type == 'Food')
                                                                                <tr>
                                                                                    <td>Shipping Charge :</td>
                                                                                    <td id="cart-shipping">£3.0</td>
                                                                                </tr>
                                                                                @endif
                                                                                {{-- <tr>
                                                                                    <td>Estimated Tax (12.5%) :</td>
                                                                                    <td id="cart-tax">$ 19.22</td>
                                                                                </tr> --}}
                                                                                <tr class="bg-light">
                                                                                    <th>Total :</th>
                                                                                    <th id="cart-total">£{{ number_format($order->amount_paid/100, 2) }}</th>
                                                                                </tr>
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                    <!-- end table-responsive -->
                                                                </div>
                                                            </div>
                                                            <!-- end card -->
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <a class="btn btn-outline-primary btn-sm edit" data-bs-toggle="modal" data-bs-target="#updateOrder{{ $order->id }}" title="Edit">
                                            <i class="fas fa-pencil-alt"></i>
                                        </a>
            
                                        <!-- Static Backdrop Modal -->
                                        <div class="modal fade" id="updateOrder{{ $order->id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="staticBackdropLabel">Update Order</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <form method="POST" action="{{ url('/admin/updateOrder') }}">
                                                        @csrf
                                                        <div class="modal-body">
            
                                                            <input type="hidden" name="order_id" value="{{ $order->id }}">
            
                                                            <div class="mb-3 form-floating">
                                                                <select class="form-select" name="status">
                                                                    <option @if($order->status == 'pending') selected @endif value="pending">Pending</option>
                                                                    <option @if($order->status == 'delivery ongoing') selected @endif value="delivery ongoing">Delivery Ongoing</option>
                                                                    <option @if($order->status == 'completed') selected @endif value="completed">Completed</option>
                                                                </select> 
                                                                <label class="col-form-label">Please Current state of Order</label>
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
                                    </td>
                                </tr>
                                @endforeach
                                </tbody>
                            </table>

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
                                                    £{{ number_format($transaction->amount_paid/100, 2) }}
                                                </td>
                                                <td>
                                                    <span
                                                        class="badge badge-pill badge-soft-success font-size-11">{{ $transaction->status }}</span>
                                                </td>
                                                <td>
                                                    <i class="fab fa-cc-mastercard me-1"></i>
                                                    {{ $transaction->payment_method }}
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
