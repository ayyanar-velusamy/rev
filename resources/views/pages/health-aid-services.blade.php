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
              <img src="{{ asset('revival/images/bg/home_health.jpg') }}"  alt=""  data-bgposition="center 60%" data-bgfit="cover" data-bgrepeat="no-repeat" class="rev-slidebg" data-bgparallax="10" data-no-retina>
              
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
              <!--<h2 class="text-uppercase mt-0">Home Health Aide <span class="text-theme-color-2">Services</span></h2>  
              <p>Our health aides will provide care support and services to our clients to help them feel relieved and relaxed. Without going out of your house, our employees will give your loved one with hands-on personal care to maintain their health.</p>
              <p>Our Home Health Aide Services include the following:</p>
              <ul class="list-img">
              <li><img src="{{ asset('revival/images/list-icon.png') }}">Bathing, grooming and personal hygiene assistance</li>
              <li><img src="{{ asset('revival/images/list-icon.png') }}">Companionship</li>
              <li><img src="{{ asset('revival/images/list-icon.png') }}">Light housekeeping</li>
              <li><img src="{{ asset('revival/images/list-icon.png') }}">Meal preparation</li>
              <li><img src="{{ asset('revival/images/list-icon.png') }}">Medication management</li>
              <li><img src="{{ asset('revival/images/list-icon.png') }}">Mobility assistance</li>
              <li><img src="{{ asset('revival/images/list-icon.png') }}">Blood pressure and temperature monitoring</li>
              <li><img src="{{ asset('revival/images/list-icon.png') }}">Dedicated attention and general supervision of health</li>
              <li><img src="{{ asset('revival/images/list-icon.png') }}">Bathing</li>
              <li><img src="{{ asset('revival/images/list-icon.png') }}">Skin care</li>
              <li><img src="{{ asset('revival/images/list-icon.png') }}">Oral hygiene</li>
              <li><img src="{{ asset('revival/images/list-icon.png') }}">Nail care</li>
              <li><img src="{{ asset('revival/images/list-icon.png') }}">Home exercise program</li>
              <li><img src="{{ asset('revival/images/list-icon.png') }}">Ambulation</li>
              <li><img src="{{ asset('revival/images/list-icon.png') }}">Simple wound care</li>
              <li><img src="{{ asset('revival/images/list-icon.png') }}">Bowel program</li>
              <li><img src="{{ asset('revival/images/list-icon.png') }}">Catheter care</li>
              <li><img src="{{ asset('revival/images/list-icon.png') }}">Light meal preparation</li>
              </ul>
              <p></p>
              <p>Our Home Maker Services include:</p>
              <ul class="list-img">
              <li><img src="{{ asset('revival/images/list-icon.png') }}">Light meal preparation</li>
              <li><img src="{{ asset('revival/images/list-icon.png') }}">Wash dishes
              <li><img src="{{ asset('revival/images/list-icon.png') }}">Dust
              <li><img src="{{ asset('revival/images/list-icon.png') }}">Vacuum
              <li><img src="{{ asset('revival/images/list-icon.png') }}">Take out the trash
              <li><img src="{{ asset('revival/images/list-icon.png') }}">Laundry
              <li><img src="{{ asset('revival/images/list-icon.png') }}">Iron clothes
              <li><img src="{{ asset('revival/images/list-icon.png') }}">Change linens
              <li><img src="{{ asset('revival/images/list-icon.png') }}">Make the bed
              <li><img src="{{ asset('revival/images/list-icon.png') }}">Answer the phone
              <li><img src="{{ asset('revival/images/list-icon.png') }}">Sort & assist in reading mail
              <li><img src="{{ asset('revival/images/list-icon.png') }}">Answer the door
              <li><img src="{{ asset('revival/images/list-icon.png') }}">Clip coupons
              <li><img src="{{ asset('revival/images/list-icon.png') }}">Shop for gifts
              <li><img src="{{ asset('revival/images/list-icon.png') }}">Pet care
              <li><img src="{{ asset('revival/images/list-icon.png') }}">Write letters
              <li><img src="{{ asset('revival/images/list-icon.png') }}">Check food freshness
              <li><img src="{{ asset('revival/images/list-icon.png') }}">Grocery shop
              <li><img src="{{ asset('revival/images/list-icon.png') }}">Care for houseplants
              <li><img src="{{ asset('revival/images/list-icon.png') }}">Pick up prescriptions
              <li><img src="{{ asset('revival/images/list-icon.png') }}">Wash dishes
              <li><img src="{{ asset('revival/images/list-icon.png') }}">Dust
              <li><img src="{{ asset('revival/images/list-icon.png') }}">Vacuum
              <li><img src="{{ asset('revival/images/list-icon.png') }}">Take out the trash
              <li><img src="{{ asset('revival/images/list-icon.png') }}">Laundry
              <li><img src="{{ asset('revival/images/list-icon.png') }}">Iron clothes
              <li><img src="{{ asset('revival/images/list-icon.png') }}">Change linens
              <li><img src="{{ asset('revival/images/list-icon.png') }}">Make the bed
              <li><img src="{{ asset('revival/images/list-icon.png') }}">Answer the phone
              <li><img src="{{ asset('revival/images/list-icon.png') }}">Sort & assist in reading mail
              <li><img src="{{ asset('revival/images/list-icon.png') }}">Answer the door
              <li><img src="{{ asset('revival/images/list-icon.png') }}">Clip coupons
              <li><img src="{{ asset('revival/images/list-icon.png') }}">Shop for gifts
              <li><img src="{{ asset('revival/images/list-icon.png') }}">Pet care
              <li><img src="{{ asset('revival/images/list-icon.png') }}">Write letters
              <li><img src="{{ asset('revival/images/list-icon.png') }}">Check food freshness
              <li><img src="{{ asset('revival/images/list-icon.png') }}">Grocery shop
              <li><img src="{{ asset('revival/images/list-icon.png') }}">Care for houseplants
              <li><img src="{{ asset('revival/images/list-icon.png') }}">Pick up prescriptions
              </ul>
              <p>For your concerns and further inquiries, please contact us. Our staff will immediately get back to you</p>-->
            </div> 
			@include('pages.common.sidebar') 
          </div>
        </div>
      </div>
    </section>  
	@include('pages.common.service') 
  </div>
  <!-- end main-content -->
  @endsection 
 