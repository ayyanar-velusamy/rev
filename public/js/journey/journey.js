var milestoneJourneyId;
var requestUserId = "";
var activeDataTable;
var milestoneContentTypeId ="";
var milstoneRating ="";
var journeyVisibilityValue = "";
var journeyReadValue = "";
var breakDownCateory = "user";
var listTabReset = false;
var getMilestonePostData = {};
var milestoneListType = "";
var myLearningjourneyManagementTable,prdefinedLearningjourneyManagementTable,assignedLearningJourneyManagementTable,journeyMilestoneTable,assignedMilestoneTable,predefinedMilestoneTable, passportMilestoneTable;
var breakdownpage_width;
var filterByAssignedBy, filterByCompletedDate, filterByCreatedDate, filterByJourneyId, filterByMilestoneCount, filterByReadOption, filterByCreatedBy, filterByTotalAssignee, filterByActiveAssignee, filterByAssignedTo, filterByGroupId, filterByAssignedType;

function setMilestoneJourneyId(id, visibility, journey_type_id, read){
    milestoneJourneyId		= id;
	journeyVisibilityValue 	= visibility;
	journeyReadValue 		= read;
	$('#addMilestoneModalBtn').attr('onclick',"addMilestone('"+id+"','"+visibility+"','"+journey_type_id+"','"+read+"')");
	$('#milestoneJourneyId').val(id);	
	$('#journeyPrimaryId').val(id);	
}

//function set active tab datatable list
function journeyMainTapChange(active_list){
   if(activeDataTable !== active_list){
	   activeDataTable = active_list;	   
	   journeyListFilter(activeDataTable);
	   listTabReset = true;	   
	   resetDataTableFilter();
	   triggerActiveDataTable();	
   }	  
}

//function Initial/draw active tab datatable
function triggerActiveDataTable(){
	if(activeDataTable == 'my_journey'){
		myLearningjourneyManagement()
	}else if(activeDataTable == 'predefined_journey'){
		prdefinedLearningjourneyManagement()
	}else{
		assignedLearningJourneyManagement()
	}
}

//function Initial/draw active page milestone datatable list
function render_milestone_list(){
	$('#milstoneAdd').modal('hide');			  			  
	if($('#assignedMilestoneList').length > 0){		
		assignedMilestoneManagement();		
	}else if($('#prdefinedMilestoneList').length > 0){
		predefinedMilestoneManagement();
	}else if($('#backfillMilestoneList').length > 0){
		backfillMilestoneManagement();
	}else if($('#passportMilestoneList').length > 0){
		passportMilestoneManagement();
	}else{
		journeyMilestoneManagement();
	}	
		
	journeyBreakDown(milestoneJourneyId);
}

//function to journey type by journey 
$(document).on('change','#inputJourneyTypeName',function(){
	if($(this).val() == 2){
		$('.inputJourneyVisibility label span').hide();
		$('.plj_visibility').removeClass('d-none');
		$('.inputJourneyVisibility').addClass('d-none');
		$('.inputJourneyVisibility #inputJourneyVisibilityName').val('Public').trigger('change');
		//$('#inputJourneyVisibilityName').attr('readonly',true);
		$('#inputJourneyVisibilityName').prop('selectedIndex',2).trigger('change');
		$('.inputCompulOpt').removeClass('d-none');
		$('table.milestoneAddedTable').attr('id','prdefinedMilestoneList');
		$('.page-head ul li#journeyNameBreadcrumb a').text('Predefined Learning Journey List');
		
		//destroy MLJ milestone list
		if (journeyMilestoneTable instanceof $.fn.dataTable.Api) {
			journeyMilestoneTable.destroy();
			journeyMilestoneTable = "";
		}
		
		//Render PLJ milestone list 
		predefinedMilestoneManagement();
	}else{
		$('.inputJourneyVisibility label span').show();
		$('#inputJourneyVisibilityName').attr('readonly',false);
		$('.plj_visibility').addClass('d-none');
		$('.inputJourneyVisibility').removeClass('d-none');
		$('#inputJourneyVisibilityName').prop('selectedIndex',0).trigger('change');
		$('.inputCompulOpt').addClass('d-none');
		$('table.milestoneAddedTable').attr('id','journeyMilestoneList');
		$('.page-head ul li#journeyNameBreadcrumb a').text('My Learning Journey List');
		
		//destroy PLJ milestone list
		if (predefinedMilestoneTable instanceof $.fn.dataTable.Api) {
			predefinedMilestoneTable.destroy();
			predefinedMilestoneTable = "";
		}
				
		//Render MLJ milestone list
		journeyMilestoneManagement();
	};
	$('#inputJourneyVisibilityName-error').hide();	
});

//function to filter by journey 
$(document).on('change','.filterByJourneyId',function(){
	filterByJourneyId = $(this).val();
	if(filterByJourneyId != "" || !listTabReset)
	triggerActiveDataTable();
})

//function to filter by milestone count 
$(document).on('change','.filterByMilestoneCount',function(){
	filterByMilestoneCount = $(this).val();
	if(filterByMilestoneCount != "" || !listTabReset)
	triggerActiveDataTable();
})

//function to filter by assigned by
$(document).on('change','.filterByAssignedBy',function(){
	filterByAssignedBy = $(this).val();
	if(filterByAssignedBy != "" || !listTabReset)
	triggerActiveDataTable();
})

//function to filter by created by
$(document).on('change','.filterByCreatedBy',function(){
	filterByCreatedBy = $(this).val();
	if(filterByCreatedBy != "" || !listTabReset)
	triggerActiveDataTable();
})

//function to filter by created by
$(document).on('change','.filterByTotalAssignee',function(){
	filterByTotalAssignee = $(this).val();
	if(filterByTotalAssignee != "" || !listTabReset)
	triggerActiveDataTable();
})

//function to filter by created by
$(document).on('change','.filterByActiveAssignee',function(){
	filterByActiveAssignee = $(this).val();
	if(filterByActiveAssignee != "" || !listTabReset)
	triggerActiveDataTable();
})

//function to filter by assigned to
$(document).on('change','.filterByAssignedTo',function(){
	filterByAssignedTo = $(this).val();
	if(filterByAssignedTo != "" || !listTabReset)
	triggerActiveDataTable();
})

//function to filter by group
$(document).on('change','.filterByGroupId',function(){
	filterByGroupId = $(this).val();
	if(filterByGroupId != "" || !listTabReset)
	triggerActiveDataTable();
})

//function to filter by group
$(document).on('change','.filterByAssignedType',function(){
	filterByAssignedType = $(this).val();
	if(filterByAssignedType != "" || !listTabReset)
	triggerActiveDataTable();
})


//function to filter by created date 
$(document).on('change','.filterByCreatedDate',function(){
	filterByCreatedDate = $(this).val();	
	if(filterByCreatedDate != "" || !listTabReset)
	triggerActiveDataTable();
})

//function to filter by complete date 
$(document).on('change','.filterByCompletedDate',function(){
	filterByCompletedDate = $(this).val();
	if(filterByCompletedDate != "" || !listTabReset)
	triggerActiveDataTable();
})

//function to filter by read option
$(document).on('change','.filterByReadOption',function(){
	filterByReadOption = $(this).val();	
	if(filterByReadOption != "" || !listTabReset)
	triggerActiveDataTable();
})

$(document).ready(function(){
	if($('.journey_content .white-box').length > 0){
		breakdownpage_width = $('.journey_content .white-box').width(); 
	}
	//Remove milestone count dropdown duplicates
	removeDuplicateOption('#mylearning .filterByJourneyId');
	removeDuplicateOption('#mylearning .filterByMilestoneCount');
	
	removeDuplicateOption('#predefinedlearning .filterByJourneyId');
	removeDuplicateOption('#predefinedlearning .filterByMilestoneCount');

	removeDuplicateOption('#assignedlearning .filterByJourneyId');
	removeDuplicateOption('#assignedlearning .filterByAssignedBy ');
	
});

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

$(document).on('change','#inputPaymentTypeName',function(){
	if($(this).val() != 'free'){
		$('.paymentTypeSec').removeClass('d-none');
	}else{
		$('.paymentTypeSec').addClass('d-none');
	}
});

$(document).on('change','#content_type_id',function(){	
	 $('.inputProviderSec').removeClass('d-none'); 
     $('.inputProviderSec label').text('Provider ').append('<span class="required">*</span>');
	 $('.inputURLSec label').text('URL ').append('<span class="required">*</span>');
	 $('#inputProviderName').attr('placeholder','Enter Provider');
	 
	 if($(this).val() > 1 && $(this).val() < 6){
		var lengthTxt = providerTxt = "";		
		$('.inputLengthSec').removeClass('d-none');				
		if($(this).val() == 2 || $(this).val() == 3){
			lengthTxt = "(minutes) ";
			if($(this).val() == 3){
				providerTxt = "Episode Name ";
			}
		}
		
		if($(this).val() == 4){
		$('.inputURLSec label span').remove();
		  lengthTxt = "(pages) ";
		  providerTxt = "Author ";
		}
		
		if($(this).val() == 5){
			lengthTxt = "(hours) ";
			providerTxt = "Provider Name ";
		}
		
		if(lengthTxt != ""){
			$('.inputLengthSec label').text('Length '+lengthTxt);
			$('#inputLengthName').attr('placeholder','Enter Length '+lengthTxt);
		}
		
		if(providerTxt != ""){
			$('.inputProviderSec label').text(providerTxt).append('<span class="required">*</span>');
		    $('#inputProviderName').attr('placeholder','Enter '+providerTxt);
		}			
	 }else{		
		$('.inputLengthSec').addClass('d-none');
		if($(this).val() == 6){
			$('.inputProviderSec').addClass('d-none');
		}	
	 }
})


function addMilestone(journey_id, visibility, journey_type_id, read){	
	
	milestoneContentTypeId = "";
	setMilestoneJourneyId(journey_id, visibility, journey_type_id, read);
	getMilestonePostData = {};
	getMilestonePostData['journey_id'] = journey_id;
	getMilestonePostData['visibility'] = visibility;
	getMilestonePostData['journey_type_id'] = journey_type_id;
	getMilestonePostData['read'] = read;
	if($('#journeyPrimaryId').val() == ""){
		if($('#saveType').length > 0){
			$('#saveType').val('milestone')
		}	
		if($('#journeyAddForm').length > 0){
			$('#journeyAddForm').submit();
		}
		return false;
	}
	$("input:radio[class^=milestoneContentType]").each(function(i) {
        $(this).attr('checked',false);
    });	
	$('#milstoneContentTypeAdd').modal('show');	
}

$(document).on('change','.milestoneContentType',function(){
	milestoneContentTypeId = $(this).val();	
	if(milestoneContentTypeId != ""){
		$('#contentTypeId').val(milestoneContentTypeId);
		$('#content_type_id').prop('selectedIndex',milestoneContentTypeId).trigger("change");
		$('#milstoneContentTypeAdd').modal('hide');
		$('#loadMilstoneAddModal').html('');
		setTimeout(function(){
			$('#milstoneAdd').modal('show');
		},500)
		getMilestonePostData['content_type_id'] = milestoneContentTypeId;
		getMilestonePostData['action'] = 'add';
		getMilestoneDetail("");
	}
});

function loadAssignedViewMilestone(milestone_id){
	$('#loadMilstoneAddModal').html('');
	$('#milstoneAdd').modal('show');
	getAssigndMilestoneDetail(milestone_id)
}
	
function loadViewMilestone(milestone_id){
	$('#loadMilstoneAddModal').html('');
	$('#milstoneAdd').modal('show');
	getMilestonePostData = {};
	getMilestonePostData['action'] = 'view';
	getMilestoneDetail(milestone_id);
}

function loadEditMilestone(milestone_id){
	$('#loadMilstoneAddModal').html('');
	$('#milstoneAdd').modal('show');
	getMilestonePostData = {};
	getMilestonePostData['action'] = 'edit';
	getMilestoneDetail(milestone_id);
}


function getAssigndMilestoneDetail(id){
	rev_submit_loader(true);
	getMilestonePostData = {};
	getMilestonePostData['action'] = 'view';
	getMilestonePostData['category'] = (window.location.href.indexOf("assigned") > -1) ? 'owner':'user';
	sendGetHtmlRequest(APP_URL+'milestone_detail/'+id+'/'+requestUserId,getMilestonePostData,function(response){
		$('#loadMilstoneAddModal').html(response);
		getMilestonePostData = {};
		setTimeout(function () {
			rev_submit_loader(false);
		},500);
	});
}

function getMilestoneDetail(id){
	rev_submit_loader(true);
	getMilestonePostData['category'] = (window.location.href.indexOf("assigned") > -1) ? 'owner':'user';
	sendGetHtmlRequest(APP_URL+'milestone/'+id,getMilestonePostData,function(response){
		$('#loadMilstoneAddModal').html(response);
		getMilestonePostData = {};
		setTimeout(function () {
			rev_submit_loader(false);
		},500);
	});
}

function loadViewBackfillMilestone(milestone_id){
	$('#loadPassportMilstoneAddModal').html('');
	$('#milstoneAdd').modal('show');
	getMilestonePostData = {};
	getMilestonePostData['action'] = 'view';
	getBackfillMilestoneDetail(milestone_id);
}

function loadEditBackfillMilestone(milestone_id){
	$('#loadPassportMilstoneAddModal').html('');
	$('#milstoneAdd').modal('show');
	getMilestonePostData = {};
	getMilestonePostData['action'] = 'edit';
	getBackfillMilestoneDetail(milestone_id);
}


function getBackfillMilestoneDetail(id){
	rev_submit_loader(true);
	sendGetHtmlRequest(APP_URL+'get_backfill_milestone/'+id,getMilestonePostData,function(response){
		$('#loadPassportMilstoneAddModal').html(response);
		getMilestonePostData = {};
		setTimeout(function () {
			rev_submit_loader(false);
		},500);
	});
}

$(document).on('click','#markAsCompleteBtn',function(){
	$('#ratingMilestoneId').val($('#MilestoneId').val());
	$('#milstoneAdd').modal('hide');
	$('#ratingID').val('');
	//removing ration from all the following stars
    $(".btnrating").removeClass("rated");
	$(".btnrating").removeAttr("data-selected");
	
	setTimeout(function () {
	  $('#milstoneRatingAdd').modal('show'); 
	}, 500);
	
});

$(document).on('click','#journeyFormSubmit',function(){
	$('#addJourneyStatus').val('draft');
})

$(document).on('click','#journeyFormSaveBtn',function(){
	$('#addJourneyStatus').val('active');	
	if($('#journeyAddForm').length > 0){
		//Add page form
		$('#journeyAddForm').submit();
	}else{
		//Edit page form
		$('#journeyUpdateForm').submit();
	}
});

//Function to load the Journey Break Down 
function journeyBreakDown(journey_id){
	if($('#journeyBreakDown').length > 0){
		if(journey_id != ""){
			var category = (window.location.href.indexOf("assigned") > -1) ? 'owner':'user'
			if(category == 'owner'){
				$('#journeyBreakDown').load(APP_URL+'journeys/break_down/'+journey_id+'/'+category+'/'+milestoneListType);
			}else{
				$('#journeyBreakDown').load(APP_URL+'journeys/break_down/'+journey_id+'/'+category+'/'+requestUserId);
			}
		}
	}
}

//Function to load the Journey List Filter 
function journeyListFilter(journey_list){
	if($('#'+journey_list).length > 0){
		$('#'+journey_list).load(APP_URL+'journeys/'+journey_list+'/filter');
	}
}

$(document).on('submit','form',function(e){
	//return false;
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
		   getMilestonePostData = {};
		   if(response.action){
			   setJourneyAction(response);
		   }		
		   if(response.journey_id){
			   setJourneyUrl(response);
		   }
		   if(response.milestone){
			  render_milestone_list();			 
		   }		   
		   if(response.rating){			   
			 $('#milstoneRatingAdd').modal('hide');
			 journeyBreakDown(response.reting_journey_id);
			 render_milestone_list();			 
		   }	   
	   }else{
		  showMessage(response.message, "error", "toastr");
	   }
	   
	   if(response.journey_status){
		  //Hide save as draft button
		  if(response.journey_status == 'active'){
			$('#journeyFormSaveBtn').addClass('active');
			$('#journeyFormSubmit').addClass('d-none');
		  }			 
	   }
	   
	   if(response.save_type){
		  //Hide save as draft button
		  if(response.save_type == 'milestone'){			  
			addMilestone(response.journey_id, response.visibility, response.journey_type_id,response.read)
		  }			 
	   }
	   
    });
  }
});

function setJourneyAction(response){
	if(response.action == 'journey_duplicate'){
		$('#predefinedJourneyDuplicateModal').modal('hide');
		triggerActiveDataTable();
	}	
}

function displaySaveBtn(){	
	if($('.milestoneAddedTable').length > 0){
		$('#saveType').val('');
		//Show/Hide Save button based on the milestone coutn
		if( $('.milestoneAddedTable').find('.dataTables_empty').length > 0){
			$('#journeyFormSaveBtn').addClass('d-none');
		}else{
			$('#journeyFormSaveBtn').removeClass('d-none');
		}
		
		//Show if milestone list empty and journey in active status
		if($('#journeyFormSaveBtn').hasClass('active')){
			$('#journeyFormSaveBtn').removeClass('d-none');
		}
	}
}

function journeyAllAssignees(journey_id, journey_type_id){
	//alert(journey_id);
	$('#allAssigneeModalTitle').text('All Assignees');
	$('#allAssigneesModal').modal('show');
	rev_submit_loader(true);
	sendGetRequest(APP_URL+'journeys/'+journey_id+'/all_assignee', function (response) {
        if(response.status) {
			//showMessage(response.message, "success", "toastr");
			setAssignedJourneyAssigee(response.data);
        }
		rev_submit_loader(false);
    });	
}

function journeyTotalAssignees(journey_id, journey_type_id){
	$('#allAssigneeModalTitle').text('Total Assignees');
	$('#allAssigneesModal').modal('show');
	rev_submit_loader(true);
	sendGetRequest(APP_URL+'journeys/'+journey_id+'/total_assignee', function (response) {
        if(response.status) {
			//showMessage(response.message, "success", "toastr");
			setPredifinedJourneyAssigee(response.data);
        }
		rev_submit_loader(false);
    });	
}

function setAssignedJourneyAssigee(data){
	if(data != "" && data != null){
		$('#allAssigneesTableScroll').html('');
		$('#allAssigneesTableScroll').append('<div class="row table_head"><div class="col-md-4">Assignee Name</div><div class="col-md-5 p-0">Assignee status of the journey</div> <div class="col-md-3 text-center">Action</div> </div>');
		$.each(data,function(key,user){
		$('#allAssigneesTableScroll').append('<div class="row table_body"> <div class="col-md-4"><span class="maxname">'+ user.name +'</span></div><div class="col-md-5"><span>' + user.complete_percentage + '%</span></div> <div class="col-md-3 btns text-center"><a href="' + APP_URL + 'peers/passport/'+ user.encrpted_id + '" title="View Passport" class="btn btn-blue">View Passport</a></div> </div>'); }); 
	}
}

function setPredifinedJourneyAssigee(data){
	if(data != "" && data != null){
		$('#allAssigneesTableScroll').html('');
		$('#allAssigneesTableScroll').append('<div class="row table_head"> <div class="col-md-6">Assignee Name</div> <div class="col-md-6 text-center">Action</div> </div>');
		$.each(data,function(key,user){
		$('#allAssigneesTableScroll').append('<div class="row table_body"> <div class="col-md-6"><span class="maxname">' + user.name + '</span></div> <div class="col-md-6 btns text-center"><a href="' + APP_URL + 'peers/passport/' + user.encrpted_id + '"title="View Passport" class="btn btn-blue">View Passport</a></div> </div>');}); 
	}
}

function deleteJourney(journey_id, name) {	
	var data = {
		_token:$('meta[name="csrf-token"]').attr('content'),
		_method:'DELETE',
		journey_id:journey_id,
		name:name,
		title:'Delete Journey',
		content:'you want to delete the following journey?'
	};
	commonConfirm(data, delete_journey);
}

function deleteMyLearningJourney(journey_id, type, type_ref_id, name) {

	var data = {
		_token:$('meta[name="csrf-token"]').attr('content'),
		_method:'DELETE',
		journey_id:journey_id,
		type:type,
		type_ref_id:type_ref_id,
		name:name,
		title:'Delete Journey',
		content:'you want to delete the following journey?'
	};	
	
	commonConfirm(data, delete_journey);
}

function deleteAssignedJourney(journey_id, type, type_ref_id, name) {
	
	var data = {
		_token:$('meta[name="csrf-token"]').attr('content'),
		_method:'POST',
		journey_id:journey_id,
		type:type,
		type_ref_id:type_ref_id,
		name:name,
		title:'Delete Journey',
		content:'you want to delete the following journey?'
		};		
	commonConfirm(data, delete_assigned_journey);
}

function deleteMilestone(milestone_id, type, type_ref_id, name) {
	
	var data = {
		_token:$('meta[name="csrf-token"]').attr('content'),
		_method:'DELETE',
		milestone_id:milestone_id,
		type:type,
		type_ref_id:type_ref_id,
		name:name,
		title:'Delete Milestone',
		content:'you want to delete the following milestone?'
	};		
	commonConfirm(data, delete_milestone);
}

function revokeJourney(journey_id, type, type_ref_id, name) {
	
	var data = {
		_token:$('meta[name="csrf-token"]').attr('content'),
		_method:'POST',
		journey_id:journey_id,
		type:type,
		type_ref_id:type_ref_id,
		name:name,
		title:'Revoke Journey',
		content:'you want to revoke the following journey?'
	};		
	commonConfirm(data, revoke_journey);
}

function revokeMilestone(milestone_id, type, type_ref_id, name) {
	
	var data = {
		_token:$('meta[name="csrf-token"]').attr('content'),
		_method:'POST',
		milestone_id:milestone_id,
		type:type,
		type_ref_id:type_ref_id,
		name:name,
		title:'Revoke Milestone',
		content:'you want to revoke the following milestone?'
		};		
	commonConfirm(data, revoke_milestone);
}

function ignoreMyLearningJourney(journey_id, type, type_ref_id, name) {
	
	var data = {
		_token:$('meta[name="csrf-token"]').attr('content'),
		_method:'POST',
		journey_id:journey_id,
		type:type,
		type_ref_id:type_ref_id,
		name:name,
		title:'Ignore Journey',
		content:'you want to ignore the following journey?'
	};		
	commonConfirm(data, ignore_journey);
}

function unignoreMyLearningJourney(journey_id, type, type_ref_id, name) {
	
	var data = {
		_token:$('meta[name="csrf-token"]').attr('content'),
		_method:'POST',
		journey_id:journey_id,
		type:type,
		type_ref_id:type_ref_id,
		name:name,
		title:'Unignore Journey',
		content:'you want to unignore the following journey?'
	};		
	commonConfirm(data, unignore_journey);
}



function ignoreMilestone(milestone_id, type, type_ref_id, name) {
	
	var data = {
		_token:$('meta[name="csrf-token"]').attr('content'),
		_method:'POST',
		milestone_id:milestone_id,
		type:type,
		type_ref_id:type_ref_id,
		name:name,		
		title:'Ignore Milestone',
		content:'you want to ignore the following milestone?'
	};		
	commonConfirm(data, ignore_milestone); 
}


function unignoreMilestone(milestone_id, type, type_ref_id, name) {
	
	var data = {
		_token:$('meta[name="csrf-token"]').attr('content'),
		_method:'POST',
		milestone_id:milestone_id,
		type:type,
		type_ref_id:type_ref_id,
		name:name,		
		title:'Unignore Milestone',
		content:'you want to unignore the following milestone?'
	};		
	commonConfirm(data, unignore_milestone); 
}



function delete_journey(data, callback) {
    sendPostRequest(APP_URL+'journeys/'+data.journey_id, data, function (response) {
        if (response.status) {
			journeyListFilter(activeDataTable);
			triggerActiveDataTable();
            showMessage(response.message, "success", "toastr");
        }else{
			showMessage(response.message, "error", "toastr");
		}
		callback();
    });
}

function delete_assigned_journey(data, callback) {
    sendPostRequest(APP_URL+'journeys/assigned/'+data.journey_id+'/delete', data, function (response) {
        if (response.status) {
			journeyListFilter(activeDataTable);
			triggerActiveDataTable();
            showMessage(response.message, "success", "toastr");
        }else{
			showMessage(response.message, "error", "toastr");
		}
    callback();
    });
}

function delete_milestone(data, callback) {
    sendPostRequest(APP_URL+'delete_milestone/'+data.milestone_id, data, function (response) {
        if (response.status) {
			render_milestone_list();
			journeyBreakDown(milestoneJourneyId);
            showMessage(response.message, "success", "toastr");
        }else{
			showMessage(response.message, "error", "toastr");
		}
    callback();
    });
}

function revoke_journey(data, callback) {
    sendPostRequest(APP_URL+'journeys/'+data.journey_id+'/revoke', data, function (response) {
        if (response.status) {
			journeyListFilter(activeDataTable);
			triggerActiveDataTable();
            showMessage(response.message, "success", "toastr");
        }else{
			showMessage(response.message, "error", "toastr");
		}
    callback();
    });
}

function ignore_journey(data, callback) {
    sendPostRequest(APP_URL+'journeys/'+data.journey_id+'/ignore', data, function (response) {
        if (response.status) {
			triggerActiveDataTable();
            showMessage(response.message, "success", "toastr");
        }else{
			showMessage(response.message, "error", "toastr");
		}
    callback();
    });
}

function unignore_journey(data, callback) {
    sendPostRequest(APP_URL+'journeys/'+data.journey_id+'/unignore', data, function (response) {
        if (response.status) {
			triggerActiveDataTable();
            showMessage(response.message, "success", "toastr");
        }else{
			showMessage(response.message, "error", "toastr");
		}
    callback();
    });
}

function revoke_milestone(data, callback) {
    sendPostRequest(APP_URL+'milestone/'+data.milestone_id+'/revoke', data, function (response) {
        if (response.status) {
			render_milestone_list();
            showMessage(response.message, "success", "toastr");
        }else{
			showMessage(response.message, "error", "toastr");
		}
    callback();
    });
}

function ignore_milestone(data, callback) {
    sendPostRequest(APP_URL+'milestone/'+data.milestone_id+'/ignore', data, function (response) {
        if (response.status) {
			render_milestone_list();
            showMessage(response.message, "success", "toastr");
        }else{
			showMessage(response.message, "error", "toastr");
		}
    callback();
    });
}

function unignore_milestone(data, callback) {
    sendPostRequest(APP_URL+'milestone/'+data.milestone_id+'/unignore', data, function (response) {
        if (response.status) {
			render_milestone_list();
            showMessage(response.message, "success", "toastr");
        }else{
			showMessage(response.message, "error", "toastr");
		}
    callback();
    });
}



function duplictePredefinedJourney(journey_id){
	$('#duplicate_journey_id').val(journey_id);
	$('.duplicate_field input').val('');
	$('#predefinedJourneyDuplicateModal').modal('show');
	$("span.error, div.error, .org-error").hide();		
	$(".form-control").removeClass('error');
	
	// var data = {
			// _token:$('meta[name="csrf-token"]').attr('content'),
			// _method:'POST',
			// journey_id:journey_id,
			// journey_name:"Test",
		// };		
	// sendPostRequest(APP_URL+'/journeys/'+journey_id+'/duplicate', data, function (response) {
        // if (response.status) {
			// prdefinedLearningjourneyManagementTable.draw();
            // showMessage(response.message, "success", "toastr");
        // }else{
			// showMessage(response.message, "error", "toastr");
		// }
    // });	
}


function addToMyJourney(journey_id){
	$('#loadAddMyLearningJourneyModal').load(APP_URL+'journeys/add_to/'+journey_id, function(){
		$('#addMyLearningJourneyModal').modal('show');
	});
}

$( function() {
  $(".datepicker").datepicker({
	   dateFormat: 'M d, yy',
	   minDate: new Date()
  });
});

if($('#end_date').length > 0){
	$('#end_date').on('change', function(evt){
		$(this).valid();
	});
}

if($('#milstoneAdd .milstoneGrid .select2.form-control').length > 0){
	$('#milstoneAdd .milstoneGrid .select2.form-control').on('change', function(evt){
		$(this).valid();
	});
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

$('.comiseo-daterangepicker-triggerbutton').on('mouseenter', function() {
	var value = $(this).text();
	$(this).attr('title', value);
	//console.log(value); 
});

$('.comiseo-daterangepicker-buttonpanel button').on('click', function() {
	var btnTxt = $(this).text();
	if(btnTxt =='Clear'){
		triggerActiveDataTable();
	}
});

function resetDataTableFilter(){
	filterByAssignedBy = filterByCompletedDate = filterByCreatedDate = filterByJourneyId = filterByMilestoneCount = filterByReadOption = filterByCreatedBy = filterByTotalAssignee = filterByActiveAssignee = filterByAssignedTo = filterByGroupId = filterByAssignedType = "";
	$('.filterByJourneyId').prop('selectedIndex',0).trigger('change').val("");
	$('.filterByMilestoneCount').prop('selectedIndex',0).trigger('change').val("");
	$('.filterByAssignedBy').prop('selectedIndex',0).trigger('change').val("");
	$('.filterByCreatedBy').prop('selectedIndex',0).trigger('change').val("");
	$('.filterByTotalAssignee').prop('selectedIndex',0).trigger('change').val("");
	$('.filterByActiveAssignee').prop('selectedIndex',0).trigger('change').val("");
	$('.filterByAssignedTo').prop('selectedIndex',0).trigger('change').val("");
	$('.filterByReadOption').prop('selectedIndex',0).trigger('change').val("");
	$('.filterByGroupId').prop('selectedIndex',0).trigger('change').val("");
	$('.filterByAssignedType').prop('selectedIndex',0).trigger('change').val("");
	$('.filterByCreatedDate').val("");
	$('.filterByCompletedDate').val("");
	$(".daterangepicker").daterangepicker("clearRange");
	listTabReset = false;
}

function myLearningjourneyManagement(){
	
	if(typeof myLearningjourneyManagementTable != "undefined" && myLearningjourneyManagementTable != ""){
		myLearningjourneyManagementTable.draw();
		return true;
	} 
	
	myLearningjourneyManagementTable = $('#myLearningJourneyList').DataTable({
		"processing": true,
		"dom": '<"top">rt<"bottom"ilp><"clear">',
		"lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
		"serverSide": true,
		"scrollX": false,
		"searching": true,
		"ajax": {
			"url": APP_URL+"journey_list",
			"data": function ( d ) {
				d.table_name 		= "myLearningJourneyList";
				d.assigned_by 		= filterByAssignedBy;
				d.completed_date 	= filterByCompletedDate;
				d.created_date 		= filterByCreatedDate;
				d.journey_name 		= filterByJourneyId;
				d.milestone_count 	= filterByMilestoneCount;
				d.read 				= filterByReadOption;
			},
		},
		"columns": [
			{data: 'journey_name', name: 'journey_name'},
			{data: 'milestone_count', name: 'milestone_count'},
			{data: 'assigned_by', name: 'assigned_by'},
			{data: 'created_at', name: 'created_at'},
			{data: 'completed_date', name: 'completed_date'},
			//{data: 'visibility', name: 'visibility'},
			{data: 'read', name: 'read'},
			{data: 'progress', name: 'progress'},
			{data: 'tags', name: 'tags'},
			{data: 'action'}
		],
		"createdRow": function ( row, data, index ) {			
			$('td', row).eq(0).html("<span class='maxname'>" + $('<div/>').html(data['journey_name']).text() + "</span>");
			$('td', row).eq(2).html("<span class='maxname'>" + data['assigned_by'] + "</span>");
			if(data.status == 'Inactive'){
				$(row).find('td').addClass("table_row_disabled").css({"background-color": '#fbfbfb', "opacity":"0.5"});
				$(row).find('td .btn').css({"color": '#ffffff'});
			}
		},		
		"columnDefs": [
			{ className: "journey_name", "targets": [ 0 ] },
			{ className: "milestone_count", "targets": [ 1 ] },
			{ className: "journy_optional", "targets": [ 5 ] },
			{ className: "created_date", "targets": [ 3 ] },
			{ className: "completed_date", "targets": [ 4 ] },
			{ className: "progressper text-center", "targets": [ 6 ] },
			{ searchable: true, visible: false, "targets": [ 7 ] },
			{ className: "actions action_btn", "orderable": false, "width": "21%", "targets": [ 8 ] }
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


function prdefinedLearningjourneyManagement(){
	
	if(typeof prdefinedLearningjourneyManagementTable != "undefined" && prdefinedLearningjourneyManagementTable != ""){
		prdefinedLearningjourneyManagementTable.draw();
		return true;
	} 
	
	prdefinedLearningjourneyManagementTable = $('#predefinedLearningJourneyList').DataTable({
		"processing": true,
		"dom": '<"top">rt<"bottom"ilp><"clear">',
		"lengthMenu": [[10, 25, 50, 100 , -1], [10, 25, 50, 100, "All"]],
		"serverSide": true,
		"scrollX": false,
		"searching": true,
		"ajax": {
			"url": APP_URL+"journey_list",
			"data": function ( d ) {
				d.table_name = "predefinedLearningJourneyList";
				d.total_assignee 	= filterByTotalAssignee;
				d.active_assignee 	= filterByActiveAssignee;
				d.created_by 		= filterByCreatedBy;
				d.created_date 		= filterByCreatedDate;
				d.journey_name 		= filterByJourneyId;
				d.milestone_count 	= filterByMilestoneCount;
			},
		},
		"columns": [
			{data: 'journey_name', name: 'journey_name'},
			{data: 'milestone_count', name: 'milestone_count'},
			{data: 'created_name', name: 'created_name'},
			{data: 'created_at', name: 'created_at'},
			///{data: 'visibility', name: 'visibility'},
			{data: 'total_assignee', name: 'total_assignee'},
			{data: 'active_assignee', name: 'active_assignee'},
			{data: 'tags', name: 'tags'},
			{data: 'action'},
			{data: 'dummy_total_assignee', name: 'dummy_total_assignee'}
		],	
		"createdRow": function ( row, data, index ) {
			$('td', row).eq(0).html("<span class='maxname'>" + $('<div/>').html(data['journey_name']).text() + "</span>");
			$('td', row).eq(2).html("<span class='maxname'>" + $('<div/>').html(data['created_name']).text() + "</span>");
			$('td', row).eq(4).html("<span class='maxname'>" + $('<div/>').html(data['total_assignee']).text() + "</span>");
		},			
		"columnDefs": [
			{ searchable: true, visible: false, "targets": [ 6,8 ] },
			{ className: "journey_name", "targets": [ 0 ] },
			{ className: "milestone_count", "targets": [ 1 ] },
			{ className: "created_by", "targets": [ 2 ] },
			{ className: "created_date", "targets": [ 3 ] },
			{ className: "total_assignee", iDataSort:8, "targets": [ 4 ] },
			{ className: "active_assignee", "targets": [ 5 ] },
			{ className: "actions action_btn", "orderable": false, "targets": [ 7 ] }
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

function assignedLearningJourneyManagement(){
	
	if(typeof assignedLearningJourneyManagementTable != "undefined" && assignedLearningJourneyManagementTable != ""){
		assignedLearningJourneyManagementTable.draw();
		return true;
	}
	
	assignedLearningJourneyManagementTable = $('#assignedLearningJourneyList').DataTable({
		"processing": true,
		"dom": '<"top">rt<"bottom"ilp><"clear">',
		"lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
		"serverSide": true,
		"scrollX": false,
		"searching": true,
		"ajax": {
			"url": APP_URL+"journey_list",
			"data": function ( d ) {
				d.table_name = "assignedLearningJourneyList";
				d.assigned_by 		= filterByAssignedBy;
				d.created_date 		= filterByCreatedDate;
				d.journey_name 		= filterByJourneyId;
				d.read 				= filterByReadOption;
				d.assigned_to 		= filterByAssignedTo;
				d.group_id	 		= filterByGroupId;
				d.assignment_type	= filterByAssignedType;
			},
		},
		"columns": [
			{data: 'journey_name', name: 'journey_name'},
			{data: 'assigned_date', name: 'assigned_date'},
			{data: 'assignment_type', name: 'assignment_type'},
			{data: 'assigned_by', name: 'assigned_by'},
			{data: 'assigned_to', name: 'assigned_to'},
			{data: 'read', name: 'read'},
			{data: 'progress', name: 'progress'},
			{data: 'tags', name: 'tags'},
			{data: 'action'}
		],	
		"createdRow": function ( row, data, index ) {
			$('td', row).eq(0).html("<span class='maxname'>" + $('<div/>').html(data['journey_name']).text() + "</span>");
			$('td', row).eq(4).html("<span class='maxname'>" + $('<div/>').html(data['assigned_to']).text() + "</span>");
		},
		"columnDefs": [
			{ searchable: true, visible: false, "targets": [ 7 ] },
			{ className: "journey_name  text-center", "targets": [ 0 ] },
			{ className: "journey_name  text-center", "targets": [ 5 ] },
			{ className: "text-center", "targets": [ 6 ] },
			{ className: "actions action_btn nowrap", "orderable": false, "width": "20%", "targets": [ 8 ] }
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


function journeyMilestoneManagement(){
	
	if(typeof journeyMilestoneTable != "undefined" && journeyMilestoneTable != ""){
		journeyMilestoneTable.draw();
		return true;
	}	
	
	journeyMilestoneTable = $('#journeyMilestoneList').DataTable({
		"processing": true,
		"dom": '<"top">rt<"bottom"ilp><"clear">',
		"lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
		"serverSide": true,
		"scrollX": false,
		"searching": true,
		"bPaginate": false,
		"bLengthChange": false,
		"bFilter": true,
		"bInfo": false,
		"ajax": {
			"url": APP_URL+"milestone_list",
			"data": function ( d ) {
				d.table_name = "journeyMilestoneList";
				d.journey_id = milestoneJourneyId;
			},
		},
		"drawCallback": function( settings ) {
			displaySaveBtn();
		},
		"columns": [
			{data: 'milestone_name', name: 'milestone_name'},
			{data: 'milestone_type', name: 'milestone_type'},
			{data: 'days_left', name: 'days_left'},
			{data: 'read', name: 'read'},
			{data: 'visibility', name: 'visibility'},
			{data: 'action'}
		],
		"createdRow": function ( row, data, index ) {
			$('td', row).eq(0).html("<span class='maxname'>" + $('<div/>').html(data['milestone_name']).text() + "</span>");
		},
		"order": [[ 2, 'asc' ]],
		"columnDefs": [
			{ visible: false, "targets": [ 4 ] },
			{ className: "compORoptional", "targets": [ 3 ] },
			{ className: "actions action_btn", "orderable": false,"width": "30%", "targets": [ 5 ] }
		],
		language: {
			search: "_INPUT_",
			searchPlaceholder: "Search...",
			sInfo: "Showing _START_ to _END_ of _TOTAL_",
			sInfoEmpty: "Showing 0 to _END_ of _TOTAL_",
			lengthMenu: "Show _MENU_",
			emptyTable: "No Milestones Added",
			"paginate": {
			  "previous": "Prev."
			}
		}
	});
}

function predefinedMilestoneManagement(){
	
	if(typeof predefinedMilestoneTable != "undefined" && predefinedMilestoneTable != ""){
		predefinedMilestoneTable.draw();
		return true;
	}
	
	predefinedMilestoneTable = $('#prdefinedMilestoneList').DataTable({
		"processing": true,
		"dom": '<"top">rt<"bottom"ilp><"clear">',
		"lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
		"serverSide": true,
		"scrollX": false,
		"searching": true,
		"bPaginate": false,
		"bLengthChange": false,
		"bFilter": true,
		"bInfo": false,
		"ajax": {
			"url": APP_URL+"milestone_list",
			"data": function ( d ) {
				d.table_name = "prdefinedMilestoneList";
				d.journey_id = milestoneJourneyId;
			},
		},
		"drawCallback": function( settings ) {
			displaySaveBtn();
		},
		"columns": [
			{data: 'milestone_name', name: 'milestone_name'},
			{data: 'milestone_type', name: 'milestone_type'},
			{data: 'days_left', name: 'days_left'},
			{data: 'read', name: 'read'},
			{data: 'visibility', name: 'visibility'},
			{data: 'action'}
		],
		"createdRow": function ( row, data, index ) {
			$('td', row).eq(0).html("<span class='maxname'>" + $('<div/>').html(data['milestone_name']).text() + "</span>");
		},
		"columnDefs": [
			{ visible: false, "targets": [ 2 ] },
			{ visible: false, "targets": [ 3 ] },
			{ className: "actions action_btn", "orderable": false, "width": "25%", "targets": [ 5 ] }
		],
		language: {
			search: "_INPUT_",
			searchPlaceholder: "Search...",
			sInfo: "Showing _START_ to _END_ of _TOTAL_",
			sInfoEmpty: "Showing 0 to _END_ of _TOTAL_",
			lengthMenu: "Show _MENU_",
			emptyTable: "No Milestones Added",
			"paginate": {
			  "previous": "Prev."
			}
		}
	});
	
}

function assignedMilestoneManagement(){

	if(typeof assignedMilestoneTable != "undefined" && assignedMilestoneTable != ""){
		assignedMilestoneTable.draw();
		return true;
	}

	assignedMilestoneTable = $('#assignedMilestoneList').DataTable({
		"processing": true,
		"dom": '<"top">rt<"bottom"ilp><"clear">',
		"lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
		"serverSide": true,
		"scrollX": false,
		"searching": true,
		"bPaginate": false,
		"bLengthChange": false,
		"bFilter": true,
		"bInfo": false,
		"ajax": {
			"url": APP_URL+"milestone_list",
			"data": function ( d ) {
				d.table_name 		= "assignedMilestoneList";
				d.journey_id		= milestoneJourneyId;
				d.assignment_type 	= milestoneListType;
				d.category 			= (window.location.href.indexOf("assigned") > -1) ? 'owner':'user';
			},
		},
		"order": [[ 2, 'asc' ]],
		"columns": [
			{data: 'milestone_name', name: 'milestone_name'},
			{data: 'milestone_type', name: 'milestone_type'},
			{data: 'days_left', name: 'days_left'},
			{data: 'read', name: 'read'},
			{data: 'visibility', name: 'visibility'},
			{data: 'action'} 
		],
		"createdRow": function ( row, data, index ) {
			$('td', row).eq(0).html("<span class='maxname'>" + $('<div/>').html(data['milestone_name']).text() + "</span>");
		},
		"columnDefs": [
			{ visible: false, "targets": [ 4 ] },
			{ className: "actions action_btn", "orderable": false, "targets": [ 5 ] }
		],
		language: {
			search: "_INPUT_",
			searchPlaceholder: "Search...",
			sInfo: "Showing _START_ to _END_ of _TOTAL_",
			sInfoEmpty: "Showing 0 to _END_ of _TOTAL_",
			lengthMenu: "Show _MENU_",
			emptyTable: "No Milestones Added",
			"paginate": {
			  "previous": "Prev."
			}
		}
	});
}

function passportMilestoneManagement(){
	
	if(typeof passportMilestoneTable != "undefined" && passportMilestoneTable != ""){
		passportMilestoneTable.draw();
		return true;
	}	
	
	passportMilestoneTable = $('#passportMilestoneList').DataTable({
		"processing": true,
		"dom": '<"top">rt<"bottom"ilp><"clear">',
		"lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
		"serverSide": true,
		"scrollX": false,
		"searching": true,
		"bPaginate": false,
		"bLengthChange": false,
		"bFilter": true,
		"bInfo": false,
		"ajax": {
			"url": APP_URL+"milestone_list",
			"data": function ( d ) {
				d.table_name = "passportMilestoneList";
				d.journey_id = milestoneJourneyId;
				d.user_id 	 = requestUserId;
			},
		},
		"drawCallback": function( settings ) {
			displaySaveBtn();
		},
		"columns": [
			{data: 'milestone_name', name: 'milestone_name'},
			{data: 'milestone_type', name: 'milestone_type'},
			{data: 'difficulty', name: 'difficulty'},
			{data: 'points_earned', name: 'points_earned'},
			{data: 'rating', name: 'rating'},
			{data: 'action'}
		],
		"createdRow": function ( row, data, index ) {
			$('td', row).eq(0).html("<span class='maxname'>" + $('<div/>').html(data['milestone_name']).text() + "</span>");
		},
		"order": [[ 2, 'asc' ]],
		"columnDefs": [
			{ className: "text-center", "targets": [ 3 ] },
			{ className: "text-center", "targets": [ 4 ] },
			{ className: "actions action_btn", "orderable": false,"width": "30%", "targets": [ 5 ] }
		],
		language: {
			search: "_INPUT_",
			searchPlaceholder: "Search...",
			sInfo: "Showing _START_ to _END_ of _TOTAL_",
			sInfoEmpty: "Showing 0 to _END_ of _TOTAL_",
			lengthMenu: "Show _MENU_",
			emptyTable: "No Milestones Added",
			"paginate": {
			  "previous": "Prev."
			}
		}
	});
	
	if(requestUserId == ""){
		passportMilestoneTable.column( 2 ).visible( false );
	}else{
		passportMilestoneTable.column( 0 ).visible( true );
	}
}

function backfillMilestoneManagement(){	

	if(typeof backfillMilestoneTable != "undefined" && backfillMilestoneTable != ""){
		backfillMilestoneTable.draw();
		return true;
	}	

	backfillMilestoneTable = $('#backfillMilestoneList').DataTable({ 
		"processing": true,
		"dom": '<"top">rt<"bottom"ilp><"clear">',
		"lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
		"serverSide": true,
		"scrollX": false,
		"searching": true,
		"bPaginate": false,
		"bLengthChange": false,
		"bFilter": true,
		"bInfo": false,
		"ajax": {
			"url": APP_URL+"backfill_milestone_list",
			"data": function ( d ) {
				d.table_name = "backfillMilestoneList";
				d.journey_id = milestoneJourneyId;
				d.user_id 	 = requestUserId;
				d.category 	= (window.location.href.indexOf("backfill_milestone") > -1) ? 'backfill':'passport';
			},
		},
		"columns": [
			{data: 'milestone_name', name: 'milestone_name'},
			{data: 'milestone_type', name: 'milestone_type'},
			{data: 'difficulty', name: 'difficulty'},
			{data: 'start_date', name: 'start_date'},
			{data: 'completion_date', name: 'completion_date'},
			{data: 'action'}
		],
		"createdRow": function ( row, data, index ) {
			$('td', row).eq(0).html("<span class='maxname'>" + $('<div/>').html(data['milestone_name']).text() + "</span>");
		},
		"columnDefs": [
			{ className: "actions action_btn", "orderable": false, "width": "25%", "targets": [ 5 ] }
		],
		language: {
			search: "_INPUT_",
			searchPlaceholder: "Search...",
			sInfo: "Showing _START_ to _END_ of _TOTAL_",
			sInfoEmpty: "Showing 0 to _END_ of _TOTAL_",
			lengthMenu: "Show _MENU_",
			emptyTable: "No Milestones Added",
			"paginate": {
			  "previous": "Prev."
			}
		}
	});
}

/*Star Rating*/
$(document).on("click", ".btnrating", function (e) {
    //clearing currrently "rated" star
    $(".btnrating").removeAttr("data-selected");

    var $this = $(this);
	
	//Set rating point
	$('#ratingID').val($this.attr('data-attr'));
	
	//removing Validation error message
	$('#ratingID-error').hide();
	
    //removing ration from all the following stars
    $this.nextAll(".btnrating").removeClass("rated");

    //mark clicked star with data-selected attribute
    $this.addClass("rated").attr("data-selected", "true");

    //mark previous stars
    $this.prevAll(".btnrating").addClass("rated");
	
});

$(document).on("mouseover", ".btnrating", function (e) {
    //unmark rated stars
    $(".btnrating").removeClass("rated");
    var $this = $(this);

    //mark currently hovered star as "hover"
    $(this).addClass("hover");

    //mark preceding stars as "hover"
    $this.prevAll(".btnrating").addClass("hover");
});

$(document).on("mouseout", ".btnrating", function (e) {
    //un-"hover" all the stars
    $(".btnrating").removeClass("hover");

    //mark star with data-selected="true" and preceding stars as "rated"
    $("[data-selected='true']").addClass("rated").prevAll(".btnrating").addClass("rated");
});

$(document).on("click","#milstoneAdd .btn-close, .milestoneCancelBtn, #predefinedJourneyDuplicateModal .btn-close, #predefinedJourneyDuplicateModal :reset",function(){
	//reset browser Back Confirm Alert
	resetBackConfirmAlert();
});

if($('.journey_content .mlj_lft_field  .form-group select').length > 0){
	$('.journey_content .mlj_lft_field  .form-group select').on('change', function(evt){
		$(this).valid();
	});
}
