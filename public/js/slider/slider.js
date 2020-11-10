var Table; 

$(document).on('submit','form',function(e){
    if($(this).hasClass('ajax-form')){
		e.preventDefault()
		let url = $(this).attr('action');
		let target = ('#'+$(this).attr('id') == '#undefined') ? 'body' : '#'+$(this).attr('id');
		let myEle = document.getElementById("inputFile");
		var formData = new FormData(this); 
		let messagePosition = 'toastr';  
		var isValid  = true;
		var extension = $('.profileAdmin').val().replace(/^.*\./, '');
		if($('.profileAdmin').val() != "") {
			if($.inArray(extension, ['png','jpg','jpeg','JPG','PNG','JPEG']) != -1) {
				var size = $('.profileAdmin')[0].files[0].size;
				if(size >= 5000000) {
					$('.add-banner .error').html('Image size cannot exceed 5 MB');
					isValid = false;
					return false;
				} else if(size <= 10000) {
					$('.add-banner .error').html('Image size must be more than 10 KB');
					isValid = false;
					return false;
				} else { 
					isValid = true;
					$('.add-banner .error').html('');
				}
			} else {
				$('.add-banner .error').html('File format should accept only JPEG,PNG.');
				isValid = false;
				return false;
			}
		}else{
			$('.add-banner .error').html('Slider Image cannot be empty');
			isValid = false;
			return false;
		}
		if(isValid){
			$.easyAjax({
			url: url,
			container	: target,
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
			});
		}
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
    sendPostRequest(APP_URL+'/sliders/status/'+data.id, data, function (response) {
        if (response.status) {
			Table.draw();
            showMessage(response.message, "success", "toastr");
        }else{
			showMessage(response.message, "error", "toastr");
		}
		callback()
    });
}

function delete_page(data, callback) {
    sendPostRequest(APP_URL+'/sliders/'+data.id, data, function (response) {
        if (response.status) {
			Table.draw();
            showMessage(response.message, "success", "toastr");
        }else{
			showMessage(response.message, "error", "toastr");
		}
		callback()
    });
}


function sliderTable(){  
		
	$.fn.dataTable.ext.errMode = 'none';

	Table = $('#sliderList').DataTable({ 
		"processing": true,
		"dom": '<"top">rt<"bottom"ilp><"clear">',
		"serverSide": true,
		"scrollX": false,
		"searching": true,
		"ajax": APP_URL+"/slider_list",
		"error": function(response) {
			console.log(response)
		},
		"columns": [			
			{data: 'name', name: 'name'}, 
			{data: 'image', name: 'image'}, 
			{data: 'status', name: 'status'},
			{data: 'action', name: 'action', orderable: false, searchable: false},
		],
		"order": [],
		"createdRow": function ( row, data, index ) {
		    $('td', row).eq(0).html("<span class='maxname'>" + data['name'] + "</span>");  
			 $('td', row).eq(1).html("<img src='"+data['image']+"' width='200px' height='100px' />");  
			if(data.status == 'Inactive'){
				$(row).find('td').addClass("table_row_disabled").css({"background-color": '#fbfbfb', "opacity":"0.5"});
				$(row).find('td .btn').css({"color": '#ffffff'});
			}
		},
		"columnDefs": [
			{ className: "actions action_btn", "orderable": false, "width": "30%", "targets": [ 3 ] },
			{ className: "", "orderable": false, "targets": [ 1 ] }
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