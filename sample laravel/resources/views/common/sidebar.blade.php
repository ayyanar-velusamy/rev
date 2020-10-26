<div class="col-sm-1 left-sidebar padding-none" >
	<div class="main_menu text-center clearfix" id="sidebar_scroll">
	<ul class="list-unstyled">  
		<li class="left_menu_list dashboard {{ request()->is('dashboard*') ? 'active' : '' }}">
			<a href="{{ route('dashboard.index')}}" tabindex="1">
				<i class="icon-dashboard" title="Dashboard"></i>
				<h5 class="fw600">Dashboard</h5>
			</a>
		</li>
		
		@canany (['view_organizations','view_roles'])
		<li class="left_menu_list organization_structure drop_menu {{ request()->is('organization-chart*') || request()->is('organization_list*') || request()->is('roles*') ? 'active' : '' }}" >
			<a href="javascript:"  tabindex="2">
				<i class="icon-org-list" title="Organization Structure"> 
					<span class="path1"></span><span class="path2"></span><span class="path3"></span>
				</i>
				<h5 class="fw600">Organization Structure</h5>
			</a>
			 <div class="orgview submenu-list animation text-left">
				<ul class="list-unstyled">
					@can('view_organizations')
					<li><a href="{{ url('/organization-chart') }}">Organizational Chart<i class="icon-hierarchical"></i></a></li>
					<li><a href="{{ url('/organization_list') }}">Organizational List<i class="icon-org-struc "></i></a></li>
					@endcan
					@can('view_roles')
					<li><a href="{{ route('roles.index')}}">User Roles Management<i class="icon-userrole"></i></a></li>
					@endcan
				</ul>
			</div>
		</li>
		@endcan
		
		@can('view_users')
		<li class="left_menu_list user_management {{ request()->is('users*') ? 'active' : '' }}">
			<a title="User Management" href="{{ route('users.index')}}"  tabindex="3">
				<i class="icon-user"></i>
				<h5 class="fw600">User Management</h5>
			</a>
		</li>
		@endcan
		
		@can('view_groups')
		<li class="left_menu_list group_management {{ request()->is('groups*') ? 'active' : '' }}">
			<a title="Groups" href="{{ route('groups.index')}}"  tabindex="4">
				<i class="icon-group"></i>
				<h5 class="fw600">Groups</h5>
			</a>
		</li>
		@endcan
		
		@can('view_journeys')		
		<li class="left_menu_list learing_journey {{ request()->is('journeys*') ? 'active' : '' }}">
			<a title="Learning Journeys" href="{{ route('journeys.index')}}"  tabindex="5">
				<i class="icon-learn-journey" ></i>
				<h5 class="fw600">Learning Journeys</h5>
			</a>
		</li>
		@endcan
		
		@can('view_libraries')
		<li class="left_menu_list library {{ request()->is('libraries*') ? 'active' : '' }}">
			<a title="Libraries" href="javascript:"  tabindex="6">
			<!--<a href="{{ route('libraries.index')}}">-->
				<i class="icon-book-lib" ></i>
				<h5 class="fw600">Libraries</h5>
			</a>
		</li>
		@endcan

		@canany(['view_approvals','full_approvals','approval_approvals'])
		<li class="left_menu_list approval_management {{ request()->is('approvals*') ? 'active' : '' }}">
			<a title="Approvals" href="{{ route('approvals.index')}}"  tabindex="7">
				<i class="icon-checked-files"></i>
				<h5 class="fw600">Approvals</h5>
			</a>
		</li>
		@endcan
		
		@can('view_peers')
		<li class="left_menu_list peers {{ (request()->is('peers*') || request()->is('passport/journey/*/*')) ? 'active' : '' }}">
			<a title="Peers" href="javascript:"  tabindex="8">
				<i class="icon-handshake"></i>
				<h5 class="fw600">Peers</h5>
			</a>
		</li>
		@endcan
		<li class="left_menu_list passport drop_menu {{ (request()->is('passport') || request()->is('profile*') || (request()->is('passport/journey/*') && request()->segment(4) == "")) ? 'active' : '' }}" >
			<a href="javascript:"  tabindex="9">
				<i class="icon-passport" title="Passport / Profile"> 
					<span class="path1"></span><span class="path2"></span><span class="path3"></span>
				</i>
				<h5 class="fw600">Passport / <br>Profile</h5>
			</a>
			 <div class="orgview submenu-list animation text-left">
				<ul class="list-unstyled">
					<li><a href="javascript:">Profile<i class="icon-hierarchical"></i></a></li>
					<li><a href="javascript:">Passport<i class="icon-passport"></i></a></li>
				</ul>
			</div>
		</li>
		@can('view_tempchecks')
		<li class="left_menu_list tempcheck {{ request()->is('tempchecks*') ? 'active' : '' }}">
			<a title="Temp Check" href="javascript:"  tabindex="10">
				<i class="icon-tempcheck"></i>
				<h5 class="fw600">Temp Check</h5>
			</a>
		</li>
		@endcan
		@can('view_reports')
		<li class="left_menu_list report {{ request()->is('reports*') ? 'active' : '' }}">
			<a title="Reports" href="javascript:"  tabindex="11">
				<i class="icon-report" ></i>
				<h5 class="fw600">Reports</h5>
			</a>
		</li>
		@endcan
	</ul>
	</div>
	<div class="side_footer text-center col-sm-12 padding-none">
		<span>&copy;</span>
		<span class="text-upper">{{ date('Y') }} LXP</span>
	</div>
</div>
 

<div id="loadAddLearningJourney"></div>

<div class="modal modal-danger fade" id="modal-danger" data-backdrop="static">
		<div class="modal-dialog modal-dialog-centered">
		  <div class="modal-content">
			<div class="modal-header">	
				<h2>Delete</h2>
				<button type="button" class="btn-close" title="Close" data-dismiss="modal">x</button>
			</div>
			<div class="modal-body">
				<input type="hidden" id="commonDeleteId">
				<h4>Are you sure <span>you want to delete <span id="commonDeleteName"></span>?</span></h4>
				<div class="btn-footer">
				  <button type="button" id="deleteNo" class="btn btn-grey" data-dismiss="modal">No</button>
				  <button type="button" id="deleteYes" class="btn btn-green modal-submit-yes">Yes</button>
				</div>
		  </div>
		  <!-- /.modal-content -->
		</div>
		<!-- /.modal-dialog -->
	</div>
</div>
<div class="modal modal600 modal-danger fade" id="common-confirm" data-backdrop="static" data-keyboard="false">
		<div class="modal-dialog modal-dialog-centered">
		  <div class="modal-content">
			<div class="modal-header">	
				<h2 id="common-confirm-title"></h2>
				<button type="button" class="btn-close" title="Close" data-dismiss="modal">x</button>
			</div>
			<div class="modal-body">
				<input type="hidden" id="commonConfirmId">
				<h4>Are you sure <span id="common-confirm-content"></span> <span id="common-confirm-name"></span></h4>
				<div class="btn-footer">
				  <button type="button" id="commonNo" class="btn btn-grey" data-dismiss="modal">No</button>
				  <button type="button" id="commonYes" class="btn btn-green modal-submit-yes">Yes</button>
				</div>
		  </div>
		  <!-- /.modal-content -->
		</div>
		<!-- /.modal-dialog -->
	</div>
</div>

<!-- Milestone Notes Edit modal -->
<div id="milstoneNotesEdit" class="modal modal928 fade" role="dialog" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog modal-dialog-centered">
		<!-- Modal content-->
		<div class="modal-content text-left">
		{!! Form::open(['enctype' => 'multipart/form-data', 'class' => 'clearfix', 'id'=>'milestoneEditNotesForm' ]) !!}
			<input type="hidden" id="inputEditMilstoneId">
			<input type="hidden" id="inputEditAssignmentId">
			<input type="hidden" name="title" id="inputEditMilstoneTitle">
			<div class="modal-header">
				<button type="button" class="btn-close" title="Close" data-dismiss="modal">x</button>
				<h2>Edit Notes</h2>
			</div>
			<div class="modal-body">
				<div class="form-all-input">
					<p class="quesNotes text-center">What are your major takeaways from this Milestone? <span>How will it impact your work?</span></p>
					<div class="form-group notesTextarea">
						<textarea id="inputMilstoneEditNote" name="notes" class="form-control"></textarea>
					</div>
				</div>			
				<div class="btn-footer">
					<button type="button" id="milstoneEditModalRestore" class="btn-grey btn" >Restore</button>
					<button type="submit" id="" class="btn-green btn" >Save</button>
				</div>
			</div>
		{{ Form::close() }}
		</div>
	</div>
</div>
<div class="modal modal-danger fade" id="predefinedJourneyDuplicateModal" data-backdrop="static" data-keyboard="false">
		<div class="modal-dialog modal-dialog-centered">
		  <div class="modal-content">
			<div class="modal-header">	
				<h2>Duplicate</h2>
				<button type="reset" title="Close" class="btn-close" data-dismiss="modal">close</button>
			</div>
			<div class="modal-body">
				<form class="ajax-form" method="POST"  id="duplicateJourneyForm" action="{{route('journeys.duplicate')}}">
				@csrf
				<input type="hidden" name="journey_id" id="duplicate_journey_id">
				<h4>Please enter a name<span> for the Journey</span></h4>
				<div class="form-group duplicate_field">
					<input required type="text" class="form-control" maxlength="64" name="journey_name" placeholder="Enter Journey Name" />
					<span class="helpText">(No two Journeys can have the same name)</span>
				</div>
				<div class="btn-footer">
				  <button type="reset" class="btn btn-grey" data-dismiss="modal">Cancel</button>
				  <button type="submit" class="btn btn-green modal-submit-yes">Save</button>
				</div>
				</form>
		  </div>
		  <!-- /.modal-content -->
		</div>
		<!-- /.modal-dialog -->
	</div>
</div>

<!-- Assignee list view modal -->
<div id="allAssigneesModal" class="modal modal600 fade" role="dialog"  data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog modal-dialog-centered ">
		<!-- Modal content-->
		<div class="modal-content text-left">
			<div class="modal-header">
				<button type="reset" class="btn-close" title="Close" data-dismiss="modal">x</button>
				<h2 id="allAssigneeModalTitle">All Assignees</h2>
			</div>
			<div class="modal-body pt-3">
				<div class="allAssigneesTable mb-4" id="allAssigneesTableScroll">
				</div>
			</div>
		</div>
	</div>
</div>

@if(request()->is('groups*'))
<!-- Add new admin add modal -->
<div id="groupAssignNewAdminModal" class="modal modal600 fade" role="dialog"  data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog modal-dialog-centered">
		<!-- Modal content-->
		<div class="modal-content text-left">
			{!! Form::open([ 'route' => 'groups.new_admin', 'enctype' => 'multipart/form-data', 'class' => 'ajax-form clearfix', 'id'=>'assignAdminModalForm' ]) !!}
			<input type="hidden" id="groupAssignAdminGroupId" name="group_id">
			<input type="hidden" id="groupAssignAdminId" name="admin_id">
			<input type="hidden" id="assignGroupName" name="name">
			<div class="modal-header">
				<button type="reset" class="btn-close" title="Close" data-dismiss="modal">x</button>
				<h2>Assign New Admin</h2> 
			</div>
			<div class="modal-body">
				<div class="assignAdmin_user">
					<div class="form-group"> 
						<h4>Please select a new admin to replace <span id="groupAssignAdminName"></span></h4>
						<label for="inputAdminName">{{ __('User') }} <span class="required">*</span></label>
						<select name="user_id" class="select2 form-control" id="inputAdminName">
						</select>
					</div>
				</div>
				<div class="btn-footer pb-0">
					<button type="reset" class="btn-grey btn assignAdminCancelBtn" data-dismiss="modal">Cancel</button>
					<button type="submit" id="assignAdminSaveBtn" class="btn-green btn">Assign</button>
				</div>
			</div>
			{{ Form::close() }}
		</div>
	</div>
</div>
@endif

@if(request()->is('passport*'))
<div class="modal modal600 modal-danger fade" id="copyLinkModal" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header">	
				<h2>Get Link</h2>
				<button type="reset" class="btn-close" title="Close" data-dismiss="modal">x</button>
			</div>
			<div class="modal-body">
				<div class="white-box"> 
					<div class="white-content pt-0">
						<div class="inner-content form-all-input px-0">
							<h4>Are you sure  <span> you want to get this link?</span></h4>
							<div class="form-group mt-3 m-0">
								<input class="form-control" id="copyLinkInputField" readonly type="text" value="<div>Icons  <a href='https://www.flaticon.com/authors/those-icons' </div>"  />
							</div>
						</div>
					</div>
				</div>
				<div class="btn-footer mt-4">
					  <button type="button" id="copyLinkSubmit" onclick="copyLinkFunction()" class="btn btn-green" >Copy Link </button>
				</div>
			</div>
		</div>
	</div>
</div>
@endif
