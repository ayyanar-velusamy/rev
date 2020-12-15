@extends('pages.layouts.app')
@section('content')
<!-- Start main-content -->
  <div class="main-content">
    <!-- Section: home -->
    <section id="home"> 
      @include('pages.common.slider') 
    </section>

    <!-- Section: home-boxes -->
    <section>
      <div class="container pb-0">
      <div class="section-content">
          <div class="row equal-height-inner home-boxes" data-margin-top="-100px" style="margin-top: -100px;">
            <div class="col-sm-12 col-md-4 pl-0 pl-sm-15 pr-0 pr-sm-15 sm-height-auto mt-sm-0 wow fadeInLeft animation-delay1" style="min-height: 20.43em; visibility: visible;">
              <div class="sm-height-auto bg-theme-colored" style="min-height: 286.02px;">
                <div class="text-center pt-30 pb-30">
                  <i class="fa fa-calendar text-white font-64 pb-10"></i>
                  <div class="p-10">
                    <h4 class="text-uppercase text-white mt-0">Schedule an ASSESSMENT</h4>
                    <p class="text-white">Improve your lifestyle now. Schedule your health assessment with us. home health care home health</p>
                    <a href="{{route('schedule')}}" class="btn btn-border btn-circled btn-transparent btn-sm">Click Here</a>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-sm-12 col-md-4 pl-0 pl-sm-15 pr-0 pr-sm-15 sm-height-auto mt-sm-0 wow fadeInLeft animation-delay2" style="min-height: 20.43em; visibility: visible;">
              <div class="sm-height-auto bg-theme-colored-darker2" style="min-height: 286.02px;">
                <div class="text-center pt-30 pb-30">
                  <i class="fa fa-file text-white font-64 pb-10"></i>
                  <div class="p-10">
                    <h4 class="text-uppercase text-white mt-0">Insurance ACCEPTED</h4>
                    <p class="text-white">Does your insurance company cover our services? Click on the link to find out. Medicare, Medicaid, Optum Health, BCBS, KAISER and more</p>
                    <a href="{{route('insurance-accepted')}}" class="btn btn-border btn-circled btn-transparent btn-sm">Click Here</a>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-sm-12 col-md-4 pl-0 pl-sm-15 pr-0 pr-sm-15 sm-height-auto mt-sm-0 wow fadeInLeft animation-delay3" style="min-height: 20.43em; visibility: visible;">
              <div class="sm-height-auto bg-theme-colored-darker3" style="min-height: 286.02px;">
                <div class="text-center pt-30 pb-30">
                  <i class="fa fa-users text-white font-64 pb-10"></i>
                  <div class="p-10">
                    <h4 class="text-uppercase text-white mt-0">Meet Our STAFF</h4>
                    <p class="text-white">We make sure the people attending to your loved ones are competent and trustworthy.</p>
                    <a href="{{route('meet-our-staff')}}" class="btn btn-border btn-circled btn-transparent btn-sm">Click Here</a>
                  </div>
                </div>
              </div>
            </div>
            
          </div>
        </div>
      </div>
    </section>
    
    
    <!-- Section: About -->
    <section id="about">
      <div class="container pb-70">
        <div class="section-content">
          <div class="row">
            <div class="col-md-8 col-sm-12 wow fadeInRight" data-wow-duration="1s" data-wow-delay="0.3s">
              <h2 class="text-uppercase mt-0">Welcome To <span class="text-theme-color-2">  Revival Home Care </span></h2>
              <p class="lead"> WE OFFER Do taking care of your responsibilities and finding time to be with your loved one prove to be 
              a herculean task? Are you looking for a home care agency that can assist your loved one when you are away? Well, 
              you can ease your mind from worrying too much. A home care services provider in Virginia and Maryland can help you 
              and your family.<br><br>
For your home care services dilemma, you can trust only one name: <b>Revival Homecare Agency</b>. Our agency exists to provide you and our community with health services that bring comfort in a familiar setting, your home. Our competent staff and employees have been serving the people of Virginia and Maryland for years. Keeping your loved one healthy and relaxed is our top priority. For more information about our services, please call us at 888-225-6905.</p>
              
            </div>
            @include('pages.common.sidebar') 
          </div>
        </div>
      </div>
    </section>

    <section class="divider parallax" data-bg-img="{{ asset('revival/images/bg/revival.jpg') }}" data-parallax-ratio="0.7">
      <div class="container pt-0 pb-0">
        <div class="row">
          <div class="col-md-8 col-md-offset-4">
            <div class="bg-white-transparent-9 pb-10 p-40">
              <h2 class="mb-20 mt-30 line-height-1 text-center text-uppercase">Our <span class="text-theme-color-2"> Offices</span></h2>
              <div class="row">
                  <div class="col-xs-12 col-sm-6 col-md-6">
                    <div class="icon-box p-15 mb-0 mb-sm-0 mt-sm-0">
                      <a class="icon pull-left sm-pull-none flip" href="#">
                      <i class="fa fa-building-o text-theme-colored font-50"></i>
                      </a>
                      <div class="ml-70 ml-sm-0">
                        <h4 class="icon-box-title mt-15 mb-5">Maryland Office</h4>
                        <p>1101 Mercantile Lane, Suite 292
                          Upper Marlboro, MD 20774-5360
                          Phone: 888-225-6994 ext – 6300
                          Fax: 888-592-3644
                          Website: www.revivalhha.com</p>
                      </div>
                    </div>
                  </div>
                  <div class="col-xs-12 col-sm-6 col-md-6">
                    <div class="icon-box p-15 mb-0 mb-sm-0 mt-sm-0">
                      <a class="icon pull-left sm-pull-none flip" href="#">
                      <i class="fa fa-building-o text-theme-colored font-50"></i>
                      </a>
                      <div class="ml-70 ml-sm-0">
                        <h4 class="icon-box-title mt-15 mb-5">Annandale Office</h4>
                        <p>5101 C Backlick Road, Suite 2
                          Annandale, VA 22003
                          Phone: 888-225-6905 ext – 6000
                          Fax: 888-801-4714
                          Website: www.revivalhha.com</p>
                      </div>
                    </div>
                  </div>
                  <div class="col-xs-12 col-sm-6 col-md-6">
                    <div class="icon-box p-15 mb-30 mb-sm-0 mt-sm-0">
                      <a class="icon pull-left sm-pull-none flip" href="#">
                      <i class="fa fa-building-o text-theme-colored font-50"></i>
                      </a>
                      <div class="ml-70 ml-sm-0">
                        <h4 class="icon-box-title mt-15 mb-5">Richmond Office</h4>
                        <p>210 Railroad Avenue, Suite 3B
                          Ashland, VA 23005
                          Phone: 888-225-6905 ext – 6000
                          Fax: 888-801-4714
                          Website: www.revivalhha.com</p>
                      </div>
                    </div>
                  </div>
                  <div class="col-xs-12 col-sm-6 col-md-6">
                    <div class="icon-box p-15 mb-30 mb-sm-0 mt-sm-0">
                      <a class="icon pull-left sm-pull-none flip" href="#">
                      <i class="fa fa-building-o text-theme-colored font-50"></i>
                      </a>
                      <div class="ml-70 ml-sm-0">
                        <h4 class="icon-box-title mt-15 mb-5">Houston Office</h4>
                        <p>Revival Texas home Health
                          6713 Broadway Street,
                          Suite #H,
                          Pearland, TX 77581
                          Phone: 713-995-6266
                          Fax: 713-995-6265</p>
                      </div>
                    </div>
                  </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>



    <!-- Section: Mission -->
   
    @include('pages.common.service') 
    
    <!-- Divider: Funfact -->
    <section class="divider parallax layer-overlay" data-bg-img="{{ asset('revival/images/bg/revival2.jpg') }}" data-parallax-ratio="0.5">
      <div class="container pt-70 pb-60">
        <div class="row">
          <div class="col-xs-12 col-sm-6 col-md-3 mb-md-50">
            <div class="funfact text-center">
              <i class="fa fa-users mt-5 text-white"></i>
              <h2 data-animation-duration="2000" data-value="500" class="animate-number text-white mt-0 font-38 font-weight-500">0</h2>
              <h4 class="text-white text-uppercase">Professionals</h4>
            </div>
          </div>
          <div class="col-xs-12 col-sm-6 col-md-3 mb-md-50">
            <div class="funfact text-center">
              <i class="fa fa-hospital-o mt-5 text-white"></i>
              <h2 data-animation-duration="2000" data-value="750" class="animate-number text-white mt-0 font-38 font-weight-500">0</h2>
              <h4 class="text-white text-uppercase">Hospital Rooms</h4>
            </div>
          </div>
          <div class="col-xs-12 col-sm-6 col-md-3 mb-md-50">
            <div class="funfact text-center">
              <i class="fa fa-ambulance mt-5 text-white"></i>
              <h2 data-animation-duration="2000" data-value="204" class="animate-number text-white mt-0 font-38 font-weight-500">0</h2>
              <h4 class="text-white text-uppercase">Transportation</h4>
            </div>
          </div>
          <div class="col-xs-12 col-sm-6 col-md-3 mb-md-50">
            <div class="funfact text-center">
              <i class="fa  fa-smile-o mt-5 text-white"></i>
              <h2 data-animation-duration="2000" data-value="2324" class="animate-number text-white mt-0 font-38 font-weight-500">0</h2>
              <h4 class="text-white text-uppercase">Happy Clients</h4>
            </div>
          </div>
        </div>
      </div>
    </section>

    



    


    <!-- Section: Experts -->
    <!-- <section>
      <div class="container pb-70 pt-50">
        <div class="section-title text-center">
          <div class="row">
            <div class="col-md-8 col-md-offset-2 pt-20">
              <h2 class="mt-0 line-height-1 text-center">Our <span class="text-theme-color-2"> Services</span></h2>
              
            </div>
          </div>
        </div>
        <div class="section-content">
          <div class="row">
            <div class="col-xs-12 col-sm-6 col-md-4 wow fadeInRight" data-wow-duration="1s" data-wow-delay="0.3s">
              <div class="team-members mb-sm-30 border-2px">
                
                <div class="team-lower-block text-center p-20">
                  <h4 class="mt-0 pb-0 p-10"> <a href="page-experts-details.html">Nursing Services</a></h4>
                  
                </div>
              </div>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-4 wow fadeInRight" data-wow-duration="1s" data-wow-delay="0.3s">
              <div class="team-members mb-sm-30 border-2px">
                
                <div class="team-lower-block text-center p-20">
                  <h4 class="mt-0 pb-0 p-10"> <a href="page-experts-details.html">Home Aide Services</a></h4>
                  
                </div>
              </div>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-4 wow fadeInRight" data-wow-duration="1s" data-wow-delay="0.3s">
              <div class="team-members mb-sm-30 border-2px">
               
                <div class="team-lower-block text-center p-20">
                  <h4 class="mt-0 pb-0 p-10"> <a href="page-experts-details.html">Physical Occupational and Speech therapy</a></h4>
                  
                </div>
              </div>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-4 wow fadeInRight" data-wow-duration="1s" data-wow-delay="0.3s">
              <div class="team-members mb-sm-30 border-2px">
                
                <div class="team-lower-block text-center p-20">
                  <h4 class="mt-0 pb-0 p-10"> <a href="page-experts-details.html">Revival University</a></h4>
                  
                </div>
              </div>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-4 wow fadeInRight" data-wow-duration="1s" data-wow-delay="0.3s">
              <div class="team-members mb-sm-30 border-2px">
                
                <div class="team-lower-block text-center p-20">
                  <h4 class="mt-0 pb-0 p-10"> <a href="page-experts-details.html">Waiver Program</a></h4>
                  
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section> -->

    
    
    
    <!-- Section: Claints Say -->
    <!-- <section class="divider parallax layer-overlay overlay-theme-color-sky" data-bg-img="{{ asset('revival/images/bg/revival3.jpg') }}">
      <div class="container pt-60 pb-70">
        <div class="section-title text-center">
          <div class="row">
            <div class="col-md-8 col-md-offset-2">
              <h2 class="text-uppercase text-white line-bottom-center mt-0">What Client's <span class="text-theme-color-2">Say</span></h2>
              <div class="title-flaticon">
                <i class="flaticon-charity-alms"></i>
              </div>
              <p class="text-white">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Rem autem<br> voluptatem obcaecati!</p>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="owl-carousel-3col  style2 dots-white" data-dots="false">
              <div class="item">
                <div class="testimonial bg-theme-color-2 p-30 pb-20 mt-50">
                  <h4 class="author text-white mt-0 mb-0">Catherine Grace</h4>
                  <h6 class="title text-white mt-0 mb-15">Designer</h6> 
                  <div class="thumb content mt-30"><img class="img-circle" alt="" src="{{ asset('revival/images/testimonials/1.jpg') }}"></div>
                  <p class="font-15 pl-0 text-white"><em>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Neque est quasi, quas ipsam, expedita placeat facilis odio illo ex accusantium eaque.</em></p>
                </div>
              </div>
              <div class="item">
                <div class="testimonial bg-theme-color-2 p-30 pb-20 mt-50">
                  <h4 class="author text-white mt-0 mb-0">Catherine Grace</h4>
                  <h6 class="title text-white mt-0 mb-15">Designer</h6> 
                  <div class="thumb content mt-30"><img class="img-circle" alt="" src="{{ asset('revival/images/testimonials/2.jpg') }}"></div>
                  <p class="font-15 pl-0 text-white"><em>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Neque est quasi, quas ipsam, expedita placeat facilis odio illo ex accusantium eaque.</em></p>
                </div>
              </div>
              <div class="item">
                <div class="testimonial bg-theme-color-2 p-30 pb-20 mt-50">
                  <h4 class="author text-white mt-0 mb-0">Catherine Grace</h4>
                  <h6 class="title text-white mt-0 mb-15">Designer</h6> 
                  <div class="thumb content mt-30"><img class="img-circle" alt="" src="{{ asset('revival/images/testimonials/3.jpg') }}"></div>
                  <p class="font-15 pl-0 text-white"><em>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Neque est quasi, quas ipsam, expedita placeat facilis odio illo ex accusantium eaque.</em></p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section> -->
    
   
    <!-- Divider: Clients -->
    <!-- <section class="clients bg-theme-colored">
      <div class="container pt-10 pb-10 pb-sm-0 pt-sm-0">
        <div class="row">
          <div class="col-md-12">
            
            <div class="owl-carousel-6col transparent text-center owl-nav-top">
              <div class="item"> <a href="#"><img src="{{ asset('revival/images/clients/w5.png') }}" alt=""></a></div>
              <div class="item"> <a href="#"><img src="{{ asset('revival/images/clients/w5.png') }}" alt=""></a></div>
              <div class="item"> <a href="#"><img src="{{ asset('revival/images/clients/w5.png') }}" alt=""></a></div>
              <div class="item"> <a href="#"><img src="{{ asset('revival/images/clients/w5.png') }}" alt=""></a></div>
              <div class="item"> <a href="#"><img src="{{ asset('revival/images/clients/w5.png') }}" alt=""></a></div>
              <div class="item"> <a href="#"><img src="{{ asset('revival/images/clients/w6.png') }}" alt=""></a></div>
            </div>
          </div>
        </div>
      </div>
    </section>       -->

  </div>
  <!-- end main-content -->
  @endsection 
 