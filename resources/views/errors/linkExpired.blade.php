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
				<img src="{{ asset('images/link_exp_img.png')}}" />
				<h3>Link Expired!</h3>
				<p>Your activation link has expired</p>
				<a href="{{route('login')}}" class="btn btn-green">Back to Sign In</a>
			</div>
		</div>
		<footer>
			<p class="copyright">&copy; {{date('Y')}} {{ env('APP_NAME','') }}</p>
		</footer>
	</body>
</html>
