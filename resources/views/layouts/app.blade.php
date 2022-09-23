<!DOCTYPE html>
    <html lang="en">
        <head>
            <!-- Required meta tags -->
            <meta charset="utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
            <title>Enkpay Agent Dsshboard</title>
            <!-- plugins:css -->
            <link rel="stylesheet" href="assets/vendors/mdi/css/materialdesignicons.min.css">
            <link rel="stylesheet" href="assets/vendors/css/vendor.bundle.base.css">
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
            <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
            <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.3/css/buttons.dataTables.min.css">


            <script src="//code.jquery.com/jquery-1.12.3.js"></script>
            <script src="//cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
            <script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>
             <!-- <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"> -->
            <link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css">









            <!-- endinject -->
            <!-- Plugin css for this page -->
            <!-- End plugin css for this page -->
            <!-- inject:css -->
            <!-- endinject -->
            <!-- Layout styles -->
            <link rel="stylesheet" href="assets/css/style.css">
            <!-- End layout styles -->
            <link rel="shortcut icon" href="assets/images/favicon.ico" />
        </head>
        <body>
            <div class="container-scroller">
                <div class="row p-0 m-0 proBanner" id="proBanner">
                    <div class="col-md-12 p-0 m-0">
                    <div class="card-body card-body-padding d-flex align-items-center justify-content-between">
                        <div class="ps-lg-1">
                        <div class="d-flex align-items-center justify-content-between">
                            <p class="mb-0 font-weight-medium me-3 buy-now-text">Free 24/7 customer support, updates, and more with this template!</p>
                            <a href="https://www.bootstrapdash.com/product/purple-bootstrap-admin-template/?utm_source=organic&utm_medium=banner&utm_campaign=buynow_demo" target="_blank" class="btn me-2 buy-now-btn border-0">Get Pro</a>
                        </div>
                        </div>
                        <div class="d-flex align-items-center justify-content-between">
                        <a href="https://www.bootstrapdash.com/product/purple-bootstrap-admin-template/"><i class="mdi mdi-home me-3 text-white"></i></a>
                        <button id="bannerClose" class="btn border-0 p-0">
                            <i class="mdi mdi-close text-white me-0"></i>
                        </button>
                        </div>
                    </div>
                    </div>
                </div>
                <!-- partial:partials/_navbar.html -->
                <nav class="navbar default-layout-navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
                    <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
                    <a class="navbar-brand brand-logo" href="/agent-dashboard"><img src="assets/images/logo.png" alt="logo" /></a>
                    <a class="navbar-brand brand-logo-mini" href="/agent-dashboard"><img src="assets/images/logo-mini.png" alt="logo" /></a>
                    </div>
                    <div class="navbar-menu-wrapper d-flex align-items-stretch">
                    <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
                        <span class="mdi mdi-menu"></span>
                    </button>
                    <div class="search-field d-none d-md-block">
                        <form class="d-flex align-items-center h-100" action="#">
                        <h2>NGN {{number_format($user_balance), 2}}</h2>
                        </form>
                    </div>
                    <ul class="navbar-nav navbar-nav-right">
                        <li class="nav-item nav-profile dropdown">
                        <a class="nav-link dropdown-toggle" id="profileDropdown" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                            <div class="nav-profile-img">
                            <img src="assets/images/faces/face1.jpg" alt="image">
                            <span class="availability-status online"></span>
                            </div>
                            <div class="nav-profile-text">
                            <p class="mb-1 text-black">{{Auth::user()->first_name}} {{Auth::user()->last_name}}</p>
                            </div>
                        </a>
                        <div class="dropdown-menu navbar-dropdown" aria-labelledby="profileDropdown">
                            <a class="dropdown-item" href="#">
                            <i class="mdi mdi-cached me-2 text-success"></i>{{Auth::user()->user_type}} </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="/logout">
                            <i class="mdi mdi-logout me-2 text-primary"></i> Signout </a>
                        </div>
                        </li>
                        
                          
                       
                     
                      
                       
                    </ul>
                    
                    </div>
                </nav>
                <!-- partial -->
                <div class="container-fluid page-body-wrapper">
                    <!-- partial:partials/_sidebar.html -->
                    <nav class="sidebar sidebar-offcanvas" id="sidebar">
                    <ul class="nav">
                        <li class="nav-item nav-profile">
                        <a href="#" class="nav-link">
                            <div class="nav-profile-image">
                            <img src="assets/images/faces/face1.jpg" alt="profile">
                            <span class="login-status online"></span>
                            <!--change to offline or busy as needed-->
                            </div>
                            <div class="nav-profile-text d-flex flex-column">
                            <span class="font-weight-bold mb-2">{{Auth::user()->first_name}} {{Auth::user()->last_name}}</span>
                            <span class="text-secondary text-small">{{Auth::user()->user_type}}</span>
                            </div>
                            <i class="mdi mdi-bookmark-check text-success nav-profile-badge"></i>
                        </a>
                        </li>
                        <li class="nav-item ">
                        <a class="nav-link" href="/agent-dashboard">
                            <span class="menu-title">Dashboard</span>
                            <i class="mdi mdi-home menu-icon"></i>
                        </a>
                        </li>
                        
                        
                        <li class="nav-item">
                        <a class="nav-link" href="/transaction">
                            <span class="menu-title">Transactions</span>
                            <i class="mdi mdi-format-list-bulleted menu-icon"></i>
                        </a>
                        </li>

                        <li class="nav-item">
                        <a class="nav-link" href="/bank-transfer">
                            <span class="menu-title">Bank Transfer</span>
                            <i class="mdi mdi-bank menu-icon"></i>
                        </a>
                        </li>


                      
                        <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="collapse" href="#general-pages" aria-expanded="false" aria-controls="general-pages">
                            <span class="menu-title">Account</span>
                            <i class="menu-arrow"></i>
                            <i class=" mdi mdi-account-circle  menu-icon"></i>
                        </a>
                        <div class="collapse" id="general-pages">
                            <ul class="nav flex-column sub-menu">
                            <li class="nav-item"> <a class="nav-link" href="device"> My Device </a></li>
                            <li class="nav-item"> <a class="nav-link" href="/update-account"> Update account</a></li>
                            </ul>
                        </div>
                        </li>
                        <li class="nav-item sidebar-actions">
                        <span class="nav-link">
                            <div class="border-bottom">

                            </div>
                            <button class="btn btn-block btn-lg btn-gradient-primary mt-4">Contact Support</button>
                            <div class="mt-4">
                            <div class="border-bottom">
                            </div>
                           
                        </span>
                        </li>
                    </ul>
                    </nav>
                    <!-- partial -->

                    @yield('content')





                    

                <!-- container-scroller -->
                <!-- plugins:js -->
                <script src="assets/vendors/js/vendor.bundle.base.js"></script>
                <!-- endinject -->
                <!-- Plugin js for this page -->
                <script src="assets/vendors/chart.js/Chart.min.js"></script>
                <script src="assets/js/jquery.cookie.js" type="text/javascript"></script>
                <!-- End plugin js for this page -->
                <!-- inject:js -->
                <script src="assets/js/off-canvas.js"></script>
                <script src="assets/js/hoverable-collapse.js"></script>
                <script src="assets/js/misc.js"></script>
                <!-- endinject -->
                <!-- Custom js for this page -->
                <script src="assets/js/dashboard.js"></script>
                <script src="assets/js/todolist.js"></script>
                <script src="assets/js/custom.js"></script>

                <script src="{{ asset('js/app.js') }}"></script>
                <script src="https://code.jquery.com/jquery-3.2.1.js"></script>
                @yield('javascripts')

            </div>    <!-- End custom js for this page -->
        </body>
</html>
