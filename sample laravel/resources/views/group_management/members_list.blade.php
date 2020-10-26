<div class="comn_dataTable">
	<div class="title_nd_btn">
		<div class="top_left mb-2">
			<h3>Group Members List</h3>
		</div>
		<div class="top_right top_right_btn">
		  @if(GetActionMethodName() != 'show')
			  @php($g_id = ($group) ? $group->id : '')
			  @if(is_admin() || is_group_admin($g_id))
			  <a id="addGroupModalBtn" href=""  title="{{ __('Add Members')}}" data-toggle="modal" onclick="addMember('{{encode_url($g_id)}}')"  class="new-user btn btn-green pull-right"><i class="icon-plus"></i> {{ __('Add Members')}}</a> 
			  @endif
		  @endif
		</div>
	</div>
<!-- general form elements -->
	<div class="box box-primary">
		<div class="table-responsive">
			<table width="100%" id="groupMembersList" class="table">
			  <thead>
			  <tr>
				<th class="member_name text-center">Name</th>
				<th>Email ID</th>
				<th>Designation</th>
				<th class="totalCompl_milestone text-center">Total Number of <span>Milestones Completed</span></th>
				<th>Action</th>
			  </tr>
			  </thead>
			</table>
		</div>
	</div>
</div>

<!-- Member add modal -->
<div id="groupMemberAddModal" class="modal modal540 fade" role="dialog"  data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog modal-dialog-centered">
		<!-- Modal content-->
		<div class="modal-content text-left">
			{!! Form::open([ 'route' => 'groups.add_member', 'enctype' => 'multipart/form-data', 'class' => 'ajax-form clearfix', 'id'=>'memberModalForm' ]) !!}
			@php($g_id = ($group) ? encode_url($group->id) : '')
			<input type="hidden" id="groupId" name="group_id" value="{{$g_id}}">
			<input type="hidden" id="memberId" name="member_id">
			<div class="modal-header">
				<button type="reset" class="btn-close" title="Close" data-dismiss="modal">x</button>
				<h2>Add Members</h2>
			</div>
			<div class="modal-body pl-5 pr-5">
			
				<div class="groupAddMultipleUser addMultipleUser">
					<div class="form-group arrow_black">
						<div class="adduser_field">
							<label for="inputUserName">{{ __('User') }} <span class="required">*</span></label>
							<select class="form-control select2" id="inputUserName" name="inputMemberAdd"></select>
							<span class="error adduser-error " style="display:none;"></span>
						</div>
						<div class="adduser_btn">
							<button type="button" id="addUserBtn" class="btn btn-blue" >{{ __('Add User')}}</button>
						</div>
					</div>
					<div id="inputMemberList" class="addMulUserscroll" >
						<ul class="addMulUserList mb-0"></ul>
					</div>
					<span id="member_id-error" class="error userempty-error" style="display:none;"></span>
				</div>

				<!--<div class="row">
					<div class="col-md-12">
						<div class="row">
							<div class="form-group col-md-8 pl-0">
								<label for="inputUserName">{{ __('User') }} <span class="required">*</span></label>
								
							</div>
							<div class="form-group col-md-4  pr-0">
								<button type="button" id="addUserBtn" title="{{ __('Add User')}}"  class="btn-green btn">{{ __('Add User')}}</button>
							</div>
						</div>
					</div>
					<div class="col-md-12">
						<div class="form-group">
							<div class="form-control" id="inputMemberList" >
								<ul>
								</ul>
							</div>
						</div>
					</div>
				</div>-->
				<div class="btn-footer">
					<button type="reset" class="btn-grey btn memberCancelBtn" data-dismiss="modal">Cancel</button>
					<button type="submit" id="memberSaveBtn" class="btn-green btn " id="importehrsub">Save</button>
				</div>
			</div>
			{{ Form::close() }}
		</div>
	</div>
</div>
