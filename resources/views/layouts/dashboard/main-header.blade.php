<!-- main-header opened -->
			<div class="main-header sticky side-header nav nav-item">
				<div class="container-fluid">
					<div class="main-header-left ">
						<div class="responsive-logo">
							<a href="{{ route('admin.home') }}"><img src="{{URL::asset('assets/images/logo.png')}}" class="logo-1" alt="logo"></a>
							<a href="{{ route('admin.home') }}"><img src="{{URL::asset('assets/images/logo.png')}}" class="dark-logo-1" alt="logo"></a>
							<a href="{{ route('admin.home') }}"><img src="{{URL::asset('assets/images/logo.png')}}" class="logo-2" alt="logo"></a>
							<a href="{{ route('admin.home') }}"><img src="{{URL::asset('assets/images/logo.png')}}" class="dark-logo-2" alt="logo"></a>
						</div>
						<div class="app-sidebar__toggle" data-toggle="sidebar">
							<a class="open-toggle" href="#"><i class="header-icon fe fe-align-left" ></i></a>
							<a class="close-toggle" href="#"><i class="header-icons fe fe-x"></i></a>
						</div>
						<div class="main-header-center mr-3 d-sm-none d-md-none d-lg-block">

							@if (str_contains(Route::currentRouteName(), 'users'))
								@php $route = route('users.index'); @endphp
							@elseif(str_contains(Route::currentRouteName(), 'roles'))
								@php $route = route('roles.index'); @endphp
							@elseif(str_contains(Route::currentRouteName(), 'subcontractors'))
								@php $route = route('subcontractors.index'); @endphp
							@elseif(str_contains(Route::currentRouteName(), 'contracts'))
								@php $route = route('contracts.index'); @endphp
							@elseif(str_contains(Route::currentRouteName(), 'worksites'))
								@php $route = route('worksites.index'); @endphp
							@elseif(str_contains(Route::currentRouteName(), 'workitems'))
								@php $route = route('workitems.index'); @endphp
							@else
								@php $route = route(Route::currentRouteName()); @endphp
							@endif

							<form action="{{ $route }}" method="GET">
								<input class="form-control" placeholder="@if (isset($searchText)) {{ __('content.search for')." ".$searchText."..." }} @else {{ __('content.search here...') }} @endif" name="search" type="search" value="{{ request()->search }}"> 
								<button class="btn" type="submit"><i class="fas fa-search d-none d-md-block"></i></button>
							</form>
						</div>
					</div>
					<div class="main-header-right">
						<ul class="nav">
							<li class="">
								<div class="dropdown  nav-itemd-none d-md-flex">
									<a href="#" class="d-flex  nav-item nav-link pl-0 country-flag1" data-toggle="dropdown" aria-expanded="false">
										<div class="my-auto btn btn-primary">
											{{ LaravelLocalization::getCurrentLocaleNative() }}
										</div>
									</a>
									<div class="dropdown-menu dropdown-menu-left dropdown-menu-arrow" x-placement="bottom-end">
										@foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
											<a rel="alternate" hreflang="{{ $localeCode }}" href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}" class="dropdown-item d-flex ">
												<div class="d-flex">
													<span class="mt-2">{{ $properties['native'] }}</span>
												</div>
											</a>
										@endforeach
									</div>
								</div>
							</li>
						</ul>
						<div class="nav nav-item  navbar-nav-right ml-auto">
							<div class="nav-link" id="bs-example-navbar-collapse-1">
								<form class="navbar-form" action="{{ $route }}" method="GET" role="search">
									<div class="input-group">
										<input type="text" name="search" class="form-control" placeholder="@if (isset($searchText)) {{ __('content.search for')." ".$searchText."..." }} @else {{ __('content.search here...') }} @endif" value="{{ request()->search }}">
										<span class="input-group-btn">
											<button type="reset" class="btn btn-default">
												<i class="fas fa-times"></i>
											</button>
											<button type="submit" class="btn btn-default nav-link resp-btn">
												<svg xmlns="http://www.w3.org/2000/svg" class="header-icon-svgs" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
											</button>
										</span>
									</div>
								</form>
							</div>
							<div class="nav-item full-screen fullscreen-button">
								<a class="new nav-link full-screen-link" href="#"><svg xmlns="http://www.w3.org/2000/svg" class="header-icon-svgs" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-maximize"><path d="M8 3H5a2 2 0 0 0-2 2v3m18 0V5a2 2 0 0 0-2-2h-3m0 18h3a2 2 0 0 0 2-2v-3M3 16v3a2 2 0 0 0 2 2h3"></path></svg></a>
							</div>
							@auth
								<div class="dropdown main-profile-menu nav nav-item nav-link">
									<a class="profile-user d-flex" href=""><img alt="" src="{{URL::asset('assets/dashboard/assets/img/faces/6.jpg')}}"></a>
									<div class="dropdown-menu">
										<div class="main-header-profile bg-primary p-3">
											<div class="d-flex wd-100p">
												<div class="main-img-user"><img alt="" src="{{URL::asset('assets/dashboard/assets/img/faces/6.jpg')}}" class=""></div>
												<div class="mr-3 my-auto">
													<h6>{{ Auth::user()->name }}</h6>
													
													@if(!empty(Auth::user()->getRoleNames()))
														<span>@foreach(Auth::user()->getRoleNames() as $v)
															{{ $v }} @if ($loop->count > 1 &&!$loop->last) - @endif
														@endforeach</span>
													@endif
												</div>
											</div>
										</div>
										<a class="dropdown-item" href="{{ route('users.edit', auth()->id()) }}"><i class="bx bx-cog"></i> {{ __('content.edit profile') }}</a>
										<a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="bx bx-log-out"></i>{{ __('content.sign out') }}</a>

										<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
											@csrf
										</form>
									</div>
								</div>
							@endauth
						</div>
					</div>
				</div>
			</div>
<!-- /main-header -->
