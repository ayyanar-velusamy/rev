@extends('layouts.app')

@section('content')
 
<div class="col-sm-12 emphrcontent padding-none">
	<div class="text_shadow col-sm-12 padding-none">
		<ul class="list-inline breadcrumb">
			<li class="active"><a href="javascript:">Journey Management</a></li>
		</ul>
	</div>
      
      <!-- Main row -->
      <div class="row">
        <!-- left column -->
        <div class="col-md-12">
          <!-- general form elements -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">{{ __('Journey Edit') }}</h3>
            </div>
			
            <!-- /.box-header -->
            <!-- form start -->
             <div class="box-body">
				<div class="row">
					<div class="col-sm-5 padding-none">
						<div class="form-group">
						   <label for="inputName">{{ __('Journey Name') }}</label>
						<input disabled type="text" name="journey_name" class="form-control" id="inputName" value="{{old('journey_name',$journey->journey_name)}}" placeholder="Enter journey name">
						   @error('journey_name')
						   <span class="invalid-feedback err" role="alert">{{$message}}</span>
						   @enderror
						</div>
						<div class="form-group">
						   <label for="inputName">{{ __('Journey Type') }}</label>
						<select disabled name="journey_type_id" class="form-control" "{{old('journey_type_id')}}" >
							<option value="">Select option</option>
							@foreach($journey_types as $type)
							<option  {{$journey->journey_type_id == $type->id ? 'selected' : ""}} value="{{ $type->id }}">{{$type->name}}</option>
							@endforeach
						</select>   
						   @error('journey_type_id')
						   <span class="invalid-feedback err" role="alert">{{$message}}</span>
						   @enderror
						</div>
						<div class="form-group">
						   <label for="inputName">{{ __('Visibility') }}</label>
						<select disabled name="visibility" class="form-control" "{{old('visibility')}}" >
							<option value="">Select option</option>
							<option {{$journey->visibility == 'private' ? 'selected' : ""}} value="private">Private</option>
							<option {{$journey->visibility == 'public' ? 'selected' : ""}} value="public">Public</option>
						</select>   
						   @error('visibility')
						   <span class="invalid-feedback err" role="alert">{{$message}}</span>
						   @enderror
						</div>
	
					</div>
					<div class="col-sm-7 padding-none">
						<div class="form-group">
						   <label for="inputName">{{ __('Description') }}</label>
						<textarea disabled name="journey_description" class="form-control">		
						{{old('journey_description', $journey->journey_description)}}						
						</textarea>   
						   @error('journey_description')
						   <span class="invalid-feedback err" role="alert">{{$message}}</span>
						   @enderror
						</div>
					</div>
				</div>
               </div>

              <!-- /.box-body -->

              <div class="box-footer">
              <a href="{{route('journeys.index')}}" class="btn btn-default">{{ __('Back') }}</a>
			  <a href="{{route('journeys.edit',[encode_url($journey->id)])}}" class="btn btn-warning">{{ __('Edit') }}</a>
              </div>
          </div>
          <!-- /.box -->
      </div>
      <!-- /.row -->
	</div>
		<div id="journeyBreakDown"></div>		
		@php( $journey_type_id  = $journey->journey_type_id)	
		@include('journey_management/milestone_list')
	</div>
</div>
@endsection
