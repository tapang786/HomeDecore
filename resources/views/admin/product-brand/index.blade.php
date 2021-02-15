@extends('layouts.admin')
@section('title', $title)
@section('content')
    <!-- /Row -->
    <div class="card">
        <div class="card-header">
          <div class="card-body">
            @can('brand_create')
            <form action="{{ route('admin.brand-setting.store') }}" method="post" class="p-2 " enctype="multipart/form-data">
                @csrf
                <h5>{{ $title }}</h5>
                @if(session('msg'))
                <p class="p-1 alert-success text-dark text-center">{{ session('msg') }}</p>
               @endif
            <div class="row border-light">
              
               <div class="col-sm-5 form-group">
                 <label>Brand Name</label>
                   <input type="text" name="name" value="{{ isset($edbrand->name)?$edbrand->name:'' }}" class="form-control" required="">
                   <input type="hidden" name="id" value="{{ isset($edbrand->id)?$edbrand->id:'' }}" class="form-control" required="">
               </div>
                <div class="col-sm-5 form-group">
                 <label>Brand Icon</label>
                   <input type="file" name="icon" value="" class="form-control" >
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
                            <th>Brand Name</th>
                            <th>Brand Icon</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody class="c">
                        @isset($brand)
                            <?php $i = 0; ?>
                            @foreach ($brand as $item)
                                <tr id='{{ $item->id }}'>
                                    <td>{{ Str::ucfirst($item->name) }}</td>
                                    <td><img src="{{ url('') }}/{{ $item->icon }}" style="height:60px;width:60px;border-radius: 50%;"></td>
                                    <td>
                                        @if ($item->status == 1)
                                            <button class="btn btn-success btn-xs edit btn-rounded">Active</button>
                                    </td>
                                @else
                                    <button class="btn btn-danger btn-xs edit btn-rounded">De-active</button></td>
                            @endisset
                            <td>
                                @can('brand_edit')
                                    <a class="btn btn-xs btn-info " href="{{ route('admin.brand-setting.edit',$item->id) }}">
                                        <i class="far fa-edit"></i>
                                    </a>
                                @endcan
                                @can('brand_delete')
                                    <a href="javascript:void(0)" class="btn btn-xs btn-danger delbrand"><i
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
            $(".delbrand").click(function(event) {
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
                            url: "{{ url('admin/brand-setting') }}/"+id,
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
