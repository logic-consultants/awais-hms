<!doctype html>
<html lang="en">

<head>

    <!--====== Required meta tags ======-->
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!--====== Title ======-->
    <title>BD School</title>

    <!--====== Favicon Icon ======-->
    <link rel="shortcut icon" href="{{asset('assets')}}/images/fav.png" type="image/png">

    <!--====== Bootstrap css ======-->
    <link rel="stylesheet" href="{{asset('assets')}}/css/bootstrap.min.css">

    <!--====== Aos css ======-->
    <link rel="stylesheet" href="{{asset('assets')}}/css/aos.css">

    <!--====== Line Icons css ======-->
    <link rel="stylesheet" href="{{asset('assets')}}/css/LineIcons.css">

    <!--====== Default css ======-->
    <link rel="stylesheet" href="{{asset('assets')}}/css/default.css">

    <!--====== Style css ======-->
    <link rel="stylesheet" href="{{asset('assets')}}/css/style.css">
    <!--====== jquery js ======-->
    <script src="{{asset('assets')}}/js/vendor/modernizr-3.6.0.min.js"></script>
    <script src="{{asset('assets')}}/js/vendor/jquery-1.12.4.min.js"></script>


</head>

<body>

    <!--====== PRELOADER PART START ======-->

    <!-- <div class="preloader">
        <div class="loader">
            <div class="ytp-spinner">
                <div class="ytp-spinner-container">
                    <div class="ytp-spinner-rotator">
                        <div class="ytp-spinner-left">
                            <div class="ytp-spinner-circle"></div>
                        </div>
                        <div class="ytp-spinner-right">
                            <div class="ytp-spinner-circle"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> -->

    <!--====== PRELOADER PART ENDS ======-->
    
    <!--====== HEADER PART START ======-->

    <header class="header-area">
        <div class="navbar-area navbar-transparent">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <nav class="navbar navbar-expand-lg">
                            <a class="navbar-brand" href="{{url('/')}}">
                                <img src="{{asset('assets')}}/images/logo.png" alt="Logo">
                            </a>

                            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarFive" aria-controls="navbarFive" aria-expanded="false" aria-label="Toggle navigation">
                                <span class="toggler-icon"></span>
                                <span class="toggler-icon"></span>
                                <span class="toggler-icon"></span>
                            </button>

                            <!-- <div class="collapse navbar-collapse sub-menu-bar" id="navbarFive">
                                <ul class="navbar-nav ml-auto">
                                    <li class="nav-item active">
                                        <a class="page-scroll" href="#home">Home</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="page-scroll" href="#about">About</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="page-scroll" href="#features">Features</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="page-scroll" href="#pricing">Pricing </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="page-scroll" href="#team">Team</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="page-scroll" href="#contact">contact</a>
                                    </li>
                                </ul>
                            </div> -->
                            <div style="width: 100%;">
                                @if(Auth::check())
                                <div class="navbar-btn rounded-buttons float-right">
                                    <a class="main-btn rounded-one" href="{{url('dashboard')}}">{{Auth::user()->school['school_name']}}</a>
                                </div>
                                @else
                                <div class="navbar-btn rounded-buttons float-right">
                                    <a class="main-btn rounded-one" href="{{url('login')}}">Log In</a>
                                </div>
                                @endif
                            </div>
                            
                        </nav> <!-- navbar -->
                    </div>
                </div> <!-- row -->
            </div> <!-- container -->
        </div>
        @if(request()->is('/'))
        <div id="home" class="header-content-area">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-6 col-md-10">
                        <div class="header-content text-center">
                            <h3 class="header-title">Try 30 Days Free</h3>
                            <!-- <p class="text"></p> -->
                            <div class="header-newslatter">
                                <form action="{{url('subscribe')}}" method="get">
                                    <i class="lni-envelope"></i>
                                    <input type="email" name="email" required="" placeholder="Email">

                                    <div class="header-btn rounded-buttons">
                                        <button type="submit" class="main-btn rounded-three">Subscribe</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div> <!-- row -->
            </div> <!-- container -->
            <div class="header-image">
                <img src="{{asset('assets')}}/images/header.png" alt="Header">
            </div>
        </div> <!-- header content area -->
        @endif
    </header>

    <!--====== HEADER PART ENDS ======-->