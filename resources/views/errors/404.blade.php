<!DOCTYPE html>
<html>
<head>
	<link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600" rel="stylesheet">
</head>
<body>
	<div class="page_404">
		<div class="page_404_container">
			<div class="logo">
				<a href="{{ route('dashboard.index')}}"><img src="{{ asset('images/logo.png')}}" /></a>
			</div>
			<div class="inner_box">
				<img src="{{ asset('images/link_page404_img.png')}}" />
				<p>Sorry! The page you requested could not be found</p>
				<a href="{{ route('dashboard.index')}}" class="btn btn-green">go back to dashboard</a>
			</div>
			<p class="copyrights">© 2020 Learning Experience Platform</p>
		</div>
	</div>
</body>
</html>