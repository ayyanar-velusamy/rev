var passportManagementTable;
var passportUserId = window.location.href.substring(window.location.href.lastIndexOf('/') + 1);
var filterByCompletedDate, filterByJourneyId, filterByAssignedBy, filterByPointEarned, filterByRating;

$(function(){
	passportManagementList();
	passportDataCount();
});

//function to filter by complete date 
$(document).on('change','.filterByCompletedDate',function(){
	filterByCompletedDate = $(this).val();
	passportManagementList();
})

//function to filter by journey 
$(document).on('change','.filterByJourneyId',function(){
	filterByJourneyId = $(this).val();
	passportManagementList();
})

//function to filter by assigned by
$(document).on('change','.filterByAssignedBy',function(){
	filterByAssignedBy = $(this).val();
	passportManagementList();
})

//function to filter by points 
$(document).on('change','.filterByPointEarned',function(){
	filterByPointEarned = $(this).val();
	passportManagementList();
})

//function to filter by rating 
$(document).on('change','.filterByRating',function(){
	filterByRating = $(this).val();
	passportManagementList();
})

function passportDataCount(){
	rev_submit_loader(true);
	sendGetRequest(APP_URL+'passport/'+passportUserId+'/milestone_count', function (response) {
        if(response.status) {
			setPassportDataCount(response.data);
        }
		rev_submit_loader(false);
    });	
}
	
function setPassportDataCount(data){
	$.each(data, function(key,val){
		if(key == 'total_milestone_count'){
			$('#'+key).text(val);
		}else if(key == 'completed_milestone_count'){
			$('#'+key).text(val );			
		}else if(key == 'total_points'){
			$('#'+key).text(val);
		}else{
			$('#typeId_'+key).text(val.points);
		}		
	});
}
function passportManagementList(){	

	if(typeof passportManagementTable != "undefined" && passportManagementTable != ""){
		passportManagementTable.draw();
		return true;
	}	
	
	passportManagementTable = $('#myLearningJourneyList').DataTable({
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
			"url": APP_URL+"journeys/possport_journey_list",
			"data": function ( d ) {
				d.current_user = true;
				d.assigned_by 		= filterByAssignedBy;
				d.completed_date 	= filterByCompletedDate;
				d.journey_name 		= filterByJourneyId;
				d.points_earned		= filterByPointEarned;
				d.rating 			= filterByRating;
			},
		},
		"columns": [
			{data: 'journey_name', name: 'journey_name'},
			{data: 'assigned_name', name: 'assigned_name'},
			{data: 'completed_date', name: 'completed_date'},
			{data: 'points_earned', name: 'points_earned'},
			{data: 'ratings', name: 'ratings'},
			{data: 'progress', name: 'progress'},
			{data: 'action'}
		],		
		"createdRow": function ( row, data, index ) {			
			//$('td', row).eq(0).html("<span class='maxname'>" + data['group_name'] + "</span>");
			//$('td', row).eq(1).html($('<div/>').html(data['admin_name']).text() );
			//$('td', row).eq(2).html($('<div/>').html(data['created_by']).text() );
		},		
		"order": [[ 0, 'asc' ]],
		"columnDefs": [
			{ className: "text-center","targets": [3] },
			{ className: "text-center", "targets": [4] },
			{ className: "actions action_btn", "orderable": false, "width": "20%", "targets": [ 6 ] }
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

$(document).on('keyup change','#dataTableSearch', function () {
    passportManagementTable.search($(this).val()).draw();
});
