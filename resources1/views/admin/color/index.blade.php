@extends('layouts.admin')
@section('title', $title)
@section('content')
    <!-- /Row -->
    <div class="card">
           <div class="card-header ">
 
        <div class="row">
            <div class="col-sm-6">
                <h4 class="card-title">
                    Manage Colors
                </h4>
            </div>
            <div class="col-sm-6 text-right">
                @can('color_create')
                <div style="margin-bottom: 10px;" class="row">
                    <div class="col-lg-12">
                        <a class="btn btn-dark btn-sm rounded adColor" href="javascript:void(0)" data-target="#addColor" data-toggle="modal">
                            {{ trans('global.add') }} color
                        </a>
                    </div>
                </div>
            @endcan
            </div>
        </div>
    </div>
        <div class="card-header">
          <div class="card-body">
            <div class="table-responsive">
                <table class=" table table-striped table-hover datatable datatable-User" id="example">
                    <thead>
                        <tr>
                            <th>Color Name</th>
                            <th>Color</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody class="c">
                        @isset($color)
                            <?php $i = 0; ?>
                            @foreach ($color as $item)
                                <tr id='{{ $item->id }}'>
                                    <td>{{ Str::ucfirst($item->colorname) }}</td>
                                    <td>
                                        @if($item->color_code!="")
                                        <div style="height:50px;width:55px;border-radius:50%;background-color:{{ $item->color_code }}"></div>
                                        @else
                                        <img src="{{ url('') }}/{{ $item->color_image }}" style="height:50px;width:55px;border-radius:50%">
                                        @endif
                                    </td>
                             
                                <td>
                                @can('color_edit')
                                    <a class="btn btn-xs btn-info editColor" href="javascript:void(0)">
                                        <i class="far fa-edit"></i>
                                    </a>
                                @endcan
                                @can('color_delete')
                                    <a href="javascript:void(0)" class="btn btn-xs btn-danger delClr"><i
                                            class="fas fa-trash-alt"></i></a>
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
<div id="addColor" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
<h5 class="modal-title text-warning title">Add Color</h5>
</div>
<form id="formclrs" method="post" enctype="multipart/form-data">
    @csrf
<div class="modal-body">
<div class="form-group row" >
<div class="col-sm-12 text-center text-success pb-2">Choose Color Option</div><br>
<div class="col-sm-6">Custom Color <input type="radio" class="form-check clopt" id="1" name="clropt" value="custom" onClick="chooseColor(1)"></div>
<div class="col-sm-6 text-right">Color Pallate <input type="radio" class="form-check clopt" id="0" name="clropt" value="pallate" onClick="chooseColor(0)"></div>
</div>
<hr>
<div class="form-group"  id="clrimg">
<label for="recipient-name" class="control-label mb-10"> Color Image</label>
<input type="file" class="form-control" name="imgfile"  id="clrimg1">
<input type="hidden" name="id" value="" class="id">
</div>
<div class="form-group" id="clrplt">
<label for="recipient-name" class="control-label mb-10">Color Pallate</label>
<input type="color" class="form-control"  name="clrplt" id="clrp">
</div>
<div class="form-group">
<label for="recipient-name" class="control-label mb-10">Color Name </label>
<input type="text" class="form-control name" id="recipient-name " name="name" required="">
</div>
</div>
<div class="modal-footer">
<button type="button" class="btn btn-default reload" data-dismiss="modal">Close</button>
<button type="submit" class="btn btn-danger">+ Add & update Color</button>
</div>
</form>
</div>
</div>
</div>
    @push('ajax-script')
        <!-- Edit CAT -->
        <script type="text/javascript">
            $(".delClr").click(function(event) {
                var id = $(this).parents('tr').attr('id');
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
                            url: "{{ url('admin/color') }}/"+id,
                            type: 'DELETE',
                            data:{ 
                                id:id,
                                _token:'{{csrf_token() }}'
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
        <!-- for data search -->
        <script>
            $(document).ready(function() {
                $("#InputCat").on("keyup", function() {
                    var value = $(this).val().toLowerCase();
                    $(".c tr").filter(function() {
                        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                    });
                });
            });

        </script>
<script type="text/javascript">
  $(document).ready(function() {
    $('#clrimg').hide();
    $('#clrplt').hide();
    $(document).on('click', '.clopt', function(event) {
      var id=$(this).attr('id');
      if(id==0)
      {
       $('#clrplt').show();
       $('#clrimg').hide();
      }
      else
        {
       $('#clrplt').hide();
       $('#clrimg').show();
      }
    });

  });
</script>
<!-- to add attribute in database-->
<script type="text/javascript">
function chooseColor(id)
{
  if(id==1){
   window.cid=id;

  }else
  {
      window.cid=id;
  }
}

$("#formclrs").submit(function(event) {
    event.preventDefault();
  if(window.cid==1)
  {
    $.ajax({
        url:'{{ route('admin.color.store') }}',
        type:'POST',
        data:new FormData(this),
        contentType:false,
        processData:false,
        success:function(data)
        {
        $("#formclrs")[0].reset();
        $('#clrimg').hide();
        $('#clrplt').hide();
          var d=$.parseJSON(data);
          var sts='';
           sts='<button class="btn btn-success btn-xs st btn-rounded " id="1">Active</button>';
           var action='<button class="btn btn-primary btn-xs edit btn-rounded"><i class="far fa-edit"></i></button><button class="btn btn-danger btn-xs del btn-rounded"><i class="fas fa-trash-alt"></i></button>';
        var row=
        '<tr id='+d.id+'><td>'+d.colorname+'</td><td><img src="{{ url('') }}/'+d.color_image+'" alt="color img" style="vertical-align:middle;height:60px;width:60px;border-radius:50%;" class="img-thumbnail"></td><td>'+action+'</td></tr>';
        $(".c").prepend(row);
         swal.fire("Color Added");
           }
    });


}
else
{
    $.ajax({
      url:'{{ route('admin.color.store') }}',
      type: 'POST',
      data:new FormData(this),
      contentType:false,
      processData:false,
      success:function(data)
      {
       $("#formclrs")[0].reset();
        $('#clrimg').hide();
        $('#clrplt').hide();
          var d=$.parseJSON(data);
          var sts='';
          sts='<button class="btn btn-success btn-xs st btn-rounded " id="1">Active</button>';
            var action='<button class="btn btn-primary btn-xs edit btn-rounded"><i class="far fa-edit"></i></button><button class="btn btn-danger btn-xs del btn-rounded"><i class="fas fa-trash-alt"></i></button>';
        var row=
        '<tr id='+d.id+'><td>'+d.colorname+'</td><td><div  style="vertical-align:middle;height:60px;width:60px;border-radius:50%;background-color:'+d.color_code+';" ></div></td><td>'+action+'</td></tr>';
        $(".c").prepend(row);

          swal.fire("Color Added");
             
      }
  })
}

});
</script>
<script type="text/javascript">
    
</script>
<script type="text/javascript">
    $(document).ready(function() {
        $(document).on('click', '.editColor', function(event) {
            let id=$(this).parents('tr').attr('id');
         $.get('{{ url("admin/color") }}/'+id+"/edit", function(data) {
             $(".name").val(data.clr.colorname)
             $(".id").val(data.clr.id)
             $(".title").html('Edit Color')
             $('#addColor').modal('show')
         });
        });
    });
</script>
<script type="text/javascript">
    $(document).ready(function() {
        $(document).on('click', '.adColor', function(event) {
             $(".id").val('')
             $(".title").html('Add Color')
        });
    });
</script>
    @endpush
@endsection
