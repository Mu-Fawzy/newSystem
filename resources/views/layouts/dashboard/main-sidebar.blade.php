<!-- main-sidebar -->
		<div class="app-sidebar__overlay" data-toggle="sidebar"></div>
		<aside class="app-sidebar sidebar-scroll">
			<div class="main-sidebar-header active">
				<a class="desktop-logo logo-light active" href="{{ route('admin.home') }}"><img src="{{URL::asset('assets/images/logo.png')}}" class="main-logo" alt="logo"></a>
				<a class="desktop-logo logo-dark active" href="{{ route('admin.home') }}"><img src="{{URL::asset('assets/images/logo.png')}}" class="main-logo dark-theme" alt="logo"></a>
				<a class="logo-icon mobile-logo icon-light active" href="{{ route('admin.home') }}"><img src="{{URL::asset('assets/images/logo.png')}}" class="logo-icon" alt="logo"></a>
				<a class="logo-icon mobile-logo icon-dark active" href="{{ route('admin.home') }}"><img src="{{URL::asset('assets/images/logo.png')}}" class="logo-icon dark-theme" alt="logo"></a>
			</div>
			<div class="main-sidemenu">
				<div class="app-sidebar__user clearfix">
					<div class="dropdown user-pro-body">
						<div class="">
							<img alt="user-img" class="avatar avatar-xl brround" src="{{URL::asset('assets/dashboard/assets/img/faces/6.jpg')}}"><span class="avatar-status profile-status bg-green"></span>
						</div>
						<div class="user-info">
							<h4 class="font-weight-semibold mt-3 mb-0">{{ Auth::user()->name }}</h4>
							@if(!empty(Auth::user()->getRoleNames()))
								<span class="mb-0 text-muted">@foreach(Auth::user()->getRoleNames() as $v)
									{{ $v }} @if ($loop->count > 1 &&!$loop->last) - @endif
								@endforeach</span>
							@endif
						</div>
					</div>
				</div>
				<ul class="side-menu">
					<li class="side-item side-item-category">{{ __('sidebar.dashboard') }}</li>
					<li class="slide">
						<a class="side-menu__item" href="{{ route('home.page') }}"><svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" viewBox="0 0 24 24" ><path d="M0 0h24v24H0V0z" fill="none"/><path d="M5 5h4v6H5zm10 8h4v6h-4zM5 17h4v2H5zM15 5h4v2h-4z" opacity=".3"/><path d="M3 13h8V3H3v10zm2-8h4v6H5V5zm8 16h8V11h-8v10zm2-8h4v6h-4v-6zM13 3v6h8V3h-8zm6 4h-4V5h4v2zM3 21h8v-6H3v6zm2-4h4v2H5v-2z"/></svg><span class="side-menu__label">{{ __('sidebar.visit site') }}</span></a>
					</li>

					@canany([__('content.role-list'),__('content.role-show'), __('content.role-create'), __('content.role-edit'), __('content.role-delete'),__('content.user-list'), __('content.user-show'), __('content.user-create'), __('content.user-edit'), __('content.user-delete')])
						<li class="side-item side-item-category">{{ __('sidebar.users managment') }}</li>

						@canany([__('content.user-list'), __('content.user-show'), __('content.user-create'), __('content.user-edit'), __('content.user-delete')])
						<li class="slide">
							<a class="side-menu__item" href="{{ route('users.index') }}"><svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" viewBox="0 0 24 24"><path d="M0 0h24v24H0V0z" fill="none"></path><path d="M12 4c-4.42 0-8 3.58-8 8s3.58 8 8 8 8-3.58 8-8-3.58-8-8-8zm3.5 4c.83 0 1.5.67 1.5 1.5s-.67 1.5-1.5 1.5-1.5-.67-1.5-1.5.67-1.5 1.5-1.5zm-7 0c.83 0 1.5.67 1.5 1.5S9.33 11 8.5 11 7 10.33 7 9.5 7.67 8 8.5 8zm3.5 9.5c-2.33 0-4.32-1.45-5.12-3.5h1.67c.7 1.19 1.97 2 3.45 2s2.76-.81 3.45-2h1.67c-.8 2.05-2.79 3.5-5.12 3.5z" opacity=".3"></path><circle cx="15.5" cy="9.5" r="1.5"></circle><circle cx="8.5" cy="9.5" r="1.5"></circle><path d="M12 16c-1.48 0-2.75-.81-3.45-2H6.88c.8 2.05 2.79 3.5 5.12 3.5s4.32-1.45 5.12-3.5h-1.67c-.69 1.19-1.97 2-3.45 2zm-.01-14C6.47 2 2 6.48 2 12s4.47 10 9.99 10C17.52 22 22 17.52 22 12S17.52 2 11.99 2zM12 20c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8z"></path></svg><span class="side-menu__label">{{ __('sidebar.users list') }}
							</span><span class="badge badge-success side-badge">
								@if (auth()->user()->hasRole( __('content.owner')))
									{{ \App\Models\User::count() }}	
								@else
									{{ \App\Models\User::whereHas('roles', function($q){ $q->where('name->'.Config::get('app.locale'),'NOT LIKE', Lang::get('content.owner',[], Config::get('app.locale'))); })->count() }}
								@endif
							</span></a>
						</li>
						@endcanany

						@canany([__('content.role-list'),__('content.role-show'), __('content.role-create'), __('content.role-edit'), __('content.role-delete')])
							<li class="slide">
								<a class="side-menu__item" href="{{ route('roles.index') }}"><svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" viewBox="0 0 24 24"><path d="M0 0h24v24H0V0z" fill="none"></path><path d="M6.26 9L12 13.47 17.74 9 12 4.53z" opacity=".3"></path><path d="M19.37 12.8l-7.38 5.74-7.37-5.73L3 14.07l9 7 9-7zM12 2L3 9l1.63 1.27L12 16l7.36-5.73L21 9l-9-7zm0 11.47L6.26 9 12 4.53 17.74 9 12 13.47z"></path></svg><span class="side-menu__label">{{ __('sidebar.roles list') }}</span><span class="badge badge-success side-badge">
									{{ \Spatie\Permission\Models\Role::where('name','<>', 'Owner')->count() }}
								</span></a>
							</li>
						@endcanany
					@endcanany
					
					@canany([__('content.contract-create'),__('content.contract-update'),__('content.contract-delete'),__('content.contract-move-to-archive'),__('content.restore'),__('content.contract-archive')])
						<li class="side-item side-item-category">{{ __('sidebar.contracts managment') }}</li>
						<li class="slide">
							<a class="side-menu__item" href="{{ route('contracts.index') }}"><svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" viewBox="0 0 24 24" ><path d="M0 0h24v24H0V0z" fill="none"/><path d="M5 5h4v6H5zm10 8h4v6h-4zM5 17h4v2H5zM15 5h4v2h-4z" opacity=".3"/><path d="M3 13h8V3H3v10zm2-8h4v6H5V5zm8 16h8V11h-8v10zm2-8h4v6h-4v-6zM13 3v6h8V3h-8zm6 4h-4V5h4v2zM3 21h8v-6H3v6zm2-4h4v2H5v-2z"/></svg><span class="side-menu__label">{{ __('sidebar.contracts list') }}</span><span class="badge badge-success side-badge">{{ \App\Models\Contract::count() }}</span></a>
						</li>
						@can(__('content.contract-create'))
							<li class="slide">
								<a class="side-menu__item" href="{{ route('contracts.create') }}"><svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" viewBox="0 0 24 24" ><path d="M0 0h24v24H0V0z" fill="none"/><path d="M5 5h4v6H5zm10 8h4v6h-4zM5 17h4v2H5zM15 5h4v2h-4z" opacity=".3"/><path d="M3 13h8V3H3v10zm2-8h4v6H5V5zm8 16h8V11h-8v10zm2-8h4v6h-4v-6zM13 3v6h8V3h-8zm6 4h-4V5h4v2zM3 21h8v-6H3v6zm2-4h4v2H5v-2z"/></svg><span class="side-menu__label">{{ __('sidebar.add new') }}</span></a>
							</li>
						@endcan
					@endcanany
		
					@canany([__('content.subcontractor-list'),__('content.subcontractor-trashed'),__('content.subcontractor-restore'),__('content.subcontractor-create'),__('content.subcontractor-edit'),__('content.subcontractor-delete'),__('content.subcontractor-deletefile')])
						<li class="side-item side-item-category">{{ __('sidebar.subContractors managment') }}</li>
						<li class="slide">
							<a class="side-menu__item" href="{{ route('subcontractors.index') }}"><svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" viewBox="0 0 24 24" ><path d="M0 0h24v24H0V0z" fill="none"/><path d="M5 5h4v6H5zm10 8h4v6h-4zM5 17h4v2H5zM15 5h4v2h-4z" opacity=".3"/><path d="M3 13h8V3H3v10zm2-8h4v6H5V5zm8 16h8V11h-8v10zm2-8h4v6h-4v-6zM13 3v6h8V3h-8zm6 4h-4V5h4v2zM3 21h8v-6H3v6zm2-4h4v2H5v-2z"/></svg><span class="side-menu__label">{{ __('sidebar.subContractors list') }}</span><span class="badge badge-success side-badge">{{ \App\Models\Subcontractor::count() }}</span></a>
						</li>

						@can(__('content.subcontractor-create'))
							<li class="slide">
								<a class="side-menu__item" href="{{ route('subcontractors.create') }}"><svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" viewBox="0 0 24 24" ><path d="M0 0h24v24H0V0z" fill="none"/><path d="M5 5h4v6H5zm10 8h4v6h-4zM5 17h4v2H5zM15 5h4v2h-4z" opacity=".3"/><path d="M3 13h8V3H3v10zm2-8h4v6H5V5zm8 16h8V11h-8v10zm2-8h4v6h-4v-6zM13 3v6h8V3h-8zm6 4h-4V5h4v2zM3 21h8v-6H3v6zm2-4h4v2H5v-2z"/></svg><span class="side-menu__label">{{ __('sidebar.add new') }}</span></a>
							</li>
						@endcan
					@endcanany

					@canany([__('content.work-list'), __('content.work-create'), __('content.work-update'), __('content.work-delete')])
						<li class="side-item side-item-category">{{ __('sidebar.work sites & items') }}</li>

						<li class="slide">
							<a class="side-menu__item" href="{{ route('worksites.index') }}"><svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" viewBox="0 0 24 24" ><path d="M0 0h24v24H0V0z" fill="none"/><path d="M5 5h4v6H5zm10 8h4v6h-4zM5 17h4v2H5zM15 5h4v2h-4z" opacity=".3"/><path d="M3 13h8V3H3v10zm2-8h4v6H5V5zm8 16h8V11h-8v10zm2-8h4v6h-4v-6zM13 3v6h8V3h-8zm6 4h-4V5h4v2zM3 21h8v-6H3v6zm2-4h4v2H5v-2z"/></svg><span class="side-menu__label">{{ __('sidebar.wrok sites list') }}</span><span class="badge badge-success side-badge">{{ \App\Models\Worksite::count() }}</span></a>
						</li>

						<li class="slide">
							<a class="side-menu__item" href="{{ route('workitems.index') }}"><svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" viewBox="0 0 24 24" ><path d="M0 0h24v24H0V0z" fill="none"/><path d="M5 5h4v6H5zm10 8h4v6h-4zM5 17h4v2H5zM15 5h4v2h-4z" opacity=".3"/><path d="M3 13h8V3H3v10zm2-8h4v6H5V5zm8 16h8V11h-8v10zm2-8h4v6h-4v-6zM13 3v6h8V3h-8zm6 4h-4V5h4v2zM3 21h8v-6H3v6zm2-4h4v2H5v-2z"/></svg><span class="side-menu__label">{{ __('sidebar.wrok items list') }}</span><span class="badge badge-success side-badge">{{ \App\Models\Workitem::count() }}</span></a>
						</li>
					@endcanany

				</ul>
			</div>
		</aside>
<!-- main-sidebar -->
