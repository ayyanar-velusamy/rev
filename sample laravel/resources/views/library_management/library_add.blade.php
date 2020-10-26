@extends('layouts.app')
@section('content')
 
<div class="page-innerwrap">
	<div class="page-head">
		<ul class="list-inline breadcrumb">
			<li><a href="{{route('libraries.index')}}">Library Content List </a></li>
			<li class="active"><a>Add Content</a></li>
		</ul>
	</div>
	<div class="page-content library_content"> 
		<form method="POST" class="ajax-form" id="libraryAddForm" action="{{route('libraries.store')}}" role="form" enctype="multipart/form-data">
		@csrf
			<div class="white-box">	
				<div class="white-box-head">	
					<h2>Add Content Type</h2>
				</div>
				<div class="white-content">
					<h3>Library Content Type</h3>
					<div class="inner-content form-all-input">
						<div class="row">
							<div class="col-sm-4 lib_cont_lft pr-4">
								<div class="form-group">
								   <label for="content_type_id">{{ __('Content Type') }}</label>
									<select name="content_type_id" id="content_type_id" readonly class="form-control select2" >
										<option value="">Select option</option>
										@foreach($content_types as $type)
										<option value="{{ $type->id }}">{{$type->name}}</option>
										@endforeach
									</select>  
									@error('content_type_id')
									<span class="invalid-feedback err" role="alert">{{$message}}</span>
									@enderror
								</div>
								<div class="form-group inputProviderSec">
								    <label for="inputProviderName">{{ __('Provider') }} <span class="required">*</span></label>
									<input type="text" name="provider" class="form-control" id="inputProviderName" value="{{old('provider')}}" placeholder="Enter Provider">
									@error('journey_name')
									<span class="invalid-feedback err" role="alert">{{$message}}</span>
									@enderror
								</div>
								<div class="form-group arrow_black">
								   <label for="inputName">{{ __('Difficulty') }} <span class="required">*</span></label>
								<select name="difficulty" class="form-control select2" "{{old('difficulty')}}" >
									<option value="">Select Difficulty</option>
									<option value="beginner">Beginner</option>
									<option value="intermediate">Intermediate</option>
									<option value="advanced">Advanced</option>
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
										<input type="text" name="title" class="form-control" id="inputTitleName" value="{{old('title')}}" placeholder="Enter Title">
									   @error('title')
									   <span class="invalid-feedback err" role="alert">{{$message}}</span>
									   @enderror
									</div>
									<div class="form-group col-md-6 pl-4 pr-0">
									   <label for="inputUrlName">{{ __('URL') }} <span class="required">*</span></label>
										<input type="text" name="url" class="form-control" id="inputUrlName" value="{{old('url')}}" placeholder=" Enter URL">
									   @error('url')
									   <span class="invalid-feedback err" role="alert">{{$message}}</span>
									   @enderror
									</div>
								</div>
								<div class="row">
									<div class="form-group col-sm-12 p-0">
									   <label for="inputName">{{ __('Description') }} <span class="required">*</span></label>
									<textarea name="description" class="form-control"  placeholder="Enter Description"></textarea>   
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
								<select name="payment_type" id="inputPaymentTypeName" class="form-control select2"  >
									<option value="">Select option</option>
									<option value="free">Free</option>
									<option value="paid">Paid</option>
								</select>   
								@error('payment_type')
								<span class="invalid-feedback err" role="alert">{{$message}}</span>
								@enderror
							</div>
							<div class="form-group  col-md-4 px-4 paymentTypeSec d-none">
							   <label for="inputPriceName">{{ __('Price') }} <span class="required">*</span></label>
								<input type="text" name="price" class="form-control priceField" id="inputPriceName"  placeholder="Enter Price">
							   @error('title')
							   <span class="invalid-feedback err" role="alert">{{$message}}</span>
							   @enderror
							</div>
							<div class="form-group arrow_black col-md-4 px-4 paymentTypeSec d-none">
							   <label for="inputApprover">{{ __('Approver') }} <span class="required">*</span></label>
								<select name="approver_id" class="form-control select2" id="inputApprover">
								<option value="">Select Approver</option>
								@foreach($approvers as $approver)
									@if($approver->id == user_id())
										<option value="{{$approver->id}}">{{ __('lang.my_self') }}</option>
									@else	
										<option value="{{$approver->id}}">{{$approver->first_name}} {{$approver->last_name}}</option>
									@endif
								@endforeach
								</select>
							   @error('url')
							   <span class="invalid-feedback err" role="alert">{{$message}}</span>
							   @enderror
							</div>
							<div class="form-group inputTags col-md-4 px-4">
							   <label for="inputTagsName">{{ __('Tags') }} </label>
								<select name="tags[]" class="form-control tagsInput"  id="inputTagsName" multiple>
								</select>
							   @error('tags')
							   <span class="invalid-feedback err" role="alert">{{$message}}</span>
							   @enderror
							</div>
							<div class="form-group col-md-4 px-4 inputLengthSec">
							   <label for="inputLengthName">{{ __('Length') }} (minutes)</label>
								<input type="text" name="length" class="form-control" id="inputLengthName" value="{{old('length')}}" placeholder=" Enter Length">
							   @error('length')
							   <span class="invalid-feedback err" role="alert">{{$message}}</span>
							   @enderror
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="btn-footer">
				<button type="button" id="clearForm" class="btn btn-grey">{{ __('Clear') }}</button>
			    <a href="{{route('libraries.index')}}" class="btn btn-green">{{ __('Back') }}</a>
				<button type="submit" id="journeyAddFormSubmit" class="btn btn-blue">{{ __('Save') }}</button> 
			</div>
		</form>
	</div>
</div>
@endsection
