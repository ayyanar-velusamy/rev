@extends('pages.layouts.app')
@section('content')
<!-- Start main-content -->
  <div class="main-content"> 
      <div class="rev_slider_wrapper">
        <div class="rev_slider" data-version="5.0">
          <ul> 
            <li data-index="rs-1" data-transition="slidingoverlayhorizontal" data-slotamount="default" data-easein="default" data-easeout="default" data-masterspeed="default" data-thumb="{{ asset('revival/images/bg/bg.jpg') }}" data-rotate="0" data-saveperformance="off" data-title="Slide 1" data-description="">
              <!-- MAIN IMAGE -->
				@if($page->image != "") 
					<img src="{{ banner_image($page->image) }}"  alt=""  data-bgposition="center 60%" data-bgfit="cover" data-bgrepeat="no-repeat" class="rev-slidebg" data-bgparallax="10" data-no-retina>
				@else
					 <img src="{{ asset('revival/images/bg/history.jpg') }}"  alt=""  data-bgposition="center 60%" data-bgfit="cover" data-bgrepeat="no-repeat" class="rev-slidebg" data-bgparallax="10" data-no-retina>
				@endif   
            </li> 
          </ul>
        </div>
        <!-- end .rev_slider -->
      </div>
	  <script>
        $(document).ready(function(e) {
          $(".rev_slider").revolution({
            sliderType:"standard",
            sliderLayout: "auto",
            dottedOverlay: "none",
            delay: 5000,
            navigation: {
                keyboardNavigation: "off",
                keyboard_direction: "horizontal",
                mouseScrollNavigation: "off",
                onHoverStop: "off",
                touch: {
                    touchenabled: "on",
                    swipe_threshold: 75,
                    swipe_min_touches: 1,
                    swipe_direction: "horizontal",
                    drag_block_vertical: false
                },
              arrows: {
                style:"zeus",
                enable:false,
                hide_onmobile:true,
                hide_under:600,
                hide_onleave:true,
                hide_delay:200,
                hide_delay_mobile:1200,
                tmp:'<div class="tp-title-wrap">     </div>',
                left: {
                  h_align:"left",
                  v_align:"center",
                  h_offset:30,
                  v_offset:0
                },
                right: {
                  h_align:"right",
                  v_align:"center",
                  h_offset:30,
                  v_offset:0
                }
              },
              bullets: {
                enable:false,
                hide_onmobile:true,
                hide_under:600,
                style:"metis",
                hide_onleave:true,
                hide_delay:200,
                hide_delay_mobile:1200,
                direction:"horizontal",
                h_align:"center",
                v_align:"bottom",
                h_offset:0,
                v_offset:30,
                space:5,
                tmp:'<span class="tp-bullet-img-wrap">  <span class="tp-bullet-image"></span></span><span class="tp-bullet-title">title</span>'
              }
            },
            responsiveLevels: [1240, 1024, 778],
            visibilityLevels: [1240, 1024, 778],
            gridwidth: [1170, 1024, 778, 480],
            gridheight: [500, 768, 960, 720],
            lazyType: "none",
            parallax: {
                origo: "slidercenter",
                speed: 1000,
                levels: [5, 10, 15, 20, 25, 30, 35, 40, 45, 46, 47, 48, 49, 50, 100, 55],
                type: "scroll"
            },
            shadow: 0,
            spinner: "off",
            stopLoop: "on",
            stopAfterLoops: 0,
            stopAtSlide: -1,
            shuffle: "off",
            autoHeight: "off",
            fullScreenAutoWidth: "off",
            fullScreenAlignForce: "off",
            fullScreenOffsetContainer: "",
            fullScreenOffset: "0",
            hideThumbsOnMobile: "off",
            hideSliderAtLimit: 0,
            hideCaptionAtLimit: 0,
            hideAllCaptionAtLilmit: 0,
            debugMode: false,
            fallbacks: {
                simplifyAll: "off",
                nextSlideOnWindowFocus: "off",
                disableFocusListener: false,
            }
          });
        });
      </script>
    <!-- Section: About -->
    
    <!-- Section: About -->
    <section id="about">
      <div class="container">
        <div class="section-content">
          <div class="row"> 
            <div class="col-md-8 col-sm-12 wow fadeInLeft" data-wow-duration="1s" data-wow-delay="0.3s">
			 {!! $page->content_en !!}  
            </div> 
			@include('pages.common.sidebar') 
          </div>
        </div>
      </div>
    </section> 
@if($page->page_name == "about-us") 
 <!-- Divider: Reservation Form -->
   <section>
      <div class="container pt-0 pb-0">
        <div class="row">
          <div class="col-md-7 wow fadeInLeft">
            <div class="p-40 pl-0">
              <!-- Reservation Form Start-->
              <form id="reservation_form" name="reservation_form" class="reservation-form" method="post" action="{{route('enquiry')}}"><h3 class="mt-0 line-bottom mb-40">Contact Us today for<span class="text-theme-color-2"> Free Consultaton!</span></h3>
			  @csrf
                <div class="row">
                  <div class="col-sm-12">
                    <div class="form-group mb-30">
                      <input placeholder="Enter Name" type="text" id="name" name="name" required="" class="form-control">
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <div class="form-group mb-30">
                      <input placeholder="Email" type="text" id="email" name="email" class="form-control" required="">
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <div class="form-group mb-30">
                      <input placeholder="Phone" type="text" id="phone" name="phone" class="form-control" required="">
                    </div>
                  </div>
                  <div class="col-sm-12">
                    <div class="form-group mb-30">
                      <textarea placeholder="Question/Comment" rows="8" id="comment" name="comment" required="" class="form-control"></textarea>
					  <label id="question-error" class="error" for="question"></label>
                    </div>
                  </div>
                  
                  <div class="col-sm-12">
                    <div class="form-group mb-0 mt-0">
                      <input name="form_botcheck" class="form-control" type="hidden" value="">
                      <button type="submit" class="btn btn-colored btn-theme-colored btn-lg btn-flat border-left-theme-color-2-4px" data-loading-text="Please wait...">Submit Now</button>
                    </div>
                  </div>
                </div>
              </form>  
            </div>
          </div>
          <div class="col-md-5 wow fadeInRight">
            <img src="{{ asset('revival/images/bg/about_contact.jpg') }}" alt="">
          </div>
        </div>
      </div>
    </section>
@endif
@if($page->page_name == "our-services") 
 <section id="mission">
      <div class="container-fluid pt-0 pb-0">
        <div class="row equal-height">
          <div class="col-sm-6 col-md-6 xs-pull-none bg-theme-colored wow fadeInLeft" data-wow-duration="1s" data-wow-delay="0.3s">
            <div class="pt-60 pb-40 pl-90 pr-160 p-md-30">
              <h2 class="title text-white text-uppercase line-bottom mt-0 mb-30">Why Choose Us?</h2>
              <div class="icon-box clearfix m-0 p-0 pb-10">
                <a href="#" class="icon icon-lg pull-left flip sm-pull-none"> 
                  <i class="fa fa-wheelchair text-white font-60"></i> 
                </a>
                <div class="ml-120 ml-sm-0">
                  <h4 class="icon-box-title text-white mt-5 mb-10 letter-space-1">World Best Service</h4>
                  <p class="text-white">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam interdum diam tortor, egestas varius erat aliquam. </p>
                </div>
              </div>
              <div class="icon-box clearfix m-0 p-0 pb-10">
                <a href="#" class="icon icon-lg pull-left flip sm-pull-none">
                  <i class="fa fa-user text-white font-60"></i> 
                </a>
                <div class="ml-120 ml-sm-0">
                  <h4 class="icon-box-title text-white mt-5 mb-10 letter-space-1">Professional Staffs</h4>
                  <p class="text-white">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam interdum diam tortor, egestas varius erat aliquam. </p>
                </div>
              </div>
              <div class="icon-box clearfix m-0 p-0 pb-10">
                <a href="#" class="icon icon-lg pull-left flip sm-pull-none">
                  <i class="fa fa-money text-white font-60"></i> 
                </a>
                <div class="ml-120 ml-sm-0">
                  <h4 class="icon-box-title text-white mt-5 mb-10 letter-space-1">Low Cost Services</h4>
                  <p class="text-white">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam interdum diam tortor, egestas varius erat aliquam. </p>
                </div>
              </div>
            </div>
          </div>
          <div class="col-sm-6 col-md-6 p-0 bg-img-cover wow fadeInRight hidden-xs" data-bg-img="{{ asset('revival/images/bg/why_choose.jpg') }}" data-wow-duration="1s" data-wow-delay="0.3s">
          </div>
        </div>
      </div>
    </section> 
@endif

	
	@include('pages.common.service') 
  </div>
  <!-- end main-content -->
  @endsection 
 