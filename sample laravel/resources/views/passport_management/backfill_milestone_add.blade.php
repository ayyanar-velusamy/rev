@extends('layouts.app')
@section('content')	
<div class="page-innerwrap">
	<div class="page-head">
		<ul class="list-inline breadcrumb">
			<li id="journeyNameBreadcrumb"><a href="{{route('passport')}}">{{ __('Passport') }}</a></li>
			<li class="active"><a>{{ __('Backfill Milestones') }}</a></li>
		</ul>
	</div>
	<div class="page-content journey_content"> 
		 <form method="POST" class="ajax-form" id="backfillMilesotneAddForm" action="{{route('journeys.store')}}" role="form" enctype="multipart/form-data" > 
			@csrf
			<div class="white-box">	
				<div class="white-box-head">	
					<h2>{{ __('Backfill Milestones') }}</h2>
				</div>
				<div class="white-content">
					<h3>{{ __('Learning Journey') }}</h3>
					<div class="inner-content form-all-input">
						<div class="row m-0">
							<div class="mlj_lft_field col-md-4 p-0 pr-5">
								<div class="form-group">
									<label for="inputName">{{ __('Backfill Milestones') }}</label>
									<input type="text" disabled name="journey_name" class="form-control" id="inputName" maxlength="64"  value="{{old('journey_name', $backfill->journey_name)}}" placeholder="Enter Journey Name">
									@error('journey_name')
									<span class="invalid-feedback err" role="alert">{{$message}}</span>
									@enderror
								</div>
							</div>
							<div class="mlj_rgt_field col-md-8 pl-5">
								<div class="form-group">
								   <label for="inputName">{{ __('Description') }} </label> 
									<textarea disabled name="journey_description" placeholder="Enter Description" maxlength="1024" class="form-control">{{old('journey_description', $backfill->journey_description )}}</textarea>   
									@error('journey_description')
									<span class="invalid-feedback err" role="alert">{{$message}}</span>
									@enderror
								</div>
							</div>	
						</div>
					</div>
				</div>
			</div>
			<div class="btn-footer">
				<a href="{{route('passport')}}" class="btn btn-green">{{ __('Back') }}</a>
			</div>
		</form>
		@php($journey_type_id = 5)
		@php($journey_id = $backfill->id)
		@include('passport_management/backfill_milestone_list')
	</div>
</div>
@endsection
