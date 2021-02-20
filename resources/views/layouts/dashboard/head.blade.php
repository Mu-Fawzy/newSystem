<!-- Title -->
<title>@yield('title', config('app.name', 'Laravel').' admin')</title>
<!-- Favicon -->
<link rel="icon" href="{{URL::asset('favicon.ico')}}" type="image/x-icon"/>
<!-- Icons css -->
<link href="{{URL::asset('assets/dashboard/assets/css/icons.css')}}" rel="stylesheet">
<!--  Custom Scroll bar-->
<link href="{{URL::asset('assets/dashboard/assets/plugins/mscrollbar/jquery.mCustomScrollbar.css')}}" rel="stylesheet"/>
<!--  Sidebar css -->
<link href="{{URL::asset('assets/dashboard/assets/plugins/sidebar/sidebar.css')}}" rel="stylesheet">

<!-- Sidemenu css -->
@if ( Config::get('app.locale') == 'ar')
    <link rel="stylesheet" href="{{URL::asset('assets/dashboard/assets/css-rtl/sidemenu.css')}}">
@else
    <link rel="stylesheet" href="{{URL::asset('assets/dashboard/assets/css/sidemenu.css')}}">
@endif

@yield('css')

@if ( Config::get('app.locale') == 'ar')
    <!--- Style css -->
    <link href="{{URL::asset('assets/dashboard/assets/css-rtl/style.css')}}" rel="stylesheet">
    <!--- Dark-mode css -->
    <link href="{{URL::asset('assets/dashboard/assets/css-rtl/style-dark.css')}}" rel="stylesheet">
    <!---Skinmodes css-->
<link href="{{URL::asset('assets/dashboard/assets/css-rtl/skin-modes.css')}}" rel="stylesheet">@else
    <!--- Style css -->
    <link href="{{URL::asset('assets/dashboard/assets/css/style.css')}}" rel="stylesheet">
    <!--- Dark-mode css -->
    <link href="{{URL::asset('assets/dashboard/assets/css/style-dark.css')}}" rel="stylesheet">
    <!---Skinmodes css-->
    <link href="{{URL::asset('assets/dashboard/assets/css/skin-modes.css')}}" rel="stylesheet">
@endif

