@extends('pages.layouts.app')
@section('content')
<!-- Start main-content -->
  <div class="main-content"> 
     @include('pages.common.slider') 
    <!-- Section: About -->
    <section id="about">
      <div class="container">
        <div class="section-content">
          <div class="row"> 
            <div class="col-md-8 col-sm-12 wow fadeInLeft" data-wow-duration="1s" data-wow-delay="0.3s">
              <h2 class="text-uppercase mt-0">About <span class="text-theme-color-2">Us</span></h2> 
			  <ul class="list-img">
				<li><img src="{{ asset('revival/images/list-icon.png') }}"><a href="#">Our Brochure</a></li>
				<li><img src="{{ asset('revival/images/list-icon.png') }}"><a href="#">Our Flyer</a></li>
			  </ul> 
              <p class="rev-p">What is Home Health Care?<br>It is a manner of care delivery that is ideal for most homebound patients. Care can be provided to individuals of any age with conditions that require continuing care by a medical professional, structured treatment or nursing care instruction.<br>Services range from high-tech medical procedures to basic personal care which are provided with the aim to:</p>
              <ul class="list-img">
				<li><img src="{{ asset('revival/images/list-icon.png') }}">reduce the strain caused by long-term hospitalization</li>
				<li><img src="{{ asset('revival/images/list-icon.png') }}">lessen nursing home bills during an illness or disability</li>
				<li><img src="{{ asset('revival/images/list-icon.png') }}">create more flexible home-based care options for the patient and the family</li>
			  </ul>
			  <p class="rev-p">Staying at home enables one to maintain social ties and involvement with community, friends, and family. This preserves a sense of independence and security for the patient. In many cases, the consistency of home health care can eliminate the need for hospitalization altogether.<br>We have the ability to provide appropriate medical and non-medical care to you and your family. If you prefer remaining in the home rather than in institutional settings, <b>Revival Homecare Agency</b> is here to help. We are dedicated to providing the highest quality of healthcare in the comfort of your own home. With a team approach to address your needs, we offer holistic care plans that consider your physical, psychological and spiritual needs as a patient.</p>
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
 