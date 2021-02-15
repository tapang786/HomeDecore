@extends('layouts.admin')
@section('content')
<div class="content">
    <div class="row">
        {{-- <div class="col-lg-12">
            Home
        </div> --}}
        <?php //print_r($settings); ?>
        <div class="col-lg-3 col-md-6 cus_admin_card">
            <div class="card card-stats">
              <div class="card-body">
                <div class="row">
                  <div class="col-5">
                    <div class="info-icon text-center icon-warning">
                      	<i class="fas fa-box"></i>
                    </div>
                  </div>
                  <div class="col-7">
                    <div class="numbers">
                      <h3 class="card-category">+24%</h3>
                    </div>
                  </div>
                </div>
              </div>
              <div class="card-footer">
                <div class="stats">
                  	<h3>Total Product</h3>
                  	<h4>120050</h4>
                </div>
              </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 cus_admin_card">
            <div class="card card-stats">
              <div class="card-body">
                <div class="row">
                  <div class="col-5">
                    <div class="info-icon text-center icon-primary">
                      	<i class="fas fa-shopping-cart"></i>
                    </div>
                  </div>
                  <div class="col-7">
                    <div class="numbers">
                      <h3 class="card-category">+14%</h3>
                    </div>
                  </div>
                </div>
              </div>
              <div class="card-footer">
                <div class="stats">
                  <h3>Total Orders</h3>
                  <h4>120050</h4>
                </div>
              </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 cus_admin_card">
            <div class="card card-stats">
              <div class="card-body">
                <div class="row">
                  <div class="col-5">
                    <div class="info-icon text-center icon-success">
                      	<i class="fas fa-truck"></i>
                    </div>
                  </div>
                  <div class="col-7">
                    <div class="numbers">
                      <h3 class="card-category">+14%</h3>
                    </div>
                  </div>
                </div>
              </div>
              <div class="card-footer">
                <div class="stats">
                  	<h3>Orders Shipped</h3>
                  	<h4>120050</h4>
                </div>
              </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 cus_admin_card">
            <div class="card card-stats">
              <div class="card-body">
                <div class="row">
                  <div class="col-5">
                    <div class="info-icon text-center icon-danger">
                      	<i class="fas fa-user"></i>
                    </div>
                  </div>
                  <div class="col-7">
                    <div class="numbers">
                      <h3 class="card-category">+14%</h3>
                    </div>
                  </div>
                </div>
              </div>
              <div class="card-footer">
                <div class="stats">
                  	<h3>Total Users</h3>
                  	<h4>120050</h4>
                </div>
              </div>
            </div>
        </div>

    </div>
    <div class="row cus_admin_card recent_order">
    	<div class="card">
		    <div class="card-header ">
		        <div class="row">
		            <div class="col-sm-6">
		                <h4 class="card-title">Recent Orders</h4>
		            </div>
		        </div>
		    </div>

		    <div class="card-body">
		        <div class="table-responsive">
		            <table class="table table-striped table-hover datatable datatable-User">
		                <thead>
		                    <tr>
		                    	<th></th>
		                        <th>Order ID</th>
		                        <th>Order Date</th>
		                        <th>Order Status</th>
		                        <th>Action</th>
		                    </tr>
		                </thead>
		                <tbody>
		                @isset($order)
                        	@php $i=1; @endphp
                        	@foreach($order as $item)
		                        <tr id='{{ $item->order_id }}'>
		                          	<td></td>
		                          	<td>#{{ $item->order_id }}</td>
		                          	<td>{{ \Carbon\Carbon::parse($item->order_date)->format('d/M/20y') }}</td>
		                          	<td>@if($item->status=="new")
		                            	<a href="javascript:void(0)" class="badge badge-success">{{ $item->status }}</a>
		                            	@elseif($item->status=="return")
		                             	<a href="javascript:void(0)" class="badge badge-warning ">{{ $item->status }}</a>
		                              	@elseif($item->status=="cancel")
		                             	<a href="javascript:void(0)" class="badge badge-danger ">{{ $item->status }}</a>
		                               @else
		                             	<a href="javascript:void(0)" class="badge badge-primary ">{{ $item->status }}</a>
		                             	@endif
		                          	</td>
		                          	<td>
			                            @can('order_show')
			                                <a class="" href="{{ route('admin.order.show',$item->id) }}">
			                                     <i class="far fa-eye"></i>
			                                </a>
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

    </div>
</div>

@endsection
@section('scripts')
<script>
    $(function () {

	  	let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons);

	  	let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
	  	let deleteButton = {
	    	text: deleteButtonTrans,
	    	url: "{{ route('admin.users.massDestroy') }}",
	    	className: 'btn-danger',
    		action: function (e, dt, node, config) {
      			var ids = $.map(dt.rows({ selected: true }).nodes(), function (entry) {
          			return $(entry).data('entry-id')
      			});

				if (ids.length === 0) {
					alert('{{ trans('global.datatables.zero_selected') }}')
					return;
				}

			    if (confirm('{{ trans('global.areYouSure') }}')) {
			        $.ajax({
			          	headers: {'x-csrf-token': _token},
			          	method: 'POST',
			          	url: config.url,
			          	data: { ids: ids, _method: 'DELETE' }
			        })
			        .done(function () { location.reload() });
			    }
    		}
  		};
  		//dtButtons.push(deleteButton);
  		dtButtons.pop('colvis');
  		dtButtons.pop('print');

		$.extend(true, $.fn.dataTable.defaults, {
		    order: [[ 1, 'desc' ]],
		    pageLength: 10,	
		    className: 'select-checkbox',
		    "lengthChange": false,
		    "bPaginate": false,
		});
	  	$('.datatable-User:not(.ajaxTable)').DataTable({ buttons: dtButtons });
	    $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
	        $($.fn.dataTable.tables(true)).DataTable()
	            .columns.adjust();
	    });
	});

</script>
@parent

@endsection

