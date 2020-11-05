var UserMangementTable;
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

		   if(res.cartProductCount){
			  $('#cartProductCount').text(res.cartProductCount);
		   }
		   if(res.bulk_upload){
				UserMangementTable.draw(); 
				$('#bulkImp').modal('hide');
				resetBlukUpload();
		   }
		   if(res.bulk_upload_error){
			   UserMangementTable.draw(); 
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

function deleteUser(user_id, status, name){
	$('#userDeleteName').text(name);
	if(status == 'inactive'){
		$('#deleteUserInactive').hide()
		$('#statusInactive').show()		
		$('#statusActive').hide()
	}else{
		$('#deleteUserInactive').show()
		$('#statusInactive').hide()
		$('#statusActive').show()
	}
	$('#userDeleteId').val(user_id);
	$('#userDelete').modal('show')
}

$(document).on('click','#deleteUserInactive', function(){
	loadingSubmitButton('#deleteUserInactive');
	var data = {
		_token:$('meta[name="csrf-token"]').attr('content'),
		_method:'PUT',
		status:'inactive',
		user_id:$('#userDeleteId').val()
	};	
		
	delete_inactive(data, function(){
		$("#userDelete").modal("hide");
		unloadingSubmitButton('#deleteUserInactive');		
	});
});

$(document).on('click','#deleteUserYes', function(){
	loadingSubmitButton('#deleteUserYes');
	var data = {
		_token:$('meta[name="csrf-token"]').attr('content'),
		_method:'DELETE',
		user_id:$('#userDeleteId').val()
	};	
	
	delete_user(data, function(){
		$("#userDelete").modal("hide");
		unloadingSubmitButton('#deleteUserYes');
	});
});


function delete_inactive(data, callback) {
    sendPostRequest(APP_URL+'/users/status/'+data.user_id, data, function (response) {
        if (response.status) {
			UserMangementTable.draw();
            showMessage(response.message, "success", "toastr");
        }else{
			showMessage(response.message, "error", "toastr");
		}
		callback()
    });
}

function delete_user(data, callback) {
    sendPostRequest(APP_URL+'/users/'+data.user_id, data, function (response) {
        if (response.status) {
			UserMangementTable.draw();
            showMessage(response.message, "success", "toastr");
        }else{
			showMessage(response.message, "error", "toastr");
		}
		callback()
    });
}


function userManagement(){
		
	$.fn.dataTable.ext.errMode = 'none';

	UserMangementTable = $('#userList').DataTable({ 
		"processing": true,
		"dom": '<"top">rt<"bottom"ilp><"clear">',
		"serverSide": true,
		"scrollX": false,
		"searching": true,
		"ajax": APP_URL+"/user_list",
		"error": function(response) {
			console.log(response)
		},
		"columns": [			
			{data: 'full_name', name: 'full_name'},
			{data: 'email', name: 'email'},
			{data: 'mobile', name: 'mobile'},
			{data: 'role', name: 'role'},
			{data: 'status', name: 'status'},
			{data: 'action', name: 'action', orderable: false, searchable: false},
		],
		"order": [],
		"createdRow": function ( row, data, index ) {
		    $('td', row).eq(0).html("<span class='maxname'>" + data['full_name'] + "</span>");
		    $('td', row).eq(1).html("<span class='maxname'>" + data['email'] + "</span>");
		    $('td', row).eq(3).html("<span class='maxname'>" + data['role'] + "</span>");

			if(data.status == 'Inactive'){
				$(row).find('td').addClass("table_row_disabled").css({"background-color": '#fbfbfb', "opacity":"0.5"});
				$(row).find('td .btn').css({"color": '#ffffff'});
			}
		},
		"columnDefs": [
			{ className: "actions action_btn", "orderable": false, "width": "30%", "targets": [ 5 ] }
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
    UserMangementTable.search($(this).val()).draw();
});


//$('#userAddForm button[type="reset"], #userEditForm button[type="reset"]').click(function() {
	//$('.select_level, select.form-control').val(null).trigger('change');
  //$(".error").removeClass("error");
//});

//function resetUserEditForm(){	
	// $('.select_level, select.form-control').each(function(){
		// var val = $(this).val();
		// $(this).val(val).attr('reset', true);			
	// })
	
	// setTimeout(function(){
			// $('.select_level, select.form-control').trigger('change');
	// },100);
//}



function resetBlukUpload(){
	resetBackConfirmAlert();	
	$('#bulkImp').modal('hide');
	$('#bulkImp').modal('hide');
	$('.csv_span').text('Import CSV');
	$('.zip_span').text('Import ZIP for Profile Image');
	$('#hrBulk')[0].reset();
	$('#uploadSection').show('slow');
    $('#uploadErrorSection').hide();
	$('.import_file #bulkimphrcsv, .import_file #bulkimphrzip').val(''); 
}

$(document).on('click','#clearForm',function(){
	$('#profile-adminImg').attr('src', $('#profile-adminImg').data('src'));
});

function grade_list(){	
	var data = {};
	var disabled = "";
	var required = ""; //' <span class="required">*</span>';
	if($('form').attr('id') != 'userAddForm'){
		data.user_id = $(location).attr('href').split("/").splice(4, 1).join("/");
	}
	sendPostRequest(APP_URL+'/users/grade_list',data, function (response) {
        if (response.status) {
            renderGradeList = response.data
			if(response.user_grade){
				
				if($(location).attr('href').split("/").splice(5, 1).join("/") == ""){
					disabled = "disabled";
					required = "";
				}
				
				//render default root node
				renderInitialGrade(0, 1, "disabled", ' <span class="required">*</span>');
				
				//render second node
				if(response.user_grade.length == 0){
					renderInitialGrade(1, '', '', '');
				}
				
				//var setId = response.user_grade[response.user_grade.length-1].set_id;
				$(response.user_grade).each(function(key,val){
					if(val.set_id != 0){
						renderInitialGrade(val.set_id, val.node_id, disabled, required);
					}
				})

				if(renderGradeList.grade_list.length > response.user_grade.length){
					var lastEl = response.user_grade[response.user_grade.length-1];
					if(lastEl.node_id != undefined && lastEl.node_id != "" && disabled == ""){
						renderGrade("<input type='hidden' value='"+lastEl.node_id+"' />", (parseInt(lastEl.set_id)+1));
					}
				}
			}else{
				renderInitialGrade(0, 1, "disabled", ' <span class="required">*</span>');
				if(renderGradeList.grade_list.length > 1){
					renderInitialGrade(1, "", disabled, required);
				}				
			}
			
        }else{
			//showMessage(response.message, "error", "toastr");
		}
		
    });
}


function renderInitialGrade(set_id, node_id, disabled, required){
	var render_set_data = [];
	var render = "";
	var firstGradeID = 1;
	var hiddenInput = "";
	
	$.each(renderGradeList.org_data, function(org_key, org_data){
		if(org_data.set_id == set_id){
			render_set_data = org_data;
		}
	});
	
	var options = '<option value="">Select '+render_set_data.set_name+'</option>';
	
	$.each(renderGradeList.grade_list, function(grade_key, grade_data){
		if(grade_data.set_id == render_set_data.set_id){
			var selected = "";
			if(parseInt(grade_data.node_id) == parseInt(node_id)){
				firstGradeID = grade_data.node_id;
				selected = "selected";
			}
			options += '<option '+selected+' value="'+grade_data.node_id+'">'+grade_data.node_name+'</option>';
		}
	});				
	
	if(set_id == 0){ 
		hiddenInput = '<input name="gradeId['+render_set_data.set_id+']" type="hidden" value="'+firstGradeID+'">'
	}
	
	//required = ''; //' <span class="required">*</span>';
	
	render += '<div class="form-group select-unit grade_'+render_set_data.set_id+' "><label data-text="Select '+render_set_data.set_name+'" for="select_level">'+render_set_data.set_name+required+'</label>	<select '+disabled+' onchange="renderGrade(this, '+render_set_data.set_id+')" name="gradeId['+render_set_data.set_id+']" class="select2 form-control select_level">'+options+'</select>'+hiddenInput+'</div>';	 /*<div id="renderGrade_'+render_set_data.set_id+'"></div>*/
	$('#renderGrade').append(render);
	
	$('.select2').select2({ minimumResultsForSearch: -1});
}


function renderGrade(e, set_id){
	
	$('.grade_'+set_id).find('span.error').text('');
	
	$('.grade_'+set_id).nextAll().remove()
		
	var grade_list = renderGradeList.grade_list.filter( function(data){ if(data.node_parent == $(e).val()) return data });
	
	if(grade_list.length == 0 || $(e).val() == ""){
		return false;
	}

	var render_set_data = [];
	var render = "";

	$.each(renderGradeList.org_data, function(org_key, org_data){
		
		if(org_data.set_id == grade_list[0].set_id){
			render_set_data = org_data;
		}
	});
	var options = '<option value="">Select '+render_set_data.set_name+'</option>';
	
	$.each(grade_list, function(grade_key, grade_data){
		options += '<option value="'+grade_data.node_id+'">'+grade_data.node_name+'</option>';
	});
	
	required = ''; //' <span class="required">*</span>';
		
	render += '<div class="form-group select-unit grade_'+render_set_data.set_id+' "><label data-text="Select '+render_set_data.set_name+'" for="select_level">'+render_set_data.set_name+required+' </label><select onchange="renderGrade(this,'+render_set_data.set_id+' )" name="gradeId['+render_set_data.set_id+']" class="select2 form-control select_level">'+options+'</select></div>';

	$('#renderGrade').append(render);
	$('.select2').select2({ minimumResultsForSearch: -1});
}


	// $('#myLearningJourneyList').DataTable({ 
		// "processing": true,
		// "dom": '<"top">rt<"bottom"ilp><"clear">',
		// "serverSide": true,
		// "scrollX": false,
		// "searching": true,
	
		// "columns": [
			// {data: 'journey_name', name: 'journey_name'},
			// {data: 'assigned_by', name: 'assigned_by'},
			// {data: 'completed_date', name: 'completed_date'},
			// {data: 'points_earned', name: 'points_earned'},
			// {data: 'rating', name: 'rating'},
			// {data: 'progress', name: 'progress'},
			// {data: 'action'}
		// ],
		// "order": [],
		// "columnDefs": [
			// { className: "actions action_btn", "orderable": false, "width": "20%", "targets": [ 6 ] }
		// ],
		// "lengthMenu": [[10, 25, 50,100 , -1], [10, 25, 50, 100, "All"]],
		// language: {
			// search: "_INPUT_",
			// searchPlaceholder: "Search...",
			// sInfo: "Showing _START_ to _END_ of _TOTAL_",
			// lengthMenu: "Show _MENU_",
			// "paginate": {
			  // "previous": "Prev."
			// }
		// } 
	// });
	
function copyLinkFunction() {
  var copyText = document.getElementById("copyLinkInputField");
  copyText.select();
  copyText.setSelectionRange(0, 99999)
  document.execCommand("copy");
  //alert("Copied the text: " + copyText.value);
  showMessage("Link Copied", "success", "toastr");
}	

/*upload croppie for account setting page*/
 
imgUrl = '';
img_data  = [];
var imgCroppie = (function() {  
	function profileUp() { 
		var $uploadCrop5;
		$('#userprofile').empty(); 	
		function readFile(input) {
 			if (input.files && input.files[0]) {
	            var reader = new FileReader();
	            
	            reader.onload = function (e) {
					$('.add-user').addClass('ready');
					$('.account-wrap').show();
					$('#userprofile .cr-image').attr('src', '');
					$('#userprofile .cr-image').css({'opacity' : '','transform': '', 'transform-origin': ''});
					
						$uploadCrop5.croppie('bind', {
							url: e.target.result
						}).then(function(){
							console.log('jQuery bind complete');
							$('.uploadLabel').hide();
							$('.add-user ul.list-inline').show(); 
							$('.add-user .table-small-img-outer').hide();
							//$('.profile-wrap').show();
						});
					
	            }
	            reader.readAsDataURL(input.files[0]);
	        }
	        else {
		        
		    }
			$('#profile-adminImg').hide();
		}
		if($("#userprofile").length > 0){
			$uploadCrop5 = $('#userprofile').croppie({
				viewport: {
					width: 150,
					height: 150,
					type: 'circle'
				},
				boundary: {
					width: 160,
					height: 160
				},
				enforceBoundary: true,
				enableOrientation: true,
				showZoomer: false,
				enableExif: false,
				enableZoom:true,
				mouseWheelZoom:false
			});
		}
		
		$('.crop-save').on('click', function (ev) {
			
				$uploadCrop5.croppie('result', {
					type: 'blob',
					size: 'viewport',
					format:'jpg,png,jpeg'
				}).then(function (resp) {
					profile_image_data = image_data = resp;
					var urlCreator = window.URL || window.webkitURL;
					console.log(image_data);
					imgUrl = urlCreator.createObjectURL(image_data);
					$('#profile-adminImg').attr('src',imgUrl);
					$('#profile-adminImg').show();
					$('.account-wrap').hide();
					$('.add-user ul').hide();
					$('.uploadLabel').show();
					$('.add-user .table-small-img-outer').show();
				});
			
		});
		$('.crop-cancel').click(function(){
			$('.account-wrap').hide();
			$('.add-user ul').hide();
			$('#profile-adminImg').show();
			$('.uploadLabel').show();
			$('.add-user').removeClass('ready');
			$('.profileAdmin').val('');
			$('.add-user .table-small-img-outer').show();
		});
		
	
		 $(document).on('change','.profileAdmin',function () {
			var extension = $('.profileAdmin').val().replace(/^.*\./, '');
			if($('.profileAdmin').val() != "") {
				if($.inArray(extension, ['png','jpg','jpeg','JPG','PNG','JPEG']) != -1) {
					var size = $('.profileAdmin')[0].files[0].size;
					if(size >= 5000000) {
						$('.add-user .error').html('Image size cannot exceed 5 MB');
						return false;
					} else if(size <= 10000) {
						$('.add-user .error').html('Image size must be more than 10 KB');
						return false;
					} else {
						readFile(this);
						$('.add-user .error').html('');
					}
				} else {
					$('.add-user .error').html('File format should accept only JPEG,PNG.');
					return false;
				}
			}
		});
	}

	function init() {
		profileUp();
	}

	return {
		init: init
	};
})();
 

$('.account-user #profile-adminImg').on('click',function(){
	$('#profile-user').click();
});

imgCroppie.init();  