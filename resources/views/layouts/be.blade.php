<!DOCTYPE html>
<html lang="zxx">

<!-- Mirrored from wpthemebooster.com/demo/themeforest/html/kleon/index-general.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 09 Jan 2025 22:29:27 GMT -->

<head>
    <!-- Meta Tags -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">
    <meta name="description" content="Kleon Admin Template">
    <meta name="author" content="">


    @include('includes.admin.style')
    <!-- Page Title -->
    <title>@yield('title')</title>

    <!-- Styles Include -->


</head>


<body class="bg-light">

    <!-- Preloader -->
    <!-- <div id="preloader">
        <div class="preloader-inner">
            <div class="spinner"></div>
            <div class="logo"><img src="{{ asset('assets/be/assets/img/logo-icon.svg') }}" alt="img"></div>
        </div>
    </div> -->

    <!-- Default Nav -->
    <header class="header kleon-default-nav">


        <!-- bagian navbar desktop -->
        @include('includes.admin.navbar')
        <!-- akhir bagian navbar dekstop -->

        <div class="small-header d-flex align-items-center justify-content-between d-xl-none">
            <div class="logo">
                <a href="index.html" class="d-flex align-items-center gap-3 flex-shrink-0">
                    <img src="{{ asset('assets/be/assets/img/logo-icon.svg') }}" alt="logo">
                    <div class="position-relative flex-shrink-0">
                        <img src="{{ asset('assets/be/assets/img/logo-text.svg') }}" alt="" class="logo-text">
                        <img src="{{ asset('assets/be/assets/img/logo-text-white.svg') }}" alt="" class="logo-text-white">
                    </div>
                </a>
            </div>
            <div>
                <button type="button" class="kleon-header-expand-toggle"><span class="fs-24"><i class="bi bi-three-dots-vertical"></i></button>
                <button type="button" class="kleon-mobile-menu-opener"><span class="close"><i class="bi bi-arrow-left"></i></span> <span class="open"><i class="bi bi-list"></i></span></button>
            </div>
        </div>


        <!-- bagian navbar mobile -->
        <div class="header-mobile-option">
            <div class="header-inner">
                <div class="d-flex align-items-center justify-content-end flex-shrink-0">
                    <ul class="nav-elements d-flex align-items-center list-unstyled m-0 p-0">
                        <li class="nav-item nav-search">
                            <button type="button" class="btn p-0 m-0 border-0" data-bs-toggle="modal" data-bs-target="#searchModal">
                                <i class="bi bi-search"></i>
                            </button>
                        </li>
                        <li class="nav-item nav-notification dropdown">
                            <a href="#" class="nav-toggler" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-bell-fill"></i>
                                <div class="badge rounded-circle">12</div>
                            </a>
                            <div class="dropdown-widget dropdown-menu p-0">
                                <div class="dropdown-wrapper pd-50">
                                    <div class="dropdown-wrapper--title">
                                        <h4 class="d-flex align-items-center justify-content-between">Notifications <a href="#">View All</a></h4>
                                    </div>
                                    <ul class="notification-board list-unstyled">
                                        <li class="author-online has-new-message d-flex gap-3">
                                            <div class="media bg-primary text-white">
                                                <i class="bi bi-lightning"></i>
                                            </div>
                                            <div class="user-message">
                                                <h6 class="message"><a href="#">Jackie Kun</a> mentioned you at <a href="#">Kleon Projects</a></h6>
                                                <p class="message-footer d-flex align-items-center justify-content-between"> <span class="fs-14 text-gray fw-normal">2m ago</span> <span>Mark as read</span></p>
                                            </div>
                                        </li>
                                        <li class="author-online has-new-message d-flex gap-3">
                                            <div class="media bg-secondary text-white">
                                                <i class="bi bi-lightning"></i>
                                            </div>
                                            <div class="user-message">
                                                <h6 class="message"><a href="#">Olivia Johanna</a> has created new task at <a href="#">Kleon Projects</a></h6>
                                                <p class="message-footer d-flex align-items-center justify-content-between"> <span class="fs-14 text-gray fw-normal">2m ago</span> <span>Mark as read</span></p>
                                            </div>
                                        </li>
                                        <li class="author-online has-new-message d-flex gap-3">
                                            <div class="media media-outline-red text-red">
                                                <i class="bi bi-clock-fill"></i>
                                            </div>
                                            <div class="user-message">
                                                <h6 class="message">[REMINDER] Due date of <a href="#">Highspeed Studios Projects</a> te task will be coming</h6>
                                                <p class="message-footer d-flex align-items-center justify-content-between"> <span class="fs-14 text-gray fw-normal">2m ago</span> <span>Mark as read</span></p>
                                            </div>
                                        </li>
                                    </ul>
                                    <h6 class="all-notifications"> <a href="#" class="btn bg-muted text-primary w-100 fw-bold mt-3 ff-heading px-0">View All Notifications</a> </h6>
                                </div>
                            </div>
                        </li>

                        <li class="nav-item nav-settings">
                            <a href="#" class="nav-toggler">
                                <i class="bi bi-gear-fill"></i>
                            </a>
                        </li>

                        <li class="nav-item nav-author px-3">
                            <a href="#" class="nav-toggler" data-bs-toggle="dropdown" aria-expanded="false">
                                <img src="{{ asset('assets/be/assets/img/nav_author.jpg') }}" alt="img" width="40" class="rounded-2">
                                <div class="nav-toggler-content">
                                    <h6 class="mb-0">Franklin Jr.</h6>
                                    <div class="ff-heading fs-14 fw-normal text-gray">Super Admin</div>
                                </div>
                            </a>
                            <div class="dropdown-widget dropdown-menu p-0 admin-card">
                                <div class="dropdown-wrapper">
                                    <div class="card mb-0">
                                        <div class="card-header p-3 text-center">
                                            <img src="{{ asset('assets/be/assets/img/nav_author.jpg') }}" alt="img" width="60" class="rounded-circle avatar">
                                            <div class="mt-2">
                                                <h6 class="mb-0 lh-18">Franklin Jr.</h6>
                                                <div class="fs-14 fw-normal text-gray">Super Admin</div>
                                            </div>
                                        </div>
                                        <div class="card-body p-3">
                                            <ul class="list-unstyled p-0 m-0">
                                                <li>
                                                    <a href="profile.html" class="fs-14 fw-normal text-dark d-block p-1"><i class="bi bi-person me-2"></i> Profile</a>
                                                </li>
                                                <li>
                                                    <a href="email.html" class="fs-14 fw-normal text-dark d-block p-1"><i class="bi bi-envelope me-2 "></i> Inbox</a>
                                                </li>
                                                <li>
                                                    <a href="#" class="fs-14 fw-normal text-dark d-block p-1"><i class="bi bi-gear me-2"></i> Setting & Privacy</a>
                                                </li>
                                            </ul>

                                        </div>
                                        <div class="card-footer p-3">
                                            <a href="login.html" class="btn btn-outline-gray bg-transparent w-100 py-1 rounded-1 text-dark fs-14 fw-medium"><i class="bi bi-box-arrow-right"></i> Logout</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- akhir bagian navbar mobile  -->
    </header>


    <!-- bagian side bar  -->
    @include('includes.admin.sidebar')

    <!-- akhir bagian side bar -->

    <!-- Main Wrapper-->
    <main class="main-wrapper">
        @yield('content')
    </main>



    @include('includes.admin.script')

</body>

</html>
