@extends('layouts.app')
@section('content')
<div class="page-innerwrap">
	<div class="page-head">
		<ul class="list-inline breadcrumb">
			<li><a href="{{route('sliders.index')}}">Slider Management List</a></li>
			<li class="active"><a>Edit Slider</a></li>
		</ul>
	</div>
	<div class="page-content user_manage">
		<form method="POST" class="ajax-form" id="sliderEditForm" action="{{route('sliders.update',[$slider->id])}}" role="form" enctype="multipart/form-data">  
			@csrf
			{{ method_field('PUT') }}
			<div class="white-box">	
				<div class="white-box-head">	
					<h2>Edit Slider </h2>
				</div>
				<div class="white-content"> 
					<div class="inner-content form-all-input">
						<div class="row">
							<div class="col-md-12">
								<div class="row">
									<div class="col-md-6 left-pad pdr-45">
										<div class="form-group">
											<label for="inputTitle">{{ __('Name') }}</label>
											<input type="text" name="name" class="form-control" maxlength="40" id="name"   value="{{$slider->name}}" />
										</div>
									</div>  
									<div class="col-md-6 left-pad pdr-45">
										<div class="form-group checkbox_status">
											<label class="check_label">Status</label>
											<label class="switch round">
												<input id="userStatusHidden" type="hidden" value="active" name="status" >
												<input {{$slider->status == 'active' ? 'checked' :''}} type="checkbox" />
												<span class="slider round"></span>
											</label>
										</div>
									</div>
								</div>
							</div> 
						 </div>
						<div class="row">
							<div class="col-md-12"> 
								<div class="add-banner text-center">
									@if($slider->image != "")
										<img width=1000 height=400 src="{{ banner_image($slider->image) }}" class="img-circle" alt="Banner Image" id="profile-adminImg">
									@else
										<img width=1000 height=400 src="{{asset('images/user_profile.png') }}" class="img-circle" alt="Banner Image" id="profile-adminImg">
									@endif 
									<div class="table-small-img-outer">
										<div class="table-small-img">
										</div>
									</div>
									<div class="text-center account-img acc-upload"> 
											<label for="profile-user" class="fw600 uploadLabel profile_upload">Change Picture</label>
										<input id="profile-user" name="image" class="profileAdmin" type="file" accept="image/*" />
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
			<div class="btn-footer">
				<button type="button" onclick="resetForm()" class="btn btn-grey">{{ __('Restore') }}</button>
				<a href="{{ back_url(route('sliders.index')) }}" class="btn btn-green">{{ __('Back') }}</a>
				<button type="submit" id="sliderEditFormSubmit" class="btn  btn-blue">{{ __('Save') }}</button>
			</div>
		</form>  	
	</div>
</div> 
@endsection
