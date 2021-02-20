<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>@yield('title',config('app.name', 'Laravel'))</title>

    <!-- Stylesheets -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}"/><!-- bootstrap grid -->
    <link rel="stylesheet" href="{{ URL::asset('assets/forntend/css/style.css') }}"/><!-- bootstrap grid -->
    <link rel="stylesheet" href="{{ URL::asset('assets/forntend/css/responsive.css') }}"/><!-- bootstrap grid -->
    <!--tables-->
    <link type="text/css" rel="stylesheet" href="{{ URL::asset('assets/forntend/css/jquery.dataTables.css') }}" />
    <link type="text/css" rel="stylesheet" href="{{ URL::asset('assets/forntend/css/dataTables.colVis.css') }}" />
    <link type="text/css" rel="stylesheet" href="{{ URL::asset('assets/forntend/css/dataTables.tableTools.css') }}" />

    <link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
</head>
<body>
    <div class="wrapper" id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="login_button" id="show_login" href="{{ route('login') }}"><i class="fa fa-sign-in ml-1"></i>{{ __('تسجيل الدخول') }}</a>
                                </li>
                            @endif
                            
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="login_button" href="{{ route('register') }}">{{ __('تسجيل جديد') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-left" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('تسجيل الخروج') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>

    <script src="{{ URL::asset('assets/forntend/js/jquery-1.12.4.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/app.js') }}"></script>
    <!--tables-->
    <script src="{{ URL::asset('assets/forntend/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('assets/forntend/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ URL::asset('assets/forntend/js/buttons.flash.min.js') }}"></script>
    <script src="{{ URL::asset('assets/forntend/js/jszip.min.js') }}"></script>
    <script src="{{ URL::asset('assets/forntend/js/pdfmake.min.js') }}"></script>
    <script src="{{ URL::asset('assets/forntend/js/vfs_fonts.js') }}"></script>
    <script src="{{ URL::asset('assets/forntend/js/buttons.html5.min.js') }}"></script>
    <script src="{{ URL::asset('assets/forntend/js/buttons.print.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $("table.table td a").parents("td").css({				
            'direction':'ltr'
            });
            $('#example').DataTable( {
                //"dom": 'Blfrtip',
                "language": {
                    "lengthMenu": '_MENU_ إدخالات في الصفحة',
                    "search": '<i class="fa fa-search"></i>',
                    "paginate": {
                        "previous": '<i class="fa fa-angle-right"></i>',
                        "next": '<i class="fa fa-angle-left"></i>'
                    }
                },
                //"buttons": [
                //	'excel', 'print'
                //],
                initComplete: function () {
                this.api().columns().every( function () {
                    var column = this;
                    

                    var select = $('<select><option value="">اختر</option></select>')
                        .appendTo( $(column.header()) )
                        .on( 'change', function () {
                            var val = $.fn.dataTable.util.escapeRegex(
                                $(this).val()
                            );
                            column
                            .search( val ? '^'+val+'$' : '', true, false )
                            .draw();
                        } );
                        column.data().unique().sort().each( function ( d, j ) {
                            select.append( '<option value="'+d+'">'+d+'</option>' )
                        } );
                    } );
                }
            } );
            $(".no_filteration").find("select").remove();
            $('#example tbody').on('click', 'tr', function() {
                $(this).toggleClass('selected');
            });
        } );
    </script>
</body>
</html>
