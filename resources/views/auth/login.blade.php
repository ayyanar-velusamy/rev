@extends('layouts.auth')

@section('content')
<div class="login-page login-ml">
    <div class="container">
        <div class="row login-content-center">
            <div class="col-md-8 login-wrap">
				<!--<div class="card-header">{{ __('Login') }}</div>-->
				<div class="row">
					<div class="col-sm-12 col-md-12 login-card-left">
						<div class="login-inner">
							<img src="{{ asset('images/logo.png')}}" alt="logo" class="" />
							<!-- <h1>{{ __('Login') }}</h1> -->
							<h1>Sign In</h1>@if (session('success'))
								<div class="alert alert-success" role="alert">
									{{ session('success') }}
								</div>
							@endif
							@if (session('error'))
								<div class="alert alert-danger" role="alert">
									{{ session('error') }}
								</div>
							@endif
							<form class="ajax-form" method="POST" action="{{ route('login') }}" novalidate id="signin-form" > 
								@csrf
								<div class="form-group email-input">
									<div class="form-field">
										<input class="input_effect  @error('email') is-invalid @enderror" type="email" maxlength="64" value="{{ old('email') }}" name="email" id="email" required autocomplete="email" autofocus >
										<label>Enter Your Email ID <span>*</span></label>
										<span class="focus-border"></span>
										<i class="icon-mail"></i>
									</div>
									@error('email')
										<span class="invalid-feedback" role="alert">
											<strong>{{ $message }}</strong>
										</span>
									@enderror
								</div>

								<div class="form-group passwd-input m10">
									<div class="form-field">
										<input class="input_effect @error('password') is-invalid @enderror" type="password" name="password" id="password"  required autocomplete="current-password" autofocus />
										<label> Enter Your Password <span>*</span></label>
										<span class="focus-border"></span>
										<i class="icon-password"></i>
									</div>
									@error('password')
										<span class="invalid-feedback" role="alert">
											<strong>{{ $message }}</strong>
										</span>
									@enderror
								</div>
								
								<div class="form-group remember_check">
									<label for="remember">
										<input class="" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }} /><i></i> Remember Me</label>
								</div>

								<div class="form-group login-submtbtn">
									<button type="submit" class="btn blue-btn btn-primary" id="signin_submit" > 
										<!-- {{ __('Login') }} --> Sign In
									</button>
									@if (Route::has('password.request'))
										<a class="" href="{{ route('password.request') }}">
											Forgot Password?
										</a>
									@endif
								</div>
							</form>
							<p class="copyright">© {{date('Y')}} Revival</p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
