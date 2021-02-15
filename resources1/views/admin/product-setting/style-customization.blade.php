@extends('layouts.admin')
@section('title', $title)
@section('content')
    <!-- /Row -->
    <div class="card">
        <div class="card-header">
          <div class="card-body">
            @can('style_create')
            <form action="{{ route('admin.product-style-customization.store') }}" method="post" class="p-2 " enctype="multipart/form-data">
                @csrf
                <h5>{{ $title }}</h5>
                @if(session('msg'))
                <p class="p-1 alert-success text-dark text-center">{{ session('msg') }}</p>
               @endif
            <div class="row border-light">
              
               <div class="col-sm-3 form-group">
                 <label>Style Varient Group</label>
                  <select name="vgroup" class="form-control" required="">
                    <option value="{{ isset($edstyle->style_group)?$edstyle->style_group:"" }}">{{ isset($edstyle->style_group)?$edstyle->style_group:"Select Varient Group" }}</option>
                      <option>Neckline</option>
                       <option>Sleeve Type</option>
                        <option>Length</option>
                  </select>
               </div>
                 <div class="col-sm-5 form-group">
                 <label>Style Varient Name (v neck, u neck, sleeveless, ankle length)</label>
                   <input type="text" name="vname" value="{{ isset($edstyle->style_group_name)?$edstyle->style_group_name:'' }}" class="form-control" required="">
                   <input type="hidden" name="id" value="{{ isset($edstyle->id)?$edstyle->id:'' }}">
               </div>

                <div class="col-sm-3 form-group">
                 <label>Size Varient Image icon </label>
                   <input type="file" name="imgfile" class="form-control"  value="">

                   <input type="hidden" name="id" value="{{ isset($edstyle->id)?$edstyle->id:'' }}">
               </div>
                  <div class="col-sm-1 form-group">
                    <label>Example </label>
                  <img src="{{ asset('') }}/UNeck.jpg" style="height:50px;width:50px;">
                
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
                            <th>Style Varient Group</th>
                            <th>Style Varient Name</th>
                            <th>Icon</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody class="c">
                        @isset($style)
                            <?php $i = 0; ?>
                            @foreach ($style as $item)
                                <tr id='{{ $item->id }}'>
                                    <td>{{ Str::ucfirst($item->style_group) }}</td>
                                    <td>{{ Str::ucfirst($item->style_group_name ) }}</td>
                                    <td><img src="{{ url('') }}/{{ $item->style_group_icon  }}" style="height:70px;width:70px;"></td>
                                    <td>
                                        @can('style_edit')
                                            <a class="btn btn-xs btn-info " href="{{ route('admin.product-style-customization.edit',$item->id) }}">
                                                <i class="far fa-edit"></i>
                                            </a>
                                        @endcan
                                        @can('style_delete')
                                            <a href="javascript:void(0)" class="btn btn-xs btn-danger delstyle"><i
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
            $(".delstyle").click(function(event) {
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
                            url: "{{ url('admin/product-style-customization') }}/"+id,
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
