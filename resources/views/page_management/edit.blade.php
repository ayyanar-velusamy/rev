@extends('layouts.app')
@section('content')
<div class="page-innerwrap">
	<div class="page-head">
		<ul class="list-inline breadcrumb">
			<li><a href="{{route('pages.index')}}">Page Management List</a></li>
			<li class="active"><a>Edit Page</a></li>
		</ul>
	</div>
	<div class="page-content user_manage">
		<form method="POST" class="ajax-form" id="pageEditForm" action="{{route('pages.update',[$page->id])}}" role="form" enctype="multipart/form-data">  
			@csrf
			{{ method_field('PUT') }}
			<div class="white-box">	
				<div class="white-box-head">	
					<h2>Edit Page </h2>
				</div>
				<div class="white-content"> 
					<div class="inner-content form-all-input">
						@if($page->id != "1")
						<div class="row">
							<div class="col-md-12"> 
								<div class="add-banner text-center">
									@if($page->image != "")
										<img width=1000 height=400 src="{{ banner_image($page->image) }}" class="img-circle" alt="Banner Image" id="profile-adminImg">
									@else
										<img width=1000 height=400 src="{{asset('images/banner_picture.png') }}" class="img-circle" alt="Banner Image" id="profile-adminImg">
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
						@else
							<div class="btn-footer">
							<a href="{{ route('sliders.index') }}" class="btn-green btn">{{ __('Edit slider') }}</a>
							</div>
						@endif	
						<div class="row">
							<div class="col-md-12 pad-zero">
								<div class="row">
									<div class="col-md-12 left-pad pdr-45">
										<div class="form-group">
											<label for="inputTitle">{{ __('Title') }}</label>
											<input type="text" name="title" class="form-control" maxlength="40" id="title"   value="{{$page->title}}" autofocus />
										</div>
									</div> 
								</div>
								@if($page->default_page != "1")
								<div class="row">
									<div class="col-md-12 left-pad ">
										<div class="form-group">
										<label for="inputFirstName">Parent Menu<span class="required">*</span></label>
										<select name="parent_menu" id="parent_menu" class="form-control select2">
											<option value="">Select Menu</option>
											@foreach($menus as $id=>$nav)
											<option {{ $page->parent_menu == $nav->id ? 'Selected' : '' }} value="{{ $nav->id }}">{{ $nav->menu_en }}</option>
											@endforeach
										</select> 
									</div>
									</div> 
								</div>
								@else
								<input type="hidden" value="0" name="parent_menu" >
								@endif
								@if($page->menu_id > "0")
								<div class="row">
									<div class="col-md-4 left-pad pdr-45">
										<div class="form-group">
											<label for="inputEmail">{{ __('Menu English') }} <span class="required">*</span></label>
											 <input type="text" name="menu_en" class="form-control" id="menu_en" value="{{$edit_menu->menu_en}}" placeholder="Enter Menu English" />
										</div>
									</div>
									<div class="col-md-4 left-pad pdr-45">
										<div class="form-group">
											<label for="inputEmail">{{ __('Menu Spanish') }} <span class="required">*</span></label>
											 <input type="text" name="menu_es" class="form-control" id="menu_es" value="{{$edit_menu->menu_es}}" placeholder="Enter Menu Spanish" />
										</div>
									</div>	
									<div class="col-md-4 left-pad pdr-45">
										<div class="form-group">
											<label for="inputEmail">{{ __('Menu Arabic') }} <span class="required">*</span></label>
											 <input type="text" name="menu_ar" class="form-control" id="menu_ar" value="{{$edit_menu->menu_ar}}" placeholder="Enter Menu Arabic"  />
										</div>
									</div>										
								</div>
								@endif
								<div class="row">
									<div class="col-md-6 left-pad pdr-45">
										<div class="form-group">
											<label for="inputMetaDescription">{{ __('Meta Description') }} <span class="required">*</span></label>
											 <textarea name="meta_description" class="form-control" id="meta_description"     placeholder="Enter Meta Description">{{$page->meta_description}}</textarea>
										</div>
									</div>
									<div class="col-md-6 right-pad pdl-45">
										<div class="form-group">
											<label for="inputMetaKeyword">{{ __('Meta Keyword') }} <span class="required">*</span></label>
											 <textarea name="meta_keyword" class="form-control" id="meta_keyword" placeholder="Enter Meta Keyword" >{{$page->meta_keyword}}</textarea>
										</div>
									</div>
								</div> 
								<div class="row"> 
									<div class="col-md-12 left-pad">
										<div class="form-group"> 
											<label for="inputContentEn">{{ __('Content English') }} <span class="required">*</span></label>
											<textarea name="content_en" class="ckeditor  form-control" id="content_en sddsd" placeholder="Enter Content English" >{{$page->content_en}}</textarea>
										</div>
									</div>
								</div>
								<div class="row"> 
									<div class="col-md-12 left-pad">
										<div class="form-group">
											<label for="inputFirstName">{{ __('Content Spanish') }} <span class="required">*</span></label>  
											<textarea name="content_es" class="ckeditor  form-control" id="content_es" value="{{old('content_es')}}" placeholder="Enter Meta Keyword">{{$page->content_es}}</textarea>
										</div>
									</div>
								</div>
								<div class="row"> 
									<div class="col-md-12 left-pad">
										<div class="form-group">
											<label for="inputFirstName">{{ __('Content Arabic') }} <span class="required">*</span></label>  
											<textarea name="content_ar" class="ckeditor  form-control" id="content_ar" value="{{old('content_ar')}}" placeholder="Enter Meta Keyword">{{$page->content_ar}}</textarea>
										</div>
									</div>
								</div>
								 
								<div class="row">
									<div class="col-md-6 left-pad pdr-45">
										<div class="form-group checkbox_status">
											<label class="check_label">Status</label>
											<label class="switch round">
												<input id="userStatusHidden" type="hidden" value="inactive" name="status" >
												<input type="hidden" value="{{$page->menu_id}}" name="menu_id" >
												<input {{$page->status == 'active' ? 'checked' :''}}  name="status" value="active" type="checkbox" />
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
				<button type="button" onclick="resetForm()" class="btn btn-grey">{{ __('Restore') }}</button>
				<a href="{{ back_url(route('pages.index')) }}" class="btn btn-green">{{ __('Back') }}</a>
				<button type="submit" id="pageEditFormSubmit" class="btn  btn-blue">{{ __('Save') }}</button>
			</div>
		</form>  	
	</div>
</div> 
@endsection
