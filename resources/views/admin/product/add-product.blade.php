@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header card-header-primary">
        <h4 class="card-title">
            {{ $title }} 
        </h4>
    </div>

    <div class="card-body">
<form method="post" enctype="multipart/form-data"  action="{{ route('admin.product.store') }}">
@csrf
<h6 class="txt-dark capitalize-font"><i class="zmdi zmdi-info-outline mr-10"></i>about product</h6>
<hr class="light-grey-hr"/>
<div class="row">
  <div class="col-md-6">
    <div class="form-group">
      <?php $sts = ['publish'=>1, 'pending'=>2, 'draft'=>3]; ?>
      <label class="control-label mb-10">Status </label>
      <select name="product_status" class="form-control " >
          @isset($sts)
            @foreach($sts as $k => $item)
              <option value="{{ $item }}" @isset($product) @if($item == $product->status) selected @endif @endisset >{{ Str::ucfirst($k)}}</option>
            @endforeach
          @endisset
      </select>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-md-4">
    <div class="form-group">
      <label class="control-label mb-10">Product Category <span class=" text-danger">*</span></label>
      <select name="catry" id="pc" class="form-control " >
          <option value="0">Select Category</option>
          @isset($categ)
            @foreach($categ as $item)
              <option value="{{ $item->id }}" @isset($product) @if($item->id == $product->categories) selected @endif @endisset >{{ Str::ucfirst($item->name)}}</option>
            @endforeach
          @endisset
      </select>
    </div>
  </div>
  <div class="col-md-4 @if(!isset($product)) sub_cat @endif">
    <div class="form-group">
      <label class="control-label mb-10 ">Sub Category {{-- <span class=" text-danger">*</span> --}}</label>
      <select name="subcat" id="subpc" class="form-control">
        <option value="0">Select Category</option>
        @isset($subcats)
          @foreach($subcats as $sitem)
            <option value="{{ $sitem->id }}" @isset($product) @if($sitem->id == $product->sub_category)  selected @endif @endisset >{{ Str::ucfirst($sitem->name)}}</option>
          @endforeach
        @endisset
        {{-- <option value="{{ isset($product->subCategory)?$product->subCategory['id']:'' }}">{{ isset($product->subCategory)?$product->subCategory['name']:'' }}</option>  --}}
      </select>
    </div>
  </div>
  <div class="col-md-4 @if(!isset($product)) sub_sub_cat @endif">
    <div class="form-group">
      <label class="control-label mb-10 ">Sub Category</label>
      <select name="sub_sub_category" id="subc" class="form-control" >
        <option value="0">Select Category</option>
        @isset($sub_sub_category)
          @foreach($sub_sub_category as $ssitem)
            <option value="{{ $ssitem->id }}" @isset($product) @if($ssitem->id == $product->sub_sub_category)  selected @endif @endisset >{{ Str::ucfirst($ssitem->name)}}</option>
          @endforeach
        @endisset
        {{-- <option value="{{ isset($product->subCategory)?$product->subCategory['id']:'' }}">{{ isset($product->subCategory)?$product->subCategory['name']:'' }}</option>  --}}
      </select>
    </div>
  </div>
</div>

{{-- Attribues --}}


@isset($attributes)
<div class="row">
  @foreach($attributes as $k => $v)
    @isset($v['terms'])
      <div class="col-md-3">
        <div class="form-group">
          <label class="control-label mb-10">{{ Str::ucfirst($v['name']) }}<span class=" text-danger"></span></label>
          <select name="attributes[{{-- {{ $v['slug'] }}_ --}}{{ $v['id'] }}][]" id="{{ $v['id'] }}" class="form-control select2">
            <option value="0">Select attributes</option>
            @foreach($v['terms'] as $itemk => $itmvl)
              <option value="{{ $itmvl->id }}" @isset($product_terms[$v['id']]['term_id']) @if($product_terms[$v['id']]['term_id'] == $itmvl->id) selected @endif @endisset >{{ Str::ucfirst($itmvl->value)}}</option>
            @endforeach
          </select>
        </div>
      </div>
    @endisset
  @endforeach
</div>
@endisset
{{-- // Attribues --}}

<!-- Row -->
<div class="row">
</div>
<!--/row-->
<div class="row">
<div class="col-md-6">
<div class="form-group">
<label class="control-label mb-10">SKU ID <span class=" text-danger">*</span></label>
<input type="text" id="SKU" class="form-control"  name="sku" value="{{ isset($product)?$product->sku_id:'' }}">

</div>
</div>
<div class="col-md-6">
<div class="form-group">
<label class="control-label mb-10">Product Name <span class=" text-danger">*</span></label>
<input type="text" id="firstName" class="form-control" name="pname" value="{{ isset($product)?$product->pname:'' }}">
<input type="hidden" name="pid" value="{{ isset($product->id)?$product->id:'' }}" class="pid">
</div>
</div>

<div class="col-md-6">
<div class="form-group">
<label class="control-label mb-10">Purchasing Price <span class=" text-danger">*</span></label>
<div class="input-group">
<input type="number" class="form-control" id="p_price"  name="p_price" value="{{ isset($product)?$product->p_price:'' }}">
</div>
</div>
</div>
<div class="col-md-6">
<div class="form-group">
<label class="control-label mb-10">Selling Price <span class=" text-danger">*</span></label>
<div class="input-group">
<input type="number" class="form-control" id="s_price"  name="s_price" value="{{ isset($product)?$product->s_price:'' }}">
</div>
</div>
</div>
<!--/span-->
<div class="col-md-6">
<div class="form-group">
<label class="control-label mb-10">Discount </label>
<div class="input-group">
<div class="input-group-addon"><i class="ti-cut"></i></div>
<input type="number" class="form-control" id="exampleInputuname_1"  name="discount" value="{{ isset($product)?$product->discount:'0' }}">
</div>
</div>
</div>
    <div class="col-md-6">
    <div class="form-group">
    <label class="control-label mb-10">Shipping Type <span class=" text-danger">*</span></label>
    <div>
        <input type="radio" class="" value="free" name="ship" id="ship" checked="{{ isset($product->shipping) && $product->shipping=='free'?'true':'false' }}"><span> Free Shipping</span>&nbsp;&nbsp;&nbsp;
        <input type="radio" class="" value="paid" name="ship" id="ship" checked="{{ isset($product->shipping) && $product->shipping=='paid'?'true':'false' }}"><span> Paid Shipping</span>
    </div>

    </div>
    </div>
    <!--/span-->
    <div class="col-md-12">
    <div class="form-group">
    <label class="control-label mb-10">Return Policy <span class=" text-danger">*</span></label>
      <select class="form-control" name="return_policy">
        <option >{{ isset($product)?$product->return_policy:'None' }}</option>
         @for($i=1; $i <=31 ; $i++) 
          <option value="{{ $i }}">{{ $i." Days" }}</option>
         @endfor 
      </select>
    </div>
    </div>
<!--/span-->
</div>
<div class="row">
    <div class="col-md-6">
    <div class="form-group">
    <label class="control-label mb-10">Total products in stock <span class=" text-danger">*</span></label>
    <input type="number" class="form-control" name="stock" id="stock" value="{{ isset($product)?$product->stock:'' }}">
    </div>
    </div>
    <!--/span-->
    <div class="col-md-6">
    <div class="form-group " >
    <label class="control-label mb-10">Product Stock Alert <span class=" text-danger">*</span></label>
    <input type="number" class="form-control" name="stock_alert" id="stock_alert" value="{{ isset($product)?$product->stock_alert:'' }}">
    </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
    <div class="form-group">
    <label class="control-label mb-10">Tax <span class=" text-danger">*</span></label>
    <select class="form-control tax" name="tax">
    <option value="{{ isset($product->tax)?$product->tax:'Select Tax' }}">
        {{ isset($product->tax) && $product->tax=='excluded'?'Tax Excluded':'Select Tax' }}</option>
    <option value="included">Tax Included</option>
    <option value="excluded">Tax Excluded</option>
    </select>
    </div>
    </div>
    <!--/span-->
    <div class="col-md-6 {{ isset($product->tax) && $product->tax=='excluded'?'':'appTax' }}" >
    <div class="form-group " >
    <label class="control-label mb-10">Tax will apply on product <span class=" text-danger">*</span></label>
    <select class="form-control text-uppercase select2" name="tax_type[]" multiple="multiple" style="width: 100%">
        @if(isset($product->tax_type) && $product->tax_type!=null)
         @foreach(json_decode($product->tax_type,true) as $itm)
           <option >{{ $itm }}</option>
        @endforeach
        @else
          <option  value="">Select Tax Type</option>
        @endif 
           @isset($tax)
           @foreach($tax as $t)
               <option>{{ $t->tax_type }}</option>
           @endforeach
           @endisset 
    </select>
    </div>
    </div>
</div>
    <!--/row-->
<hr>
<div class="seprator-block"></div>
<h6 class="txt-dark capitalize-font"><i class="zmdi zmdi-comment-text mr-10"></i>Product Short Description</h6>
<hr class="light-grey-hr"/>
<div class="row">
<div class="col-md-12">
<div class="form-group">
<textarea class="form-control" rows="4" name="p_s_description">{{ isset($product)?$product->p_s_description:'' }}</textarea>
</div>
</div>
</div>
<div class="seprator-block"></div>
<h6 class="txt-dark capitalize-font"><i class="zmdi zmdi-comment-text mr-10"></i>Product  Description in Details</h6>
<hr class="light-grey-hr"/>
<div class="row">
<div class="col-md-12">
<textarea  name="descript" class="editor1" style="height:400px !important;">{{ isset($product)?$product->p_description:'' }}</textarea>
</div>
</div>
<div class="seprator-block"></div>
<br>
<br>
<br>

{{-- <hr class="light-grey-hr"/> --}}
<div class="row">
  <div class="col-md-6">
    <h6 class="txt-dark capitalize-font">Feature Product</h6>
    <input type="checkbox" name="feature" value="1" @if($product->feature) checked @endif>
  </div>
  <div class="col-md-6">
    <h6 class="txt-dark capitalize-font">Sales</h6>
    <input type="checkbox" name="sales" value="1" @if($product->sales) checked @endif>
  </div>
</div>

<hr>
<div class="seprator-block"></div>
<h6 class="txt-dark capitalize-font"><i class="zmdi zmdi-collection-image mr-10"></i>Product Thumbnail <span class=" text-danger">*</span></h6>
<hr class="light-grey-hr"/>
<div class="row">
<div class="col-lg-12 dropzone"  id="my-awesome-dropzone">
    <div class="row">
        @if(isset($product->thumbnails))
          @foreach(json_decode($product->thumbnails) as $thumb)
           <div class="col-sm-2"> <img src="{{ url('/product/thumbnail') }}/{{ $thumb }}" style="height:120px;width:100%;">
          </div>
          @endforeach
          <p>Upload new to override all previous thumbnail</p>
        @endif
       
    </div>
<div class="mt-40 fallback ">
<input type="file"  class="dropify "  name="thumbnail[]" multiple id="thumbnail" />
</div>
</div>
</div>
<hr class="light-grey-hr"/>
<div class="row">
  <div class="col-md-6">
    <div class="form-group">
    <label class="control-label mb-10">Meta Title</label>
    <input type="text" class="form-control" name="meta_title" value="{{ isset($product)?$product->meta_title:'' }}">
    </div>
  </div>
  <!--/span-->
  <div class="col-md-6">
    <div class="form-group">
    <label class="control-label mb-10">Meta Keyword</label>
    <input type="text" class="form-control" name="meta_keyword" value="{{ isset($product)?$product->meta_keyword:'' }}">
    </div>
  </div>
</div>
<div class="form-actions">
  <button class="btn btn-primary btn-icon left-icon mr-10 pull-left saveproduct" type="submit"> 
    <i class="fa fa-check"></i> 
    <span>save & update</span></button>
</form>
 </div>
</div>
<style type="text/css">
  .sub_cat, .sub_sub_cat {
    display: none;
  }
</style>
@push('ajax-script')

<script type="text/javascript">

  $( document ).ready(function() {
    //
    $(document).on('change', '#pc', function(event) {
      //
      var pcat = $(this).val();
      $('.sub_sub_cat').hide();

      if(pcat != '0') {
        $.get('{{ url('admin/get-category') }}/'+pcat, function(data) {
          //
          $("#subpc").html(data.html);
          
        });  
        $('.sub_cat').show();
      } 
      else {
        $('.sub_cat').hide();
      }
    });

    $(document).on('change', '#subpc', function(event) {
      //
      var pcat = $(this).val();
      if(pcat != '0') {
        $.get('{{ url('admin/get-category') }}/'+pcat, function(data) {
          //
          $("#subc").html(data.html);
        });  
        $('.sub_sub_cat').show();
      } 
      else {
        $('.sub_sub_cat').hide();
      }
    });

    $('.appTax').hide();
    $(document).on('change', '.tax', function(event) {
      $(this).val()=="excluded"?$('.appTax').show():$('.appTax').hide()
    });
  }); 


</script>

@endpush
@endsection