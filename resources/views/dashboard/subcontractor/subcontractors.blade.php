@extends('layouts.dashboard.master')
@section('title', isset($trash) && $trash == true ? __('content.subcontractors trash') : __('content.list',['model'=>trans_choice('content.subcontractor',2)]))
	
@section('css')
<!--Internal   Notify -->
<link href="{{URL::asset('assets/dashboard/assets/plugins/notify/css/notifIt.css')}}" rel="stylesheet"/>
@endsection
@section('page-header')
				<!-- breadcrumb -->
				<div class="breadcrumb-header justify-content-between">
					<div class="my-auto">
						<div class="d-flex">
							<h4 class="content-title mb-0 my-auto">{{ trans_choice('content.subcontractor',2) }}</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ 
								@isset($trash) @if ($trash == true) {{ __('content.subcontractors trash') }} @else {{ __('content.list',['model'=>trans_choice('content.subcontractor',2)]) }} @endif @endisset</span>
						</div>
					</div>
					<div class="d-flex my-xl-auto right-content">
						<div class="pr-1 mb-3 mb-xl-0">
							@isset($trash)
								@if ($trash == false)
									@can(__('content.subcontractor-trashed'))
										@isset($countDeletedSubContracts)
											@if ($countDeletedSubContracts->count() > 0)
												<a href="{{ route('subcontractors.trashed') }}" class="btn btn-danger ml-2"><i class="mdi mdi-delete ml-1"></i>{{ __('content.subcontractors trash') }}</a>
											@endif
										@endisset
									@endcan

									@can(__('content.subcontractor-create'))
										<a href="{{ route('subcontractors.create') }}" class="btn btn-success ml-2"><i class="mdi mdi-plus ml-1"></i>{{ __('sidebar.add new') }}</a>
									@endcan
								@endif
								
							@endisset
						</div>
						
						<div class="mb-3 mb-xl-0">
							<div class="btn-group dropdown">
								<button type="button" class="btn btn-primary">{{ carbon\Carbon::now()->translatedFormat('d M Y') }}</button>
								@isset($trash)
									@if ($trash == false)
										<button type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split" id="dropdownMenuDate" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
										<span class="sr-only">Toggle Dropdown</span>
										</button>
										<div class="dropdown-menu dropdown-menu-left" aria-labelledby="dropdownMenuDate" data-x-placement="bottom-end">
											
											@forelse ($years as $item)
												<a class="dropdown-item" href="{{ route('subcontractors.index',['year'=>$item->year]) }}">{{ $item->year }}</a>
											@empty
												<a class="dropdown-item" href="#">{{ __('content.no items yet', ['model'=>removeLettersFromStart(trans_choice('content.subcontractor',1)  ,2 ,null)]) }}</a>
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
									<h4 class="card-title mb-2">{{ __('content.table',['model'=>trans_choice('content.subcontractor',2)]) }}</h4>
									@isset($trash)
										@if ($trash == true)
											<a href="{{ route('subcontractors.index') }}" class="btn-info btn-icon"><i class="la la-arrow-left"></i></a>
										@endif
									@endisset
								</div>
							</div>
							<div class="card-body">
								<div class="table-responsive border-top userlist-table">
									<table class="table card-table table-striped table-vcenter text-nowrap mb-0">
										<thead>
											<tr>
												<th class="wd-lg-8p"><span>#</span></th>
												<th class="wd-lg-20p"><span>{{ __('validation.attributes.name') }}</span></th>
												<th class="wd-lg-20p"><span>{{ __('validation.attributes.phone') }}</span></th>
												<th class="wd-lg-20p"><span>{{ __('validation.attributes.address') }}</span></th>
												<th class="wd-lg-20p"><span>{{ __('content.status') }}</span></th>
												<th class="wd-lg-20p"><span>{{ __('content.creator') }}</span></th>
												<th class="wd-lg-20p"><span>{{ __('content.created at') }}</span></th>

												@isset($trash)
													@if ($trash == true)
														@if (auth()->user()->hasAllPermissions([__('content.subcontractor-restore'), __('content.subcontractor-trashed')]) || 
														auth()->user()->can(__('content.subcontractor-delete')))
															<th class="wd-lg-20p">{{ __('content.actions') }}</th>
														@endif
													@else
														@if (auth()->user()->can(__('content.subcontractor-edit')) || 
														auth()->user()->can(__('content.subcontractor-delete')))
															<th class="wd-lg-20p">{{ __('content.actions') }}</th>
														@endif
													@endif
												@endisset
											</tr>
										</thead>
										<tbody>
											@forelse ($subcontractors as $subcontractor)
												<tr>
													<td>{{ $loop->iteration }}</td>
													<td>{{ $subcontractor->name }}</td>
													<td>{{ $subcontractor->phone }}</td>
													<td>{{ $subcontractor->address }}</td>
													<td class="text-center">
														<span class="label text-{{ $subcontractor->status == 1 ? 'success' : 'muted' }} d-flex">
															<div class="dot-label bg-{{ $subcontractor->status == 1 ? 'success' : 'gray-300' }} ml-1"></div>
															{{ $subcontractor->statusSubcontractor() }}
														</span>
													</td>
													<td>{{ $subcontractor->user->name }}</td>
													<td>{{ $subcontractor->created_at }}</td>
													@if (
													auth()->user()->hasAllPermissions([__('content.subcontractor-restore'),__('content.subcontractor-delete'), __('content.subcontractor-trashed')]) || 
													auth()->user()->can(__('content.subcontractor-edit')) 
													)
													<td>
														@if ($subcontractor->trashed() == false)
															@can(__('content.subcontractor-edit'))
																<a href="{{ route('subcontractors.show', $subcontractor->id) }}" class="btn btn-sm btn-primary">
																	<i class="las la-search"></i>
																</a>
															@endcan
														@else
															@if (auth()->user()->hasAllPermissions([__('content.subcontractor-restore'), __('content.subcontractor-trashed')]))
																<a href="{{ route('restore.subcontractor', $subcontractor->id) }}" class="btn btn-sm btn-primary">
																	<i class="las la-trash-restore"></i>
																</a>
															@endif
														@endif

														@can(__('content.subcontractor-delete'))
															<a href="#" class="delete btn btn-sm btn-danger">
																<i class="las la-trash"></i>
															</a>
															<form action="{{ route('subcontractors.destroy',$subcontractor->id) }}" method="post" class="d-none">
																@csrf
																@method('DELETE')
															</form>
														@endcan
													</td>
													@endif
												</tr>
											@empty
												<tr>
													<th class="text-center" colspan="8">{{ __('content.no items yet', ['model'=>removeLettersFromStart(trans_choice('content.subcontractor',1)  ,2 ,null)]) }}</th>
												</tr>
											@endforelse
											
										</tbody>
									</table>
								</div>
								{!! $subcontractors->appends( request()->query() )->links('dashboard.paginations.pagination') !!}
								
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
	$('a.delete').on('click',function(e){
		e.preventDefault();
		$(this).next().submit();
	})
</script>
@endsection