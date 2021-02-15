@extends('layouts.admin')
@section('title',$title)
@section('content')
@push('style-content')
@endpush
<!-- /Row -->
@php  session()->pull('add_style');  @endphp
  <div class="row text-capitalize">
    <div class="col-sm-6"><h4>order detail</h4></div>
    <div class="col-sm-6 text-right"><a href="javascript:void(0)" class=" p-2 rounded">Order / Order Detail</a></div>
    </div>
 <div class="container-fluid">
  <div class="card">
  <div class="row">
<div class="col-sm-9 p-5">
<div class="row">
  <div class="col-sm-6 "><h6 class="panel-title txt-dark text-warning">Order number: #{{ $order->order_id }}</h6></div>
  <div class="col-sm-6 text-right"><h6 class="badge badge-success text-white p-1">{{ $order->status }}</h6></div>
</div>
<hr>
<div class="row">
  <div class="col-sm-3"><h6 class="panel-title txt-dark text-warning">Order Placed</h6>{{ \Carbon\Carbon::parse($order->order_date)->format('d-M-Y')  }}</div>
  <div class="col-sm-3 text-capitalize"><h6 class="panel-title txt-dark text-warning">Name</h6>{{ $order->shippingAddress['name'] }}</div>
  <div class="col-sm-3 "><h6 class="panel-title txt-dark text-warning">Email</h6>{{ $order->user['email'] }}</div>
  <div class="col-sm-3 text-center"><h6 class="panel-title txt-dark text-warning"> Contact</h6>{{ $order->shippingAddress['phone'] }}</div>
</div><br>
<div class="row">
  <div class="col-sm-6"><h6 class="panel-title txt-dark text-warning">Delivery Address</h6>{{ $order->shippingAddress['landmark']." ".$order->shippingAddress['address'].", ".$order->shippingAddress['country'].", ".$order->shippingAddress['state']." ".$order->shippingAddress['city'].", ".$order->shippingAddress['zip_code']." ".$order->shippingAddress['address_type'] }}<br>{{ $order->shippingAddress['phone'] }}</div>
  <div class="col-sm-6 text-capitalize"><h6 class="panel-title txt-dark text-warning">Billing Address</h6>{{ $order->shippingAddress['landmark']." ".$order->shippingAddress['address'].", ".$order->shippingAddress['country'].", ".$order->shippingAddress['state']." ".$order->shippingAddress['city'].", ".$order->shippingAddress['zip_code']." ".$order->shippingAddress['address_type'] }}<br>{{ $order->shippingAddress['phone'] }}</div>

</div><hr>
<div class="row">
  <div class="col-sm-6">
    <h6 class="panel-title txt-dark text-warning">Payment Info</h6>
        <p>
        Payment Mode : {{ isset($order->payment['payment_mode'])?$order->payment['payment_mode']:'' }}</p>
        <p> Payment Status : {{ isset($order->payment['payment_status'])?$order->payment['payment_status']:'' }}</p>
        <p> Amount To Receipt : {{ isset($order->payment['amount_receipt'])?$order->payment['amount_receipt']:'' }}</p>
  </div>
  <div class="col-sm-6 text-capitalize">
   <div class="row">
    <div class="col-sm-6">
      <h6 class="panel-title text-dark text-warning">Invoice Details</h6>
      </div>
     <div class="col-sm-6 text-right"><a class="badge badge-success p-2" href="{{ route('admin.generate-pdf',['download'=>'pdf','id'=>$order->id])}}"><i class="fa fa-download"></i> Invoice</a></div>
   </div><br>
      <br>
         Invoice No : {{ $order->invoice_number }}
  </div>
</div>
</div>
<div class="col-sm-3 p-5" style="border:1px solid #C0D2D4">
  <h6 class="panel-title txt-dark text-warning">Change order status</h6><br>
<form action="{{ url('admin/change-order-status') }}" method="post" >
  @csrf
 <div class="col-sm-12">
 <input type="hidden" name="id" value="{{ $order->id }}">
  <select class="form-control" name="ost" required="">
    <option value="">Change Status</option>
    <option>In Process</option>
    <option>Packed</option>
    <option>Shipped</option>
     <option>Refunded</option>
    <option>Cancelled</option>
    <option>Delivered</option>
    <option>Out for delivery</option>
      <option>Out for reach</option>
  </select>
 </div>
   <div class="col-sm-12 ">
    <button class="btn btn-success text-right"><i class="fa fa-paper-plane" aria-hidden="true"></i> Change</button>
 <br><br>
 </div>
</form>
</div>

<div class="clearfix"></div>
</div>
<div class="panel-wrapper ">
<div class="panel-body">
  <hr class="light-grey-hr"/>
<div class="form-wrap">
<div class="row p-3">
<table  class="table table-hover  " >
  <thead style="background:#FFAC32;">
    <tr class=" text-xs-left">
      <th>SKU ID</th>
      <th>Product</th>
      <th>Quantity</th>
      <th>Product Price</th>
      <th>Discount</th>
      <th>Total Saving</th>
      <th>Total</th>
      <th>Image</th>
      <th>Return Remain Days</th>
        </tr>
  </thead>
  @php $tot=0;$tax_type=[];$i=0;$tax_rate=[] @endphp
  <tbody class="c" id="attrvdata">
    @if(!empty($order->orderItem))
    @foreach($order->orderItem as $item)
        <tr id='{{ $item['id'] }}'>
          <td>{{ $item->sku_id }}</td>
      <td>{{ Str::ucfirst($item['product_name'])}}</td>
            <td>{{ Str::ucfirst($item['quantity']) }}</td>
            <td> Rs. {{ Str::ucfirst($item['product_price']) }}</td>
            <td>{{ $item->discount }} %</td>
            <td> Rs. {{ Str::ucfirst($item['total_saving']) }}</td>
            <td> Rs. {{ $item['total_price'] }}</td>
            <td>
                @if($item['product_type']=="single")
                <img src="{{ $item['thumbnail'] }}" style="height:100px;width:120px;">
                @else
                <img src="{{ $item['thumbnail'] }}" style="height:100px;width:120px;">
                @endif
            </td>
            <td>{{ $item->return_policy }}</td>
            @isset($item->tax)
             @foreach(json_decode($item->tax,true) as $tx)
               @php 
                     $tax_type[$i]=$tx['tax_type'];
                     $tax_rate[$tx['tax_type']]=$tx['tax_amount'];
                      $i++;
                @endphp
             @endforeach
            @endisset
         @php $tot +=$item['total_price'];
         print_r($tax_rate);
         @endphp
      </tr>
      <tr>
        <td colspan="9">
           <p><span style="font-weight:bold;">Neck Style:</span> {{ $item['neck_type'] }}<span style="font-weight:bold;"> ({{ $item['neck_style'] }}) </span></p>
           <p><span style="font-weight:bold;" class="text-capitalize">sleeve Style:</span> {{ $item['sleeve_type'] }}<span style="font-weight:bold;"> ({{ $item['sleeve_style'] }}) </span></p>
            <p><span style="font-weight:bold;" class="text-capitalize">bottom Style:</span> {{ $item['bottom_type'] }}<span style="font-weight:bold;"> ({{ $item['bottom_style'] }}) </span></p>
            <p><span style="font-weight:bold;" class="text-capitalize">Size</span>
             {{ $item['size'] }}</p>
            <p><span style="font-weight:bold;" class="text-capitalize">Height</span>
             {{ $item['height'] }}</p>
              <p><span style="font-weight:bold;" class="text-capitalize">Option Style</span>
             {{ $item['optional_style'] }}</p>
        </td>
      </tr>
    @endforeach

    @else
    <td colspan="5">No Order Items</td>
    @endif

  </tbody>
</table>
<hr>
<table class="table-hover table text-right" style="line-height:0.3">
   <thead>
  
       <tr>
      <td style="width:85%; ">Sub Total</td>
      <td style="width:15%;text-align:left "> Rs. {{ $tot }}</td>
    </tr>
   
      @if(isset($tax_type))
         @php $check=$tax_type[0];$i=0 @endphp
       @foreach(array_unique($tax_type) as $tx )
       <tr>
           <td style="width:85%; ">{{ $tx }}</td>
             <td style="width:15%;text-align:left "> Rs.  </td> 
         @foreach($tax_rate as $rate)
             {{ $rate}}
         @endforeach
        @php $tot    @endphp
      </tr>
       @endforeach
       @endisset
    <tr>
      <td style="width:85%; ">Shipping Charge</td>
      <td style="width:15%;text-align:left "> Rs. {{ $order->shipping_charge }}</td>
    </tr>
    @isset($order->customization_charge)
      <tr>
      <td style="width:85%; ">Customization Charge</td>
      <td style="width:15%;text-align:left "> Rs. {{ $order->customization_charge }}</td>
       @php $tot +=$order->customization_charge;  @endphp
    </tr>
     @endisset
    <hr>
      <tr>
      <td style="width:85%; border-top: 1px solid #000"><H6> Total </H6></td>
      <td style="width:15%;text-align:left;border-top: 1px solid #000 "><h6> Rs. {{ $tot+$order->shipping_charge }}</h6></td>
    </tr>
   </thead>
</table>
</div>
</div>
</div>
</div>
</div>
  </div>
@push('ajax-script')
@endpush
@endsection
