@extends('layouts.app')

@section('content')
<div class="page-innerwrap">
	<div class="page-head">
		<ul class="list-inline breadcrumb">
			<li><a>Tempcheck</a></li>
			<li class="active"><a href="javascript:">Assign Tempcheck</a></li>
		</ul>
	</div>
   <!-- Main row -->
	<div class="page-content tempcheck_content">
		<div class="pageTabTop">
			<ul class="nav nav-tabs" id="joureyTab">
				<li class="nav-item">
				  <a class="nav-link active" data-toggle="tab" href="#tempcheck" data-tabName="Tempcheck">Tempcheck</a>
				</li>
				<li class="nav-item">
				  <a class="nav-link" href="{{route('tempchecks.trend_index')}}" data-tabName="Latest Tempcheck">Latest Tempcheck</a>
				</li>
				<li class="nav-item">
				  <a class="nav-link" href="{{route('tempchecks.assigned_index')}}" data-tabName="My Trends">My Trends</a>
				</li>
			 </ul>
			<div class="tab-content">
				<div id="tempcheck" class="tab-pane active"><br>
					<!-- left column -->
					<form method="POST" class="ajax-form" id="tempcheckAssignForm" action="{{route('tempchecks.store_assign')}}" role="form" enctype="multipart/form-data">
					@csrf
					<input type="hidden" name="tempcheck_id" value="{{ Request::route('id') }}">
					<input type="hidden" id='postId' name="assignment_ids[]">
					<div class="white-box aligCenter885">	
						<div class="white-box-head">	
							<h2>Assign Tempcheck</h2>
						</div>
						<div class="white-content">
							<div class="inner-content form-all-input UserGroupGrade_Class">
								<div class="row mn-15">
									<div class="col-md-4">
										<div class="addMultipleUser pl-0">
											<div class="form-group">
												<div class="adduser_field">
													<label for="inputUserName">{{ __('User') }} <span class="required">*</span></label>
													<select class="form-control select2" id="inputUserName" name="user[]">
														<option value="">Select Group</option>
														@foreach($users as $user)
														<option value="user_{{$user->id}}">{{$user->first_name}} {{$user->last_name}}</option>
														@endforeach
													</select>
												</div>
											</div>
										</div>
									</div>
									<div class="col-md-4">
										<div class="addMultipleUser pl-0">
											<div class="form-group">
												<div class="adduser_field">			
													<label for="inputGroupName">{{ __('Group') }} <span class="required">*</span></label>
													<select class="form-control select2" id="inputGroupName" name="group[]">
														<option value="">Select Group</option>
														@foreach($groups as $group)
														<option value="group_{{$group->id}}">{{$group->group_name}}</option>
														@endforeach
													</select>
												</div>
											</div>
										</div>
									</div>
									<div class="col-md-4">
									<div class="addMultipleUser pl-0">
											<div class="form-group">
												<div class="adduser_field">	 		
													<label for="inputGradeName">{{ __('Grade') }} <span class="required">*</span></label>
													<select class="form-control select2" id="inputGradeName" name="grade[]">
														<option value="">Select Group</option>
														@foreach($grades as $grade)
														<option value="grade_{{$grade->node_id}}">{{$grade->node_name}}</option>
														@endforeach
													</select>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="addMulUserscroll">
									<ul class="addAlluserList  mb-0" id="addAlluserList"></ul>
								</div>
							</div>
						</div> 
					</div>
				<div class="btn-footer">
					<a href="{{route('tempchecks.index')}}" class="btn btn-green">{{ __('Back') }}</a>
					<button type="submit" class="btn btn-blue">Save</button>
				</div>
				</form>				
			</div>
		</div>
	</div>
</div>
@endsection
