<!DOCTYPE html>
<html dir="ltr" lang="en">


<head>

<!-- Meta Tags -->
<meta name="viewport" content="width=device-width,initial-scale=1.0"/>
<meta http-equiv="content-type" content="text/html; charset=UTF-8"/>


<!-- Favicon and Touch Icons -->
<link href="{{ asset('revival/images/favicon.png') }}" rel="shortcut icon" type="image/png">
<link href="{{ asset('revival/images/apple-touch-icon.png') }}" rel="apple-touch-icon">
<link href="{{ asset('revival/images/apple-touch-icon-72x72.png') }}" rel="apple-touch-icon" sizes="72x72">
<link href="{{ asset('revival/images/apple-touch-icon-114x114.png') }}" rel="apple-touch-icon" sizes="114x114">
<link href="{{ asset('revival/images/apple-touch-icon-144x144.png') }}" rel="apple-touch-icon" sizes="144x144">

<!-- Stylesheet -->
<link href="{{ asset('revival/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset('revival/css/jquery-ui.min.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset('revival/css/animate.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset('revival/css/css-plugin-collections.css') }}" rel="stylesheet"/>
<!-- CSS | menuzord megamenu skins -->
<link id="menuzord-menu-skins" href="{{ asset('revival/css/menuzord-skins/menuzord-rounded-boxed.css') }}" rel="stylesheet"/>
<!-- CSS | Main style file -->
<link href="{{ asset('revival/css/style-main.css') }}" rel="stylesheet" type="text/css">
<!-- CSS | Preloader Styles -->
<link href="{{ asset('revival/css/preloader.css') }}" rel="stylesheet" type="text/css">
<!-- CSS | Custom Margin Padding Collection -->
<link href="{{ asset('revival/css/custom-bootstrap-margin-padding.css') }}" rel="stylesheet" type="text/css">
<!-- CSS | Responsive media queries -->
<link href="{{ asset('revival/css/responsive.css') }}" rel="stylesheet" type="text/css">


<!-- Revolution Slider 5.x CSS settings -->
<link  href="{{ asset('revival/js/revolution-slider/css/settings.css') }}" rel="stylesheet" type="text/css"/>
<link  href="{{ asset('revival/js/revolution-slider/css/layers.css') }}" rel="stylesheet" type="text/css"/>
<link  href="{{ asset('revival/js/revolution-slider/css/navigation.css') }}" rel="stylesheet" type="text/css"/>

<!-- CSS | Theme Color -->
<link href="{{ asset('revival/css/colors/theme-skin-color-set-1.css') }}" rel="stylesheet" type="text/css">

<!-- external javascripts -->
<script src="{{ asset('revival/js/jquery-2.2.4.min.js') }}"></script>
<script src="{{ asset('revival/js/jquery-ui.min.js') }}"></script>
<script src="{{ asset('revival/js/bootstrap.min.js') }}"></script>
<!-- JS | jquery plugin collection for this theme -->
<script src="{{ asset('revival/js/jquery-plugin-collection.js') }}"></script>

<!-- Revolution Slider 5.x SCRIPTS -->
<script src="{{ asset('revival/js/revolution-slider/js/jquery.themepunch.tools.min.js') }}"></script>
<script src="{{ asset('revival/js/revolution-slider/js/jquery.themepunch.revolution.min.js') }}"></script>


</head>
<body class="">
<div id="wrapper" class="clearfix">
  <!-- preloader -->
  <div id="preloader">
    <div id="spinner">
      <img alt="" src="{{ asset('revival/images/preloaders/5.gif') }}">
    </div>
    
  </div>
  
  <!-- Header -->
  <header id="header" class="header">
    <div class="header-top bg-theme-color-2 sm-text-center">
      <div class="container">
        <div class="row">
          <div class="col-md-8">
            <div class="widget no-border m-0">
              <ul class="list-inline">
                <li class="m-0 pl-10 pr-10"> <i class="fa fa-phone text-white"></i> <a class="text-white" href="tel:888-225-6905">&nbsp;888-225-6905</a></li>
                <li class="m-0 pl-10 pr-10"> <i class="fa fa-fax text-white"></i> <a class="text-white" href="fax:888-225-6905">&nbsp;888-801-4714</a> </li>
                <li class="m-0 pl-10 pr-10"> <i class="fa fa-envelope text-white"></i> <a class="text-white" href="mailto:info@revivalhha.com">&nbsp;info@revivalhha.com</a> </li>
              </ul>
            </div>
          </div>

          <div class="col-md-4">
            <div class="widget no-border m-0">
              <ul class="list-inline text-right sm-text-center">
                <li>
                  <a href="#" class="text-white">Contact us today for free Consultation !</a>
                </li>
                
              </ul>
            </div>
          </div>
          
        </div>
      </div>
    </div>
    <div class="header-nav">
      <div class="header-nav-wrapper navbar-scrolltofixed bg-white">
        <div class="container">
          <nav id="menuzord-right" class="menuzord default">
            <a class="menuzord-brand pull-left flip" href="javascript:void(0)">
              <img src="{{ asset('revival/images/logo-wide.png') }}" alt="">
            </a>
            <ul class="menuzord-menu">
            <li class="{{ request()->is('/') ? 'active' : '' }}"><a href="{{ route('index')}}">Home</a>
              </li>
              <li class="{{ request()->is('about-us') ? 'active' : '' }}"><a href="{{ route('about-us')}}">About Us</a>
                <ul class="dropdown">
                  <li><a href="{{ route('history')}}" class="{{ request()->is('history') ? 'active' : '' }}">History</a></li>
                  <li><a href="{{ route('quality-measures')}}" class="{{ request()->is('quality-measures') ? 'active' : '' }}" href="#">Quality Measures</a></li>
                </ul>
              </li>
              <li ><a href="#home">Our Services</a>
              </li>
              <li ><a href="#home">Careers</a>
              </li>
              <li ><a href="#home">Resources</a>
              </li>
              <li ><a href="#home">Contact Us</a>
              </li>
              
            </ul>
          </nav>
        </div>
      </div>
    </div>
  </header>
  @yield('content')

   <!-- Footer -->
   <footer id="footer" class="footer bg-white-222" data-bg-img="images/footer-bg.png">
    <div class="container pt-70 pb-40">
      <div class="row">
        <div class="col-sm-6 col-md-3">
          <div class="widget dark">
            <img class="mt-10 mb-15" alt="" src="asset('revival/images/logo-wide-white.png') }}">
            <p class="font-16 mb-10">Revival Homecare Agency. Our agency exists to provide you and our community with health services that bring comfort in a familiar setting, your home.</p>
            <a class="font-14" href="#"><i class="fa fa-angle-double-right text-theme-colored"></i> Submit your referrals</a>
            <ul class="styled-icons icon-dark mt-20">
              <li class="wow fadeInLeft" data-wow-duration="1.5s" data-wow-delay=".1s" data-wow-offset="10"><a href="#" data-bg-color="#3B5998"><i class="fa fa-facebook"></i></a></li>
              <li class="wow fadeInLeft" data-wow-duration="1.5s" data-wow-delay=".2s" data-wow-offset="10"><a href="#" data-bg-color="#02B0E8"><i class="fa fa-twitter"></i></a></li>
              <li class="wow fadeInLeft" data-wow-duration="1.5s" data-wow-delay=".3s" data-wow-offset="10"><a href="#" data-bg-color="#05A7E3"><i class="fa fa-skype"></i></a></li>
              <li class="wow fadeInLeft" data-wow-duration="1.5s" data-wow-delay=".4s" data-wow-offset="10"><a href="#" data-bg-color="#A11312"><i class="fa fa-google-plus"></i></a></li>
              <li class="wow fadeInLeft" data-wow-duration="1.5s" data-wow-delay=".5s" data-wow-offset="10"><a href="#" data-bg-color="#C22E2A"><i class="fa fa-youtube"></i></a></li>
            </ul>
          </div>
        </div>
        <div class="col-sm-6 col-md-3">
         
        </div>
        <div class="col-sm-6 col-md-3">
          <div class="widget dark">
            <h5 class="">Useful Links</h5>
            <ul class="list-border">
              <li><a href="/">Home</a></li>
              <li><a href="#">About us</a></li>
              <li><a href="#">Our Services</a></li>
              <li><a href="#">Careers</a></li>
              <li><a href="#">Resources</a></li>
              <li><a href="#">Contact Us</a></li>
            </ul>
          </div>
        </div>
        <div class="col-sm-6 col-md-3">
          <div class="widget dark">
            <h5 class="">Quick Contact</h5>
            <ul class="list-border">
              <li><i class="fa fa-phone "></i> <a href="tel:888-801-4714">888-801-4714</a></li>
              <li><i class="fa fa-fax "></i> <a href="fax:888-225-6905">888-225-6905</a></li>
              <li><i class="fa fa-envelope "></i> <a href="mailto:info@revivalhha.com">info@revivalhha.com</a></li>
              <li><a href="#" class="lineheight-20">1101 Mercantile Lane, Suite 292
                  Upper Marlboro, MD 20774-5360</a></li>
            </ul>
            <!-- <p class="font-16 text-white mb-5 mt-15">Subscribe to our newsletter</p>
                <form id="footer-mailchimp-subscription-form" class="newsletter-form mt-10">
              <label class="display-block" for="mce-EMAIL"></label>
              <div class="input-group">
                <input type="email" value="" name="EMAIL" placeholder="Your Email"  class="form-control" data-height="37px" id="mce-EMAIL">
                <span class="input-group-btn">
                    <button type="submit" class="btn btn-colored btn-theme-colored m-0"><i class="fa fa-paper-plane-o text-white"></i></button>
                </span>
              </div>
            </form> -->
            
          </div>
        </div>
      </div>
    </div>
    <div class="footer-bottom bg-black-333">
      <div class="container pt-20 pb-20">
        <div class="row">
          <div class="col-md-12 text-center">
            <p class="font-11 text-black-777 m-0">Copyright &copy;2020 Revival Home Care Agency. All Rights Reserved</p>
          </div>
         
        </div>
      </div>
    </div>
  </footer>
  <a class="scrollToTop" href="#"><i class="fa fa-angle-up"></i></a>
</div>
<!-- end wrapper --> 

<!-- Footer Scripts --> 
<!-- JS | Custom script for all pages --> 
<script src="{{ asset('revival/js/custom.js') }}"></script>


<script type="text/javascript" src="{{ asset('revival/js/revolution-slider/js/extensions/revolution.extension.actions.min.js') }}"></script> 
<script type="text/javascript" src="{{ asset('revival/js/revolution-slider/js/extensions/revolution.extension.carousel.min.js') }}"></script> 
<script type="text/javascript" src="{{ asset('revival/js/revolution-slider/js/extensions/revolution.extension.kenburn.min.js') }}"></script> 
<script type="text/javascript" src="{{ asset('revival/js/revolution-slider/js/extensions/revolution.extension.layeranimation.min.js') }}"></script> 
<script type="text/javascript" src="{{ asset('revival/js/revolution-slider/js/extensions/revolution.extension.migration.min.js') }}"></script> 
<script type="text/javascript" src="{{ asset('revival/js/revolution-slider/js/extensions/revolution.extension.navigation.min.js') }}"></script> 
<script type="text/javascript" src="{{ asset('revival/js/revolution-slider/js/extensions/revolution.extension.parallax.min.js') }}"></script> 
<script type="text/javascript" src="{{ asset('revival/js/revolution-slider/js/extensions/revolution.extension.slideanims.min.js') }}"></script> 

</body>


</html>