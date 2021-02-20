@extends('layouts.dashboard.master')
@section('title', __('content.list',['model'=>trans_choice('content.role',2)]))
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
							<h4 class="content-title mb-0 my-auto">{{ trans_choice('content.role',2) }}</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ {{ __('content.list',['model'=>trans_choice('content.role',2)]) }}</span>
						</div>
					</div>
					<div class="d-flex my-xl-auto right-content">
						@can(__('content.role-create'))
							<div class="pr-1 mb-3 mb-xl-0">
								<a href="{{ route('roles.create') }}" class="btn btn-success ml-2"><i class="mdi mdi-plus ml-1"></i>{{ __('sidebar.add new') }}</a>
							</div>
						@endcan
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
											@if ($roles->total() > 0)
												<b>{!! __('content.there are (n) results found for (s)', ['number'=>$roles->total(),'search'=> "(".request()->search.")"]) !!}</b>
											@else
												<b>{{ __('content.sorry, no results found') }}</b>
											@endif
										@else
											{{ __('content.table',['model'=>trans_choice('content.role',2)]) }}
										@endif
									</h4>
									<i class="mdi mdi-dots-horizontal text-gray"></i>
								</div>
							</div>
							<div class="card-body">

								<div class="table-responsive">
									<table class="table mg-b-0 text-md-nowrap">
										<thead>
											<tr>
												<th><span>#</span></th>
												<th><span>{{ __('content.name',['model'=>trans_choice('content.role',1)]) }}</span></th>
												<th>{{ __('content.actions') }}</th>
											</tr>
										</thead>
										<tbody>
											@can(__('content.role-list'))
												@forelse ($roles as $role)
													<tr>
														<td>{{ $loop->iteration }}</td>
														<td>{{ $role->name }}</td>
														<td>
															<div class="btn-icon-list">
																@can(__('content.role-show'))
																	<a class="btn btn-info btn-icon" href="{{ route('roles.show',$role->id) }}"><i class="typcn typcn typcn-folder-open"></i></a>
																@else
																	<a class="btn btn-secondary btn-icon disabled" href="javascript:;"><i class="typcn typcn typcn-folder-open"></i></a>
																@endcan

																@can(__('content.role-edit'))
																	<a class="btn btn-primary btn-icon" href="{{ route('roles.edit',$role->id) }}"><i class="typcn typcn-edit"></i></a>
																@else
																	<a class="btn btn-secondary btn-icon disabled" href="javascript:;"><i class="typcn typcn-edit"></i></a>
																@endcan

																@can(__('content.role-delete'))
																	<a class="btn btn-danger btn-icon swal-warning" href="#" data-action="Delete"><i class="typcn typcn-delete"></i></a>
																	<form action="{{ route('roles.destroy', $role->id) }}" method="POST" class="d-none">
																		@csrf
																		@method('DELETE')
																	</form>
																@else
																	<a class="btn btn-secondary btn-icon swal-warning disabled" href="javascript:;"><i class="typcn typcn-delete"></i></a>
																@endcan
															</div>	
														</td>
													</tr>
												@empty
													<tr>
														<th class="text-center" colspan="8">
															@if (isset(request()->search) != null) 
																{!! __('content.sorry no results found for', ['search'=> "<b>".request()->search."</b>."]) !!} 
															@else
																{{ __('content.no roles yet') }} <a href="{{ route('roles.create') }}">{{  __('content.create now') }}</a>
															@endif
														</th>
													</tr>
												@endforelse
											@else
												<tr>
													<th class="text-center" colspan="8">
														{{ __('content.you are not authorized to see the content') }}
													</th>
												</tr>
											@endcan
										</tbody>
									</table>
								</div>
								{!! $roles->appends( request()->query() )->links('dashboard.paginations.pagination') !!}
								
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
			e.preventDefault();
			
			var current_object = $(this),
				_action = current_object.data("action");
				text = "";
				
				if(_action == "Delete"){
					text = "{{ __('content.this role will delete forever!, and all users have this role will be not active') }}";
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