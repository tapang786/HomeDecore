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
              <a href="/"><img src="{{ url('/logo') }}/{{ $data['setting']->logo}}" alt="" /></a>
              <p class="text mt-5 pstyle">
                {{ $data['setting']->desc}}
              </p>
            </div>
          </div>
        </div>
        <div class="col-md-3 col-sm-4">
          <div class="footer-widget">
            <div class="footer-menu expert">
              <h3 class="links">Account</h3>
              @foreach($data['menus']['account']['menus'] as $ke => $vl )
                <a href="{{ $vl['url'] }}" class="account"><p class="text1">{{ $vl['name'] }}</p></a>
              @endforeach
              
            </div>
          </div>
        </div>
        <div class="col-md-3 col-sm-4">
          <div class="footer-widget">
            <div class="footer-menu">
              <h3 class="links">Site Link</h3>
              @foreach($data['menus']['site-link']['menus'] as $ke => $vl )
                <a href="{{ $vl['url'] }}" class="site-link"><p class="text1">{{ $vl['name'] }}</p></a>
              @endforeach
            </div>
          </div>
        </div>
        <div class="col-md-3 col-sm-4">
          <div class="footer-widget">
            <div class="footer-menu no-padding">
              <h3 class="links">Site Link</h3>

              <p class="mt-5 text1">
                <i class="fa fa-map-marker fa-lg" aria-hidden="true"></i>

                {{ $data['setting']->city }}
                {{ $data['setting']->address}}
                <!-- Unit 158 St Patrick's Woollen Mills Douglas, Cork, T16 XN73,
                uk -->

                @if ($data['setting']->country!='')
                  {{ $data['setting']->country }}
                  @endif

                @if ($data['setting']->zip!='')
                  {{ $data['setting']->zip}}
                  @endif

                {{-- @if ($data['setting']->pan!='')
                  {{ $data['setting']->pan}}
                @endif --}}

                {{-- @if ($data['setting']->cin!='')
                  {{ $data['setting']->cin}}
                @endif --}}

                {{-- @if ($data['setting']->gstin!='')
                  {{ $data['setting']->gstin}}
                @endif --}}

              </p>
              <p>
                  @if ($data['setting']->helpline!='')
                <i
                  class="fa fa-phone fa-lg"
                  aria-hidden="true"
                  id-=" footer-fa"
                ></i>
                <!-- +353 (0)221-7894561 -->
                {{ $data['setting']->helpline}}
                  @endif
              </p>

              <p>
                @if ($data['setting']->email!='')
                <i class="fa fa-envelope fa-lg" aria-hidden="true"></i>
                <!-- shoplorem.ie -->
                {{ $data['setting']->email}}
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
      <p class=" right-con" style="float: left">Copyright © {{ now()->year }} {{ $data['setting']->title }}</p>
      <p class=" left-con" style="float: right">Designed By Expertweb</p>
    </div>
  </div>
</footer>
