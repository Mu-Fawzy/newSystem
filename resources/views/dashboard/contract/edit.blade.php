@extends('layouts.dashboard.master')
@section('title', __('content.edit')." ".$contract->contract_number)
@section('css')
<!-- Internal Select2 css -->
<link href="{{URL::asset('assets/dashboard/assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet">
<!--Internal   Notify -->
<link href="{{URL::asset('assets/dashboard/assets/plugins/notify/css/notifIt.css')}}" rel="stylesheet"/>
<link href="{{URL::asset('assets/dashboard/assets/plugins/jquery-simple-datetimepicker/jquery.simple-dtpicker.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/dashboard/assets/plugins/pickerjs/picker.min.css')}}" rel="stylesheet">
<!---Internal Fileupload css-->
<link href="{{URL::asset('assets/dashboard/assets/plugins/fileuploads/css/fileupload.css')}}" rel="stylesheet" type="text/css"/>
<!--- Internal Sweet-Alert css-->
<link href="{{URL::asset('assets/dashboard/assets/plugins/sweet-alert/sweetalert.css')}}" rel="stylesheet">

@endsection
@section('page-header')
				<!-- breadcrumb -->
				<div class="breadcrumb-header justify-content-between">
					<div class="my-auto">
						<div class="d-flex">
							<h4 class="content-title mb-0 my-auto">{{ trans_choice('content.contract',2) }}</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ {{ __('content.edit')." ".$contract->contract_number }}</span>
						</div>
					</div>
					<div class="d-flex my-xl-auto right-content">
						<div class="pr-1 mb-3 mb-xl-0">
							@can(__('content.contract-create'))
								<a href="{{ route('contracts.create') }}" class="btn btn-success ml-2"><i class="mdi mdi-plus ml-1"></i>{{ __('sidebar.add new') }}</a>
							@endcan
						</div>
					</div>
				</div>
				<!-- breadcrumb -->
@endsection
@section('content')
				<!-- row -->
				<div class="row row-sm">
					<div class="col-lg-4">
						<div class="card mg-b-20">
							<div class="card-body">
								<div class="pl-0">
									<div class="main-profile-overview">
										<div class="d-flex justify-content-between mg-b-20">
											<div>
												<h5 class="main-profile-name">{{ __('content.edit')." ".$contract->contract_number }}</h5>
											</div>
											<div class="btn-icon-list">

												@can(__('content.contract-delete'))
													<a href="#" class=" btn-icon btn-danger swal-warning" data-placement="right" data-toggle="tooltip" title="{{ __('content.delete') }}"><i class="las la-trash"></i></a>
													<form action="{{ route('contracts.deleteForEver',$contract->id) }}" method="post" class="d-none">
														@csrf
														@method('DELETE')
													</form>
												@endcan

												@can(__('content.contract-move-to-archive'))
													<a href="#" class=" btn-icon btn-warning swal-warning" data-placement="right" data-toggle="tooltip-primary" title="{{ __('content.move to archive') }}"><i class="las la-file-archive"></i></a>
													<form action="{{ route('contracts.destroy',$contract->id) }}" method="post" class="d-none">
														@csrf
														@method('DELETE')
													</form>
												@endcan

												<a href="{{ route('contracts.index') }}" class="btn-info btn-icon"><i class="la la-arrow-left"></i></a>
											</div>
										</div>
										
										
										<div class="main-profile-bio">
											<form class="form-horizontal" action="{{ route('contracts.update', $contract->id) }}" method="Post" enctype="multipart/form-data">
												@csrf
												@method('PUT')
												<h6>{{ __('content.contract number') }}</h6>
												<div class="form-group">
													<input type="text" class="form-control" name="contract_number" placeholder="{{ __('content.contract number') }}" value="{{ $contract->contract_number }}">
													@error('contract_number')
														<div class="alert alert-danger mg-t-6" role="alert">
															<button aria-label="Close" class="close" data-dismiss="alert" type="button">
																<span aria-hidden="true">&times;</span>
															</button>
															{{ $message }}
														</div>
													@enderror
												</div>

												<h6>{{ __('content.subcontractor name') }}</h6>
												<div class="form-group">
													<input type="text" class="form-control" name="subcontractor_id" placeholder="{{ __('content.subcontractor name') }}" value="{{ $contract->subcontactor->name }}" disabled>
												</div>

												<h6>{{ __('content.select',['model'=>trans_choice('content.work site',1)]) }}</h6>
												@isset($worksites)
													@if ($worksites->count() > 0)
														<div class="form-group">
															<select class="form-control select2" name="worksite_id">
																<option label="Choose one"></option>
																@foreach ($worksites as $worksite)
																	<option {{ $contract->worksite->id == $worksite->id ? "selected" : "" }} value="{{ $worksite->id }}">{{ $worksite->name }}</option>
																@endforeach
															</select>
															@error('worksite_id')
																<div class="alert alert-danger mg-t-6" role="alert">
																	<button aria-label="Close" class="close" data-dismiss="alert" type="button">
																		<span aria-hidden="true">&times;</span>
																	</button>
																	{{ $message }}
																</div>
															@enderror
														</div>
													@endif
												@endisset

												<h6>{{ __('content.select',['model'=>trans_choice('content.work item',1)]) }}</h6>
												@isset($workitems)
													@if ($workitems->count() > 0)
														<div class="form-group">
															<select class="form-control select2" name="workitem_id">
																<option label="Choose one"></option>
																@foreach ($workitems as $workitem)
																	<option {{ $contract->workitem->id == $workitem->id ? "selected" : "" }} value="{{ $workitem->id }}">{{ $workitem->name }}</option>
																@endforeach
															</select>
															@error('workitem_id')
																<div class="alert alert-danger mg-t-6" role="alert">
																	<button aria-label="Close" class="close" data-dismiss="alert" type="button">
																		<span aria-hidden="true">&times;</span>
																	</button>
																	{{ $message }}
																</div>
															@enderror
														</div>
													@endif
												@endisset

												<div class="form-group mb-0 mt-3 justify-content-end">
													<div>
														<button type="submit" class="btn btn-primary">{{ __('content.update') }}</button>
													</div>
												</div>
											</form>
										</div>
									</div><!-- main-profile-overview -->
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-8">
						{{-- <div class="row row-sm">
							<div class="col-sm-12 col-xl-4 col-lg-12 col-md-12">
								<div class="card ">
									<div class="card-body">
										<div class="counter-status d-flex md-mb-0">
											<div class="counter-icon bg-primary-transparent">
												<i class="icon-layers text-primary"></i>
											</div>
											<div class="mr-auto">
												<h5 class="tx-13">Sites</h5>
												<h2 class="mb-0 tx-22 mb-1 mt-1">200</h2>
												<p class="text-muted mb-0 tx-11"><i class="si si-arrow-up-circle text-success mr-1"></i>increase</p>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="col-sm-12 col-xl-4 col-lg-12 col-md-12">
								<div class="card ">
									<div class="card-body">
										<div class="counter-status d-flex md-mb-0">
											<div class="counter-icon bg-danger-transparent">
												<i class="icon-paypal text-danger"></i>
											</div>
											<div class="mr-auto">
												<h5 class="tx-13">Work Items</h5>
												<h2 class="mb-0 tx-22 mb-1 mt-1">200</h2>
												<p class="text-muted mb-0 tx-11"><i class="si si-arrow-up-circle text-success mr-1"></i>increase</p>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="col-sm-12 col-xl-4 col-lg-12 col-md-12">
								<div class="card ">
									<div class="card-body">
										<div class="counter-status d-flex md-mb-0">
											<div class="counter-icon bg-success-transparent">
												<i class="icon-rocket text-success"></i>
											</div>
											<div class="mr-auto">
												<h5 class="tx-13">Product sold</h5>
												<h2 class="mb-0 tx-22 mb-1 mt-1">1,890</h2>
												<p class="text-muted mb-0 tx-11"><i class="si si-arrow-up-circle text-success mr-1"></i>increase</p>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div> --}}
						<div class="card">
							<div class="card-body">
								<div class="tabs-menu ">
									<!-- Tabs -->
									<ul class="nav nav-tabs profile navtab-custom panel-tabs">
										<li>
											<a href="#home" data-toggle="tab" aria-expanded="true" class="active"> <span class="visible-xs"><i class="las la-file-contract tx-16 mr-1"></i></span> <span class="hidden-xs">{{ trans_choice('content.contract',1) }}</span> </a>
										</li>
										<li class="">
											<a href="#attachs" data-toggle="tab" aria-expanded="false"> <span class="visible-xs"><i class="las la-images tx-15 mr-1"></i></span> <span class="hidden-xs">{{ trans_choice('content.invoice',2) }}</span> </a>
										</li>
									</ul>
								</div>
								<div class="tab-content border-left border-bottom border-right border-top-0 p-4">
									<div class="tab-pane active" id="home">
										<div class="row">
											<div class="col-sm-4">
												<h4 class="tx-15 text-uppercase mb-3">{{ trans_choice('content.contract',1) }}</h4>
												<div class="border p-1 card thumb">
													@if ($contract->contract != null)
														<img src="@if($contract->contract->extension != 'pdf'){{URL::asset($contract->contract->setPath($contract->contract->name))}}@else{{URL::asset('assets/images/contract.png')}}@endif" class="thumb-img" alt="{{ $contract->contract->remvoeExt($contract->contract->origin_name) }}" style="height: 200px; width: 177px;margin: 0 auto;">
														

														<h4 class="text-center tx-14 mt-3 mb-0">{{ $contract->contract->remvoeExt($contract->contract->origin_name) }}</h4>
														<div class="ga-border mb-2"></div>
														<div class="row row-xs">
															<div class="col-md-6">
																<a class="image-popup btn-sm btn btn-primary-gradient btn-block" href="{{ route('open.file',['contracts',$contract->contract->name]) }}" target="_blank">{{ __('content.showFile') }}</a>
															</div>
															<div class="col-md-6 mg-t-10 mg-sm-t-0">
																<a class="image-popup btn-sm btn btn-success-gradient btn-block" href="{{ route('download.file',['contracts',$contract->contract->name]) }}">{{ __('content.downloadFile') }}</a>
															</div>
															<div class="col-md-12 mg-t-5">
																<a href="#" title="{{ __('content.delete') }}" class="image-popup btn-sm btn btn-danger-gradient btn-block swal-warning">{{ __('content.delete') }}</a>
																<form action="{{ route('contract.files',[$contract->id,'contracts',$contract->contract->name]) }}" method="post" class="d-none">
																	@csrf
																</form>
															</div>
														
														</div>
													@endif
												</div>
											</div>
											<div class="col-lg-8">
												<h4 class="tx-15 text-uppercase mb-3">{{ __('content.upload or change contract',['model'=>trans_choice('content.contract',1)]) }}</h4>
												<form action="{{ route('update.contract',$contract->id) }}" method="POST" enctype="multipart/form-data">
													@csrf
													@method('POST')
													<div class="row row-sm mg-b-20">
														<div class="col-lg-12">
															<div class="form-group">
																<input type="file" name="contract" class="dropify" data-height="230" multiple/>
																@error('contract')
																	<div class="alert alert-danger mg-t-6" role="alert">
																		<button aria-label="Close" class="close" data-dismiss="alert" type="button">
																			<span aria-hidden="true">&times;</span>
																		</button>
																		{{ $message }}
																	</div>
																@enderror
															</div>
														</div>
													</div>
													<div class="form-group mb-0 mt-3 justify-content-end">
														<div>
															<button type="submit" class="btn btn-primary">{{ __('content.upload',['model'=>trans_choice('content.contract',1)]) }}</button>
														</div>
													</div>
												</form>
											</div>
										</div>
									</div>
									<div class="tab-pane" id="attachs">

										<div class="row">
											
											@forelse ($contract->attachinvoices as $attach)
												<div class="col-sm-4">
													<div class="border p-1 card thumb">
														<img src="@if($attach->extension != 'pdf'){{URL::asset($attach->setPath($attach->name))}}@else{{URL::asset('assets/images/attachs.png')}}@endif" class="thumb-img" alt="{{ $attach->remvoeExt($attach->origin_name) }}" style="max-height: 200px;">
														<h4 class="text-center tx-14 mt-3 mb-0">{{ $attach->remvoeExt($attach->origin_name) }}</h4>
														<div class="ga-border mb-2"></div>
														<div class="row row-xs">
															<div class="col-md-6">
																<a class="image-popup btn-sm btn btn-primary-gradient btn-block" href="{{ route('open.file',['invoices',$attach->name]) }}" target="_blank">{{ __('content.showFile') }}</a>
															</div>
															<div class="col-md-6 mg-t-10 mg-sm-t-0">
																<a class="image-popup btn-sm btn btn-success-gradient btn-block" href="{{ route('download.file',['invoices',$attach->name]) }}">{{ __('content.downloadFile') }}</a>
															</div>
															<div class="col-md-12 mg-t-5">
																<a href="#" title="{{ __('content.delete') }}" class="image-popup btn-sm btn btn-danger-gradient btn-block swal-warning">{{ __('content.delete') }}</a>
																<form action="{{ route('contract.files',[$contract->id,'invoices',$attach->name]) }}" method="post" class="d-none">
																	@csrf
																</form>
															</div>
														
														</div>
													</div>
												</div>
											@empty
												<div class="col-sm-12 text-center">{{ __('content.no items yet',['model'=>trans_choice('content.invoice',1)]) }}</div>
											@endforelse

											
										</div>
										<div class="row row-sm mg-t-10">
											<div class="col-lg-12">
												<form action="{{ route('update.contract',$contract->id) }}" method="POST" enctype="multipart/form-data">
													@csrf
													@method('POST')
													<div class="row row-sm mg-b-20">
														<div class="col-lg-12">
															<div class="form-group">
																<label class="form-label">{{ __('content.upload',['model'=>trans_choice('content.invoice',2)]) }}</label>
																<input type="file" name="invoices[]" class="dropify" data-height="200" multiple/>
																@foreach($errors->get('invoices.*') as $messages)
																	@foreach($messages as $message)
																		<div class="alert alert-danger mg-t-6" role="alert">
																			<button aria-label="Close" class="close" data-dismiss="alert" type="button">
																				<span aria-hidden="true">&times;</span>
																			</button>
																			{{ $message }}
																		</div>
																	@endforeach
																@endforeach
															</div>
														</div>
													</div>
													<div class="form-group mb-0 mt-3 justify-content-end">
														<div>
															<button type="submit" class="btn btn-primary">{{ __('content.upload',['model'=>trans_choice('content.invoice',2)]) }}</button>
														</div>
													</div>
												</form>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!-- row closed -->
			</div>
			<!-- Container closed -->
		</div>
		<!-- main-content closed -->

		
@endsection
@section('js')
<!--Internal  Datepicker js -->
<script src="{{URL::asset('assets/dashboard/assets/plugins/jquery-ui/ui/widgets/datepicker.js')}}"></script>
<!--Internal  jquery.maskedinput js -->
<script src="{{URL::asset('assets/dashboard/assets/plugins/jquery.maskedinput/jquery.maskedinput.js')}}"></script>
<!--Internal  spectrum-colorpicker js -->
<script src="{{URL::asset('assets/dashboard/assets/plugins/spectrum-colorpicker/spectrum.js')}}"></script>
<!-- Internal Select2.min js -->
<script src="{{URL::asset('assets/dashboard/assets/plugins/select2/js/select2.min.js')}}"></script>
<!--Internal Ion.rangeSlider.min js -->
<script src="{{URL::asset('assets/dashboard/assets/plugins/ion-rangeslider/js/ion.rangeSlider.min.js')}}"></script>
<!--Internal  jquery-simple-datetimepicker js -->
<script src="{{URL::asset('assets/dashboard/assets/plugins/amazeui-datetimepicker/js/amazeui.datetimepicker.min.js')}}"></script>
<!--Internal Fileuploads js-->
<script src="{{URL::asset('assets/dashboard/assets/plugins/fileuploads/js/fileupload.js')}}"></script>
<script>
	@php
	$langs = [ 
		'put'			=> __('content.drag and drop a file here or click'),
		'replace'		=> __('content.drag and drop or click to replace'),
		'remove'		=> __('content.remove'),
		'error'		=> __('content.Ooops, something wrong appended.'),
		'fileSize'	=> __('content.the file size is too big.',['megaSize'=>2]),
	]
	@endphp
	var translation = {!! json_encode($langs) !!};
</script>
<script src="{{URL::asset('assets/dashboard/assets/plugins/fileuploads/js/file-upload.js')}}"></script>
<!-- Ionicons js -->
<script src="{{URL::asset('assets/dashboard/assets/plugins/jquery-simple-datetimepicker/jquery.simple-dtpicker.js')}}"></script>
<!--Internal  pickerjs js -->
<script src="{{URL::asset('assets/dashboard/assets/plugins/pickerjs/picker.min.js')}}"></script>
<script>
	@php
	$langs = [ 
		'chooseOne'	=> __('content.select',['model'=>'']),
		'search'	=>  __('content.search here...'),
	]
	@endphp
	var translation = {!! json_encode($langs) !!};
</script>
<!-- Internal form-elements js -->
<script src="{{URL::asset('assets/dashboard/assets/js/form-elements.js')}}"></script>
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