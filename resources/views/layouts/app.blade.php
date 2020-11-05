<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <title>{{ config('app.name', 'Laravel') }}</title>
  <meta charset="utf-8">
  <link rel="icon" href="{{ asset('images/favicon.png') }}" type="image/gif" sizes="16x16">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="{{ asset('css/jquery.toast.css') }}"   rel="stylesheet">
  <link href="{{ asset('css/jquery.dataTables.min.css') }}" rel="stylesheet">
  <link href="{{ asset('css/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
  <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('css/icomoon-style.css') }}" rel="stylesheet">
  <link href="{{ asset('css/jquery.orgchart.css') }}" rel="stylesheet" type="text/css">
  <link href="{{ asset('css/jquery.treeview.css') }}" rel="stylesheet" type="text/css">
  <link href="{{ asset('css/jquery.mCustomScrollbar.css') }}" rel="stylesheet" type="text/css"> 
  <link href="{{ asset('css/croppie.css') }}" rel="stylesheet">  
  <link href="{{ asset('css/select2.min.css') }}" rel="stylesheet">  
  <link href="{{ asset('css/jquery-ui.css') }}" rel="stylesheet">  
  <link href="{{ asset('css/jquery.comiseo.daterangepicker.css') }}" rel="stylesheet">  
  <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
  
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600" rel="stylesheet">
  <script>
		var is_logged_in = true;  
  </script>
</head>
<body>
<div class="preloader" id="loader">
	<div class="loading-content"></div>
</div>
<div class="preloaderOne">
	<div class="loadingOne"></div>
</div>
<script>
	var APP_URL = "{{config('app.url')}}";
</script>
<header>
	<div class="container-fluid">
		<div class="header">
			<div class="row">
				<div class="col-md-1 left-side-navbar text-center"> 
					<span class="sidemenu_list expand "><img src="{{ asset('images/menu-icon.png')}}" class="img-responsive" alt="Menu Icon" /></span>
				</div>
				<div class="col-md-2 logo">
					<a href="{{ url('/') }}">
						<img src="{{ asset('images/dash-logo.png')}}" alt="logo" class="img-responsive" />
					</a>
				</div>
				<div class="col-md-5 empty"></div>
				<div class="col-md-4 header-right">
					<div class="row">
						<div class="col-md-6 col-xs-6 col-lg-6 header_emmpty">
						</div>
						<div class="col-md-2 col-xs-2 col-lg-2 header_icons">
							<div class="notification padding-left-none">
								<ul class="nav navbar-nav">
									<li class="nav-item">
										<a class="nav-link"  data-toggle="modal" data-target="#notification_modal" href="javascript:"><i class="icon-notification" title="Notification"><span class="count">{{ count(auth()->user()->unreadNotifications) }}</span></i></a>
									</li>
								</ul>
							</div>
						</div>		
						<div class="head_admin admin col-md-4 col-lg-4 col-xs-4 text-right padding-none">
							<div class="row">
								<div class="admin_txt">
									<h3>Hello <span>{{ Auth::user()->full_name ?? "" }}</span></h3>
								</div>
								<div class="admin_img">
									<div class="admin_img_iner">
										@if(Auth::user()->image != "")
											<img width=150 src="{{ profile_image(Auth::user()->image) }}" class="img-responsive" alt="Profile Picture">
										@else
											<img width=150 src="{{asset('images/user_profile.png') }}" class="img-responsive" alt="Profile Picture">
										@endif
										<div class="admin_img_arrow">
											<img src="{{ asset('images/down_arrrow.png')}}" class="img-responsive" alt="down_arrrow" />
										</div>
									</div>
									<div class="admin_img_drop"  style="display:none;">
										<ul class="list-unstyled">
											<li><a href="/profile">My Profile <i class="icon-passport" title="Passport"></i></a></li>
											<li><a href="javascript:" data-toggle="modal" data-target="#signout_persmision" >{{ __('Sign Out') }}<i class="icon-logout" title="Sign Out"></i></a></li>
										</ul>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</header>
<div class="page-wrap">    
<div class="container-fluid">    
  <div class="row content">
	@include('common.sidebar')
    <div class="col-sm-11 main_sec text-left"> 
      @yield('content')
    </div>
  </div>
</div>
<!--Notification Modal-->
<div class="modal right fade" id="notification_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="btn-close" data-dismiss="modal" title="Close" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h3 class="modal-title">Notification</h3>
			</div>
			<div class="modal-body" id="scrollbar">
				<ul class="list-unstyled notification_list">
				  @foreach (auth()->user()->unreadNotifications as $notification)
					@include('notifications.'.snake_case(class_basename($notification->type)))
				  @endforeach
				  @if(count(auth()->user()->unreadNotifications) == 0)
					  <li>No notification found</li>
				  @endif
				</ul>
				
			</div>
		</div>
	</div>
</div>

<!--SignOut permission-->
<div id="signout_persmision" class="modal fade in" role="dialog" data-backdrop="static">
	<div class="modal-dialog modal-dialog-centered">
	<!-- Modal content-->
		<div class="modal-content text-left">
			<div class="modal-header">
				<h2>Sign Out</h2>
				<button type="button" class="btn-close" title="Close" data-dismiss="modal">x</button>
			</div>
			<div class="modal-body text-center">
				<h4><span>Are you sure </span>you want to Sign Out?</h4>
				<div class="PTB20 btn-footer">
					<button type="button" class="btn-grey btn" data-dismiss="modal">No</button>
					<a class="btn-green btn" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Yes</a>
					<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
						@csrf
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<script src="https://cdn.jsdelivr.net/npm/lodash@4.17.15/lodash.min.js"></script>
<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>-->
<script src="{{ asset('js/jquery.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.min.js') }}"></script>
<script src="{{ asset('js/croppie.js') }}"></script> 
<script src="{{ asset('js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('js/jquery.toast.js') }}"></script>
<script src="{{ asset('js/helper.js') }}"></script>
<script src="{{ asset('js/jquery.validate.min.js') }}"></script>  
<script src="{{ asset('js/jquery.timeago.js') }}"></script> 
<script src="{{ asset('js/moment.min.js') }}"></script> 
<script src="{{ asset('js/common.js') }}"></script>
<script src="{{ asset('js/jquery.mCustomScrollbar.concat.min.js') }}"></script>
<script src="{{ asset('js/select2.min.js') }}"></script>
<script src="{{ asset('js/jquery-ui.js') }}"></script>
<script src="{{ asset('js/jquery.comiseo.daterangepicker.js') }}"></script>
<script src="{{ asset('js/underscore-min.js') }}"></script> 
<script src="{{ asset('js/highcharts.js') }}"></script> 
<script src="{{ asset('js/custom.js') }}"></script> 
<script src="{{ asset('js/validation.js') }}"></script> 
<script src="{{ asset('plugins/ckeditor/ckeditor.js') }}"></script> 

<script type="text/javascript">
    $(document).ready(function () {
        //$('.ckeditor').ckeditor();
    });
	
</script>

<script type="text/javascript">

	$.ajaxSetup({
		headers: {
		'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});

	$(document).ready(function(){
		$(".preloader").css({'display':'block'});
		setTimeout(function(){ $(".preloader").fadeOut(); }, 400) 
		setTimeout(function(){ $("#display_id").fadeIn(); }, 300) 
	});

	$(document).ajaxStart(function() {
		var url = '{{route("check_user_status")}}';
		$.ajax({ 
			type: 'GET',
			url: url,
			dataType: "json",
			success: function(response){
				if(response.status){
					if(response.user_status != 'active'){
						resetBackConfirmAlert();
						window.location.href = "{{route('login')}}";
					}
				}
			},
			error:function(jqXHR, textStatus, errorThrown) {				
				if(jqXHR.status){
					resetBackConfirmAlert();
					window.location.href = "{{route('login')}}";
				}
			}
		});						
	});

	function log(text){
		$('#consoleOutput').append('<p>'+text+'</p>')
	}

	$(document).ajaxStop(function() {
		//console.log("ajaxstop");
		loaderReset('ajax');
	});
		
	setTimeout(function(){loaderReset('page')},1000)
		
	function loaderReset(type){
		if(type == 'page'){
			$(".preloaderOne").css({'display':'none'});
		}
		$( "#display_id" ).css({'display':'block'});
		$(".preloader").css({'display':'none'});
		$( "body" ).css({'overflow':'visible'});
	}

	
	
</script>
@yield('footer_script')

<!-- Controller / Method base js loading here-->
{{ moduleJs()}}

<!-- Common session based toast message start -->
@if(Session::has('error_message'))
	<script>
		showMessage("{!!Session::get('error_message')!!}",'error','toastr')
	</script>
@endif
@if(Session::has('success_message'))
	<script>
		showMessage("{!!Session::get('success_message')!!}",'success','toastr')
	</script>
@endif
<!-- Common session based toast message end -->
</body>
</html>


