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
                @foreach ($settings as $settings)

                {{ $settings->city }}
                {{ $settings->address}}



                <!-- Unit 158 St Patrick's Woollen Mills Douglas, Cork, T16 XN73,
                uk -->
                @endforeach

                @if ($settings->country!='')
                  {{ $settings->country }}
                  @endif

                @if ($settings->zip!='')
                  {{ $settings->zip}}
                  @endif

                @if ($settings->pan!='')
                  {{ $settings->pan}}
                  @endif

                @if ($settings->cin!='')
                  {{ $settings->cin}}
                  @endif

                @if ($settings->gstin!='')
                  {{ $settings->gstin}}
                  @endif

              </p>
              <p>
                  @if ($settings->helpline!='')
                <i
                  class="fa fa-phone fa-lg"
                  aria-hidden="true"
                  id-=" footer-fa"
                ></i>
                <!-- +353 (0)221-7894561 -->
                {{ $settings->helpline}}
                  @endif
              </p>

              <p>
                @if ($settings->email!='')
                <i class="fa fa-envelope fa-lg" aria-hidden="true"></i>
                <!-- shoplorem.ie -->
                {{ $settings->email}}
                @endif
              </p>
              <p>

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
