@extends('pages.layouts.app')
@section('content')
<!-- Start main-content -->
  <div class="main-content"> 
      <div class="rev_slider_wrapper">
        <div class="rev_slider" data-version="5.0">
          <ul>

            <!-- SLIDE 1 -->
            <li data-index="rs-1" data-transition="slidingoverlayhorizontal" data-slotamount="default" data-easein="default" data-easeout="default" data-masterspeed="default" data-thumb="{{ asset('revival/images/bg/bg.jpg') }}" data-rotate="0" data-saveperformance="off" data-title="Slide 1" data-description="">
              <!-- MAIN IMAGE -->
              <img src="{{ asset('revival/images/bg/our_services.jpg') }}"  alt=""  data-bgposition="center 60%" data-bgfit="cover" data-bgrepeat="no-repeat" class="rev-slidebg" data-bgparallax="10" data-no-retina>
              <!-- LAYERS -->

              <!-- LAYER NR. 1 
              <div class="tp-caption tp-resizeme text-uppercase text-white font-raleway"
                id="rs-1-layer-1"
                data-x="['left']"
                data-hoffset="['0']"
                data-y="['top']"
                data-voffset="['30']" 
                data-fontsize="['100']"
                data-lineheight="['30']"
                data-width="none"
                data-height="none"
                data-whitespace="nowrap"
                data-transform_idle="o:1;s:500"
                data-transform_in="y:100;scaleX:1;scaleY:1;opacity:0;"
                data-transform_out="x:left(R);s:1000;e:Power3.easeIn;s:1000;e:Power3.easeIn;"
                data-mask_in="x:0px;y:0px;s:inherit;e:inherit;"
                data-mask_out="x:inherit;y:inherit;s:inherit;e:inherit;"
                data-start="1000" 
                data-splitin="none" 
                data-splitout="none" 
                data-responsive_offset="on"
                style="z-index: 7; white-space: nowrap; font-weight:700;"><img src="{{ asset('revival/images/complogo.png') }}">
              </div>
-->
              

              <!-- LAYER NR. 3 
              <div class="tp-caption tp-resizeme text-white" 
                id="rs-1-layer-3"

                data-x="['left']"
                data-hoffset="['35']"
                data-y="['middle']"
                data-voffset="['50']"
                data-fontsize="['16']"
                data-lineheight="['28']"
                data-width="none"
                data-height="none"
                data-whitespace="nowrap"
                data-transform_idle="o:1;s:500"
                data-transform_in="y:100;scaleX:1;scaleY:1;opacity:0;"
                data-transform_out="x:left(R);s:1000;e:Power3.easeIn;s:1000;e:Power3.easeIn;"
                data-mask_in="x:0px;y:0px;s:inherit;e:inherit;"
                data-mask_out="x:inherit;y:inherit;s:inherit;e:inherit;"
                data-start="1400" 
                data-splitin="none" 
                data-splitout="none" 
                data-responsive_offset="on"
                style="z-index: 5; white-space: nowrap; letter-spacing:1px;"><a class="btn btn-colored btn-lg btn-flat btn-theme-colored border-left-theme-color-2-6px pl-20 pr-20" href="#">Submit your Referrals</a> 
              </div>-->

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
              <h2 class="text-uppercase mt-0">Our <span class="text-theme-color-2">Services</span></h2>  
              <p>Home Health Care Services are delivered in the comfort and security of your home. It provides you and your family with the sense of control and peace of mind that is rarely replicated in other approaches to care. At <b>Revival Homecare Agency</b>, our professionals provide the personal care you seek. We give you assistance and support during difficult times on your way to fully healing from illness or at least, in coping with chronic medical conditions.</p>

              <p>Our personal care professionals go through extensive training. They work under the guidance a Registered Nurse. At <b>Revival Homecare Agency</b>, we maintain a courteous, approachable, personable, and time-efficient attitude to best serve you in your home.</p>

              <p>We take pride in providing top quality tailored health care for all patients. As a state-licensed home health care agency, we devote ourselves to offering you nothing but the utmost service as our way of returning your trust in us.</p>

              <p>Our skilled professionals are courteous, supportive and friendly. They have been carefully screened and regularly receive specialized training. We want you to feel comfortable when you allow our staff into your homes.</p>
              <p>Our services include but are not limited to:</p>
              <ul class="list-img">
              <li><a href="{{route('nursing-services')}}"><img src="{{ asset('revival/images/list-icon.png') }}">Nursing Services</a></li>
              <li><a href="{{route('health-aid-services')}}"><img src="{{ asset('revival/images/list-icon.png') }}">Home Health Aide and Home Maker Services</a></li>
              <li><a href="{{route('physical-occupational-services')}}"><img src="{{ asset('revival/images/list-icon.png') }}">Physical, Occupational and Speech Therapy</a></li>
              </ul>
            </div> 
			@include('pages.common.sidebar') 
          </div>
        </div>
      </div>
    </section>  
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

    @include('pages.common.service') 
  </div>
  <!-- end main-content -->
  @endsection 
 