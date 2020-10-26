@extends('layouts.auth')
@section('content')
@if(isset($user) && !empty($user))
@if($user->status == 'active')
<div class="login-page reset-passwd-page">
    <div class="container">
        <div class="row login-content-center">
            <div class="col-md-12 login-wrap">
                <!--<div class="card-header">{{ __('Reset Password') }}</div>-->
				<div class="row">
					<div class="col-md-8 login-card-left">
						<div class="login-inner">
							<img src="{{ asset('images/logo.png')}}" alt="logo" class="" />
							<h1>{{ __('Set Password') }}</h1>
							<form class="ajax-form" method="POST" action="{{ route('set_password') }}" novalidate id="set_form" >
								@csrf
								<input type="hidden" name="token" value="{{ $token }}">

								<div class="form-group passwd-input">
									<div class="form-field">
										<input class="input_effect @error('password') is-invalid @enderror" type="password" name="password" id="password" required autocomplete="current-password" autofocus />
										<label>Enter New Password *</label>
										<span class="focus-border"></span>
										<i class="icon-password"></i>
									</div>
									@error('password')
										<span class="invalid-feedback" role="alert">
											<strong>{{ $message }}</strong>
										</span>
									@enderror
								</div>
								
								<div class="form-group confpasswd-input">
									<div class="form-field">
										<input class="input_effect" type="password" name="password_confirmation" id="password-confirm" required autocomplete="new-password" >
										<label>Enter Confirm Password *</label>
										<span class="focus-border"></span>
										<i class="icon-password"></i>
									</div>
								</div>
								
								<div class="form-group login-submtbtn ">
									<button type="submit" id="set_submit" class="btn blue-btn btn-primary">
										<!--{{ __('Reset Password') }}-->
										Submit
									</button>
								</div>
							</form>
							<p class="copyright">© {{date('Y')}} Learning Experience Platform</p>
						</div>
					</div>
                </div>
			</div>
		</div>
	</div>
</div>
@else
<!DOCTYPE html>
<html>
	<head>
		<link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
		<link href="{{ asset('css/custom.css') }}" rel="stylesheet">
	</head>
	<body class="link_expire_page">
		<header>
			<div class="logo">
				<a href="{{route('login')}}"><img src="{{ asset('images/link_exp_logo.png')}}" /></a>
			</div>
		</header>
		<div class="main">
			<div class="link_expire">
				<h3>Account Inactive!</h3>
				<p>Please contact your management for more info.</p>
				<a href="{{route('login')}}" class="btn btn-green">Back to Sign In</a>
			</div>
		</div>
		<footer>
			<p class="copyright">&copy; {{date('Y')}} {{ env('APP_NAME','') }}</p>
		</footer>
	</body>
</html>
@endif
@else
	
@endif
@endsection
