@extends('layouts.app')
@section('content')
<div class="page-innerwrap">
	<div class="page-head">
		<ul class="list-inline breadcrumb"> 
			<li><a href="{{route('roles.index')}}">User Roles Management List</a></li>
			<li class="active"><a>View Role</a></li>
		</ul>
	</div>
	<div class="page-content">
		{!! Form::model($role, ['method' => 'PUT', 'route' => ['roles.update',  $role->id ], 'class' => 'm-b']) !!}
		<div class="white-box">	
			<div class="white-box-head">	
				<h2>View Role</h2>
			</div>
			<div class="white-content">
				<h3>Role</h3>
				<div class="inner-content">
					<div class="row">
						<div class="col-md-6  pad-zero">
							<div class="form-group col-md-8">
							  <label for="inputText">{{ __('Role Name') }}</label>
							  <input disabled type="text" name="name" class="form-control"  maxlength="40" id="inputText" value="{{old('name', $role->name)}}" placeholder="Role Name">
							  @error('name')
							  <span class="invalid-feedback err" role="alert">{{$message}}</span>
							  @enderror
							</div>
						</div>
						<div class="col-md-6  pad-zero">
							<div class="col-md-8">
								<div class="form-group checkbox_status">
									<label for="inputStatus">{{ __('Status') }}</label>
									<label class="switch round">
										  <input disabled id='roleStatusHidden' type='hidden' value='inactive' name='status'>
										  <input disabled type="checkbox" id='roleStatus' name="status" class="form-control" id="inputStatus" {{ $role->status =='active' ? 'Checked':''}} value="active"/>
										  <span class="slider round"></span>
									</label>	
									  @error('status')
									  <span class="invalid-feedback err" role="alert">{{$message}}</span>
									  @enderror
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6  pad-zero">
							<div class="form-group col-md-8">
							  <label for="inputText">{{ __('Created By') }}</label>
							  <input disabled type="text" name="name" class="form-control" id="inputText" value="{{old('name', $role->creator()) }}" placeholder="Role Name">
							  @error('name')
							  <span class="invalid-feedback err" role="alert">{{$message}}</span>
							  @enderror
							</div>
						</div>
						<div class="col-md-6  pad-zero">
							<div class="form-group col-md-8">
							  <label for="inputText">{{ __('Created Date & Time') }}</label>
							  <input disabled type="text" name="name" class="form-control" id="inputText" value="{{old('name', get_date_time($role->created_at))}}" placeholder="Role Name">
							  @error('name')
							  <span class="invalid-feedback err" role="alert">{{$message}}</span>
							  @enderror
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="white-content permission_panel view_page">
				<h3>Permission</h3>
				<div class="inner-content">	
					@if($role->name === 'Admin')
						@include('common._permissions', [
									  'title' => 'Modules',
									  'options' => ['disabled'] ])
					@else
						@include('common._permissions', [
									  'title' => 'Modules',
									  'model' => $role,
									  'options' => ['disabled']])
					@endif
					
				</div>
			</div>
		</div>
		<div class="btn-footer">
			<a href="{{route('roles.index')}}" class="btn btn-green">{{ __('Back') }}</a>
			@can('edit_roles')
			<a href="{{route('roles.edit',[encode_url($role->id)])}}" class="btn btn-blue">{{ __('Edit')
			}}</a>
			@endcan
		</div>
		{!! Form::close() !!}
	</div>
</div>
@endsection