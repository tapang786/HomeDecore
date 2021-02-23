@extends('layouts.master')

@section('styles')
	@parent
	<link href="{{ asset('css/product.css') }}" rel="stylesheet" />
	<link href="{{ asset('elevatezoom/css/jquery.ez-plus.css') }}" rel="stylesheet" />
@endsection

<title>{{ $product->pname }}</title>
@section('content')


    <section class="page-content">
      	<div class="container">
	        {{-- {!! $product->page_subtitle_content !!} --}}
	        {{-- <pre> <?php print_r($product); ?> </pre> --}}
      	</div>
    </section>
        <!-- ////////////// START PRODUCT DESC////////////////////// -->
    <section class="description mt-5">
      <div class="container">
        <div class="row">
          <div class="col-sm-6">
            <div class="img-section">

            	<div class="zoom-wrapper">
                    <div class="zoom-left">

						@isset($product)
							@php  
								$thumbs = json_decode($product->thumbnails,true);
							@endphp

						    <img class="zoom-img" id="zoom_09" src="{{ url('product/thumbnail') }}/{{ $thumbs[0] }}" data-zoom-image="{{ url('product/thumbnail') }}/{{ $thumbs[0] }}" width="411"/>
						@endisset

                        <div id="gallery_09" class="cus_gallery_imgs">
	                        @php $i=1 @endphp
							@isset($product)
							    @foreach(json_decode($product->thumbnails,true) as $thumb)
							      	@if($i==1)
							         <a href="#" class="elevatezoom-gallery active" data-update=""
		                               data-image="{{ url('product/thumbnail') }}/{{ $thumb }}"
		                               data-zoom-image="{{ url('product/thumbnail') }}/{{ $thumb }}">
		                                <img src="{{ url('product/thumbnail') }}/{{ $thumb }}" /></a>
							        @else
							        	<a href="#" class="elevatezoom-gallery" data-update=""
		                               data-image="{{ url('product/thumbnail') }}/{{ $thumb }}"
		                               data-zoom-image="{{ url('product/thumbnail') }}/{{ $thumb }}">
		                                <img src="{{ url('product/thumbnail') }}/{{ $thumb }}" /></a>
							       	@endif 
							       	@php $i++ @endphp 
							    @endforeach
							@endisset
                        </div>
                    </div>
                </div>                                             
            </div>
		</div>
		<div class="col-sm-6">
            <div class="description-section">
				<h3>{!! $product->pname !!}</h3>
				<p>SKU: {{ $product->sku_id }}</p>
				<h3>${{ $product->s_price }}</h3>
				{{-- <h5>Add Premium Anti-Slip Underlay</h5>
	            <div class="drop d-flex">
	                <div class="dropdown">
	                  <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" >
	                    Chosse an option
	                  </button>
	                  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
	                    <a class="dropdown-item" href="#">Action</a>
	                    <a class="dropdown-item" href="#">Another action</a>
	                    <a class="dropdown-item" href="#">Something else here</a>
	                  </div>
	                </div>
	                <div class="dropdown ml-4">
	                  <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" >
	                    Chosse an option
	                  </button>
	                  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton"
	                  >
	                    <a class="dropdown-item" href="#">Action</a>
	                    <a class="dropdown-item" href="#">Another action</a>
	                    <a class="dropdown-item" href="#">Something else here</a>
	                  </div>
	                </div>
	            </div> --}}
              	@if($product->stock > $product->stock_alert) 
              		<p>In stock</p>
              	@elseif($product->stock < $product->stock_alert && $product->stock > 0) 
              		<p>Few Items Left</p>
              	@else 
              		<p>Out of stock</p>
              	@endif
              <div class="qunatity">
                <form id="myform" method="POST" action="#">
                  	<input type="button" value="-" class="qtyminus" field="quantity" />
                  	<input type="text" name="quantity" value="0" class="qty" />
                  	<input type="button" value="+" class="qtyplus" field="quantity" />
                  	<input type="hidden" name="product_id" value="{{ $product->id }}">
                </form>
                <button class="cart-btn ml-4" data-id="{{ $product->id }}">ADD TO CART</button>
                <button class="wish-btn ml-3" data-id="{{ $product->id }}">ADD TO WISHLIST</button>
                <p class="available">Available in Stores</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- ////////////// END PRODUCT DESC////////////////////// -->
    <!-- ////////////// START PRODUCT DESC////////////////////// -->

    <section class="discript mt-5 mb-5">
      <div class="container">
        <div class="discrpt">
          <h3>Description:</h3>
          {!! $product->p_description !!}
        </div>
      </div>
    </section>
    <!-- ////////////// END PRODUCT DESC////////////////////// -->
    <!-- ////////////// START SIMILAR DESC////////////////////// -->
    <section class="similar mb-5 mt-5">
      <div class="container">
        <h1>Similar Products</h1>
        <div class="gallery-image">
          <div class="row mt-5 mb-5">
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
    </section>
    <!-- ////////////// END SIMILAR DESC////////////////////// -->
    
@endsection
@section('scripts')
<script type="text/javascript">
    $(document).ready(function () {
        $("#zoom_09").ezPlus({
            gallery: "gallery_09",
            galleryActiveClass: "active"
        });

        $("#select").change(function (e) {
            var currentValue = $("#select").val();
          
            $('#gallery_09 a').removeClass('active').eq(currentValue - 1).addClass('active');
            var ez = $('#zoom_09').data('ezPlus');
            ez.swaptheimage(smallImage, largeImage);
        });
    });
</script>
@parent
<style type="text/css">
	.zoom-left {
		float: left;
	    width: 100%;
	    overflow: hidden;
	}
	.zoom-left img.zoom-img {
		float: left;
    	width: 100%;
        max-height: 400px;
	}
	.cus_gallery_imgs {
		min-width:500px;
		width: 100%;
		float:left;
	}
	.cus_gallery_imgs > a {
		width: 20%;
	    float: left;
	    height: 75px;
	    padding: 4px;
	    padding-left: 0;
	}
	.cus_gallery_imgs > a > img {
		width: 100%;
	    height: 65px;
	}
</style>
<script type="text/javascript" src="{{ asset('elevatezoom/src/jquery.ez-plus.js') }}"></script>
@endsection