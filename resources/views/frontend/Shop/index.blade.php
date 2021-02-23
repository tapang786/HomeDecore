@extends('layouts.master')
{{-- @section('scripts')
@parent
<link rel="stylesheet" href="css/shop.css" />
@endsection --}}

@section('styles')
@parent
<link href="{{ asset('css/shop.css') }}" rel="stylesheet" />
@endsection

@section('content')
<body>
<!-- ////////////////// start section//////////////////// -->
<section>
  <div class="container">
    <div class="row">
      	<div class="col-sm-3">
	        <div class="filter mt-5 filter_attr" @if($products_fillter) telnt="1" @endif data-sortby="{{ request()->get('sortby') }}" data-terms="{{ $terms }}" data-url="{{ url('/shop-filter') }}" filter_attr="{{ $attr }}" data-token={{ csrf_token() }}>
	       	  @foreach($attributes as $k => $v)
			        @isset($v['terms'])
			        <div class="style mt-1">
	                <hr>
	                <h5>
	                	{{ Str::ucfirst($v['name']) }} <i class="fa fa-angle-down" aria-hidden="true"></i>
	                </h5>
	                <ul>
	                    @foreach($v['terms'] as $itemk => $itmvl)
      		            	<li>
                          <label>
                            <input type="checkbox" {{ in_array($itmvl->id, $terms_valu)?'checked':'' }} class="filter_terms" name="filter_terms[]" data-attr="{{ $v['slug'] }}" data-term="{{ $itmvl->id }}" value="{{ $itmvl->id }}"> 
                            <span>{{ Str::ucfirst($itmvl->value)}}</span>
                          </label>
      		            	</li> 
    			            @endforeach    
	                </ul>
	            </div>
			    
			    @endisset
			@endforeach
	        </div>
       
      	</div>
      	<div class="col-sm-9 mt-5">
	        <div class="products">
	          <div class="sort d-flex m-left">
	            <h5 class="mr-3">Sort By</h5>
	            <div class="dropdown mr-4" id="dropdwn">
	              <select class="sortby" id="sortby">
                  <option class="dropdown-item" value="popularity">Popularity</option>
                  <option class="dropdown-item" value="newest">Newest First</option>
                  <option class="dropdown-item" value="asc">Price Low to High</option>
                  <option class="dropdown-item" value="desc">Price High to Low</option>
                </select>
            </div>
            <div class="dropdown ml-2 mr-2" id="dropdwn">
              <select class="per_page">
                <option class="dropdown-item" value="9">9</option>
                <option class="dropdown-item" value="15">15</option>
                <option class="dropdown-item" value="21">21</option>
                <option class="dropdown-item" value="27">27</option>
              </select>
            </div>
            <p>per page</p>
          </div>
          
          </div>
        <div class="row mt-5" id="products" style=" width:100%;  ">
        	@foreach($products as $k => $product)
            @if($products_fillter)
              {{-- @foreach($product as $k => $product) --}}
              <div class="col-sm-4 product_{{ $product->id }}">
  				        <a href="{{ url('/product').'/'.$product->slug }}">
                    @if(json_decode($product->thumbnails,true)!=null)
                    @php $j=1 @endphp
                    @foreach(json_decode($product->thumbnails,true) as $th)

                      @if($j==1)
                        <img src="{{url('/product/thumbnail')}}/{{$th}}" class="imgthumbnail" alt="{{ $product->pname }}">
                      @endif
                      @php $j++ @endphp
                    @endforeach
                    @endif
                    
                  </a>
                	<a href="{{ url('/product').'/'.$product->slug }}">
                    <h6 class="text-center mt-3">{{ $product->pname }}</h6>
                  </a>
                	<p class="text-center text-danger"><b>${{ $product->s_price }}</b></p>
              </div>
              {{-- @endforeach --}}
            @else 
              <div class="col-sm-4 product_{{ $product->id }}">
                <a href="{{ url('/product').'/'.$product->slug }}">
                  @if(json_decode($product->thumbnails,true)!=null)
                  @php $j=1 @endphp
                  @foreach(json_decode($product->thumbnails,true) as $th)

                    @if($j==1)
                      <img src="{{url('/product/thumbnail')}}/{{$th}}" class="imgthumbnail" alt="{{ $product->pname }}">
                    @endif
                    @php $j++ @endphp
                  @endforeach
                  @endif
                  
                </a>
                <a href="{{ url('/product').'/'.$product->slug }}">
                  <h6 class="text-center mt-3">{{ $product->pname }}</h6>
                </a>
                <p class="text-center text-danger"><b>${{ $product->s_price }}</b></p>
            </div>
            @endif
        	@endforeach
        </div>         
        </div>
      </div>
    </div>
  </div>
</section>
<!-- ///////////////////end section//////////////////// -->
<!-- //////////////  START NEWS SECTION ////////// -->
<section class="section mt-5">
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

@endsection
@section('scripts')
@parent
<script type="text/javascript">
	
</script>
@endsection
