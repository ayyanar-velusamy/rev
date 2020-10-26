var tempcheckListTable, tempcheckTrendListTable,tempcheckAssignedListTable;
var filterByDueDate,filterFrequency,filterByAssignee,filterByDesignation, filterAssignedBy;
var assignList = [];


$( function() {
  $(".datepicker").datepicker({
	   dateFormat: 'M d, yy',
	   minDate: new Date()
  });
});

$(document).ready(function() {
	triggerActiveDataTable();
});

$(document).on('change','.filterFrequency',function(){
	filterFrequency = $(this).val();
	triggerActiveDataTable();
})

//function to filter by created date 
$(document).on('change','.filterByDueDate',function(){
	filterByDueDate = $(this).val();	
	triggerActiveDataTable();
})

$(document).on('change','.filterByAssignee',function(){
	filterByAssignee = $(this).val();
	console.log(filterByAssignee)
	triggerActiveDataTable();
})

$(document).on('change','.filterByDesignation',function(){
	filterByDesignation = $(this).val();	
	triggerActiveDataTable();
})

$(document).on('change','.filterAssignedBy',function(){
	filterAssignedBy = $(this).val();	
	triggerActiveDataTable();
})

function triggerActiveDataTable(){
	if($('#tempcheckList').length > 0){
		tempcheckListManagement()
	}else if($('#tempcheckTrendList').length > 0){
		tempcheckTrendListManagement()
	}else if($('#tempcheckAssignedList').length > 0){
		tempcheckAssignedListManagement()
	}
}

function tempcheckListManagement(){
	
	if(typeof tempcheckListTable != "undefined" && tempcheckListTable != ""){
		tempcheckListTable.draw();
		return true;
	} 

	tempcheckListTable = $('#tempcheckList').DataTable({ 
		"processing": true,
		"dom": '<"top">rt<"bottom"ilp><"clear">',
		"serverSide": true,
		"searching": true,
		"ajax": {
			"url": APP_URL+"tempchecks/tempcheck_list",
			"data": function ( d ) {
				d.table_name 		= "tempcheckList";
				d.frequency 		= filterFrequency;
				d.due_date 			= filterByDueDate;
			},
		},
		"columns": [
			{data: 'question', name: 'question'},
			{data: 'frequency', name: 'frequency'},
			{data: 'due_date', name: 'due_date'},
			{data: 'action'}
		],
		"columnDefs": [
			{ className: "",  "width":"45%", "targets": [ 0 ] },
			{ className: "",  "width":"12%", "targets": [ 1 ] },
			{ className: "",  "width":"12%", "targets": [ 2 ] },
			{ className: "actions action_btn", "orderable": false, "width":"25%", "targets": [ 3 ] }
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
    if($('#tempcheckList').length > 0){
		tempcheckListTable.search($(this).val()).draw();
	}else if($('#tempcheckTrendList').length > 0){
		tempcheckTrendListTable.search($(this).val()).draw();
	}else if($('#tempcheckAssignedList').length > 0){
		tempcheckAssignedListTable.search($(this).val()).draw();
	}	
});


function tempcheckTrendListManagement(){
	
	if(typeof tempcheckTrendListTable != "undefined" && tempcheckTrendListTable != ""){
		tempcheckTrendListTable.draw();
		return true;
	} 

	tempcheckTrendListTable = $('#tempcheckTrendList').DataTable({
		"processing": true,
		"dom": '<"top">rt<"bottom"ilp><"clear">',
		"lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
		"serverSide": true,
		"searching": true,
		"ajax": {
			"url": APP_URL+"tempchecks/trend_list",
			"data": function ( d ) {
				d.table_name 		= "tempcheckTrendList";
				d.user_id 			= filterByAssignee;
				d.designation		= filterByDesignation;
			},
		},
		"columns": [
			{data: 'first_name', name: 'first_name'},
			{data: 'email', name: 'email'},
			{data: 'designation', name: 'designation'},
			{data: 'rating', name: 'rating'},
			{data: 'action'}
		],
		"columnDefs": [
			{ className: "text-center",  "targets": [ 3 ] },
			{ className: "actions action_btn", "orderable": false, "targets": [ 4 ] }
		],
		language: {
			search: "_INPUT_",
			searchPlaceholder: "Search...",
			sInfo: "Showing  _END_ of _TOTAL_",
			lengthMenu: "Show _MENU_"
		}
	});	
}


function tempcheckAssignedListManagement(){
	
	if(typeof tempcheckAssignedListTable != "undefined" && tempcheckAssignedListTable != ""){
		tempcheckAssignedListTable.draw();
		return true;
	} 

	tempcheckAssignedListTable = $('#tempcheckAssignedList').DataTable({
		"processing": true,
		"dom": '<"top">rt<"bottom"ilp><"clear">',
		"lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
		"serverSide": true,
		"searching": true,
		"ajax": {
			"url": APP_URL+"tempchecks/assigned_list",
			"data": function ( d ) {
				d.table_name 		= "tempcheckAssignedList";
				d.frequency 		= filterFrequency;
				d.due_date 			= filterByDueDate;
				d.assigned_by		= filterAssignedBy;
			},
		},
		"columns": [
			{data: 'first_name', name: 'first_name'},
			{data: 'frequency', name: 'frequency'},
			{data: 'due_date', name: 'due_date'}, 
			{data: 'action'}
		],
		"columnDefs": [
			{ className: "actions action_btn", "orderable": false, "targets": [3 ] }
		],
		language: {
			search: "_INPUT_",
			searchPlaceholder: "Search...",
			sInfo: "Showing  _END_ of _TOTAL_",
			lengthMenu: "Show _MENU_"
		}
	});
}



$(document).on('submit','form',function(e){
    if($(this).hasClass('ajax-form')){
    e.preventDefault()
    let url = $(this).attr('action');
    let target = ('#'+$(this).attr('id') == '#undefined') ? 'body' : '#'+$(this).attr('id');
    if($(this).attr('id') == 'tempcheckAssignForm'){
		if(assignList.length > 0){
			var postId = [];
			$(assignList).each(function(k,v){
				postId.push(v.id);
			});
			$('#postId').val(postId);
		}		
	}	
	$.easyAjax({
        url: url,
        container: target,
        type: "POST",
        redirect: true,
        file: false,
        data: $(this).serialize(),
        messagePosition:'toastr',
    }, function(response){
       if(response.status){
			triggerActiveDataTable()
	   }else{
		  showMessage(response.message, "error", "toastr");
	   }
    });
  }
});


function deleteTempcheck(tempcheck_id,name){
	var data = {
		_token:$('meta[name="csrf-token"]').attr('content'),
		_method:'DELETE',
		tempcheck_id:tempcheck_id,
		name:name,
		title:'Delete',
		content:'you want to delete the following Tempcheck?'
	};
	commonConfirm(data, delete_tempcheck);
}

function delete_tempcheck(data, callback) {
    sendPostRequest(APP_URL+'/tempchecks/'+data.tempcheck_id, data, function (response) {
        if (response.status) {
			if(response.redirect){
				if(window.location.href != response.redirect)
				window.location.href = response.redirect;
			}
			triggerActiveDataTable()
            showMessage(response.message, "success", "toastr");
        }else{
			showMessage(response.message, "error", "toastr");
		}
    });
    callback();
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

$(document).on('click','.radioTempCheck input[type=radio]', function(){
	var radioValue = $(this).val();
	if ((radioValue == "weekly") || (radioValue == "bi-weekly")) {
		$('.frequencyDay').removeClass('d-none');
		$('#inputWeeklyName').attr('disabled',false);
		$('#inputMonthlyName').attr('disabled',true);
		$('.DateofMonth').addClass('d-none'); 
		
	} else if ((radioValue == "monthly")) {
		$('.DateofMonth').removeClass('d-none');
		$('#inputWeeklyName').attr('disabled',true);
		$('#inputMonthlyName').attr('disabled',false);
		$('.frequencyDay').addClass('d-none');
	}
});


$('#inputUserName').on('change', function(){
	var id = $('#inputUserName').val()
	if(!memberExist(assignList, id)){
		var name = $("#inputUserName option:selected").html();
		var rand = Math.floor(1000 + Math.random() * 9000);
		$('ul#addAlluserList').append('<li id="user_' + rand + '">'+ name + '<span id=" user_' + rand + ' " class="close_icon"><i class=" icon-close-button"></i></span></li>');
		assignList.push({'id':id,'name':name,'rand':'user_'+rand});
	}else{
		showMessage('User alreay added', "error", "toastr");
	}
});

$(document).on('change','#inputGroupName',function(e){
	console.log($('#inputGroupName').val())
	if($('#inputGroupName').val() != ""){
		var id = $('#inputGroupName').val()
		if(!memberExist(assignList, id)){
			var name = $("#inputGroupName option:selected").html();
			var rand = Math.floor(1000 + Math.random() * 9000);
			$('ul#addAlluserList').append('<li class="lightGrey_bg" id="' + rand + '">' + name + '<span id="group_' + rand + '" class="close_icon"><i class=" icon-close-button"></i></span></li>');
			assignList.push({'id':id,'name':name,'rand':'group_'+rand});
		}else{
			showMessage('User alreay added', "error", "toastr");
		}
		$('.userempty-error').hide().text('');
	}else{
		//alert();
		$('.adduser-error').show().text('Please select a Group');
	}
});

$(document).on('change','#inputGradeName',function(e){
	if($('#inputGradeName').val() != ""){
		var id = $('#inputGradeName').val()
		if(!memberExist(assignList, id)){
			var name = $("#inputGradeName option:selected").html();
			var rand = Math.floor(1000 + Math.random() * 9000);
			$('ul#addAlluserList').append('<li class="darkGrey_bg" id="' + rand + '">'+ name +' <span id="grade_' + rand + '" class="close_icon"><i class=" icon-close-button"></i></span></li>');
			assignList.push({'id':id,'name':name,'rand':'grade_'+rand});
		}else{
			showMessage('User alreay added', "error", "toastr");
		}
		$('.userempty-error').hide().text('');
	}else{
		//alert();
		$('.adduser-error').show().text('Please select a Grade');
	}
});

$(document).on('click','.addAlluserList .close_icon',function(e){
	var target = $(this).parent();
	var rand = $(this).attr('id');
	var index = _.findIndex(assignList, function(item){
		return $.trim(item.rand) === $.trim(rand);
	});
	if(index != -1){
		assignList.splice(index, 1);
		target.remove();
	}
});

function memberExist(arr, id) {
    for(var i = 0, len = arr.length; i < len; i++) {
        if( arr[ i ].id === id )
            return true;
    }
    return false;
}

function tempcheckGraph(tempcheck_id, user_id){
	 sendGetRequest(APP_URL+'/tempchecks/'+tempcheck_id+'/trend_graph/'+user_id, function (response) {
        if (response.status) {
			setChartData(response.data)
        }else{
			showMessage(response.message, "error", "toastr");
		}
    });
}
function setChartData(data){
	Highcharts.chart('container', {
		title: {
			text: ''
		},
		yAxis: {
			title: {
				text: 'Average Rating',
				style: {
					color: '#384f98',
					borderColor:'#384f98',
				},
			}, 
		},

		xAxis: {
			categories: data.categories,
			title: {
				text: 'Date',
				style: {
					color: '#384f98',
					borderColor:'#384f98',
				},
			},
		
		},

		colors: ['#384f98'],

		series: [{
			name: 'Ratings',
			data: data.value
		}],

		responsive: {
			rules: [{
				condition: {
					maxWidth: 500
				},
			}]
		}

	});
}