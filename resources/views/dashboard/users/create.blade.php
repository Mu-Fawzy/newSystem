@extends('layouts.dashboard.master')
@section('title', __('content.create title',['model'=> removeLettersFromStart(removeLettersFromStart(trans_choice('content.user',1) ,0 ,8) ,2 ,null)	])) 
@section('css')
<!-- Internal Select2 css -->
<link href="{{URL::asset('assets/dashboard/assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet">
<!--Internal  Datetimepicker-slider css -->
<link href="{{URL::asset('assets/dashboard/assets/plugins/amazeui-datetimepicker/css/amazeui.datetimepicker.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/dashboard/assets/plugins/jquery-simple-datetimepicker/jquery.simple-dtpicker.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/dashboard/assets/plugins/pickerjs/picker.min.css')}}" rel="stylesheet">
<!---Internal Fileupload css-->
<link href="{{URL::asset('assets/dashboard/assets/plugins/fileuploads/css/fileupload.css')}}" rel="stylesheet" type="text/css"/>
<!-- Internal Spectrum-colorpicker css -->
<link href="{{URL::asset('assets/dashboard/assets/plugins/spectrum-colorpicker/spectrum.css')}}" rel="stylesheet">
@endsection
@section('page-header')
		<!-- breadcrumb -->
		<div class="breadcrumb-header justify-content-between">
			<div class="my-auto">
				<div class="d-flex">
					<h4 class="content-title mb-0 my-auto">{{ trans_choice('content.user',2) }}</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ {{ __('content.create title',['model'=> removeLettersFromStart(removeLettersFromStart(trans_choice('content.user',1) ,0 ,8) ,2 ,null)	]) }}</span>
				</div>
			</div>
		</div>
		<!-- breadcrumb -->
@endsection
@section('content')
			<!-- row opened -->
			<div class="row row-sm">
				<div class="col-xl-12">
					<div class="card">
						<div class="card-header pb-0">
							@include('dashboard.messages.errors')
							<div class="d-flex justify-content-between">
								<div>
									<h4 class="card-title mg-b-0 mb-2">{{ __('content.create title',['model'=> removeLettersFromStart(removeLettersFromStart(trans_choice('content.user',1) ,0 ,8) ,2 ,null)	]) }}</h4>
								</div>
								<div class="btn-icon-list">
									<a href="{{ route('users.index') }}" class="btn-info btn-icon"><i class="typcn typcn-arrow-back-outline"></i></a>
								</div>
							</div>

						</div>
						<div class="card-body">
							<form class="form-horizontal" action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data">
								@csrf
								<div class="row row-sm mg-b-20">
									<div class="col-lg-6">
										<div class="form-group">
											<label class="form-label">{{ __('validation.attributes.name') }}</label>
											<input type="text" class="form-control" name="name" placeholder="{{ __('validation.attributes.name') }}" value="{{ old('name') }}">
										</div>
									</div><!-- col-6 -->
									<div class="col-lg-6">
										<div class="form-group">
											<label class="form-label">{{ __('validation.attributes.email') }}</label>

											<input type="text" class="form-control" name="email" placeholder="{{ __('validation.attributes.email') }}" value="{{ old('email') }}">
										</div>
									</div><!-- col-6 -->
								</div>
								<div class="row row-sm mg-b-20">
									<div class="col-lg-6">
										<div class="form-group">
											<label class="form-label">{{ __('validation.attributes.password') }}</label>
											<input type="password" class="form-control" name="password" placeholder="{{ __('validation.attributes.password') }}">
										</div>
									</div><!-- col-6 -->
									<div class="col-lg-6">
										<div class="form-group">
											<label class="form-label">{{ __('validation.attributes.password_confirmation') }}</label>
											<input type="password" class="form-control" name="confirm-password" placeholder="{{ __('validation.attributes.password_confirmation') }}">
										</div>
									</div><!-- col-6 -->
								</div>
								<div class="row row-sm mg-b-20">
									<div class="col-lg-12">
										<div class="form-group">
											<label class="form-label">{{ trans_choice('content.role',2) }}</label>
											<select class="form-control" name="roles[]" id="" multiple>
												@foreach ($roles as $role )
													<option value="{{ $role->id }}">{{ $role->getTranslation('name', app()->getLocale()) }}</option>
												@endforeach
											</select>
										</div>
									</div>
								</div>
								<div class="row row-sm mg-b-20">
									<div class="col-lg-12">
										<div class="form-group">
											<label class="form-label">{{ __('content.status') }}</label>
											<input type="hidden" class="form-control" name="status" value="1">
											<div class="main-toggle main-toggle-dark on"><span></span></div>
											@error('status')
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
										<button type="submit" class="btn btn-primary">{{ __('content.create') }}</button>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
				<!--/div-->
			</div>
			<!-- /row -->
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
<!-- Internal form-elements js -->
<script src="{{URL::asset('assets/dashboard/assets/js/form-elements.js')}}"></script>
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
		});
	});
</script>
@endsection