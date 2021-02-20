<!-- Back-to-top -->
<a href="#top" id="back-to-top"><i class="las la-angle-double-up"></i></a>
<!-- JQuery min js -->
<script src="{{URL::asset('assets/dashboard/assets/plugins/jquery/jquery.min.js')}}"></script>
<!-- Bootstrap Bundle js -->
<script src="{{URL::asset('assets/dashboard/assets/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- Ionicons js -->
<script src="{{URL::asset('assets/dashboard/assets/plugins/ionicons/ionicons.js')}}"></script>
<!-- Moment js -->
<script src="{{URL::asset('assets/dashboard/assets/plugins/moment/moment.js')}}"></script>

<!-- Rating js-->
<script src="{{URL::asset('assets/dashboard/assets/plugins/rating/jquery.rating-stars.js')}}"></script>
<script src="{{URL::asset('assets/dashboard/assets/plugins/rating/jquery.barrating.js')}}"></script>

@if (Route::currentRouteName() != 'login')
    <!--Internal  Perfect-scrollbar js -->
    <script src="{{URL::asset('assets/dashboard/assets/plugins/perfect-scrollbar/perfect-scrollbar.min.js')}}"></script>
    {{-- <script src="{{URL::asset('assets/dashboard/assets/plugins/perfect-scrollbar/p-scroll.js')}}"></script> --}}
@endif
<!--Internal Sparkline js -->
<script src="{{URL::asset('assets/dashboard/assets/plugins/jquery-sparkline/jquery.sparkline.min.js')}}"></script>
<!-- Custom Scroll bar Js-->
<script src="{{URL::asset('assets/dashboard/assets/plugins/mscrollbar/jquery.mCustomScrollbar.concat.min.js')}}"></script>
@if (Route::currentRouteName() != 'login')
    <!-- right-sidebar js -->
    @if ( Config::get('app.locale') == 'ar')
        <script src="{{URL::asset('assets/dashboard/assets/plugins/sidebar/sidebar-rtl.js')}}"></script>
    @else
        <script src="{{URL::asset('assets/dashboard/assets/plugins/sidebar/sidebar.js')}}"></script>
    @endif
    <script src="{{ URL::asset('assets/dashboard/assets/plugins/sidebar/sidebar-custom.js')}}"></script>
@endif
<!-- Eva-icons js -->
<script src="{{URL::asset('assets/dashboard/assets/js/eva-icons.min.js')}}"></script>
@yield('js')
@if (Route::currentRouteName() != 'login')
    <!-- Sticky js -->
    <script src="{{URL::asset('assets/dashboard/assets/js/sticky.js')}}"></script>
@endif
<!-- custom js -->
<script src="{{URL::asset('assets/dashboard/assets/js/custom.js')}}"></script><!-- Left-menu js-->
<script src="{{URL::asset('assets/dashboard/assets/plugins/side-menu/sidemenu.js')}}"></script>