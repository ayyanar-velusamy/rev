@extends('layouts.auth')

@section('content')
<div class="login-page forg-passwd-page">
    <div class="container">
        <div class="row login-content-center">
            <div class="col-md-12 login-wrap">
				<!-- <div class="card-header">{{ __('Reset Password') }}</div> -->
				<div class="row">
					<div class="col-md-8 login-card-left">
						<div class="login-inner">
								<img src="{{ asset('images/logo.png')}}" alt="logo" class="" />
								<!-- <h1>{{ __('Reset Password') }}</h1> -->
								<h1>Forgot Password</h1>
							@if (session('success'))
								<div class="alert alert-success" role="alert">
									{{ session('success') }}
								</div>
							@endif
							@if (session('error'))
								<div class="alert alert-danger" role="alert">
									{{ session('error') }}
								</div>
							@endif
							<form class="ajax-form" method="POST" action="{{ route('password.email') }}" novalidate id="forget_form">
								@csrf
								<div class="form-group email-input">
									<div class="form-field">
										<input class="input_effect  @error('email') is-invalid @enderror" maxlength="64" type="email" value="{{ old('email') }}" name="email" id="email" required autocomplete="email" autofocus >
										<label>Enter Your Email ID *</label>
										<span class="focus-border"></span>
										<i class="icon-mail"></i>
									</div>
									@error('email')
										<span class="invalid-feedback" role="alert">
											<strong>{{ $message }}</strong>
										</span>
									@enderror
								</div>
								<div class="form-group login-submtbtn ">
									<button type="submit" id="forget_submit" class="btn blue-btn btn-primary">
										<!--{{ __('Send Password Reset Link') }}-->
										Submit
									</button>
									<p>Back to <a href="{{route('login')}}">Sign In</a></p>
								</div>
							</form>
							<p class="copyright">©{{date('Y')}} Revival</p>
						</div>
					</div>
				</div>
			</div>
        </div>
    </div>
</div>
@endsection
