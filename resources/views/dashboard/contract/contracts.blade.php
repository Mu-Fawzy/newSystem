@extends('layouts.dashboard.master')
@section('title', isset($archive) && $archive == true ? __('content.trash',['model'=>trans_choice('content.contract',2)]) : __('content.list',['model'=>trans_choice('content.contract',2)]))
@section('css')
<!--Internal   Notify -->
<link href="{{URL::asset('assets/dashboard/assets/plugins/notify/css/notifIt.css')}}" rel="stylesheet"/>
<!--- Internal Sweet-Alert css-->
<link href="{{URL::asset('assets/dashboard/assets/plugins/sweet-alert/sweetalert.css')}}" rel="stylesheet">

@endsection
@section('page-header')
	<!-- breadcrumb -->
	<div class="breadcrumb-header justify-content-between">
		<div class="my-auto">
			<div class="d-flex">
				<h4 class="content-title mb-0 my-auto">{{ trans_choice('content.contract',2) }}</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ @isset($archive) @if ($archive == true) {{ __('content.trash',['model'=>trans_choice('content.contract',2)]) }} @else {{ __('content.list',['model'=>trans_choice('content.contract',2)]) }} @endif @endisset</span>
			</div>
		</div>
		<div class="d-flex my-xl-auto right-content">
			<div class="pr-1 mb-3 mb-xl-0">
				@isset($archive)
					@if ($archive == false)
						@can(__('content.contract-archive'))
							@isset($countDeletedContracts)
								@if ($countDeletedContracts->count() > 0)
									<a href="{{ route('contracts.archive') }}" class="btn btn-danger ml-2"><i class="mdi mdi-delete ml-1"></i>{{ __('content.archive') }}</a>
								@endif
							@endisset
						@endcan
						@can(__('content.contract-create'))
							<a href="{{ route('contracts.create') }}" class="btn btn-success ml-2"><i class="mdi mdi-plus ml-1"></i>{{ __('sidebar.add new') }}</a>
						@endcan
					@endif
				@endisset
			</div>
			
			<div class="mb-3 mb-xl-0">
				<div class="btn-group dropdown">
					<button type="button" class="btn btn-primary">{{ carbon\Carbon::now()->translatedFormat('d M Y') }}</button>
					@isset($years)
						@if($years->count() > 0)
							@if (isset($archive) && $archive == false)
								<button type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split" id="dropdownMenuDate" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								<span class="sr-only">Toggle Dropdown</span>
								</button>
								<div class="dropdown-menu dropdown-menu-left" aria-labelledby="dropdownMenuDate" data-x-placement="bottom-end">
									@forelse ($years as $item)
										<a class="dropdown-item" href="{{ route('contracts.index',['year'=>$item->year]) }}">{{ $item->year }}</a>
									@empty
										<a class="dropdown-item" href="#">{{ __('content.no items yet',['model'=>trans_choice('content.contract',1)]) }}</a>	
									@endforelse
								</div>
							@endif
						@endif
					@endisset
				</div>
			</div>
		</div>
	</div>
	<!-- breadcrumb -->
@endsection
@section('content')
				<!--Row-->
				<div class="row row-sm">
					<div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 grid-margin">
						<div class="card">
							<div class="card-header pb-0">
								<div class="d-flex justify-content-between">
									<h4 class="card-title mb-2">{{ __('content.table',['model'=>trans_choice('content.contract',2)]) }}</h4>
									@isset($archive)
										@if ($archive == true)
										<a href="{{ route('contracts.index') }}" class="btn-info btn-icon"><i class="la la-arrow-left"></i></a>
										@endif
									@endisset
								</div>
							</div>
							<div class="card-body">
								<div class="table-responsive border-top userlist-table">
									<table class="table card-table table-striped table-vcenter text-nowrap mb-0">
										<thead>
											<tr>
												<th class="wd-lg-20p"><span>#</span></th>
												<th class="wd-lg-20p"><span>{{ __('content.contract number') }}</span></th>
												<th class="wd-lg-20p"><span>{{ trans_choice('content.subcontractor',1) }}</span></th>
												<th class="wd-lg-20p"><span>{{ __('content.creator') }}</span></th>
												<th class="wd-lg-20p"><span>{{ trans_choice('content.work item',1) }}</span></th>
												<th class="wd-lg-20p"><span>{{ trans_choice('content.work site',1) }}</span></th>
												<th class="wd-lg-20p"><span>{{ __('content.created at') }}</span></th>
												<th class="wd-lg-20p"><span>{{ trans_choice('content.contract',1) }}</span></th>
												<th class="wd-lg-20p"><span>{{ trans_choice('content.invoice',2) }}</span></th>
												@isset($archive)
													@if ($archive == true)
														@if (auth()->user()->hasAllPermissions([__('content.contract-restore'), __('content.contract-archive')]) || 
														auth()->user()->can(__('content.contract-delete')))
															<th class="wd-lg-20p">{{ __('content.actions') }}</th>
														@endif
													@else
														@if (auth()->user()->can(__('content.contract-update')) || 
														auth()->user()->can(__('content.contract-delete')) || 
														auth()->user()->can(__('content.contract-move-to-archive')))
															<th class="wd-lg-20p">{{ __('content.actions') }}</th>
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
													<td>{{ $contract->user->name }}</td>
													<td>{{ $contract->workitem->name }}</td>
													<td>{{ $contract->worksite->name }}</td>
													<td>{{ $contract->created_at }}</td>
													<td>
														@if ($contract->contract != null)
															<a href="{{ route('open.file',['contracts',$contract->contract->name]) }}" target="_blank">{{ $contract->contract->origin_name }}</a>
														@else
															{{ __('content.no items yet',['model'=>trans_choice('content.contract',1)]) }}
														@endif
													</td>
													<td>
														@forelse ($contract->attachinvoices as $invoice)
															<a href="{{ route('open.file',['invoices',$invoice->name]) }}" target="_blank">{{ $invoice->origin_name }}</a> @if (!$loop->last)-@endif
														@empty
															{{ __('content.no items yet',['model'=>trans_choice('content.invoice',2)]) }}
														@endforelse
													</td>
													@if (auth()->user()->hasAllPermissions([__('content.contract-restore'), __('content.contract-archive')]) || 
													auth()->user()->can(__('content.contract-update')) || 
													auth()->user()->can(__('content.contract-move-to-archive')) || 
													auth()->user()->can(__('content.contract-move-to-archive')))
													<td>
														@if (!$contract->trashed())
														
															@can(__('content.contract-update'))
																<a href="{{ route('contracts.edit', $contract->id) }}" title="{{ __('content.edit') }}" class="btn btn-sm btn-primary" data-placement="right" data-toggle="tooltip-primary">
																	<i class="las la-edit"></i>
																</a>
															@endcan
														@endif

														@can(__('content.contract-delete'))
															<a href="#" title="{{ __('content.delete') }}" class="btn btn-sm btn-danger swal-warning" data-placement="right" data-toggle="tooltip"><i class="las la-trash"></i></a>
															<form action="{{ route('contracts.deleteForEver',$contract->id) }}" method="post" class="d-none">
																@csrf
																@method('DELETE')
															</form>
														@endcan
														@if (!$contract->trashed())
														
															@can(__('content.contract-move-to-archive'))
																<a href="#" title="{{ __('content.move to archive') }}" class="btn btn-sm btn-warning swal-warning" data-placement="right" data-toggle="tooltip-primary"><i class="las la-file-archive"></i></a>
																<form action="{{ route('contracts.destroy',$contract->id) }}" method="post" class="d-none">
																	@csrf
																	@method('DELETE')
																</form>
															@endcan
														@endif

														@if (auth()->user()->hasAllPermissions([__('content.contract-restore'), __('content.contract-archive')]))
															@if ($contract->trashed())
																<a href="{{ route('contracts.restore',$contract->id) }}" title="{{ __('content.restore') }}" class="btn btn-sm btn-success" data-placement="right" data-toggle="tooltip"><i class="las la-trash-restore"></i></a>
															@endif
														@endif
													</td>
													@endif
												</tr>
											@empty
												<tr>
													<th class="text-center" colspan="10">{{ __('content.no items yet',['model'=>trans_choice('content.contract',1)]) }}</th>
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
				type = "";

				if(title == "{{ __('content.delete') }}"){
					text = "{{ __('content.delete forever') }}";
					type = "error";
				} else {
					text = "{{ __('content.go to archive',['model'=>__('content.move to archive')]) }}";
					type = "warning";
				}
			swal({
				title: "{{ __('content.are you sure?') }}",
				text: text,
				type: type,
				showCancelButton: true,
				cancelButtonText: "{{ __('content.cancel') }}",
				confirmButtonText: "{{ __('content.Yes') }}",
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