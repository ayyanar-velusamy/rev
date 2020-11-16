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
              <img src="{{ asset('revival/images/bg/contact.jpg') }}"  alt=""  data-bgposition="center 60%" data-bgfit="cover" data-bgrepeat="no-repeat" class="rev-slidebg" data-bgparallax="10" data-no-retina>
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
    <!-- Divider: Contact -->
    <section class="divider">
      <div class="container pt-0">
        <div class="row mb-60 bg-deep">
          <div class="col-sm-12 col-md-3 wow fadeInLeft" data-wow-duration="1.5s" data-wow-delay=".1s" data-wow-offset="10">
            <div class="contact-info text-center pt-60 pb-60 border-right">
              <i class="fa fa-building font-36 mb-10 text-theme-colored"></i>
              <h4>Maryland Office</h4>
              <h5 class="text-gray">#1101 Mercantile Lane, Suite 292</h5>
              <h5 class="text-gray">Upper Marlboro, MD 20774-5360</h5>
              <h5 class="text-gray">Phone: 888-225-6994 ext – 6300</h5>
              <h5 class="text-gray">Fax: 888-592-3644</h5>
              <h5 class="text-gray">Website: <a target="_blank" href="https://www.revivalhc.com">www.revivalhc.com</a></h5>
            </div>
          </div>
          <div class="col-sm-12 col-md-3 wow fadeInLeft" data-wow-duration="1.5s" data-wow-delay=".3s" data-wow-offset="10">
            <div class="contact-info text-center  pt-60 pb-60 border-right">
              <i class="fa fa-building-o font-36 mb-10 text-theme-colored"></i>
              <h4>Annandale Office</h4>
              <h5 class="text-gray">#5101 C Backlick Road, Suite 2</h5>
                    <h5 class="text-gray">Annandale, VA 22003</h5>
                    <h5 class="text-gray">Phone: 888-225-6905 ext – 6000</h5>
                    <h5 class="text-gray">Fax: 888-801-4714</h5>
                    <h5 class="text-gray">Website: <a href="/">www.revivalhha.com</a></h5>
            </div>
          </div>
          <div class="col-sm-12 col-md-3 wow fadeInLeft" data-wow-duration="1.5s" data-wow-delay=".6s" data-wow-offset="10">
            <div class="contact-info text-center  pt-60 pb-60">
              <i class="fa fa-building font-36 mb-10 text-theme-colored"></i>
              <h4>Richmond Office</h4>
              <h5 class="text-gray">#210 Railroad Avenue, Suite 3B</h5>
                    <h5 class="text-gray">Ashland, VA 23005</h5>
                    <h5 class="text-gray">Phone: 888-225-6905 ext – 6000</h5>
                    <h5 class="text-gray">Fax: 888-801-4714</h5>
                    <h5 class="text-gray">Website: <a href="/">www.revivalhha.com</a></h5>
            </div>
          </div>
          <div class="col-sm-12 col-md-3 wow fadeInLeft" data-wow-duration="1.5s" data-wow-delay=".9s" data-wow-offset="10">
            <div class="contact-info text-center  pt-60 pb-60">
              <i class="fa fa-building-o font-36 mb-10 text-theme-colored"></i>
              <h4>Houston Office</h4>
              <h5 class="text-gray">Revival Texas home Health</h5>
              <h5 class="text-gray">#3727 Greenbriar Drive, Suite 117</h5>
                    <h5 class="text-gray">Stafford, TX 77477-3929</h5>
                    <h5 class="text-gray">Phone: 713-995-6266</h5>
                    <h5 class="text-gray">Fax: 713-995-6265</h5>
                    
            </div>
          </div>
        </div>
        <div class="row pt-30 wow fadeInLeft">
          <div class="col-md-4">
            <div class="row">
              <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="icon-box left media bg-deep p-30 mb-20"> <a class="media-left pull-left" href="#"> <i class="fa fa-map-marker text-theme-colored"></i></a>
                  <div class="media-body"> <strong>OUR OFFICE LOCATION</strong>
                    <p>1101 Mercantile Lane, Suite 292 Upper Marlboro, MD 20774-5360</p>
                  </div>
                </div>
              </div>
              <div class="col-xs-12 col-sm-6 col-md-12">
                <div class="icon-box left media bg-deep p-30 mb-20"> <a class="media-left pull-left" href="#"> <i class="fa fa-phone text-theme-colored"></i></a>
                  <div class="media-body"> <strong>OUR CONTACT NUMBER</strong>
                    <p><a href="tel:888-801-4714">888-801-4714</a></p>
                  </div>
                </div>
              </div>
              <div class="col-xs-12 col-sm-6 col-md-12">
                <div class="icon-box left media bg-deep p-30 mb-20"> <a class="media-left pull-left" href="#"> <i class="fa fa-fax text-theme-colored"></i></a>
                  <div class="media-body"> <strong>OUR FAX</strong>
                    <p><a href="fax:888-225-6905">888-225-6905</a></p>
                  </div>
                </div>
              </div>
              <div class="col-xs-12 col-sm-6 col-md-12">
                <div class="icon-box left media bg-deep p-30 mb-20"> <a class="media-left pull-left" href="#"> <i class="fa fa-envelope text-theme-colored"></i></a>
                  <div class="media-body"> <strong>OUR CONTACT E-MAIL</strong>
                    <p><a href="mailto:info@revivalhha.com">info@revivalhha.com</a></p>
                  </div>
                </div>
              </div>
              
            </div>
          </div>
          <div class="col-md-8">
            <h3 class="line-bottom mt-0 mb-20">Contact Us</h3>
            <p>Contact us today to learn about our specialized care and affordable rates.</p>
            <p>Our office hours are 8:00 AM to 5:00 PM, weekdays. Professional caregivers and staff personnel are available 24 hours a day, 7 days a week. Registered Nurses are on-call after hours in order to meet your special needs.<p>
            <!-- Contact Form -->
            <form id="contact_form1" name="contact_form" class="" action="" method="post" novalidate="novalidate">

              <div class="row">
                <div class="col-sm-12">
                  <div class="form-group">
                    <input name="form_name" class="form-control " type="text" placeholder="Enter Name" required="" aria-required="true" aria-invalid="true">
                  </div>
                </div>
                
                <div class="col-sm-12">
                  <div class="form-group">
                    <textarea name="form_address" class="form-control required"  placeholder="Enter Address" aria-required="true"></textarea>
                  </div>
                </div>
              </div>
                
              <div class="row">
                <div class="col-sm-6">
                  <div class="form-group">
                    <input name="form_subject" class="form-control required " type="email" placeholder="Enter Email" aria-required="true">
                  </div>
                </div>
                <div class="col-sm-6">
                  <div class="form-group">
                    <input name="form_phone" class="form-control required" type="text" placeholder="Enter Phone"  aria-required="true">
                  </div>
                </div>
              </div>

              <div class="form-group">
                <textarea name="form_message" class="form-control required " rows="5" placeholder="Questioon/Comment" aria-required="true"></textarea>
              </div>
              <div class="form-group">
                <input name="form_botcheck" class="form-control" type="hidden" value="">
                <button type="submit" class="btn btn-flat btn-theme-colored text-uppercase mt-10 mb-sm-30 border-left-theme-color-2-4px" data-loading-text="Please wait...">Send your message</button>
                <button type="reset" class="btn btn-flat btn-theme-colored text-uppercase mt-10 mb-sm-30 border-left-theme-color-2-4px">Reset</button>
              </div>
            </form>

            <!-- Contact Form Validation-->
            <script type="text/javascript">
            $(".error").hide();
              $("#contact_form1").validate({
                submitHandler: function(form) {
                  var form_btn = $(form).find('button[type="submit"]');
                  var form_result_div = '#form-result';
                  $(form_result_div).remove();
                  form_btn.before('<div id="form-result" class="alert alert-success" role="alert" style="display: none;"></div>');
                  var form_btn_old_msg = form_btn.html();
                  form_btn.html(form_btn.prop('disabled', true).data("loading-text"));
                  $(form).ajaxSubmit({
                    dataType:  'json',
                    success: function(data) {
                      if( data.status == 'true' ) {
                        $(form).find('.form-control').val('');
                      }
                      form_btn.prop('disabled', false).html(form_btn_old_msg);
                      $(form_result_div).html(data.message).fadeIn('slow');
                      setTimeout(function(){ $(form_result_div).fadeOut('slow') }, 6000);
                    }
                  });
                }
              });
            </script>
          </div>
        </div>
      </div>
    </section> 
	@include('pages.common.service') 
  </div>
  <!-- end main-content -->
  @endsection 
 