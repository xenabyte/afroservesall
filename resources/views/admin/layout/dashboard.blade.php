@php
    $admin = Auth::guard('admin')->user();
@endphp
<!doctype html>
<html lang="en">

    
<head>
        
        <meta charset="utf-8" />
        <title>{{ env('APP_NAME') }} - Admin  Dashboard</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content={{ env('APP_DESCRIPTION') }}" name="description" />
        <meta content="KoderiaNg(+2348162957065)" name="author" />
        <!-- App favicon -->
        <link rel="shortcut icon" href="">

        <!-- DataTables -->
        <link href="{{ asset('assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />

        <!-- Responsive datatable examples -->
        <link href="{{ asset('assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />     


        <!-- Bootstrap Css -->
        <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
        <!-- Icons Css -->
        <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
        <!-- App Css-->
        <link href="{{ asset('assets/css/app.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />

        
    </head>

    <body data-sidebar="dark">
        @include('sweetalert::alert')

    <!-- <body data-layout="horizontal" data-topbar="dark"> -->

        <!-- Begin page -->
        <div id="layout-wrapper">

            
            <header id="page-topbar">
                <div class="navbar-header">
                    <div class="d-flex">
                        <!-- LOGO -->
                        <div class="navbar-brand-box">
                            <a href="{{ url('/admin/home') }}" class="logo logo-dark">
                                <span class="logo-sm">
                                    <img src="" alt="" height="40">
                                </span>
                                <span class="logo-lg">
                                    <img src="" alt="" height="40">
                                </span>
                            </a>

                            <a href="{{ url('/admin/home') }}" class="logo logo-light">
                                <span class="logo-sm">
                                    <img src="" alt="" height="40">
                                </span>
                                <span class="logo-lg">
                                    <img src="" alt="" height="40">
                                </span>
                            </a>
                        </div>

                        <button type="button" class="btn btn-sm px-3 font-size-16 header-item waves-effect" id="vertical-menu-btn">
                            <i class="fa fa-fw fa-bars"></i>
                        </button>

                    </div>

                    <div class="d-flex">

                        <div class="dropdown d-none d-lg-inline-block ms-1">
                            <button type="button" class="btn header-item noti-icon waves-effect" data-bs-toggle="fullscreen">
                                <i class="bx bx-fullscreen"></i>
                            </button>
                        </div>


                        <div class="dropdown d-inline-block">
                            <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <img class="rounded-circle header-profile-user" src="{{ asset('assets/images/users/avatar-1.jpg') }}"
                                    alt="Header Avatar">
                                <span class="d-none d-xl-inline-block ms-1" key="t-henry">{{ $admin->name }}</span>
                                <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end">
                                <!-- item-->
                                <a class="dropdown-item" href="#"><i class="bx bx-user font-size-16 align-middle me-1"></i> <span key="t-profile">Profile</span></a>
                                <a class="dropdown-item" href="#"><i class="bx bx-wallet font-size-16 align-middle me-1"></i> <span key="t-my-wallet">My Wallet</span></a>
                                <a class="dropdown-item d-block" href="#"><span class="badge bg-success float-end">11</span><i class="bx bx-wrench font-size-16 align-middle me-1"></i> <span key="t-settings">Settings</span></a>
                                <a class="dropdown-item" href="#"><i class="bx bx-lock-open font-size-16 align-middle me-1"></i> <span key="t-lock-screen">Lock screen</span></a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item text-danger" href="{{ url('/admin/logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="bx bx-power-off font-size-16 align-middle me-1 text-danger"></i> <span key="t-logout">Logout</span></a>
                                <form id="logout-form" action="{{ url('/admin/logout') }}" method="POST" style="display: none;">@csrf</form>
                            </div>
                        </div>

                    </div>
                </div>
            </header>

            <!-- ========== Left Sidebar Start ========== -->
            <div class="vertical-menu">

                <div data-simplebar class="h-100">

                    <!--- Sidemenu -->
                    <div id="sidebar-menu">
                        <!-- Left Menu Start -->
                        <ul class="metismenu list-unstyled" id="side-menu">
                            <li class="menu-title" key="t-menu">Menu</li>
                            <li>
                                <a href="{{ url('/admin/home') }}" class="waves-effect">
                                    <i class="bx bx-home-circle"></i>
                                    <span key="t-dashboard">Home</span>
                                </a>
                            </li>
                            <li class="menu-title" key="t-menu">Website Configurations</li>
                            <li>
                                <a href="{{ url('/admin/siteSettings') }}" class="waves-effect">
                                    <i class="bx bx-cog"></i>
                                    <span key="t-settings">Site Settings</span>
                                </a>
                            </li>

                            <li>
                                <a href="{{ url('/admin/socials') }}" class="waves-effect">
                                    <i class="bx bx-cog"></i>
                                    <span key="t-settings">Socials</span>
                                </a>
                            </li>

                            <li>
                                <a href="javascript: void(0);" class="has-arrow waves-effect">
                                    <i class="bx bxs-news"></i>
                                    <span key="t-dashboards">Site Pages</span>
                                </a>
                                <ul class="sub-menu" aria-expanded="false">
                                    <li><a href="{{ url('/admin/term') }}" key="t-default">Terms and Condition</a></li>
                                    <li><a href="{{ url('/admin/privacy') }}" key="t-saas">Privacy</a></li>
                                    <li><a href="{{ url('/admin/about') }}" key="t-saas">About us</a></li>

                                </ul>
                            </li>
                            <li class="menu-title" key="t-menu">News, Advert and Polls</li>
                            <li>
                                <a href="{{ url('/admin/category') }}" class="waves-effect">
                                    <i class="bx bx-hive"></i>
                                    <span key="t-category">Category</span>
                                </a>
                            </li>

                            <li>
                                <a href="{{ url('/admin/getTopics') }}" class="waves-effect">
                                    <i class="bx bx-layer"></i>
                                    <span key="t-Category">Topics</span>
                                </a>
                            </li>


                            <li>
                                <a href="javascript: void(0);" class="has-arrow waves-effect">
                                    <i class="bx bxs-news"></i>
                                    <span key="t-dashboards">News</span>
                                </a>
                                <ul class="sub-menu" aria-expanded="false">
                                    <li><a href="{{ url('/admin/news') }}" key="t-default">Post a News</a></li>
                                    <li><a href="{{ url('/admin/publishedNews') }}" key="t-saas">Published News</a></li>
                                    <li><a href="{{ url('/admin/draftNews') }}" key="t-crypto">Drafts</a></li>
                                </ul>
                            </li>

                            <li>
                                <a href="{{ url('/admin/polls') }}" class="waves-effect">
                                    <i class="bx bx-hive"></i>
                                    <span key="t-category">Polls</span>
                                </a>
                            </li>


                            <li>
                                <a href="{{ url('/admin/adverts') }}" class="waves-effect">
                                    <i class="bx bx-hive"></i>
                                    <span key="t-category">All Adverts</span>
                                </a>
                            </li>

                            <li class="menu-title" key="t-staff">Staff</li>
                            <li>
                                <a href="javascript: void(0);" class="has-arrow waves-effect">
                                    <i class="bx bx-user-pin"></i>
                                    <span key="t-reporters">Reporters</span>
                                </a>
                                <ul class="sub-menu" aria-expanded="false">
                                    <li><a href="{{ url('/admin/reporters') }}" key="t-default">New Reporter</a></li>
                                    <li><a href="{{ url('/admin/allReporters') }}" key="t-saas">All Reporters</a></li>
                                </ul>
                            </li>

                            <li>
                                <a href="javascript: void(0);" class="has-arrow waves-effect">
                                    <i class="bx bx-user-circle"></i>
                                    <span key="t-editors">Editors</span>
                                </a>
                                <ul class="sub-menu" aria-expanded="false">
                                    <li><a href="{{ url('/admin/editors') }}" key="t-default">New Editor</a></li>
                                    <li><a href="{{ url('/admin/allEditors') }}" key="t-saas">All Editors</a></li>
                                </ul>
                            </li>

                            <li class="menu-title" key="t-auth"></li>
                            <li>
                                <a href="{{ url('/admin/logout') }}"  onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="waves-effect">
                                    <i class="bx bx-power-off"></i>
                                    <span key="t-logout">Logout</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <!-- Sidebar -->
                </div>
            </div>
            <!-- Left Sidebar End -->

            

            <!-- ============================================================== -->
            <!-- Start right Content here -->
            <!-- ============================================================== -->
            <div class="main-content">

                <div class="page-content">
                    <div class="container-fluid">

                        @yield('content')
                            
                    </div> <!-- container-fluid -->
                </div>
                <!-- End Page-content -->

                
                <footer class="footer">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-sm-6">
                                <script>document.write(new Date().getFullYear())</script> © Skote.
                            </div>
                            <div class="col-sm-6">
                                <div class="text-sm-end d-none d-sm-block">
                                    Design & Develop by KoderiaNG
                                </div>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
            <!-- end main content-->

        </div>
        <!-- END layout-wrapper -->

        <!-- JAVASCRIPT -->
        <script src="{{ asset('assets/libs/jquery/jquery.min.js') }}"></script>
        <script src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('assets/libs/metismenu/metisMenu.min.js') }}"></script>
        <script src="{{ asset('assets/libs/simplebar/simplebar.min.js') }}"></script>
        <script src="{{ asset('assets/libs/node-waves/waves.min.js') }}"></script>


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

         
        <!-- jquery step -->
        <script src="{{ asset('assets/libs/jquery-steps/build/jquery.steps.min.js') }}"></script>

        <!-- form wizard init -->
        <script src="{{ asset('assets/js/pages/form-wizard.init.js') }}"></script>
        <script src="{{ asset('assets/js/app.js') }}"></script>
        <script>
            $(document).ready(function() {
                // Detect changes in the checkbox
                $('#SwitchCheckSizelg').change(function() {
                    // Check if the checkbox is checked
                    if ($(this).is(':checked')) {
                        // Show the category select container
                        $('#categorySelectContainer').show();
                    } else {
                        // Hide the category select container
                        $('#categorySelectContainer').hide();
                    }
                });
                
            });
        </script>

    </body>

</html>
