@extends('layouts.admin')
@section('title',$title)
@section('content')

<!-- /Row -->
<div class="card">
    <div class="card-header ">
 
        <div class="row">
            <div class="col-sm-6 pl-2">
                <h4 class="card-title">
                    {{ $title }}
                </h4>
            </div>
            <div class="col-sm-6 text-right">
                @can('product_create')
                <div style="margin-bottom: 10px;" class="row">
                    <div class="col-lg-11">
                        <a class="btn btn-dark" href="{{ route('admin.product.create') }}" >
                            {{ trans('global.add') }} Product
                        </a>
                    </div>
                </div>
            @endcan
            </div>
        </div>
    </div>
      <div class="card-body">
        <div class="table-responsive">
          @if(session('msg'))
          <p class="alert-success p-1 text-dark">{{ session('msg') }}</p>
          @endif
<table class="table table-stripped table hover table-responsive datatable" id="example">
  <thead >
    <tr >
      <th>Sr.</th>
      <th>Product Name</th>
            <th>P. Price</th>
            <th>S. Price</th>
            <th>Discount</th>
            <th>Stock</th>
            <th>Stock Alert</th>
             <th>Thumbnail</th>
            <th>Status</th>
            <th>Action</th>
    </tr>
  </thead>
  <tbody class="c">
    @if(!empty($product))
         <?php $i=0; ?>
    @foreach($product as $item)

    @php $j=1 @endphp
    <tr id='{{ $item->id }}'>
      <td>{{ ++$i }}</td>

      <td>{{ Str::ucfirst($item->pname) }}</td>
            <td>{{ Str::ucfirst($item->p_price ) }}</td>
            <td>{{ Str::ucfirst($item->s_price ) }}</td>
            <td>{{ Str::ucfirst($item->discount ) }}%</td>
            <td>{{ Str::ucfirst($item->stock ) }}</td>
            <td>{{ Str::ucfirst($item->stock_alert ) }}</td>
            <td>
            @if(json_decode($item->thumbnails,true)!=null)
            @foreach(json_decode($item->thumbnails,true) as $th)

              @if($j==1)
            <img src="{{url('/product')}}/thumbnail/{{$th}}" alt="" style="width:100px;height:100px;">
                @endif
                @php $j++ @endphp
            @endforeach
            @endif
            </td>
      <td>
        @if($item->status==1)
        <button class="btn btn-success btn-xs edit btn-rounded pstatus" id="1">Published</button></td>
        @else
        <button class="btn btn-danger btn-xs edit btn-rounded pstatus" id="0">In Draft</button></td>
        @endif
      <td>
        <div class="dropdown">
        <a class=" dropdown-toggle"  data-toggle="dropdown" href="Javascript:void(0)">
        <i class="fa fa-ellipsis-v" aria-hidden="true"></i><i class="fa fa-ellipsis-v" aria-hidden="true"></i><i class="fa fa-ellipsis-v" aria-hidden="true"></i>
        </a>
        <ul class="dropdown-menu">
           <li><a href="{{ route('admin.set-varient',$item->id) }}" class="text-dark">Set Varient</a></li>
             <li><a href="{{ route('admin.product.edit',$item->id) }}" class="editp text-success"><i class="fas fa-pencil-ruler"></i> </a></li>
        <li class="divider"></li>
         <li> <a class=" text-danger delp" href="Javascript:void(0)"><i class="far fa-trash-alt"></i></a></li>
        <li class="divider"></li>
        <li><a class="text-warning viewp" href="{{route('admin.product.show',$item->id)}}"><i class="fas fa-eye"></i></a></li>
        </ul>
        </div>
       </td>
    </tr>
    @endforeach

    @else
    <td colspan="5">No Products</td>
    @endif
   
  </tbody>
</table>
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
    <!-- Edit CAT -->
     <script type="text/javascript">

      $(".delp").click(function(event) {
      var id=$(this).parents('tr').attr('id');
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
      url: "{{ url('admin/product') }}/"+id,
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
    </script>
    
    <script type="text/javascript">
       $(".edit").click(function(event) {
       var id=$(this).parents('tr').attr('id');
        $.get('{{ url('/admin/categories') }}/'+id+'/edit', function(data) {
          var d=$.parseJSON(data);
          alert(d.name)
          $('.name').attr('value',d.name);
          $('#id').attr('value',d.id);
          $('#parent').text(d.cid)
          $("#addCat").modal('show')
          
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
@endpush
@endsection
