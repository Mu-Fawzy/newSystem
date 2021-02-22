@extends('layouts.dashboard.master')
@section('title', __('content.show',['model'=>trans_choice('content.subcontractor',1),'name'=>$subcontractor->name]))
@section('css')
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
							<h4 class="content-title mb-0 my-auto">{{ trans_choice('content.subcontractor',2) }}</h4><span class="text-muted mt-1 tx-13 m{{ Config::get('app.locale') == 'ar' ? 'r' : 'l' }}-2 mb-0">/ {{ $subcontractor->name }}</span>
						</div>
					</div>
					<div class="d-flex my-xl-auto right-content">
						@can(__('content.subcontractor-create'))
							<div class="pr-1 mb-3 mb-xl-0">
								<a href="{{ route('subcontractors.create') }}" class="btn btn-success ml-2"><i class="mdi mdi-plus ml-1"></i>{{ __('sidebar.add new') }}</a>
							</div>
						@endcan
						<div class="mb-3 mb-xl-0">
							<div class="btn-group dropdown">
								<button type="button" class="btn btn-primary">{{ carbon\Carbon::now()->translatedFormat('d M Y') }}</button>
								</button>
							</div>
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
										<div class="imagesubcontractor">
											<div class="main-img-user profile-user">
												@if ($subcontractor->attachlogo != null)
													<img class="img-thumbnail" src="{{URL::asset('public/'.$subcontractor->attachlogo->setPath($subcontractor->attachlogo->name))}}">
													<a class="modal-effect fas fa-camera profile-edit" data-effect="effect-scale" data-toggle="modal" href="#uploadLogo"></a>
												@else
													<img class="img-thumbnail" src="{{URL::asset('assets/images/logo.png')}}">
													<a class="modal-effect fas fa-camera profile-edit" data-effect="effect-scale" data-toggle="modal" href="#uploadLogo"></a>
												@endif
											</div>
											@error('logo')
												<div class="alert alert-danger mg-t-6 clearfix" role="alert">
													<button aria-label="Close" class="close" data-dismiss="alert" type="button">
														<span aria-hidden="true">&times;</span>
													</button>
													{{ $message }}
												</div>
											@enderror
										</div>
										<div class="d-flex justify-content-between mg-b-20">
											<div>
												<h5 class="main-profile-name">{{ $subcontractor->name }}</h5>
												<p class="main-profile-name-text">{{ $subcontractor->email }}</p>
											</div>
										</div>
										<h6>{{ __('content.bio') }}</h6>
										<div class="main-profile-bio">{{ Str::words($subcontractor->bio, 20) }}</div>
										<form role="form" action="{{ route('update.status',$subcontractor->id) }}" method="POST">
											@csrf
											<div class="form-group">
												<h6>{{ __('content.status') }}</h6>
												<input type="hidden" class="form-control" name="status" value="{{ $subcontractor->status }}">
												<div class="main-toggle main-toggle-dark @if ($subcontractor->status == 1){{'on'}}@endif"><span></span></div>
												@error('status')
													<div class="alert alert-danger mg-t-6" role="alert">
														<button aria-label="Close" class="close" data-dismiss="alert" type="button">
															<span aria-hidden="true">&times;</span>
														</button>
														{{ $message }}
													</div>
												@enderror
											</div>
										</form>
									</div><!-- main-profile-overview -->
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-8">
						<div class="row row-sm">
							<div class="col-sm-12 col-xl-6 col-lg-12 col-md-12">
								<div class="card ">
									<div class="card-body">
										<div class="counter-status d-flex md-mb-0">
											<div class="counter-icon bg-primary-transparent">
												<i class="icon-layers text-primary"></i>
											</div>
											
											<div class="m{{ Config::get('app.locale') == 'ar' ? 'r' : 'l' }}-auto">
												<h5 class="tx-13">{{ trans_choice('content.work site',2) }}</h5>
												<h2 class="mb-0 tx-22 mb-1 mt-1">
													<a href="{{ route('subcontractor.worksites', $subcontractor->id) }}">{{ $subcontractor->worksites->count() }}</a>
												</h2>
												<p class="text-muted mb-0 tx-11"><i class="si si-arrow-up-circle text-success m{{ Config::get('app.locale') == 'ar' ? 'l' : 'r' }}-1"></i>{{ __('content.number') }}</p>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="col-sm-12 col-xl-6 col-lg-12 col-md-12">
								<div class="card ">
									<div class="card-body">
										<div class="counter-status d-flex md-mb-0">
											<div class="counter-icon bg-danger-transparent">
												<i class="icon-paypal text-danger"></i>
											</div>
											<div class="m{{ Config::get('app.locale') == 'ar' ? 'r' : 'l' }}-auto">
												<h5 class="tx-13">{{ trans_choice('content.work item',2) }}</h5>
												<h2 class="mb-0 tx-22 mb-1 mt-1">
													<a href="{{ route('subcontractor.workitems',$subcontractor->id) }}">{{ $subcontractor->workitems->count() }}</a>
												</h2>
												<p class="text-muted mb-0 tx-11"><i class="si si-arrow-up-circle text-success m{{ Config::get('app.locale') == 'ar' ? 'l' : 'r' }}-1"></i>{{ __('content.number') }}</p>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="card">
							<div class="card-body">
								<div class="tabs-menu ">
									<!-- Tabs -->
									<ul class="nav nav-tabs profile navtab-custom panel-tabs">
										<li>
											<a href="#home" data-toggle="tab" aria-expanded="true" class="active"> <span class="visible-xs"><i class="las la-user-circle tx-16 m{{ Config::get('app.locale') == 'ar' ? 'l' : 'r' }}-1"></i></span> <span class="hidden-xs">{{ __('content.about subcontractors') }}</span> </a>
										</li>
										<li>
											<a href="#attachs" data-toggle="tab" aria-expanded="false"> <span class="visible-xs"><i class="las la-images tx-15 m{{ Config::get('app.locale') == 'ar' ? 'l' : 'r' }}-1"></i></span> <span class="hidden-xs">{{ trans_choice('content.attachment',2) }}</span> </a>
										</li>
										<li>
											<a href="#settings" data-toggle="tab" aria-expanded="false"> <span class="visible-xs"><i class="las la-cog tx-16 m{{ Config::get('app.locale') == 'ar' ? 'l' : 'r' }}-1"></i></span> <span class="hidden-xs">{{ __('content.settings') }}</span> </a>
										</li>
									</ul>
								</div>
								<div class="tab-content border-left border-bottom border-right border-top-0 p-4">
									<div class="tab-pane active" id="home">
										<h4 class="tx-15 text-uppercase mb-3">{{ __('content.bio') }}</h4>
										<p class="m-b-5">{{ $subcontractor->bio }}</p>
										<hr>
										<h4 class="tx-15 text-uppercase mb-3">{{ __('validation.attributes.phone') }}</h4>
										<p class="m-b-5">{{ $subcontractor->phone }}</p>
										<hr>
										<h4 class="tx-15 text-uppercase mb-3">{{ __('validation.attributes.email') }}</h4>
										<p class="m-b-5">{{ $subcontractor->email }}</p>
									</div>
									<div class="tab-pane" id="attachs">
										<div class="row">
											
											@forelse ($subcontractor->attachs as $attach)
												<div class="col-sm-4">
													<div class="border p-1 card thumb">
														<img src="@if($attach->extension != 'pdf'){{URL::asset($attach->setPath($attach->name))}}@else{{URL::asset('assets/images/pdf.png')}}@endif" class="thumb-img" alt="{{ $attach->remvoeExt($attach->origin_name) }}" style="max-height: 200px;">
														<h4 class="text-center tx-14 mt-3 mb-0">{{ $attach->remvoeExt($attach->origin_name) }}</h4>
														<div class="ga-border mb-2"></div>
														<div class="row row-xs">
															<div class="col-md-6">
																<a class="image-popup btn-sm btn btn-primary-gradient btn-block" href="{{ route('open.file',['attachs',$attach->name]) }}" target="_blank">{{ __('content.showFile') }}</a>
															</div>
															<div class="col-md-6 mg-t-10 mg-sm-t-0">
																<a class="image-popup btn-sm btn btn-success-gradient btn-block" href="{{ route('download.file',['attachs',$attach->name]) }}">{{ __('content.downloadFile') }}</a>
															</div>
															<div class="col-md-12 mg-t-5">
																<a class="image-popup btn-sm btn btn-danger-gradient btn-block swal-warning" href="{{ route('delete.file',[$subcontractor->id,$attach->name]) }}" title="{{ __('content.delete') }}" data-placement="top" data-toggle="tooltip">{{ __('content.delete') }}</a>
																
																<a class="d-none" href="{{ route('delete.file',[$subcontractor->id,$attach->name]) }}"></a>
															</div>
														
														</div>
													</div>
												</div>
											@empty
												<div class="col-sm-12 text-center">{{ __('content.no attachments yet') }}</div>
											@endforelse

										</div>
										<div class="row row-sm mg-t-10">
											<div class="col-lg-12">
												<form action="{{ route('update.attachs',$subcontractor->id) }}" method="POST" enctype="multipart/form-data">
													@csrf
													@method('POST')
													<div class="row row-sm mg-b-20">
														<div class="col-lg-12">
															<div class="form-group">
																<label class="form-label">{{ __('content.upload attachments') }}</label>
																<input type="file" name="attachment_name[]" class="dropify" data-height="200" multiple/>
																@foreach($errors->get('attachment_name.*') as $key=>$messages)
																	@foreach($messages as $message)
																		<div class="alert alert-danger mg-t-6" role="alert">
																			<button aria-label="Close" class="close" data-dismiss="alert" type="button">
																				<span aria-hidden="true">&times;</span>
																			</button>
																			{{ $message }} ({{ trans_choice('content.invoice',1) }} {{ substr($key, -1, strpos($key, ".")) }})
																		</div>
																	@endforeach
																@endforeach
															</div>
														</div>
													</div>
													<div class="form-group mb-0 mt-3 justify-content-end">
														<div>
															<button type="submit" class="btn btn-primary">{{ __('content.create') }}</button>
														</div>
													</div>
												</form>
												
											</div>
										</div>
									</div>
									<div class="tab-pane" id="settings">
										<form role="form" action="{{ route('subcontractors.update',$subcontractor->id) }}" method="POST">
											@csrf
											@method('PUT')

											<div class="row">
												@foreach(LaravelLocalization::getSupportedLanguagesKeys() as $localeCode)
													<div class="col-lg-6">
														<div class="form-group">
															<label for="name">{{ __('content.subcontractor name')." ".$localeCode }}</label>
															<input type="text" class="form-control" name="name_{{ $localeCode }}" placeholder="{{ __('content.subcontractor name')." ".$localeCode }}" value="{{ $subcontractor->getTranslation('name', $localeCode) }}">
															@error('name_'.$localeCode)
																<div class="alert alert-danger mg-t-6" role="alert">
																	<button aria-label="Close" class="close" data-dismiss="alert" type="button">
																		<span aria-hidden="true">&times;</span>
																	</button>
																	{{ $message }}
																</div>
															@enderror
														</div>
													</div><!-- col-6 -->
												@endforeach

												<div class="col-lg-6">
													<div class="form-group">
														<label for="phone">{{ __('validation.attributes.phone') }}</label>
														<input type="tel" value="{{ $subcontractor->phone }}" id="phone" name="phone" class="form-control">
														@error('phone')
															<div class="alert alert-danger mg-t-6" role="alert">
																<button aria-label="Close" class="close" data-dismiss="alert" type="button">
																	<span aria-hidden="true">&times;</span>
																</button>
																{{ $message }}
															</div>
														@enderror
													</div>
												</div>

												<div class="col-lg-6">
													<div class="form-group">
														<label for="email">{{ __('validation.attributes.email') }}</label>
														<input type="email" value="{{ $subcontractor->email }}" id="email" name="email" class="form-control">
														@error('email')
															<div class="alert alert-danger mg-t-6" role="alert">
																<button aria-label="Close" class="close" data-dismiss="alert" type="button">
																	<span aria-hidden="true">&times;</span>
																</button>
																{{ $message }}
															</div>
														@enderror
													</div>
												</div>

												@foreach(LaravelLocalization::getSupportedLanguagesKeys() as $localeCode)
													<div class="col-lg-6">
														<div class="form-group">
															<label for="address">{{ __('validation.attributes.address')." ".$localeCode }}</label>
															<textarea id="address" name="address_{{ $localeCode }}" class="form-control" rows="3">{{ $subcontractor->getTranslation('address', $localeCode) }}</textarea>
															@error('address_'.$localeCode)
																<div class="alert alert-danger mg-t-6" role="alert">
																	<button aria-label="Close" class="close" data-dismiss="alert" type="button">
																		<span aria-hidden="true">&times;</span>
																	</button>
																	{{ $message }}
																</div>
															@enderror
														</div>
													</div><!-- col-6 -->
												@endforeach



												@foreach(LaravelLocalization::getSupportedLanguagesKeys() as $localeCode)
													<div class="col-lg-6">
														<div class="form-group">
															<label for="address">{{ __('content.bio')." ".$localeCode }}</label>
															<textarea id="address" name="bio_{{ $localeCode }}" class="form-control" rows="4">{{ $subcontractor->getTranslation('bio', $localeCode) }}</textarea>
															@error('bio_'.$localeCode)
																<div class="alert alert-danger mg-t-6" role="alert">
																	<button aria-label="Close" class="close" data-dismiss="alert" type="button">
																		<span aria-hidden="true">&times;</span>
																	</button>
																	{{ $message }}
																</div>
															@enderror
														</div>
													</div><!-- col-6 -->
												@endforeach

											</div>

											<button class="btn btn-primary waves-effect waves-light w-md" type="submit">{{ __('content.update') }}</button>
										</form>
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

		<!-- Modal effects -->
		<div class="modal" id="uploadLogo">
			<form action="{{ route('update.attachs',$subcontractor->id) }}" method="POST" enctype="multipart/form-data">
				@csrf
				@method('POST')
				<div class="modal-dialog modal-dialog-centered" role="document">
					<div class="modal-content modal-content-demo">
						<div class="modal-header">
							<h6 class="modal-title">{{ __('content.subcontractor logo') }}</h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
						</div>
						<div class="modal-body">
							<h6>{{ __('content.uploadFile') }}</h6>
							<div class="form-group">
								<input type="file" name="logo" class="dropify" data-height="225"/>
							</div>
						</div>
						<div class="modal-footer">
							<button class="btn ripple btn-primary" type="submit">{{ __('content.uploadFile') }}</button>
							<button class="btn ripple btn-secondary" data-dismiss="modal" type="button">{{ __('content.close') }}</button>
						</div>
					</div>
				</div>
			</form>
		</div>
		<!-- End Modal effects-->
		
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
	$(function() {
		var statusbtn = $('input[name="status"]'),
			nextstatusbtn = statusbtn.next('.main-toggle');

		nextstatusbtn.on('click',function(){
			if ($(this).hasClass("on")) {
				statusbtn.val(1);
			}else{
				statusbtn.val(0);
			}
			$(this).closest('form').submit();
		});
	});

	$(function() {
		'use strict'
		// showing modal with effect
		$('.modal-effect').on('click', function(e) {
			e.preventDefault();
			var effect = $(this).attr('data-effect');
			$('#uploadLogo').addClass(effect);
		});
		// hide modal with effect
		$('#uploadLogo').on('hidden.bs.modal', function(e) {
			$(this).removeClass(function(index, className) {
				return (className.match(/(^|\s)effect-\S+/g) || []).join(' ');
			});
		});
	});

	$('a.swal-warning').each(function(){
		$(this).on('click',function(e){
			e.preventDefault();
			var current_object = $(this),
				title = current_object.attr("data-original-title");
				text = "";
				type = "";

				if(title == "{{ __('content.delete') }}"){
					text = "{{ __('content.delete forever') }}";
					type = "error";
				}
			swal({
				title: "{{ __('content.are you sure?') }}",
				text: text,
				type: type,
				showCancelButton: true,
				cancelButtonText: "{{ __('content.cancel') }}",
				confirmButtonText: "{{ __('content.Yes') }}",
				confirmButtonColor: '#57a94f',
				
			},
			function(isConfirm) {
				if (isConfirm) {
					current_object.next('.d-none')[0].click();
				}
			});
		})
	});
</script>
@endsection