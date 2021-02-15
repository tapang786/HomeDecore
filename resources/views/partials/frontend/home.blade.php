@extends('layouts.master')
@section('content')

<?php
  print_r ($settings);

 ?>
<body>

    <!-- ///////////  START IMAGE SECTION ////////// -->

    <section
      class="hero-section d-flex justify-content-center position-relative"
    >
      <div class="container position-absolute h-100" id="content">
        <div class="left-part-content">
          <p>OUR FLOORS ARE DESIGNED TO LAST <br />A LIFETIME</p>
          <h1><strong><b>Flooring For<br />Any Interior</b></strong></h1>

          <button type="button" class="shopbutton" name="button">
            SHOP NOW
            <button type="button" class="shopbtn" name="button">
              <i class="fa fa-chevron-right"></i>
            </button>
          </button>
        </div>
      </div>
      <div class="w-100 d-flex">
        <div class="left-part"></div>
        <div class="right-part imager" id="left-image"></div>
      </div>
    </section>

    <!-- ///////////  END IMAGE SECTION ////////// -->
    <!-- //////////////  START CARD SECTION //////////// -->
    <section>
      <div class="container">
        <div class="inner-content py-5">
          <div class="row">
            <div class="col pr-1">
              <div class="card">
                <div class="outer">
                  <img src="image/fa1.png" alt="" />
                  <div class="card-body p-0">
                    <h5 class="card-title custom-card-title">Home Decor</h5>
                    <p class="card-text">But i must plain</p>
                  </div>
                </div>
              </div>
            </div>
            <div class="col pl-2 pr-1">
              <div class="card">
                <div class="outer">
                  <img src="image/fa2.png" alt="" />
                  <div class="card-body p-0">
                    <h5 class="card-title custom-card-title">Celing Decor</h5>
                    <p class="card-text">Purses or desir</p>
                  </div>
                </div>
              </div>
            </div>
            <div class="col pr-1 pl-1">
              <div class="card">
                <div class="outer">
                  <div class="card-bg h-100">
                    <img src="image/fa3.png" alt="" />
                    <div class="card-body p-0">
                      <h5 class="card-title custom-card-title">Wall Decor</h5>
                      <p class="card-text">Except to contain</p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- //////////////  END CARD SECTION //////////// -->

    <!-- ////////////////  START ABOUT SECTION////////////// -->
    <section class="about">
      <div class="container-fluid">
        <div class="widg">
          <div class="container">
            <div class="row innerset">
              <div class="col-sm-6 texture">
                <h5>ABOUT US</h5>
                <h1>Flooring & Paving Services</h1>
                <hr id="hr" />
                <h5 id="top">
                  We also <span id="wide">Specialize</span> in servicing
                  apartment owners <br />and property management companies
                  requiring<br />
                  replacement products for existing units.
                </h5>
                <p id="topp">
                  Leverage agile frameworks to provide a robust synopsis for
                  high level<br />
                  overviews. Iterative approaches to corporate strategy foster
                  collaborative startegy foster proposition.
                </p>
                <p>For More Details <a href="#" id="wider">Click Here!</a></p>
              </div>
              <div class="col-sm-6 roomimage">
                <img src="image/img-8.png" alt="" />
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- ////////////////  END ABOUT SECTION////////////// -->
    <!-- ////////// START GALLERY SECTION ////////// -->
    <section>
      <div class="gallery text-center">
        <h6>BEST ACCESSORIES</h6>
        <h1>Featured Products</h1>
        <p>Will your clients accept that you go about things order.</p>

        <div class="warpper">
          <input class="radio" id="one" name="group" type="radio" checked />
          <input class="radio" id="two" name="group" type="radio" />
          <input class="radio" id="three" name="group" type="radio" />
          <div class="tabs">
            <label class="tab" id="one-tab" for="one">BEST SELLERS</label>
            <label class="tab" id="two-tab" for="two">FEATURED</label>
            <label class="tab" id="three-tab" for="three">SALES</label>
          </div>
          <div class="panels">
            <div class="panel" id="one-panel">

              <div class="gallery-image">
                <div class="row ">
                  <div class="col-sm-3">
                    <img src="image/gal-4.png" alt="" />
                    <h6 class="text-center mt-3">Reef Geometric Rug RF15</h6>
                    <p class="text-center text-danger"><b>$160.25</b></p>
                  </div>
                  <div class="col-sm-3">
                    <img src="image/gal-3.png" alt="" />
                    <h6 class="text-center mt-3">Reef Geometric Rug RF15</h6>
                    <p class="text-center text-danger"><b>$160.25</b></p>
                  </div>
                  <div class="col-sm-3">
                    <img src="image/gal-2.png" alt="" />
                    <h6 class="text-center mt-3">Reef Geometric Rug RF15</h6>
                    <p class="text-center text-danger"><b>$160.25</b></p>
                  </div>
                  <div class="col-sm-3">
                    <img src="image/gal-5.png" alt="" />
                    <h6 class="text-center mt-3">Reef Geometric Rug RF15</h6>
                    <p class="text-center text-danger"><b>$160.25</b></p>
                  </div>
                </div>
              </div>
            </div>
            <div class="panel" id="two-panel">

              <div class="gallery-image">
                <div class="row">
                  <div class="col-sm-3">
                    <img src="image/gal-1.png" alt="" />
                    <h6 class="text-center mt-3">Reef Geometric Rug RF15</h6>
                    <p class="text-center text-danger"><b>$160.25</b></p>
                  </div>
                  <div class="col-sm-3">
                    <img src="image/gal-2.png" alt="" />
                    <h6 class="text-center mt-3">Reef Geometric Rug RF15</h6>
                    <p class="text-center text-danger"><b>$160.25</b></p>
                  </div>
                  <div class="col-sm-3">
                    <img src="image/gal-3.png" alt="" />
                    <h6 class="text-center mt-3">Reef Geometric Rug RF15</h6>
                    <p class="text-center text-danger"><b>$160.25</b></p>
                  </div>
                  <div class="col-sm-3">
                    <img src="image/gal-4.png" alt="" />
                    <h6 class="text-center mt-3">Reef Geometric Rug RF15</h6>
                    <p class="text-center text-danger"><b>$160.25</b></p>
                  </div>
                </div>
              </div>
            </div>
            <div class="panel" id="three-panel">

              <div class="gallery-image">
                <div class="row">
                  <div class="col-sm-3">
                    <img src="image/gal-1.png" alt="" />
                    <h6 class="text-center mt-3">Reef Geometric Rug RF15</h6>
                    <p class="text-center text-danger"><b>$160.25</b></p>
                  </div>
                  <div class="col-sm-3">
                    <img src="image/gal-2.png" alt="" />
                    <h6 class="text-center mt-3">Reef Geometric Rug RF15</h6>
                    <p class="text-center text-danger"><b>$160.25</b></p>
                  </div>
                  <div class="col-sm-3">
                    <img src="image/gal-3.png" alt="" />
                    <h6 class="text-center mt-3">Reef Geometric Rug RF15</h6>
                    <p class="text-center text-danger"><b>$160.25</b></p>
                  </div>
                  <div class="col-sm-3">
                    <img src="image/gal-4.png" alt="" />
                    <h6 class="text-center mt-3">Reef Geometric Rug RF15</h6>
                    <p class="text-center text-danger"><b>$160.25</b></p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>



      <div class="wrapper mt-5">
        <video class="video">
            <source src="video/video.mp4" type="video/mp4" />
        </video>
      <div class="playpause"></div>
    </div>

    </section>
    <!-- ////////// END  GALLERY SECTION  ////////// -->
    <!-- //////////////  START DECORATION SECTION ////////// -->
    <section class="decoration">
      <div class="container-fluid" id="image-text">
        <div class="container">
          <div class="innerset">
            <div class="img-tex">
              <img src="image/img-9.png" alt="" />
              <div class="img-text bottom-left">
                <h4>
                  New Arrivals in <br />
                  Decorations.
                </h4>
                <a href="">View More</a>
              </div>
            </div>
            <div class="img-text-2">
              <div class="conatiner">
                <h4>
                  New Decoration<br />
                  Solutions for Home.
                </h4>
                <p class="mt-3 mb-3">
                  But I must explain to you how all this mistaken idea of
                  denouncing pleasure and praising pain was born and I will give
                  you a complete account of the system, andexpound the actual
                  teachings of the great consequences.
                </p>
                <div class="row">
                  <div class="col-sm-5">
                    <img src="image/img-10.png" class="gal-img" alt="" />
                  </div>
                  <div class="col-sm-5">
                    <img src="image/img-11.png" class="gal-img" alt="" />
                  </div>
                  <button class="toshop">TOSHOP</button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- //////////////  END DECORATION SECTION ////////// -->
    <!-- //////////////  START SLIDE SECTION ////////// -->
    <section class="insta-stories">
      <div class="container">
        <div class="gallery text-center container">
          <h6>SEE OUR COLLECTION</h6>
          <h1>Our Instagram Stories</h1>
          <p>
            Built a tested code base or had them built, you decided on a
            content.
          </p>
          <div class="">
            <div class="carousel mb-5 mt-5">
              <div>
                <img src="{{ asset('image/IMG-12.png') }}" />
              </div>
              <div>
                <img src="{{ asset('image/IMG-13.png') }}" />
              </div>
              <div>
                <img src="{{ asset('image/IMG-14.png') }}" />
              </div>
              <div>
                <img src="{{ asset('image/IMG-15.png') }}" />
              </div>
              <div>
                <img src="{{ asset('image/IMG-16.png') }}" />
              </div>
              <div>
                <img src="{{ asset('image/IMG-13.png') }}" />
              </div>
              <div>
                <img src="{{ asset('image/IMG-14.png') }}" />
              </div>
              <div>
                <img src="{{ asset('image/IMG-15.png') }}" />
              </div>
              <div>
                <img src="{{ asset('image/IMG-16.png') }}" />
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- //////////////  END SLIDER SECTION ////////// -->
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

    <!-- //////////////  JAVA SCRIPT ////////// -->

@endsection
@section('scripts')
@parent

@endsection
