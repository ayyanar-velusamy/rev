@extends('layouts.app')
@section('content')
<div class="page-innerwrap">
	<div class="page-head">
		<ul class="list-inline breadcrumb"> 
			<li class=""><a href="javascript:">Library Management List</a></li>
		</ul>
		<div class="top_search_box">
			<form>
				<input id="dataTableSearch" type="input" name="serching" placeholder="Search" />
			</form>	
		</div>
	</div>
	<div class="page-content library_list">
		<div class="comn_dataTable">
			  <!-- general form elements -->
				<div class="top_fileter">
					<div class="top_left_form">
						<div class="row m-0">
							<div class="form-group contentName col-md-2 p-0">
								<select class="form-control filterByLibraryId select2">
									<option value="">Library</option>							
									@if($contents)
										@foreach($contents as $content)
										<option value="{{ $content->title }}">{{$content->title}}</option>
										@endforeach
									@endif
								</select>
							</div>
							<div class="form-group contentType col-md-2 p-0 pl-2">
								<select class="form-control filterByContentType select2">
									<option value="">Content Type</option>
									@if($content_types)
										@foreach($content_types as $type)
										<option value="{{ $type->id }}">{{$type->name}}</option> 
										@endforeach
									@endif											
								</select>
							</div>
							<div class="form-group uploadedBy  col-md-2 p-0 pl-2 ">
								<select class="filterByCreatedBy form-control select2">
									<option value="">Uploaded By</option>
									@if($created_by)}
										@foreach($created_by as $created)
											@if($created->id == user_id())
												@php($created->created_name = "Me")
											@endif
											<option value="{{ $created->id }}" > {{ $created->created_name }}</option>
										@endforeach
									@endif	
								</select>
							</div>
							<div class="form-group createdDate date-rangePicker col-md-2 p-0 pl-2">
								<input type="text" class="filterByCreatedDate form-control daterangepicker" name="created_date" placeholder="Created Date" />
							</div>
							<div class="form-group rating col-md-2 p-0 pl-2">
								<select class="filterByRating form-control select2">
									<option value="">Rating</option>
									<option value="0">0</option>
									@if($ratings)
										@foreach($ratings as $rating)
										<option value="{{ $rating->rating }}">{{round($rating->rating,2)}}</option>
										@endforeach
									@endif
								</select>
							</div>
						</div>
					</div>
					<div class="top_right_btn">
						@can('add_libraries')
						<div class="lib_relative">
							<a title="{{ __('Add Library')}}"  class="btn add-content btn-green"> <i class="icon-plus"></i> {{ __('Add Content')}}</a>
							<div class="library_drop"  style="display:none;">
								<ul class="list-unstyled">
									<li><a href="{{ url('passport') }}">Predefined Journey </a></li>
									<li><a data-toggle="modal" data-target="#milstoneContentTypeAdd" >Add Content</a></li>
								</ul>
							</div>
						</div>
						@endcan
					</div>
				</div>
				<div class="row" id="loadContentBlock">
					
				</div> 
				<div class="table-responsive d-none">
					<table id="userList" class="table dataTable table-striped">
						<thead>
							<table id="libraryList" class="table table-bordered table-hover">
							  <thead>
							  <tr>
								<th>Content Title</th>
								<th>Content Type</th>
								<th>Created By</th>
								<th>Created Date</th>
								<th>Ratings</th>
								<th>Action</th>
							  </tr>
							  </thead>
							</table>
						</thead>
					</table>
				</div>
		</div>
		<div id="loadAddContentModal"></div>
	</div>
</div>
<!-- Milestone type selection modal -->
<div id="milstoneContentTypeAdd" class="modal modal600 fade" role="dialog"  data-backdrop="static">
	<div class="modal-dialog modal-dialog-centered ">
		<!-- Modal content-->
		<div class="modal-content text-left">
			<div class="modal-header">
				<button type="reset" class="btn-close" title="Close" data-dismiss="modal">x</button>
				<h2>Content Type</h2>
			</div>
			<div class="modal-body">
				<div class="form-all-input">
					<label>Select Content Type <span class="required">*</span></label>
					<div class="row">
						@foreach($content_types as $type)
						<div class="col-md-3 {{$type->name}} form-group milestone_types p-0 pt-2 pb-2">
						   <label for="{{$type->name}}" >
						   <input type="radio" name="content_type" id="{{$type->name}}" class="milestoneContentType form-control" value="{{ $type->id}}" >
						   <i class="{{$type->name}}"></i>
						   <span>{{$type->name}}</span></label>
						</div>
						@endforeach
					</div>
				</div>			
				<div class="btn-footer">
					<button type="reset" class="btn-grey btn" data-dismiss="modal">Cancel</button>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
