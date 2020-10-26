@extends('layouts.app')
@section('content')
<div class="page-innerwrap">
	<div class="page-head">
		<ul class="list-inline breadcrumb"> 
			<li><a href="{{route('roles.index')}}">User Roles Management List</a></li>
			<li class="active"><a>Add Role</a></li>
		</ul>
	</div>
	<div class="page-content">
		{!! Form::model("role", ['method' => 'POST', 'route' => ['roles.store' ], 'class' => 'm-b ajax-form', 'id' => 'rolesAddForm']) !!}
		<div class="white-box">	
			<div class="white-box-head">	
				<h2>Add Role</h2>
			</div>
			<div class="white-content">
				<h3>Role</h3>
				<div class="inner-content">
					<div class="row">
						<div class="col-md-6  pad-zero">
							<div class="form-group col-md-8">
							  <label for="inputText">{{ __('Role Name') }} <span class="required">*</span></label>
							  <input type="text" name="name" class="form-control" maxlength="40" id="inputText" value="{{old('name')}}" placeholder="Enter Role Name" autofocus />
							  @error('name')
							  <span class="invalid-feedback err" role="alert">{{$message}}</span>
							  @enderror
							</div>
						</div>
						<div class="col-md-6  pad-zero">	
							<div class="col-md-8">
								<div class="form-group checkbox_status">
									<label for="inputStatus">{{ __('Status') }} <span class="required">*</span></label>
									<label class="switch round">
										<input id='roleStatusHidden' type='hidden' value='inactive' name='status'>
										<input type="checkbox" id='roleStatus' name="status" class="form-control" id="inputStatus" value="active" checked />
										<span class="slider round"></span>
									</label>
								  @error('status')
								  <span class="invalid-feedback err" role="alert">{{$message}}</span>
								  @enderror
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>	
			<div class="white-content permission_panel">
				<h3>Permission <span>*</span></h3>
				<div class="inner-content">
				@include('common._permissions', [
					  'title' =>'Modules',
					  'model' => [] ])
				</div>	
			</div>	
		</div>	
		@can('edit_roles')
		<div class="btn-footer">
			<button type="button" id="clearForm" class="btn btn-grey">{{ __('Clear') }}</button>
			<a href="{{route('roles.index')}}" class="btn btn-green">{{ __('Back') }}</a>
			{!! Form::submit('Save', ['class' => 'btn btn-blue ', 'id' => 'rolesAddFormSubmit']) !!} 
		</div>
		@endcan
		{!! Form::close() !!}
	</div>
</div>
@endsection