<!-- ////////////////////// START TOP BAR///////////////////////// -->
<section id="head">
  <div class="container">
    <div class="row justify-content-between">

      <div class="col-xs-3" id="faf">
        <i class="fa fa-user" aria-hidden="true"></i> &nbsp;<a href="#" class="hide"> My Account</a>
      </div>
      <div class="col-xs-3" id="fas">
        <i class="fa fa-truck fa-flip-horizontal fas align" aria-hidden="true" ></i>
        &nbsp;<a href="#" class="hide">World Wide Shipping</a>
      </div>

      <div class="col-xs-3" id="fa">
        <i class="fa fa-phone" aria-hidden="true"> </i> &nbsp;
        <a href="#" class="mr-4 hide" >Contact us</a >
        <span class="head-icon " >
          <i class="fa fa-credit-card-alt show-icon" aria-hidden="true"></i>&nbsp;
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
            @foreach($data['menus']['useful-info']['menus'] as $ke => $vl )
              <a class="dropdown-item" href="{{ $vl['url'] }}">{{ $vl['name'] }}</a>
            @endforeach
          </div>
        </div>
      </div>
      <div class="col-sm-6 text-center">
        <div class="logo">
          <a href="/"><img src="{{ url('/logo')}}/{{ $data['setting']->logo }}" alt=""></a>
        </div>
      </div>
      <div class="col-sm-3 bar">
        <div class="search-bar example">
          <input type="text" class="" placeholder="Search" name="search2" />
          <button>
            <i class="fa fa-search" style="font-size: 15px"></i>
          </button>
        </div>
        <i class="fa fa-shopping-cart ml-3" aria-hidden="true" style="font-size: 25px" ></i>
        <i class="fa fa-heart ml-2" aria-hidden="true" style="font-size: 23px" ></i>
        <i class="fa fa-search"id="show" aria-hidden="true" ></i>
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
    @foreach($data['menus']['header-menu']['menus'] as $ke => $vl )
      <li class="nav-item">
        <a class="nav-link" href="{{ $vl['url'] }}">{{ $vl['name'] }}</a>
      </li>
    @endforeach
  </ul>
  </div>
  </nav>
  <div class="menu-logo"><img src="image/logo.png" alt=""></div>
  </div>
  </section>

<!-- /////////// END NAV BAR  /////////////// -->

