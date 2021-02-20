@extends('layouts.dashboard.master2')
@section('title', __('content.login'))
@section('css')
<!-- Sidemenu-respoansive-tabs css -->
<link href="{{URL::asset('assets/dashboard/assets/plugins/sidemenu-responsive-tabs/css/sidemenu-responsive-tabs.css')}}" rel="stylesheet">
@endsection
@section('content')
		<div class="container-fluid">
			<div class="row no-gutter">
				<!-- The image half -->
				<div class="col-md-6 col-lg-6 col-xl-7 d-none d-md-flex bg-primary-transparent">
					<div class="row wd-100p mx-auto text-center">
						<div class="col-md-12 col-lg-12 col-xl-12 my-auto mx-auto wd-100p">
							<img src="{{URL::asset('assets/images/logo.png')}}" class="my-auto ht-xl-40p wd-md-100p wd-xl-40p mx-auto" alt="logo">
						</div>
					</div>
				</div>
				<!-- The content half -->
				<div class="col-md-6 col-lg-6 col-xl-5 bg-white">
					<div class="login d-flex align-items-center py-2">
						<!-- Demo content-->
						<div class="container p-0">
							<div class="row">
								<div class="col-md-10 col-lg-10 col-xl-9 mx-auto">
									<div class="card-sigin">
										<div class="mb-5 text-center"> <h1><a href="{{ route('admin.home') }}"><img src="{{URL::asset('assets/images/logo.png')}}" class="sign-favicon ht-100" alt="logo"></a></h1></div>
										<div class="card-sigin">
											<div class="main-signup-header">
												<div class="text-center">
													<h2>{{ __('content.welcome back!') }}</h2>
													<h5 class="font-weight-semibold mb-4">{{ __('content.please sign in to continue.') }}</h5>
												</div>
												<form method="POST" action="{{ route('login') }}">
                                                    @csrf
													<div class="form-group">
														<label for="email">{{ __('validation.attributes.email') }}</label> 
														<input id="email" class="form-control @error('email') is-invalid @enderror" placeholder="{{ __('content.please enter your email') }}" type="email" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
														@error('email')
															<span class="invalid-feedback" role="alert">
																<strong>{{ $message }}</strong>
															</span>
														@enderror
													</div>
													<div class="form-group">
														<label for="password">{{ __('validation.attributes.password') }}</label> 
														<input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="{{ __('content.please enter your password') }}">
														@error('password')
															<span class="invalid-feedback" role="alert">
																<strong>{{ $message }}</strong>
															</span>
														@enderror
													</div>

													<div class="form-group">
														<div class="form-check">
															<input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
						
															<label class="form-check-label" for="remember">
																{{ __('content.remeber me') }}
															</label>
														</div>
													</div>

													<button type="submit" class="btn btn-main-primary btn-block">{{ __('content.login') }}</button>
													
												</form>
												<div class="main-signin-footer mt-5">
                                                    @if (Route::has('password.request'))
                                                        <p><a href="{{ route('password.request') }}">
															{{ __('content.forgot your password ?') }}
														</a></p>
                                                    @endif
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div><!-- End -->
					</div>
				</div><!-- End -->
			</div>
		</div>
@endsection
@section('js')
@endsection