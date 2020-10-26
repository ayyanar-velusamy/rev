@extends('layouts.app')

@section('content')
<div class="page-innerwrap">
	<div class="page-head">
		<ul class="list-inline breadcrumb">
			<li><a>Tempcheck</a></li>
			<li class="active"><a href="javascript:">Edit Tempcheck</a></li>
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
					<form method="POST" class="ajax-form" id="tempcheckAddForm" action="{{route('tempchecks.update',[$tempcheck->id])}}" role="form" enctype="multipart/form-data">
					@csrf
					{{ method_field('PUT')}}
					<div class="white-box aligCenter885">	
						<div class="white-box-head">	
							<h2>Edit Tempcheck</h2>
						</div>
						<div class="white-content">
								<div class="inner-content form-all-input">
									<div class="row">
										 <div class="col-md-12 pad-zero">
											<div class="row">
												<div class="col-md-12 left-pad">
													<div class="form-group">
														<label for="inputQuestionName">{{ __('Question') }} <span class="required">*</span></label>
														<textarea id="inputQuestionName" class="form-control " name="question" type="text" />{{old('question',$tempcheck->question) }}</textarea>
													</div>
												</div>
												<div class="col-md-12 left-pad">
													<div class="row">
														<div class="form-group col-md-6">
															<label for="inputFrequencyName">{{ __('Frequency') }} <span class="required">*</span></label>
															<div class="form-group">
																<ul class="radioTempCheck">
																	<li><label><input type="radio" name="frequency" id="inputValue1" {{old('frequency',$tempcheck->frequency) == 'weekly' ? 'checked' : '' }} value="weekly"> <i></i>Weekly</label></li>
																	<li><label><input type="radio" name="frequency" id="inputValue2" {{old('frequency',$tempcheck->frequency) == 'bi-weekly' ? 'checked' : '' }}  value="bi-weekly"><i></i>Bi-Weekly</label></li>
																	<li><label><input type="radio" name="frequency" id="inputValue3" {{$tempcheck->frequency == 'monthly' ? 'checked' : '' }}  value="monthly"> <i></i> Monthly</label></li>
																</ul>
															</div>
														</div>
														<div class="form-group col-md-6  arrow_black pr-0 pl-4">
															<label for="inputDueDateName">{{ __('Due Date') }} <span class="required">*</span></label>
															<input type="text" name="due_date" class="form-control datepicker" id="inputDueDateName" value="{{get_date($tempcheck->due_date)}}"  placeholder="Pick Due Date ">
														</div>
														<div class="form-group col-md-6  arrow_black frequencyDay pr-0 pl-4 {{ ($tempcheck->frequency == 'monthly') ? 'd-none' : '' }}">
															<label for="inputWeeklyName">{{ __('Frequency day') }} <span class="required">*</span></label>
															<select class="form-control select2" id="inputWeeklyName" name="frequency_day">
																<option value="">Select day</option>
																<option {{old('frequency_day',$tempcheck->frequency_day) == 'mon' ? 'selected' : '' }} value="mon">Monday</option>
																<option {{old('frequency_day',$tempcheck->frequency_day) == 'tue' ? 'selected' : '' }} value="tue">Tuesday</option>
																<option {{old('frequency_day',$tempcheck->frequency_day) == 'wed' ? 'selected' : '' }} value="wed">Wednesday</option>
																<option {{old('frequency_day',$tempcheck->frequency_day) == 'thu' ? 'selected' : '' }} value="thu">Thursday</option>
																<option {{old('frequency_day',$tempcheck->frequency_day) == 'fri' ? 'selected' : '' }} value="fri">Friday</option>
																<option {{old('frequency_day',$tempcheck->frequency_day) == 'sat' ? 'selected' : '' }} value="sat">Saturday </option>
																<option {{old('frequency_day',$tempcheck->frequency_day) == 'sun' ? 'selected' : '' }} value="sun">Sunday</option>
															</select>
														</div>
														<div class="form-group col-md-6  arrow_black DateofMonth pr-0 pl-4 {{ ($tempcheck->frequency == 'monthly') ? '' : 'd-none' }}">
															<label for="inputMonthlyName">{{ __('Date for Month') }} <span class="required">*</span></label>
															<select class="form-control select2" id="inputMonthlyName" name="frequency_day">
																<option value="">Select date</option>
																@foreach(range(1,31) as $val)
																<option {{old('frequency_day',$tempcheck->frequency_day) == $val ? 'selected' : '' }} value="{{$val}}">{{$val}}</option>
																@endforeach
															</select>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
						</div>
					</div>  
					<div class="btn-footer">
						<button type="button" class="btn btn-grey">Restore</button>
						<a href="{{back_url(route('tempchecks.index'))}}" class="btn btn-green">{{ __('Back') }}</a>
						<button type="submit" class="btn btn-blue">Update</button>
					</div>
				</form>
			</div>
		</div>
		</div>
	</div>
</div>
@endsection
