@extends('layouts.dashboard.master')
@section('title',  __('content.edit')." - ".$user->name)
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
<!--- Internal Sweet-Alert css-->
<link href="{{URL::asset('assets/dashboard/assets/plugins/sweet-alert/sweetalert.css')}}" rel="stylesheet">

@endsection
@section('page-header')
		<!-- breadcrumb -->
		<div class="breadcrumb-header justify-content-between">
			<div class="my-auto">
				<div class="d-flex">
					<h4 class="content-title mb-0 my-auto">{{ trans_choice('content.user',2) }}</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ {{ __('content.edit')." - ".$user->name }}</span>
				</div>
			</div>
			<div class="d-flex my-xl-auto right-content">
				@can(__('content.user-create'))
					<div class="pr-1 mb-3 mb-xl-0">
						<a href="{{ route('users.create') }}" class="btn btn-success ml-2"><i class="mdi mdi-plus ml-1"></i>{{ __('sidebar.add new') }}</a>
					</div>
				@endcan
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
							<div class="d-flex justify-content-between mg-b-20">
								<div>
									<h5 class="main-profile-name">{{ __('content.edit')." - ".$user->name }}</h5>
								</div>
								<div class="btn-icon-list">
									@can(__('content.user-delete'))
										<a class="btn-danger btn-icon swal-warning" href="{{ route('users.destroy', $user->id) }}" data-action="Delete"><i class="typcn typcn-delete"></i></a>
										<form action="{{ route('users.destroy', $user->id) }}" method="POST" class="d-none">
											@csrf
											@method('DELETE')
										</form>
									@endcan

									<a href="{{ route('users.index') }}" class="btn-info btn-icon"><i class="typcn typcn-arrow-back-outline"></i></a>
								</div>
							</div>
						</div>
						
						<div class="card-body">
							<form class="form-horizontal" action="{{ route('users.update', $user->id) }}" method="POST">
								@csrf
								@method('PATCH')
								<div class="row row-sm mg-b-20">
									<div class="col-lg-6">
										<div class="form-group">
											<label class="form-label">{{ __('validation.attributes.name') }}</label>

											<input type="text" class="form-control" name="name" placeholder="{{ __('validation.attributes.name') }}" value="{{ $user->name }}">
											@error('name')
												<div class="alert alert-danger mg-t-6" role="alert">
													<button aria-label="Close" class="close" data-dismiss="alert" type="button">
														<span aria-hidden="true">&times;</span>
													</button>
													{{ $message }}
												</div>
											@enderror
										</div>
									</div><!-- col-6 -->
									<div class="col-lg-6">
										<div class="form-group">
											<label class="form-label">{{ __('validation.attributes.email') }}</label>

											<input type="text" class="form-control" name="email" placeholder="{{ __('validation.attributes.email') }}" value="{{ $user->email }}">
											@error('email')
												<div class="alert alert-danger mg-t-6" role="alert">
													<button aria-label="Close" class="close" data-dismiss="alert" type="button">
														<span aria-hidden="true">&times;</span>
													</button>
													{{ $message }}
												</div>
											@enderror
										</div>
									</div><!-- col-6 -->
								</div>
								<div class="row row-sm mg-b-20">
									<div class="col-lg-6">
										<div class="form-group">
											<label class="form-label">{{ __('validation.attributes.password') }}</label>
											<input type="password" class="form-control" name="password" placeholder="{{ __('validation.attributes.password') }}">
											@error('password')
												<div class="alert alert-danger mg-t-6" role="alert">
													<button aria-label="Close" class="close" data-dismiss="alert" type="button">
														<span aria-hidden="true">&times;</span>
													</button>
													{{ $message }}
												</div>
											@enderror
										</div>
									</div><!-- col-6 -->
									<div class="col-lg-6">
										<div class="form-group">
											<label class="form-label">{{ __('validation.attributes.password_confirmation') }}</label>
											<input type="password" class="form-control" name="confirm-password" placeholder="{{ __('validation.attributes.password_confirmation') }}">
											@error('confirm-password')
												<div class="alert alert-danger mg-t-6" role="alert">
													<button aria-label="Close" class="close" data-dismiss="alert" type="button">
														<span aria-hidden="true">&times;</span>
													</button>
													{{ $message }}
												</div>
											@enderror
										</div>
									</div><!-- col-6 -->
								</div>
								<div class="row row-sm mg-b-20">
									<div class="col-lg-12">
										<div class="form-group">
											<label class="form-label">{{ trans_choice('content.role',2) }}</label>

											<select class="form-control" name="roles[]" id="" multiple>
												@foreach ($roles as $role)
													<option value="{{ $role->id }}" @if(in_array($role->getTranslation('name', app()->getLocale()), $userRole)) selected @endif>{{ $role->getTranslation('name', app()->getLocale()) }}</option>
												@endforeach

											</select>
											@foreach($errors->get('roles.*') as $messages)
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
								<div class="row row-sm mg-b-20">
									<div class="col-lg-12">
										<div class="form-group">
											<label class="form-label">{{ __('content.status') }}</label>
											<input type="hidden" class="form-control" name="status" value="{{ $user->status }}">
											<div class="main-toggle main-toggle-dark @if ($user->status == 1){{'on'}}@endif"><span></span></div>
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
										<button type="submit" class="btn btn-primary">{{ __('content.update') }}</button>
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
<!--Internal  Sweet-Alert js-->
<script src="{{URL::asset('assets/dashboard/assets/plugins/sweet-alert/sweetalert.min.js')}}"></script>

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

	$('a.swal-warning').each(function(){
		$(this).on('click',function(e){
			e.preventDefault();
			
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