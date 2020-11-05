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
              <img src="{{ asset('revival/images/bg/history.jpg') }}"  alt=""  data-bgposition="center 60%" data-bgfit="cover" data-bgrepeat="no-repeat" class="rev-slidebg" data-bgparallax="10" data-no-retina>
              <!-- LAYERS -->

              <!-- LAYER NR. 1 -->
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

              

              <!-- LAYER NR. 3 -->
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
              </div>

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
    <section id="about">
      <div class="container">
        <div class="section-content">
          <div class="row"> 
            <div class="col-md-8 col-sm-12 wow fadeInLeft" data-wow-duration="1s" data-wow-delay="0.3s">
              <h2 class="text-uppercase mt-0">History</h2>  
              <p class="rev-p"><b>Revival Homecare Agency</b> was established based on the idea of completely giving back to the community. The idea of servicing loved ones with the comfort of family, friends, neighbors and a familiar setting was incredible as the patient’s psychological state would encourage a speedy recovery. Founded in 2007; both Akram Elzend, DPT (President) and Amir Elsayed, DPT (Vice President) understood the need and importance in having alternatives in healthcare that are not only cost efficient, but do not take out the personal feelings and values of the traditional aspects in patient care. While being at home and surrounded with love and comfort, facing different medical issues can be challenging to both the patient and his or her family.</p> 
			  <p class="rev-p">Here at Revival Homecare Agency our number one mission is to provide the highest quality of care, easing the patient’s pain and guiding family and friends through this apprehensive journey. By providing Home Health Care services, our clinicians not only address our patient’s medical needs, but also focus on meeting their physical, psychological, environmental and spiritual needs within the comforts and settings of their own home.</p>
			  <p class="rev-p">Home health care is an essential part of health care today, touching the lives of nearly every American. It encompasses a broad range of professional health care and support services provided in the home. As hospital stays decrease, increasing numbers of patients need highly-skilled services when they return home. Home care is necessary when a person needs ongoing care that cannot easily or effectively be provided solely by family and friends. Home health care services usually include assisting those persons who are recovering, disabled, chronically or terminally ill and are in need of medical, nursing, social, or therapeutic treatment and or assistance with the essential activities of daily living.</p>
			  <p class="rev-p">Since its establishment in Northern Virginia, <b>Revival Homecare Agency</b> has expanded its services and is now currently serving the Richmond and Maryland community bringing forth professionalism, reliability, and knowledge of the medical industry. Our highly qualified team has grown to over 100 employees, including licensed and certified clinicians with expertise in skilled nursing, physical therapy, occupational therapy, speech therapy, and personal care.</p>
			  <p class="rev-p">Using a team approach, our team of skilled professionals and non-medical professionals seek to provide assistance and support during difficult times. They are not only courteous, supportive, personable, and friendly, they are also carefully screened and receive specialized training so you can feel comfortable allowing our staff into your home. By providing that “Personal Touch” or one-on-one care with patients, <b>Revival Homecare Agency</b> strives to be your number one choice in home care services for you and or your loved ones.</p>
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
 