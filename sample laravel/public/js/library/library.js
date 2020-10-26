var assignMembers = [];
var assignGroups  = [];
var libraryMangementTable;
var filterByLibraryId,filterByCreatedDate,filterByCreatedBy,filterByRating,filterByContentType,searchString;

$(document).ready(function() {
	renderContentBlock();
});


//function to filter by content 
$(document).on('change','.filterByLibraryId',function(){
	filterByLibraryId = $(this).val();
	renderContentBlock();
})

//function to filter by content type 
$(document).on('change','.filterByContentType',function(){
	filterByContentType = $(this).val();
	renderContentBlock();
})

//function to filter by created date 
$(document).on('change','.filterByCreatedDate',function(){
	filterByCreatedDate = $(this).val();	
	renderContentBlock();
})

//function to filter by created by
$(document).on('change','.filterByCreatedBy',function(){
	filterByCreatedBy = $(this).val();
	renderContentBlock();
})

//function to filter by created by
$(document).on('change','.filterByRating',function(){
	filterByRating = $(this).val();
	renderContentBlock();
})

$(document).on('keyup change','#dataTableSearch', function () {
	searchString = $(this).val();
	renderContentBlock();
});

function renderContentBlock(){
	lxp_submit_loader(true);

	var data = {
		'content_name'	:filterByLibraryId,
		'content_type'	:filterByContentType,
		'created_date'	:filterByCreatedDate,
		'created_by'	:filterByCreatedBy,
		'rating'		:filterByRating,
		'search_string'	:searchString,
	};
	
	sendGetHtmlRequest(APP_URL+'library_block_list',data,function(response){
		$('#loadContentBlock').html(response);
		setTimeout(function () {
			lxp_submit_loader(false);
		},500);
	});
}

$(document).on('change','#inputPaymentTypeName',function(){
	if($(this).val() != "" && $(this).val() == 'paid'){
		$('.paymentTypeSec').removeClass('d-none');
		$('#inputPriceName').val('');
		$('#inputApprover').prop('selectedIndex','').trigger('change');
	}else{
		$('.paymentTypeSec').addClass('d-none');
	}	
});

$(document).on('change','.milestoneContentType',function(){
	localStorage.setItem('libraryContentType',$(this).val());
	window.location.href = APP_URL+'libraries/create';
});

function libraryMangementList(){
	libraryMangementTable = $('#libraryList').DataTable({
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
		"serverSide": true,
		"ajax": APP_URL+"/library_list",
		"columns": [
			{data: 'title', name: 'title'},
			{data: 'content_type', name: 'content_type'},
			{data: 'created_by', name: 'created_by'},
			{data: 'created_at', name: 'created_at'},
			{data: 'created_at', name: 'created_at'},
			{data: 'action'}
		],
		"columnDefs": [
			{ className: "actions action_btn", "orderable": false, "targets": [ 5 ] }
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
			libraryMangementTable.draw();
	   }else{
		  showMessage(response.message, "error", "toastr");
	   }
    });
  }
});


function deleteLibrary(library_id, name) {
	
	
	var data = {
		_token:$('meta[name="csrf-token"]').attr('content'),
		_method:'DELETE',
		library_id:library_id,
		name:name,
		title:'Delete',
		content:'you want to delete the following Content?'
	};
	commonConfirm(data, delete_library);
}

function delete_library(data, callback) {
    sendPostRequest(APP_URL+'/libraries/'+data.library_id, data, function (response) {
        if (response.status) {
			renderContentBlock();
            showMessage(response.message, "success", "toastr");
        }else{
			showMessage(response.message, "error", "toastr");
		}
		callback();
    });
}

function assignUserChange(user_ids){
	var data = {
		_token:$('meta[name="csrf-token"]').attr('content'),
		user_id:$.map( user_ids, function( a ) { return a.id; })
	}
	get_journey_list(data);
}

function assignGroupChange(group_ids){
	var data = {
		_token:$('meta[name="csrf-token"]').attr('content'),
		group_id: $.map( group_ids, function( a ) { return a.id; })
	}
	get_journey_list(data);
}

function get_journey_list(data){	
	sendPostRequest(APP_URL+'/libraries/get_journey', data, function (response) {
        if (response.status) {
			$('#inputJourneyName').html('').append('<option>Select option</option>');
			$.each(response.journeys, function(key, val){
				$('#inputJourneyName').append('<option value='+key+'>'+val+'</option>');
			});
            //showMessage(response.message, "success", "toastr");
        }
    });
}

function addToMyJourney(content_id){
	$('#loadAddContentModal').html('');
	$('#loadAddContentModal').load(APP_URL+'/libraries/add_to/'+content_id, function(){ 
		$('#addAddContentModal').modal('show');
	});
}


$(document).on('click','#assignAddUser',function(e){
	if($('#inputUserName').val() != ""){
		var id = $('#inputUserName').val()
		if(!memberExist(assignMembers, id)){
			var name = $("#inputUserName option:selected").html();
			var rand = Math.floor(1000 + Math.random() * 9000);
			$('ul#addMulUserList').append('<li id="' + rand + '">'+ name + '<span id=" user_' + rand + ' " class="close_icon"><i class=" icon-close-button"></i></span></li>');
			assignMembers.push({'id':id,'name':name,'rand':rand});
			assignUserChange(assignMembers)
		}else{
			showMessage('User alreay added', "error", "toastr");
		}
		$('.userempty-error').hide().text('');
	}else{
		//alert();
		$('.adduser-error').show().text('Please select a Users');
	}
});

$(document).on('click','#assignAddGroup',function(e){
	//console.log($('#inputGroupName').val())
	if($('#inputGroupName').val() != ""){
		var id = $('#inputGroupName').val()
		if(!memberExist(assignGroups, id)){
			var name = $("#inputGroupName option:selected").html();
			var rand = Math.floor(1000 + Math.random() * 9000);
			$('ul#addMulGroupList').append('<li id="' + rand + '">' + name + '<span id="group_' + rand + '" class="close_icon"><i class=" icon-close-button"></i></span></li>');
			assignGroups.push({'id':id,'name':name,'rand':rand});
			assignGroupChange(assignGroups)
		}else{
			showMessage('User alreay added', "error", "toastr");
		}
		$('.userempty-error').hide().text('');
	}else{
		//alert();
		$('.adduser-error').show().text('Please select a Group');
	}
});

function memberExist(arr, id) {
    for(var i = 0, len = arr.length; i < len; i++) {
        if( arr[ i ].id === id )
            return true;
    }
    return false;
}

$(document).on('click','.addMulUserList .close_icon',function(e){
	var $target = $(this).parent('li');
	var rand = $(this).attr('id');
	var data_arr = rand.split('_');
	if((data_arr[0]).trim() == 'user'){
		var index = _.findIndex(assignMembers, function(item){
			return item.rand === parseInt(data_arr[1]);
		});
		if(index != -1){
			assignMembers.splice(index, 1);
			assignUserChange(assignMembers)
			$target.remove();
		}
	}else if((data_arr[0]).trim() == 'group'){
		var index = _.findIndex(assignGroups, function(item){
			return item.rand === parseInt(data_arr[1]);
		});
		if(index != -1){
			assignGroups.splice(index, 1);
			assignGroupChange(assignGroups)
			$target.remove();
		}
	}
});

$( function() {
  $(".datepicker").datepicker({
	   dateFormat: 'M d, yy',
	   minDate: new Date()
  });

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
});

if($('#end_date').length > 0){
	$('#end_date').on('change', function(evt){
		$(this).valid();
	});
}

$(document).on("click",".lib_grid_bottom span.expand .icon-Expand",function(e){
	if($(this).hasClass('btn-collapse')){
		$(this).removeClass('btn-collapse');
		$(this).parents('.lib_grid_bottom').find('.btn-dropdown').hide();
		e.stopPropagation();
	}
	else{
		$('.lib_grid_bottom span.expand .icon-Expand').removeClass('btn-collapse');
		$(this).addClass('btn-collapse');
		$('.lib_grid_bottom span.expand .icon-Expand').parents('.lib_grid_bottom').find('.btn-dropdown').hide();
		$(this).parents('.lib_grid_bottom').find('.btn-dropdown').show();
		e.stopPropagation();
	}
});

$(document).click(function (e) {
    if (! $(e.target).hasClass('btn-collapse'))
		$('.lib_grid_bottom span.expand .icon-Expand').removeClass('btn-collapse');
		$('.lib_grid_bottom span.expand .icon-Expand').parents('.lib_grid_bottom').find('.btn-dropdown').hide();
});

$(document).on('submit','#contentAssignForm', function(e){
	e.preventDefault();
	lxp_submit_loader(true);
    let url = $(this).attr('action');
	var data = $('#contentAssignForm').serializeArray();
	
	if(assignMembers.length > 0){
		$.each(assignMembers, function(k,v){
			data.push({name:'user['+k+']', value:v.id});
		});
	}
	
	if(assignGroups.length > 0){
		$.each(assignGroups, function(k,v){
			data.push({name:'group['+k+']', value:v.id});
		});	
	}
	
    $.easyAjax({
        url: url,
        container: "#contentAssignForm",
        type: "POST",
		disableButton: true,
        redirect: true,
        file: false,
        data: data,
        messagePosition:'toastr',
    }, function(response){
       if(response.status){
		  //showMessage(response.message, "success", "toastr");
	   }else{
		  //showMessage(response.message, "error", "toastr");
	   }
	   setTimeout(function(){
			lxp_submit_loader(false);
		},500)
    });
});