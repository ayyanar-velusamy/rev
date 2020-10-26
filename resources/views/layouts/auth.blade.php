<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
	
	<!-- Styles -->
	<link rel="icon" href="{{ asset('images/favicon.png') }}" type="image/gif" sizes="16x16">
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
    <link href="{{ asset('css/icomoon-style.css') }}" rel="stylesheet">
	<link href="{{ asset('css/jquery.toast.css') }}"   rel="stylesheet">
	
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800&display=swap" rel="stylesheet">
    <script>
		var is_logged_in = false;  
    </script>
</head>
<body>
	<div class="preloader" id="loader">
		<div class="loading-content"></div>
	</div>
	<div class="preloaderOne">
		<div class="loadingOne"></div>
	</div>
    <div id="app">
        <main class="main-content">
            @yield('content')
        </main>
    </div>
</body>
<!-- Scripts -->
<script src="{{ asset('js/jquery.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.min.js') }}"></script>
<script src="{{ asset('js/jquery.toast.js') }}"></script>
<script src="{{ asset('js/helper.js') }}"></script>
<script src="{{ asset('js/jquery.validate.min.js') }}"></script> 
<script src="{{ asset('js/auth/auth.js') }}"></script>
<script src="{{ asset('js/common.js') }}"></script>
<script src="{{ asset('js/custom.js') }}"></script> 
<script src="{{ asset('js/validation.js') }}"></script>
<!-- Common session based toast message start -->
@if(session('error_message'))
	<script>
		showMessage("{{ session('error_message') }}",'error','toastr')
	</script>
@endif
@if(session('success_message'))
	<script>
		showMessage("{{ session('success_message') }}",'success','toastr')
	</script>
@endif

<script>
	$(document).ajaxStop(function() {
		//console.log("ajaxstop");
		loaderReset('ajax');
	});
		
	setTimeout(function(){loaderReset('page')},200)
		
	function loaderReset(type){
		if(type == 'page'){
			$(".preloaderOne").css({'display':'none'});
		}
		$( "#display_id" ).css({'display':'block'});
		$(".preloader").css({'display':'none'});
		$( "body" ).css({'overflow':'visible'});
	}
</script>
<!-- Common session based toast message end --> 
</html>
