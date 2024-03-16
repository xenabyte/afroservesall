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
        <section class="section hero-section bg-ico-hero" id="home" style="background-image:url({{ asset('assets/images/bg_img_1.jpg') }});background-size:cover;background-position:top">
            <div class="bg-overlay bg-darke"></div>
            <div class="container">
                <div class="row align-items-center mt-5 pt-5">
                    <div class="col-lg-5 mt-5 pt-5">
                        <div class="text-white-50 mt-5">
                            <h1 class="text-white fw-semibold mb-3 hero-title">{{ env('APP_NAME') }}</h1>
                            <p class="font-size-14">{{ env('APP_DESCRIPTION') }}</p>
                            
                            <div class="d-flex flex-wrap gap-2 mt-4">
                                <a href="#about" class="btn btn-light">What we do</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-5 col-md-8 col-sm-10 ms-lg-auto">
                        
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
                    <div class="col-lg-12">
                        <div class="text-center mb-5 mt-5">
                            <div class="small-title">About us</div>
                            <h4>What we do at Afro Serves all?</h4>
                        </div>
                    </div>
                </div>
                <div class="row align-items-center">
                    <div class="col-lg-5">
  
                        <div class="text-muted">
                            <h4>Best ICO for your cryptocurrency business</h4>
                            <p>If several languages coalesce, the grammar of the resulting that of the individual new common language will be more simple and regular than the existing.</p>
                            <p class="mb-4">It would be necessary to have uniform pronunciation.</p>

                            <div class="d-flex flex-wrap gap-2">
                                <a href="javascript: void(0);" class="btn btn-success">Read More</a>
                                <a href="javascript: void(0);" class="btn btn-outline-primary">How It work</a>
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
                                            <p class="text-muted mb-0">At vero eos et accusamus et iusto blanditiis</p>
        
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
                                            <p class="text-muted mb-0">Quis autem vel eum iure reprehenderit</p>
        
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
        <section class="section" id="features">
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
                                        <a class="nav-link active" id="v-pills-gen-ques-tab" data-bs-toggle="pill" href="#v-pills-gen-ques" role="tab">
                                            <i class= "bx bx-help-circle nav-icon d-block mb-2"></i>
                                            <p class="fw-bold mb-0">General Questions</p>
                                        </a>
                                        <a class="nav-link" id="v-pills-token-sale-tab" data-bs-toggle="pill" href="#v-pills-token-sale" role="tab"> 
                                            <i class= "bx bx-receipt nav-icon d-block mb-2"></i>
                                            <p class="fw-bold mb-0">Food Ordering Services</p>
                                        </a>
                                        <a class="nav-link" id="v-pills-roadmap-tab" data-bs-toggle="pill" href="#v-pills-roadmap" role="tab">
                                            <i class= "bx bx-timer d-block nav-icon mb-2"></i>
                                            <p class="fw-bold mb-0">Saloon Services</p>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-lg-10 col-sm-8">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="tab-content">
                                                <div class="tab-pane fade show active" id="v-pills-gen-ques" role="tabpanel">
                                                    <h4 class="card-title mb-4">General Questions</h4>
                                                    
                                                    <div>
                                                        <div id="gen-ques-accordion" class="accordion custom-accordion">
                                                            <div class="mb-3">
                                                                <a href="#general-collapseOne" class="accordion-list" data-bs-toggle="collapse" aria-expanded="true"
                                                                    aria-controls="general-collapseOne">
                                                    
                                                                    <div>What is Lorem Ipsum ?</div>
                                                                    <i class="mdi mdi-minus accor-plus-icon"></i>
                                                    
                                                                </a>
                                                    
                                                                <div id="general-collapseOne" class="collapse show" data-bs-parent="#gen-ques-accordion">
                                                                    <div class="card-body">
                                                                        <p class="mb-0">Everyone realizes why a new common language would be desirable: one could refuse to
                                                                            pay expensive translators. To achieve this, it would be necessary to have uniform grammar,
                                                                            pronunciation and more common words.</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                    
                                                            <div class="mb-3">
                                                                <a href="#general-collapseTwo" class="accordion-list collapsed" data-bs-toggle="collapse"
                                                                    aria-expanded="false" aria-controls="general-collapseTwo">
                                                                    <div>Why do we use it ?</div>
                                                                    <i class="mdi mdi-minus accor-plus-icon"></i>
                                                                </a>
                                                                <div id="general-collapseTwo" class="collapse" data-bs-parent="#gen-ques-accordion">
                                                                    <div class="card-body">
                                                                        <p class="mb-0">If several languages coalesce, the grammar of the resulting language is more simple
                                                                            and regular than that of the individual languages. The new common language will be more simple
                                                                            and regular than the existing European languages.</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                    
                                                            <div class="mb-3">
                                                                <a href="#general-collapseThree" class="accordion-list collapsed" data-bs-toggle="collapse"
                                                                    aria-expanded="false" aria-controls="general-collapseThree">
                                                                    <div>Where does it come from ?</div>
                                                                    <i class="mdi mdi-minus accor-plus-icon"></i>
                                                                </a>
                                                                <div id="general-collapseThree" class="collapse" data-bs-parent="#gen-ques-accordion">
                                                                    <div class="card-body">
                                                                        <p class="mb-0">It will be as simple as Occidental; in fact, it will be Occidental. To an English
                                                                            person, it will seem like simplified English, as a skeptical Cambridge friend of mine told me
                                                                            what Occidental.</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                    
                                                            <div>
                                                                <a href="#general-collapseFour" class="accordion-list collapsed" data-bs-toggle="collapse"
                                                                    aria-expanded="false" aria-controls="general-collapseFour">
                                                                    <div>Where can I get some ?</div>
                                                                    <i class="mdi mdi-minus accor-plus-icon"></i>
                                                                </a>
                                                                <div id="general-collapseFour" class="collapse" data-bs-parent="#gen-ques-accordion">
                                                                    <div class="card-body">
                                                                        <p class="mb-0">To an English person, it will seem like simplified English, as a skeptical Cambridge
                                                                            friend of mine told me what Occidental is. The European languages are members of the same
                                                                            family. Their separate existence is a myth.</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="tab-pane fade" id="v-pills-token-sale" role="tabpanel">
                                                    <h4 class="card-title mb-4">Token sale</h4>
                                                        
                                                    <div>
                                                        <div id="token-accordion" class="accordion custom-accordion">
                                                            <div class="mb-3">
                                                                <a href="#token-collapseOne" class="accordion-list collapsed" data-bs-toggle="collapse"
                                                                                aria-expanded="false"
                                                                                aria-controls="token-collapseOne">
                                                                    <div>Why do we use it ?</div>
                                                                    <i class="mdi mdi-minus accor-plus-icon"></i>
                                                                </a>
                                                                <div id="token-collapseOne" class="collapse" data-bs-parent="#token-accordion">
                                                                    <div class="card-body">
                                                                        <p class="mb-0">If several languages coalesce, the grammar of the resulting language is more simple and regular than that of the individual languages. The new common language will be more simple and regular than the existing European languages.</p>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="mb-3">
                                                                <a href="#token-collapseTwo" class="accordion-list" data-bs-toggle="collapse"
                                                                                                aria-expanded="true"
                                                                                                aria-controls="token-collapseTwo">
                                                                    
                                                                    <div>What is Lorem Ipsum ?</div>
                                                                    <i class="mdi mdi-minus accor-plus-icon"></i>
                                                                    
                                                                </a>
                                        
                                                                <div id="token-collapseTwo" class="collapse show" data-bs-parent="#token-accordion">
                                                                    <div class="card-body">
                                                                        <p class="mb-0">Everyone realizes why a new common language would be desirable: one could refuse to pay expensive translators. To achieve this, it would be necessary to have uniform grammar, pronunciation and more common words.</p>
                                                                    </div>
                                                                </div>
                                                            </div>
            
                                                            <div class="mb-3">
                                                                <a href="#token-collapseThree" class="accordion-list collapsed" data-bs-toggle="collapse"
                                                                                aria-expanded="false"
                                                                                aria-controls="token-collapseThree">
                                                                    <div>Where can I get some ?</div>
                                                                    <i class="mdi mdi-minus accor-plus-icon"></i>
                                                                </a>
                                                                <div id="token-collapseThree" class="collapse" data-bs-parent="#token-accordion">
                                                                    <div class="card-body">
                                                                        <p class="mb-0">To an English person, it will seem like simplified English, as a skeptical Cambridge friend of mine told me what Occidental is. The European languages are members of the same family. Their separate existence is a myth.</p>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div>
                                                                <a href="#token-collapseFour" class="accordion-list collapsed" data-bs-toggle="collapse"
                                                                                aria-expanded="false"
                                                                                aria-controls="token-collapseFour">
                                                                    <div>Where does it come from ?</div>
                                                                    <i class="mdi mdi-minus accor-plus-icon"></i>
                                                                </a>
                                                                <div id="token-collapseFour" class="collapse" data-bs-parent="#token-accordion">
                                                                    <div class="card-body">
                                                                        <p class="mb-0">It will be as simple as Occidental; in fact, it will be Occidental. To an English person, it will seem like simplified English, as a skeptical Cambridge friend of mine told me what Occidental.</p>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="tab-pane fade" id="v-pills-roadmap" role="tabpanel">
                                                    <h4 class="card-title mb-4">Roadmap</h4>
                                                        
                                                    <div>
                                                        <div id="roadmap-accordion" class="accordion custom-accordion">

                                                            <div class="mb-3">
                                                                <a href="#roadmap-collapseOne" class="accordion-list" data-bs-toggle="collapse"
                                                                                                aria-expanded="true"
                                                                                                aria-controls="roadmap-collapseOne">
                                                                    


                                                                    <div>Where can I get some ?</div>
                                                                    <i class="mdi mdi-minus accor-plus-icon"></i>
                                                                    
                                                                </a>
                                        
                                                                <div id="roadmap-collapseOne" class="collapse show" data-bs-parent="#roadmap-accordion">
                                                                    <div class="card-body">
                                                                        <p class="mb-0">Everyone realizes why a new common language would be desirable: one could refuse to pay expensive translators. To achieve this, it would be necessary to have uniform grammar, pronunciation and more common words.</p>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="mb-3">
                                                                <a href="#roadmap-collapseTwo" class="accordion-list collapsed" data-bs-toggle="collapse"
                                                                                aria-expanded="false"
                                                                                aria-controls="roadmap-collapseTwo">
                                                                    <div>What is Lorem Ipsum ?</div>
                                                                    <i class="mdi mdi-minus accor-plus-icon"></i>
                                                                </a>
                                                                <div id="roadmap-collapseTwo" class="collapse" data-bs-parent="#roadmap-accordion">
                                                                    <div class="card-body">
                                                                        <p class="mb-0">If several languages coalesce, the grammar of the resulting language is more simple and regular than that of the individual languages. The new common language will be more simple and regular than the existing European languages.</p>
                                                                    </div>
                                                                </div>
                                                            </div>


            
                                                            <div class="mb-3">
                                                                <a href="#roadmap-collapseThree" class="accordion-list collapsed" data-bs-toggle="collapse"
                                                                                aria-expanded="false"
                                                                                aria-controls="roadmap-collapseThree">
                                                                    <div>Why do we use it ?</div>
                                                                    <i class="mdi mdi-minus accor-plus-icon"></i>
                                                                </a>
                                                                <div id="roadmap-collapseThree" class="collapse" data-bs-parent="#roadmap-accordion">
                                                                    <div class="card-body">
                                                                        <p class="mb-0">To an English person, it will seem like simplified English, as a skeptical Cambridge friend of mine told me what Occidental is. The European languages are members of the same family. Their separate existence is a myth.</p>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div>
                                                                <a href="#roadmap-collapseFour" class="accordion-list collapsed" data-bs-toggle="collapse"
                                                                                aria-expanded="false"
                                                                                aria-controls="roadmap-collapseFour">
                                                                    <div>Where does it come from ?</div>
                                                                    <i class="mdi mdi-minus accor-plus-icon"></i>
                                                                </a>
                                                                <div id="roadmap-collapseFour" class="collapse" data-bs-parent="#roadmap-accordion">
                                                                    <div class="card-body">
                                                                        <p class="mb-0">It will be as simple as Occidental; in fact, it will be Occidental. To an English person, it will seem like simplified English, as a skeptical Cambridge friend of mine told me what Occidental.</p>
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

        <script src="{{ asset('assets/libs/jquery.easing/jquery.easing.min.js') }}"></script>

        <!-- Plugins js-->
        <script src="{{ asset('assets/libs/jquery-countdown/jquery.countdown.min.js') }}"></script>

        <!-- owl.carousel js -->
        <script src="{{ asset('assets/libs/owl.carousel/owl.carousel.min.js') }}"></script>

        <!-- ICO landing init -->
        <script src="{{ asset('assets/js/pages/ico-landing.init.js') }}"></script>

        <script src="{{ asset('assets/js/app.js') }}"></script>
        <script>
            sessionStorage.clear();
        </script>

    </body>

</html>
