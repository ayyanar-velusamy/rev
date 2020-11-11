var Table;  


function enquiryTable(){  
		
	$.fn.dataTable.ext.errMode = 'none';

	Table = $('#enquiryList').DataTable({ 
		"processing": true,
		"dom": '<"top">rt<"bottom"ilp><"clear">',
		"serverSide": true,
		"scrollX": false,
		"searching": true,
		"ajax": APP_URL+"/enquiry_list",
		"error": function(response) {
			console.log(response)
		},
		"columns": [			
			{data: 'name', name: 'name'}, 
			{data: 'email', name: 'email'}, 
			{data: 'phone', name: 'phone'},
			{data: 'comment', name: 'comment', orderable: false, searchable: false},
		],
		"order": [],
		"createdRow": function ( row, data, index ) {
		    $('td', row).eq(3).html("<span class='maxname'>" + data['comment'] + "</span>");  
		},
		"columnDefs": [ 
			{ className: "", "orderable": false, "targets": [ 3 ] }
		],
		"lengthMenu": [[10, 25, 50,100 , -1], [10, 25, 50, 100, "All"]],
		language: {
			search: "_INPUT_",
			searchPlaceholder: "Search...",
			sInfo: "Showing _START_ to _END_ of _TOTAL_",
			lengthMenu: "Show _MENU_",
			"paginate": {
			  "previous": "Prev."
			}
		} 
	});
}

$(document).on('keyup change','#dataTableSearch', function () {
    Table.search($(this).val()).draw();
}); 
 