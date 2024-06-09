@php
    $customer = Auth::guard('customer')->user();
    $isAuthenticated = !empty($customer) ? true : false;
    $name = !empty($customer) ? $customer->lastname . ' ' . $customer->othernames : null;
    $email = !empty($customer) ? $customer->email : null;
    $addresses = !empty($customer) ? $customer->addresses()->orderBy('id', 'desc')->get() : null;
    $orders = !empty($customer) ? $customer->orders()->orderBy('id', 'desc')->get() : null;
    $transactions = !empty($customer) ? $customer->transactions : null;

    $previousUrl = session('previous_url');
    $pageName = "profile";
@endphp

<!doctype html>
<html lang="en">


<head>

    <meta charset="utf-8" />
    <title>{{ env('APP_NAME') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="{{ env('APP_DESCRIPTION') }}" name="description" />
    <meta content="KoderiaNg" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}">

    <!-- DataTables -->
    <link href="{{ asset('assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css') }}" rel="stylesheet"
        type="text/css" />

    <!-- Responsive datatable examples -->
    <link href="{{ asset('assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') }}"
        rel="stylesheet" type="text/css" />


    <!-- Bootstrap Css -->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="{{ asset('assets/css/app.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />
    <!-- select2 css -->
    <link href="{{ asset('assets/libs/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- Plugins css -->
    <link href="{{ asset('assets/libs/dropzone/dropzone.css') }}" rel="stylesheet" type="text/css" />

</head>

<body data-bs-spy="scroll" data-bs-target="#topnav-menu" data-bs-offset="60">
    @include('sweetalert::alert')
    @include('common.social')
    <nav class="navbar navbar-expand-lg navigation fixed-top sticky">
        <div class="container">
            <a class="navbar-logo mt-3 mb-2" href="{{ url('/') }}">
                <img src="{{ asset('assets/images/logo-dark.png') }}" alt="" height="100"
                    class="logo logo-dark">
                <img src="{{ asset('assets/images/logo-light.png') }}" alt="" height="100"
                    class="logo logo-light">
            </a>

            <button type="button" class="btn btn-sm px-3 font-size-16 d-lg-none header-item waves-effect waves-light"
                data-bs-toggle="collapse" data-bs-target="#topnav-menu-content">
                <i class="fa fa-fw fa-bars"></i>
            </button>

            <div class="collapse navbar-collapse" id="topnav-menu-content">
                <ul class="navbar-nav ms-auto" id="topnav-menu">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/') }}">Afroservesall</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ $previousUrl == url('/orderNow') ? url('foodOrder') : url('saloonBooking') }}#home">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ $previousUrl }}">{{ $previousUrl == url('/orderNow') ? 'Order Now' : 'Book Now' }}</a>
                    </li>
                </ul>
            </div>
            <button type="button" class="btn header-item noti-icon waves-effect"
                id="page-header-notifications-dropdown" data-bs-toggle="dropdown" aria-haspopup="true"
                aria-expanded="false">
                <i class="bx bx-cart bx-tada"></i>
                <span class="badge bg-danger rounded-pill" id="cart-items-badge">0</span>
            </button>
            @if (!empty($name))
                <div class="dropdown d-inline-block">
                    <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown"
                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="margin-right: 5px;">
                        <img class="rounded-circle header-profile-user"
                            src="{{ asset('assets/images/users/avatar.png') }}" alt="Header Avatar">
                        <span class="d-none d-xl-inline-block ms-1" key="t-henry"
                            style="margin-right: 5px;">{{ $name }}</span>
                        <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end">
                        <!-- item-->
                        <span class="dropdown-item d-none d-xl-inline-block ms-2 nav-link" key="t-henry">Welcome <br> {{ $name }}</span>
                        <hr>
                        <a class="dropdown-item" href="{{ url('customer/profile') }}"><i
                                class="bx bx-user font-size-16 align-middle me-1"></i> <span
                                key="t-profile">Profile</span></a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item text-danger" href="{{ url('/customer/logout') }}"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i
                                class="bx bx-power-off font-size-16 align-middle me-1 text-danger"></i> <span
                                key="t-logout">Logout</span></a>
                        <form id="logout-form" action="{{ url('/customer/logout') }}" method="POST"
                            style="display: none;">@csrf</form>
                    </div>
                </div>
            @endif
        </div>
    </nav>

    <!-- hero section start -->
    <section class="section hero-section bg-ico-hero" id="home"
        style="background-image:url({{ asset('assets/images/bg_img_1.jpg') }});background-size:cover;background-position:top">
        <div class="bg-overlay bg-darke"></div>
        <div class="container">
            <div class="row align-items-center pt-1">
                <div class="col-lg-7 ">
                    <div class="text-white-50">
                        <h1 class="text-white fw-semibold mb-3 hero-title">Your Profile!</h1>

                    </div>
                </div>
                <div class="col-lg-3 col-md-8 col-sm-10 ms-lg-auto">

                </div>
            </div>
            <!-- end row -->
        </div>
        <!-- end container -->
    </section>
    <!-- hero section end -->


    <!-- about section start -->
    <section class="section pt-4 bg-white" id="about">
        <div class="container">
            <div class="row">
                <div class="col-xl-4">
                    <div class="card overflow-hidden">
                        <div class="bg-primary-subtle">
                            <div class="row">
                                <div class="col-7">
                                    <div class="text-primary p-3">
                                        <h5 class="text-primary">Welcome Back !</h5>
                                        <p>We are pleased to have you here</p>
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
                                <div class="col-sm-12">
                                    <div class="avatar-md profile-user-wid mb-4">
                                        <img src="{{ asset('assets/images/users/avatar.png') }}" alt=""
                                            class="img-thumbnail rounded-circle">
                                    </div>
                                    <h5 class="font-size-15 text-truncate">{{ $name }}</h5>
                                    <p class="text-muted mb-0 text-truncate">{{ $email }} <br>
                                        {{ $customer->phone }} </p>
                                </div>

                                <div class="col-sm-12">
                                    <div class="mt-4">
                                        <a href="javascript: void(0);"
                                            class="btn btn-primary waves-effect waves-light btn-sm"
                                            data-bs-toggle="modal" data-bs-target="#updatePassword">Update Password<i
                                                class="mdi mdi-arrow-right ms-1"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end card -->
                </div>

                <div class="col-xl-8">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card mini-stats-wid">
                                <div class="card-body">
                                    <div class="d-flex">
                                        <div class="flex-grow-1">
                                            <p class="text-muted fw-medium mb-2">Completed Booking(s)/Order(s)</p>
                                            <h4 class="mb-0">{{ $orders->where('status', 'completed')->count() }}
                                            </h4>
                                        </div>

                                        <div class="flex-shrink-0 align-self-center">
                                            <div class="mini-stat-icon avatar-sm rounded-circle bg-success">
                                                <span class="avatar-title">
                                                    <i class="bx bx-check-circle font-size-24"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card mini-stats-wid">
                                <div class="card-body">
                                    <div class="d-flex">
                                        <div class="flex-grow-1">
                                            <p class="text-muted fw-medium mb-2">Ongoing Booking(s)/Order(s)</p>
                                            <h4 class="mb-0">
                                                {{ $orders->where('status', '!=', 'completed')->count() }}</h4>
                                        </div>

                                        <div class="flex-shrink-0 align-self-center">
                                            <div class="avatar-sm mini-stat-icon rounded-circle bg-primary">
                                                <span class="avatar-title">
                                                    <i class="bx bx-hourglass font-size-24"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title mb-4">Address</h4>
                            <hr>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Address</th>
                                        <th>Phone Number</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>


                                <tbody>
                                    @foreach ($addresses as $address)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{!! $address->address_1 . ' ' . $address->address_2 !!}</td>
                                            <td>{{ $address->phone_number }}</td>
                                            <td>
                                                <div class="text-end">
                                                    <a href="javascript:void(0);" data-bs-toggle="modal"
                                                        data-bs-target="#delete{{ $address->id }}"
                                                        class="link-danger"><i
                                                            class="mdi mdi-map-marker-remove-outline"></i></a>

                                                    <div id="delete{{ $address->id }}" class="modal fade"
                                                        tabindex="-1" aria-hidden="true" style="display: none;">
                                                        <div class="modal-dialog modal-dialog-centered">
                                                            <div class="modal-content">
                                                                <div class="modal-body text-center p-5">
                                                                    <div class="text-end">
                                                                        <button type="button"
                                                                            class="btn-close text-end"
                                                                            data-bs-dismiss="modal"
                                                                            aria-label="Close"></button>
                                                                    </div>
                                                                    <div class="mt-2">
                                                                        <lord-icon
                                                                            src="https://cdn.lordicon.com/wwneckwc.json"
                                                                            trigger="hover"
                                                                            style="width:150px;height:150px">
                                                                        </lord-icon>
                                                                        <h4 class="mb-3 mt-4">Are you sure you want to
                                                                            delete <br /> {{ $address->address_1 }}?
                                                                        </h4>
                                                                        <form
                                                                            action="{{ url('customer/deleteAddress') }}"
                                                                            method="POST">
                                                                            @csrf
                                                                            <input name="address_id" type="hidden"
                                                                                value="{{ $address->id }}">
                                                                            <hr>
                                                                            <button type="submit" id="submit-button"
                                                                                class="btn btn-danger w-100">Yes,
                                                                                Delete</button>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                                <div
                                                                    class="modal-footer bg-light p-3 justify-content-center">

                                                                </div>
                                                            </div><!-- /.modal-content -->
                                                        </div><!-- /.modal-dialog -->
                                                    </div><!-- /.modal -->
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title mb-4">Your Booking(s)/Order(s)</h4>
                            <hr>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">SKU</th>
                                            <th scope="col">Product Type</th>
                                            <th scope="col">Delivery Type</th>
                                            <th scope="col">Booking Date</th>
                                            <th scope="col">Status</th>
                                            <th scope="col"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($orders as $order)
                                            <tr>
                                                <th scope="row">{{ $loop->iteration }}</th>
                                                <td>{{ $order->sku }}</td>
                                                <td>{{ $order->product_type }}</td>
                                                <td>{{ ucwords($order->delivery_type) }}</td>
                                                <td>{{ !empty($order->booking_date)? date('F d, Y h:i A', strtotime($order->booking_date)) : null }}</td>
                                                <td>
                                                    @if ($order->status == 'pending')
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
                                                    <div class="hstack gap-3 fs-15">
                                                        <a class="btn btn-outline-secondary btn-sm edit"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#viewOrder{{ $order->id }}"
                                                            title="view">
                                                            <i class="fas fa-eye"></i>
                                                        </a>

                                                        @if ($order->status == 'pending' && ucwords($order->delivery_type) != 'Pickup')
                                                            <a class="btn btn-outline-primary btn-sm edit"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#edit{{ $order->id }}"
                                                                title="view">
                                                                <i class="fas fa-pencil-alt"></i>
                                                            </a>
                                                        @endif
                                                    </div>

                                                    <div class="modal fade" id="viewOrder{{ $order->id }}"
                                                        data-bs-backdrop="static" data-bs-keyboard="false"
                                                        tabindex="-1" role="dialog"
                                                        aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                                        <div class="modal-dialog .modal-dialog-scrollable modal-xl modal-dialog-centered"
                                                            role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="staticBackdropLabel">
                                                                        Order
                                                                        Information</h5>
                                                                    <button type="button" class="btn-close"
                                                                        data-bs-dismiss="modal"
                                                                        aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body row">
                                                                    <div class="col-xl-8">
                                                                        <div class="card">
                                                                            <div class="card-body">
                                                                                <div class="table-responsive">
                                                                                    <table
                                                                                        class="table align-middle mb-0 table-nowrap">
                                                                                        <thead class="table-light">
                                                                                            <tr>
                                                                                                <th>#</th>
                                                                                                <th>Product</th>
                                                                                                <th>Quantity</th>
                                                                                                <th>Price</th>
                                                                                                <th colspan="2">
                                                                                                    Total
                                                                                                </th>
                                                                                            </tr>
                                                                                        </thead>
                                                                                        <tbody>
                                                                                            @foreach ($order->cartItems as $cartItem)
                                                                                                <tr class="product">
                                                                                                    <td>{{ $loop->iteration }}
                                                                                                    </td>
                                                                                                    <td>
                                                                                                        <h5
                                                                                                            class="font-size-14 text-truncate">
                                                                                                            <a href="#"
                                                                                                                class="text-dark">{{ $cartItem->name }}</a>
                                                                                                        </h5>
                                                                                                        <p
                                                                                                            class="mb-0">
                                                                                                            {{ $cartItem->description }}
                                                                                                        </p>
                                                                                                    </td>
                                                                                                    <td><span
                                                                                                            class="product-price">{{ $cartItem->quantity }}</span>
                                                                                                    </td>
                                                                                                    <td>£<span
                                                                                                            class="product-line-price">{{ $cartItem->price / number_format($cartItem->quantity) }}</span>
                                                                                                    </td>
                                                                                                    <td>£<span
                                                                                                            class="product-line-price">{{ $cartItem->price }}</span>
                                                                                                    </td>
                                                                                                </tr>
                                                                                            @endforeach

                                                                                        </tbody>
                                                                                    </table>
                                                                                </div>
                                                                            </div>
                                                                            <div class="card-body">
                                                                                @if ($order->address)
                                                                                    <p class="mb-0">Address : <span
                                                                                            class="fw-medium">{{ $order->address->address_1 . ' ' . $order->address->address_2 }}</span>
                                                                                    </p>
                                                                                    <p class="mb-0">Phone Number :
                                                                                        <span
                                                                                            class="fw-medium">{{ $order->address->phone_number }}</span>
                                                                                    </p>
                                                                                @endif
                                                                                <p class="mb-0">Additional
                                                                                    Information :
                                                                                    <span
                                                                                        class="fw-medium">{{ $order->additional_information }}</span>
                                                                                </p>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-xl-4">
                                                                        <div class="card">
                                                                            <div class="card-body">
                                                                                <h4 class="card-title mb-3">Order
                                                                                    Summary
                                                                                </h4>
                                                                                <hr>
                                                                                <div class="table-responsive">
                                                                                    <table class="table mb-0">
                                                                                        <tbody>
                                                                                            <tr>
                                                                                                <td>Grand Total :</td>
                                                                                                <td id="cart-subtotal">
                                                                                                    £{{ number_format($order->amount_paid / 100, 2) }}
                                                                                                </td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td>Service Charge : </td>
                                                                                                <td id="cart-discount">£0.50</td>
                                                                                            </tr>
                                                                                            @if($order->product_type == 'Food')
                                                                                            <tr>
                                                                                                <td>Shipping Charge :</td>
                                                                                                <td id="cart-shipping">£3.00</td>
                                                                                            </tr>
                                                                                            @endif
                                                                                            <tr class="bg-light">
                                                                                                <th>Total :</th>
                                                                                                <th id="cart-total">
                                                                                                    £{{ number_format($order->amount_paid / 100, 2) }}
                                                                                                </th>
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
                                                                    <button type="button" class="btn btn-danger"
                                                                        data-bs-dismiss="modal">Close</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div id="edit{{ $order->id }}" class="modal fade"
                                                        tabindex="-1" aria-hidden="true" style="display: none;">
                                                        <div class="modal-dialog modal-dialog-centered">
                                                            <div class="modal-content border-0 overflow-hidden">
                                                                <div class="modal-header p-3">
                                                                    <h4 class="card-title mb-0">Update Booking/Delivery
                                                                        Date</h4>
                                                                    <button type="button" class="btn-close"
                                                                        data-bs-dismiss="modal"
                                                                        aria-label="Close"></button>
                                                                </div>

                                                                <div class="modal-body">
                                                                    <form action="{{ url('/customer/updateOrder') }}"
                                                                        method="post" enctype="multipart/form-data">
                                                                        @csrf

                                                                        <input name="order_id" type="hidden"
                                                                            value="{{ $order->id }}">
                                                                        <input value="{{ $order->product_type }}"
                                                                            type="hidden" id="productType">


                                                                        <div class="form-group">
                                                                            <label for="bookingDateTime">Booking Date
                                                                                and Time</label>
                                                                            <input class="form-control"
                                                                                type="datetime-local"
                                                                                id="bookingDateTime"
                                                                                name="bookingDateTime">
                                                                        </div>

                                                                        <div class="alert alert-danger fade mt-3"
                                                                            id="availabilityAlert" role="alert">
                                                                            <i class="mdi mdi-block-helper me-2"></i>
                                                                            <p id="availabilityMessage"></p>
                                                                        </div>

                                                                        <hr>
                                                                        <div class="text-end">
                                                                            <button type="submit" id="submit-button"
                                                                                class="btn btn-primary">Save
                                                                                Changes</button>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div><!-- /.modal-content -->
                                                        </div><!-- /.modal-dialog -->
                                                    </div><!-- /.modal -->

                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <hr class="my-5">
        </div>
        <!-- end container -->
    </section>
    <!-- about section end -->


    <!-- Static Backdrop Modal -->
    <div class="modal fade" id="updatePassword" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Update Profile</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="{{ url('/customer/register') }}">
                    @csrf
                    <div class="modal-body">

                        <div class="mb-3">
                            <label for="useremail" class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" id="useremail"
                                value="{{ $customer->email }}" required>
                            <div class="invalid-feedback">
                                Please Enter Email
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-floating mb-3">
                                    <input type="text" name="lastname" class="form-control" id="lastname"
                                        value="{{ $customer->lastname }}" required>
                                    <div class="invalid-feedback">
                                        Please Enter Lastname
                                    </div>
                                    <label for="lastname" class="form-label">Lastname</label>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-floating mb-3">
                                    <input type="text" name="othernames" class="form-control" id="othernames"
                                        value="{{ $customer->othernames }}" required>
                                    <div class="invalid-feedback">
                                        Please Enter Other Names
                                    </div>
                                    <label for="othernames" class="form-label">Othernames</label>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label class="form-label">Phone Number</label>
                                        <div class="input-group">
                                            <button class="btn btn-light " type="button">+44</i></button>
                                            <input type="text" name="phone" class="form-control"
                                                placeholder="Enter Phone Number">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Password</label>
                                    <div class="input-group auth-pass-inputgroup">
                                        <button class="btn btn-light " type="button"><i
                                                class="mdi mdi-lock"></i></button>
                                        <input type="password" name="password" class="form-control"
                                            placeholder="Enter password" aria-label="Password"
                                            aria-describedby="password-addon">
                                        <button class="btn btn-light " type="button" id="password-addon"><i
                                                class="mdi mdi-eye-outline"></i></button>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Confirm Password</label>
                                    <div class="input-group">
                                        <button class="btn btn-light " type="button"><i
                                                class="mdi mdi-lock"></i></button>
                                        <input type="password" name="password_confirmation" class="form-control"
                                            placeholder="Confirm password">
                                    </div>
                                </div>
                            </div>
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

    <!-- Footer start -->
    <footer class="landing-footer">
        <div class="container">


            <hr class="footer-border my-5">

            <div class="row">
                <div class="col-lg-8">
                    <div class="mb-4">
                        <img src="{{ asset('assets/images/logo-light.png') }}" alt="" height="100">
                    </div>

                    <p class="mb-2">
                        <script>
                            document.write(new Date().getFullYear())
                        </script> © {{ env('APP_NAME') }}. Design & Develop by KoderiaNG
                    </p>
                    <p>{{ env('APP_DESCRIPTION') }}</p>
                </div>

            </div>
        </div>
        <!-- end container -->
    </footer>
    <!-- Footer end -->

    <!-- JAVASCRIPT -->
    <script src="{{ asset('assets/libs/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/libs/metismenu/metisMenu.min.js') }}"></script>
    <script src="{{ asset('assets/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('assets/libs/node-waves/waves.min.js') }}"></script>

    <script src="{{ asset('assets/libs/jquery.easing/jquery.easing.min.js') }}"></script>

    <!-- Plugins js-->
    <script src="{{ asset('assets/libs/jquery-countdown/jquery.countdown.min.js') }}"></script>

    <!-- owl.carousel js -->
    <script src="{{ asset('assets/libs/owl.carousel/owl.carousel.min.js') }}"></script>

    <!-- Required datatable js -->
    <script src="{{ asset('assets/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <!-- Buttons examples -->
    <script src="{{ asset('assets/libs/datatables.net-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('assets/libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/libs/jszip/jszip.min.js') }}"></script>
    <script src="{{ asset('assets/libs/pdfmake/build/pdfmake.min.js') }}"></script>
    <script src="{{ asset('assets/libs/pdfmake/build/vfs_fonts.js') }}"></script>
    <script src="{{ asset('assets/libs/datatables.net-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('assets/libs/datatables.net-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('assets/libs/datatables.net-buttons/js/buttons.colVis.min.js') }}"></script>

    <!-- Responsive examples -->
    <script src="{{ asset('assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js') }}"></script>

    <!-- Datatable init js -->
    <script src="{{ asset('assets/js/pages/datatables.init.js') }}"></script>
    <!-- ICO landing init -->
    <script src="{{ asset('assets/js/pages/ico-landing.init.js') }}"></script>

    <script src="{{ asset('assets/js/app.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        sessionStorage.clear();
    </script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#datatables1').DataTable({
                dom: 'Bfrtip',
            });
            $('#buttons-datatables1').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ]
            });

            $('#buttons-datatables2').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ]
            });

            $('#buttons-datatables3').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ]
            });

            $('#buttons-datatables4').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ]
            });

            $('#buttons-datatables5').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ]
            });

            $('#buttons-datatables6').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ]
            });

            $('#buttons-datatables7').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ]
            });
        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.getElementById('bookingDateTime').addEventListener('change', function() {
                const selectedDateTime = document.getElementById('bookingDateTime').value;
                checkAvailability(selectedDateTime);
            });
        });

        function checkAvailability(selectedDateTime) {
            axios.post('/customer/checkAvailability', {
                    dateTime: selectedDateTime,
                    productType: 'Hair'
                })
                .then(function(response) {
                    const isAvailable = response.data.available;
                    if (!isAvailable) {
                        showAvailabilityAlert("Selected date and time is not available. Please choose another.");
                        document.getElementById('bookingDateTime').value = '';
                    }
                })
                .catch(function(error) {
                    console.error('Error checking availability:', error);
                });
        }

        function showAvailabilityAlert(message) {
            const alertDiv = document.getElementById('availabilityAlert');
            const messageParagraph = document.getElementById('availabilityMessage');
            messageParagraph.textContent = message;
            alertDiv.classList.add('show');
        }
    </script>


</body>

</html>
