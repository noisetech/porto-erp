<!doctype html>
<html lang="en" data-bs-theme="">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>
    <!--favicon-->
    <link rel="icon" href="{{ asset('fe/assets/images/favicon-32x32.png') }}" type="image/png">
    <!-- loader-->
    <link href="{{ asset('assets/fe-login/assets/css/pace.min.css') }}" rel="stylesheet">
    <script src="{{ asset('assets/fe-login/assets/js/pace.min.js') }}"></script>

    <!--plugins-->
    <link href="{{ asset('assets/fe/assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css') }}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/fe-login/assets/plugins/metismenu/metisMenu.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/fe-login/assets/plugins/metismenu/mm-vertical.css') }}">
    <!--bootstrap css-->
    <link href="{{ asset('assets/fe/fe-login/assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('fe-login/fonts.googleapis.com/css2ab59.css') }}" rel="stylesheet">
    <link href="{{ asset('fe-login/fonts.googleapis.com/cssf511.css') }}" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <!-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> -->
    <!--main css-->
    <link href="{{ asset('assets/fe-login/assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/fe-login/sass/main.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/fe-login/sass/dark-theme.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/fe-login/sass/blue-theme.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/fe-login/sass/responsive.css') }}" rel="stylesheet">

</head>

<body>


    <!--authentication-->

    <div class="section-authentication-cover">
        <div class="">
            <div class="row g-0">

                <div class="col-12 col-xl-7 col-xxl-8 auth-cover-left align-items-center justify-content-center d-none d-xl-flex border-end bg-transparent">

                    <div class="card rounded-0 mb-0 border-0 shadow-none bg-transparent bg-none">
                        <div class="card-body">
                            <img src="{{ asset('assets/fe-login/assets/images/auth/login1.png') }}" class="img-fluid auth-img-cover-login" width="650" alt="">
                        </div>
                    </div>

                </div>

                <div class="col-12 col-xl-5 col-xxl-4 auth-cover-right align-items-center justify-content-center border-top border-4 border-primary border-gradient-1">
                    <div class="card rounded-0 m-3 mb-0 border-0 shadow-none bg-none">
                        <div class="card-body p-sm-5">
                            <img src="{{ asset('assets/fe-login/images/logo-hdo-1.png') }}" class="mb-4" width="145" alt="">
                            <h4 class="fw-bold">Masuk dan Verifikasi</h4>
                            <p class="mb-0">Nikmati kemudahan sistem autentikasi tunggal untuk mengakses semua layanan dengan satu akun.</p>

                            <!-- <div class="row g-3 my-4">
                                <div class="col-12 col-lg-12">
                                    <button class="btn btn-light py-2 font-text1 fw-bold d-flex align-items-center justify-content-center w-100"><img src="{{ asset('fe-login/assets/images/apps/05.png') }}" width="20" class="me-2" alt="">Google</button>
                                </div>

                            </div>

                            <div class="separator section-padding">
                                <div class="line"></div>
                                <p class="mb-0 fw-bold">OR</p>
                                <div class="line"></div>
                            </div> -->

                            <div class="form-body mt-4">
                                <form class="row g-3" action="{{ route('login') }}" method="post">
                                    @csrf
                                    <div class="col-12">
                                        <label for="inputEmailAddress" class="form-label">Email/Akun pengguna</label>
                                        <input type="text" name="email" class="form-control" placeholder="Masukkan email/username">
                                    </div>
                                    <div class="col-12">
                                        <label for="inputChoosePassword" class="form-label">Password</label>
                                        <div class="input-group" id="show_hide_password">
                                            <input type="password" name="password" class="form-control" id="inputChoosePassword" placeholder="Masukan password">
                                            <a href="javascript:void(0)" class="input-group-text bg-transparent"><i class="bi bi-eye-slash-fill"></i></a>
                                        </div>
                                    </div>


                                    <div class="col-md-6">

                                    </div>
                                    <div class="col-md-6 text-end"> <a href="auth-cover-forgot-password.html" class="text-white">Forgot Password ?</a>
                                    </div>
                                    <div class="col-12">
                                        <div class="d-grid">
                                            <button type="submit" class="btn btn-secondary">Login</button>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="text-start">
                                            <!-- <p class="mb-0">Belum punya akun? <a href="{{ route('register') }}">Daftar disini</a>
                                            </p> -->
                                        </div>
                                    </div>
                                </form>
                            </div>

                        </div>
                    </div>
                </div>

            </div>
            <!--end row-->
        </div>
    </div>

    <!--authentication-->




    <!--plugins-->
    <script src="{{ asset('assets/fe-login/assets/js/jquery.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            $("#show_hide_password a").on('click', function(event) {
                event.preventDefault();
                if ($('#show_hide_password input').attr("type") == "text") {
                    $('#show_hide_password input').attr('type', 'password');
                    $('#show_hide_password i').addClass("bi-eye-slash-fill");
                    $('#show_hide_password i').removeClass("bi-eye-fill");
                } else if ($('#show_hide_password input').attr("type") == "password") {
                    $('#show_hide_password input').attr('type', 'text');
                    $('#show_hide_password i').removeClass("bi-eye-slash-fill");
                    $('#show_hide_password i').addClass("bi-eye-fill");
                }
            });
        });
    </script>

</body>


<!-- Mirrored from codervent.com/maxton/demo/vertical-menu/auth-cover-login.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 06 Jan 2025 09:32:21 GMT -->

</html>
