@extends('pages.layouts.app')
@section('content')
<!-- Start main-content -->
  <div class="main-content"> 
      <div class="rev_slider_wrapper">
        <div class="rev_slider" data-version="5.0">
          <ul>

            <!-- SLIDE 1 -->
            <li data-index="rs-1" data-transition="slidingoverlayhorizontal" data-slotamount="default" data-easein="default" data-easeout="default" data-masterspeed="default" data-thumb="{{ asset('revival/images/bg/bg.jpg') }}" data-rotate="0" data-saveperformance="off" data-title="Slide 1" data-description="">
              <img src="{{ asset('revival/images/bg/quality.jpg') }}"  alt=""  data-bgposition="center 60%" data-bgfit="cover" data-bgrepeat="no-repeat" class="rev-slidebg" data-bgparallax="10" data-no-retina>             
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
              <!--<h2 class="text-uppercase mt-0">Quality <span class="text-theme-color-2">Measures</span></h2>  
              <p class="rev-p"><b>Revival Homecare Agency</b> is guided by a tradition of personal, clinical, and technological excellence .We are dedicated to providing the highest quality home-based patient care with compassion and respect for each person.</p>  
			  <p class="rev-p"><b>Revival Homecare Agency</b> recognizes the unique physical, emotional, and spiritual needs of each person receiving health care in the home. We strive to extend the highest level of courtesy, safety and service to patients, family/caregivers, visitors, and each other. We deliver state-of-the-art home health services with identified centers of excellence. We engage in a wide range of continuing education, clinical education, and other programs for professionals and the public.</p>
			  <p class="rev-p">We strive to create an environment of teamwork and participation, where, through continuous performance improvement and open communication, health care professionals pursue excellence and take pride in their work, the organization, and their personal development. We believe that the quality of our human resources—organization personnel, physicians, and volunteers—is the key to our continued success. We provide physicians an environment that fosters high quality diagnosis and treatment. We maintain financial viability through a cost-effective operation to meet our long-term commitment to the community.</p>
			  <p class="rev-p"><b>Revival Homecare Agency</b><br><br>(This information comes from the Home Health Outcome and Assessment Information Set (OASIS) C during the time period April 2012 – March 2013)<br>The information in Home Health Compare should be looked at carefully. Use it with the other information you gather about home health agencies as you decide where to get home health services. You may want to contact your doctor, your State Survey Agency or your State Quality Improvement Organization for more information. To report quality problems, contact the State Quality Improvement Organization or State Home Health Hotline number that can be found in the Helpful Contacts section of this website.</p>
			  <h4>Why is this information important?</h4>
			  <p class="rev-p">Most people value being able to take care of themselves. In some cases, it may take more time for you to walk and move around yourself than to have someone do things for you. But, it is important that home health care staff and informal caregivers encourage you to do as much as you can for yourself. Your home health staff will evaluate your need for, and teach you how to use any special devices or equipment that you may need to help you increase you ability to perform some activities and your ability to get in and out of bed yourself may help you live independently as long as possible in your own home without the assistance of another person.If you can get in and out of bed with little help, you may be more independent, feel better about yourself, and stay more active. This can affect your health in a good way.</p>
			  <h4>Why is this information important?</h4>
			  <p class="rev-p">Home health staff should ask if you are having pain at each visit. If you are in pain, you (or someone on your behalf) should tell the staff. Efforts can then be made to find and treat the cause and make you more comfortable. If pain is not treated, you may not be able to perform daily routines, may become depressed, or have an overall poor quality of life. Pain may also be a sign of a new or worsening health problem.</p>
			  <h4>Why is this information important?</h4>
			  <p class="rev-p">Normal wound healing after an operation is an important marker of good care. Patients whose wounds heal normally generally feel better and can get back to their daily activities sooner than those whose wounds don’t heal normally. After an operation, patients often go home to recover and their doctor may refer them for home health care. One way to measure the quality of care that home health agencies give is to look at how well their patients’ wounds heal after an operation.Higher percentages are better.</p>
			  <p class="rev-p">For medicines to work properly, they need to be taken correctly. Taking too much or too little medicine can keep it from helping you feel better and, in some cases, can make you sicker, make you confused (which could affect your safety), or even cause death. Home health staff can help teach you ways to organize your medicines and take them properly. Getting better at taking your medicines correctly means the home health agency is doing a good job teaching you how to take your medicines.</p>
			  <p class="rev-p">A home health care provider may refer a patient to emergency care when this is the best way to treat the patient’s current condition. However, some emergency care may be avoided if the home health staff is doing a good job at checking your health condition to detect problems early. They also need to check how well you are eating, drinking, and taking your medicines, and how safe your home is. Home health staff must coordinate your care. This involves communicating regularly with you, your informal caregivers, your doctor, and anyone else who provides care for you. Lower percentages are better.</p>-->
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
 