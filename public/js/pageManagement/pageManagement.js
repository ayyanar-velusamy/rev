var PageMangementTable;
var renderGradeList = [];
var selectedGrade = [];

$(document).on('submit','form',function(e){
    if($(this).hasClass('ajax-form')){
		e.preventDefault()
		let url = $(this).attr('action');
		let target = ('#'+$(this).attr('id') == '#undefined') ? 'body' : '#'+$(this).attr('id');
		let myEle = document.getElementById("inputFile");
		var formData = new FormData(this);     
		let messagePosition = 'toastr';
		$.easyAjax({
			url: url,
			container : target,
			type: "POST",
			redirect: true,
			disableButton: true,
			file: true,
			data: formData,
			messagePosition:messagePosition,
		}, function(res){

		   if(res.action){
				userCallbackAction(res.action, res);
		   }

		   if(res.cartProductCount){
			  $('#cartProductCount').text(res.cartProductCount);
		   }
		   if(res.bulk_upload){
				PageMangementTable.draw(); 
				$('#bulkImp').modal('hide');
				resetBlukUpload();
		   }
		   if(res.bulk_upload_error){
			   PageMangementTable.draw(); 
			   renderBlukUploadError(res.failed_items)
		   }			
		});
	}
});

function userCallbackAction(action, response){
	if(action == 'change_password'){
		$('#changePasswordModalForm')[0].reset();
		//reset browser Back Confirm Alert
		resetBackConfirmAlert();
		$('#changePasswordModal').modal('hide');
	}
}

$(document).on("click","#changePasswordModal .btn-close, #changePwdCancel",function(){
	$('#changePasswordModalForm')[0].reset();
	//reset browser Back Confirm Alert
	resetBackConfirmAlert();
});

function renderBlukUploadError(errors){
	
	var table = '<div class="errorTable"><div class="row error_head"><div class="col-md-1">#</div><div class="col-md-6">Email</div><div class="col-md-5">Error message</div></div>';
	var index = 1;
	$(errors).each(function(key,value){
		table += '<div class="row error_body"><div class="col-md-1">'+ (index++) +'</div><div class="col-md-6 maxname">'+value.email+'</div><div class="col-md-5">'+value.error+'</div></div>';
	})
	table +='</div><div class="btn-footer"><button type="button" onclick="resetBlukUpload()" class="btn-green btn">OK</button></div>';
	$('#uploadSection').hide();
	$('#uploadErrorSection').show();
	$('#bulkImp').modal('show');
    $('#uploadErrorSection').html(table);
	
	$("#uploadErrorSection .errorTable").mCustomScrollbar({
		theme:"minimal",
		 axis:"y",
		 scrollbarPosition: "inside",
		 scrollButtons:{ enable: false },
		 mouseWheel:{ enable: true },
		 advanced:{
			autoExpandHorizontalScroll:true,
			updateOnContentResize:true
		},
	}); 
}

function deletePage(page_id, status, name){
	$('#pageDeleteName').text(name);
	if(status == 'inactive'){
		$('#deletePageInactive').hide()
		$('#statusInactive').show()		
		$('#statusActive').hide()
	}else{
		$('#deletePageInactive').show()
		$('#statusInactive').hide()
		$('#statusActive').show()
	}
	$('#pageDeleteId').val(page_id);
	$('#pageDelete').modal('show')
}

$(document).on('click','#deletePageInactive', function(){
	loadingSubmitButton('#deletePageInactive');
	var data = {
		_token:$('meta[name="csrf-token"]').attr('content'),
		_method:'PUT',
		status:'inactive',
		id:$('#pageDeleteId').val()
	};	
		
	delete_inactive(data, function(){
		$("#pageDelete").modal("hide");
		unloadingSubmitButton('#deletePageInactive');		
	});
});

$(document).on('click','#deletePageYes', function(){
	loadingSubmitButton('#deletePageYes');
	var data = {
		_token:$('meta[name="csrf-token"]').attr('content'),
		_method:'DELETE',
		id:$('#pageDeleteId').val()
	};	
	
	delete_page(data, function(){
		$("#pageDelete").modal("hide");
		unloadingSubmitButton('#deletePageYes');
	});
});


function delete_inactive(data, callback) {
    sendPostRequest(APP_URL+'/pages/status/'+data.id, data, function (response) {
        if (response.status) {
			PageMangementTable.draw();
            showMessage(response.message, "success", "toastr");
        }else{
			showMessage(response.message, "error", "toastr");
		}
		callback()
    });
}

function delete_page(data, callback) {
    sendPostRequest(APP_URL+'/pages/'+data.id, data, function (response) {
        if (response.status) {
			PageMangementTable.draw();
            showMessage(response.message, "success", "toastr");
        }else{
			showMessage(response.message, "error", "toastr");
		}
		callback()
    });
}


function pageManagement(){  
		
	$.fn.dataTable.ext.errMode = 'none';

	PageMangementTable = $('#pageList').DataTable({ 
		"processing": true,
		"dom": '<"top">rt<"bottom"ilp><"clear">',
		"serverSide": true,
		"scrollX": false,
		"searching": true,
		"ajax": APP_URL+"/page_list",
		"error": function(response) {
			console.log(response)
		},
		"columns": [			
			{data: 'title', name: 'title'},
			{data: 'meta_description', name: 'meta_description'},
			{data: 'meta_keyword', name: 'meta_keyword'}, 
			{data: 'status', name: 'status'},
			{data: 'action', name: 'action', orderable: false, searchable: false},
		],
		"order": [],
		"createdRow": function ( row, data, index ) {
		    $('td', row).eq(0).html("<span class='maxname'>" + data['title'] + "</span>");
		    $('td', row).eq(1).html("<span class='maxname'>" + data['meta_description'] + "</span>");
		    $('td', row).eq(2).html("<span class='maxname'>" + data['meta_keyword'] + "</span>");

			if(data.status == 'Inactive'){
				$(row).find('td').addClass("table_row_disabled").css({"background-color": '#fbfbfb', "opacity":"0.5"});
				$(row).find('td .btn').css({"color": '#ffffff'});
			}
		},
		"columnDefs": [
			{ className: "actions action_btn", "orderable": false, "width": "30%", "targets": [ 4 ] }
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
    PageMangementTable.search($(this).val()).draw();
}); 

$(document).on('click','#clearForm',function(){
	$('#profile-adminImg').attr('src', $('#profile-adminImg').data('src'));
});
  
  
function copyLinkFunction() {
  var copyText = document.getElementById("copyLinkInputField");
  copyText.select();
  copyText.setSelectionRange(0, 99999)
  document.execCommand("copy");
  //alert("Copied the text: " + copyText.value);
  showMessage("Link Copied", "success", "toastr");
}	