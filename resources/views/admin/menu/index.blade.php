@extends('layouts.admin')
@section('title',$title)
@section('content')

<!-- /Row -->
<div class="card">
    <div class="card-header ">
        {{-- <div class="row">
          <div class="col-sm-6">
            <div class="row">
              @if(count($main_menu) > 0) 
                  <div class="form-group col-sm-8">
                    <label class="control-label mb-10">Select Menu</label>
                    <select class="main_menu form-control" name="main_menu">
                    @foreach($main_menu as $item)
                      <option value="{{ $item->slug }}">{{ $item->name }}</option>
                    @endforeach
                    </select>
                  </div>
              @endif
              <div class="form-group col-sm-3">
                
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter">Create Menu</button>
              </div>
              

            </div>
          </div>
        </div> --}}
        <div class="row">
            <div class="col-sm-6">
                <h4 class="card-title"> <a href="{{ url('admin/menu') }}">Back</a></h4>
            </div>
            <div class="col-sm-6 text-right">
              @can('category_create')
                <div style="margin-bottom: 10px;" class="row">
                    <div class="col-lg-12">
                        <a class="btn btn-success add_cat" href="javascript:void(0)" data-target="#addCat" data-toggle="modal">
                            {{ trans('global.add') }} Menu 
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
                <th>Parent Menu</th>
                {{-- <th>Status</th> --}}
                <th>Action</th>
              </tr>
            </thead>
                <tbody class="c">
                  @isset($menus)
                        <?php $i=0; //print_r($cat); exit; ?>
                        @foreach($menus as $item)
                        <tr id='{{ $item['id'] }}'>
                          <td>{{ $item['id'] }}</td>
                          <td>{{ Str::ucfirst($item['name']) }}</td>
                          <td>{{ isset($item['parent_menu_name']) ? Str::ucfirst($item['parent_menu_name']) : '-' }}</td>
                          {{-- <td>
                            @if($item['status'] =='active')
                            <button class="btn btn-success btn-xs edit btn-rounded">Active</button></td>
                            @else
                            <button class="btn btn-danger btn-xs edit btn-rounded">De-active</button></td>
                            @endif--}}
                          <td>
                            @if($item['url'] != '')
                            <a class="btn btn-xs btn-success" href="{{ $item['url'] }} ">
                              <i class="far fa-eye"></i>
                            </a>
                            @endif
                            @can('category_edit')
                              <a class="btn btn-xs btn-info edit" href="javascript:void(0)">
                                <i class="far fa-edit"></i>
                              </a>
                            @endcan
                            {{-- @can('category_delete') --}}
                              <a href="javascript:void(0)" class="btn btn-xs btn-danger delc" >
                                <i class="fas fa-trash-alt"></i>
                              </a>
                            {{-- @endcan --}}
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
      <div class="modal-header" style="background-color:#FFAC32">

        <h5 class="modal-title">Add & Update Menu</h5>
      </div>
      <form id="addcat" method="post">
        @csrf
        <div class="modal-body">

          <div class="form-group">
            <label for="recipient-name" class="control-label mb-10">Menu name</label>
            <input type="text" class="form-control name" id="recipient-name " name="name"  value="">
            <input type="hidden" name="id" id="id" value="">
          </div>
          <div class="form-group">
            <label for="message-text" class="control-label mb-10">Parent Menu</label>
            <select name="pname" id="pc" class="form-control" >
              <option selected value="0" id="parent">No Parent</option>
              @if(!$parrent_menu->isEmpty())
                @foreach($parrent_menu as $item)
                  <option value="{{ ($item->id) }}">{{ Str::ucfirst($item->name) }}</option>
                @endforeach
              @endif
            </select>
          </div>
          <div class="form-group">
            <label for="recipient-name" class="control-label mb-10">Url</label>
            <input type="text" class="form-control url" id="url"  name="url" value="">
            <input type="hidden" name="menu_type" id="menu_type" value="{{ $menu_type }}">
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



{{-- 
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <form>

        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">Create Menu</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary">Add</button>
        </div>

      </form>
    </div>
  </div>
</div> --}}


@push('ajax-script')
<script type="text/javascript">

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
          $.get('destroy-menu/'+id, function(data) {
            swalWithBootstrapButtons.fire(
              'Deleted!',
              'Your file has been deleted.',
              'success'
            )
            $("#"+id).remove();
            location.reload();
          });
        } else if ( result.dismiss === Swal.DismissReason.cancel)  /* Read more about handling dismissals below */
        {
          swalWithBootstrapButtons.fire(
            'Cancelled',
            'Your imaginary file is safe :)',
            'error'
          )
        }
      });
  });
    
  $(".edit").click(function(event) {
    //
    var id=$(this).parents('tr').attr('id');

    $.get('{{ url('/admin/manage-menu') }}/'+id+'/edit', function(data) {
      var d=$.parseJSON(data);
      $('.name').attr('value',d.name);
      $('.url').attr('value',d.url);
      $('#id').attr('value',d.id);
//      $('#parent').attr('value',d.parent_menu);
      $('#url').attr('value',d.url);

      if(d.parent_menu != 0) {
        $.each( $('#pc option'), function( i, val ) {
          //$( "#" + val ).text( "Mine is " + val + "." );
          if($(this).val() == d.parent_menu) {
            $(this).attr('selected','selected')
          }
        });
        //$('#parent').text('value', d.name);
      }
      $("#addCat").modal('show');
    });
  });

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
