@extends('layouts.admin')
@section('title', $title)
@section('content')
    <!-- /Row -->
    <div class="card">
        <div class="card-header">
          <div class="card-body">
            @can('size_value_create')
            <form action="{{ route('admin.product-size-value-setting.store') }}" method="post" class="p-2 ">
                @csrf
                <h5>{{ $title }}</h5>
                @if(session('msg'))
                <p class="p-1 alert-success text-dark text-center">{{ session('msg') }}</p>
               @endif
            <div class="row border-light">
              
               <div class="col-sm-3 form-group">
                 <label>Size Varient Group</label>
                  <select name="vgroup" class="form-control vgroup" required="">
                    <option value="{{ isset($size_var->getVarient['varient_category'])?$size_var->getVarient['varient_category']:"" }}">{{ isset($size_var->getVarient['varient_category'])?$size_var->getVarient['varient_category']:"Select Varient Group" }}</option>
                      <option>Standard Size</option>
                       <option>Custom Size</option>
                  </select>
               </div>
               <div class="col-sm-3 form-group">
                <label>Size Varient Name</label>
                 <select name="vname" class="form-control vname" required="">
                <option value="{{ isset($size_var->getVarient['id'])?$size_var->getVarient['id']:"" }}">{{ isset($size_var->getVarient['varient_name'])?$size_var->getVarient['varient_name']:"" }}</option>
                  </select>
              </div>
                <div class="col-sm-4  form-group">
                 <label>Size Varient value</label>
                   <input type="text" name="vvalue" value="{{ isset($size_var->varient_value)?$size_var->varient_value:'' }}" class="form-control" required="">
                   <input type="hidden" name="id" value="{{ isset($size_var->id)?$size_var->id:'' }}">
               </div>
                <div class="col-sm-2 form-group">
                   <button class="btn btn-primary btn-sm">Add & Update</button>
               </div>
              </div>
             </form>
             @endcan<br>
            <div class="table-responsive">
                <table class=" table table-striped table-hover datatable datatable-User" id="example">
                    <thead>
                        <tr>
                            <th>Varient Group</th>
                            <th>Varient Name</th>
                            <th>Varient Value</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody class="c">
                        @isset($size_v)
                            <?php $i = 0; ?>
                            @foreach ($size_v as $item)
                                <tr id='{{ $item->id }}'>
                                    <td>{{ Str::ucfirst($item->getVarient['varient_category']) }}</td>
                                    <td>{{ Str::ucfirst($item->getVarient['varient_name']) }}</td>
                                    <td>{{ Str::ucfirst($item->varient_value) }}</td>
                                    <td>
                                        @can('size_value_edit')
                                            <a class="btn btn-xs btn-info " href="{{ route('admin.product-size-value-setting.edit',$item->id) }}">
                                                <i class="far fa-edit"></i>
                                            </a>
                                        @endcan
                                        @can('size_value_delete')
                                            <a href="javascript:void(0)" class="btn btn-xs btn-danger delsV"><i
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

    @push('ajax-script')

        <!-- Edit CAT -->
        <script type="text/javascript">
            $(".delsV").click(function(event) {
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
                            url: "{{ url('admin/product-size-value-setting') }}/"+id,
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
                $(document).on('change', '.vgroup', function(event) {
                 $.get('{{ url("admin/get-size-varient") }}/'+$('.vgroup').val(), function(data) {
                   var opt="<option value=''>Select varient name</option>";
                   $.each(data.ps, function(index, val) {
                    opt +='<option value="'+val.id+'">'+val.varient_name+'</option>'
                   });
                   $('.vname').html(opt)
                 });
                });
            });
        </script>
    @endpush
@endsection
