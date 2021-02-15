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
        <div class="table-responsive">
            <table class=" table table-striped table-hover datatable datatable-User " id="example">
             <thead >
              <tr >
                <th>#order number</th>
                <th>status</th>
                <th>shiiping charge</th>
                <th>customization charge</th>
                <th>order date</th>
                <th>Action</th>
              </tr>
            </thead>

                <tbody class="c">
                      @isset($order)
                             <?php $i=1; ?>
                        @foreach($order as $item)
                        <tr id='{{ $item->id }}'>
                          <td>#{{ $item->order_id }}</td>
                          <td>@if($item->status=="new")
                            <a href="javascript:void(0)" class="badge badge-success">{{ $item->status }}</a>
                            @elseif($item->status=="return")
                             <a href="javascript:void(0)" class="badge badge-warning ">{{ $item->status }}</a>
                              @elseif($item->status=="cancel")
                             <a href="javascript:void(0)" class="badge badge-danger ">{{ $item->status }}</a>
                               @else
                             <a href="javascript:void(0)" class="badge badge-primary ">{{ $item->status }}</a>
                             @endif
                          </td>
                          <td>{{ Str::ucfirst($item->shipping_charge)}}</td>
                          <td>{!! Str::ucfirst($item->customization_charge)!!}</td>
                          <td>{{ \Carbon\Carbon::parse($item->order_date)->format('d-M-yy') }}</td>
                          <td>
                            @can('order_show')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.order.show',$item->id) }}">
                                     <i class="far fa-eye"></i>
                                    </a>
                             @endcan
                            @can('order_delete')
                <a href="javascript:void(0)" class="btn btn-xs btn-danger delpage" ><i class="fas fa-trash-alt"></i></a>
                                 @endcan
                          </td>
                        </tr>
                        @endforeach
                        @endisset
                </tbody>
            </table>
        </div>
    </div>
</div>
<div id="addCat" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header" style="background-color:pink">
<h5 class="modal-title">Add & Update Category</h5>
</div>
<form id="addcat" method="post">
	@csrf
<div class="modal-body">
<div class="form-group">
<label for="recipient-name" class="control-label mb-10">Category name</label>
<input type="text" class="form-control name" id="recipient-name " name="name"  value="">
<input type="hidden" name="id" id="id" value="">
</div>
<div class="form-group">
<label for="message-text" class="control-label mb-10">Parent Category</label>
<select name="pname" id="pc" class="form-control" >
	<option selected="" id="parent">No Parent</option>
</select>
</div>
</div>
<div class="modal-footer">
<button type="button" class="btn btn-default reload" data-dismiss="modal">Close</button>
<button type="submit" class="btn btn-danger">+ Add & Update</button>
</div>
</form>
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
