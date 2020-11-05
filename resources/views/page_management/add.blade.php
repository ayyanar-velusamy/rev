@extends('layouts.app')
@section('content')
	
<div class="page-innerwrap">
	<div class="page-head">
		<ul class="list-inline breadcrumb">
			<li><a href="{{route('pages.index')}}">Page Management List</a></li>
			<li class="active"><a>Add Page</a></li>
		</ul>
	</div>
	<div class="page-content user_manage"> 
		 <form method="POST" class="ajax-form" id="pageAddForm" action="{{route('pages.store')}}" role="form" enctype="multipart/form-data" > 
			@csrf
			<div class="white-box">	
				<div class="white-box-head">	
					<h2>Add Page</h2>
				</div>
				<div class="white-content"> 
					<div class="inner-content form-all-input">
					<div class="row">
						<div class="col-md-12">
							<div class="account-bg ">
									<div class="add-banner text-center">
									<img width="1000" height="250" data-src="{{asset('images/profile_picture.png') }}" src="{{asset('images/profile_picture.png') }}" class="img-circle img-responsive" alt="User Image" id="profile-adminImg">
									<div class="table-small-img-outer">
										<div class="table-small-img">
										</div>
									</div>
									<div class="text-center account-img acc-upload"> 
											<label for="profile-user" class="fw600 uploadLabel profile_upload">Banner Picture</label>
										<input id="profile-user" name="image" class="profileAdmin" type="file" accept="image/*"/>
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
						<div class="row"> 
							<div class="col-md-12 pad-zero">
								<div class="row">
									<div class="col-md-12 left-pad ">
										<div class="form-group">
											<label for="inputFirstName">{{ __('Title') }} <span class="required">*</span></label>
											<input type="text" name="title" class="form-control" maxlength="40" id="title" value="{{old('title')}}" placeholder="Enter Page Title" autofocus />
										</div>
									</div> 
								</div> 
								<div class="row">
									<div class="col-md-6 left-pad pdr-45">
										<div class="form-group">
											<label for="inputEmail">{{ __('Meta Description') }} <span class="required">*</span></label>
											 <textarea name="meta_description" class="form-control" id="meta_description" value="{{old('meta_description')}}" placeholder="Enter Meta Description"></textarea>
										</div>
									</div>
									<div class="col-md-6 right-pad pdl-45">
										<div class="form-group">
											<label for="inputEmail">{{ __('Meta Keyword') }} <span class="required">*</span></label>
											 <textarea name="meta_keyword" class="form-control" id="meta_keyword" value="{{old('meta_keyword')}}" placeholder="Enter Meta Keyword"></textarea>
										</div>
									</div>
								</div>
								<div class="row"> 
									<div class="col-md-12 left-pad">
										<div class="form-group">
											<label for="inputFirstName">{{ __('Content English') }} <span class="required">*</span></label>
											<textarea name="content_en" class="ckeditor  form-control" id="content_en" value="{{old('content_en')}}" placeholder="Enter Meta Keyword"></textarea>
										</div>
									</div>
								</div>
								<div class="row"> 
									<div class="col-md-12 left-pad">
										<div class="form-group">
											<label for="inputFirstName">{{ __('Content French') }} <span class="required">*</span></label>  
											<textarea name="content_fr" class="ckeditor  form-control" id="content_fr" value="{{old('content_fr')}}" placeholder="Enter Meta Keyword"></textarea>
										</div>
									</div>
								</div>
								 
								<div class="row">	
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
					</div>
				</div> 
			</div>
			<div class="btn-footer">
				<button type="button" id="clearForm" class="btn btn-grey">{{ __('Clear') }}</button>
				<a href="{{route('users.index')}}" class="btn btn-green">{{ __('Back') }}</a>
				<button type="submit" id="pageAddFormSubmit" class="btn btn-blue">{{ __('Save') }}</button>
			</div>
		</form>
	</div>
</div>
@endsection
