@extends('layouts.admin')
@section('title',$title)
@section('content')

<!-- /Row -->
<div class="card">
    <div class="card-header ">
 
        <div class="row">
            <div class="col-sm-6">
                <h4 class="card-title">
                    Pages
                </h4>
            </div>
            <div class="col-sm-6 text-right">
                @can('page_create')
                <div style="margin-bottom: 10px;" class="row">
                    <div class="col-lg-12">
                        <a class="btn btn-success" href="{{ route('admin.pages.create') }}" >
                            {{ trans('global.add') }} Page
                        </a>
                    </div>
                </div>
            @endcan
            </div>
        </div>
    </div>
      <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-striped table-hover datatable datatable-User " id="example">
             <thead >
              <tr >
                <th>#Sr.</th>
                <th>Pages</th>
                <th>Page titles</th>
                <th>Contents</th>
                <th>Action</th>
              </tr>
            </thead>
                <tbody class="c">
                      @isset($page)
                             <?php $i=1; ?>
                        @foreach($page as $item)
                        <tr id='{{ $item->id }}'>
                          <td>{{ $i++ }}</td>
                          <td>{{ $item->page_title }}</td>
                          <td>{{ Str::ucfirst($item->page_sub_title)}}</td>
                          <td>{!! Str::ucfirst($item->page_subtitle_content)!!}</td>
                          <td>
                            @can('page_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.pages.edit',$item->id) }}">
                                     <i class="far fa-edit"></i>
                                    </a>
                             @endcan
                            @can('page_delete')
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
    $("#addcat").submit(function(event) {
        event.preventDefault();
         $.ajax({
            url: '{{ route("admin.categories.store") }}',
            type: 'POST',
            data:new FormData(this),
            contentType:false,
            processData:false,
            success:function(data)
            {
            if(data!='You have already added this category')
            {
              var d=$.parseJSON(data);
              var sts='';
               sts='<button class="btn btn-success btn-xs st btn-rounded " id="1">Active</button>';
               var action='<button class="btn btn-info btn-xs edit btn-rounded"><i class="far fa-edit"></i></button><button class="btn btn-danger btn-xs del btn-rounded">  <i class="fas fa-trash-alt"></i></button>';
            var row=
            '<tr id='+d.id+'><td></td><td>'+d.name+'</td><td>'+d.cid+'</td><td>'+sts+'</td><td>'+action+'</td></tr>';
            $(".c").prepend(row);
            $("#pc").append('<option>'+d.name+'</option>');
            $("#addcat")[0].reset();
              swal("Added");
            }else{
               swal("Sorry!! ",data);
            }
            }
        })
    });
    </script>
    <!-- Edit CAT -->
     <script type="text/javascript">

      $(".delpage").click(function(event) {
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
  text: "You won't be able to revert this!",
  icon: 'warning',
  showCancelButton: true,
  confirmButtonText: 'Yes, delete it!',
  cancelButtonText: 'No, cancel!',
  reverseButtons: true
}).then((result) => {
  if (result.isConfirmed) {
     $.ajax({
      url: "{{ url('admin/pages') }}/"+id,
      type: 'DELETE',
      data:{ 
        id:id,
           _token:'{{ csrf_token() }}'
                },
      success:function(data)
      { swalWithBootstrapButtons.fire(
                'Deleted!',
                'Your file has been deleted.',
                'success'
              )
      
        $("#"+id).remove() 
      }
    })
       
        
 
  } else if (
    /* Read more about handling dismissals below */
    result.dismiss === Swal.DismissReason.cancel
  ) {
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
