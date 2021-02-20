@extends('layouts.dashboard.master')
@section('title', __('content.show',['model'=>removeLettersFromStart(removeLettersFromStart(trans_choice('content.role',1) ,0 ,8) ,2 ,null),'name'=>$role->name]))
@section('css')
<!--Internal  Font Awesome -->
<link href="{{URL::asset('assets/dashboard/assets/plugins/fontawesome-free/css/all.min.css')}}" rel="stylesheet">
<!--Internal  treeview -->
@if ( Config::get('app.locale') == 'ar')
	<link href="{{URL::asset('assets/dashboard/assets/plugins/treeview/treeview-rtl.css')}}" rel="stylesheet" type="text/css" />
@else
	<link href="{{URL::asset('assets/dashboard/assets/plugins/treeview/treeview.css')}}" rel="stylesheet" type="text/css" />
@endif

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
							<h4 class="content-title mb-0 my-auto">{{ trans_choice('content.role',2) }}</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ {{ __('content.show',['model'=>removeLettersFromStart(removeLettersFromStart(trans_choice('content.role',1) ,0 ,8) ,2 ,null),'name'=>$role->name]) }}</span>
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

				<!-- row -->
				<div class="row row-sm">
					<div class="col-lg-12">
						<div class="card mg-b-20">
							<div class="card-body">
								<div class="pl-0">
									<div class="main-profile-overview">
										
										<div class="d-flex justify-content-between mg-b-20">
											
											<div>
												<h5 class="main-profile-name">{{ __('content.show',['model'=>removeLettersFromStart(removeLettersFromStart(trans_choice('content.role',1) ,0 ,8) ,2 ,null),'name'=>$role->name]) }}</h5>
											</div>
											<div class="btn-icon-list">
												@can(__('content.role-edit'))
													<a href="{{ route('roles.edit',$role->id) }}" class="btn-primary btn-icon"><i class="typcn typcn-edit"></i></a>
												@else
													<a class="rounded-0 btn btn-secondary btn-icon disabled" href="javascript:;"><i class="typcn typcn-edit"></i></a>
												@endcan

												@can(__('content.role-delete'))
													<a class="btn-danger btn-icon swal-warning" data-action="Delete" href="#"><i class="typcn typcn-delete"></i></a>
													<form action="{{ route('roles.destroy', $role->id) }}" method="POST" class="d-none">
														@csrf
														@method('DELETE')
													</form>
												@else
													<a class="rounded-0 btn btn-secondary btn-icon swal-warning mr-0 disabled" href="javascript:;"><i class="typcn typcn-delete"></i></a>
												@endcan

												<a href="{{ route('roles.index') }}" class="btn-info btn-icon"><i class="typcn typcn-arrow-back-outline"></i></a>
											</div>
										</div>
									</div><!-- main-profile-overview -->
								</div>

								<div class="row">
									<!-- col -->
									<div class="col-lg-4">
										@if(!empty($rolePermissions))
											<ul class="roles">
												<li><a href="#">{{ __('content.permissions') }}</a>
													<ul>
														@foreach (config('customPermission.permissions_title') as $s)
														<li>{{ \Lang::choice('content.'.$s,2,[], \Config::get('app.locale')) }}
															<ul class="child">
																@foreach($rolePermissions as $value)
																	@if (preg_match("/\b$s\b/i", $value))
																		<li>{{ $value->name }}</li>
																	@endif
																@endforeach
															</ul>
														</li>
														@endforeach
													</ul>
												</li>
											</ul>
										@endif

									</div>
									<!-- /col -->
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
<!-- Internal form-elements js -->
<script src="{{URL::asset('assets/dashboard/assets/js/form-elements.js')}}"></script>
<!--Internal  Notify js -->
<script src="{{URL::asset('assets/dashboard/assets/plugins/notify/js/notifIt.js')}}"></script>
<script src="{{URL::asset('assets/dashboard/assets/plugins/notify/js/notifit-custom.js')}}"></script>
<!-- Internal Treeview js -->
<script src="{{URL::asset('assets/dashboard/assets/plugins/treeview/treeview.js')}}"></script>
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
		$('.roles').treed();
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

	$(function() {
		if($('li.branch ul.child:not(:has(li))')) {
			$('li.branch ul.child:not(:has(li))').parent().remove();
		}
	});
	
</script>

@endsection