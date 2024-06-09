@php
    $pageName = "hair";
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
        @include('common.social')
        <nav class="navbar navbar-expand-lg navigation fixed-top sticky">
            <div class="container">
                <a class="navbar-logo mt-3 mb-2" href="{{ url('/') }}">
                    <img src="{{ asset('assets/images/logo-dark.png') }}" alt="" height="100" class="logo logo-dark">
                    <img src="{{ asset('assets/images/logo-light.png') }}" alt="" height="100" class="logo logo-light">
                </a>

                <button type="button" class="btn btn-sm px-3 font-size-16 d-lg-none header-item waves-effect waves-light" data-bs-toggle="collapse" data-bs-target="#topnav-menu-content">
                    <i class="fa fa-fw fa-bars"></i>
                </button>
              
                <div class="collapse navbar-collapse" id="topnav-menu-content">
                    <ul class="navbar-nav ms-auto" id="topnav-menu" >
                        <li class="nav-item">
                            <a class="nav-link active" href="{{ url('/') }}">Afroservesall</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="#home">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/bookNow') }}">Book Now</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <!-- hero section start -->
        <section class="section hero-section bg-ico-hero" id="home" style="background-image:url({{ asset('assets/images/services/s5.jpg') }});background-size:cover;background-position:top">
            <div class="bg-overlay bg-darke"></div>
            <div class="container">
                <div class="row align-items-center mt-5 pt-5">
                    <div class="col-lg-8 mt-5 pt-5">
                        <div class="text-white-50 mt-5">
                            <h1 class="text-white fw-semibold mb-3 hero-title">Good looks, Uniqueness? We know how!</h1>
                            <p class="font-size-14">Schedule your appointment for various hairstyles and general hair maintenance </p>
                            
                            <div class="d-flex flex-wrap gap-2 mt-4">
                                <a href="{{ url('/bookNow') }}" class="btn btn-light">Book Now</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-8 col-sm-10 ms-lg-auto">
                        
                    </div>
                </div>
                <!-- end row -->
            </div>
            <!-- end container -->
        </section>
        <!-- hero section end -->

        <!-- Features start -->
        {{-- <section class="section" id="features">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="text-center mb-5">
                            <div class="small-title">Our Services</div>
                            <h4>What we offer</h4>
                        </div>
                    </div>
                </div>
                <!-- end row -->

                <div class="row align-items-center pt-4">
                    <div class="col-md-6 col-sm-8">
                        <div>
                            <img src="assets/images/crypto/features-img/img-1.png" alt="" class="img-fluid mx-auto d-block">
                        </div>
                    </div>
                    <div class="col-md-5 ms-auto">
                        <div class="mt-4 mt-md-auto">
                            <div class="d-flex align-items-center mb-2">
                                <div class="features-number fw-semibold display-4 me-3">01</div>
                                <h4 class="mb-0">Lending</h4>
                            </div>
                            <p class="text-muted">If several languages coalesce, the grammar of the resulting language is more simple and regular than of the individual will be more simple and regular than the existing.</p>
                            <div class="text-muted mt-4">
                                <p class="mb-2"><i class="mdi mdi-circle-medium text-success me-1"></i>Donec pede justo vel aliquet</p>
                                <p><i class="mdi mdi-circle-medium text-success me-1"></i>Aenean et nisl sagittis</p>
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
                                <h4 class="mb-0">Wallet</h4>
                            </div>
                            <p class="text-muted">It will be as simple as Occidental; in fact, it will be Occidental. To an English person, it will seem like simplified English, as a skeptical Cambridge friend.</p>
                            <div class="text-muted mt-4">
                                <p class="mb-2"><i class="mdi mdi-circle-medium text-success me-1"></i>Donec pede justo vel aliquet</p>
                                <p><i class="mdi mdi-circle-medium text-success me-1"></i>Aenean et nisl sagittis</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6  col-sm-8 ms-md-auto">
                        <div class="mt-4 me-md-0">
                            <img src="assets/images/crypto/features-img/img-2.png" alt="" class="img-fluid mx-auto d-block">
                        </div>
                    </div>
                    
                </div>
                <!-- end row -->
            </div>
            <!-- end container -->
        </section> --}}
        <!-- Features end -->
        

        <!-- Footer start -->
        <footer class="landing-footer">
            <div class="container">
                <hr class="footer-border my-5">

                <div class="row">
                    <div class="col-lg-8">
                        <div class="mb-4">
                            <img src="{{ asset('assets/images/logo-light.png') }}" alt="" height="100">
                        </div>
    
                        <p class="mb-2"><script>document.write(new Date().getFullYear())</script> © {{ env('APP_NAME') }}. Design & Develop by KoderiaNG</p>
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

        <!-- ICO landing init -->
        <script src="{{ asset('assets/js/pages/ico-landing.init.js') }}"></script>

        <script src="{{ asset('assets/js/app.js') }}"></script>
        <script>
            $(document).ready(function(){
                var imageUrls = [
                    "../assets/images/services/s5.jpg",
                    "../assets/images/services/s3.jpg",
                    "../assets/images/services/s8.jpg",
                    "../assets/images/services/s1.jpg",
                    "../assets/images/services/s2.jpg",
                    "../assets/images/services/s4.jpg",
                    "../assets/images/services/s6.jpg",
                    "../assets/images/services/s7.jpg",
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