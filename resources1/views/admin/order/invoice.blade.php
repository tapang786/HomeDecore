<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Invoice Pdf</title>
<style type="text/css" >
	h3,h4,h5,h6{
		font-weight:600;
		color:black;
       line-height:0.3
       padding-bottom:0px;
		margin-bottom: 0px;
		font-family:Arial, Helvetica, sans-serif
	}
	h4{
		font-size:26px;
	}
	h6{
		font-size:18px;
	}
	h5{
     font-size:15px;
 	}
 p,span,td{
 font-family:Arial, Helvetica, sans-serif	
 }
	span{
		color:grey;
	}
	.text-center{
		text-align:center;
	}
	thead{
		width:100%;
	}
	thead>tr>th{
		width:16%;
	}
	tbody>tr>td{
		width:16%;
		text-align:center;
	}
	.cust{
		float:left;
	}
</style>
</head>
<body>
	<div class="text-center"><h4 style="font-weight:600">Tax Invoice</h4></div><br>
<table style="width:100%;">
	<tbody>
		<tr>
			<td style="width:65%;text-align:left">
				<p style="font-weight:600"><img src="{{ url('storage/app') }}/{{ $setting->logo }}" style="height:30px;width:200px;" alt="logo"></p>
			<p > {{ $setting->address.", ".$setting->country.", ".$setting->state.", ".$setting->city.", ".$setting->zip.', ' }}<br>{{ $setting->helpline }}</p>
          <h5 >GSTIN - <span >{{ $setting->gstin }}</span></h5>
			</td>
			<td style="width:35%;"><h5 style="border:2px black solid;padding:20px;">Invoice Number <span > #{{ $order->invoice_number }}</span></h5></td>
			<td style="width:10%;"></td>
		</tr>
	</tbody>
</table>
<br>
	<table style="width:100%;border-top:2px solid black;">
	<tbody>
		<tr>
			<td style="width:30%;text-align:left">
			<h5 >Order ID: #{{ $order->order_id }}</h5>
			<h5 >Order Date: <span >{{ \Carbon\Carbon::parse($order->order_date)->format('d-M-Y') }}</span></h5>
			<h5 >Invoice Date: <span >{{ \Carbon\Carbon::parse($order->order_date)->format('d-M-Y') }}</span></h5>
			<h5 >PAN: <span >{{ $setting->pan }}</span></h5>
			<h5 >CIN: <span >{{ $setting->cin }}</span></h5>
			</td>
			<td style="width:30%;text-align:left">
							<h5>Bill To</h5>
				<h5><?php echo ucwords($order->shippingAddress['name']) ?></h5>
			<p>{{ $order->shippingAddress['landmark']." ".$order->shippingAddress['address'].", ".$order->shippingAddress['country'].", ".$order->shippingAddress['state']." ".$order->shippingAddress['city'].", ".$order->shippingAddress['zip_code']." ".$order->shippingAddress['address_type'] }}<br>{{ $order->shippingAddress['phone'] }}</p>

			</td>
			<td style="width:30%;text-align:left;">	<h5>Ship To</h5>
			<h5><?php echo ucwords($order->shippingAddress['name']) ?></h5>
			<p>{{ $order->shippingAddress['landmark']." ".$order->shippingAddress['address'].", ".$order->shippingAddress['country'].", ".$order->shippingAddress['state']." ".$order->shippingAddress['city'].", ".$order->shippingAddress['zip_code']." ".$order->shippingAddress['address_type'] }}<br>{{ $order->shippingAddress['phone'] }}</p></td>

		</tr>
	</tbody>
</table>
	
@php $ti=0;$tp=0;$td=0;$gt=0;$tt=0;  @endphp
	<table  style="width:100%;border-top:2px solid black;border-bottom:1px solid black;">
		<thead>
			<tr style="height:40px !important;border-bottom:1px solid black;">
			   <th>Product</th>
			   <th>Price</th>
				<th>Qty</th>
				<th>Total</th>
				<th>Total Saving</th>
				<th>Gross Amount</th>
				
			</tr>
		</thead>
		<tbody>

			@if(count($order->orderItem) < 0)
			<tr>
				
              <td colspan="5">No Products</td>
			 </tr>
			 @else
			 @foreach ($order->orderItem as $value)
               <tr>
               <td>{{ Str::ucfirst($value->product_name) }}</td>
               <td>Rs. {{ $value->product_price }} </td>
				<td>{{ $value->quantity }}</td>
				<td>Rs. {{ $value->product_price*$value->quantity }} </td>
				<td>Rs. {{ $value->total_saving }} </td>
				<td>Rs. {{ $value->total_price  }} </td>
			    </tr>
			    @php
                  $ti +=$value->quantity;
                  $tt +=$value->product_price*$value->quantity;
                  $tp +=$value->product_price;
                  $td +=$value->total_saving;
                  $gt +=$value->total_price;
                  $total_amount=$gt;

			    @endphp
			 @endforeach
           <tbody style="border-top:1px solid black !important;">
			 <tr style="font-weight:600;" >
			 	
			 	<td colspan="1" >Total</td>
			 	<td >{{ $tp }} Rs</td>
			 	<td >{{ $ti }} </td>
			 	<td >{{ $tt }} Rs</td>
			 	<td >{{ $td }} Rs</td>
			 	<td>{{ $gt }} Rs</td>
			 
			 </tr>
			 </tbody>
			 @endif
		
		</tbody>
	</table>
<table style="width:100%; margin-top:10px">
	<tbody>
		@isset($order->tax)
		@foreach(json_decode($order->tax,true) as $tx)
          <tr>
          	<td colspan="7" style="width:80%;"></td>
			<td>{{ $tx['tax_type'] }}
			</td>
			<td>Rs {{ $tx['tax_amount'] }} 
				<?php $gt +=$tx['tax_amount']; ?></td>
		  </tr> 
		@endforeach
		@endisset
		 @isset($order->customization_charge)
      <tr>
      	<td colspan="7" style="width:80%;"></td>
      <td >Customization Charge</td>
      <td > Rs. {{ $order->customization_charge }}</td>
       @php $gt +=$order->customization_charge;  @endphp
      </tr>
     @endisset
        <tr>
        	<td colspan="7" style="width:80%;"></td>
        	<td>Shipping Charge</td>
        	<td>Rs {{ $order->shipping_charge }}</td>
        </tr>

		<tr>
			<td colspan="7" style="width:70%;"></td>
			<td style="border-top:1px solid black;">
				 <h6> Total: </h6>
			</td>
			<td style="border-top:1px solid black;"><h6>Rs {{ $gt+$order->shipping_charge }} </h6></td>
		</tr>
	</tbody>
</table>
<p>
	*Keep this invoice and
manufacturer box for
warranty purposes
</p>

	
</body>
</html>
