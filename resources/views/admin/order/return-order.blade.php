@extends('layouts.admin')
@section('title',$title)
@section('content')

<!-- /Row -->
<div class="card">
    <div class="card-header ">
 
        <div class="row">
            <div class="col-sm-6">
                <h4 class="card-title">
                    {{ $title }}
                </h4>
            </div>     
        </div>
    </div>
      <div class="card-body">
   <div class="form-wrap">
<table  class="table table-hover display  pb-30  example" id="example">
  <thead style="background: #FFAC32">
    <tr >      
      <th>Order Id</th>
      <th>Shipping Charge</th>
            <th>Return Date</th>
            <th>Status</th>
            <th>Status Note</th>
      <th>Action</th>
    </tr>
  </thead>
  <tbody class="c" id="attrvdata">
    @if(!empty($returnProduct))
         <?php $i=0; ?>
    @foreach($returnProduct as $item)
    <tr id='{{ $item->id }}'>
         <td>#{{ Str::ucfirst($item->order['order_id']) }}</td>
                <td>{{ $item->order['shipping_charge'] }}</td>
               <td> {{ \Carbon\Carbon::parse($item['return_date'])->format('d-M-Y') }}</td>
      <td><span class="badge-success badge">{{ Str::ucfirst($item->order['status']) }}</span> </td>
      <td>{{ $item->order['status_note'] }}</td>
      <td>
 <div class="dropdown">
  <a class=" dropdown-toggle" type="button" data-toggle="dropdown" href="javascript:void(0)"><i class="fa fa-tasks" aria-hidden="true"></i></a>
  <ul class="dropdown-menu">
    <li><a href="{{ route('admin.order.show',$item->order['id']) }}"><i class="fa fa-eye" aria-hidden="true"></i></a></li>
    <li><a href="#"><i class="fa fa-trash"></i></a></li>
  </ul>
</div>
</td>
    </tr>
    @endforeach

    @else
    <td colspan="5">No order</td>
    @endif

  </tbody>
</table>

</div>
    </div>
</div>

@push('ajax-script')
 <script type="text/javascript">
  $(document).ready(function() {
    });
 </script>
@endpush
@endsection

