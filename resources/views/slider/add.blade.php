@extends('layouts.app')
@section('content')
	
<div class="page-innerwrap">
	<div class="page-head">
		<ul class="list-inline breadcrumb">
			<li><a href="{{route('sliders.index')}}">Slider Management List</a></li>
			<li class="active"><a>Add Slider</a></li>
		</ul>
	</div>
	<div class="page-content user_manage"> 
		 <form method="POST" class="ajax-form" id="sliderAddForm" action="{{route('sliders.store')}}" role="form" enctype="multipart/form-data" > 
			@csrf
			<div class="white-box">	
				<div class="white-box-head">	
					<h2>Add Slider</h2>
				</div>
				<div class="white-content"> 
					<div class="inner-content form-all-input">
					<div class="row"> 
							<div class="col-md-12">
								<div class="row">
									<div class="col-md-6 ">
										<div class="form-group">
											<label for="inputFirstName">{{ __('Name') }} <span class="required">*</span></label>
											<input type="text" name="name" class="form-control" maxlength="40" id="name" value="{{old('title')}}" placeholder="Enter Slider Name" autofocus />
										</div>
									</div> 
									<div class="col-md-6 left-pad pdr-45">
										<div class="form-group checkbox_status">
											<label class="check_label">Status  <span class="required">*</span></label>
											<label class="switch round">
												<input id="userStatusHidden" type="hidden" value="active" name="status">
												<input name="status" value="active" disabled="disabled" type="checkbox" checked  />
												<span class="slider round"></span>
											</label>
										</div>
									</div>
								</div> 
							</div>	
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="account-bg ">
									<div class="add-banner text-center">
									<img width="1000" height="400" data-src="{{asset('images/profile_picture.png') }}" src="{{asset('images/profile_picture.png') }}" class="img-circle img-responsive" alt="User Image" id="profile-adminImg">
									<div class="table-small-img-outer">
										<div class="table-small-img">
										</div>
									</div>
									<div class="text-center account-img acc-upload"> 
										<label for="image" class="fw600 uploadLabel profile_upload">Slider Picture</label>
										<input id="image" name="image" class="profileAdmin" type="file" accept="image/*"/>
									</div>  
									<div class="banner-wrap">
										<div id="bannerUpload" ></div> 
									</div>
									<ul class="list-inline btn-footer" >
										<li><a href="javascript:" class="crop-save btn-green btn">Save</a></li>
										<li><a href="javascript:" class="crop-cancel btn-grey btn">Cancel</a></li>
									</ul>
									<p class="error"></p>
								</div>
							</div>
							
							
						</div>
					</div> 
					</div>
				</div> 
			</div>
			<div class="btn-footer">
				<button type="button" id="clearForm" class="btn btn-grey">{{ __('Clear') }}</button>
				<a href="{{route('sliders.index')}}" class="btn btn-green">{{ __('Back') }}</a>
				<button type="submit" id="sliderAddFormSubmit" class="btn btn-blue">{{ __('Save') }}</button>
			</div>
		</form>
	</div>
</div>
@endsection
