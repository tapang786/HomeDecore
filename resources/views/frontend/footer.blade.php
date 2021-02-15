
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
  </p>
  <p>
    @if ($settings->country!='')
      {{ $settings->country }}
      @endif

  </p>
  <p>
    @if ($settings->zip!='')
      {{ $settings->zip}}
      @endif

  </p>
  <p>
    @if ($settings->pan!='')
      {{ $settings->pan}}
      @endif

  </p>
  <p>
    @if ($settings->cin!='')
      {{ $settings->cin}}
      @endif

  </p>
  <p>
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
    @if ($settings->site_url!='')
      {{ $settings->site_url}}
      @endif
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
<!-- //////////////   END FOOTER SECTION ////////// -->
