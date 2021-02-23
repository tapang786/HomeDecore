@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        <h4 class="card-title">
            
        </h4>
          <div class="row">
            <div class="col-sm-6">
                <h4 class="card-title">
                   {{ $title }} 
                </h4>
            </div>
            <div class="col-sm-6 text-right">
                @can('page_create')
                <div style="margin-bottom: 10px;" class="row">
                    <div class="col-lg-12">
                        <a class="btn btn-success btn-sm" href="{{ route('admin.load-page') }}" >
                            View Page Module
                        </a>
                    </div>
                </div>
                @endcan
            </div>
        </div>
    </div>
    <div class="card-body">
      <form action="{{ route("admin.home.store") }}" method="POST" enctype="multipart/form-data">
        @csrf
        @if(session()->has('msg'))
          <p class="alert alert-success">{{ session('msg') }}</p>
        @endif

        <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }} col-sm-6 bannerImage hide">
          <label for="name">Section Name</label>
          <input type="text" name="content_title" class="form-control" value="{{ isset($section->content_title) ? $section->content_title : '' }}">
        </div>

        <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }} col-sm-12 bannerImage hide">
          <label for="name">Section</label>
          <textarea style="height:400px !important;" class="editor1 form-control" name="content" >{{isset($section->contents)?$section->contents:'' }}</textarea>
        </div>
        <input type="hidden" id="name" name="id" class="form-control" value="{{ isset($section->id)?$section->id:'' }}" >
        {{-- <div class="row">
          <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }} col-sm-6">
              <label for="name">Select Module</label>
              <select class="form-control module" name="module" >
                <option value="{{ isset($page->page_title)?$page->page_title:'' }}">{{ isset($page->page_title)?$page->page_title:'Select Module' }}</option>
                <option>Offer Banner</option>
                <option>Product Banner</option>
                <option>Display Products</option>
              </select>
          </div>
          <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }} col-sm-6 ">
            <label for="name">Content Position</label>
            <select class="form-control " name="content_post" >
               <option value="{{ isset($page->page_title)?$page->page_title:'' }}">{{ isset($page->page_title)?$page->page_title:'Select Content Position' }}</option>
               <option>Top</option>
               <option>Middle</option>
               <option>Footer</option>
            </select>
          </div>
          <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }} col-sm-6 ">
            <label for="name">Position Priority</label>
            <select class="form-control" name="position" >
               @for ($i =1 ; $i <=10 ; $i++)
                   <option>{{ $i }}</option>
               @endfor
            </select>
          </div>
          <div class="form-group {{$errors->has('email')?'has-error' : '' }} col-sm-6 hide">
            <label for="attribute">What will apply on banner?</label><br>
            <input type="radio" class="form-check-label pricingType" value="discount" name="pricingType"> Product Discount &nbsp;&nbsp;&nbsp;
            <input type="radio" class="form-check-label pricingType" value="price" name="pricingType"> Product Price
          </div>
          <div class="form-group {{$errors->has('email')?'has-error' : '' }} col-sm-6 hide">
            <label for="attribute" id="minLabel"></label><br>
            <input type="number" class="form-control"  name="minPricing">
          </div>
          <div class="form-group {{$errors->has('email')?'has-error' : '' }} col-sm-6 hide">
            <label for="attribute" id="maxLabel"></label><br>
            <input type="number" class="form-control"  name="maxPricing">
          </div>
          <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }} col-sm-6">
            <label for="name">Add Product Categories(optional)</label>
            <select class="form-control select2" name="cat[]" required multiple >
              <option value=""></option>
              @isset($category)
                @foreach ($category as $cat)
                  <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                @endforeach
              @endisset
            </select>
          </div>

          <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }} col-sm-6 bannerImage hide">
            <label for="name">Banner Image</label>
            <input type="file" name="banner" class="form-control" value="">
          </div>
          <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }} col-sm-6 totalProduct tot">
            <label for="name">Total Number of Product to show</label>
            <input type="number" name="totproduct" class="form-control" value="">
          </div>
          <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }} col-sm-6 totalRow tot">
            <label for="name">Total Number of Product in one row</label>
            <input type="number" name="productrow" class="form-control" value="">
          </div>
          <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }} col-sm-12 title">
              <label for="name">Content Title (optional)</label>
              <input type="text" id="name" name="title" class="form-control" value="{{ isset($page->page_sub_title)?$page->page_sub_title:'' }}"  value="">
              <input type="hidden" id="name" name="id" class="form-control" value="{{ isset($page->id)?$page->id:'' }}" >
          </div>
          <div class="form-group {{$errors->has('email')?'has-error' : '' }} col-sm-12 content">
            <label for="email">Contents</label>
            <textarea style="height:400px !important;" class="editor1 form-control" name="content" >{{isset($page->page_subtitle_content)?$page->page_subtitle_content:'' }}</textarea>
          </div>
          <div class="form-group {{$errors->has('email')?'has-error' : '' }} col-sm-12">
            <label for="attribute">Apply Attribute</label><br>
            <input type="radio" class="form-check-label" value="best seller" name="newA"> Best Seller &nbsp;&nbsp;&nbsp;
            <!-  <input type="radio" class="form-check-label" value="brand" name="newA"> Show By Brand ->
            <input type="radio" class="form-check-label" value="latest" name="newA"> New Arrival&nbsp;&nbsp;&nbsp;
           
          </div>
          <div class="form-group {{$errors->has('email')?'has-error' : '' }} col-sm-12">
            <label for="attribute">Show As A</label><br>
            <input type="radio" class="form-check-label" value="slider" name="showas"> Slider Image &nbsp;&nbsp;&nbsp;
            <input type="radio" class="form-check-label" value="single" name="showas"> Single Image
          </div>
          <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }} col-sm-12">
            <label for="name">Meta keyword</label>
            <input type="text" id="name" name="meta_title" class="form-control" value="{{isset($page->meta_title)?$page->meta_title:'' }}" >
          </div>
          <div class="form-group {{$errors->has('email')?'has-error' : '' }} col-sm-12">
            <label for="email">Meta Description</label>
            <textarea  class=" form-control" name="meta_keyword">{{isset($page->meta_description)?$page->meta_description:'' }}</textarea>
          </div>
          --}}
          <div>
            <input class="btn btn-danger" type="submit" value="{{ trans('global.save') }} & Update">
          </div>
        </div> 
      </form>
    </div>
</div>
@push('ajax-script')
  <script type="text/javascript">
    $(document).ready(function() {
      $(".post").hide();
      $(document).on('change', '.module', function(event) {
         let v=$('.module option:selected').text();
           if(v=="Offer Banner"){
              $(".hide").show();
              $(".tot").hide(); 
               $(".post").hide();
           }else if(v=="Product Banner"){
             $(".hide").show();
              $(".tot").hide(); 
               $(".post").hide();
           }else if(v=="Display Products"){
             $(".hide").hide();
              $(".tot").show(); 
              $(".post").show();
              $(".pricingType").prop('checked', false);
           }
      });
      $(document).on('click', '.pricingType', function(event) {
        let v=$(this).val()
        if(v=="discount"){
          $('#minLabel').text("Minimum Product Discount in(%)");
          $('#maxLabel').text("Maximum Product Discount in(%)");
        } if(v=="price"){
          $('#minLabel').text("Minimum Product Price");
          $('#maxLabel').text("Maximum Product Price");
        }
      });
    });
  </script>
@endpush
@endsection
