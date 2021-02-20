@extends('layouts.dashboard.master')
@section('title', __('content.home'))
@section('css')
<!--  Owl-carousel css-->
<link href="{{URL::asset('assets/dashboard/assets/plugins/owl-carousel/owl.carousel.css')}}" rel="stylesheet" />
<!-- Maps css -->
<link href="{{URL::asset('assets/dashboard/assets/plugins/jqvmap/jqvmap.min.css')}}" rel="stylesheet">
@endsection
@section('page-header')
				<!-- breadcrumb -->
				<div class="breadcrumb-header justify-content-between">
					<div class="left-content">
						<div>
							<h2 class="main-content-title tx-24 mg-b-3 mg-b-lg-1">{{ __('content.welcome back!') }}</h2>
							<p class="mg-b-0">{{ __('content.dashboard') }}</p>
						</div>
					</div>
				</div>
				<!-- /breadcrumb -->
@endsection
@section('content')
				<!-- row -->
				<div class="row row-sm">
					<div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
						<div class="card overflow-hidden sales-card bg-success-gradient">
							<div class="pl-3 pt-3 pr-3 pb-2 pt-0">
								<div class="">
									<h6 class="mb-3 tx-12 text-white">{{ __('content.number of') .' '. trans_choice('content.contract',2) }}</h6>
								</div>
								<div class="pb-0 mt-0">
									<div class="d-flex">
										<div class="">
											<h4 class="tx-20 font-weight-bold mb-1 text-white">{{ $countContract }}</h4>
										</div>
										<span class="float-right my-auto m{{ Config::get('app.locale') == 'ar' ? 'r' : 'l' }}-auto">
											<i class="fas fa-arrow-circle-up text-white"></i>
										</span>
									</div>
								</div>
							</div>
							<span id="compositeline" class="pt-1">5,9,5,6,4,12,18,14,10,15,12,5,8,5,12,5,12,10,16,12</span>
						</div>
					</div>
					<div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
						<div class="card overflow-hidden sales-card bg-primary-gradient">
							<div class="pl-3 pt-3 pr-3 pb-2 pt-0">
								<div class="">
									<h6 class="mb-3 tx-12 text-white">{{ __('content.number of') .' '. trans_choice('content.work site',2) }}</h6>
								</div>
								<div class="pb-0 mt-0">
									<div class="d-flex">
										<div class="">
											<h4 class="tx-20 font-weight-bold mb-1 text-white">{{ $worksite }}</h4>
										</div>
										<span class="float-right my-auto m{{ Config::get('app.locale') == 'ar' ? 'r' : 'l' }}-auto">
											<i class="fas fa-arrow-circle-up text-white"></i>
										</span>
									</div>
								</div>
							</div>
							<span id="compositeline2" class="pt-1">3,2,4,6,12,14,8,7,14,16,12,7,8,4,3,2,2,5,6,7</span>
						</div>
					</div>
					<div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
						<div class="card overflow-hidden sales-card bg-danger-gradient">
							<div class="pl-3 pt-3 pr-3 pb-2 pt-0">
								<div class="">
									<h6 class="mb-3 tx-12 text-white">{{ __('content.number of') .' '. trans_choice('content.work item',2) }}</h6>
								</div>
								<div class="pb-0 mt-0">
									<div class="d-flex">
										<div class="">
											<h4 class="tx-20 font-weight-bold mb-1 text-white">{{ $workitem }}</h4>
										</div>
										<span class="float-right my-auto m{{ Config::get('app.locale') == 'ar' ? 'r' : 'l' }}-auto">
											<i class="fas fa-arrow-circle-up text-white"></i>
										</span>
									</div>
								</div>
							</div>
							<span id="compositeline3" class="pt-1">5,10,5,20,22,12,15,18,20,15,8,12,22,5,10,12,22,15,16,10</span>
						</div>
					</div>
					<div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
						<div class="card overflow-hidden sales-card bg-warning-gradient">
							<div class="pl-3 pt-3 pr-3 pb-2 pt-0">
								<div class="">
									<h6 class="mb-3 tx-12 text-white">{{ __('content.number of') .' '. trans_choice('content.subcontractor',2) }}</h6>
								</div>
								<div class="pb-0 mt-0">
									<div class="d-flex">
										<div class="">
											<h4 class="tx-20 font-weight-bold mb-1 text-white">{{ $subcontractor }}</h4>
										</div>
										<span class="float-right my-auto m{{ Config::get('app.locale') == 'ar' ? 'r' : 'l' }}-auto">
											<i class="fas fa-arrow-circle-up text-white"></i>
										</span>
									</div>
								</div>
							</div>
							<span id="compositeline4" class="pt-1">5,9,5,6,4,12,18,14,10,15,12,5,8,5,12,5,12,10,16,12</span>
						</div>
					</div>
				</div>
				<!-- row closed -->

				<!-- row opened -->
				<div class="row row-sm">
					<div class="col-md-12 col-lg-12 col-xl-12">
						<div class="card">
							<div class="card-header bg-transparent pd-b-0 pd-t-20 bd-b-0">
								<div class="d-flex justify-content-between">
									<h4 class="card-title mb-0">{{ __('content.general status') }}</h4>
									<i class="mdi mdi-dots-horizontal text-gray"></i>
								</div>
							</div>
							<div class="card-body">
								<div id="bar" class="sales-bar"></div>
							</div>
						</div>
					</div>
				</div>
				<!-- row closed -->

			</div>
		</div>
		<!-- Container closed -->
@endsection
@section('js')

<script>
	@php
	$data = [ 
		'dirRight'				=> app()->getLocale() == 'ar' ? 'left' : 'right',
		'dirLeft'				=> app()->getLocale() == 'ar' ? 'right' : 'left',
		'years'					=> $years,
		'contracts'				=> $contracts,
		'contracts_tran'		=> trans_choice('content.contract',2),
		'sites'					=> $sites,
		'sites_tran'			=> trans_choice('content.work site',2),
		'items'					=> $items,
		'items_tran'			=> trans_choice('content.work item',2),
		'subcontractors'		=> $subcontractors,
		'subcontractors_tran'	=> trans_choice('content.subcontractor',2),
	]
	@endphp
	var jsonData = {!! json_encode($data) !!};
</script>

<!--Internal Apexchart js-->
<script src="{{URL::asset('assets/dashboard/assets/js/apexcharts.js')}}"></script>
<!--Internal  index js -->
<script src="{{URL::asset('assets/dashboard/assets/js/index.js')}}"></script>
<script src="{{URL::asset('assets/dashboard/assets/js/jquery.vmap.sampledata.js')}}"></script>	
@endsection