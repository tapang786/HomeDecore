@extends('layouts.admin')
@section('content')
@section('styles')
<style>
.pvarient{
    background-color:#000 !important;
    padding:0px !important;
}
.pvarient > button{
    color:#fff !important;
}
</style>
@php $nec="block";$leng="block";$sleev="block"; @endphp
 @if(session("addVariantStyle")=="sleeve")
   @php $nec="none"; $leng="none" @endphp
 @elseif(session("addVariantStyle")=="neck")
  @php $sleev="none"; $leng="none" @endphp
 @elseif(session("addVariantStyle")=="length")
  @php $nec="none"; $sleev="none" @endphp
 @endif
@endsection
<div class="card">
    <div class="card-header ">
        <div class="row">
            <div class="col-sm-6 pl-2"> <h4 class="card-title"> {{ $title }}</h4></div> 
            <div class="col-sm-6 text-right pr-1
            "><a class="btn btn-sm btn-primary" href="{{ url('admin/reset-session') }}">Add New Variant</a>
                <a class="btn btn-sm btn-primary" href="{{ url('admin/return-back/') }}">RETURN BACK <i class="fas fa-arrow-right"></i></a>
            </div>
       </div>
   </div>
   <div class="card-body">
          <div id="accordion">
            <?php if(!session()->has("addVariantStyle")){ ?>
              <div class="card">
               <div class="card-header pvarient" id="headingOne">
                  <h5 class="mb-0">
                    <button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne" type="button">
                     Color Variant
                    </button>
                  </h5>
                </div>

                <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
                  <div class="card-body">
                    <h6>Select Product Apply Color</h6><hr>
                    @if(session()->has('msg'))
                     <p class="alert-success alert p-1">{{ session('msg') }}</p>
                    @endif
                    <form id="setColor" method="POST" enctype="multipart/form-data" action="{{ route('admin.set-product-color-variant') }}" >
                        @csrf
                        <input type="hidden" name="pid" value="{{ isset($pid)?$pid:'' }}">
                         <input type="hidden" name="clrid" value="{{ session()->has('clrid')?session('clrid'):'' }}">
                    <div class="row">
                    @isset($color)
                      @foreach($color as $clr)
                        <div class="col-sm-1 float-left">
                         @if($clr->color_image!="" || $clr->color_image!=null)
                         <img src="{{ url('') }}/{{ $clr->color_image }}" style="height:40px;width:40px;border-radius:50%;">
                         @elseif($clr->color_code!=null || $clr->color_code!=="")
                         <div style="height:40px;width:40px;border-radius:50%;background-color:{{ $clr->color_code }};float:left"></div>
                         @endif
                         <div class="clearfix"></div>
                         <div style="margin-left:12px;">
                            @if(session()->has('colorid') && $clr->id==(int)session('colorid'))
                         <input type="radio" name="color" value="{{ $clr->id }}" class="form-check color" checked="">
                         @else
                         <input type="radio" name="color" value="{{ $clr->id }}" class="form-check color">
                         @endif
                         </div>
                         </div>
                      @endforeach
                      @endisset
                       <div class="form-group col-sm-4">
                            <label>Price</label>
                          <select class="form-control pvaiant" name="height">
                           <option value="pi">price included</option>
                           <option value="pv">price may vary</option>
                         </select>
                        </div>
                         <div class="form-group col-sm-4 pp">
                            <label>Product Price</label>
                         <input type="number" name="pv" class="form-control">
                        </div>
                           <div class="col-sm-12 text-right">
                                 <button class="btn btn-success btn-sm">Apply Color</button>  
                          </div>
                    </div>
                   </form>
                  </div>
                </div>
              </div>
              <div class="card">
                <div class="card-header pvarient" id="headingTwo">
                  <h5 class="mb-0">
                    <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo" type="button">
                      Product Gallary Image
                    </button>
                  </h5>
                </div>

                <div id="collapseTwo" class="collapse {{ session()->has('msggal')?'show':'' }}" aria-labelledby="headingTwo" data-parent="#accordion">
                  <div class="card-body">
                   <form method="post" enctype="multipart/form-data"  action="{{ route('admin.set-product-gallary') }}">
                    @csrf
                    <div class="row">
                     <div class="col-sm-12"><h6>Apply Gallary Image Related To Applied Color</h6></div> 
                        @if(session()->has('msggal'))
                    <div class="col-sm-12">  <p class="alert-success alert p-1">{{ session('msggal') }}</p></div>
                    @endif
                      <div class="form-group col-sm-6">
                         <input type="hidden" name="pid" value="{{ isset($pid)?$pid:'' }}">
                         <input type="hidden" name="colorid" value="{{ session()->has('colorid')?session('colorid'):'' }}">
                          <input type="file" name="gallaryImage[]" class="form-control" multiple="">
                      </div>
                       <div class="form-group col-sm-6">
                          <button class="btn btn-success btn-sm">Upload Image</button>
                      </div>
                      </div>
                  </form>
                  </div>
                </div>
              </div>
              <?php } ?>
              <div class="card">
                <div class="card-header pvarient" id="headingThree">
                  <h5 class="mb-0">
                    <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree" type="button">
                      Customize Style  {{ session('add_style') }}
                    </button>
                  </h5>
                </div>
                <div id="collapseThree" class="collapse {{ session()->has("addVariantStyle")?'show':'' }}" aria-labelledby="headingThree" data-parent="#accordion">
                  <div class="card-body">
                    @if(!session()->has("addVariantStyle"))                
                    <div class="row">
                        <div class="col-sm-12">
                            <h6>Choose Image to apply style customization</h6>
                        </div>
                        @if(session()->has('gallaryProduct'))
                            @foreach(session('gallaryProduct') as $img)  
                           <div class="col-sm-2">
                            <img src="{{ url('product/product-gallary') }}/{{ $img['image'] }}" style="height:100px;width:50%;">
                            <input type="radio" name="galimg" class="form-check galimg" value="{{ $img['id'] }}">
                           </div>
                            @endforeach
                        @endif
                   
                    </div>
                    @endif
                    <hr>
                    <!-- upload image for neckline -->
                    <form  method="POST" enctype="multipart/form-data" id="addneckstyle" style="display:{{$nec }}">
                        @csrf
                       <div class="row">
                         <div class="col-sm-12">
                            <h6>neckline style customization</h6>
                        </div>
                        <input type="hidden" name="rid" value="{{ isset($stedit->id)?$stedit->id:'' }}">
                        <div class="col-sm-3">
                             <label>NeckLine</label>
                             <select class="form-control text-capitalize neckstyle" name="style_id" required="">
                                <option value="{{ isset($stedit)?$stedit->product_style_customization_id :'' }}" selected="">{{ isset($stedit)?$stedit->getStyleName['style_group_name']:'Select neck style' }}</option>
                                 @isset($neckline)
                                  @foreach($neckline as $item)
                                    <option value="{{ $item->id }}">{{ $item->style_group_name }}</option>
                                  @endforeach
                                 @endisset
                             </select>
                         </div>
                         <div class="col-sm-2">
                             <img src="{{ url('') }}/{{ isset($stedit)?$stedit->getStyleName['style_group_icon']:'UNeck.jpg' }}" alt="neckline" id="necklineImg" style="width:40px;height:50px;" >
                         </div>
                            <input type="hidden" name="pid" value="{{ isset($pid)?$pid:'' }}">
                         <div class="col-sm-4">
                            <label>Neck Body Image</label>
                             <input type="file" name="neckimage" class="form-control">
                         </div>
                             <div class="col-sm-1  text-right">
                              @php $img=isset($stedit)?json_decode($stedit->image,true):''  @endphp
                             <img src="{{ url('') }}/{{$img!=""?$img['image']:'V.jpg'}}" style="height:100px;width:50px;">
                         </div>
                         <div class="col-sm-2 text-right">
                             <button class="btn btn-success btn-sm">Upload</button>
                         </div>
                
                    </div>
                    </form>
                    <br><hr>
                      <!-- upload image for neckline -->
                    <form  method="POST" enctype="multipart/form-data" id="addsleeve" style="display:{{$sleev }}">
                        @csrf
                    <div class="row">
                          <div class="col-sm-12">
                            <h6>sleeve type style customization</h6>
                        </div>
                         <input type="hidden" name="pid" value="{{ isset($pid)?$pid:'' }}">
                         <input type="hidden" name="clrid" value="{{ session()->has('clrid')?session('clrid'):'' }}">
                          <input type="hidden" name="rid" value="{{ isset($stedit->id)?$stedit->id:'' }}">
                        <div class="col-sm-4">
                             <label>Sleeve Type</label>
                             <select class="form-control sleevstyle text-capitalize" name="style_id" required="">
 <option value="{{ isset($stedit)?$stedit->product_style_customization_id :'' }}" selected="">{{ isset($stedit)?$stedit->getStyleName['style_group_name']:'Select sleeve style' }}</option>
                                 @isset($sleeve)
                                  @foreach($sleeve as $item)
                                    <option value="{{ $item->id }}">{{ $item->style_group_name }}</option>
                                  @endforeach
                                 @endisset 
                             </select>
                         </div>
                         <div class="col-sm-2">
                            <img src="{{ url('') }}/{{ isset($stedit)?$stedit->getStyleName['style_group_icon']:'5.png' }}" alt="sleeve" id="sleeveImg" style="width:40px;height:50px;" >
        
                         </div>
                         <div class="col-sm-4 ">
                             <label>Right Hand Image</label>
                             <input type="file" name="rhand" class="form-control">
                         </div>
                          <div class="col-sm-2  text-right">
                              @php $img=isset($stedit)?json_decode($stedit->image,true):''  @endphp
                             <img src="{{ url('') }}/{{$img!=""?$img['rhand']:'right-hand.jpg'}}" style="height:100px;width:70px;">
                             
                         </div>
                          <div class="col-sm-3">
                             <label>Left Hand Image</label>
                             <input type="file" name="lhand" class="form-control">
                         </div>
                           <div class="col-sm-2  text-right">
                            <img src="{{ url('') }}/{{$img!=""?$img['lhand']:'left-hand.jpg'}}" style="height:100px;width:70px;">
                      
                         </div>
                         <div class="col-sm-4 text-right">
                             <button class="btn btn-success btn-sm">Upload</button>
                         </div>
                         </div>
                    </form>
                     <br><hr>
                    <!-- upload image for LENGTH -->
                    <form id="addlength" method="POST" enctype="multipart/form-data" style="display:{{$leng }}">
                        @csrf
                    <div class="row">
                         <div class="col-sm-12">
                            <h6>length style customization</h6>
                        </div>
                        <div class="col-sm-3">
                         <input type="hidden" name="pid" value="{{ isset($pid)?$pid:'' }}">
                         <input type="hidden" name="clrid" value="{{ session()->has('clrid')?session('clrid'):'' }}">
                         <input type="hidden" name="rid" value="{{ isset($stedit->id)?$stedit->id:'' }}">
                             <label>length style</label>
                             <select class="form-control lenstyle text-capitalize" name="style_id" required="">
              <option value="{{ isset($stedit)?$stedit->product_style_customization_id:'' }}" selected="">{{ isset($stedit)?$stedit->getStyleName['style_group_name']:'Select length style' }}</option>
                                 @isset($length)
                                  @foreach($length as $item)
                                    <option value="{{ $item->id }}">{{ $item->style_group_name }}</option>
                                  @endforeach
                                 @endisset
                             </select>
                         </div>
                         <div class="col-sm-2">
                            <img src="{{ url('') }}/{{ isset($stedit)?$stedit->getStyleName['style_group_icon']:'6.png' }}" alt="length" id="lengthImg" style="width:40px;height:50px;" >
                         </div>
                         <div class="col-sm-4">
                             <label>length style Image</label>
                             <input type="file" name="length" class="form-control">
                         </div>
                             <div class="col-sm-1  text-right">
                                @php $img=isset($stedit)?json_decode($stedit->image,true):''  @endphp
                             <img src="{{ url('') }}/{{ $img!=""?$img['image']:'bottom.jpg'}}" style="height:100px;width:70px;">
                         </div>
                         <div class="col-sm-2 text-right">
                             <button class="btn btn-success btn-sm">Upload</button>
                         </div>                
                    </div>
                    </form>
                  </div>
                </div>
              </div>
           @if(!session()->has("addVariantStyle"))
             <div class="card">
                <div class="card-header pvarient" id="heading4">
                  <h5 class="mb-0">
                    <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapse4" aria-expanded="false" aria-controls="collapse4" type="button">
                      Product Available Size
                    </button>
                  </h5>
                </div>
                <div id="collapse4" class="collapse" aria-labelledby="heading4" data-parent="#accordion">
                  <div class="card-body">
                <form method="post"  id="StandardSize">
                    @csrf
                    <div class="row">
                  <!--   <div class="col-sm-12"><h6>Custom Size</h6></div> 
                               @isset($custom)
                                  @foreach($custom as $item)
                                    <div class="form-group col-sm-3">
                                       <label>{{ $item->varient_name }}</label>
                                       <select class="form-control select2" style="width:100%;" multiple="">
                                          @isset($item->getValue)
                                            @foreach($item->getValue as $item2)
                                            <option>{{ $item2['varient_value'] }}</option>

                                             @endforeach
                                          @endisset
                                       </select>
                                    </div>
                                  @endforeach
                                 @endisset -->
                
                    <div class="col-sm-12"><h6>Standard Size</h6></div> 
                      <input type="hidden" name="pid" value="{{ isset($pid)?$pid:'' }}">
                         <input type="hidden" name="clrid" value="{{ session()->has('clrid')?session('clrid'):'' }}">
                             @isset($standard)
                               <div class="form-group col-sm-6">
                                <label>Size</label>
                                <select class="form-control stdSize select2" name="size[]" required="" multiple="" style="width:100%;">
    
                                  @foreach($standard as $item)
                                   <option >{{ $item['varient_name'] }}</option>
                                   @endforeach
                                  </select>
                                  </div>
                                 @endisset
                                   <!--<div class="form-group col-sm-4" >                                     
                                      <label>Size Value</label>
                                         <select class="form-control select2" style="width:100%;" multiple="" name="StdValue[]" required="" id="stdValue">
                                            <option value="">Select Size Value</option>
                                       </select>
                                    </div>-->
                                   <!-- <div class="form-group col-sm-4">
                                            <label>Price</label>
                                          <select class="form-control pvaiant" name="height">
                                           <option value="pi">price included</option>
                                           <option value="pv">price may vary</option>
                                         </select>
                                        </div>
                                     <div class="form-group col-sm-4 pp">
                                        <label>Product Price</label>
                                     <input type="number" name="pv" class="form-control">
                                    </div>   -->
                       <div class="form-group col-sm-6 pt-4">
                       <button class="btn btn-success btn-sm">Save </button>
                      </div>
                      </div>
                   </form>
                  </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header pvarient" id="heading5">
                  <h5 class="mb-0">
                    <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapse5" aria-expanded="false" aria-controls="collapse5" type="button">
                      Product Available Height
                    </button>
                  </h5>
                </div>
                <div id="collapse5" class="collapse" aria-labelledby="heading5" data-parent="#accordion">
                  <div class="card-body">
                    <form method="post" enctype="multipart/form-data" id="setHeight" >
                        @csrf
                        <div class="row">
                         <div class="col-sm-12"><h6>Available Height</h6></div> 
                           <input type="hidden" name="pid" value="{{ isset($pid)?$pid:'' }}">
                         <input type="hidden" name="clrid" value="{{ session()->has('clrid')?session('clrid'):'' }}">
                            <div class="form-group col-sm-7">
                             <label>Height</label>
                              <select class="form-control select2 height" name="heigh[]" style="width:100%" multiple="">
                                @for($i=4;$i<7;$i++)
                                 @for($j=0;$j<12;$j++)
                                   <option>{{ $i.'.'.$j }}</option>
                                     @endfor
                                      @endfor
                                      </select>
                                      </div>
                                        <!-- <div class="form-group col-sm-4">
                                            <label>Price</label>
                                          <select class="form-control pvaiant" name="height">
                                           <option value="pi">price included</option>
                                           <option value="pv">price may vary</option>
                                         </select>
                                        </div>
                                         <div class="form-group col-sm-4 pp">
                                            <label>Product Price</label>
                                         <input type="number" name="pv" class="form-control">
                                        </div>-->
                                            <div class="form-group col-sm-5 pt-4">
                                        <button class="btn btn-success btn-sm">Save </button>
                                    </div>
                                   </div>
                              </form>
                              </div>
                            </div>
                          </div>
             <div class="card">
                <div class="card-header pvarient" id="heading6">
                  <h5 class="mb-0">
                    <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapse6" aria-expanded="false" aria-controls="collapse6" type="button">
                    Matching Product
                    </button>
                  </h5>
                </div>
                <div id="collapse6" class="collapse" aria-labelledby="heading6" data-parent="#accordion">
                  <div class="card-body">
                    <form method="post"  action="{{ url('admin/add-matching-product') }}">
                        @csrf
                        <div class="row">
                         <div class="col-sm-12"><h6>Product related to color</h6></div> 
                          <input type="hidden" name="pid" value="{{ isset($pid)?$pid:'' }}">
                         <input type="hidden" name="clrid" value="{{ session()->has('clrid')?session('clrid'):'' }}">
                            <div class="form-group col-sm-4">
                            <label>Product</label>
                              <select class="form-control select2" name="mp[]" style="width:100%" multiple="">
                                @if(session()->has('product'))
                                 @foreach(session('product') as $p)
                                   <option value="{{ $p->id }}">{{ $p->pname }}</option>
                                     @endforeach  
                                      @endif                         
                                     </select>
                                      </div>
                                            <div class="form-group col-sm-6">
                                        <button class="btn btn-success btn-sm">Save </button>
                                    </div>
                                   </div>
                              </form>
                              </div>
                            </div>
                          </div>
                           @endif
                        </div>
        </div>
      </div>
    @push('ajax-script')
    <script type="text/javascript">
      $(document).ready(function() {
        $(document).on('change', '.neckstyle', function(event) {
         let id=$(this).val();
        $.get('{{ url('admin/get-style-image') }}/'+id, function(data) {
           $("#necklineImg").attr('src', '{{ url("") }}/'+data.img.style_group_icon);
        });
        });

        $(document).on('change', '.sleevstyle', function(event) {
         let id=$(this).val();
        $.get('{{ url('admin/get-style-image') }}/'+id, function(data) {
           $("#sleeveImg").attr('src', '{{ url("") }}/'+data.img.style_group_icon);
        });
        });
        $(document).on('change', '.lenstyle', function(event) {
         let id=$(this).val();
        $.get('{{ url('admin/get-style-image') }}/'+id, function(data) {
           $("#lengthImg").attr('src', '{{ url("") }}/'+data.img.style_group_icon);
        });
        });
    });
</script>
<script type="text/javascript">
    $(document).ready(function() {
        $(".pp").hide();
        $(document).on('change', '.pvaiant', function(event) {
         if($(this).val()=='pv'){
            $(".pp").show();
         }else{
             $(".pp").hide();
         }
        });
    });
</script>
<script type="text/javascript">
        $(document).on('submit', '#addneckstyle', function(event) {
            event.preventDefault();
            let galid=$(".galimg:checked").val();
            $.ajax({
                url: '{{ url('admin/set-custom-style') }}{{  session()->has("galid")?"/".session('galid'):'' }}/'+galid,
                type: 'POST',
                data:new FormData(this) ,
                contentType:false,
                processData:false,
                success:function(data){
                    swal.fire('success',"NeckLine data saved!");
                  $('#addneckstyle')[0].reset();  
                }
            })
       
       });
</script>
<script type="text/javascript">
        $(document).on('submit', '#addsleeve', function(event) {
            event.preventDefault();
            let galid=$(".galimg:checked").val();
            $.ajax({
                url: '{{ url('admin/set-custom-style') }}{{  session()->has("galid")?"/".session('galid'):'' }}/'+galid,
                type: 'POST',
                data:new FormData(this) ,
                contentType:false,
                processData:false,
                success:function(data){
                    swal.fire('Saved',"sleeve style data saved!");
                  $('#addsleeve')[0].reset();  
                }
            })
         });
</script>
<script type="text/javascript">
        $(document).on('submit', '#addlength', function(event) {
            event.preventDefault();
            let galid=$(".galimg:checked").val();
            $.ajax({
                url: '{{ url('admin/set-custom-style') }}{{  session()->has("galid")?"/".session('galid'):'' }}/'+galid,
                type: 'POST',
                data:new FormData(this) ,
                contentType:false,
                processData:false,
                success:function(data){
                    swal.fire('Saved',"length style data saved!");
                  $('#addlength')[0].reset();  
                }
            });
         });
</script>
<script type="text/javascript">
    $(document).ready(function() {
        $(document).on('change', '.stdSize', function(event) {
            let id=$(this).val();
         $.get('{{url("admin/get-size-value") }}/'+id, function(data) {
            let opt="<option value=''>Select Size Value</option>";
            $.each(data.v, function(index, val) {
                opt +="<option>"+val.varient_value+"</option>"
            });
            $("#stdValue").html(opt);
         });
        });
    });
</script>
<script type="text/javascript">
        $(document).on('submit', '#StandardSize', function(event) {
            event.preventDefault();
              $.ajax({
                url: '{{ url('admin/set-standard_size') }}',
                type: 'POST',
                data:new FormData(this) ,
                contentType:false,
                processData:false,
                success:function(data){
                    swal.fire('Saved',"standard size data saved!");
                  $('#StandardSize')[0].reset();  
                 
                }
            });
        });
</script>
<script type="text/javascript">
        $(document).on('submit', '#setHeight', function(event) {
            event.preventDefault();
              $.ajax({
                url: '{{ url('admin/set-available-height') }}',
                type: 'POST',
                data:new FormData(this) ,
                contentType:false,
                processData:false,
                success:function(data){
                    swal.fire('Saved',"standard size data saved!");
                  $('#setHeight')[0].reset();  
                 
                }
            });
        });
</script>
@endpush
@endsection
