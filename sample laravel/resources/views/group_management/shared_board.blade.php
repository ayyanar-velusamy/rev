@extends('layouts.app')
@section('content')
<div class="page-innerwrap">
	<div class="page-head">
		<ul class="list-inline breadcrumb">
			<li><a href="{{route('groups.index')}}">{{ __('Group Management List') }}</a></li>
			<li class="active"><a href="javascript:">Shared Board</a></li>
		</ul>
	</div>
   <!-- Main row -->
	<div class="page-content sharedBoard">
        <!-- left column -->
		<div class="white-box">
			<div class="white-box-head">	
				<h2>Shared Board</h2>
			</div>		
			<div class="white-content">
				<div class="inner-content form-all-input">
				<form method="POST" class="ajax-form" id="groupPostAddForm" action="{{route('groups.store_post')}}" role="form" enctype="multipart/form-data">
					<input name="group_id" id="group_id" type="hidden" value="{{request()->route('id')}}" />
					<input name="group_name" type="hidden" value="{{$group_info->group_name}}" />
					@csrf
					<div class="row">
						<div class="form-group journeyName col-md-4 p-0">
							<label for="inputJourneyName">{{ __('Journey Name') }} <span class="required">*</span></label>
							<select id="inputJourneyName" name="journey_id" class="form-control sharedBoardJourney select2">
								<option value="">Journey Name</option>
								@if($journeys)
									@foreach($journeys as $id => $journey_name)
										<option value="{{ $id }}" > 
										{{ $journey_name }}</option>
									@endforeach
								@endif										
							</select>
						</div>
					</div>
					<div class="sharedBoard_textarea">
						<div class="form-group mb-0">
							<label for="inputBodyName">{{ __('Post') }} <span class="required">*</span></label>
							<textarea id="inputBodyName" class="form-control" maxlength="1024" placeholder="Create Post" name="content"></textarea>
						</div>
						<div class="btn-footer text-right mb-0">
							<a href="javascript:" onclick="resetPost()" class="btn btn-grey">{{ __('Cancel') }}</a>
							<button id="postSumit" type="submit" class="btn btn-green">Post</button>
						</div>
					</div>
					</form>
				</div>
			</div>
			<div id="loadGroupPost_{{request()->route('id')}}">
				@include('group_management/shared_board_posts')
			</div> 
		</div>  
	</div>
</div>

@endsection
