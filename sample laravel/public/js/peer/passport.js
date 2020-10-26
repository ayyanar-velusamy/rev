var passportManagementTable;
var passportUserId = window.location.href.substring(window.location.href.lastIndexOf('/') + 1);

$(function(){
	passportManagementList();
	passportDataCount();
	peerManagementGroupList();
});


function passportDataCount(){
	lxp_submit_loader(true);
	sendGetRequest(APP_URL+'passport/'+passportUserId+'/milestone_count', function (response) {
        if(response.status) {
			setPassportDataCount(response.data);
        }
		lxp_submit_loader(false);
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
	
	passportManagementTable = $('#peerLearningJourneyList').DataTable({
		"processing": true,
		"dom": '<"top">rt<"bottom"ilp><"clear">',
		"lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
		"serverSide": true,
		"scrollX": false,
		"searching": false,
		"bPaginate": false,
		"bLengthChange": false,
		"bFilter": false, 
		"bInfo": false,
		"paging": false,
		"ajax": {
			"url": APP_URL+"journeys/possport_journey_list",
			"data": function ( d ) {
				d.current_user_id = passportUserId;
			},
		},
		"columns": [
			{data: 'journey_name', name: 'journey_name'},
			{data: 'assigned_name', name: 'assigned_name'},
			{data: 'points_earned', name: 'points_earned'},
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
			{ className: "text-center", "targets": [ 2 ] },
			{ className: "text-center",  "targets": [ 3 ] },
			{ className: "actions action_btn", "orderable": false, "width": "20%", "targets": [ 4 ] }
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


function peerManagementGroupList(){	

	if(typeof peerManagementGroupTable != "undefined" && peerManagementGroupTable != ""){
		peerManagementGroupTable.draw();
		return true;
	}	
	
	peerManagementGroupTable = $('#peerLearningGroupList').DataTable({ 
		"processing": true,
		"dom": '<"top">rt<"bottom"ilp><"clear">',
		"lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
		"serverSide": false,
		"scrollX": false,
		"searching": false,
		"bPaginate": false,
		"bLengthChange": false,
		"bFilter": false, 
		"bInfo": false,
		"paging": false,
		"ajax": {
			"url": APP_URL+"groups/user_group_list",
			"data": function ( d ) {
				d.user_id = passportUserId;
			},
		},
		"columns": [
			{data: 'group_name', name: 'group_name'},
			{data: 'action'}
		],		
		"order": [[ 0, 'asc' ]],
		"columnDefs": [		
			{ className: "actions action_btn text-center", "orderable": false, "width": "20%", "targets": [ 1 ] },
		],
		language: {
			search: "_INPUT_",
			searchPlaceholder: "Search...",
			sInfo: "Showing _START_ to _END_ of _TOTAL_",
			sInfoEmpty: "Showing 0 to _END_ of _TOTAL_",
			//emptyTable: "No Groups Added",
			lengthMenu: "Show _MENU_",
			"paginate": {
			  "previous": "Prev."
			}
		}
	});
}