
<!doctype html>
<html lang="en">

    
<head>

        <meta charset="utf-8" />
        <title>{{ env('APP_NAME') }} - Customer Authentication</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="{{ env('APP_DESCRIPTION') }}" name="description" />
        <meta content="KoderiaNg(+2348162957065)" name="author" />
        <!-- App favicon -->
        <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}">


        <!-- Bootstrap Css -->
        <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
        <!-- Icons Css -->
        <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
        <!-- App Css-->
        <link href="{{ asset('assets/css/app.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />
            
        <!-- owl.carousel css -->
        <link rel="stylesheet" href="{{ asset('assets/libs/owl.carousel/assets/owl.carousel.min.css') }}">

        <link rel="stylesheet" href="{{ asset('assets/libs/owl.carousel/assets/owl.theme.default.min.css') }}">

        <script src="{{ asset('assets/js/plugin.js') }}"></script>

    </head>

    <body class="auth-body-bg">
        @include('sweetalert::alert')
        <div>
            <div class="container-fluid p-0">
                <div class="row g-0">
                    
                    <div class="col-xl-7">
                        <div class="auth-full-bg pt-lg-5 p-4">
                            <div class="w-100">
                                <div class="bg-overlay"></div>
                                <div class="d-flex h-100 flex-column">
    
                                    <div class="p-4 mt-auto">
                                        <div class="row justify-content-center">
                                            <div class="col-lg-7">
                                                <div class="text-center">
                                                    
                                                    {{-- <h4 class="mb-3"><i class="bx bxs-quote-alt-left text-primary h1 align-middle me-3"></i><span class="text-primary">5k</span>+ Satisfied clients</h4> --}}
                                                    
                                                    <div dir="ltr">
                                                        {{-- <div class="owl-carousel owl-theme auth-review-carousel" id="auth-review-carousel">
                                                            <div class="item">
                                                                <div class="py-3">
                                                                    <p class="font-size-16 mb-4">""</p>
    
                                                                    <div>
                                                                        <h4 class="font-size-16 text-primary"></h4>
                                                                        <p class="font-size-14 mb-0"></p>
                                                                    </div>
                                                                </div>
                                                                
                                                            </div>
    
                                                            <div class="item">
                                                                <div class="py-3">
                                                                    <p class="font-size-16 mb-4"></p>
    
                                                                    <div>
                                                                        <h4 class="font-size-16 text-primary"></h4>
                                                                        <p class="font-size-14 mb-0">-</p>
                                                                    </div>
                                                                </div>
                                                                
                                                            </div>
                                                        </div> --}}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end col -->

                    <div class="col-xl-5">
                        <div class="auth-full-page-content p-md-5 p-4">
                            <div class="w-100">

                                <div class="d-flex flex-column h-100">
                                    <div class="mb-4 mb-md-5">
                                        <a href="{{ url('/') }}" class="d-block card-logo">
                                            <img src="{{ asset('assets/images/logo-dark.png') }}" alt="" height="100" class="card-logo-dark">
                                        </a>
                                    </div>
                                    @yield('content')

                                    <div class="mt-4 mt-md-5 text-center">
                                        <p class="mb-0">© <script>document.write(new Date().getFullYear())</script> {{ env('APP_NAME') }}. Developed by KoderiaNG</p>
                                    </div>
                                </div>
                                
                                
                            </div>
                        </div>
                    </div>
                    <!-- end col -->
                </div>
                <!-- end row -->
            </div>
            <!-- end container-fluid -->
        </div>

        <!-- JAVASCRIPT -->
        <script src="{{ asset('assets/libs/jquery/jquery.min.js') }}"></script>
        <script src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('assets/libs/metismenu/metisMenu.min.js') }}"></script>
        <script src="{{ asset('assets/libs/simplebar/simplebar.min.js') }}"></script>
        <script src="{{ asset('assets/libs/node-waves/waves.min.js') }}"></script>
        
        <!-- App js -->
        <script src="{{ asset('assets/js/app.js') }}"></script>

        <!-- owl.carousel js -->
        <script src="{{ asset('assets/libs/owl.carousel/owl.carousel.min.js') }}"></script>

        <!-- auth-2-carousel init -->
        <script src="{{ asset('assets/js/pages/auth-2-carousel.init.js') }}"></script>
        
        

    </body>

</html>
