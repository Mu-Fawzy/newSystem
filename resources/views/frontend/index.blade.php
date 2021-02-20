@extends('layouts.frontend.master')
@section('title', 'Subcontractors')
@section('css')
<!--Internal   Notify -->
<link href="{{URL::asset('assets/dashboard/assets/plugins/notify/css/notifIt.css')}}" rel="stylesheet"/>
<!--- Internal Sweet-Alert css-->
<link href="{{URL::asset('assets/dashboard/assets/plugins/sweet-alert/sweetalert.css')}}" rel="stylesheet">

@endsection
@section('page-header')
@endsection
@section('content')
				<!--Row-->
				<div class="row row-sm mt-3">
					<div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 grid-margin">
						<div class="card">
							<div class="card-header pb-0">
								<div class="d-flex justify-content-between">
									<h1 class="card-title mb-0">
										@isset($archive)
											@if ($archive == true)
												Contractors Archive
											@else
												@if (isset(request()->search))
													@if ($contracts->total() > 0)
														<b>There are {{ $contracts->total() }} results found for ({{ request()->search }})</b>
													@else
														<b>Sorry, no results found</b>
													@endif
												@else
													Contractors Table
												@endif
											@endif
										@endisset
									</h1>
									<div>
										
										@isset($archive)
											@if ($archive == true)
												<a href="{{ route('home.page') }}" class="btn btn-outline-info btn-sm ml-2"><i class="mdi mdi-home ml-1"></i>All Contracts</a>
											@else
												@can(__('content.contract-archive'))
													@isset($countDeletedContracts)
														@if ($countDeletedContracts->count() >= 1)
															<a href="{{ route('home.archive') }}" class="btn btn-outline-warning btn-sm"><i class="mdi mdi-delete ml-1"></i>Archive</a>
														@endif
													@endisset
												@endcan

												@can(__('content.contract-create'))
													<a href="{{ route('contracts.create') }}" class="btn btn-outline-primary btn-sm ml-2"><i class="mdi mdi-plus ml-1"></i>New Contract</a>
												@endcan
											@endif
										@endisset
										
									</div>
								</div>
							</div>
							<div class="card-body">
								<div class="table-responsive border-top userlist-table">
									<table class="table card-table table-striped table-vcenter text-nowrap mb-0">
										<thead>
											<tr>
												<th class="wd-lg-20p"><span>ID</span></th>
												<th class="wd-lg-20p"><span>Contract Number</span></th>
												<th class="wd-lg-20p"><span>Subcontractor</span></th>
												<th class="wd-lg-20p"><span>workitem_id</span></th>
												<th class="wd-lg-20p"><span>worksite_id</span></th>
												<th class="wd-lg-20p"><span>Contract</span></th>
												<th class="wd-lg-20p"><span>Invoices</span></th>

												@isset($archive)
													@if ($archive == true)
														@if (auth()->user()->hasAllPermissions([__('content.contract-restore'), __('content.contract-archive')]) || 
														auth()->user()->can(__('content.contract-delete')))
															<th class="wd-lg-20p">Action</th>
														@endif
													@else
														@if (auth()->user()->can(__('content.contract-update')) || 
														auth()->user()->can(__('content.contract-delete')) || 
														auth()->user()->can(__('content.contract-move-to-archive')))
															<th class="wd-lg-20p">Action</th>
														@endif
													@endif
												@endisset
											</tr>
										</thead>
										<tbody>
											@forelse ($contracts as $contract)
												<tr>
													<th>{{ $loop->iteration }}</th>
													<td class="text-primary">{{ $contract->contract_number }}</td>
													<td>{{ $contract->subcontactor->name }}</td>
													<td>{{ $contract->workitem->name }}</td>
													<td>{{ $contract->worksite->name }}</td>
													<td>
														@if ($contract->contract != null)
															<a href="{{ route('open.file',['contracts',$contract->contract->name]) }}" target="_blank">{{ $contract->contract->origin_name }}</a>
														@else
															No Contract
														@endif
													</td>
													<td>
														@forelse ($contract->attachinvoices as $invoice)
															<a href="{{ route('open.file',['invoices',$invoice->name]) }}" target="_blank">{{ $invoice->origin_name }}</a> @if (!$loop->last)-@endif
														@empty
															No Invoice Yet
														@endforelse
													</td>

													@if (auth()->user()->hasAllPermissions([__('content.contract-restore'), __('content.contract-archive')]) || 
													auth()->user()->can(__('content.contract-update')) || 
													auth()->user()->can(__('content.contract-delete')) || 
													auth()->user()->can(__('content.contract-move-to-archive')))
													<td>
														@if (!$contract->trashed())
															@can(__('content.contract-update'))
																<a href="{{ route('contracts.edit', $contract->id) }}" title="Edit" class="btn btn-sm btn-primary" data-placement="right" data-toggle="tooltip-primary">
																	<i class="las la-edit"></i>
																</a>
															@endcan
														@endif

														@can(__('content.contract-delete'))
															<a href="#" title="Delete" class="btn btn-sm btn-danger swal-warning" data-placement="right" data-toggle="tooltip"><i class="las la-trash"></i></a>
															<form action="{{ route('contracts.deleteForEver',$contract->id) }}" method="post" class="d-none">
																@csrf
																@method('DELETE')
															</form>
														@endcan

														@if (!$contract->trashed())
															@can(__('content.contract-move-to-archive'))
																<a href="#" title="Archive" class="btn btn-sm btn-warning swal-warning" data-placement="right" data-toggle="tooltip-primary"><i class="las la-file-archive"></i></a>
																<form action="{{ route('contracts.destroy',$contract->id) }}" method="post" class="d-none">
																	@csrf
																	@method('DELETE')
																</form>
															@endcan
														@endif

														@if (auth()->user()->hasAllPermissions([__('content.contract-restore'), __('content.contract-archive')]))
															@if ($contract->trashed())
																<a href="{{ route('home.restore',$contract->id) }}" title="Restore" class="btn btn-sm btn-success" data-placement="right" data-toggle="tooltip"><i class="las la-trash-restore"></i></a>
															@endif
														@endif
													</td>
													@endif
												</tr>
											@empty
												<tr>
													<th class="text-center" colspan="10">Sorry, no results found for <b>{{ request()->search }}</b>.</th>
												</tr>
											@endforelse
											
										</tbody>
									</table>
								</div>
								{!! $contracts->appends( request()->query() )->links('dashboard.paginations.pagination') !!}
								
							</div>
						</div>
					</div><!-- COL END -->
				</div>
				<!-- row closed  -->
			</div>
			<!-- Container closed -->
		</div>
		<!-- main-content closed -->
@endsection
@section('js')
<!--Internal  Datepicker js -->
<script src="{{URL::asset('assets/dashboard/assets/plugins/jquery-ui/ui/widgets/datepicker.js')}}"></script>
<!-- Internal Select2 js-->
<script src="{{URL::asset('assets/dashboard/assets/plugins/select2/js/select2.min.js')}}"></script>
<!--Internal  Notify js -->
<script src="{{URL::asset('assets/dashboard/assets/plugins/notify/js/notifIt.js')}}"></script>
<script src="{{URL::asset('assets/dashboard/assets/plugins/notify/js/notifit-custom.js')}}"></script>
<!--Internal  Sweet-Alert js-->
<script src="{{URL::asset('assets/dashboard/assets/plugins/sweet-alert/sweetalert.min.js')}}"></script>

@if (session('success'))
	<script>
		function not7() {
			notif({
				msg: "{{ session('success') }}",
				type: "success"
			});
		}
		not7();
	</script>
@endif
<script>
	$('a.swal-warning').each(function(){
		$(this).on('click',function(e){
			//e.preventDefault();
			
			var current_object = $(this),
				title = current_object.attr("data-original-title");
				text = "";

				if(title == "Delete"){
					text = "This Contract will delete forever!";
				} else {
					text = "This Contract will move to archive!";
				}
			swal({
				title: "Are you sure?",
				text: text,
				type: "warning",
				showCancelButton: true,
				confirmButtonText: "Yes, "+title+" it!",
				closeOnConfirm: false
			},
			function(isConfirm) {
				if (isConfirm) {
					current_object.next().submit();
				}
			});
		})
	});
</script>
@endsection