@extends('layouts.dashboard.master')
@section('title', __('content.list',['model'=>trans_choice('content.work item',2)]))
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
							<h4 class="content-title mb-0 my-auto">{{ trans_choice('content.work item',2) }}</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ {{ __('content.list',['model'=>trans_choice('content.work item',2)]) }}</span>
						</div>
					</div>
					<div class="d-flex my-xl-auto right-content">
						
						@can(__('content.work-create'))
							<div class="pr-1 mb-3 mb-xl-0">
								<a href="{{ route('workitems.create') }}" class="btn btn-success ml-2"><i class="mdi mdi-plus ml-1"></i>{{ __('sidebar.add new') }}</a>
							</div>
						@endcan
						
						<div class="mb-3 mb-xl-0">
							<div class="btn-group dropdown">
								<button type="button" class="btn btn-primary">{{ carbon\Carbon::now()->translatedFormat('d M Y') }}</button>
								@isset($years)
									@if($years->count() > 0)
										<button type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split" id="dropdownMenuDate" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
										<span class="sr-only">Toggle Dropdown</span>
										</button>
										<div class="dropdown-menu dropdown-menu-{{ Config::get('app.locale') == 'ar' ? 'left' : 'right' }}" aria-labelledby="dropdownMenuDate" data-x-placement="bottom-end">
											@forelse ($years as $item)
												<a class="dropdown-item" href="{{ route('workitems.index',['year'=>$item->year]) }}">{{ $item->year }}</a>
											@empty
												<a class="dropdown-item" href="#">{{ __('content.no items yet',['model'=>trans_choice('content.work item',2)]) }}</a>	
											@endforelse
										</div>
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
									<h4 class="card-title mb-2">
										@if (isset(request()->search))
											@if ($workitems->total() > 0)
												<b>{!! __('content.there are (n) results found for (s)', ['number'=>$workitems->total(),'search'=> "(".request()->search.")"]) !!}</b>
											@else
												<b>{{ __('content.sorry, no results found') }}</b>
											@endif
										@else
											{{ __('content.table',['model'=>trans_choice('content.work item',2)]) }}
										@endif
									</h4>
									<i class="mdi mdi-dots-horizontal text-gray"></i>
								</div>
							</div>
							<div class="card-body">
								<div class="table-responsive border-top userlist-table">
									<table class="table card-table table-striped table-vcenter text-nowrap mb-0">
										<thead>
											<tr>
												<th class="wd-lg-8p"><span>#</span></th>
												<th class="wd-lg-20p"><span>{{ __('content.name',['model'=>trans_choice('content.work item',1) ]) }}</span></th>
												<th class="wd-lg-20p"><span>{{ __('content.creator') }}</span></th>
												<th class="wd-lg-20p"><span>{{ __('content.created at') }}</span></th>
												<th class="wd-lg-20p">{{ __('content.actions') }}</th>
											</tr>
										</thead>
										<tbody>
											@forelse ($workitems as $workitem)
												<tr>
													<td>{{ $loop->iteration }}</td>
													<td>{{ $workitem->name }}</td>
													<td>{{ $workitem->user->name }}</td>
													<td>{{ $workitem->created_at }}</td>
													<td>
														@can(__('content.work-update'))
															<a href="{{ route('workitems.edit', $workitem->id) }}" class="btn btn-sm btn-info"><i class="las la-pen"></i></a>
														@else
															<a href="javascript:;" class="delete btn btn-sm btn-secondary disabled"><i class="las la-pen"></i></a>
														@endcan

														@can(__('content.work-delete'))
															<a href="#" title="{{ __('content.delete') }}" data-action="Delete" class="btn btn-sm btn-danger swal-warning" data-placement="right" data-toggle="tooltip">
																<i class="las la-trash"></i>
															</a>
															<form action="{{ route('workitems.destroy',$workitem->id) }}" method="post" class="d-none">
																@csrf
																@method('DELETE')
															</form>
														@else
															<a href="#" class="delete btn btn-sm btn-secondary disabled"><i class="las la-trash"></i></a>
														@endcan
													</td>
												</tr>
											@empty
												<tr>
													<th class="text-center" colspan="8">
														@if (isset(request()->search) != null) 
														{!! __('content.sorry no results found for', ['search'=> "<b>".request()->search."</b>."]) !!} 
														@else
															@isset ($subcontractorWorkitems)
																{{ trans_choice('content.subcontractor',1) }} <a href="{{ route('subcontractors.show',$subcontractor->id) }}">{{ $subcontractor->name }}</a> - {{ __('content.no items yet',['model'=> removeLettersFromStart(trans_choice('content.work item',2), 0 ,5)]) }}
															@else
																{{ __('content.no items yet',['model'=>trans_choice('content.work item',2)]) }} 
															@endisset
															<a href="{{ route('workitems.create') }}">{{  __('content.create now') }}</a>
														@endif
													</th>
												</tr>
											@endforelse
											
										</tbody>
									</table>
								</div>
								{!! $workitems->appends( request()->query() )->links('dashboard.paginations.pagination') !!}
								
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
				_action = current_object.data("action");
				text = "";
				
				if(_action == "Delete"){
					text = "{{ __('content.delete forever') }}";
				}

			

			swal({
				title: "{{ __('content.are you sure?') }}",
				text: text,
				type: "error",
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