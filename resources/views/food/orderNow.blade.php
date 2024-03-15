@php
// Get the cart items from the session
$cartItems = session('cart');

// Initialize subtotal variable
$subtotal = 0;

// Calculate subtotal
if(!empty($cartItems))
    foreach ($cartItems as $item) {
        $subtotal += $item['price'];
    }
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

        <nav class="navbar navbar-expand-lg navigation fixed-top sticky">
            <div class="container">
                <a class="navbar-logo" href="{{ url('/') }}">
                    <img src="{{ asset('assets/images/logo-dark.png') }}" alt="" height="19" class="logo logo-dark">
                    <img src="{{ asset('assets/images/logo-light.png') }}" alt="" height="19" class="logo logo-light">
                </a>

                <button type="button" class="btn btn-sm px-3 font-size-16 d-lg-none header-item waves-effect waves-light" data-bs-toggle="collapse" data-bs-target="#topnav-menu-content">
                    <i class="fa fa-fw fa-bars"></i>
                </button>
              
                <div class="collapse navbar-collapse" id="topnav-menu-content">
                    <ul class="navbar-nav ms-auto" id="topnav-menu" >
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/') }}">Afro serves all</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#home">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="{{ url('/orderNow') }}">Order Here</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#faqs">Contact Us</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <!-- hero section start -->
        <section class="section hero-section bg-ico-hero" id="home" style="background-image:url({{ asset('assets/images/bg_img_1.jpg') }});background-size:cover;background-position:top">
            <div class="bg-overlay bg-darke"></div>
            <div class="container">
                <div class="row align-items-center mt-5 pt-5">
                    <div class="col-lg-12 col-md-12 col-sm-12 ms-lg-auto">
                        <div class="card overflow-hidden mb-0 mt-5 mt-lg-0" style="background-color: rgba(255, 255, 255, 0.1);">
                            <div class="card-header text-center">
                                <h5 class="mb-0">Place your order here</h5>
                            </div>
                            <div class="card-body">
                                <div class="container">
                                    <div class="row">
                                        <!-- First Column: Products (Hidden on Small Screens) -->
                                        <div class="col-md-2 d-none d-md-block">
                                            <h2 class="text-light">Menu Items</h2>
                                            <div class="list-group" id="productList">
                                                @foreach($foodProducts as $product)
                                                    <a href="#collapse{{ $product->id }}" class="list-group-item product-link">{{ $product->name }}</a>
                                                @endforeach
                                            </div>
                                        </div>
                                        
                                        <!-- Second Column: Features (Accordion) -->
                                        <div class="col-md-6">
                                            <h2></h2>
                                            <div id="accordion">
                                                @foreach($foodProducts as $product)
                                                    <div class="accordion-item">
                                                        <div class="card">
                                                            <div class="card-header bg-muted" id="heading_{{ $product->id }}">
                                                                <h2 class="accordion-header" id="heading{{ $product->id }}">
                                                                    <button class="accordion-button fw-medium collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $product->id }}" aria-expanded="false" aria-controls="collapse{{ $product->id }}">
                                                                        {{ $product->name }} <br>
                                                                    </button>
                                                                </h2>
                                                                <small>{{ $product->description }}</small>
                                                            </div>
                            
                                                            <div id="collapse{{ $product->id }}" class="accordion-collapse" aria-labelledby="heading{{ $product->id }}" data-bs-parent="#accordion">
                                                                <div class="accordion-body">
                                                                    @foreach($product->features as $feature)
                                                                    <div class="px-3 mb-3">
                                                                        <div class="row row-cols-lg-auto g-3 d-flex justify-content-between align-items-center flex-column flex-lg-row">
                                                                            <div class="col-12">
                                                                                <!-- Feature name -->
                                                                                <span>{{ $feature->feature }}</span>
                                                                            </div>
                                                                        
                                                                            <div class="col-auto">
                                                                                <div class="input-group input-group-sm flex-nowrap">
                                                                                    <!-- Price button -->
                                                                                    <button type="button" class="btn btn-outline-secondary input-group-text">
                                                                                        <strong><span class="text-danger">${{ $feature->price }}</span></strong>
                                                                                    </button>
                                                                                    <!-- Quantity buttons -->
                                                                                    <button type="button" class="btn btn-outline-secondary input-group-text minus-button">
                                                                                        <i class="mdi mdi-minus"></i>
                                                                                    </button>
                                                                                    <input type="hidden" class="product-id" value="{{ $product->id }}">
                                                                                    <input type="hidden" class="feature-id" value="{{ $feature->id }}">
                                                                                    <!-- Input field for quantity -->
                                                                                    <input class="form-control quantity-input" type="number" value="1" min="1" style="max-width: 60px;">
                                                                                    <!-- Increase button -->
                                                                                    <button type="button" class="btn btn-outline-secondary input-group-text plus-button">
                                                                                        <i class="mdi mdi-plus"></i>
                                                                                    </button>
                                                                                    <!-- Add to cart button -->
                                                                                    <button type="button" class="btn btn-sm btn-primary add-to-cart-button"><i class="mdi mdi-cart-outline"></i></button>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        
                                                                        <!-- Description -->
                                                                        <p><small>{{ $feature->description }}</small></p>
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
                                            <h2 class="text-light">Cart Items</h2>
                                            <div class="card p-3" id="cart-items-container">
                                                @if(session()->has('cart') && count(session('cart')) > 0)
                                                    <!-- Cart items will be dynamically added here by JavaScript -->
                                                    @endforeach
                                                @else
                                                    <p>Your cart is empty.</p>
                                                @endif
                                            </div>
                                        
                                            <!-- Subtotal -->
                                            <div class="card p-3">
                                                <!-- Subtotal -->
                                                <div class="text-end mt-1">
                                                    <strong>Subtotal:</strong> $<span id="subtotal">00.00</span>
                                                </div>
                                                <hr>
                                                <textarea class="form-control mb-3" placeholder="Additional information"></textarea>
                                        
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input" type="radio" name="delivery" id="pickup" value="pickup" checked>
                                                    <label class="form-check-label" for="pickup">Pickup</label>
                                                </div>
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input" type="radio" name="delivery" id="delivery" value="delivery">
                                                    <label class="form-check-label" for="delivery">Delivery</label>
                                                </div>
                                        
                                                <hr>
                                                <button type="button" class="btn btn-primary">Proceed to Checkout</button>
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
       

        <!-- Footer start -->
        <footer class="landing-footer">
            <div class="container">
                <hr class="footer-border my-5">

                <div class="row">
                    <div class="col-lg-6">
                        <div class="mb-4">
                            <img src="assets/images/logo-light.png" alt="" height="20">
                        </div>
    
                        <p class="mb-2"><script>document.write(new Date().getFullYear())</script> © {{ env('APP_NAME') }}. Design & Develop by KoderiaNG</p>
                        <p{{ env('APP_DESCRIPTION') }}</p>
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
        <script>
           document.addEventListener('DOMContentLoaded', function () {
            fetchCartItems();

            // Event delegation for minus buttons
            document.addEventListener('click', function(event) {
                if (event.target.classList.contains('cart-minus-button')) {
                    const quantityInput = event.target.parentNode.querySelector('.cart-quantity-input');
                    if (parseInt(quantityInput.value) > 1) {
                        quantityInput.value = parseInt(quantityInput.value) - 1;
                        updateCartQuantity(event.target, 'decrease');
                    }
                }
            });

            // Event delegation for plus buttons
            document.addEventListener('click', function(event) {
                if (event.target.classList.contains('cart-plus-button')) {
                    const quantityInput = event.target.parentNode.querySelector('.cart-quantity-input');
                    quantityInput.value = parseInt(quantityInput.value) + 1;
                    updateCartQuantity(event.target, 'increase');
                }
            });

            const minusButtons = document.querySelectorAll('.minus-button');
            minusButtons.forEach(function(minusButton) {
                minusButton.addEventListener('click', function() {
                    const quantityInput = this.parentNode.querySelector('.quantity-input');
                    if (parseInt(quantityInput.value) > 1) {
                        quantityInput.value = parseInt(quantityInput.value) - 1;
                    }
                });
            });

            const plusButtons = document.querySelectorAll('.plus-button');
            plusButtons.forEach(function(plusButton) {
                plusButton.addEventListener('click', function() {
                    const quantityInput = this.parentNode.querySelector('.quantity-input');
                    quantityInput.value = parseInt(quantityInput.value) + 1;
                });
            });

            const addToCartButtons = document.querySelectorAll('.add-to-cart-button');
                addToCartButtons.forEach(function(button) {
                    button.addEventListener('click', function () {
                        const featureId = this.parentElement.querySelector('.feature-id').value;
                        const productId = this.parentElement.querySelector('.product-id').value;
                        const quantity = this.parentElement.querySelector('.quantity-input').value;
                        console.log(featureId, productId, quantity);
                    
                        // Send a POST request to the Laravel route
                        axios.post('/customer/addToCart', { product_id: productId, feature_id: featureId, quantity: quantity })
                            .then(function (response) {
                                if (response.data.status === 'error') {
                                    // Show a SweetAlert for record not found
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Product could not be added to cart',
                                        text: 'Product not found',
                                    });
                                } else {
                                    updateCartSection(response.data.cart);
                                }
                            })
                            .catch(function (error) {
                                console.error(error);
                            });
                    });
                });

            });

            function updateCartQuantity(button, action) {
                const productId = button.parentElement.querySelector('.cart-product-id').value;
                const featureId = button.parentElement.querySelector('.cart-feature-id').value;

                axios.post('/customer/updateQuantity', { productId: productId, featureId: featureId, action: action })
                    .then(function(response) {
                        fetchCartItems();
                    })
                    .catch(function(error) {
                        console.error(error);
                    });
            }

            function fetchCartItems() {
                axios.get('/customer/getCartItems')
                    .then(function(response) {
                        const cart = response.data.cart;
                        updateCartSection(cart);
                    })
                    .catch(function(error) {
                        console.error(error);
                    });
            }

            function updateCartSection(cartItems) {
                const cartContainer = document.getElementById('cart-items-container');
                const subtotalElement = document.getElementById('subtotal');
                let subtotal = 0;

                // Clear existing cart items
                cartContainer.innerHTML = '';

                if (cartItems.length > 0) {
                    cartItems.forEach(function(cartItem) {
                        const itemElement = document.createElement('div');
                        itemElement.classList.add('px-3', 'mb-3');
                        itemElement.innerHTML = `
                            <div class="row row-cols-lg-auto g-3 d-flex justify-content-between align-items-center flex-column flex-lg-row">
                                <div class="col-12">
                                    <span>${cartItem.name}</span>
                                </div>
                                <div class="col-auto">
                                    <div class="input-group input-group-sm flex-nowrap">
                                        <input type="hidden" class="cart-product-id" value="${cartItem.product_id}">
                                        <input type="hidden" class="cart-feature-id" value="${cartItem.feature_id}">
                                        <button type="button" class="btn btn-outline-secondary input-group-text cart-minus-button">
                                            <i class="mdi mdi-minus"></i>
                                        </button>
                                        <input class="form-control cart-quantity-input" type="number" value="${cartItem.quantity}" min="1" style="max-width: 60px;">
                                        <button type="button" class="btn btn-outline-secondary input-group-text cart-plus-button">
                                            <i class="mdi mdi-plus"></i>
                                        </button>
                                        <button type="button" class="btn btn-outline-secondary input-group-text">
                                            <strong><span class="text-danger">$${(cartItem.price).toFixed(2)}</span></strong>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <p><small>${cartItem.description}</small></p>
                            <hr>
                        `;
                        cartContainer.appendChild(itemElement);

                        subtotal += parseFloat(cartItem.price);
                    });

                    // Reattach event listeners for plus and minus buttons
                    attachEventListeners();
                } else {
                    cartContainer.innerHTML = '<p>Your cart is empty.</p>';
                }

                subtotalElement.textContent = subtotal.toFixed(2);
            }

            function attachEventListeners() {
                // Add event listeners for minus buttons
                const minusButtons = document.querySelectorAll('.cart-minus-button');
                minusButtons.forEach(function(minusButton) {
                    minusButton.addEventListener('click', function() {
                        const quantityInput = this.parentNode.querySelector('.cart-quantity-input');
                        if (parseInt(quantityInput.value) > 1) {
                            quantityInput.value = parseInt(quantityInput.value) - 1;
                            updateCartQuantity(this, 'decrease');
                        }

                        if (parseInt(quantityInput.value) < 2) {
                            quantityInput.value = parseInt(quantityInput.value) - 1;
                            updateCartQuantity(this, 'delete');
                        }
                    });
                });

                // Add event listeners for plus buttons
                const plusButtons = document.querySelectorAll('.cart-plus-button');
                plusButtons.forEach(function(plusButton) {
                    plusButton.addEventListener('click', function() {
                        const quantityInput = this.parentNode.querySelector('.cart-quantity-input');
                        quantityInput.value = parseInt(quantityInput.value) + 1;
                        updateCartQuantity(this, 'increase');
                    });
                });
            }
        </script>
        <script>
            // Smooth scroll to accordion sections and open accordion on product click
            $(document).ready(function(){
                $('.product-link').on('click', function (e) {
                    e.preventDefault();
                    var target = $(this).attr('href');
                    $('html, body').animate({
                        scrollTop: $(target).offset().top
                    }, 1000);
                    $(target).collapse('show');
                });
            });
        </script>

    </body>

</html>