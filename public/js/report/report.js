var activeDataTable;
var listTabReset = false;
var approvalReportListManagementTable,groupReportMangementTable,currentUserReportManagementTable,userActivityManagementTable,tempcheckReportListTable;

var filterByAssignedBy, filterByCompletedDate, filterByCreatedDate, filterByJourneyId, filterByMilestoneCount, filterByReadOption, filterByCreatedBy, filterByTotalAssignee, filterByActiveAssignee, filterByAssignedTo, filterByGroupId, filterByAssignedType, filterByFirstName, filterByLastName, filterByLastLoginDate, filterByPoint,filterByMilestoneCompletedCount,filterByTotalJourneyCount,filterByJourneyCompletedCount,filterByDesignation,
filterByPhoneNumber,filterByEmailId,filterByRole,filterByUserGrade,filterByMemberCount,filterByJourneyCount,filterByAdminCount,filterByMilestoneType,filterByRequestBy,filterByRequestFor,filterByStatusOption,filterByMilestoneId,filterByPrice,filterByApproverName,filterByRating,filterByQuestion,filterAssignedBy,filterByAssignee;

$(function(){
	activeDataTable = "userActivity";
	triggerActiveDataTable();
})

//function set active tab datatable list
function reportMainTapChange(active_list){
   if(activeDataTable !== active_list){
	   activeDataTable = active_list;
	   listTabReset = true;
	   resetDataTableFilter();
	   triggerActiveDataTable();	
   }	  
}

//function Initial/draw active tab datatable
function triggerActiveDataTable(){
	if(activeDataTable == 'approvalReport'){
		approvalReportListManagement()
	}else if(activeDataTable == 'groupReport'){
		groupReportMangementList()
	}else if(activeDataTable == 'currentUserReport'){
		currentUserReportManagementList()
	}else if(activeDataTable == 'userActivity'){
		userActivityManagementList()
	}else if(activeDataTable == 'tempcheckReport'){
		tempcheckReportManagementList()
	}
}

//function to filter by journey 
$(document).on('change','.filterByJourneyId',function(){
	filterByJourneyId = $(this).val();
	if(filterByJourneyId != "" || !listTabReset)
	triggerActiveDataTable();
})

//function to filter by milestone count 
$(document).on('change','.filterByMilestoneCount',function(){
	filterByMilestoneCount = $(this).val();
	if(filterByMilestoneCount != "" || !listTabReset)
	triggerActiveDataTable();
})

//function to filter by assigned by
$(document).on('change','.filterByAssignedBy',function(){
	filterByAssignedBy = $(this).val();
	if(filterByAssignedBy != "" || !listTabReset)
	triggerActiveDataTable();
})

//function to filter by created by
$(document).on('change','.filterByCreatedBy',function(){
	filterByCreatedBy = $(this).val();
	if(filterByCreatedBy != "" || !listTabReset)
	triggerActiveDataTable();
})

//function to filter by created by
$(document).on('change','.filterByTotalAssignee',function(){
	filterByTotalAssignee = $(this).val();
	if(filterByTotalAssignee != "" || !listTabReset)
	triggerActiveDataTable();
})

//function to filter by created by
$(document).on('change','.filterByActiveAssignee',function(){
	filterByActiveAssignee = $(this).val();
	if(filterByActiveAssignee != "" || !listTabReset)
	triggerActiveDataTable();
})

//function to filter by assigned to
$(document).on('change','.filterByAssignedTo',function(){
	filterByAssignedTo = $(this).val();
	if(filterByAssignedTo != "" || !listTabReset)
	triggerActiveDataTable();
})

//function to filter by group
$(document).on('change','.filterByGroupId',function(){
	filterByGroupId = $(this).val();
	if(filterByGroupId != "" || !listTabReset)
	triggerActiveDataTable();
})

//function to filter by group
$(document).on('change','.filterByAssignedType',function(){
	filterByAssignedType = $(this).val();
	if(filterByAssignedType != "" || !listTabReset)
	triggerActiveDataTable();
})

//function to filter by first name
$(document).on('change','.filterByFirstName',function(){
	filterByFirstName = $(this).val();
	if(filterByFirstName != "" || !listTabReset)
	triggerActiveDataTable();
})

//function to filter by last name
$(document).on('change','.filterByLastName',function(){
	filterByLastName = $(this).val();
	if(filterByLastName != "" || !listTabReset)
	triggerActiveDataTable();
})

//function to filter by last login date
$(document).on('change','.filterByLastLoginDate',function(){
	filterByLastLoginDate = $(this).val();
	if(filterByLastLoginDate != "" || !listTabReset)
	triggerActiveDataTable();
})

//function to filter by phone number
$(document).on('change','.filterByPhoneNumber',function(){
	filterByPhoneNumber = $(this).val();
	if(filterByPhoneNumber != "" || !listTabReset)
	triggerActiveDataTable();
})

//function to filter by Email id
$(document).on('change','.filterByEmailId',function(){
	filterByEmailId = $(this).val();
	if(filterByEmailId != "" || !listTabReset)
	triggerActiveDataTable();
})

//function to filter by Role
$(document).on('change','.filterByRole',function(){
	filterByRole = $(this).val();
	if(filterByRole != "" || !listTabReset)
	triggerActiveDataTable();
})

//function to filter by Role
$(document).on('change','.filterByUserGrade',function(){
	filterByUserGrade = $(this).val();
	if(filterByUserGrade != "" || !listTabReset)
	triggerActiveDataTable();
})

//function to filter by member_count
$(document).on('change','.filterByMemberCount',function(){
	filterByMemberCount = $(this).val();
	if(filterByMemberCount != "" || !listTabReset)
	triggerActiveDataTable();
})

//function to filter by journey count
$(document).on('change','.filterByJourneyCount',function(){
	filterByJourneyCount = $(this).val();
	if(filterByJourneyCount != "" || !listTabReset)
	triggerActiveDataTable();
}) 

//function to filter by Point
$(document).on('change','.filterByPoint',function(){
	filterByPoint = $(this).val();
	if(filterByPoint != "" || !listTabReset)
	triggerActiveDataTable();
})

//function to filter by completed milestone count
$(document).on('change','.filterByMilestoneCompletedCount',function(){
	filterByMilestoneCompletedCount = $(this).val();
	if(filterByMilestoneCompletedCount != "" || !listTabReset)
	triggerActiveDataTable();
})

//function to filter by total journey count
$(document).on('change','.filterByTotalJourneyCount',function(){
	filterByTotalJourneyCount = $(this).val();
	if(filterByTotalJourneyCount != "" || !listTabReset)
	triggerActiveDataTable();
})

//function to filter by admin count
$(document).on('change','.filterByAdminCount',function(){
	filterByAdminCount = $(this).val();
	if(filterByAdminCount != "" || !listTabReset)
	triggerActiveDataTable();
})

//function to filter by milestone type
$(document).on('change','.filterByMilestoneType',function(){
	filterByMilestoneType = $(this).val();
	if(filterByMilestoneType != "" || !listTabReset)
	triggerActiveDataTable();
})

//function to filter by price
$(document).on('change','.filterByPrice',function(){
	filterByPrice = $(this).val();
	if(filterByPrice != "" || !listTabReset)
	triggerActiveDataTable();
})

//function to filter by Approver
$(document).on('change','.filterByApproverName',function(){
	filterByApproverName = $(this).val();
	if(filterByApproverName != "" || !listTabReset)
	triggerActiveDataTable();
})

//function to filter by Ration
$(document).on('change','.filterByRating',function(){
	filterByRating = $(this).val();
	if(filterByRating != "" || !listTabReset)
	triggerActiveDataTable();
})

//function to filter by Question
$(document).on('change','.filterByQuestion',function(){
	filterByQuestion = $(this).val();
	if(filterByQuestion != "" || !listTabReset)
	triggerActiveDataTable();
})

//function to filter by Assigned by
$(document).on('change','.filterAssignedBy',function(){
	filterAssignedBy = $(this).val();
	if(filterAssignedBy != "" || !listTabReset)
	triggerActiveDataTable();
})

//function to filter by Assignee
$(document).on('change','.filterByAssignee',function(){
	filterByAssignee = $(this).val();
	if(filterByAssignee != "" || !listTabReset)
	triggerActiveDataTable();
})

//function to filter by request by
$(document).on('change','.filterByRequestBy',function(){
	filterByRequestBy = $(this).val();
	if(filterByRequestBy != "" || !listTabReset)
	triggerActiveDataTable();
})

//function to filter by request for
$(document).on('change','.filterByRequestFor',function(){
	filterByRequestFor = $(this).val();
	if(filterByRequestFor != "" || !listTabReset)
	triggerActiveDataTable();
})

//function to filter by milestone
$(document).on('change','.filterByMilestoneId',function(){
	filterByMilestoneId = $(this).val();
	if(filterByMilestoneId != "" || !listTabReset)
	triggerActiveDataTable();
})

//function to filter by request by
$(document).on('change','.filterByStatusOption',function(){
	filterByStatusOption = $(this).val();
	if(filterByStatusOption != "" || !listTabReset)
	triggerActiveDataTable();
})

//function to filter by completed journey count
$(document).on('change','.filterByJourneyCompletedCount',function(){
	filterByJourneyCompletedCount = $(this).val();
	if(filterByJourneyCompletedCount != "" || !listTabReset)
	triggerActiveDataTable();
})

//function to filter by designation
$(document).on('change','.filterByDesignation',function(){
	filterByDesignation = $(this).val();
	if(filterByDesignation != "" || !listTabReset)
	triggerActiveDataTable();
})

//function to filter by created date 
$(document).on('change','.filterByCreatedDate',function(){
	filterByCreatedDate = $(this).val();	
	if(filterByCreatedDate != "" || !listTabReset)
	triggerActiveDataTable();
})

//function to filter by complete date 
$(document).on('change','.filterByCompletedDate',function(){
	filterByCompletedDate = $(this).val();
	if(filterByCompletedDate != "" || !listTabReset)
	triggerActiveDataTable();
})

//function to filter by read option
$(document).on('change','.filterByReadOption',function(){
	filterByReadOption = $(this).val();	
	if(filterByReadOption != "" || !listTabReset)
	triggerActiveDataTable();
})

$(document).ready(function(){
	if($('.journey_content .white-box').length > 0){
		breakdownpage_width = $('.journey_content .white-box').width(); 
	}
	//Remove milestone count dropdown duplicates
	removeDuplicateOption('#mylearning .filterByMilestoneCount');
	removeDuplicateOption('.filterByTotalJourneyCount')
	removeDuplicateOption('.filterByJourneyCompletedCount');
	removeDuplicateOption('#approvalReport .filterByMilestoneId');
});

function removeDuplicateOption(target){
	var code = {};
	$(target+ " > option").each(function () {
		if(code[this.text]) {
			$(this).remove();
		} else {
			code[this.text] = this.value;
		}
	});
}


$(document).on('submit','form',function(e){
	//return false;
    if($(this).hasClass('ajax-form')){
    e.preventDefault()
    let url = $(this).attr('action');
    let target = ('#'+$(this).attr('id') == '#undefined') ? 'body' : '#'+$(this).attr('id');
    $.easyAjax({
        url: url,
        container: target,
        type: "POST",
        redirect: true,
		disableButton: true,
        file: false,
        data: $(this).serialize(),
        messagePosition:'toastr',
    }, function(response){
       if(response.status){ 
		   
	   }else{
		  showMessage(response.message, "error", "toastr");
	   }	   
    });
  }
});

$( function() {
  $(".datepicker").datepicker({
	   dateFormat: 'M d, yy',
	   minDate: new Date()
  });
});

if($('#end_date').length > 0){
	$('#end_date').on('change', function(evt){
		$(this).valid();
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
	//console.log(value); 
});

$('.comiseo-daterangepicker-buttonpanel button').on('click', function() {
	var btnTxt = $(this).text();
	if(btnTxt =='Clear'){
		triggerActiveDataTable();
	}
});

function resetDataTableFilter(){
	filterByAssignedBy = filterByCompletedDate = filterByCreatedDate = filterByJourneyId = filterByMilestoneCount = filterByReadOption = filterByCreatedBy = filterByTotalAssignee = filterByActiveAssignee = filterByAssignedTo = filterByGroupId = filterByAssignedType = "";
	$('.filterByJourneyId').prop('selectedIndex',0).trigger('change').val("");
	$('.filterByMilestoneCount').prop('selectedIndex',0).trigger('change').val("");
	$('.filterByAssignedBy').prop('selectedIndex',0).trigger('change').val("");
	$('.filterByCreatedBy').prop('selectedIndex',0).trigger('change').val("");
	$('.filterByTotalAssignee').prop('selectedIndex',0).trigger('change').val("");
	$('.filterByActiveAssignee').prop('selectedIndex',0).trigger('change').val("");
	$('.filterByAssignedTo').prop('selectedIndex',0).trigger('change').val("");
	$('.filterByReadOption').prop('selectedIndex',0).trigger('change').val("");
	$('.filterByGroupId').prop('selectedIndex',0).trigger('change').val("");
	$('.filterByAssignedType').prop('selectedIndex',0).trigger('change').val("");
	$('.filterByCreatedDate').val("");
	$('.filterByCompletedDate').val("");
	$(".daterangepicker").daterangepicker("clearRange");
	listTabReset = false;
}

function approvalReportListManagement(){
	
	if(typeof approvalReportListManagementTable != "undefined" && approvalReportListManagementTable != ""){
		approvalReportListManagementTable.draw();
		return true;
	} 
	
	approvalReportListManagementTable = $('#approvalReportList').DataTable({
		"processing": true,
		"dom": '<"top">rt<"bottom"ilp><"clear">',
		"lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
		"serverSide": true,
		"scrollX": false,
		"searching": true,
		"ajax": {
			"url": APP_URL+"reports/approval_list",
			"data": function ( d ) {
				d.table_name 		= "approvalReportList";
				d.requested_by 		= filterByRequestBy;
				d.requested_for 	= filterByRequestFor;
				d.status	 		= filterByStatusOption;
				d.journey_name 		= filterByJourneyId;
				d.milestone_name 	= filterByMilestoneId;
				d.milestone_type_id	= filterByMilestoneType;
				d.price				= filterByPrice;
				d.approver_id		= filterByApproverName;
			},
		},
		"columns": [
			{data: 'approver_name', name: 'approver_name'},
			{data: 'journey_name', name: 'journey_name'},
			{data: 'title', name: 'title'},
			{data: 'content_type', name: 'content_type'},
			{data: 'requested_for', name: 'requested_for'},
			{data: 'requested_by', name: 'requested_by'},
			{data: 'price', name: 'price'},
			{data: 'status', name: 'status'}
		],
		"createdRow": function ( row, data, index ) {			
			//$('td', row).eq(0).html("<span class='maxname'>" + $('<div/>').html(data['journey_name']).text() + "</span>");
		},		
		"columnDefs": [
		],
		language: {
			search: "_INPUT_",
			searchPlaceholder: "Search...",
			sInfo: "Showing _START_ to _END_ of _TOTAL_",
			sInfoEmpty: "Showing 0 to _END_ of _TOTAL_",
			lengthMenu: "Show _MENU_",
			"paginate": {
			  "previous": "Prev."
			}
		}
	});
}

function groupReportMangementList(){	

	if(typeof groupReportMangementTable != "undefined" && groupReportMangementTable != ""){
		groupReportMangementTable.draw();
		return true;
	}	
	
	groupReportMangementTable = $('#groupReportList').DataTable({
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
			"url": APP_URL+"reports/group_report_list",
			"data": function ( d ) {
				d.created_by 		= filterByCreatedBy;
				d.created_date 		= filterByCreatedDate;
				d.group_id 			= filterByGroupId;
				d.member_count 		= filterByMemberCount;
				d.admin_count 		= filterByAdminCount;
				d.milestone_count 	= filterByMilestoneCount;
				d.journey_count 	= filterByJourneyCount;
			},
		},
		"columns": [
			{data: 'group_name', name: 'group_name'},
			{data: 'member_count', name: 'member_count'},
			{data: 'admin_count', name: 'admin_count'},
			{data: 'created_by', name: 'created_by'},
			{data: 'created_at', name: 'created_at'},
			{data: 'journey_count', name: 'journey_count'},
			{data: 'milestone_count', name: 'milestone_count'},
		],
		"createdRow": function ( row, data, index ) {			
			$('td', row).eq(3).html($('<div/>').html(data['created_by']).text() );			
		},		
		"order": [[ 0, 'asc' ]],
		"columnDefs": [	
		],
		language: {
			search: "_INPUT_",
			searchPlaceholder: "Search...",
			sInfo: "Showing _START_ to _END_ of _TOTAL_",
			sInfoEmpty: "Showing 0 to _END_ of _TOTAL_",
			lengthMenu: "Show _MENU_",
			"paginate": {
			  "previous": "Prev."
			}
		}
	});
}

function currentUserReportManagementList(){	

	if(typeof currentUserReportManagementTable != "undefined" && currentUserReportManagementTable != ""){
		currentUserReportManagementTable.draw();
		return true;
	}	
	
	currentUserReportManagementTable = $('#currentUserReportList').DataTable({
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
			"url": APP_URL+"reports/current_user_report",
			"data": function ( d ) {
				d.first_name 		= filterByFirstName;
				d.last_name 		= filterByLastName;
				d.designation 		= filterByDesignation;
				d.mobile 			= filterByPhoneNumber;
				d.email 			= filterByEmailId;
				d.role 				= filterByRole;
				d.grade_id 			= filterByUserGrade;			
			},
		},
		"columns": [
			{data: 'first_name', name: 'first_name'},
			{data: 'last_name', name: 'last_name'},
			{data: 'mobile', name: 'mobile'},
			{data: 'email', name: 'email'},
			{data: 'designation', name: 'designation'},
			{data: 'role', name: 'role'},
			{data: 'grade', name: 'grade'}
		],		
		"createdRow": function ( row, data, index ) {
			$('td', row).eq(6).html($('<div/>').html(data['grade']).text() );	
		},
		"order": [[ 0, 'asc' ]],
		"columnDefs": [	
		],
		language: {
			search: "_INPUT_",
			searchPlaceholder: "Search...",
			sInfo: "Showing _START_ to _END_ of _TOTAL_",
			sInfoEmpty: "Showing 0 to _END_ of _TOTAL_",
			lengthMenu: "Show _MENU_",
			"paginate": {
			  "previous": "Prev."
			}
		}
	});
}


function userActivityManagementList(){	

	if(typeof userActivityManagementTable != "undefined" && userActivityManagementTable != ""){
		userActivityManagementTable.draw();
		return true;
	}	
	
	userActivityManagementTable = $('#userActivityList').DataTable({
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
			"url": APP_URL+"reports/user_activity_report",
			"data": function ( d ) {				
				d.first_name 				= filterByFirstName;
				d.last_name 				= filterByLastName;
				d.points_earned 			= filterByPoint;
				d.completed_milestone_count = filterByMilestoneCompletedCount;
				d.total_journey_count	 	= filterByTotalJourneyCount;
				d.completed_journey_count 	= filterByJourneyCompletedCount;
				d.last_login_at 			= filterByLastLoginDate;
			},
		},
		"columns": [
			{data: 'first_name', name: 'first_name'},
			{data: 'last_name', name: 'last_name'},
			{data: 'last_login', name: 'last_login'},
			{data: 'points_earned', name: 'points_earned'},
			{data: 'completed_milestone_count', name: 'completed_milestone_count'},
			{data: 'total_journey_count', name: 'total_journey_count'},
			{data: 'completed_journey_count', name: 'completed_journey_count'},
		],		
		"createdRow": function ( row, data, index ) {
			//$('td', row).eq(0).html($('<div/>').html(data['profile_picture']).text());
		},
		"order": [[ 1, 'asc' ]],
		"columnDefs": [	
			{ className: "text-center", "targets": [ 3,4 ] },
			{ className: "text-center", "targets": [ 5,6 ] }
		],
		language: {
			search: "_INPUT_",
			searchPlaceholder: "Search...",
			sInfo: "Showing _START_ to _END_ of _TOTAL_",
			sInfoEmpty: "Showing 0 to _END_ of _TOTAL_",
			lengthMenu: "Show _MENU_",
			"paginate": {
			  "previous": "Prev."
			}
		}
	});
}

function tempcheckReportManagementList(){
	
	if(typeof tempcheckReportListTable != "undefined" && tempcheckReportListTable != ""){
		tempcheckReportListTable.draw();
		return true;
	} 

	tempcheckReportListTable = $('#tempcheckReportList').DataTable({
		"processing": true,
		"dom": '<"top">rt<"bottom"ilp><"clear">',
		"lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
		"serverSide": true,
		"searching": true,
		"ajax": {
			"url": APP_URL+"reports/tempcheck_report_list",
			"data": function ( d ) {
				d.table_name 		= "tempcheckReportList";
				d.user_id 			= filterByAssignee;
				d.created_by		= filterAssignedBy;
				d.rating			= filterByRating;
				d.question			= filterByQuestion;
			},
		},
		"columns": [
			{data: 'assigned_by', name: 'assigned_by'},
			{data: 'assignee', name: 'assignee'},
			{data: 'rating', name: 'rating'},
			{data: 'question', name: 'question'}
		],
		"columnDefs": [
			{ className: "text-center",  "targets": [ 3 ] }
		],
		language: {
			search: "_INPUT_",
			searchPlaceholder: "Search...",
			sInfo: "Showing  _END_ of _TOTAL_",
			lengthMenu: "Show _MENU_"
		}
	});	
}

$(document).on('keyup change','#dataTableSearch', function () {
	if(activeDataTable == 'approvalReport'){
		approvalReportListManagementTable.search($(this).val()).draw();
	}else if(activeDataTable == 'groupReport'){
		groupReportMangementTable.search($(this).val()).draw();
	}else if(activeDataTable == 'currentUserReport'){
		currentUserReportManagementTable.search($(this).val()).draw();
	}else if(activeDataTable == 'userActivity'){
		userActivityManagementTable.search($(this).val()).draw();
	}else if(activeDataTable == 'tempcheckReport'){
		tempcheckReportListTable.search($(this).val()).draw();
	}
});