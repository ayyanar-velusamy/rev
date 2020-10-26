@extends('layouts.app')
@section('content')


<div class="page-innerwrap">
	<div class="page-head">
		<ul class="list-inline breadcrumb">
			<li><a href="{{route('libraries.index')}}">Library Content List </a></li>
			<li class="active"><a>View Content</a></li>
		</ul>
	</div>
	<div class="page-content library_content"> 
		<form method="POST" class="ajax-form" id="libraryAddForm" action="{{route('libraries.store')}}" role="form" enctype="multipart/form-data">
		@csrf
			<div class="white-box">	
				<div class="white-box-head">	
					<h2>View Content Type: {{old('title', $content->title)}}</h2>
				</div>
				<div class="white-content">
					<h3>Library Content Type</h3>
					<div class="inner-content form-all-input">
						<div class="row">
							<div class="col-sm-4 lib_cont_lft pr-4">
								<div class="form-group">
								   <label for="inputName">{{ __('Content Type') }}</label>
									<select disabled name="content_type_id" class="form-control" "{{old('content_type_id')}}" >
										<option value="">Select option</option>
										@foreach($content_types as $type)
										<option {{old('content_type_id', $content->content_type_id) == $type->id ? 'selected': ''}} value="{{ $type->id }}">{{$type->name}}</option>
										@endforeach
									</select>  
									@error('content_type_id')
									<span class="invalid-feedback err" role="alert">{{$message}}</span>
									@enderror
								</div>
								<div class="form-group">
								     <label for="inputProviderName">{{ __('Provider') }}</label>
									<input disabled type="text" name="provider" class="form-control" id="inputProviderName" value="{{old('provider', $content->provider)}}" placeholder="Enter provider name">
									   @error('journey_name')
									   <span class="invalid-feedback err" role="alert">{{$message}}</span>
									   @enderror
								</div>
								<div class="form-group">
								   <label for="inputName">{{ __('Difficulty') }}</label>
									<select disabled name="difficulty" class="form-control" "{{old('difficulty')}}" >
										<option value="">Select option</option>
										<option {{old('difficulty', $content->difficulty) == "beginner" ? 'selected': ''}} value="beginner">Beginner</option>
										<option {{old('difficulty', $content->difficulty) == "intermediate" ? 'selected': ''}} value="intermediate">Intermediate</option>
										<option {{old('difficulty', $content->difficulty) == "advanced" ? 'selected': ''}} value="advanced">Advanced</option>
									</select>   
								   @error('difficulty')
								   <span class="invalid-feedback err" role="alert">{{$message}}</span>
								   @enderror
								</div>
							</div>
							<div class="col-sm-8 lib_cont_rgt pl-4">
								<div class="row">
									<div class="form-group col-md-6 pl-0 pr-4">
									    <label for="inputTitleName">{{ __('Title') }}</label>
										<input disabled type="text" name="title" class="form-control" id="inputTitleName" value="{{old('title', $content->title)}}" placeholder="Enter Title">
									    @error('title')
									    <span class="invalid-feedback err" role="alert">{{$message}}</span>
									    @enderror
									</div>
									<div class="form-group col-md-6 pl-4 pr-0">
									   <label for="inputUrlName">{{ __('URL') }}</label>
									   <input disabled type="text" name="url" class="form-control" id="inputUrlName" value="{{old('url',$content->url)}}" placeholder="Enter URL">
									   @error('url')
									   <span class="invalid-feedback err" role="alert">{{$message}}</span>
									   @enderror
									</div>
								</div>
								<div class="row">
									<div class="form-group col-sm-12 p-0">
									    <label for="inputName">{{ __('Description') }}</label>
										<textarea disabled name="description" class="form-control">{{old('description', $content->description)}}</textarea>   
									   @error('description')
									   <span class="invalid-feedback err" role="alert">{{$message}}</span>
									   @enderror
									</div>
								</div>
							</div>
						</div>
						<div class="row px-3 rowGroupField mn-4"> 
							<div class="form-group arrow_black col-md-4 px-4">
								<label for="inputName">{{ __('Free or Paid') }}</label>
								<select disabled name="payment_type" class="form-control select2" "{{old('payment_type')}}" >
									<option value="">Select option</option>
									<option {{old('payment_type', $content->payment_type) == "free" ? 'selected': ''}} value="free">Free</option>
									<option {{old('payment_type', $content->payment_type) == "paid" ? 'selected': ''}} value="paid">Paid</option>
								</select>   
							   @error('payment_type')
							   <span class="invalid-feedback err" role="alert">{{$message}}</span>
							   @enderror
							</div>
							<div class="form-group  col-md-4 px-4  paymentTypeSec {{$content->payment_type != 'paid' ? 'd-none' : ''}}">
							   <label for="inputPriceName">{{ __('Price') }} <span class="required">*</span></label>
								<input disabled type="text" name="price" class="form-control priceField" id="inputPriceName" value="{{old('price',$content->price)}}" placeholder="Enter title">
							   @error('title')
							   <span class="invalid-feedback err" role="alert">{{$message}}</span>
							   @enderror
							</div>
							<div class="form-group arrow_black col-md-4 px-4 paymentTypeSec {{$content->payment_type != 'paid' ? 'd-none' : ''}}">
							   <label for="inputApprover">{{ __('Approver') }}</label>
								<select disabled name="approver_id" class="form-control select2" id="inputApprover">
								<option value="">Select Approver</option>
								@foreach($approvers as $approver)
									@if($approver->id == user_id())
										<option {{ $approver->id == $content->approver_id ? 'selected' : '' }} value="{{$approver->id}}">{{ __('lang.my_self') }}</option>
									@else	
										<option {{ $approver->id == $content->approver_id ? 'selected' : '' }} value="{{$approver->id}}">{{$approver->first_name}} {{$approver->last_name}}</option>
									@endif									
								@endforeach
								</select>
							   @error('url')
							   <span class="invalid-feedback err" role="alert">{{$message}}</span>
							   @enderror
							</div>
							<div class="form-group col-md-4 px-4">
							    <label for="inpuCreatedName">{{ __('Uploaded By') }}</label>
								<input disabled type="text" name="length" class="form-control" id="inpuCreatedName" value="{{$content->creator()}}" placeholder="Enter length">
							</div>
							<div class="form-group col-md-4 px-4">
							    <label for="inputRatingName">{{ __('Rating') }}</label>
								<input disabled type="text" name="length" class="form-control" id="inputRatingName" value="{{$content->rating()}} / 5">
							</div>
							@if(in_array($content_type_id,[2,3,4,5]))
							<div class="form-group col-md-4 px-4">
							   <label for="inputLengthName">{{ __($lengthSec) }}</label>
								<input disabled type="text" name="length" class="form-control" id="inputLengthName" value="{{old('length',$content->length)}}" placeholder=" Enter {{ __($lengthSec) }}">
							   @error('length')
							   <span class="invalid-feedback err" role="alert">{{$message}}</span>
							   @enderror
							</div>
							@endif
							<div class="form-group inputTags col-md-4 px-4">
							   <label for="inputTagsName">{{ __('Tags') }} </label>
								<select disabled name="tags[]" class="form-control tagsInput"  id="inputTagsName" multiple>
								@if($content->tags != "")
								@foreach(explode(',',$content->tags) as $tag)
								<option selected value="{{$tag}}">{{$tag}}</option>
								@endforeach
								@endif
								</select>
							   @error('tags')
							   <span class="invalid-feedback err" role="alert">{{$message}}</span>
							   @enderror
							</div>						
						</div>
					</div>
				</div>
			</div>
			<div class="btn-footer">
			    <a href="{{route('libraries.index')}}" class="btn btn-grey">{{ __('Back') }}</a>
				@if(auth()->user()->hasPermissionTo('assign_libraries'))
				<a href="{{route('libraries.assign',[encode_url($content->id)])}}" class="btn btn-green">{{ __('Assign') }}</a>
				@endif				
				@if(auth()->user()->hasPermissionTo('edit_libraries'))
				<a href="{{route('libraries.edit',[encode_url($content->id)])}}" class="btn btn-blue">{{ __('Edit') }}</a>
				@endif
				<a href="javascript:" onclick="addToMyJourney('{{encode_url($content->id)}}')" class="btn btn-lightblue">{{ __('Add to My Journey') }}</a> 
			</div>
		</form>
		<div id="loadAddContentModal"></div>
	</div>
</div>
@endsection
