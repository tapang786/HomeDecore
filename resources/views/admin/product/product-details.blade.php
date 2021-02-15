@extends('layouts.admin')
@section('title',$title)
@section('content')
@push('style-content')
<link href="{{ asset('css/ecommerce.css') }}" rel="stylesheet" />
<link href="{{ asset('css/color_skins.css') }}" rel="stylesheet" />
<link href="{{ asset('css/main.css') }}" rel="stylesheet" />
@endpush
<!-- /Row -->
@php  session()->pull('add_style');  @endphp
  <div class="row text-capitalize">
    <div class="col-sm-6"><h4>product detail</h4></div>
    <div class="col-sm-6 text-right"><a href="javascript:void(0)" class=" p-2 rounded">Product / Product Detail</a></div>
    </div>
 <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-lg-12">
                <div class="card">
                    <div class="body">
                        <div class="row">
                            <div class="preview col-lg-4 col-md-12">
                               @include('admin.product.product-details-thumbnail')              
                            </div>
                            <div class="details col-lg-8 col-md-12">
                                <h3 class="product-title m-b-0 text-capitalize">{{ $product['pname'] }}   <a class="btn btn-sm btn-primary" href="{{ url('admin/return-back/') }}">RETURN BACK <i class="fas fa-arrow-right"></i></a></h3>
                                <h4 class="price m-t-0">Current Price: <span class="col-amber">{{ $product['s_price'] }}</span></h4>
                                <div class="rating">
                                    <div class="stars">
                                        <span class="zmdi zmdi-star col-amber"></span>
                                        <span class="zmdi zmdi-star col-amber"></span>
                                        <span class="zmdi zmdi-star col-amber"></span>
                                        <span class="zmdi zmdi-star col-amber"></span>
                                        <span class="zmdi zmdi-star-outline"></span>
                                    </div>
                                    <span class="m-l-10">41 reviews</span>
                                </div>
                                <hr>
                                <p class="product-description">{{ $product['p_s_description'] }}</p>
                                <p class="vote"><strong>78%</strong> of buyers enjoyed this product! <strong>(23 votes)</strong></p>
                                {{-- <h5 class="sizes">sizes:
                                  @isset($variants)
                                  @foreach($pVariant as $pv)
                                     @if(true)
                                      {{ str_replace('"',"",$pv['product_size']) }}
                                         @break
                                      @endif
                                    @endforeach
                                  @endisset
                                </h5>
                                 <h5 class="sizes">height:
                                  @isset($pVariant)
                                  @foreach($pVariant as $pv)
                                     @if(true)
                                      {{ str_replace('"',"",$pv['height']) }}
                                         @break
                                      @endif
                                    @endforeach
                                  @endisset
                                </h5>
                                <h5 class="colors">colors:
                                     @isset($pVariant)
                                      @foreach($pVariant as $pv)
                                      <a href="javascript:void(0)">
                                        @if($pv->colorName['color_code']!="")
                                      <span class="color bg-green" style="background-color:{{ $pv->colorName['color_code'] }};width:30px;height:30px;margin-left:0px !important"></span>
                                      @else
                                     <img src="{{ url('') }}/{{ $pv->colorName['color_image'] }}" style="height:30px;width:30px;">
                                      @endif
                                    </a>
                                        @endforeach
                                      @endisset
                                </h5> --}}
                                @isset($variants)
                                  @foreach($variants as $vk => $vvl)
                                    <h5 class="{{$vk}}">{{$vk}}</h5>
                                      <select id="{{$vk}}" class="variants">
                                        <option value="0">Select Variant</option>
                                        @foreach($vvl as $vl)
                                          <option value="{{$vl}}">{{$vl}}</option>
                                        @endforeach
                                      </select>
                                  @endforeach
                                @endisset
                                <hr>
                                @isset($variants_values)

                                  <script type="text/javascript">
                                    var variants = @php echo json_encode($variants_values); @endphp;
                                  </script>

                                  <input type="hidden" name="id" id="datavariants" data-color="" data-size="">

                                @endisset
                                <div class="action" style="margin-bottom: 23px;">
                                    <button class="btn btn-primary btn-round waves-effect" type="button">add to cart</button>
                                    <button class="btn btn-primary btn-icon btn-icon-mini btn-round waves-effect" type="button"><i class="far fa-heart"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="card">
                    <ul class="nav nav-tabs" >
                        <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#description">Description</a></li>
                         <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#varientProd">Varient Products</a></li>
                          <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#neckStyle">Neck Style</a></li>
                            <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#sleeveStyle">Sleeve Style</a></li>
                                <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#lengthStyle">Length Style</a></li>
                                <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#fabricType">Fabric Type</a></li>
                                 <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#matchedProduct">Matched Product</a></li>    
                    </ul>
                </div>
                <div class="card">
                    <div class="body">                        
                        <div class="tab-content">
                            <div class="tab-pane active p-3" id="description">
                            {!! $product->p_description !!}
                            </div>
                            <div class="tab-pane p-3" id="varientProd">
                            
                            </div>
                            <div class="tab-pane p-3" id="neckStyle">
                              <table class="table table-bordered " >
                               <thead>
                                <tr style="background-color:black;color:white;">
                                 <th>Style Applied Image</th>
                                  <th>Style Variant Name</th>
                                 <th>Style Image</th>
                                  <th>Style Variant Image</th>
                                 <th>Action</th>
                               </tr>
                             </thead>
                             <tbody>
                              @isset($neck)
                              @php $i=0; @endphp
                                @foreach($neck as $pv)
                                 <tr id="{{ isset($pv[$i]->getAppliedStyleGalImage['id'])?$pv[$i]->getAppliedStyleGalImage['id']:"" }}">
                                 <td>
                                  {{ isset($pv[$i]->getAppliedStyleGalImage['id'])?$pv[$i]->getAppliedStyleGalImage['id']:"" }}
                                  <img src="{{ url('product/product-gallary') }}/{{ isset($pv[$i]->getAppliedStyleGalImage['image'])?$pv[$i]->getAppliedStyleGalImage['image']:"" }}" style="height:150px;width:100px;">
                                 </td>
                                  <td colspan="3">
                                  <table class="table"> 
                                    @isset($pv)
                                     @foreach($pv as $pimage)
                                      <tr id="{{ $pimage->id }}">
                                      <td>{{$pimage->getStyleName['style_group_name'] }}</td>
                                      <td><img src="{{ url('') }}/{{ $pimage->getStyleName['style_group_icon'] }}" style="height:50px;width:50px;"></td>
                                      <td>
                                        @php
                                           $img=json_decode($pimage->image,true);
                                         @endphp
                                        <img src="{{ url('') }}/{{ $img['image'] }}" style="height:100px;width:50px;"> 
                                      </td>
                                      <td>
                                         <a href="{{ url('admin/editVariant'.'/'.$pimage->id) }}/neck" class="btn-success btn-xs "><i class="fa fa-edit"></i></a>
                                        <button class="btn-danger btn-xs removeStyle"><i class="fa fa-trash"></i></button>
                                      </td>
                                    </tr>
                                     @endforeach
                                    @endisset
                                  </table>
                                  </td>
                                     <td> <button class="btn-danger btn-xs removeWholeSetVariant" id="neck_style"><i class="fa fa-trash"></i></button>
                                      <a href="javascript:void" class="btn-success btn-xs" onclick="addVariant({{ isset($pv[$i]->getAppliedStyleGalImage['id'])?$pv[$i]->getAppliedStyleGalImage['id']:"" }},'neck')"><i class="far fa-plus-square"></i> Variant</a></td>                      
                               </tr>
                               @php $i++ @endphp
                                @endforeach
                              @endisset
                             </tbody>
                             </table>
                            </div>
                             <div class="tab-pane p-3" id="sleeveStyle">
                              <table class="table table-bordered " >
                               <thead>
                                <tr style="background-color:black;color:white;">
                                 <th>Style Applied Image</th>
                                  <th>Style Variant Name</th>
                                  <th>Style Image</th>
                                  <th>Style Variant Image</th>
                                 <th>Action</th>
                               </tr>
                             </thead>
                             <tbody>
                              @isset($sleeve)
                               @php $i=0; @endphp
                                @foreach($sleeve as $pv)
                                 <tr id="{{ isset($pv[$i]->getAppliedStyleGalImage['id'])?$pv[$i]->getAppliedStyleGalImage['id']:"" }}">
                                 <td>
                                  <img src="{{ url('product/product-gallary') }}/{{ isset($pv[$i]->getAppliedStyleGalImage['image'])?$pv[$i]->getAppliedStyleGalImage['image']:"" }}" style="height:150px;width:100px;">
                                 </td>
                                  <td colspan="3">
                                  <table class="table"> 
                                    @isset($pv)
                                     @foreach($pv as $pimage)
                                      <tr id="{{ $pimage->id }}">
                                      <td>{{$pimage->getStyleName['style_group_name'] }}</td>
                                      <td><img src="{{ url('') }}/{{ $pimage->getStyleName['style_group_icon'] }}" style="height:50px;width:50px;"></td>
                                      <td>
                                        @php
                                           $img=json_decode($pimage->image,true);
                                         @endphp
                                        <img src="{{ url('') }}/{{ $img['lhand'] }}" style="height:100px;width:50px;"> &nbsp;&nbsp;
                                         <img src="{{ url('') }}/{{ $img['rhand'] }}" style="height:100px;width:50px;"> 
                                      </td>
                                      <td>
                                         <a href="{{ url('admin/editVariant'.'/'.$pimage->id) }}/sleeve" class="btn-success btn-xs "><i class="fa fa-edit"></i></a>
                                        <button class="btn-danger btn-xs removeStyle"><i class="fa fa-trash"></i></button>
                                      </td>
                                    </tr>
                                     @endforeach
                                    @endisset
                                  </table>
                                  </td>
                                 <td> <button class="btn-danger btn-xs removeWholeSetVariant" id="sleeve_style"><i class="fa fa-trash"></i></button>
                                 <button class="btn-success btn-xs" onclick="addVariant({{ isset($pv[$i]->getAppliedStyleGalImage['id'])?$pv[$i]->getAppliedStyleGalImage['id']:"" }},'sleeve')"><i class="far fa-plus-square"></i> Variant</button></td>                      
                               </tr>
                               @php $i++ @endphp
                                @endforeach
                              @endisset
                             </tbody>
                             </table>
                            </div>
                            <div class="tab-pane p-3" id="lengthStyle">
                              <table class="table table-bordered " >
                               <thead>
                                <tr style="background-color:black;color:white;">
                                 <th>Style Applied Image</th>
                                  <th>Style Variant Name</th>
                                  <th>Style Image</th>
                                  <th>Style Variant Image</th>
                                 <th>Action</th>
                               </tr>
                             </thead>
                             <tbody>
                              @isset($length)
                               @php $i=0; @endphp
                                @foreach($length as $pv)
                                 <tr id="{{ isset($pv[$i]->getAppliedStyleGalImage['id'])?$pv[$i]->getAppliedStyleGalImage['id']:"" }}">
                                 <td>
                                  <img src="{{ url('product/product-gallary') }}/{{ isset($pv[$i]->getAppliedStyleGalImage['image'])?$pv[$i]->getAppliedStyleGalImage['image']:"" }}" style="height:150px;width:100px;">
                                 </td>
                                  <td colspan="3">
                                  <table class="table"> 
                                    @isset($pv)
                                     @foreach($pv as $pimage)
                                      <tr id="{{ $pimage->id }}">
                                      <td>{{$pimage->getStyleName['style_group_name'] }}</td>
                                      <td><img src="{{ url('') }}/{{ $pimage->getStyleName['style_group_icon'] }}" style="height:50px;width:50px;"></td>
                                      <td>
                                        @php
                                           $img=json_decode($pimage->image,true);
                                         @endphp
                                        <img src="{{ url('') }}/{{ $img['image'] }}" style="height:100px;width:80px;"> &nbsp;&nbsp;
                                       
                                      </td>
                                      <td>
                                        <a href="{{ url('admin/editVariant'.'/'.$pimage->id) }}/length" class="btn-success btn-xs "><i class="fa fa-edit"></i></a>
                                        <button class="btn-danger btn-xs removeStyle"><i class="fa fa-trash"></i></button>
                                      </td>
                                    </tr>
                                     @endforeach
                                    @endisset
                                  </table>
                                  </td>
                                     <td><button class="btn-danger btn-xs removeWholeSetVariant" id="length_style"><i class="fa fa-trash"></i></button>
                                      <button class="btn-success btn-xs" onclick="addVariant({{ isset($pv[$i]->getAppliedStyleGalImage['id'])?$pv[$i]->getAppliedStyleGalImage['id']:"" }},'length')"><i class="far fa-plus-square"></i> Variant</button></td>                      
                               </tr>
                               @php $i++; @endphp
                                @endforeach
                              @endisset
                              
                             </tbody>
                             </table>
                            </div>
                            <div class="tab-pane p-3" id="fabricType">
                              <table class="table table-bordered " >
                               <thead>
                                <tr style="background-color:black;color:white;">
                                 <th>Images</th>
                                  <th>Applied Fabrics</th>
                                 <th>Action</th>
                               </tr>
                             </thead>
                             <tbody>
                              @isset($pVariant)
                                @foreach($pVariant as $pv)
                                 <tr id="{{ $pv['id'] }}">
                                 <td >
                                  @isset($pv->getGallaryImage)
                                      @foreach ($pv->getGallaryImage as $gal)
                                          <img src="{{ url('product/product-gallary').'/'.$gal->image }}" style="height:70px;width:70px;">
                                      @endforeach
                                  @endisset
                                 </td>
                                  <td >
                                    {{ $pv->fabric_type }}
                                  </td>
                                     <td>
                                      <a class="btn-success btn-xs" href="{{ url('admin/edit-product-fabric'.'/'.$pv['id']) }}"><i class="fa fa-edit"></i></a></td>                      
                               </tr>
                                @endforeach
                              @endisset
                              
                             </tbody>
                             </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
@push('ajax-script')

<script type="text/javascript">

  $(document).ready(function() {
    $('.variants#Color').on('change', function() {
      var nthis = $(this);
      var sizes = '<option value="0">Select Variant</option>';
      /*$.each(variants, function( index, value ) {
        if(value.Color == nthis.val()) {
          //console.log( value.Size );
          sizes += '<option value="'+value.Size+'">'+value.Size+'</option>';
        }
      });*/
      //$('#Size').html(sizes);
      $('#datavariants').attr('data-color', nthis.val());
      changeVariants();
    });


    $('.variants#Size').on('change', function() {
      var nthis = $(this);
      $('#datavariants').attr('data-size', nthis.val());
      changeVariants();
    });

  });

  function changeVariants() {
    // body...
    var color = $('#datavariants').attr('data-color');
    var size = $('#datavariants').attr('data-size');

    $.each(variants, function( index, value ) {
      if(value.Size == size && value.Color == color) {
        console.log( value.product.id );
        $('h4.price .col-amber').html(value.product.s_price);
      }
    });
  }
</script>
    <!-- Edit CAT -->
     <script type="text/javascript">

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

      $(".delp").click(function(event) {
        
        var id=$(this).parents('tr').attr('id');
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
              url: "{{ url('admin/product') }}/"+id,
              type: 'DELETE',
              data:{ 
                id:id,
                   _token:'{{ csrf_token() }}'
                        },
              success:function(data)
              { 
                swalWithBootstrapButtons.fire(
                        'Deleted!',
                        'Your file has been deleted.',
                        'success' )
                $("#"+id).remove() 
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
 </script>
    <script type="text/javascript">
      $(document).ready(function() {
        $(document).on('click', '.removeStyle', function(event) {
          let id=$(this).parents('tr').attr('id');
          const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
              confirmButton: 'btn btn-success',
              cancelButton: 'btn btn-danger'
            },
            buttonsStyling: false
          })
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
               $.ajax({
                url: "{{ url('admin/remove-variant') }}/"+id,
                type: 'DELETE',
                data:{ 
                  id:id,
                     _token:'{{ csrf_token() }}'
                          },
                success:function(data)
                { swalWithBootstrapButtons.fire(
                          'Deleted!',
                          'Your file has been deleted.',
                          'success' )
                $("#"+id).remove() 
                }
              })
            } else if (result.dismiss === Swal.DismissReason.cancel ) {
              swalWithBootstrapButtons.fire(
                'Cancelled',
                'Your imaginary file is safe :)',
                'error'
              )
            }
          })
        });
        // remove gallary image
           $(document).on('click', '.removeGallary', function(event) {
          let id=$(this).parents('tr').attr('id');
          const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
              confirmButton: 'btn btn-success',
              cancelButton: 'btn btn-danger'
            },
            buttonsStyling: false
          })
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
               $.ajax({
                url: "{{ url('admin/remove-product-gallary') }}/"+id,
                type: 'DELETE',
                data:{ 
                  id:id,
                     _token:'{{ csrf_token() }}'
                          },
                success:function(data)
                { swalWithBootstrapButtons.fire(
                          'Deleted!',
                          'Your file has been deleted.',
                          'success' )
                $("#"+id).remove() 
                }
              })
            } else if (result.dismiss === Swal.DismissReason.cancel ) {
              swalWithBootstrapButtons.fire(
                'Cancelled',
                'Your imaginary file is safe :)',
                'error'
              )
            }
          })
        });
      });
    </script>
     <script type="text/javascript">
      $(document).ready(function() {
        $(document).on('click', '.removeWholeSetVariant', function(event) {
          let id=$(this).parents('tr').attr('id');
          let style=$(this).attr('id');
          const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
              confirmButton: 'btn btn-success',
              cancelButton: 'btn btn-danger'
            },
            buttonsStyling: false
          })
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
               $.ajax({
                url: "{{ url('admin/remove-whole-set-variant') }}/"+id+"/"+style,
                type: 'DELETE',
                data:{ 
                  id:id,
                     _token:'{{ csrf_token() }}'
                          },
                success:function(data)
                { swalWithBootstrapButtons.fire(
                          'Deleted!',
                          'Your file has been deleted.',
                          'success' )
                $("#"+id).remove() 
                }
              })
            } else if (result.dismiss === Swal.DismissReason.cancel ) {
              swalWithBootstrapButtons.fire(
                'Cancelled',
                'Your imaginary file is safe :)',
                'error'
              )
            }
          })
        });
      });
    </script>
   
   <!-- for data search -->
    <script>
    $(document).ready(function(){
      $("#InputCat").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $(".c tr").filter(function() {
          $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
      });
    });
    </script> 
    <script type="text/javascript">
      function addVariant(galId,type){
         window.location.href="{{ url('admin/set-varient'.'/'.$product->id) }}/"+galId+'/'+type; 
      }
    </script> 
    <script type="text/javascript" src="{{ asset('js/libscripts.bundle.js') }}"></script>
     <script type="text/javascript" src="{{ asset('js/mainscripts.bundle.js') }}"></script>
      <script type="text/javascript" src="{{ asset('js/vendorscripts.bundle.js') }}"></script>
@endpush
@endsection
