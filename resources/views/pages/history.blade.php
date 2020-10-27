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
 