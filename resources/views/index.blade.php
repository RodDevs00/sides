<!DOCTYPE html>
<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>BALAIS DOCTORS INFIRMARY</title>
        <link rel="icon" href="{{ asset('img/landing/balais.png') }}">
        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="{{ asset('css/landing/bootstrap.min.css') }}">
        <!-- animate CSS -->
        <link rel="stylesheet" href="{{ asset('css/landing/animate.css') }}">
        <!-- owl carousel CSS -->
        <link rel="stylesheet" href="{{ asset('css/landing/owl.carousel.min.css') }}">
        <!-- themify CSS -->
        <link rel="stylesheet" href="{{ asset('css/landing/themify-icons.css') }}">
        <!-- flaticon CSS -->
        <link rel="stylesheet" href="{{ asset('css/landing/flaticon.css') }}">
        <!-- magnific popup CSS -->
        <link rel="stylesheet" href="{{ asset('css/landing/magnific-popup.css') }}">
        <!-- nice select CSS -->
        <link rel="stylesheet" href="{{ asset('css/landing/nice-select.css') }}">
        <!-- swiper CSS -->
        <link rel="stylesheet" href="{{ asset('css/landing/slick.css') }}">
        <!-- style CSS -->
        <link rel="stylesheet" href="{{ asset('css/landing/style.css') }}">
    </head>
    <body>
        <!--::header part start::-->
        <header class="main_menu home_menu">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-12">
                        <nav class="navbar navbar-expand-lg navbar-light">
                            <a class="navbar-brand" href="{{ route('index') }}"> <img src="{{ asset('img/landing/balais.png') }}"
                                    alt="logo" style="width: 50px;"> Balais Doctors Infirmary
                            </a>
                            <button class="navbar-toggler" type="button" data-toggle="collapse"
                                data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                                aria-expanded="false" aria-label="Toggle navigation">
                                <span class="navbar-toggler-icon"></span>
                            </button>

                            <div class="collapse navbar-collapse main-menu-item justify-content-center"
                                id="navbarSupportedContent">
                                <ul class="navbar-nav align-items-center">
                                    <li class="nav-item active">
                                        <a class="nav-link" href="#">Home</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#about">About</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#services">Services</a>
                                    </li>
                                   
                                </ul>
                            </div>
                            <a class="btn_2 d-none d-lg-block" href="{{ route('login') }}">Login</a>
                            <a class="btn d-none d-lg-block" href="{{ route('register') }}">Register</a>
                        </nav>
                    </div>
                </div>
            </div>
        </header>
        <!-- Header part end-->

        <!-- banner part start-->
        <section class="banner_part">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-5 col-xl-6">
                        <div class="banner_text">
                            <div class="banner_text_iner">
                                <h1>Balais Doctors Infirmary </h1>
                                <h2>Online Appointment and Consultation</h2>
                                <p>Trusted to give medical advices and advanced  medical technologies.</p>
                                <a href="{{ route('login') }}" class="btn_2">Schedule your consultation</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="banner_img ml-5">
                            <img src="{{ asset('img/landing/balais.png') }}" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- banner part start-->

        <!-- about us part start-->
        <section class="about_us padding_top" id="about">
            <div class="container">
                <div class="row justify-content-between align-items-center">
                    <div class="col-md-6 col-lg-6">
                        <div class="about_us_img">
                            <img src="{{ asset('img/landing/calendar.png') }}" alt="">
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-5">
                        <div class="about_us_text">
                            <h2>Services</h2>
                            <p>Our main goal is for our patients to find the perfect doctor and schedule an appointment as easily as possible. This journey needs to be pleasant, so we are always willing to help. </p>
                            <div class="banner_item">
                                <div class="single_item">
                                    <img src="{{ asset('img/landing/icon/banner_1.svg') }}" alt="">
                                    <h5>Doctors</h5>
                                </div>
                                <div class="single_item">
                                    <img src="{{ asset('img/landing/icon/banner_2.svg') }}" alt="">
                                    <h5>Scheduling</h5>
                                </div>
                                <div class="single_item">
                                    <img src="{{ asset('img/landing/icon/banner_3.svg') }}" alt="">
                                    <h5>Qualified</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- about us part end-->

        <!-- feature_part start-->
        <section class="feature_part" id="services">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-xl-8">
                        <div class="section_tittle text-center">
                            <h2>Our Services</h2>
                        </div>
                    </div>
                </div>
                <div class="row justify-content-between align-items-center">
                    <div class="col-lg-3 col-sm-12">
                        <div class="single_feature">
                            <div class="single_feature_part">
                                <span class="single_feature_icon"><img src="{{ asset('img/landing/children.png') }}"
                                        alt=""></span>
                                <h4>Pediatrics</h4>
                                <p>Our mission is to offer preventative support so that children and adolescents grow up healthy and happy.</p>
                            </div>
                        </div>
                        <div class="single_feature">
                            <div class="single_feature_part">
                                <span class="single_feature_icon"><img src="{{ asset('img/landing/heart.png') }}"
                                        alt=""></span>
                                <h4>Cardiology</h4>
                                <p>Our cardiologists are highly qualified to identify diseases of one of the main organs of the human body.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-12">
                        <div class="single_feature_img">
                            <img src="{{ asset('img/landing/doctors2.png') }}" alt="">
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-12">
                        <div class="single_feature">
                            <div class="single_feature_part">
                                <span class="single_feature_icon"><img src="{{ asset('img/landing/eye.png') }}"
                                        alt=""></span>
                                <h4>Ophthalmology</h4>
                                <p>Care for diseases that affect the eyes and vision is carried out by our ophthalmologists.</p>
                            </div>
                        </div>
                        <div class="single_feature">
                            <div class="single_feature_part">
                                <span class="single_feature_icon"><img src="{{ asset('img/landing/bone.png') }}"
                                        alt=""></span>
                                <h4>Orthopedics</h4>
                                <p>Our orthopedists take care of your bones, muscles, joints, ligaments and other components of your system.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- feature_part start-->

        

        <!-- footer part start-->
        <footer class="footer-area">
            <div class="copyright_part">
                <div class="container">
                    <div class="row align-items-center">
                        <p class="footer-text m-0 col-lg-8 col-md-12">
                            Copyright &copy;<script>
                                document.write(new Date().getFullYear());
                            </script> All rights reserved
                        </p>
                        <div class="col-lg-4 col-md-12 text-center text-lg-right footer-social">
                            <a href="#"><i class="ti-facebook"></i></a>
                            <a href="#"> <i class="ti-twitter"></i> </a>
                            <a href="#"><i class="ti-instagram"></i></a>
                            <a href="#"><i class="ti-skype"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
        <!-- footer part end-->

        <!-- jquery plugins here-->
        <script src="{{ asset('js/landing/jquery-1.12.1.min.js') }}"></script>
        <!-- popper js -->
        <script src="{{ asset('js/landing/popper.min.js') }}"></script>
        <!-- bootstrap js -->
        <script src="{{ asset('js/landing/bootstrap.min.js') }}"></script>
        <!-- owl carousel js -->
        <script src="{{ asset('js/landing/owl.carousel.min.js') }}"></script>
        <script src="{{ asset('js/landing/jquery.nice-select.min.js') }}"></script>
        <!-- contact js -->
        <script src="{{ asset('js/landing/jquery.ajaxchimp.min.js') }}"></script>
        <script src="{{ asset('js/landing/jquery.form.js') }}"></script>
        <script src="{{ asset('js/landing/jquery.validate.min.js') }}"></script>
        <script src="{{ asset('js/landing/mail-script.js') }}"></script>
        <script src="{{ asset('js/landing/contact.js') }}"></script>
        <!-- custom js -->
        <script src="{{ asset('js/landing/custom.js') }}"></script>
    </body>
</html>
