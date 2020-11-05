var profile_image_data = "";
var formmodified = 0; 
// JavaScript for label effects only
$(window).load(function(){
/* 	$(".form-field input").val(""); */
    $(".form-field .input_effect").focusout(function(){
        if($(this).val() != ""){
            $(this).addClass("has-content"); 
        }else{
            $(this).removeClass("has-content"); 
        }
		$(".input_effect").each(function(){
			if($(this).val() != ""){
				$(this).removeClass("has-content"); 
				$(this).addClass("has-content"); 
			}else{
				$(this).removeClass("has-content"); 
			}
		})
    })
});

if( $("#sidebar_scroll").length > 0){
  $("#sidebar_scroll").mCustomScrollbar({
	theme:"minimal",
	 axis:"y",
	 scrollbarPosition: "inside",
	 scrollButtons:{ enable: false },
	 mouseWheel:{ enable: true },
	 advanced:{
		autoScrollOnFocus:'a[tabindex]', 
		autoExpandHorizontalScroll:true,
		updateOnContentResize:true
	},
	}); 
} 

/*Notification Modal Scroll*/
if($('#scrollbar').length > 0 ) {
	$("#scrollbar").mCustomScrollbar({
			theme:"minimal",
			 axis:"y",
			 scrollbarPosition: "inside",
			 scrollButtons:{ enable: false },
			 mouseWheel:{ enable: true },
			 advanced:{
				autoScrollOnFocus:true, 
				autoExpandHorizontalScroll:true,
				updateOnContentResize:true
			},

	});  
}

/*admin settings*/

$(document).ready(function () {   
	$('.admin_img img').on('click', function(){
	if($('.admin_img_drop').is(':visible') == false){
		$('.admin_img_drop').slideToggle(100);
		}
	});		

	$(document).mouseup(function(e) {
		if($('.admin_img_drop').is(':visible') == true){
			if(e.target.offsetParent == null || e.target.className != 'admin_img_drop' && e.target.offsetParent.className != 'admin_img_drop'){
				$('.admin_img_drop').slideToggle(100);
			}
		}
	});
});



/*sidebar shrink and expand*/
$(".left-side-navbar .sidemenu_list").on('click',function(){
		$(".header").toggleClass("haeder-change");
		$(".page-wrap").toggleClass("menu-close");
		$(this).toggleClass('animation');
});
	
/*mCustomScrollbar Organization*/


$(window).on("load",function(){
	
	if($(".org-chart-sec").length > 0){
		$(".org-chart-sec").mCustomScrollbar({
			theme:"minimal",
			axis:"x",
			scrollbarPosition: "inside",
			scrollButtons:{ enable: false },
			contentTouchScroll: 20,
			mouseWheel:{ enable: true } ,
			advanced:{
				autoScrollOnFocus:'input', 
				autoExpandHorizontalScroll:true,
				updateOnContentResize:true,
			},

		});
	} 	
	//$('.mCSB_container').addClass('dragscroll');	
	
	if($("#orgChartContainer").length > 0){
		$("#orgChartContainer").mCustomScrollbar({
			theme:"minimal",
			 axis:"y",
			 scrollbarPosition: "inside",
			 autoExpandScrollbar: true,
			 scrollInertia: "2", 
			 scrollButtons:{ enable: false },
			 mouseWheel:{ enable: false },
			 advanced:{
				autoScrollOnFocus:'input', 
				autoExpandHorizontalScroll:true,
				updateOnContentResize:true
			},

		});  
	}
	
});


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

//imgCroppie.init();

/*Import Modal Pop input file type filed */
$('.import_file #bulkimphrcsv').change(function() {
  //var i = $(this).prev('span').clone();
  var file = $('.import_file #bulkimphrcsv')[0].files[0].name;
  $(this).prev('span').text(file);
}); 

$('.import_file #bulkimphrzip').change(function() {
  //var i = $(this).prev('span').clone();
  var file = $('.import_file #bulkimphrzip')[0].files[0].name;
  $(this).prev('span').text(file);
}); 


/* User add and edit page select grade option*/

$.fn.select2.amd.require._defined['select2/selection/search'].prototype.update = function(a, b) {
    var c = this.$search[0] == document.activeElement;
    this.$search.attr("placeholder", "");
    a.call(this, b);
    this.$selection.find(".select2-selection__rendered").append(this.$searchContainer);
    this.resizeSearch();
    if (c) {
      var self = this;
      window.setTimeout(function() {
        self.$search.focus();
      }, 0);
    }
  };

$(document).ready(function() {
	
	if($('.select2').length > 0){
		$('.select2').select2({ minimumResultsForSearch: -1,
		dropdownAutoWidth : true,
		width: 'auto' 
		}); 
	}
	// $('#userAddForm .select_level').each(function(i) {
		// if(i>0)
		// {	
			// $(this).parents('.form-group').addClass('select-disable').hide();
			// $(this).prop('disabled', true);
		// } else {
			// $(this).addClass('select_validate');
		// }
	// })
	$(".tagsInput").select2({ 
		tags: true,
		placeholder: "Enter Tags",
		tokenSeparators: ['', ''],
		maximumInputLength:64,
		 createTag: function(params) {
			if(params.term.match(/^[a-zA-Z]+$/g)){
				return { id: params.term, text: params.term };
			}	
		},
	});
});

// $(document).on("change","#userAddForm .select_level",function(){
	// $('#userAddForm select').each(function(i){
	// //$('.insertionEmp select').find('option').removeClass('insert-emp');;
		// $('#userAddForm select').find('option:selected').prop("selected",true);
	// });
	// //var get_modal = $(this).closest('.insertionEmp').attr('id');
	// var thisSetId = $(this).data('set-id');
	// var thisId = this;
	// $("#userAddForm .select_level").each(function(x){
		// if(x>=thisSetId){
			// console.log($(thisId).val())
			// disable_Id = x+1;
			// var get_parent_disable_id =  $(thisId).find('option:selected').data('node_id');
			// console.log(get_parent_disable_id);
			// var get_data_length = $("#userAddForm .level_id_"+disable_Id+" option[data-node_parent ='"+get_parent_disable_id+"']").length;
			// $("#userAddForm .level_id_"+disable_Id).find('option:first-child').prop('selected', true);
			// if(get_data_length == 0){
				// $("#userAddForm .level_id_"+disable_Id).parents('.form-group').addClass('select-disable').hide();
				// $("#userAddForm .level_id_"+disable_Id).prop('disabled', true);
				// $("#userAddForm .level_id_"+disable_Id).val(null).trigger('change');
			// } else {
				// $("#userAddForm .level_id_"+disable_Id).parents('.form-group').show();
				// $("#userAddForm .level_id_"+disable_Id).prop('disabled', false);
			// }
	  // }
	// });
// });

// $(document).on("change","#userEditForm .select_level",function(){
	// $('#userEditForm select').each(function(i){
	// //$('.insertionEmp select').find('option').removeClass('insert-emp');;
	// $('#userEditForm select').find('option:selected').prop("selected",true);
	// });
	// //var get_modal = $(this).closest('.insertionEmp').attr('id');
	// var thisSetId = $(this).data('set-id');
	// var thisId = this;
	// $("#userEditForm .select_level").each(function(x){
		// if(x>=thisSetId){
			// disable_Id = x+1;
			// var get_parent_disable_id =  $(thisId).find('option:selected').data('node_id');
			// var get_data_length = $("#userEditForm .level_id_"+disable_Id+" option[data-node_parent ='"+get_parent_disable_id+"']").length;
			// //$("#userEditForm .level_id_"+disable_Id).find('option:first-child').prop('selected', true);
			// //$(this).val(1).trigger('change.select2');
			// if(get_data_length == 0){
				// $("#userEditForm .level_id_"+disable_Id).parents('.form-group').addClass('select-disable');
				// $("#userEditForm .level_id_"+disable_Id).prop('disabled', true);
				// //$("#userEditForm .level_id_"+disable_Id).val('').trigger('change');
			// } else {
				// $("#userEditForm .level_id_"+disable_Id).parents('.form-group').removeClass('select-disable');
				// $("#userEditForm .level_id_"+disable_Id).prop('disabled', false);
			// }
	  // }
	// });
// });


function resetBackConfirmAlert(){
	formmodified = 0
}

function resetForm(){	
	resetBackConfirmAlert();
	window.location.reload(true);
		
	// var data = {
		// _token:$('meta[name="csrf-token"]').attr('content'),
		// _method:'DELETE',
		// title:'Reset Form',
		// content:'you want to reset?'
	// };		
	// commonConfirm(data, function(){
		// resetBackConfirmAlert();
		// window.location.reload();
	// });
}

$(document).on('click','#clearForm',function(){
	if($(this).closest('form').length > 0){
		var from_id = '#'+$(this).closest('form').attr('id');
		
		if((from_id+'.select_level, select.form-control').length > 0){
			$(from_id+'.select_level, select.form-control').val(null).trigger('change');
		}
				
		if(from_id == "#rolesAddForm"){
			$('.checkbox_label input.full_access').removeAttr('checked');
		}

		if(from_id == "#userAddForm"){
			var required = '<span class="required">*</span>';
			$('.import_file #bulkimphrcsv, .import_file #bulkimphrzip').val('');
			$('#renderGrade').html("");			
			renderInitialGrade(0, 1, "disabled", "");
			renderInitialGrade(1, "", "", required);			
		}
		
		$("span.error, div.error, .org-error").hide();		
		$(".form-control").removeClass('error');		
		
		$(from_id)[0].reset();
		resetBackConfirmAlert();
	}
});

$('.notification_list a[data-notif-id]').click(function (e) {
		e.preventDefault();
        var notif_id   = $(this).data('notifId');
        var targetHref = $(this).attr('href');
		var $this = this;
        $.post('/users/NotifMarkAsRead', {'notif_id': notif_id}, function (data) {
            if(data.status){
				if(window.location.href == targetHref || targetHref =="javascript:;"){
					$('#notification_modal').modal('hide');
					$($this).parents('li').remove();
					$target = $('.icon-notification span.count');
					var current_count = parseInt($target.text());
					var new_count = ((current_count - 1) >= 0) ? (current_count - 1) : 0;
					$target.text(new_count);
					if(new_count == 0){
						$('#notification_modal .notification_list').append('<li>No notification found</li>');
					}
					
				}else{
					window.location.href = targetHref; 
				}
			}
        }, 'json');

        return false;
});

$(document).on('click','.nav-tabs li a.nav-link',function(){
   if($(this).hasClass('active')){
	  $tabNname = $(this).attr('data-tabName');
	  //alert($tabNname);
	  $('.page-head .journey li a').html($tabNname);
   }
});



$(document).on("click",".comn_dataTable table span.expand-dot .icon-Expand",function(e){
	if($(this).hasClass('btn-collapse')){
		$(this).removeClass('btn-collapse');
		$(this).parents('td.actions').find('.btn-dropdown').hide();
		e.stopPropagation();
	}
	else{
		$('.comn_dataTable table span.expand-dot .icon-Expand').removeClass('btn-collapse');
		$(this).addClass('btn-collapse');
		$('.comn_dataTable table span.expand-dot .icon-Expand').parents('td.actions').find('.btn-dropdown').hide();
		$(this).parents('td.actions').find('.btn-dropdown').show();
		e.stopPropagation();
	}
});

$(document).click(function (e) {
    if (! $(e.target).hasClass('btn-collapse'))
		$('.comn_dataTable table span.expand-dot .icon-Expand').removeClass('btn-collapse');
		$('.comn_dataTable table span.expand-dot .icon-Expand').parents('td.actions').find('.btn-dropdown').hide();
});


$(document).on("click",".comn_dataTable table span.expand-dot a",function(e){
	if($(this).hasClass('btn-collapse')){
		$(this).removeClass('btn-collapse');
		$(this).parents('td.actions').find('.btn-dropdown').hide();
		e.stopPropagation();
	}
	else{
		$('.comn_dataTable table span.expand-dot a').removeClass('btn-collapse');
		$(this).addClass('btn-collapse');
		$('.comn_dataTable table span.expand-dot a').parents('td.actions').find('.btn-dropdown').hide();
		$(this).parents('td.actions').find('.btn-dropdown').show();
		e.stopPropagation();
	}
});
$(document).click(function (e) {
    if (! $(e.target).hasClass('btn-collapse'))
		$('.comn_dataTable table span.expand-dot a').removeClass('btn-collapse');
		$('.comn_dataTable table span.expand-dot a').parents('td.actions').find('.btn-dropdown').hide();
});



if($("#org_list_scroll").length > 0){
	$("#org_list_scroll").mCustomScrollbar({
		theme:"minimal",
		axis:"xy",
		scrollbarPosition: "inside",
		scrollButtons:{ enable: false },
		contentTouchScroll: 20,
		setHeight: '700',
		mouseWheel:{ enable: true } ,
		advanced:{
			autoScrollOnFocus:'input', 
			autoExpandHorizontalScroll:true,
			updateOnContentResize:true,
		},

	});
}   	  

$(document).on("click",".filetree .hitarea",function(e){
  var href=$(this).nextAll("ul"),target=$(href).parents(".mCustomScrollbar");  
  if(target.length){
    e.preventDefault();
    target.mCustomScrollbar("scrollTo",href); 
  }
});

/*Tool Tip Start*/
$(function () {
  $('[data-toggle="tooltip"]').tooltip( { 
	  position :{ my: 'left center', at: 'right+10 center', html: true,
		using: function( position, feedback ) {
		  $( this ).css( position );
		  $( "<div>" )
			.addClass( "arrow" )
			.addClass( feedback.vertical )
			.addClass( feedback.horizontal )
			.appendTo( this );
		}
	  }
  });
})

$.widget("ui.tooltip", $.ui.tooltip, {
    options: {
        content: function () {
            return $(this).prop('title');
        }
    }
});
/*Tool Tip End*/

function milstoneNotesEdit(milestone_id){
	setMilestoneEditNote(milestone_id)
}

$(document).on('click','#milstoneEditModalRestore', function(e){
	//reset browser Back Confirm Alert
	resetBackConfirmAlert();
	
	setMilestoneEditNote($('#inputEditMilstoneId').val());
});

function setMilestoneEditNote(milestone_id){
	rev_submit_loader(true);
	sendGetRequest(APP_URL+'milestone/'+milestone_id+'/notes',function(response){
		if(response.status){
			$('#milestoneEditNotesForm').attr('action',APP_URL+'milestone/'+response.data.id+'/notes');
			$('#inputEditMilstoneId').val(milestone_id);
			$('#inputEditAssignmentId').val(response.data.id);
			$('#inputMilstoneEditNote').val(response.data.notes);
			$('#inputEditMilstoneTitle').val(response.data.title);
			$('#milstoneNotesEdit').modal('show');
			rev_submit_loader(false);
		}
		setTimeout(function(){
			rev_submit_loader(false);
		},500)
	})
}

$(document).on('submit','#milestoneEditNotesForm', function(e){
	e.preventDefault();
    let url = $(this).attr('action');
    $.easyAjax({
        url: url,
        container: "#milestoneEditNotesForm",
        type: "POST",
		disableButton: true,
        redirect: true,
        file: false,
        data: $(this).serialize(),
        messagePosition:'toastr',
    }, function(response){
       if(response.status){
			showMessage(response.message, "success", "toastr");
			$('#milstoneNotesEdit').modal('hide');
			rev_submit_loader(false);
	   }else{
		  showMessage(response.message, "error", "toastr");
	   }
	   setTimeout(function(){
			rev_submit_loader(false);
		},500)
    });
});


$("#inputURLName").bind("paste", function(e){
	catchPaste(e, this, function(pastedUrl) {
		// access the clipboard using the api
		if(pastedUrl.match(/(http(s)?:\/\/.)?(www\.)?[-a-zA-Z0-9@:%._\+~#=]{2,256}\.[a-z]{2,6}\b([-a-zA-Z0-9@:%_\+.~#?&//=]*)/g)){ 
			get_meta_tags(pastedUrl);
		}	
	});
});


function catchPaste(evt, elem, callback) {
  if (navigator.clipboard && navigator.clipboard.readText) {
    // modern approach with Clipboard API
    navigator.clipboard.readText().then(callback);
  } else if (evt.originalEvent && evt.originalEvent.clipboardData) {
    // OriginalEvent is a property from jQuery, normalizing the event object
    callback(evt.originalEvent.clipboardData.getData('text'));
  } else if (evt.clipboardData) {
    // used in some browsers for clipboardData
    callback(evt.clipboardData.getData('text/plain'));
  } else if (window.clipboardData) {
    // Older clipboardData version for Internet Explorer only
    callback(window.clipboardData.getData('Text'));
  } else {
    // Last resort fallback, using a timer
    setTimeout(function() {
      callback(elem.value)
    }, 100);
  }
}


function get_meta_tags(fetchURL){
	$("#inputURLName").prop('disabled', true).val(fetchURL);
	rev_submit_loader(true);	
	var data = "url="+encodeURIComponent(fetchURL);
	$.ajax({
		type: "GET",
		url: APP_URL+'libraries/get_meta_tags',
		data: data,
		dataType: "json",
		success: function(response){
			if(response.status){
				setMetaValue(response.data);
			}
		}
		
	});
}

function setMetaValue(tags){
		
	if($('#inputTitleName').length > 0){
		if(tags.title && tags.title != "" && tags.title != null){
			$('#inputTitleName').val(tags.title);
		}
	}
	
	if($('#inputProviderName').length > 0){
		if(tags.provider && tags.provider != "" && tags.provider != null){
			$('#inputProviderName').val(tags.provider);
		}
	}
	
	if($('#inputDescriptionName').length > 0){
		if(tags.description && tags.description != "" && tags.description != null){
			$('#inputDescriptionName').val(tags.description);
		}
	}
	
	if($('#inputTagsName').length > 0){
		if(tags.keywords && tags.keywords != "" && tags.keywords != null){
			$('#inputTagsName').html('');
			options = [];
			$.each(tags.keywords.split(","),function(kay,val){
				$('#inputTagsName').append('<option value="'+ val +'">'+ val +'</option>');
				options.push(val)	
			});
			$('#inputTagsName').val(options).trigger("change"); 
		}
	}
	
	setTimeout(function(){
		rev_submit_loader(false);
		$("#inputURLName").prop('disabled', false);
	},300)
}

$(document.body).on("change",".select2-search__field",function() {
	$(this).keypress(function (e) {
		var regex = new RegExp(/^[a-zA-Z\s]+$/);
		var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
		if (regex.test(str)) {
			return true;
		}
		else {
			e.preventDefault();
			return false;
		}
	});	
});

$(window).load(function(){
	if($('.comn_dataTable table.dataTable tr td').hasClass('dataTables_empty')){
		$('.comn_dataTable table.dataTable td').parent('tr').css("background", "transparent");
	}
});

if($("#allAssigneesModal .modal-body").length > 0){
	$("#allAssigneesModal .modal-body").mCustomScrollbar({
		theme:"minimal",
		axis:"y", 
		scrollbarPosition: "outside",
		scrollButtons:{ enable: false },
		contentTouchScroll: 20,
		mouseWheel:{ enable: true } ,
		advanced:{
			autoExpandHorizontalScroll:true,
			updateOnContentResize:true,
		},

	});
}   

if($(".addMultipleUser .addMulUserscroll").length > 0){
	$(".addMultipleUser .addMulUserscroll").mCustomScrollbar({ 
		theme:"minimal",
		axis:"y", 
		scrollbarPosition: "outside",
		scrollButtons:{ enable: false }, 
		contentTouchScroll: 20,
		mouseWheel:{ enable: true } ,
		advanced:{
			autoExpandHorizontalScroll:true,
			updateOnContentResize:true,
		},

	});
}  

$(document).ready(function(){
	
	var res = window.location.href.split("/");
	//------ Remove libraries content type start -------
	var lastSegment = window.location.href.substring(window.location.href.lastIndexOf('/') + 1);
	var pos = res.indexOf(lastSegment);
	if(!(lastSegment =='create' && res[pos-1] == 'libraries')){
		localStorage.removeItem('libraryContentType')
	}
	//------ Remove libraries content type end -------
	
	//--- Remove journey list page active tab start -------
	if(window.location.href.lastIndexOf('journeys') == -1 && res[pos-1] != 'groups' && res[pos-1] !='passport'){
		localStorage.removeItem('journeyListActiveTab')
	}
	//--- Remove journey list page active tab end -------
	
	//--- Remove PL journey Assign page active tab start -------
	if(window.location.href.lastIndexOf('journeys') && lastSegment !='assign'){
		localStorage.removeItem('AssignActiveTab')
	}
	//--- Remove PL journey Assign page active tab end -------
});

if($(".UserGroupGrade_Class .addMulUserscroll").length > 0){
	$(".UserGroupGrade_Class .addMulUserscroll").mCustomScrollbar({ 
		theme:"minimal",
		axis:"y", 
		scrollbarPosition: "outside",
		scrollButtons:{ enable: false }, 
		contentTouchScroll: 20,
		mouseWheel:{ enable: true } ,
		advanced:{
			autoExpandHorizontalScroll:true,
			updateOnContentResize:true,
		},

	});
} 

$(document).ready(function () {   
	$('.add-content').on('click', function(){
	if($('.library_drop').is(':visible') == false){
		$('.library_drop').slideToggle(100);
		}
	});		

	$(document).mouseup(function(e) {
		if($('.library_drop').is(':visible') == true){
			if(e.target.offsetParent == null || e.target.className != 'library_drop' && e.target.offsetParent.className != 'library_drop'){
				$('.library_drop').slideToggle(100);
			}
		}
	});
});

function copyLinkModal(url){
	$('#copyLinkInputField').val(url);
	$('#copyLinkModal').modal('show');
}

function downloadCertificate(id, type){
	window.location.href = APP_URL+'certificate_download/'+id+'/'+type;
}

