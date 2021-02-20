@extends('layouts.dashboard.master')
@section('title', __('content.edit')." - ".$workitem->name)
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
					<h4 class="content-title mb-0 my-auto">{{ trans_choice('content.work item',2) }}</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ {{ __('content.edit')." - ".$workitem->name }}</span>
				</div>
			</div>
			<div class="d-flex my-xl-auto right-content">
				
				@can(__('content.work-create'))
					<div class="pr-1 mb-3 mb-xl-0">
						<a href="{{ route('workitems.create') }}" class="btn btn-success ml-2"><i class="mdi mdi-plus ml-1"></i>{{ __('sidebar.add new') }}</a>
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
									<h5 class="main-profile-name">{{ __('content.edit')." - ".$workitem->name }}</h5>
								</div>
								<div class="btn-icon-list">
									@can(__('content.work-delete'))
										<a class="btn-danger btn-icon swal-warning" href="#" title="{{ __('content.delete') }}" data-action="Delete" data-placement="right" data-toggle="tooltip"><i class="typcn typcn-delete"></i></a>
										<form action="{{ route('workitems.destroy', $workitem->id) }}" method="POST" class="d-none">
											@csrf
											@method('DELETE')
										</form>
									@endcan

									<a href="{{ route('workitems.index') }}" class="btn-info btn-icon"><i class="typcn typcn-arrow-back-outline"></i></a>
								</div>
							</div>
						</div>

						<div class="card-body">

							<form class="form-horizontal" action="{{ route('workitems.update', $workitem->id) }}" method="Post">
								@csrf
								@method('PUT')
								<div class="row row-sm mg-b-20">

									@foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
										<div class="col-lg-6">
											<div class="form-group">
												<label class="form-label">{{__('content.name',['model'=>trans_choice('content.work item',1) ])." ".$localeCode }}</label>
												<input type="text" class="form-control" name="name_{{ $localeCode }}" placeholder="{{__('content.name',['model'=>trans_choice('content.work item',1) ])." ".$localeCode }}" value="{{ $workitem->getTranslation('name', $localeCode) }}">
												@error('name_'.$localeCode)
													<div class="alert alert-danger mg-t-6" role="alert">
														<button aria-label="Close" class="close" data-dismiss="alert" type="button">
															<span aria-hidden="true">&times;</span>
														</button>
														{{ $message }}
													</div>
												@enderror
											</div>
										</div>
									@endforeach

									<div class="col-lg-12">
										<div class="form-group">
											<button type="submit" class="btn btn-primary">{{ __('content.update') }}</button>
										</div>
									</div><!-- col-6 -->
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