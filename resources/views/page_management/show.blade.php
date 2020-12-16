@extends('layouts.app')

@section('content')
<div class="page-innerwrap">
	<div class="page-head">
		<ul class="list-inline breadcrumb">
			<li><a href="{{route('pages.index')}}">Page Management List</a></li>
			<li class="active"><a>View Page</a></li>
		</ul>
	</div>
   <!-- Main row -->
	<div class="page-content user_manage">
        <!-- left column -->
		<div class="white-box">	
			<div class="white-box-head">	
				<h2>View Page</h2>
			</div>
			<div class="white-content"> 
				<div class="inner-content form-all-input">
					<div class="row">
						<div class="col-md-12">
							@if($page->id != "1")
								<div class="add-page text-center"> 
								@if($page->image != "")
									<img width=1000 height=400 src="{{ banner_image($page->image) }}" class="img-circle" alt="Banner Image">
								@else
									<img width=1000 height=400 src="{{asset('images/banner_picture.png') }}" class="img-circle" alt="Banner Image">
								@endif
								</div>
							@else
								<div class="btn-footer">
								<a href="{{ route('sliders.index') }}" class="btn-green btn">{{ __('View Slider') }}</a>
								</div>
							@endif
						</div>
					</div>
					<div class="row"> 
						 <div class="col-md-12 pad-zero">
							<div class="row">
								<div class="col-md-12 left-pad pdr-45">
									<div class="form-group">
										<label for="inputTitle">{{ __('Title') }}</label>
										<input class="form-control" type="text"  maxlength="40"  value="{{$page->title}}" disabled />
									</div>
								</div> 
							</div>
							@if($page->default_page != "1")
							<div class="row">
									<div class="col-md-12 left-pad ">
										<div class="form-group">
										<label for="inputFirstName">Parent Menu  <span class="required">*</span></label>
										<select name="parent_menu" id="parent_menu" class="form-control select2" disabled>
											<option value="">Select Menu</option>
											@foreach($menus as $id=>$nav)
											<option {{ $page->parent_menu == $nav->id ? 'Selected' : '' }} value="{{ $nav->id }}">{{ $nav->menu }}</option>
											@endforeach
										</select> 
									</div>
									</div> 
								</div>
							@endif
							@if($page->menu_id > "0")							
							<div class="row">
									<div class="col-md-4 left-pad pdr-45">
										<div class="form-group">
											<label for="inputEmail">{{ __('Menu English') }} <span class="required">*</span></label>
											 <input type="text" name="menu_en" class="form-control" id="menu_en" value="{{$edit_menu->menu_en}}" placeholder="Enter Menu English" disabled />
										</div>
									</div>
									<div class="col-md-4 left-pad pdr-45">
										<div class="form-group">
											<label for="inputEmail">{{ __('Menu Spanish') }} <span class="required">*</span></label>
											 <input type="text" name="menu_es" class="form-control" id="menu_es" value="{{$edit_menu->menu_es}}" placeholder="Enter Menu Spanish" disabled />
										</div>
									</div>	
									<div class="col-md-4 left-pad pdr-45">
										<div class="form-group">
											<label for="inputEmail">{{ __('Menu Arabic') }} <span class="required">*</span></label>
											 <input type="text" name="menu_ar" class="form-control" id="menu_ar" value="{{$edit_menu->menu_ar}}" placeholder="Enter Menu Arabic" disabled />
										</div>
									</div>										
								</div>
								@endif
							<div class="row">
								<div class="col-md-6 left-pad pdr-45">
									<div class="form-group">
										<label for="inputMetaDescription">{{ __('Meta Description') }} <span class="required">*</span></label>
										 <textarea name="meta_description" class="form-control" id="meta_description" disabled    placeholder="Enter Meta Description">{{$page->meta_description}}</textarea>
									</div>
								</div>
								<div class="col-md-6 right-pad pdl-45">
									<div class="form-group">
										<label for="inputMetaKeyword">{{ __('Meta Keyword') }} <span class="required">*</span></label>
										 <textarea name="meta_keyword" class="form-control" id="meta_keyword" placeholder="Enter Meta Keyword" disabled>{{$page->meta_keyword}}</textarea>
									</div>
								</div>
							</div>
							<div class="row"> 
								<div class="col-md-12 left-pad">
									<div class="form-group"> 
										<label for="inputContentEn">{{ __('Content English') }} <span class="required">*</span></label>
										<textarea name="content_en" class="ckeditor  form-control" id="content_en" placeholder="Enter Content English" disabled>{{$page->content_en}}</textarea>
									</div>
								</div>
							</div>
							<div class="row"> 
									<div class="col-md-12 left-pad">
										<div class="form-group">
											<label for="inputFirstName">{{ __('Content Spanish') }} <span class="required">*</span></label>  
											<textarea name="content_es" class="ckeditor  form-control" id="content_es" value="{{old('content_es')}}" placeholder="Enter Meta Keyword" disabled>{{$page->content_es}}</textarea>
										</div>
									</div>
								</div>
								<div class="row"> 
									<div class="col-md-12 left-pad">
										<div class="form-group">
											<label for="inputFirstName">{{ __('Content Arabic') }} <span class="required">*</span></label>  
											<textarea name="content_ar" class="ckeditor  form-control" id="content_ar" value="{{old('content_ar')}}" placeholder="Enter Meta Keyword" disabled>{{$page->content_ar}}</textarea>
										</div>
									</div>
								</div>
								 
							 
							<div class="row">
								<div class="col-md-6 left-pad pdr-45">
									<div class="form-group checkbox_status">
										<label class="check_label">Status</label>
										<label class="switch round">
											<input id="userStatusHidden" type="hidden" value="inactive" name="status" disabled>
											<input {{$page->status == 'active' ? 'checked' :''}} type="checkbox" disabled />
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
			<a href="{{route('pages.index')}}" class="btn btn-green">{{ __('Back') }}</a>
			@can('edit_users')
			<a href="{{route('pages.edit',[encode_url($page->id)])}}" class="btn btn-blue">{{ __('Edit') }}</a>
			@endcan
		</div>
	</div>
</div>
@endsection
