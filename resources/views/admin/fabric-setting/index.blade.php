@extends('layouts.admin')
@section('title', $title)
@section('content')
    <!-- /Row -->
    <div class="card">
        <div class="card-header">
          <div class="card-body">
            @can('fabric_create')
            <form action="{{ route('admin.fabric-setting.store') }}" method="post" class="p-2 " enctype="multipart/form-data">
                @csrf
                <h5>{{ $title }}</h5>
                @if(session('msg'))
                <p class="p-1 alert-success text-dark text-center">{{ session('msg') }}</p>
               @endif
            <div class="row border-light">
              
               <div class="col-sm-6 form-group">
                 <label>Fabric Name (Cotton, Polyster)</label>
                   <input type="text" name="name" value="{{ isset($edfab->name)?$edfab->name:'' }}" class="form-control" required="">
                   <input type="hidden" name="id" value="{{ isset($edfab->id)?$edfab->id:'' }}" class="form-control" required="">
               </div>
                <div class="col-sm-6 form-group text-center">
                   <button class="btn btn-primary btn-sm">Add & Update</button>
               </div>
              </div>
             </form>
             @endcan<br>
            <div class="table-responsive">
                <table class=" table table-striped table-hover datatable datatable-User" id="example">
                    <thead>
                        <tr>
                            <th>Fabric Name</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody class="c">
                        @isset($fab)
                            <?php $i = 0; ?>
                            @foreach ($fab as $item)
                                <tr id='{{ $item->id }}'>
                                    <td>{{ Str::ucfirst($item->name) }}</td>
                                    <td>
                                        @if ($item->status == 1)
                                            <button class="btn btn-success btn-xs edit btn-rounded">Active</button>
                                    </td>
                                @else
                                    <button class="btn btn-danger btn-xs edit btn-rounded">De-active</button></td>
                            @endisset
                            <td>
                                @can('fabric_edit')
                                    <a class="btn btn-xs btn-info " href="{{ route('admin.fabric-setting.edit',$item->id) }}">
                                        <i class="far fa-edit"></i>
                                    </a>
                                @endcan
                                @can('fabric_delete')
                                    <a href="javascript:void(0)" class="btn btn-xs btn-danger delfab"><i
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
            $(".delfab").click(function(event) {
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
                            url: "{{ url('admin/fabric-setting') }}/"+id,
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
