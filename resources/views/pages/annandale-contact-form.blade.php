@extends('pages.layouts.app')
@section('content')
<!-- Start main-content -->
  <div class="main-content"> 
    <!-- Section: inner-header -->
    <section class="inner-header divider parallax layer-overlay overlay-dark-5" data-bg-img="{{ asset('revival/images/bg/revival_bg3.jpg') }}">
      <div class="container pt-70 pb-120">
        <!-- Section Content -->
        <div class="section-content">
          <div class="row">
            <div class="col-md-12">
              <h2 class="title text-white text-center">Annandale Office</h2> 
            </div>
          </div>
        </div>
      </div>
    </section>
     <section class="divider">
      <div class="container">
        <div class="row">
          <div class="col-md-4">
            <div class="row">
              <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="icon-box left media bg-deep p-30 mb-20"> <a class="media-left pull-left" href="#"> <i class="pe-7s-map-2 text-theme-colored"></i></a>
                  <div class="media-body"> <strong>OUR OFFICE LOCATION</strong>
                    <p>1101 Mercantile Lane, Suite 292 Upper Marlboro, MD 20774-5360</p>
                  </div>
                </div>
              </div>
              <div class="col-xs-12 col-sm-6 col-md-12">
                <div class="icon-box left media bg-deep p-30 mb-20"> <a class="media-left pull-left" href="#"> <i class="pe-7s-call text-theme-colored"></i></a>
                  <div class="media-body"> <strong>OUR CONTACT NUMBER</strong>
                    <p>888-225-6994 ext – 6300</p>
                  </div>
                </div>
              </div>
              <div class="col-xs-12 col-sm-6 col-md-12">
                <div class="icon-box left media bg-deep p-30 mb-20"> <a class="media-left pull-left" href="#"> <i class="pe-7s-mail text-theme-colored"></i></a>
                  <div class="media-body"> <strong>OUR CONTACT E-MAIL</strong>
                    <p>info@revivalhha.com</p>
                  </div>
                </div>
              </div>
              <div class="col-xs-12 col-sm-6 col-md-12">
                <div class="icon-box left media bg-deep p-30 mb-20"> <a class="media-left pull-left" href="#"> <i class="pe-7s-calculator text-theme-colored"></i></a>
                  <div class="media-body"> <strong>OUR CONTACT FAX</strong>
                    <p>888-801-4714</p>
                  </div>
                </div>
              </div>
			  <div class="col-xs-12 col-sm-6 col-md-12">
                <div class="icon-box left media bg-deep p-30 mb-20"> <a class="media-left pull-left" href="#"> <i class="pe-7s-global text-theme-colored"></i></a>
                  <div class="media-body"> <strong>OUR WEBSITE</strong>
                    <p><a>www.revivalhha.com</a></p>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-8">
            <h3 class="line-bottom mt-0 mb-20">Interested in discussing?</h3>
            <p class="mb-20">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Error optio in quia ipsum quae neque alias eligendi, nulla nisi. Veniam ut quis similique culpa natus dolor aliquam officiis ratione libero. Expedita asperiores aliquam provident amet dolores.</p>
			<!-- Reservation Form Start-->
              <form id="reservation_form" name="reservation_form" class="reservation-form" method="post" action="{{route('enquiry')}}">
			  @csrf
                <div class="row">
                  <div class="col-sm-12">
                    <div class="form-group mb-30">
                      <input placeholder="Enter Name" type="text" id="name" name="name" required="" class="form-control">
					  <input type="hidden" id="form_name" name="form_name" value="Annandale Office" class="form-control">
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
                      <textarea placeholder="Question/Comment" id="comment" name="comment" required="" class="form-control"></textarea>
					  <label id="question-error" class="error" for="question"></label>
                    </div>
                  </div> 
                  <div class="col-sm-12">
                    <div class="form-group mb-0 mt-0">
                      <input name="form_botcheck" class="form-control" type="hidden" value="">
                      <button type="submit" class="btn btn-colored btn-theme-colored btn-lg btn-flat border-left-theme-color-2-4px" data-loading-text="Please wait...">Submit Now</button>
					  <button type="reset" class="btn btn-flat btn-theme-colored btn-lg border-left-theme-color-2-4px">Reset</button>  
                    </div>
                  </div>
                </div>
              </form>  
          </div>
        </div>
      </div>
    </section>
    
    <!-- Divider: Google Map -->
    <section>
      <div class="container-fluid pt-0 pb-0">
        <div class="row"> 
          <!-- Google Map HTML Codes --><iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d5456.163483134849!2d144.95177475051227!3d-37.81589041361766!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x6ad65d4dd5a05d97%3A0x3e64f855a564844d!2s121+King+St%2C+Melbourne+VIC+3000%2C+Australia!5e0!3m2!1sen!2sbd!4v1556130803137!5m2!1sen!2sbd" width="100%" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>

        </div>
      </div>
    </section>

  </div>
  <!-- end main-content -->
  @endsection 
  