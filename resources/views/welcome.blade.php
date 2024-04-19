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
    <style>
        .hero-images img {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            opacity: 0;
            transition: opacity 1s ease-in-out;
        }

        .hero-images img.active {
            opacity: 1;
        }


    </style>

</head>

<body data-bs-spy="scroll" data-bs-target="#topnav-menu" data-bs-offset="60">

    <nav class="navbar navbar-expand-lg navigation fixed-top sticky">
        <div class="container">
            <a class="navbar-logo" href="{{ url('/') }}">
                <img src="{{ asset('assets/images/logo-dark.png') }}" alt="" height="19"
                    class="logo logo-dark">
                <img src="{{ asset('assets/images/logo-light.png') }}" alt="" height="19"
                    class="logo logo-light">
            </a>

            <button type="button" class="btn btn-sm px-3 font-size-16 d-lg-none header-item waves-effect waves-light"
                data-bs-toggle="collapse" data-bs-target="#topnav-menu-content">
                <i class="fa fa-fw fa-bars"></i>
            </button>

            <div class="collapse navbar-collapse" id="topnav-menu-content">
                <ul class="navbar-nav ms-auto" id="topnav-menu">
                    <li class="nav-item">
                        <a class="nav-link active" href="#home">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#about">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#features">Services</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#faqs">FAQs</a>
                    </li>
                </ul>

                <div class="my-2 ms-lg-2">
                    <a href="{{ url('foodOrder') }}" class="btn btn-outline-success w-xs">Place an order</a>
                </div>

                <div class="my-2 ms-lg-2">
                    <a href="{{ url('saloonBooking') }}" class="btn btn-outline-primary w-xs">Place a booking</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- hero section start -->
    <section class="section hero-section bg-ico-hero" id="home"
        style="background-image:url({{ asset('assets/images/bg_img_1.jpg') }});background-size:cover;background-position:top">
        <div class="bg-overlay bg-darke"></div>
        <div class="container">
            <div class="row align-items-center mt-5 pt-5">
                <div class="col-lg-7 mt-5 pt-5">
                    <div class="text-white-50 mt-5">
                        <h1 class="text-white fw-semibold mb-3 hero-title">Food or Craving Pampering? Afroservesall Has You Covered!</h1>
                        <p class="font-size-14">Order delicious meals from us and book appointments with us - all in one convenient shop!</p>
    
                        <div class="d-flex flex-wrap gap-2 mt-4">
                            <a href="#about" class="btn btn-light">What we do</a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end row -->
        </div>
        <!-- end container -->
    </section>
    


    <!-- about section start -->
    <section class="section pt-4 bg-white" id="about">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="text-center mb-5 mt-5">
                        <div class="small-title">About us</div>
                        <h4>What we do at Afroservesall?</h4>
                    </div>
                </div>
            </div>
            <div class="row align-items-center">
                <div class="col-lg-5">

                    <div class="text-muted">
                        <h4>Afroservesall: Your One-Stop Shop for Food & Beauty</h4>
                        <p>Afroservesall takes the hassle out of your day by offering two essential services in one user-friendly app:</p>
                        <p>Life gets busy, but that doesn't mean you have to sacrifice delicious food or self-care. Afroserves is here to simplify your life by offering two amazing services in one user-friendly app:</p>

                        <div class="d-flex flex-wrap gap-2">
                            <a href="#features" class="btn btn-success">Read more on our services</a>
                            {{-- <a href="javascript: void(0);" class="btn btn-outline-primary">How It work</a> --}}
                        </div>

                    </div>
                </div>

                <div class="col-lg-6 ms-auto">
                    <div class="mt-4 mt-lg-0">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="card border">
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <i class="mdi mdi-human-female h2 text-success"></i>
                                        </div>
                                        <h5>Saloon Services</h5>
                                        <p class="text-muted mb-0">Pamper yourself and enhance your beauty with us. Book appointments with us and pamper yourself with the help of skilled professionals.</p>

                                    </div>
                                    <div class="card-footer bg-transparent border-top text-center">
                                        <a href="{{ url('saloonBooking') }}" class="text-primary">Place a booking</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="card border mt-lg-5">
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <i class="mdi mdi-food h2 text-success"></i>
                                        </div>
                                        <h5>Food Ordering Services</h5>
                                        <p class="text-muted mb-0">Indulge in your culinary cravings by ordering from a wide variety of menu. We offer something for every taste bud, from local favorites to international cuisine.</p>

                                    </div>
                                    <div class="card-footer bg-transparent border-top text-center">
                                        <a href="{{ url('foodOrder') }}" class="text-primary">Place an order</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end row -->

            <hr class="my-5">

            {{-- <div class="row">
                    <div class="col-lg-12">
                        <div class="owl-carousel owl-theme clients-carousel" id="clients-carousel" dir="ltr">
                            <div class="item">
                                <div class="client-images">
                                    <img src="assets/images/clients/1.png" alt="client-img" class="mx-auto img-fluid d-block">
                                </div>
                            </div>
                            <div class="item">
                                <div class="client-images">
                                    <img src="assets/images/clients/2.png" alt="client-img" class="mx-auto img-fluid d-block">
                                </div>
                            </div>
                            <div class="item">
                                <div class="client-images">
                                    <img src="assets/images/clients/3.png" alt="client-img" class="mx-auto img-fluid d-block">
                                </div>
                            </div>
                            <div class="item">
                                <div class="client-images">
                                    <img src="assets/images/clients/4.png" alt="client-img" class="mx-auto img-fluid d-block">
                                </div>
                            </div>
                            <div class="item">
                                <div class="client-images">
                                    <img src="assets/images/clients/5.png" alt="client-img" class="mx-auto img-fluid d-block">
                                </div>
                            </div>
                            <div class="item">
                                <div class="client-images">
                                    <img src="assets/images/clients/6.png" alt="client-img" class="mx-auto img-fluid d-block">
                                </div>
                            </div>
                        </div>
                    </div>
                </div> --}}
            <!-- end row -->
        </div>
        <!-- end container -->
    </section>
    <!-- about section end -->

    <!-- Features start -->
    <section class="section bg-dark text-white" id="features">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="text-center mb-5">
                        <div class="small-title">Our Services</div>
                        <h4>At Afroserves, we understand that a busy life shouldn't mean sacrificing delicious meals or well-deserved pampering. That's why we offer two amazing services.</h4>
                    </div>
                </div>
            </div>
            <!-- end row -->

            <div class="row align-items-center pt-4">
                <div class="col-md-6 col-sm-8">
                    <div>
                        <img src="{{ asset('assets/images/services/s5.jpg') }}" alt=""
                            class="rounded img-fluid mx-auto d-block">
                    </div>
                </div>
                <div class="col-md-5 ms-auto">
                    <div class="mt-4 mt-md-auto">
                        <div class="d-flex align-items-center mb-2">
                            <div class="features-number fw-semibold display-4 me-3">01</div>
                            <h4 class="mb-0">Saloon Appointment Services</h4>
                        </div>
                        <p class="text-white">Pamper yourself, it's time!</p>
                        <div class="text-white mt-4">
                            <p class="mb-2"><i class="mdi mdi-circle-medium text-success me-1"></i>Schedule appointments at a convenient date and time that fits your busy schedule. No more waiting on hold or inconvenient salon hours.</p>
                            <p><i class="mdi mdi-circle-medium text-success me-1"></i>Afroservesall allows you to book appointments effortlessly anytime, anywhere.</p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end row -->

            <div class="row align-items-center mt-5 pt-md-5">
                <div class="col-md-5">
                    <div class="mt-4 mt-md-0">
                        <div class="d-flex align-items-center mb-2">
                            <div class="features-number fw-semibold display-4 me-3">02</div>
                            <h4 class="mb-0">Food Ordering Services</h4>
                        </div>
                        <p class="text-white">Browse menus, explore mouthwatering pictures, and add your selections to your cart with just a few taps. Customize your order with special requests and dietary needs.</p>
                        <div class="text-white mt-4">
                            <p class="mb-2"><i class="mdi mdi-circle-medium text-success me-1"></i>Enjoy a diverse range of cuisines to suit every taste bud.</p>
                            <p><i class="mdi mdi-circle-medium text-success me-1"></i>Our delivery partners ensure your food arrives fresh, hot, and on time.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6  col-sm-8 ms-md-auto">
                    <div class="mt-4 me-md-0">
                        <img src="{{ asset('assets/images/services/f4.jpg') }}" alt=""
                            class="rounded img-fluid mx-auto d-block">
                    </div>
                </div>

            </div>
            <!-- end row -->
        </div>
        <!-- end container -->
    </section>
    <!-- Features end -->


    <!-- Faqs start -->
    <section class="section pt-4 bg-white" id="faqs">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="text-center mb-5">
                        <div class="small-title">FAQs</div>
                        <h4>Frequently Asked Questions</h4>
                    </div>
                </div>
            </div>
            <!-- end row -->

            <div class="row">
                <div class="col-lg-12">
                    <div class="vertical-nav">
                        <div class="row">
                            <div class="col-lg-2 col-sm-4">
                                <div class="nav flex-column nav-pills" role="tablist">
                                    <a class="nav-link active" id="v-pills-gen-ques-tab" data-bs-toggle="pill"
                                        href="#v-pills-gen-ques" role="tab">
                                        <i class= "bx bx-help-circle nav-icon d-block mb-2"></i>
                                        <p class="fw-bold mb-0">General Questions</p>
                                    </a>
                                    <a class="nav-link" id="v-pills-token-sale-tab" data-bs-toggle="pill"
                                        href="#v-pills-token-sale" role="tab">
                                        <i class= "bx bx-receipt nav-icon d-block mb-2"></i>
                                        <p class="fw-bold mb-0">Food Ordering Services</p>
                                    </a>
                                    <a class="nav-link" id="v-pills-roadmap-tab" data-bs-toggle="pill"
                                        href="#v-pills-roadmap" role="tab">
                                        <i class= "bx bx-timer d-block nav-icon mb-2"></i>
                                        <p class="fw-bold mb-0">Saloon Services</p>
                                    </a>
                                </div>
                            </div>
                            <div class="col-lg-10 col-sm-8">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="tab-content">
                                            <div class="tab-pane fade show active" id="v-pills-gen-ques"
                                                role="tabpanel">
                                                <h4 class="card-title mb-4">General Questions</h4>

                                                <div>
                                                    <div id="gen-ques-accordion" class="accordion custom-accordion">
                                                        <div class="mb-3">
                                                            <a href="#general-collapseOne" class="accordion-list"
                                                                data-bs-toggle="collapse" aria-expanded="true"
                                                                aria-controls="general-collapseOne">

                                                                <div>What is Afroservesall?</div>
                                                                <i class="mdi mdi-minus accor-plus-icon"></i>

                                                            </a>

                                                            <div id="general-collapseOne" class="collapse show"
                                                                data-bs-parent="#gen-ques-accordion">
                                                                <div class="card-body">
                                                                    <p class="mb-0">Afroservesall is a convenient app offering two amazing services in one: food ordering and salon service booking.</p>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="mb-3">
                                                            <a href="#general-collapseTwo"
                                                                class="accordion-list collapsed"
                                                                data-bs-toggle="collapse" aria-expanded="false"
                                                                aria-controls="general-collapseTwo">
                                                                <div>What are the benefits of using Afroservesall?</div>
                                                                <i class="mdi mdi-minus accor-plus-icon"></i>
                                                            </a>
                                                            <div id="general-collapseTwo" class="collapse"
                                                                data-bs-parent="#gen-ques-accordion">
                                                                <div class="card-body">
                                                                    <p class="mb-0">Convenience: Manage both food cravings and self-care needs through one user-friendly website. <br>
                                                                        Variety: Enjoy a wide selection of foods and delivers top-notch salons services. <br>
                                                                        Efficiency: Order food and book appointments effortlessly, saving you time and stress. <br>
                                                                        Security: Secure online payment options ensure a safe and smooth experience.</p>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="mb-3">
                                                            <a href="#general-collapseThree"
                                                                class="accordion-list collapsed"
                                                                data-bs-toggle="collapse" aria-expanded="false"
                                                                aria-controls="general-collapseThree">
                                                                <div>Where is Afroservesall available?</div>
                                                                <i class="mdi mdi-minus accor-plus-icon"></i>
                                                            </a>
                                                            <div id="general-collapseThree" class="collapse"
                                                                data-bs-parent="#gen-ques-accordion">
                                                                <div class="card-body">
                                                                    <p class="mb-0">Afroservesall is currently available mainly online. We are constantly working on expanding our reach to have physical locations.</p>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div>
                                                            <a href="#general-collapseFour"
                                                                class="accordion-list collapsed"
                                                                data-bs-toggle="collapse" aria-expanded="false"
                                                                aria-controls="general-collapseFour">
                                                                <div>How much does Afroservesall cost?</div>
                                                                <i class="mdi mdi-minus accor-plus-icon"></i>
                                                            </a>
                                                            <div id="general-collapseFour" class="collapse"
                                                                data-bs-parent="#gen-ques-accordion">
                                                                <div class="card-body">
                                                                    <p class="mb-0">Using the Afroservesall website is free. However, restaurant menu prices and salon service fees will vary depending on your selections..</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="tab-pane fade" id="v-pills-token-sale" role="tabpanel">
                                                <h4 class="card-title mb-4">Food Ordering Services</h4>

                                                <div>
                                                    <div id="token-accordion" class="accordion custom-accordion">
                                                        <div class="mb-3">
                                                            <a href="#token-collapseOne"
                                                                class="accordion-list collapsed"
                                                                data-bs-toggle="collapse" aria-expanded="false"
                                                                aria-controls="token-collapseOne">
                                                                <div>How do I place an order?</div>
                                                                <i class="mdi mdi-minus accor-plus-icon"></i>
                                                            </a>
                                                            <div id="token-collapseOne" class="collapse"
                                                                data-bs-parent="#token-accordion">
                                                                <div class="card-body">
                                                                    <p class="mb-0"> Browse restaurant menus, add your desired dishes to your cart, and proceed to checkout. You can customize your order with special requests and dietary needs. Securely pay online using your preferred method and track your order in real-time until it arrives at your doorstep.</p>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="mb-3">
                                                            <a href="#token-collapseTwo" class="accordion-list"
                                                                data-bs-toggle="collapse" aria-expanded="true"
                                                                aria-controls="token-collapseTwo">

                                                                <div>What are the delivery fees?</div>
                                                                <i class="mdi mdi-minus accor-plus-icon"></i>

                                                            </a>

                                                            <div id="token-collapseTwo" class="collapse show"
                                                                data-bs-parent="#token-accordion">
                                                                <div class="card-body">
                                                                    <p class="mb-0">Delivery fees vary depending on the restaurant and your distance. You'll see the exact delivery fee before confirming your order.
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="mb-3">
                                                            <a href="#token-collapseThree"
                                                                class="accordion-list collapsed"
                                                                data-bs-toggle="collapse" aria-expanded="false"
                                                                aria-controls="token-collapseThree">
                                                                <div>How long does it take for my food to arrive?</div>
                                                                <i class="mdi mdi-minus accor-plus-icon"></i>
                                                            </a>
                                                            <div id="token-collapseThree" class="collapse"
                                                                data-bs-parent="#token-accordion">
                                                                <div class="card-body">
                                                                    <p class="mb-0">Delivery times depend on the restaurant's location and current order volume. However, you can always track your order in the app for an estimated arrival time.</p>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div>
                                                            <a href="#token-collapseFour"
                                                                class="accordion-list collapsed"
                                                                data-bs-toggle="collapse" aria-expanded="false"
                                                                aria-controls="token-collapseFour">
                                                                <div>Can I schedule a food order in advance?</div>
                                                                <i class="mdi mdi-minus accor-plus-icon"></i>
                                                            </a>
                                                            <div id="token-collapseFour" class="collapse"
                                                                data-bs-parent="#token-accordion">
                                                                <div class="card-body">
                                                                    <p class="mb-0">Unfortunately, scheduling food orders in advance is not currently available. However, we are constantly working on improving our app features.</p>
                                                                </div>
                                                            </div>
                                                        </div>


                                                    </div>
                                                </div>
                                            </div>

                                            <div class="tab-pane fade" id="v-pills-roadmap" role="tabpanel">
                                                <h4 class="card-title mb-4">Saloon Booking Services</h4>

                                                <div>
                                                    <div id="roadmap-accordion" class="accordion custom-accordion">

                                                        <div class="mb-3">
                                                            <a href="#roadmap-collapseOne" class="accordion-list"
                                                                data-bs-toggle="collapse" aria-expanded="true"
                                                                aria-controls="roadmap-collapseOne">



                                                                <div>How do I find a salon and book an appointment?</div>
                                                                <i class="mdi mdi-minus accor-plus-icon"></i>

                                                            </a>

                                                            <div id="roadmap-collapseOne" class="collapse show"
                                                                data-bs-parent="#roadmap-accordion">
                                                                <div class="card-body">
                                                                    <p class="mb-0">Search on the Afroservices All app by service type (haircut, massage, etc.), choose the perfect match for your needs. Select a convenient date and time slot and confirm your booking with a few clicks.</p>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="mb-3">
                                                            <a href="#roadmap-collapseTwo"
                                                                class="accordion-list collapsed"
                                                                data-bs-toggle="collapse" aria-expanded="false"
                                                                aria-controls="roadmap-collapseTwo">
                                                                <div>What salon services are available?</div>
                                                                <i class="mdi mdi-minus accor-plus-icon"></i>
                                                            </a>
                                                            <div id="roadmap-collapseTwo" class="collapse"
                                                                data-bs-parent="#roadmap-accordion">
                                                                <div class="card-body">
                                                                    <p class="mb-0">We offered a wide range of salon services , including haircuts, styling, coloring, manicures, pedicures, facials, massages, and more.</p>
                                                                </div>
                                                            </div>
                                                        </div>



                                                        <div class="mb-3">
                                                            <a href="#roadmap-collapseThree"
                                                                class="accordion-list collapsed"
                                                                data-bs-toggle="collapse" aria-expanded="false"
                                                                aria-controls="roadmap-collapseThree">
                                                                <div>Can I cancel or reschedule my appointment?</div>
                                                                <i class="mdi mdi-minus accor-plus-icon"></i>
                                                            </a>
                                                            <div id="roadmap-collapseThree" class="collapse"
                                                                data-bs-parent="#roadmap-accordion">
                                                                <div class="card-body">
                                                                    <p class="mb-0">Yes, you can cancel or reschedule your appointment within a reasonable timeframe (typically 24 hours) through the Afroservesall app.</p>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div>
                                                            <a href="#roadmap-collapseFour"
                                                                class="accordion-list collapsed"
                                                                data-bs-toggle="collapse" aria-expanded="false"
                                                                aria-controls="roadmap-collapseFour">
                                                                <div>How do I pay for my salon service?</div>
                                                                <i class="mdi mdi-minus accor-plus-icon"></i>
                                                            </a>
                                                            <div id="roadmap-collapseFour" class="collapse"
                                                                data-bs-parent="#roadmap-accordion">
                                                                <div class="card-body">
                                                                    <p class="mb-0">Payment options are avaialble during the booking process.</p>
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
                    </div>
                    <!-- end vertical nav -->
                </div>
            </div>
            <!-- end row -->
        </div>
        <!-- end container -->
    </section>
    <!-- Faqs end -->


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


    <script src="{{ asset('assets/libs/jquery.easing/jquery.easing.min.js') }}"></script>

    <!-- Plugins js-->
    <script src="{{ asset('assets/libs/jquery-countdown/jquery.countdown.min.js') }}"></script>

    <!-- owl.carousel js -->
    <script src="{{ asset('assets/libs/owl.carousel/owl.carousel.min.js') }}"></script>

    <!-- ICO landing init -->
    <script src="{{ asset('assets/js/pages/ico-landing.init.js') }}"></script>

    <script>
         $(document).ready(function(){
            var imageUrls = [
                "{{ asset('assets/images/bg_img_1.jpg') }}",
                "{{ asset('assets/images/services/s2.jpg') }}",
                "{{ asset('assets/images/services/f2.jpg') }}",
                "{{ asset('assets/images/services/s1.jpg') }}",
                "{{ asset('assets/images/services/f3.jpg') }}",
                "{{ asset('assets/images/services/s3.jpg') }}",
                "{{ asset('assets/images/services/f4.jpg') }}",
                "{{ asset('assets/images/services/s4.jpg') }}",
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
