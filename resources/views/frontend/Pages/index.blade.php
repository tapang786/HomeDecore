@extends('layouts.master')
<title>{{ $page->page_title }}</title>
@section('content')
<body>
    <section id="head">
      <div class="container">
        <div class="row justify-content-between">
         
          <div class="col-xs-3" id="faf">
            <i class="fa fa-user" aria-hidden="true"></i> &nbsp;<a
              href="#"
              class="hide"
            >
              My Account</a
            >
          </div>
          <div class="col-xs-3" id="fas">
            <i
              class="fa fa-truck fa-flip-horizontal fas align"
              aria-hidden="true"
            ></i>
            &nbsp;<a href="#" class="hide">World Wide Shipping</a>
          </div>

          <div class="col-xs-3" id="fa">
            <i class="fa fa-phone" aria-hidden="true"> </i> &nbsp;<a
              href="#"
              class="mr-4 hide"
              >Contact us</a
            >
            <span class="head-icon "
              ><i class="fa fa-credit-card-alt show-icon" aria-hidden="true"></i>&nbsp;
              <a href="#" class="hide">Blog</a></span
            >
          </div>

          </div>
        </div>
    </section>

    <!-- ///////////////// END TOP BAR /////////////////////// -->

    <!-- ///////////////  START LOGO BAR //////////////////// -->
    <section class="log">
      <div class="container">
        <div class="row cart">
          <div class="col-sm-3">
            <div class="dropdown">
              <span id="drop">About Us / </span
              ><button
                class="btn"
                type="button"
                data-toggle="dropdown"
                id="btn"
              >
                Useful Info<i class="fa fa-chevron-down ml-2"></i>
              </button>
              <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                <a class="dropdown-item" href="#">BEST SELLERS</a>
                <a class="dropdown-item" href="#">GOALS</a>
                <a class="dropdown-item" href="#">PRODUCT</a>
              </div>
            </div>
          </div>
          <div class="col-sm-6 text-center">
            <div class="logo">
              <img src="image/logo.png" alt="" />
            </div>
          </div>
          <div class="col-sm-3 bar">
            <div class="search-bar example">
              <input
                type="text"
                class=""
                placeholder="       Search"
                name="search2"
              />
              <button>
                <i class="fa fa-search" style="font-size: 15px"></i>
              </button>
            </div>
            <i
              class="fa fa-shopping-cart ml-3"
              aria-hidden="true"
              style="font-size: 25px"
            ></i>
            <i
              class="fa fa-heart ml-2"
              aria-hidden="true"
              style="font-size: 23px"
            ></i>
            <i
              class="fa fa-search"id="show"
              aria-hidden="true"
            ></i>
          </div>
        </div>
      </div>
    </section>
    <!-- ////////////// END LOGO BAR ///////////////// -->

    <!-- /////////// START NAV BAR  /////////////// -->

    <section id="head2">
      <div class="container">
        <nav class="navbar navbar-expand-lg navbar-light">
          <button class="navbar-toggler collapsed" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo03" aria-controls="navbarTogglerDemo03" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
        
          <div class="navbar-collapse collapse" id="navbarTogglerDemo03" style="">
            <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
              <li class="nav-item">
                <a class="nav-link" href="#">Home</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#">Shop</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#">New</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#">Carpete / Decor</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#">Textiles</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" id="clr" href="#">SALE</a>
              </li>
            </ul>
          </div>
        </nav>
        <div class="menu-logo"><img src="image/logo.png" alt=""></div>
      </div>
    </section>

    <!-- /////////// END NAV BAR  /////////////// -->
    <!-- ///////////  START TEXT BAR ////////////// -->
    <section class="page-content">
      <div class="container">
        {!! $page->page_subtitle_content !!}
      </div>
    </section>

    <!-- //////////////  START NEWS SECTION ////////// -->
    <section class="section">
      <div class="container">
        <div class="section-1 text-light">
          <h1>SIGN UP TO OUR NEWSLETTER</h1>
        </div>
        <div class="section-2">
          <input type="search" class="enter mt-3" placeholder="Enter Email" />
          <button type="submit" id="save">SIGN UP</button>
        </div>
      </div>
    </section>
    <!-- //////////////  END NEWS SECTION ////////// -->
    <!-- //////////////  START FOOTER SECTION ////////// -->
    <footer class="footer-area footer--light mt-5">
      <div class="footer-big">
        <div class="container">
          <div class="row">
            <div class="col-md-3 col-sm-4">
              <div class="footer-widget">
                <div class="widget-about">
                  <img src="image/logo.png " alt="" />
                  <p class="text mt-5 pstyle">
                    Rugs.ie is a rug shop based in Cork, Ireland. Our extensive
                    collection, personally handpicked from suppliers throughout
                    the world, includes everything from elegant Persian and
                    Oriental designs to striking modern and abstract pieces,
                    perfect for adding a touch of luxury and comfort to your
                    home
                  </p>
                </div>
              </div>
            </div>
            <div class="col-md-3 col-sm-4">
              <div class="footer-widget">
                <div class="footer-menu expert">
                  <h3 class="links">Account</h3>
                  <a href=""><p class="text1 mt-5">My Account</p></a>
                </div>
              </div>
            </div>
            <div class="col-md-3 col-sm-4">
              <div class="footer-widget">
                <div class="footer-menu">
                  <h3 class="links">Site Link</h3>
                  <a href=""><p class="text1 mt-5">Home</p></a>
                  <a href=""><p class="text1">Shop</p></a>
                  <a href=""><p class="text1">New</p></a>
                  <a href=""><p class="text1">Carpet/Rugs</p></a>
                  <a href=""><p class="text1">Home Decor</p></a>
                  <a href=""><p class="text1">Textiles</p> </a>
                </div>
              </div>
            </div>
            <div class="col-md-3 col-sm-4">
              <div class="footer-widget">
                <div class="footer-menu no-padding">
                  <h3 class="links">Site Link</h3>
                  <p class="mt-5 text1">
                    <i class="fa fa-map-marker fa-lg" aria-hidden="true"></i>
                    Unit 158 St Patrick's Woollen Mills Douglas, Cork, T16 XN73,
                    uk
                  </p>
                  <p>
                    <i
                      class="fa fa-phone fa-lg"
                      aria-hidden="true"
                      id-=" footer-fa"
                    ></i>
                    +353 (0)221-7894561
                  </p>
                  <p>
                    <i class="fa fa-envelope fa-lg" aria-hidden="true"></i>
                    shoplorem.ie
                  </p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="container" id="team">
        <div class="container-team">
          <p class=" right-con" style="float: left">Copyright © 2020 loremie</p>
          <p class=" left-con" style="float: right">Designed By Expertweb</p>
        </div>
      </div>
    </footer>    
@endsection
@section('scripts')
@parent

@endsection