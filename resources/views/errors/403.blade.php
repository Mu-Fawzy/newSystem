@extends('layouts.dashboard.master2')
@section('css')
<!--- Internal Fontawesome css-->
<link href="{{URL::asset('assets/dashboard/assets/plugins/fontawesome-free/css/all.min.css')}}" rel="stylesheet">
<!---Ionicons css-->
<link href="{{URL::asset('assets/dashboard/assets/plugins/ionicons/css/ionicons.min.css')}}" rel="stylesheet">
<!---Internal Typicons css-->
<link href="{{URL::asset('assets/dashboard/assets/plugins/typicons.font/typicons.css')}}" rel="stylesheet">
<!---Internal Feather css-->
<link href="{{URL::asset('assets/dashboard/assets/plugins/feather/feather.css')}}" rel="stylesheet">
<!---Internal Falg-icons css-->
<link href="{{URL::asset('assets/dashboard/assets/plugins/flag-icon-css/css/flag-icon.min.css')}}" rel="stylesheet">
@endsection
@section('content')
	<!-- Main-error-wrapper -->
	<div class="main-error-wrapper  page page-h ">
		<img src="{{URL::asset('assets/dashboard/assets/img/media/403.png')}}" class="error-page" alt="error">
		<h2>Oopps. {{ $exception->getMessage() }}</h2>
		<h6>You may have mistyped the address or the page may have moved.</h6>
		@if (\Request::is('admin/*'))
			<a class="btn btn-outline-danger" href="{{ route('admin.home') }}">Back to Home</a>
		@else
			<a class="btn btn-outline-danger" href="{{ route('home.page') }}">Back to Home</a>
		@endif
	</div>
	<!-- /Main-error-wrapper -->
@endsection
@section('js')
@endsection