var peerManagementTable;
var peerManagementGroupTable;
var filterByFirstName,filterByLastName,filterByDesignation,filterByPoint,filterByCount;

//function to filter by group id
$(document).on('change','.filterByFirstName',function(){
	filterByFirstName = $(this).val();
	peerManagementList();	
})

//function to filter by group id
$(document).on('change','.filterByLastName',function(){
	filterByLastName = $(this).val();
	peerManagementList();	
})

//function to filter by group id
$(document).on('change','.filterByDesignation',function(){
	filterByDesignation = $(this).val();
	peerManagementList();	
})

//function to filter by group id
$(document).on('change','.filterByPoint',function(){
	filterByPoint = $(this).val();
	peerManagementList();	
})

//function to filter by group id
$(document).on('change','.filterByCount',function(){
	filterByCount = $(this).val();
	peerManagementList();	
})

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

function peerManagementList(){	

	if(typeof peerManagementTable != "undefined" && peerManagementTable != ""){
		peerManagementTable.draw();
		return true;
	}	
	
	peerManagementTable = $('#peersList').DataTable({
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
			"url": APP_URL+"peers/peer_list",
			"data": function ( d ) {
				d.first_name 		= filterByFirstName;
				d.last_name 		= filterByLastName;
				d.designation 		= filterByDesignation;
				d.points_earned 	= filterByPoint;
				d.completed_milestone_count 		= filterByCount;				
			},
		},
		"columns": [
			{data: 'profile_picture', name: 'profile_picture'},
			{data: 'first_name', name: 'first_name'},
			{data: 'last_name', name: 'last_name'},
			{data: 'designation', name: 'designation'},
			{data: 'points_earned', name: 'points_earned'},
			{data: 'completed_milestone_count', name: 'completed_milestone_count'},
			{data: 'action'}
		],		
		"createdRow": function ( row, data, index ) {
			$('td', row).eq(0).html($('<div/>').html(data['profile_picture']).text());
		},
		"order": [[ 1, 'asc' ]],
		"columnDefs": [		
			{ className: "actions action_btn", "orderable": false, "width": "15%", "targets": [ 6 ] },
			{ className: "text-center", "orderable": false, "targets": [ 0 ] },
			{ className: "text-center", "targets": [ 4 ] },
			{ className: "text-center", "targets": [ 5 ] }
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


