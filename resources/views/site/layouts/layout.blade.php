<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="description" content="">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Title -->
    <title>Wen</title>

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('/img/core-img/win-logo.png') }}">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Stylesheet -->
    <link rel="stylesheet" href="{{ asset('style.css') }}">
    
    <!-- jQuery 2.2.4 -->
    <script src="{{ asset('js/jquery.min.js') }}"></script>

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-creditcardvalidator/1.0.0/jquery.creditCardValidator.js"></script>
	
    <link rel="stylesheet" type="text/css" href="{{ asset('/regestrationFrom/css/style.css') }}">

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
   integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
   crossorigin=""/>

   <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
   integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
   crossorigin=""></script>
</head>

<body>
    <!-- Preloader -->
    <div id="preloader">
        <div class="loader"></div>
    </div>
    <!-- /Preloader -->

    <!-- Header Area Start -->
    <header class="header-area">
        <!-- Search Form -->
        <div class="search-form d-flex align-items-center">
            <div class="container">
                <form action="#" method="get">
                    <input type="search" name="search-form-input" id="searchFormInput" placeholder="{{ __('Type your keyword ...') }}">
                    <button type="submit"><i class="icon_search"></i></button>
                </form>
            </div>
        </div>

        <!-- Top Header Area Start -->
        <div class="top-header-area">
            <div class="container">
                <div class="row">

                    <div class="col-6">
                        <div class="top-header-content">
                            <a href="#"><i class="icon_phone"></i> <span>(123) 456-789-1230</span></a>
                            <a href="#"><i class="icon_mail"></i> <span>info.win@gmail.com</span></a>
                        </div>
                    </div>

                    <div class="col-6">
                        <div class="top-header-content">
                            <!-- Top Social Area -->
                            <div class="top-social-area ml-auto">
                                <a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a>
                                <a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a>
                                <a href="#"><i class="fa fa-tripadvisor" aria-hidden="true"></i></a>
                                <a href="#"><i class="fa fa-instagram" aria-hidden="true"></i></a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <!-- Top Header Area End -->

        <!-- Main Header Start -->
        <div class="main-header-area">
            <div class="classy-nav-container breakpoint-off">
                <div class="container">
                    <!-- Classy Menu -->
                    <nav class="classy-navbar justify-content-between" id="robertoNav">

                        <!-- Logo -->
                        <a class="nav-brand" href="#"><img src="{{ asset('/img/core-img/win-logo_145x59.png') }}" alt=""></a>

                        <!-- Navbar Toggler -->
                        <div class="classy-navbar-toggler">
                            <span class="navbarToggler"><span></span><span></span><span></span></span>
                        </div>

                        <!-- Menu -->
                        <div class="classy-menu">
                            <!-- Menu Close Button -->
                            <div class="classycloseIcon">
                                <div class="cross-wrap"><span class="top"></span><span class="bottom"></span></div>
                            </div>
                            <!-- Nav Start -->
                            <div class="classynav">
                                <ul id="nav">
                                    <li class="active"><a href="{{ route('index', app()->getLocale()) }}">{{ __('Home') }}</a></li>
                                    <li><a href="{{ route('hotels', app()->getLocale()) }}">{{ __('Hotels') }}</a></li>
                                    <li><a href="{{ route('chalets', app()->getLocale()) }}">{{ __('Chalets') }}</a></li>
                                    <li><a href="{{ route('restaurents', app()->getLocale()) }}">{{ __('Restaurants') }}</a></li>
                                    <li><a href="{{ route('contact-us', app()->getLocale()) }}">{{ __('Contact') }}</a></li>
                                    <li class="cn-dropdown-item has-down"><a href="#"><i class="fa-solid fa-globe"></i></a>
                                        <ul class="dropdown">
                                            <li>
                                                <li><a href="{{ route(Route::currentRouteName(), array_merge(Route::current()->parameters(), ['language' => 'en', 'checkinDate' => request('checkinDate'), 'checkoutDate' => request('checkoutDate'), 'guests' => request('guests'), 'stars' => request('stars')])) }}"><i class="flag-united-kingdom flag"></i> English</a></li>        
                                            </li>
                                            <li>
                                                <a href="{{ route(Route::currentRouteName(), array_merge(Route::current()->parameters(), ['language' => 'ar', 'checkinDate' => request('checkinDate'), 'checkoutDate' => request('checkoutDate'), 'guests' => request('guests'), 'stars' => request('stars')])) }}"><i class="flag-saudi-arabia flag"></i> العربية</a>
                                            </li>
                                        </ul>
                                    </li>
                                    @guest
                                        @if (Route::has('login'))
                                            <li>
                                                <a href="{{ route('login', app()->getLocale()) }}"><i class="fa-solid fa-right-to-bracket"></i> {{ __('Sign in') }}</a>
                                            </li>
                                        @endif

                                        @if (Route::has('register'))
                                            <li>
                                                <a href="{{ route('beginning-registration', app()->getLocale()) }}"><i class="fa fa-user"></i> {{ __('Sign up') }}</a>
                                            </li>
                                        @endif
                                    @else
                                        <li class="cn-dropdown-item has-down">
                                            <a id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                                {{ Auth::user()->name }}
                                            </a>
                                            <ul class="dropdown">
                                                <li>
                                                    <a class="" href="{{ route('logout', app()->getLocale()) }}"
                                                    onclick="event.preventDefault();
                                                                    document.getElementById('logout-form').submit();">
                                                        {{ __('Logout') }}
                                                    </a>

                                                    <form id="logout-form" action="{{ route('logout', app()->getLocale()) }}" method="POST" class="d-none">
                                                        @csrf
                                                    </form>
                                                </li>
                                            </ul>
                                        
                                        </li>
                                    @endguest
                                </ul>

                                <!-- Search -->
                                <div class="search-btn ml-4">
                                    <i class="fa fa-search" aria-hidden="true"></i>
                                </div>

                            </div>
                            <!-- Nav End -->
                        </div>
                    </nav>
                </div>
            </div>
        </div>
    </header>
    <!-- Header Area End -->

    @yield('content')

    <!-- Footer Area Start -->
    <footer class="footer-area section-padding-80-0">
        <!-- Main Footer Area -->
        <div class="main-footer-area">
            <div class="container">
                <div class="row align-items-baseline justify-content-between">
                    <!-- Single Footer Widget Area -->
                    <div class="col-12 col-sm-6 col-lg-3">
                        <div class="single-footer-widget mb-80">
                            <!-- Footer Logo -->
                            <a href="#" class="footer-logo"><img src="{{ asset('/img/core-img/win-logo_145x59.png') }}" alt=""></a>

                            <h4>+12 345-678-9999</h4>
                            <span>Info.win@gmail.com</span>
                            <span>856 Cordia Extension Apt. 356, Lake Deangeloburgh, South Africa</span>
                        </div>
                    </div>

                    <!-- Single Footer Widget Area -->
                    <div class="col-12 col-sm-4 col-lg-4">
                        <div class="single-footer-widget mb-80">
                            <!-- Widget Title -->
                            <h5 class="widget-title">Links</h5>
                            <div class="d-flex justify-content-between">
                                <div class="col-6">
                                <ul class="footer-nav">
                                <li><a href="#"><i class="fa fa-caret-right" aria-hidden="true"></i> About Us</a></li>
                                <li><a href="{{ route('terms', app()->getLocale()) }}"><i class="fa fa-caret-right" aria-hidden="true"></i> Terms</a></li>
                                <li><a href="{{ route('hotels', app()->getLocale()) }}"><i class="fa fa-caret-right" aria-hidden="true"></i> Hotels</a></li>
                                </ul>
                                </div>
                                <div class="col-6">
                                <ul class="footer-nav">
                                <li><a href="{{ route('chalets', app()->getLocale()) }}"><i class="fa fa-caret-right" aria-hidden="true"></i> Chalets</a></li>
                                <li><a href="{{ route('restaurents', app()->getLocale()) }}"><i class="fa fa-caret-right" aria-hidden="true"></i> Restaurents</a></li>
                                </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Single Footer Widget Area -->
                    <div class="col-12 col-sm-8 col-lg-4">
                        <div class="single-footer-widget mb-80">
                            <!-- Widget Title -->
                            <h5 class="widget-title">Subscribe Newsletter</h5>
                            <span>Subscribe our newsletter gor get notification about new updates.</span>

                            <!-- Newsletter Form -->
                            <form action="#" class="nl-form">
                                <input type="email" class="form-control" placeholder="Enter your email...">
                                <button type="submit"><i class="fa fa-paper-plane"></i></button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Copywrite Area -->
        <div class="container">
            <div class="copywrite-content">
                <div class="row align-items-center">
                    <div class="col-12 col-md-8">
                        <!-- Copywrite Text -->
                        <div class="copywrite-text">
                            <p><!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved, Made with <i class="fa fa-heart-o" aria-hidden="true"></i> by Win
<!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. --></p>
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <!-- Social Info -->
                        <div class="social-info">
                            <a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a>
                            <a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a>
                            <a href="#"><i class="fa fa-instagram" aria-hidden="true"></i></a>
                            <a href="#"><i class="fa fa-linkedin" aria-hidden="true"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!-- Footer Area End -->

    <!-- **** All JS Files ***** -->

    <!-- Bootstrap -->
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <!-- All Plugins -->
    <script src="{{ asset('js/roberto.bundle.js') }}"></script>
    <!-- Active -->
    <script src="{{ asset('js/default-assets/active.js') }}"></script>
    @yield('script')
</body>

</html>