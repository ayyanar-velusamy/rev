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
              <img src="{{ asset('revival/images/bg/physical.jpg') }}"  alt=""  data-bgposition="center 60%" data-bgfit="cover" data-bgrepeat="no-repeat" class="rev-slidebg" data-bgparallax="10" data-no-retina>
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
              <h2 class="text-uppercase mt-0">Physical, Occupational and Speech Therapy <span class="text-theme-color-2">Services</span></h2>  
              <p>Our therapists can provide assessment and solutions to our patients. They will be with you to make sure you get the right treatment. Our highly experienced therapists will work around the clock to be certain that all your needs are attended.</p>
              <p>Our Physical Therapy Services include:</p>
              <ul class="list-img">
              <li><img src="{{ asset('revival/images/list-icon.png') }}">Pain Management</li>
              <li><img src="{{ asset('revival/images/list-icon.png') }}">Post Surgery Care</li>
              <li><img src="{{ asset('revival/images/list-icon.png') }}">Pre Surgery Care</li>
              <li><img src="{{ asset('revival/images/list-icon.png') }}">Education and Training in the use of Assistive Devices</li>
              <li><img src="{{ asset('revival/images/list-icon.png') }}">Orthopedics</li>
              <li><img src="{{ asset('revival/images/list-icon.png') }}">Pediatrics</li>
              <li><img src="{{ asset('revival/images/list-icon.png') }}">Body Mechanics</li>
              <li><img src="{{ asset('revival/images/list-icon.png') }}">Exercise Programs</li>
              <li><img src="{{ asset('revival/images/list-icon.png') }}">Improving Range Of Motion</li>
              <li><img src="{{ asset('revival/images/list-icon.png') }}">Muscle Re-Education</li>
              <li><img src="{{ asset('revival/images/list-icon.png') }}">Regaining Mobility</li>
              <li><img src="{{ asset('revival/images/list-icon.png') }}">Relearning Daily Living Skills And Self-Care Skills</li>
              <li><img src="{{ asset('revival/images/list-icon.png') }}">Strength Training</li>
              </ul>
              <p></p>
              <p>Our Occupational Therapy Services include:</p>
              <ul class="list-img">
              <li><img src="{{ asset('revival/images/list-icon.png') }}">Health Assessment</li>
              <li><img src="{{ asset('revival/images/list-icon.png') }}">Body Mechanics</li>
              <li><img src="{{ asset('revival/images/list-icon.png') }}">Basic Skills Evaluation</li>
              <li><img src="{{ asset('revival/images/list-icon.png') }}">Basic Level Skills Education and Training</li>
              <li><img src="{{ asset('revival/images/list-icon.png') }}">Device Assistance Training</li>
              <li><img src="{{ asset('revival/images/list-icon.png') }}">Pain Management</li>
              <li><img src="{{ asset('revival/images/list-icon.png') }}">Exercise Programs</li>
              <li><img src="{{ asset('revival/images/list-icon.png') }}">Therapeutic Programs</li>
              <li><img src="{{ asset('revival/images/list-icon.png') }}">Strength Enhancement</li>
              <li><img src="{{ asset('revival/images/list-icon.png') }}">Balance Restoration</li>
              <li><img src="{{ asset('revival/images/list-icon.png') }}">Sensory Functions Restoration</li>
              <li><img src="{{ asset('revival/images/list-icon.png') }}">Energy Conservation and Management</li>
              <li><img src="{{ asset('revival/images/list-icon.png') }}">Muscle Control Restoration and Enhancement</li>
              <li><img src="{{ asset('revival/images/list-icon.png') }}">Mobility Enhancement</li>
              </ul>
              <p>Our Speech  Services include:</p>
              <ul class="list-img">
              <li><img src="{{ asset('revival/images/list-icon.png') }}">Home Safety</li>
              <li><img src="{{ asset('revival/images/list-icon.png') }}">Speech</li>
              <li><img src="{{ asset('revival/images/list-icon.png') }}">Language</li>
              <li><img src="{{ asset('revival/images/list-icon.png') }}">Dysphagia (Swallowing)</li>
              <li><img src="{{ asset('revival/images/list-icon.png') }}">Cognition</li>
              <li><img src="{{ asset('revival/images/list-icon.png') }}">Adaptive Speech Devices</li>
              <li><img src="{{ asset('revival/images/list-icon.png') }}">Aural (Hearing) Rehabilitation</li>
              <li><img src="{{ asset('revival/images/list-icon.png') }}">Non-oral Communication</li>
              <li><img src="{{ asset('revival/images/list-icon.png') }}">Home Speech and Language Exercise Program</li>
              <li><img src="{{ asset('revival/images/list-icon.png') }}">Patient Education</li>
              <li><img src="{{ asset('revival/images/list-icon.png') }}">Communication Options/Alternatives</li>
              <li><img src="{{ asset('revival/images/list-icon.png') }}">Eating and Swallowing Strategies</li>
              <li><img src="{{ asset('revival/images/list-icon.png') }}">Speech Articulation Exercise</li>
              <li><img src="{{ asset('revival/images/list-icon.png') }}">Aural Rehabilitation</li>
              <li><img src="{{ asset('revival/images/list-icon.png') }}">Cognitive Skills Evaluation</li>
              <li><img src="{{ asset('revival/images/list-icon.png') }}">Comprehension Skills Assessment</li>
              <li><img src="{{ asset('revival/images/list-icon.png') }}">Sensory Skills Assessment</li>
              </ul>
              <p></p>
              <p>For your concerns and further inquiries, please contact us. Our staff will immediately get back to you.</p>
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
 