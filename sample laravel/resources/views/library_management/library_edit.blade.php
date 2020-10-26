@extends('layouts.app')
@section('content')
 
<div class="page-innerwrap">
	<div class="page-head">
		<ul class="list-inline breadcrumb">
			<li><a href="{{route('libraries.index')}}">Library Content List </a></li>
			<li class="active"><a>Edit Content</a></li>
		</ul>
	</div>
	<div class="page-content library_content"> 
		<form method="POST" class="ajax-form" id="libraryEditForm"  action="{{route('libraries.update',[$content->id])}}" role="form" enctype="multipart/form-data">
		@csrf
		@method('PUT')
			<div class="white-box">	
				<div class="white-box-head">	
					<h2>Edit Content Type: {{old('title', $content->title)}}</h2>
				</div>
				<div class="white-content">
					<h3>Library Content Type</h3>
					<div class="inner-content form-all-input">
						<div class="row">
							<div class="col-sm-4 lib_cont_lft pr-4">
								<div class="form-group">
								   <label for="inputName">{{ __('Content Type') }}</label>
									<select name="content_type_id" readonly class="form-control select2" "{{old('content_type_id')}}" >
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
								    <label for="inputProviderName">{{ __($providerSec) }} <span class="required">*</span></label>
									<input type="text" name="provider" class="form-control" id="inputProviderName" value="{{old('provider', $content->provider)}}"  placeholder="Enter {{ __($providerSec) }}">
									@error('journey_name')
									<span class="invalid-feedback err" role="alert">{{$message}}</span>
									@enderror
								</div>
								<div class="form-group arrow_black">
								   <label for="inputName">{{ __('Difficulty') }} <span class="required">*</span></label>
								<select name="difficulty" class="form-control select2" "{{old('difficulty')}}" >
									<option value="">Select Difficulty</option>
									<option {{old('difficulty', $content->difficulty) == "beginner" ? 'selected': ''}} value="beginner">Beginner</option>
									<option {{old('difficulty', $content->difficulty) == "intermediate" ? 'selected': ''}} value="intermediate">Intermediate</option>
									<option {{old('difficulty', $content->difficulty) == "advanced" ? 'selected': ''}} value="advanced">Advanced</option>
								</select>   
								   @error('difficulty')
								   <span class="invalid-feedback err" role="alert">{{$message}}</span>
								   @enderror
								</div>
							</div>
							<div class="col-sm-8 lib_cont_rgt pl-4"">
								<div class="row">
									<div class="form-group  col-md-6 pl-0 pr-4">
									   <label for="inputTitleName">{{ __('Title') }} <span class="required">*</span></label>
										<input type="text" name="title" class="form-control" id="inputTitleName" value="{{old('title', $content->title)}}" placeholder="Enter Title">
									   @error('title')
									   <span class="invalid-feedback err" role="alert">{{$message}}</span>
									   @enderror
									</div>
									<div class="form-group col-md-6 pl-4 pr-0">
									   <label for="inputUrlName">{{ __('URL') }} <span class="required">*</span></label>
										<input type="text" name="url" class="form-control" id="inputUrlName" value="{{old('url',$content->url)}}" placeholder=" Enter URL">
									   @error('url')
									   <span class="invalid-feedback err" role="alert">{{$message}}</span>
									   @enderror
									</div>
								</div>
								<div class="row">
									<div class="form-group col-sm-12 p-0">
									   <label for="inputName">{{ __('Description') }} <span class="required">*</span></label>
									<textarea name="description" class="form-control"  placeholder="Enter Description">{{old('description', $content->description)}}</textarea>   
									   @error('description')
									   <span class="invalid-feedback err" role="alert">{{$message}}</span>
									   @enderror
									</div>
								</div>
							</div>
						</div>
						<div class="row px-3 rowGroupField mn-4"> 
							<div class="form-group arrow_black col-md-4 px-4">
								<label for="inputPaymentTypeName">{{ __('Free or Paid') }} <span class="required">*</span></label>
								<select name="payment_type" class="form-control select2" id="inputPaymentTypeName" >
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
								<input type="text" name="price"  value="{{old('price',$content->price)}}"  class="form-control priceField" id="inputPriceName"  placeholder="Enter Price">
							   @error('title')
							   <span class="invalid-feedback err" role="alert">{{$message}}</span>
							   @enderror
							</div>
							<div class="form-group arrow_black col-md-4 px-4 paymentTypeSec {{$content->payment_type != 'paid' ? 'd-none' : ''}}">
							   <label for="inputApprover">{{ __('Approver') }} <span class="required">*</span></label>
								<select name="approver_id" class="form-control select2" id="inputApprover">
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
							@if(in_array($content_type_id,[2,3,4,5]))
							<div class="form-group col-md-4 px-4">
							   <label for="inputLengthName">{{ __($lengthSec) }}</label>
								<input type="text" name="length" class="form-control" id="inputLengthName" value="{{old('length',$content->length)}}" placeholder=" Enter {{ __($lengthSec) }}">
							   @error('length')
							   <span class="invalid-feedback err" role="alert">{{$message}}</span>
							   @enderror
							</div>
							@endif
							<div class="form-group inputTags col-md-4 px-4">
							   <label for="inputTagsName">{{ __('Tags') }} </label>
								<select name="tags[]" class="form-control tagsInput"  id="inputTagsName" multiple>
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
			    <button type="reset" onclick="resetForm()" class="btn btn-grey">{{ __('Restore') }}</button>
				<a href="{{ back_url(route('libraries.index')) }}" class="btn btn-green">{{ __('Back') }}</a>
				<button type="submit" id="contentEditFormSubmit" class="btn btn-blue">{{ __('Save') }}</button> 
			</div>
		</form>
	</div>
</div>
@endsection
