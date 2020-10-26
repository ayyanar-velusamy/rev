var groupMangementTable, groupMemberTable, groupJourneyTable, activeGroupId;
var groupMembers = [];
var groupNewMembers = [];
var filterByCreatedBy,filterByCreatedDate,filterByGroupId,filterByAdminId,filterByMemberCount,filterByJourneyCount;

//function to filter by group id
$(document).on('change','.filterByGroupId',function(){
	filterByGroupId = $(this).val();
	groupManagementList();	
})

//function to filter by admin id
$(document).on('change','.filterByAdminId',function(){
	filterByAdminId = $(this).val();
	groupManagementList();	
})

//function to filter by member count
$(document).on('change','.filterByMemberCount',function(){
	filterByMemberCount = $(this).val();
	groupManagementList();	
})

//function to filter by journey count
$(document).on('change','.filterByJourneyCount',function(){
	filterByJourneyCount = $(this).val();
	groupManagementList();	
})

//function to filter by created by
$(document).on('change','.filterByCreatedBy',function(){
	filterByCreatedBy = $(this).val();
	groupManagementList();	
})

//function to filter by created date 
$(document).on('change','.filterByCreatedDate',function(){
	filterByCreatedDate = $(this).val();
	groupManagementList();
})
$(document).ready(function() {
	groupManagementList();	
});

function setActiveGroupId(id){
    activeGroupId = id;
	$('#groupId').val(id);
	$('#groupPrimaryId').val(id);
	$('#groupAssignAdminGroupId').val(id);
	$('#addGroupModalBtn').attr('onclick',"addMember('"+id+"')");
}


function addMember(group_id){
	groupNewMembers = [];
	setActiveGroupId(group_id);	
	if(group_id == ""){
		if($('#GroupFormSubmitBtn').length > 0){
			$('#GroupFormSubmitBtn').submit();
		}
		return false;
	}	
	get_user_list();
	$('#groupMemberAddModal').modal('show');
}

function get_user_list(){
	lxp_submit_loader(true);
	sendGetRequest(APP_URL+'/groups/member_list/'+activeGroupId, function (response) {
        if(response.status) {
            //showMessage(response.message, "success", "toastr");
			setUserDropdownList(response.data);
        }
		lxp_submit_loader(false);
    });	
}

function setUserDropdownList(data){
	if(data.users_list != "" && data.users_list != null){
		$('#inputUserName').html('');
		$('#inputUserName').append('<option value="">Select User</option>');
		$.each(data.users_list,function(kay,user){
			$('#inputUserName').append('<option value="'+ user.id +'">'+ user.first_name +' '+user.last_name+'</option>');
		}); 
	}

	if(data.members_list != "" && data.members_list != null){
		$('#inputMemberList ul').html('');
		$('#inputAdminName').html('');
		$('#inputAdminName').append('<option value="">Select User</option>');
		$.each(data.members_list,function(kay,member){
			
			if($('#groupAssignAdminId').val() != member.user_id){
				$('#inputAdminName').append('<option value="' + member.user_id + '">' + member.user_name + '</option>');
			}
			
			//$('#inputMemberList ul').append(`<li>${member.user_name} <span id="" class="close_icon"><i class=" icon-close-button"></i></span></li>`);
			groupMembers.push({'id':member.user_id,'name':member.user_name,'rand':''});
		}); 
	}
}

$(document).on('click','#addUserBtn',function(e){
	if($('#inputUserName').val() != ""){
		var id = $('#inputUserName').val()
		if(!memberExist(id)){
			var name = $("#inputUserName option:selected").html();
			var rand = Math.floor(1000 + Math.random() * 9000);
			$('#inputMemberList ul').append('<li id="' + rand + '">' + name + '<span id="' + rand + '" title="Remove" class="close_icon"><i class=" icon-close-button"></i></span></li>');
			groupNewMembers.push({'id':id,'name':name,'rand':rand});
		}else{
			showMessage('User already added', "error", "toastr");
		}
		$('.userempty-error').hide().text(''); 
	}else{
		//alert();
		//showMessage('User Cannot be empty', "error", "toastr");
		$('.adduser-error').show().text('Please select a User');
	}
});

$(document).on('click','#memberSaveBtn',function(e){
	if ($('#inputMemberList ul li').length == 0){
		$('.userempty-error').show().text('Group Members cannot be empty');
		return false;
	}
	else {
		$('.userempty-error').hide().text('');
	}

});

if($('.addMultipleUser #inputUserName').length > 0){
	$('.addMultipleUser #inputUserName').on('change', function(evt){
		//$(this).valid();
		$('.adduser-error').hide().text('');
	});
}

$(document).on('click','.addMulUserList .close_icon',function(e){
	var target = $(this).parent();
	var rand = $(this).attr('id');
	var index = _.findIndex(groupNewMembers, function(item){
		return item.rand === parseInt(rand);
	});
	if(index != -1){
		groupNewMembers.splice(index, 1);
		target.remove();
	}
});

function memberExist(id) {
    for(var i = 0, len = groupNewMembers.length; i < len; i++) {
        if( groupNewMembers[ i ].id === id )
            return true;
    }
    return false;
}


$(document).on('submit','form',function(e){
    if($(this).hasClass('ajax-form')){
    e.preventDefault()
    let url = $(this).attr('action');
    target = ('#'+$(this).attr('id') == '#undefined') ? 'body' : '#'+$(this).attr('id');
	//Is member for then append new member id
	if($(this).attr('id') == 'memberModalForm'){
		if(groupNewMembers.length > 0){
			var memberId = [];
			$(groupNewMembers).each(function(k,v){
				memberId.push(v.id);
			});
			$('#memberId').val(memberId);
		}		
	}
    $.easyAjax({
        url: url,
        container: target,
        type: "POST",
        redirect: true,
        file: false,
		disableButton: true,
        data: $(this).serialize(),
        messagePosition:'toastr',
    }, function(response){
       if(response.status){
		    if(response.group_id){
			   setGroupUrl(response);
			   groupMemberManagement();
		    }			
			if(response.action){
				groupCallbackAction(response.action, response);
			}
				
		    if(target == '#groupPostAddForm'){
				loadGroupPost($('#group_id').val());
			}else if(target == '#groupCommentAddForm'){
				loadGroupComment(response.post_id);
			}else if(target == '#groupReplayAddForm'){
				loadGroupReplayComment(response.post_id, response.comment_id);
			}
			groupMangementTable.draw();
			
	   }else{
		  showMessage(response.message, "error", "toastr");
	   }
    });
  }
});



function groupCallbackAction(action, response){
	if(action == 'add_member'){
		$('#groupMemberAddModal').modal('hide');
		groupMemberManagement();
	}
	
	if(action == 'new_admin'){
		$('#leaveGroupBtn').hide();
		$('#groupAssignNewAdminModal').modal('hide');
		groupMemberManagement();
	}	
	
	if(action == 'update_post' || action == 'store_post'){
		resetPost();
	}
	
	if(action == 'update_comment' || action == 'store_comment'){
		resetComment();
		loadGroupComment(response.post_id);
	}	
}

function makeAsAdmin(user_id,group_id,name,group_name){
	var data = {
		_token:$('meta[name="csrf-token"]').attr('content'),
		_method:'POST',
		group_id:group_id,
		user_id:user_id,
		group_name:group_name,
		name:name,
		title:'Assign',
		content:'you want to make following user as Group Admin?'
	};
	commonConfirm(data, make_admin);
}

function make_admin(data, callback) {
    sendPostRequest(APP_URL+'groups/make_admin', data, function (response) {
        if (response.status) {
			groupMemberManagement();
            showMessage(response.message, "success", "toastr");
        }else{
			showMessage(response.message, "error", "toastr");
		}
		callback();
    });   
}

function removeMember(user_id, group_id, name, group_name){
	var data = {
		_token:$('meta[name="csrf-token"]').attr('content'),
		_method:'POST',
		group_id:group_id,
		user_id:user_id,
		group_name:group_name,
		name:name,
		title:'Remove',
		content:'you want to remove the following User?'
	};
	commonConfirm(data, remove_member);
}

function remove_member(data, callback) {
    sendPostRequest(APP_URL+'groups/remove_member', data, function (response) {
        if (response.status) {
			groupMemberManagement();
            showMessage(response.message, "success", "toastr");
        }else{
			if(response.member_id){
				$('#groupAssignAdminGroupId').val(activeGroupId)
				$('#groupAssignAdminId').val(response.member_id)
				$('#groupAssignAdminName').text(response.member_name)
				$('#assignGroupName').val(response.group_name)
				get_user_list();
				$('#groupAssignNewAdminModal').modal('show');
			}
			showMessage(response.message, "error", "toastr");
		}
		callback();
    });
}

function deleteGroup(group_id, name) {
	
	var data = {
		_token:$('meta[name="csrf-token"]').attr('content'),
		_method:'DELETE',
		group_id:group_id,
		name:name,
		title:'Delete',
		content:'you want to delete the following Group?'
	};
	commonConfirm(data, delete_group);
}

function delete_group(data, callback) {
    sendPostRequest(APP_URL+'groups/'+data.group_id, data, function (response) {
        if (response.status) {
			groupManagementList();
            showMessage(response.message, "success", "toastr");
        }else{
			showMessage(response.message, "error", "toastr");
		}
		callback();
    });
}

function leaveGroup(group_id, group_name){
	setActiveGroupId(group_id);	
	var data = {
		_token:$('meta[name="csrf-token"]').attr('content'),
		_method:'DELETE',
		group_id:group_id,
		group_name:group_name,
		title:'Leave Group',
		content:'you want to leave '+group_name+' Group? <br>You will no longer get this group\'s notifications',
	};		
	commonConfirm(data, leave_group);
}

function leave_group(data, callback) {
    sendPostRequest(APP_URL+'/groups/leave/'+data.group_id, data, function (response) {
        if (response.status) {
			$('#leaveGroupBtn').hide();
			groupMemberManagement();
            showMessage(response.message, "success", "toastr");
        }else{
			if(response.member_id){
				$('#groupAssignAdminGroupId').val(activeGroupId)
				$('#groupAssignAdminId').val(response.member_id)
				$('#groupAssignAdminName').text(response.member_name)
				$('#assignGroupName').val(response.group_name)
				get_user_list();
				$('#groupAssignNewAdminModal').modal('show');
			}
			showMessage(response.message, "error", "toastr");
		}
		callback();
    });
}

function revokeJourney(journey_id, type, type_ref_id, name) {
	
	var data = {
		_token:$('meta[name="csrf-token"]').attr('content'),
		_method:'POST',
		journey_id:journey_id,
		type:type,
		type_ref_id:type_ref_id,
		name:name,
		title:'Revoke Journey',
		content:'you want to revoke the following journey?'
	};		
	commonConfirm(data, revoke_journey);
}

function revoke_journey(data, callback) {
    sendPostRequest(APP_URL+'journeys/'+data.journey_id+'/revoke', data, function (response) {
        if (response.status) {
			groupJourneyManagement();
            showMessage(response.message, "success", "toastr");
        }else{
			showMessage(response.message, "error", "toastr");
		}
		callback();
    });
}

function groupManagementList(){	

	if(typeof groupMangementTable != "undefined" && groupMangementTable != ""){
		groupMangementTable.draw();
		return true;
	}	
	
	groupMangementTable = $('#groups-list-table').DataTable({
		"processing": true,
		"dom": '<"top">rt<"bottom"ilp><"clear">',
		"lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
		"serverSide": true,
		"scrollX": false,
		"searching": true,
		"bPaginate": true,
		"bLengthChange": true,
		"bFilter": true,
		"bInfo": true,
		"ajax": {
			"url": APP_URL+"groups/group_list",
			"data": function ( d ) {
				d.created_by 		= filterByCreatedBy;
				d.created_date 		= filterByCreatedDate;
				d.group_id 			= filterByGroupId;
				d.admin_id 			= filterByAdminId;
				d.member_count 		= filterByMemberCount;
				d.journey_count 	= filterByJourneyCount;
			},
		},
		"columns": [
			{data: 'group_name', name: 'group_name'},
			{data: 'admin_name', name: 'admin_name'},
			{data: 'created_by', name: 'created_by'},
			{data: 'created_at', name: 'created_at'},
			{data: 'user_count', name: 'user_count'},
			{data: 'journey_count', name: 'journey_count'},
			{data: 'action'},
		],
		"createdRow": function ( row, data, index ) {			
			$('td', row).eq(0).html("<span class='maxname'>" + data['group_name'] + "</span>");
			$('td', row).eq(1).html($('<div/>').html(data['admin_name']).text() );
			$('td', row).eq(2).html($('<div/>').html(data['created_by']).text() );
		},		
		"order": [[ 0, 'asc' ]],
		"columnDefs": [	
			{ className: "group_name",  "targets": [0] },
			{ className: "group_admin", "width": "20%",  "targets": [1] },
			{ className: "total_group_members", "width": "20%", "targets": [4] },
			{ className: "total_leaning_joutney", "width": "20%", "targets": [5] },
			{ className: "actions action_btn nowrap", "orderable": false,"width": "30%", "targets": [6] }
		],
		language: {
			search: "_INPUT_",
			searchPlaceholder: "Search...",
			sInfo: "Showing _START_ to _END_ of _TOTAL_",
			sInfoEmpty: "Showing 0 to _END_ of _TOTAL_",
			emptyTable: "No Groups Added",
			lengthMenu: "Show _MENU_",
			"paginate": {
			  "previous": "Prev."
			}
		}
	});
}
	
$(document).on('keyup change','#dataTableSearch', function () {
    groupMangementTable.search($(this).val()).draw();
});

function groupMemberManagement(){

	if(typeof groupMemberTable != "undefined" && groupMemberTable != ""){
		groupMemberTable.draw();
		return true;
	}

	groupMemberTable = $('#groupMembersList').DataTable({
		"processing": true,
		"dom": '<"top">rt<"bottom"ilp><"clear">',
		"lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
		"serverSide": true,
		"scrollX": false,
		"searching": true,
		"bPaginate": false,
		"bLengthChange": false,
		"bFilter": true,
		"bInfo": false,
		"ajax": {
			"url": APP_URL+"groups/get_members_list",
			"data": function ( d ) {
				d.table_name = "groupMembersList";
				d.group_id = activeGroupId;
			},
		},
		"order": [[ 0, 'asc' ]],
		"columns": [
			{data: 'member_name', name: 'member_name'},
			{data: 'email', name: 'email'},
			{data: 'designation', name: 'designation'},
			{data: 'milestone_completed_count', name: 'milestone_completed_count'},
			{data: 'action'} 
		],		
		"createdRow": function ( row, data, index ) {			
			$('td', row).eq(0).html("<span class='maxname'>" + $('<div/>').html(data['member_name']).text() + "</span>");
			$('td', row).eq(1).html("<span class='maxname'>" + data['email'] + "</span>");
			$('td', row).eq(2).html("<span class='maxname'>" + data['designation'] + "</span>");
		},
		"drawCallback": function( settings ) {
			setAdminfieldValue();
		},
		"columnDefs": [
			{ className: "member_name text-center", "targets": [ 0 ] },
			{ className: "totalCompl_milestone text-center", "targets": [ 3 ] },
			{ className: "actions action_btn nowrap", "orderable": false, "width": "38%", "targets": [ 4 ] }   
		],
		language: {
			search: "_INPUT_",
			searchPlaceholder: "Search...",
			sInfo: "Showing _START_ to _END_ of _TOTAL_",
			sInfoEmpty: "Showing 0 to _END_ of _TOTAL_",
			lengthMenu: "Show _MENU_",
			emptyTable: "No Members Added",
			"paginate": {
			  "previous": "Prev."
			}
		}
	});
}

function setAdminfieldValue(){
	if($('#inputGroupAdminName').length > 0){
		var admins = [];
		$('td .groupAdmin').each(function(){
			admins.push($(this).parents('span').text().replace('(Admin)',''));
			$('#inputGroupAdminName').val(admins.join(', '));
		});		
	}
}

function groupJourneyManagement(){

	if(typeof groupJourneyTable != "undefined" && groupJourneyTable != ""){
		groupJourneyTable.draw();
		return true;
	}

	groupJourneyTable = $('#groupJourneysList').DataTable({
		"processing": true,
		"dom": '<"top">rt<"bottom"ilp><"clear">',
		"lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
		"serverSide": true,
		"scrollX": false,
		"searching": true,
		"bPaginate": false,
		"bLengthChange": false,
		"bFilter": true,
		"bInfo": false,
		"ajax": {
			"url": APP_URL+"groups/get_journeys_list",
			"data": function ( d ) {
				d.table_name = "groupJourneysList";
				d.group_id = activeGroupId;
			},
		},
		"order": [[ 1, 'asc' ]],
		"columns": [
			{data: 'journey_name', name: 'journey_name'},
			{data: 'milestone_count', name: 'milestone_count'},
			{data: 'assigned_by', name: 'assigned_by'},
			{data: 'assigned_date', name: 'assigned_date'},
			{data: 'targeted_complete_date', name: 'targeted_complete_date'},
			{data: 'progress', name: 'progress'},
			{data: 'action'} 
		],
		"columnDefs": [
			{ className: "journey_name", "targets": [ 0 ] },
			{ className: "milestone_count", "targets": [ 1 ] },
			{ className: "created_date", "targets": [ 3 ] },
			{ className: "completed_date", "targets": [ 4 ] },
			{ className: "progressper", "targets": [ 5 ] },
			{ className: "actions action_btn", "orderable": false,"width":"25%", "targets": [ 6 ] }
		],
		language: {
			search: "_INPUT_",
			searchPlaceholder: "Search...",
			sInfo: "Showing _START_ to _END_ of _TOTAL_",
			sInfoEmpty: "Showing 0 to _END_ of _TOTAL_",
			lengthMenu: "Show _MENU_",
			emptyTable: "No Journeys Added",
			"paginate": {
			  "previous": "Prev."
			}
		}
	});
}

$(".daterangepicker").each(function(){
	var placeholder = $(this).attr('placeholder'); 

	 $(this).daterangepicker({
		 datepickerOptions : {
			 //changeMonth: true,
			// changeYear: true,
			 numberOfMonths : 2,
			 dateFormat: 'M d, yy',
			 maxDate: null
		 },
		 initialText : placeholder,
		 presetRanges: [], 
	 });
});

$('.comiseo-daterangepicker-triggerbutton').on('mouseenter', function() {
	var value = $(this).text();
	$(this).attr('title', value);
});

$('.comiseo-daterangepicker-buttonpanel button').on('click', function() {
	var btnTxt = $(this).text();
	if(btnTxt =='Clear'){
		groupManagementList();
	}
});
/* $('.sharedBoardCommntentGroup .reply a.replies_count').on('click', function() {
	$(this).parents('.sharedBoardCommntentGroup').find('.sharedBoardReplies').slideToggle();
}); */



if($('.group_content .white-content .form-group .select2.form-control').length > 0){
	$('.group_content .white-content .form-group .select2.form-control').on('change', function(evt){
		$(this).valid();
	});
}

if($('.assignAdmin_user #inputAdminName').length > 0){
	$('.assignAdmin_user #inputAdminName').on('change', function(evt){
		$(this).valid();
	});
}
if($('#inputAdminName').length > 0){
	$('#inputAdminName').select2({
	minimumResultsForSearch: -1,
	dropdownAutoWidth : true,
	width: '100%',
	}); 
}

$(document).on("click","#groupAssignNewAdminModal .btn-close, .assignAdminCancelBtn, #groupMemberAddModal .btn-close, .memberCancelBtn",function(){
	//reset browser Back Confirm Alert
	resetBackConfirmAlert();
});