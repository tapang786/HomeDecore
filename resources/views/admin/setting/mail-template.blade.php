@extends('layouts.admin')
@section('content')

<div class="card">
 
<div class="card-body">
<div class="panel panel-default card-view">
  <a href="{{ route('admin.mail-template.create') }}" class="btn btn-success btn-xs">Add Mail Template</a>
<div class="panel-wrapper ">
<div class="panel-body">
<div class="form-wrap">
<div class="row" >
  <br>
<table  class="table table-hover  " id="example" style="width:100% !important;overflow:scroll;">
  <thead style="background: #FFAC32">
    <tr class="text-sm-left">
      <th>Message For</th>
      <th>Name</th>
      <th>Subject</th>
      <th>From</th>
      <th>Reply From</th>
            <th>Message Categories</th>
            <th>Messages</th>
      <th>Action</th>
    </tr>
  </thead>
  <tbody class="c" id="attrvdata">
    @isset($msg)
         <?php $i=0; ?>
    @foreach($msg as $item)
    <tr id='{{ $item['id'] }}'>
          <td>{{ Str::ucfirst($item->status) }}</td>
              <td>{{ Str::ucfirst($item->name) }}</td>
                <td>{{ Str::ucfirst($item->subject) }}</td>
                  <td> {{ $item->from_email }}</td>
                  <td> {{ $item->reply_email }}</td>
                    <td> {{ $item->msg_cat }}</td>
                      <td style="max-width:200px;overflow-x:auto;"> {!! $item->message!!}</td>

      <td>
 <div class="dropdown">
  <a class=" dropdown-toggle" type="button" data-toggle="dropdown" href="javascript:void(0)"><i class="fa fa-tasks" aria-hidden="true"></i></a>
  <ul class="dropdown-menu">
    <li><a href="{{ route('admin.mail-template.edit',$item->id) }}"><i class="fa fa-pencil" aria-hidden="true"></i></a></li>
    <li><a href="javascript:void(0)" id="delMsg"><i class="fa fa-trash"></i></a></li>
  </ul>
</div>
</td>
</tr>
    @endforeach
        @endisset

  </tbody>
</table>
</div>
</div>
</div>
</div>
</div>
</div>
</div>

@push('ajax-script')
<script type="text/javascript">
  $(document).ready(function() {
    $(document).on('click', "#delMsg", function(event) {
      let id=$(this).parents('tr').attr('id');
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
      url: "{{ url('admin/mail-template') }}/"+id,
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
  });
</script>
@endpush
@endsection
