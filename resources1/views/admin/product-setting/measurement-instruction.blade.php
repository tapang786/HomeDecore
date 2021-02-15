@extends('layouts.admin')
@section('title', $title)
@section('content')
    <!-- /Row -->
    <div class="card">
        <div class="card-header">
          <div class="card-body">
            @can('measure_create')
            <form action="{{ route('admin.measurement-instruction.store') }}" method="post" class="p-2 " enctype="multipart/form-data">
                @csrf
                <h5>{{ $title }}</h5>
                @if(session('msg'))
                <p class="p-1 alert-success text-dark text-center">{{ session('msg') }}</p>
               @endif
            <div class="row border-light">
              
               <div class="col-sm-3 form-group">
                 <label>Body Part</label>
                  <select name="body" class="form-control" required="">
                    <option value="{{ isset($editmeas->custom_size)?$editmeas->custom_size:"" }}">{{ isset($editmeas->custom_size)?$editmeas->custom_size:"Select Body Part" }}</option>
                    @isset($bodyp)
                     @foreach($bodyp as $bp)
                      <option>{{ $bp->varient_name }}</option>
                        @endforeach
                        @endisset
                  </select>
               </div>
                 <div class="col-sm-6 form-group">
                 <label>Title</label>
                   <input type="text" name="title" value="{{ isset($editmeas->title)?$editmeas->title:'' }}" class="form-control" required="">
                   <input type="hidden" name="id" value="{{ isset($editmeas->id)?$editmeas->id:'' }}">
               </div>

                <div class="col-sm-3 form-group">
                 <label>Measurement Image  </label>
                   <input type="file" name="imgfile" class="form-control"  value="">
               </div>
                <div class="col-sm-12 form-group">
                 <label>Content</label>
                 <textarea class="form-control" name="content" style="height:200px;">{{ isset($editmeas->content)?$editmeas->content:'' }}</textarea>
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
                            <th>Title</th>
                            <th>Body Parts</th>
                            <th>Image</th>
                            <th>Contents</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody class="c">
                        @isset($meas)
                            <?php $i = 0; ?>
                            @foreach ($meas as $item)
                                <tr id='{{ $item->id }}'>
                                    <td>{{ Str::ucfirst($item->title) }}</td>
                                    <td>{{ Str::ucfirst($item->custom_size ) }}</td>
                                    <td><img src="{{ url('') }}/{{ $item->image  }}" style="height:100px;width:100px;"></td>
                                    <td>{!! $item->content !!}</td>
                                    <td>
                                        @can('measure_edit')
                                            <a class="btn btn-xs btn-info " href="{{ route('admin.measurement-instruction.edit',$item->id) }}">
                                                <i class="far fa-edit"></i>
                                            </a>
                                        @endcan
                                        @can('measure_delete')
                                            <a href="javascript:void(0)" class="btn btn-xs btn-danger delmeas"><i
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
            $(".delmeas").click(function(event) {
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
                            url: "{{ url('admin/measurement-instruction') }}/"+id,
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
    @endpush
@endsection
