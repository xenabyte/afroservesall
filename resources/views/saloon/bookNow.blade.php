@php
    // Get the cart items from the session
    $cartItems = session('cart');

    // Initialize subtotal variable
    $subtotal = 0;

    // Calculate subtotal
    if (!empty($cartItems)) {
        foreach ($cartItems as $item) {
            $subtotal += $item['price'];
        }
    }

    $customer = Auth::guard('customer')->user();
    $isAuthenticated = !empty($customer) ? true : false;
    $name = !empty($customer) ? $customer->lastname . ' ' . $customer->othernames : null;
    $addresses = !empty($customer) ? $customer->addresses : null;
@endphp
<!doctype html>
<html lang="en">


<head>

    <meta charset="utf-8" />
    <title>{{ env('APP_NAME') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content={{ env('APP_DESCRIPTION') }}" name="description" />
    <meta content="KoderiaNg" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}">

    <!-- owl.carousel css -->
    <link rel="stylesheet" href="{{ asset('assets/libs/owl.carousel/assets/owl.carousel.min.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/libs/owl.carousel/assets/owl.theme.default.min.css') }}">

    <!-- Bootstrap Css -->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="{{ asset('assets/css/app.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />
    <!-- App js -->
    <script src="{{ asset('assets/js/plugin.js') }}"></script>

</head>

<body data-bs-spy="scroll" data-bs-target="#topnav-menu" data-bs-offset="60">
    @include('sweetalert::alert')

    <nav class="navbar navbar-expand-lg navigation fixed-top sticky">
        <div class="container">
            <button type="button" class="btn btn-sm px-3 font-size-16 d-lg-none header-item waves-effect waves-light"
                data-bs-toggle="collapse" data-bs-target="#topnav-menu-content">
                <i class="fa fa-fw fa-bars"></i>
            </button>

            <a class="navbar-logo" href="{{ url('/') }}">
                <img src="{{ asset('assets/images/logo-dark.png') }}" alt="" height="19"
                    class="logo logo-dark">
                <img src="{{ asset('assets/images/logo-light.png') }}" alt="" height="19"
                    class="logo logo-light">
            </a>

            <div class="collapse navbar-collapse" id="topnav-menu-content">
                <ul class="navbar-nav ms-auto" id="topnav-menu">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/') }}">Afro serves all</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ url('saloonBooking') }}#home">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/bookNow') }}">Book Now</a>
                    </li>
                </ul>
            </div>
            <button type="button" class="btn header-item noti-icon waves-effect bg-white"
                id="page-header-notifications-dropdown" data-bs-toggle="dropdown" aria-haspopup="true"
                aria-expanded="false">
                <i class="bx bx-cart bx-tada"></i>
                <span class="badge bg-danger rounded-pill" id="cart-items-badge">0</span>
            </button>
            @if (!empty($name))
                <div class="dropdown d-inline-block">
                    <button type="button" class="btn header-item waves-effect bg-white" id="page-header-user-dropdown"
                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="margin-right: 5px;">
                        <img class="rounded-circle header-profile-user"
                            src="{{ asset('assets/images/users/avatar.png') }}" alt="Header Avatar">
                        <span class="d-none d-xl-inline-block ms-1" key="t-henry"
                            style="margin-right: 5px;">{{ $name }}</span>
                        <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end">
                        <!-- item-->
                        <span class="dropdown-item d-none d-xl-inline-block ms-2 nav-link" key="t-henry">Welcome</span>
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
        style="background-image:url({{ asset('assets/images/services/s4.jpg') }});background-size:cover;background-position:top">
        <div class="bg-overlay bg-darke"></div>
        <div class="container">
            <div class="row align-items-center mt-5 pt-5">
                <div class="col-lg-12 col-md-12 col-sm-12 ms-lg-auto">
                    <div class="card overflow-hidden mb-0 mt-5 mt-lg-0"
                        style="background-color: rgba(255, 255, 255, 0.1);">
                        <div class="card-header text-center">
                            <h5 class="mt-4 mb-4">Book an appointment</h5>
                        </div>
                        <div class="card-body">
                            <div class="container">
                                <div class="row">
                                    <!-- First Column: Products (Hidden on Small Screens) -->
                                    <div class="col-md-2 d-none d-md-block">
                                        <h2 class="text-light">Hair Styles</h2>
                                        <div class="list-group" id="productList">
                                            @foreach ($hairProducts as $product)
                                                <a href="#collapse{{ $product->id }}"
                                                    class="list-group-item product-link">{{ $product->name }}</a>
                                            @endforeach
                                        </div>
                                    </div>

                                    <!-- Second Column: Features (Accordion) -->
                                    <div class="col-md-6">
                                        <h2></h2>
                                        <div class="card">
                                            <div class="card-header bg-muted">
                                                <small class="text-danger">By increasing the quantity means
                                                    you are booking for more than 1 person.</small>
                                            </div>
                                        </div>

                                        <div id="accordion">
                                            @foreach ($hairProducts as $product)
                                                <div class="accordion-item">
                                                    <div class="card">
                                                        <div class="card-header bg-muted"
                                                            id="heading_{{ $product->id }}">
                                                            <h2 class="accordion-header"
                                                                id="heading{{ $product->id }}">
                                                                <button class="accordion-button fw-medium collapsed"
                                                                    type="button" data-bs-toggle="collapse"
                                                                    data-bs-target="#collapse{{ $product->id }}"
                                                                    aria-expanded="false"
                                                                    aria-controls="collapse{{ $product->id }}">
                                                                    {{ $product->name }} <br>
                                                                </button>
                                                            </h2>
                                                            <small>{{ $product->description }}</small>
                                                        </div>

                                                        <div id="collapse{{ $product->id }}"
                                                            class="accordion-collapse"
                                                            aria-labelledby="heading{{ $product->id }}"
                                                            data-bs-parent="#accordion">
                                                            <div class="accordion-body">
                                                                @foreach ($product->features as $feature)
                                                                    <div class="px-3 mb-3">
                                                                        <div
                                                                            class="row row-cols-lg-auto g-3 d-flex justify-content-between align-items-center flex-column flex-lg-row">
                                                                            <div class="col-12">
                                                                                <!-- Feature name -->
                                                                                <span>{{ $feature->feature }}</span>
                                                                            </div>

                                                                            <div class="col-auto">
                                                                                <div
                                                                                    class="input-group input-group-sm flex-nowrap">
                                                                                    <!-- Price button -->
                                                                                    <button type="button"
                                                                                        class="btn btn-outline-secondary input-group-text">
                                                                                        <strong><span
                                                                                                class="text-danger">£{{ $feature->price }}</span></strong>
                                                                                    </button>
                                                                                    <!-- Quantity buttons -->
                                                                                    <button type="button"
                                                                                        class="btn btn-outline-secondary input-group-text minus-button">
                                                                                        <i class="mdi mdi-minus"></i>
                                                                                    </button>
                                                                                    <input type="hidden"
                                                                                        class="product-id"
                                                                                        value="{{ $product->id }}">
                                                                                    <input type="hidden"
                                                                                        class="feature-id"
                                                                                        value="{{ $feature->id }}">
                                                                                    <!-- Input field for quantity -->
                                                                                    <input
                                                                                        class="form-control quantity-input"
                                                                                        type="number" value="1"
                                                                                        min="1"
                                                                                        style="max-width: 60px;">
                                                                                    <!-- Increase button -->
                                                                                    <button type="button"
                                                                                        class="btn btn-outline-secondary input-group-text plus-button">
                                                                                        <i class="mdi mdi-plus"></i>
                                                                                    </button>
                                                                                    <!-- Add to cart button -->
                                                                                    <button type="button"
                                                                                        class="btn btn-sm btn-primary add-to-cart-button"><i
                                                                                            class="mdi mdi-cart-outline"></i></button>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <!-- Description -->
                                                                        <p><small>{{ $feature->description }}</small>
                                                                        </p>
                                                                        <hr>
                                                                    </div>
                                                                @endforeach

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>

                                    <!-- Third Column: Cart  d-none d-md-block -->
                                    <div class="col-md-4">
                                        <h2 class="text-light">Booking Information</h2>
                                        @if (!empty($name))
                                            <div class="card p-3">
                                                <p> {{ $name . '!,' }} Welcome back</p>
                                            </div>
                                        @endif
                                        <div class="card p-3" id="cart-items-container">
                                            <!-- Cart items will be dynamically added here by JavaScript -->
                                        </div>

                                        <!-- Subtotal -->
                                        <div class="card p-3">
                                            <div class="text-end mt-1">
                                                <strong>Subtotal:</strong> £<span id="subtotal">00.00</span>
                                            </div>
                                            <hr>
                                            <textarea class="form-control mb-3" id="additionalInfo" placeholder="Additional information"></textarea>
                                            <div class="form-group">
                                                <label for="deliveryDate">Booking Date</label>
                                                <input class="form-control" type="date" id="bookingDate"
                                                    name="bookingDate">
                                            </div>
                                            <input type="hidden" name="delivery" id="deliveryType"
                                                value="delivery">
                                            <hr>
                                            <button type="button" class="btn btn-primary"
                                                id="proceedToCheckoutBtn">Proceed to Checkout</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <!-- end row -->
        </div>
        <!-- end container -->
    </section>
    <!-- hero section end -->

    <!-- Proceed to Checkout Button -->

    @include('common.auth')

    <!-- Payment Modal -->
    <div class="modal fade" id="paymentModal" tabindex="-1" aria-labelledby="paymentModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="paymentModalLabel">Payment</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div>
                        <h5 class="text-primary">Order Details</h5>
                        <p class="text-muted">Get your free {{ env('APP_NAME') }} account now.</p>
                        <hr>
                    </div>
                    <div class="card p-3" id="order-items-container">
                        @if (session()->has('cart') && count(session('cart')) > 0)
                            <!-- Cart items will be dynamically added here by JavaScript -->
                        @else
                            <p>Your cart is empty.</p>
                        @endif
                    </div>
                    <input type="hidden" id="cartItemsInput" name="cartItems">
                    <div class="text-end mt-1">
                        <strong>Subtotal:</strong> £<span id="orderSubtotal">00.00</span>
                    </div>
                    <hr>
                    <button type="button" class="btn btn-primary" id="proceedToPayment">Proceed to Payment</button>
                </div>
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
                        <img src="assets/images/logo-light.png" alt="" height="20">
                    </div>

                    <p class="mb-2">
                        <script>
                            document.write(new Date().getFullYear())
                        </script> © {{ env('APP_NAME') }}. Design & Develop by KoderiaNG
                    </p>
                    <p{{ env('APP_DESCRIPTION') }}< /p>
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
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    <script src="{{ asset('assets/libs/jquery.easing/jquery.easing.min.js') }}"></script>

    <!-- Plugins js-->
    <script src="{{ asset('assets/libs/jquery-countdown/jquery.countdown.min.js') }}"></script>

    <!-- owl.carousel js -->
    <script src="{{ asset('assets/libs/owl.carousel/owl.carousel.min.js') }}"></script>

    <!-- ICO landing init -->
    <script src="{{ asset('assets/js/pages/ico-landing.init.js') }}"></script>

    <script src="{{ asset('assets/js/app.js') }}"></script>
    @include('common.food')

    <script type="text/javascript">
        document.getElementById('proceedToCheckoutBtn').addEventListener('click', function() {
            const isAuthenticated = "<?php echo $isAuthenticated; ?>";
            const deliveryType = document.getElementById('deliveryType').value;

            if (isAuthenticated == '') {
                $('#loginModal').modal('show');
            } else {
                if (deliveryType === 'pickup') {
                    // Show payment modal directly
                    $('#paymentModal').modal('show');
                } else {
                    $('#addressModal').modal('show');
                }
            }
        });


        document.getElementById('makePaymentBtn').addEventListener('click', function() {
            $('#addressModal').modal('hide');
            $('#paymentModal').modal('show');
        });
    </script>
    <script>
        // Smooth scroll to accordion sections and open accordion on product click
        $(document).ready(function() {
            $('.product-link').on('click', function(e) {
                e.preventDefault();
                var target = $(this).attr('href');
                $('html, body').animate({
                    scrollTop: $(target).offset().top
                }, 1000);
                $(target).collapse('show');
            });
        });

        document.getElementById('proceedToPayment').addEventListener('click', function() {
            const deliveryType = document.getElementById('deliveryType').value;
            const addressId = document.getElementById('addressId').value;
            const address1 = document.getElementById('address1').value;
            const address2 = document.getElementById('address2').value;
            const phone = document.getElementById('phone').value;
            const additionalInfo = document.getElementById('additionalInfo').value;
            const cartItems = document.getElementById('cartItemsInput').value;
            const bookingDate = document.getElementById('bookingDate').value;
            const productType = 'Hair';

            if (!bookingDate) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Please provide a booking date.',
                });
                return;
            }

            // Make sure all required fields are filled
            if (deliveryType === 'delivery' && (!addressId && !address1)) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Please provide an address.',
                });
                return;
            }

            // Prepare data to send to the server
            const data = {
                delivery_type: deliveryType,
                address_id: addressId,
                address_1: address1,
                address_2: address2,
                phone: phone,
                additional_infomation: additionalInfo,
                cart_items: cartItems,
                booking_date: bookingDate,
                product_type: productType,
            };

            // Send data to the server
            axios.post('/customer/placeOrder', data)
                .then(function(response) {

                    console.log(response);
                    const redirectUrl = response.data.redirectUrl;
                    const status = response.data.status;
                    const message = response.data.message;

                    if (redirectUrl) {
                        window.location.href = redirectUrl;
                    }

                    if (status == 'error') {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: message,
                        });
                    }
                })
                .catch(function(error) {
                    console.error(error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'An error occurred while processing your request.',
                    });
                });
        });
    </script>

</body>

</html>
