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
                        <nav class="navbar navbar-expand-lg navbar-light mt-3">
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
                                        
                                    </li>
                                    <li class="nav-item">
                                       
                                    </li>
                                    <li class="nav-item">
                                       
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
                        <div class="banner_img ml-5 mb-5">
                            <img src="{{ asset('img/landing/balais.png') }}" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- banner part start-->

       
        

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
