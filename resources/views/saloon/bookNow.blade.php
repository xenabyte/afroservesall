@php
    // Get the cart items from the session
    $cartItems = session('cart');
    session()->put('type', 'Hair');
    $type =  session('type');


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
    $storeStatus = !empty($pageGlobalData->setting) ? $pageGlobalData->setting->saloon_status : null;

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
                        <a class="nav-link" href="{{ url('/') }}">Afroservesall</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('saloonBooking') }}#home">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ url('/bookNow') }}">Book Now</a>
                    </li>
                </ul>
            </div>
            <button type="button" class="btn header-item noti-icon waves-effect bg-white"
                id="page-header-notifications-dropdown">
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
                        <span class="dropdown-item d-none d-xl-inline-block ms-2 nav-link" key="t-henry">Welcome <br>{{ $name }}</span>
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
            @else
                <button type="button" class="btn header-item waves-effect bg-white" id="auth"
                    style="margin-right: 5px;">
                    <img class="rounded-circle header-profile-user"
                        src="{{ asset('assets/images/users/avatar.png') }}" alt="Header Avatar">
                </button>
            @endif
        </div>
    </nav>
    <style>
        .container-wrapper {
            position: relative;
        }

        #overflow-button {
            position: absolute;
            top: 10px; /* Adjust top position as needed */
            right: 10px; /* Adjust right position as needed */
            z-index: 2; /* Ensure it's above the overlay */
        }
    </style>

    <!-- hero section start -->
    <section class="section hero-section bg-ico-hero" id="home"
        style="background-image:url({{ asset('assets/images/services/s4.jpg') }});background-size:cover;background-position:top">
        <div class="bg-overlay bg-darke"></div>
        <div class="container-wrapper">
            <div class="container"  style="height:700px;overflow-x:hidden;">
                <div class="row align-items-center">
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
                                                    <small class="text-danger">By increasing the quantity means you are
                                                        booking for more than 1 person.</small> <br>
                                                    <small class="text-danger">The prices stated are minimum prices as
                                                        prices differ according to volume and length of hair.</small>
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
                                        <div class="col-md-4"  id="cart-session">
                                            <h2 class="text-light">Booking Information</h2>
                                            <div id="response"></div>
                                            <div id="error"></div>
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
                                                    <span>Pay non-refundable booking fee</span><br>
                                                    <strong>Subtotal:</strong> £<span id="subtotal"  style="text-decoration: line-through;">00.00</span> £<span>30.00</span> 
                                                </div>
                                                <hr>
                                                <textarea class="form-control mb-3" id="additionalInfo" placeholder="Additional information"></textarea>
                                                <div class="form-group">
                                                    <label for="bookingDateTime">Booking Date and Time</label>
                                                    <input class="form-control" type="datetime-local"
                                                        id="bookingDateTime" name="bookingDateTime">
                                                </div>

                                                <div class="alert alert-danger fade mt-3" id="availabilityAlert"
                                                    role="alert">
                                                    <i class="mdi mdi-block-helper me-2"></i>
                                                    <p id="availabilityMessage"></p>
                                                </div>

                                                <input type="hidden" name="delivery" id="deliveryType"
                                                    value="delivery">
                                                <hr>
                                                <button type="button" @if ($storeStatus == 'Closed') disabled @endif
                                                    class="btn btn-primary" id="proceedToCheckoutBtn">Proceed to
                                                    Checkout</button>
                                            </div>

                                            <div class="card">
                                                <div class="card-body">
                                                    <h4 class="card-title mb-4">Business Hours</h4>
                                                    <div class="mt-4">
                                                        <div class="table-responsive">
                                                            <table
                                                                class="table table-nowrap align-middle table-hover mb-0">
                                                                <tbody>
                                                                    @if (!empty($pageGlobalData->hairActiveHours))
                                                                        @foreach ($pageGlobalData->hairActiveHours as $hairActiveHour)
                                                                            <tr>
                                                                                <td>
                                                                                    <h5
                                                                                        class="text-truncate font-size-14 mb-1">
                                                                                        <a href="javascript: void(0);"
                                                                                            class="text-dark">{{ $hairActiveHour->week_days }}</a>
                                                                                    </h5>
                                                                                    <p class="text-muted mb-0">
                                                                                        {{ date('h:i A', strtotime($hairActiveHour->opening_hours)) }}
                                                                                        -
                                                                                        {{ date('h:i A', strtotime($hairActiveHour->closing_hours)) }}
                                                                                    </p>
                                                                                </td>
                                                                            </tr>
                                                                        @endforeach
                                                                    @endif
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

                        </div>
                    </div>
                </div>
                <!-- end row -->
            </div>
            <span id="overflow-button"></span>
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
                        <span>Pay non-refundable booking fee</span><br>
                        <strong>Subtotal:</strong> £<span id="orderSubtotal" style="text-decoration: line-through;">00.00</span> £<span>30.00</span> 
                    </div>
                    <hr>
                    <button type="button" class="btn btn-primary" id="proceedToPayment">Proceed to Payment</button>
                </div>
            </div>
        </div>
    </div>

    <!-- storeClosModal -->
    <div class="modal fade" id="storeClosModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="storeClosModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header border-bottom-0">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="text-center mb-4">
                        <div class="avatar-md mx-auto mb-4">
                            <div class="avatar-title bg-danger rounded-circle text-primary h1">
                                <i class="text-light mdi mdi-door-closed-lock"></i>
                            </div>
                        </div>

                        <div class="row justify-content-center">
                            <div class="col-xl-10">
                                <h4 class="text-primary">Shop Closed</h4>
                                <p class="text-muted font-size-14 mb-4">
                                    {{ !empty($pageGlobalData->setting) ? $pageGlobalData->setting->saloon_message : null }}
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end modal -->


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
        const isAuthenticated = "<?php echo $isAuthenticated; ?>";

        document.addEventListener('DOMContentLoaded', function() {
            var button = document.getElementById('page-header-notifications-dropdown');
            var cartSection = document.getElementById('cart-session');

            button.addEventListener('click', function() {
                cartSection.scrollIntoView({ behavior: 'smooth' });
            });
        });

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

        if (isAuthenticated != ''){
            document.getElementById('auth').addEventListener('click', function() {
                $('#loginModal').modal('show');
            });
        }

        $(document).ready(function() {
            if ("{{ $storeStatus }}" == 'Closed') {
                $('#storeClosModal').modal('show');
            }
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
            const bookingDate = document.getElementById('bookingDateTime').value;
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
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'An error occurred while processing your request.',
                    });
                });
        });

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
     <script>
        $(document).ready(function(){
            var imageUrls = [
                "{{ asset('assets/images/services/s5.jpg') }}",
                "{{ asset('assets/images/services/s3.jpg') }}",
                "{{ asset('assets/images/services/s1.jpg') }}",
                // Add more image URLs as needed
            ];

            var heroSection = $('.hero-section');
            var overlay = $('.bg-overlay');

            var index = 0;
            var img = new Image();
            img.onload = function() {
                overlay.fadeOut(50, function() {
                    heroSection.css('background-image', 'url(' + imageUrls[index] + ')');
                    overlay.show();
                });
            };
            img.src = imageUrls[index];

            setInterval(function(){
                index = (index + 1) % imageUrls.length;
                overlay.fadeIn(500, function() {
                    var nextImg = new Image();
                    nextImg.onload = function() {
                        heroSection.css('background-image', 'url(' + imageUrls[index] + ')');
                    };
                    nextImg.src = imageUrls[index];
                });
            }, 5000); // Change image every 5 seconds
        });
    </script>
</body>

</html>
