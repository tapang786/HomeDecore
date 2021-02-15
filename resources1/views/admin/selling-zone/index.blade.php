@extends('layouts.admin')
@section('title', $title)
@section('content')
    <!-- /Row -->
    <div class="card">
        <div class="card-header">
          <div class="card-body">
            @can('zone_create')
            <form action="{{ route('admin.selling-zone.store') }}" method="post" class="p-2 ">
                @csrf
                <h5>{{ $title }}</h5>
                @if(session('msg'))
                <p class="p-1 alert-success text-dark text-center">{{ session('msg') }}</p>
               @endif
            <div class="row border-light">
               <div class="col-sm-4 form-group">
                 <label>Country</label>
                   <select class="form-control country" name="country" required="">
                       <option value="{{ isset($edzone->getCountry['id'])?$edzone->getCountry['id']:'' }}">{{ isset($edzone->getCountry['name'])?$edzone->getCountry['name']:'Select Country' }}</option>
                       @isset($country)
                         @foreach($country as $ct)
                           <option value="{{ $ct->id }}">{{ $ct->name }}</option>
                         @endforeach
                       @endisset
                   </select>
               </div>
                <div class="col-sm-4 form-group">
                 <label>State</label>
                     <select class="form-control state" name="state" required="">
                        <option value="{{ isset($edzone->getState['id'])?$edzone->getState['id']:'' }}">{{ isset($edzone->getState['name'])?$edzone->getState['name']:'' }}</option>
                     </select>
               </div>
                <div class="col-sm-4 form-group">
                 <label>City</label>
                     <select class="form-control city" name="city" required="">
                         <option value="{{ isset($edzone->getCity['id'])?$edzone->getCity['id']:'' }}">{{ isset($edzone->getCity['name'])?$edzone->getCity['name']:'' }}</option>
                     </select>
               </div>
               <div class="col-sm-4 form-group">
                 <label>Postal Code</label>
                     <input type="text" name="pincode" required="" class="form-control" value="{{ isset($edzone->postal_code)?$edzone->postal_code:'' }}">
               </div>
               <div class="col-sm-4 form-group">
                <label>Shipping Charge</label>
                    <input type="text" name="ship" required="" class="form-control" value="{{ isset($edzone->shipping_charge)?$edzone->shipping_charge:'' }}">
                       <input type="hidden" name="id"  value="{{ isset($edzone->id)?$edzone->id:'' }}">
              </div>
                <div class="col-sm-4 form-group text-center">
                   <button class="btn btn-primary btn-sm">Add & Update</button>
               </div>
              </div>
             </form>
             @endcan<br>
            <div class="table-responsive">
                <table class=" table table-striped table-hover datatable datatable-User" id="example">
                    <thead>
                        <tr>
                            <th>Selling Countries</th>
                            <th>Selling States</th>
                            <th>Selling Cities</th>
                            <th>Selling postal code</th>
                            <th>Shipping Charge</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody class="c">
                        @isset($zone)
                            <?php $i = 0; ?>
                            @foreach ($zone as $item)
                                <tr id='{{ $item->id }}'>
                                    <td>{{ Str::ucfirst($item->getCountry['name']) }}</td>
                                    <td>{{ Str::ucfirst($item->getState['name']) }}</td>
                                    <td>{{ Str::ucfirst($item->getCity['name']) }}</td>
                                    <td>{{ Str::ucfirst($item->postal_code) }}</td>
                                     <td>{{ Str::ucfirst($item->shipping_charge) }}</td>
                                    <td>
                                        @if ($item->status == 1)
                                            <button class="btn btn-success btn-xs edit btn-rounded">Active</button>
                                    </td>
                                @else
                                    <button class="btn btn-danger btn-xs edit btn-rounded">De-active</button></td>
                            @endisset
                            <td>
                                @can('zone_edit')
                                    <a class="btn btn-xs btn-info " href="{{ route('admin.selling-zone.edit',$item->id) }}">
                                        <i class="far fa-edit"></i>
                                    </a>
                                @endcan
                                @can('zone_delete')
                                    <a href="javascript:void(0)" class="btn btn-xs btn-danger delzone"><i
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
            $(".delzone").click(function(event) {
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
                            url: "{{ url('admin/selling-zone') }}/"+id,
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
    $(document).on('change','.country', function(event) {
            var id=$(this).val();
            $.get('{{ url("admin/get-state") }}/'+id, function(data) {
                var d=$.parseJSON(data);
                var option="<option value=''>Select State</option>";
                $.each(d, function(index, val) {
                    option +='<option value="'+val.id+'">'+val.name+'</option>'
                });
                $(".state").html(option)
            });
            
        });
</script>

<script type="text/javascript">

        $(document).on('change','.state', function(event) {
            var id=$(this).val();
            $.get('{{ url("admin/get-city") }}/'+id, function(data) {
                var d=$.parseJSON(data);
                var option="<option value=''>Select City</option>";
                $.each(d, function(index, val) {
                    option +='<option value="'+val.id+'">'+val.name+'</option>'
                });
                $(".city").html(option)
            });
            
        });

</script>
    @endpush
@endsection
