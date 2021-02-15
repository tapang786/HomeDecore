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
            <div class="col-sm-6 text-right pr-1">
              {{-- <a class="btn btn-sm btn-primary" href="{{ url('admin/reset-session') }}">Add New Variant</a> --}}
              <a class="btn btn-sm btn-primary" href="{{ url('admin/return-back/') }}">RETURN BACK <i class="fas fa-arrow-right"></i></a>
            </div>
        </div>
    </div>
    <div class="card-body">
      <form method="post" id="create_variantions" action="{{ route("admin.create-varient") }}">
        @csrf
        <input type="hidden" name="pid" value="{{ isset($pid)?$pid:'' }}">
        <div id="accordion" class="variants_values">
          {{-- Color  --}}
{{--           <div class="card">
            <div class="card-header pvarient" id="heading6">
              <h5 class="mb-0">
                <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne" type="button">Color</button>
              </h5>
            </div>
            <div id="collapseOne" class="collapse" aria-labelledby="heading6" data-parent="#accordion">
              <div class="card-body">
                  <div class="row">
                    <div class="col-sm-12">
                      <h6>Select color</h6>
                    </div> 
                    <div class="form-group col-sm-4">
                      <select class="form-control select2" id="color_variant" name="color[]" style="width:100%" multiple="">
                        @isset($color)
                          @foreach($color as $clr)
                            <option value="{{ $clr->id }}">{{ $clr->value }}</option>
                          @endforeach
                        @endisset                         
                      </select>
                    </div>
                    <div class="form-group col-sm-6">
                    </div>
                  </div>
              </div>
            </div>
          </div> --}}

          {{-- Size --}}
          {{-- <div class="card">
            <div class="card-header pvarient" id="heading6">
              <h5 class="mb-0">
                <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapse2" aria-expanded="false" aria-controls="collapse2" type="button">Size</button>
              </h5>
            </div>
            <div id="collapse2" class="collapse" aria-labelledby="heading6" data-parent="#accordion">
              <div class="card-body">
                  <div class="row">
                    <div class="col-sm-12">
                      <h6>Select size</h6>
                    </div> 
                    <div class="form-group col-sm-4">
                      <select class="form-control select2" id="size_variant" name="size[]" style="width:100%" multiple="">
                        @isset($size)
                          @foreach($size as $k => $clr)
                            <option value="{{ $clr->id }}">{{ $clr->value }}</option>
                          @endforeach
                        @endisset                         
                      </select>
                    </div>
                    <div class="form-group col-sm-6">
                    </div>
                  </div>
              </div>
            </div>
          </div> --}}

          <?php //print_r($attributes); ?>
        @foreach($attributes as $k => $attribute)
          {{-- Size --}}
          @isset($attribute['terms'])
          @php $terms = $attribute['terms']; @endphp
          <div class="card">
            <div class="card-header pvarient" id="heading6">
              <h5 class="mb-0">
                <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapse{{ $k }}" aria-expanded="false" aria-controls="collapse{{ $k }}" type="button">{{ $attribute['name'] }}</button>
              </h5>
            </div>
            <div id="collapse{{ $k }}" class="collapse" aria-labelledby="heading6" data-parent="#accordion">
              <div class="card-body">
                  <div class="row">
                    <div class="col-sm-12">
                      <h6>Select {{ $attribute['name'] }}</h6>
                    </div> 
                    <div class="form-group col-sm-4">
                      <select class="form-control select2" id="{{ $attribute['slug'] }}_variant" name="{{ $attribute['slug'] }}[]" style="width:100%" multiple="">
                        @isset($terms)
                          @foreach($terms as $k => $clr)
                            <option value="{{ $clr->id }}">{{ $clr->value }}</option>
                          @endforeach
                        @endisset                         
                      </select>
                      <input type="hidden" name="attributes[]" value="{{ $attribute['slug'] }}">
                    </div>
                    <div class="form-group col-sm-6">
                    </div>
                  </div>
              </div>
            </div>
          </div>
          @endisset
        @endforeach
        <div class="card">
          <div class="form-group col-sm-3">
            <button class="btn btn-success btn-sm p-2" type="submit" id="make_variantions">Make Variantions</button>
          </div>
        </div>
      </div>
    </form>

    
    <div id="accordion" class="show_variantions" style="display: none;">
      <form method="post" id="save_variantions" enctype="multipart/form-data" action="{{ route("admin.save-varients") }}">
      @csrf
      <input type="hidden" name="pid" value="{{ isset($pid)?$pid:'' }}">
        <div class="card">
          <div class="form-group col-sm-12">
            <table class="table table-hover">
              <thead>
                <tr>
                  <th>#ID</th>
                  <th>Product ID</th>
                  <th>Color</th>
                  <th>Size</th>
                  <th>SKU</th>
                  <th>Price</th>
                  <th>Stock</th>
                  <th>Image</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody class="variantions_combinations">
                
              </tbody>
            </table>
          </div>
        </div>
        <div class="card">
          <div class="form-group col-sm-3">
            <button type="submit" class="btn btn-success btn-sm p-2">Save Variantions</button>
          </div>
        </div>
      </form>
    </div>

    <div id="accordion" class="old_variants_values">
      <div class="card">
        <table class="table table-bordered " >
          <thead>
            <tr style="background-color:black;color:white;">
              <th>#ID</th>
              <th>Product ID</th>
              <th>Color</th>
              <th>Size</th>
              <th>SKU</th>
              <th>Price</th>
              <th>Stock</th>
              <th>Image</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
          @isset($variants_values)
            @php $i = 1; @endphp
            @foreach($variants_values as $pv)
             <tr id="{{ $pv['id'] }}">
             <td> {{$i}} </td>
             <td> {{ $pv['p_id'] }} </td>
             <td> {{$pv['Color']}} </td>
             <td> {{$pv['Size']}} </td>
             <td> {{ $pv['product']->sku_id }} </td>
             <td> <span class="static_value">{{$pv['product']->s_price}} </span> <input type="text" value="{{$pv['product']->s_price}}" name="s_price" class="edit_value"> </td>
             <td> <span class="static_value">{{$pv['product']->stock}} </span> <input type="text" value="{{$pv['product']->stock}}" name="stock" class="edit_value"> </td>
             <td> 
                @php $img = 1; @endphp
                @foreach(json_decode($pv['product']->thumbnails,true) as $thumb)
                  @if($img == 1)
                    <img src="{{ url('product/thumbnail') }}/{{ $thumb }}" class="img-fluid" style="height:120px;">

                  @else
                    <img src="{{ url('product/thumbnail') }}/{{ $thumb }}" class="img-fluid" style="height:120px;">
                  @endif  
                  @php $img++; @endphp
                @endforeach
             </td>
             <td>
                <button class="btn btn-danger btn-sm removeVariant"  v-id="{{ $pv['id'] }}"><i class="far fa-trash-alt"></i></button>
                <button class="btn btn-success btn-sm editVariant" v-id="{{ $pv['id'] }}"><i class="far fa-edit"></i></button>
                <button class="btn btn-success btn-sm saveVariant" v-id="{{ $pv['id'] }}"><i class="fas fa-check"></i></button>
             </td>
           </tr>
              @php $i++; @endphp
            @endforeach
          @endisset                            
         </tbody>
        </table>
      </div>
    </div>
    
</div>


@push('ajax-script')
<style type="text/css">
  .edit_value, .saveVariant {
    display: none;
  }
</style>
<script type="text/javascript">
    $(document).ready(function() {
      /*$(document).on("click", "#make_variantions", function(e){
        e.preventDefault();
        //return false;
        var error = false;
        if($('#color_variant').val() == '') {
          error = true;
        }
        if($('#size_variant').val() == '') {
          error = true;
        }
        if(error) {
          alert('Variantions value required.');
          return false;
        }
        let myForm = document.getElementById('create_variantions');
        let formData = new FormData(myForm);
        $.ajax({
          url: '{{ url('admin/create-varient') }}/',
          type: 'get',
          data: formData,
          contentType:false,
          processData:false,
          success:function(response) {
            console.log(response);
            $('.variants_values').hide();
            $('.old_variants_values').hide();
            $('.show_variantions').show();
            $('.variantions_combinations').html(response.html);
          }
        });
      });*/

      $('form#create_variantions').on('submit',function(e){
        e.preventDefault();
        alert('sdf');
        /*var error = false;
        if($('#color_variant').val() == '') {
          error = true;
        }
        if($('#size_variant').val() == '') {
          error = true;
        }
        if(error) {
          alert('Variantions value required.');
          return false;
        }*/

        var formData = new FormData($(this)[0]);
        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: formData,
            datatype: 'JOSN',
            processData: false,
            contentType: false,
            success: function (response) {
              $('.variants_values').hide();
              $('.old_variants_values').hide();
              $('.show_variantions').show();
              $('.variantions_combinations').html(response.html);
            },
            error: function (response) {
            }
        });
      });

      $(document).on('click', '.editVariant', function(e){
        e.preventDefault();
        $('tr#'+$(this).attr('v-id')+' .edit_value').show();
        $('tr#'+$(this).attr('v-id')+' .saveVariant').show();
        $('tr#'+$(this).attr('v-id')+' .static_value').hide();
        $(this).hide();
      });

      $(document).on('click', '.delete_variant', function(e){
        e.preventDefault();
        $('#variant_row_'+$(this).attr('data-row')).remove();
      });

        $(document).on("click",".removeVariant", function(e) {

        var vid = $(this).attr('v-id');
        const swalWithBootstrapButtons = Swal.mixin({
          customClass: {
            confirmButton: 'btn btn-success',
            cancelButton: 'btn btn-danger'
          },
          buttonsStyling: false
        });

        swalWithBootstrapButtons.fire({
          title: 'Are you sure?',
          text: "You won't be able to revert this item!",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonText: 'Yes, delete it!',
          cancelButtonText: 'No, cancel!',
          reverseButtons: true
        }).then((result) => {
          if (result.isConfirmed) {
            //
            $.ajax({
              url: "{{ url('admin/delete-variant') }}",
              type: 'POST',
              data:{ 
                id:vid,
                _token:'{{ csrf_token() }}'
              },
              success:function(data)
              { 
                swalWithBootstrapButtons.fire(
                        'Deleted!',
                        'Your file has been deleted.',
                        'success' )
                $("#"+vid).remove();
              }
            });

          } else if (result.dismiss === Swal.DismissReason.cancel ) {
            swalWithBootstrapButtons.fire(
              'Cancelled',
              'Your imaginary file is safe :)',
              'error'
            )
          }
        }); 
      });
    });
</script>


{{-- <script type="text/javascript">
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
</script> --}}
<style type="text/css">
  .select2-results__option {
    padding: 5px;
  }
</style>
@endpush
@endsection
