@extends('layouts.admin')
@section('title',$title)
@section('content')

<!-- /Row -->
<div class="card">
    <div class="card-header ">
 
        <div class="row">
            <div class="col-sm-6">
                <h4 class="card-title">
                    Terms
                </h4>
            </div>
            <div class="col-sm-6 text-right">
                @can('category_create')
                <div style="margin-bottom: 10px;" class="row">
                    <div class="col-lg-12">
                        <a class="btn btn-success add_cat" href="javascript:void(0)" data-target="#addCat" data-toggle="modal">
                            {{ trans('global.add') }} Term
                        </a>
                    </div>
                </div>
            @endcan
            </div>
        </div>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-striped table-hover datatable datatable-User" id="example">
             <thead >
              <tr >
                <th>#Sr.</th>
                <th>Name</th>
                <th>Slug</th>
                <th>Action</th>
              </tr>
            </thead>
                <tbody class="c">
                      @isset($terms)
                        <?php $i=1; ?>
                        @foreach($terms as $item)
                        <tr id='{{ $item['id'] }}'>
                          <td>{{ $i }}</td>
                          <td>{{ Str::ucfirst($item['value']) }}</td>
                          <td>{{ $item['slug'] }}</td>
                          
                          <td>
                            <a class="btn btn-xs btn-info edit far fa-edit" href="javascript:void(0)">
                               Edit
                            </a>
                            <a href="javascript:void(0)" class="btn btn-xs btn-danger delc fas fa-trash-alt">
                                Delete
                            </a>
                            
                          </td>
                        </tr>
                        <?php $i++; ?>
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
      <div class="modal-header" style="background-color:#FFAC32">

        <h5 class="modal-title">Add & Update Terms</h5>
      </div>
      <form id="addcat" method="post">
      	@csrf
        <div class="modal-body">

          <div class="form-group">
            <label for="recipient-name" class="control-label mb-10">Name</label>
            <input type="text" class="form-control name" id="recipient-name " name="name"  value="">
            <input type="hidden" name="id" id="id" value="">
            <input type="hidden" name="attribute_id" id="attribute_id" value="{{ $attribute_id }}">
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
        url:'{{ url('/admin/terms') }}',
        type:'POST',
        data:new FormData(this),
        contentType:false,
        processData:false,
        success:function(data)
        {
          var d = $.parseJSON(data);
          //swal.fire("Added");
          location.reload();
        }
    });
  });

  /*Edit CAT */
  $(".delc").click(function(event) {
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
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'No, cancel!',
        reverseButtons: true
      }).then((result) => {
        if (result.isConfirmed) {
          $.get('/admin/delete-term/'+id, function(data) {
            swalWithBootstrapButtons.fire(
              'Deleted!',
              'Your file has been deleted.',
              'success'
            );
            $("#"+id).remove();
            location.reload();
          });
        } else if ( result.dismiss === Swal.DismissReason.cancel) 
        {
          swalWithBootstrapButtons.fire(
            'Cancelled',
            'Your imaginary file is safe :)',
            'error'
          );
        }
      });
  });
    
  $(".edit").click(function(event) {
    //
    var id=$(this).parents('tr').attr('id');
    $.get('{{ url('/admin/terms') }}/'+id+'/edit', function(data) {
      var d = $.parseJSON(data);
      $('.name').attr('value', d.value);
      $('#id').attr('value',d.id);     
      $("#addCat").modal('show');
    });    
  });

  /*$(document).ready(function(){
      $("#InputCat").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $(".c tr").filter(function() {
          $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
        });
      });
  });*/

</script>  
@endpush
@endsection
