var ApprovalMangementTable;
var filterByJourneyId, filterByMilestoneId, filterByRequestBy, filterByRequestFor, filterByRequestDate, filterByStatusOption, filterByMilestoneType; 


$(document).on('submit','form',function(e){	
    if($(this).hasClass('ajax-form')){
		e.preventDefault()
		let url = $(this).attr('action');	    
		let messagePosition = 'toastr';
		$.easyAjax({
			url: url,
			container: '#approval-form',
			type: "POST",
			redirect: true,
			disableButton: true,
			file: false,
			data: $(this).serializeArray(),
			messagePosition:messagePosition,
		}, function(res){
			$('#approval-modal').modal('hide');
			approvalMangement();
		});
	}
});


function milstoneView(milestone_id){
	lxp_submit_loader(true);
	getRequestedMilestoneDetail(milestone_id, disabled=true);
	
	$(".daterangepicker").daterangepicker("clearRange");
}

function getRequestedMilestoneDetail(id, disabled){
	sendGetRequest(APP_URL+'approvals/milestone/'+id,function(response){{
		if(response.status){
			response.data.id = id;
			setRequesteMilestoneModalValue(response.data, disabled);
		}
		setTimeout(function(){
			lxp_submit_loader(false);
		},700)
	}})
}

function setRequesteMilestoneModalValue(data, disabled){
	//Model header set milestone name
	$('#milstoneAddTitle').text( data.title +': View');	

	$('#content_type_id').val(data.content_type_id);
	$('#inputTitleName').val(data.title).attr('disabled',disabled);
	$('#inputURLName').val(data.url).attr('disabled',disabled);
	$('#inputProviderName').val(data.provider).attr('disabled',disabled);
	$('#inputDifficultyName').val(data.difficulty).attr('disabled',disabled);
	$('#inputVisibilityName').val(data.visibility).attr('disabled',disabled);
	$('#inputDescriptionName').val(data.description).attr('disabled',disabled);
	$('#inputPriceName').val(data.price).attr('disabled',true);
	$('#inputApproverName').val(data.approver).attr('disabled',true);
	$('#inputStatusName').val(data.approval_status).attr('disabled',true);
	$('#inputCommentDes').val(data.approval_comment).attr('disabled',true);
	$('#inputReadName').val(data.read).attr('disabled',true);
	$('#inputRequestedDateName').val(moment(data.requested_date).format("MMM D, YYYY")).attr('disabled',true);
	$('#inputJourneyName').val(data.journey_name).attr('disabled',true);
	$('#inputRequestedByName').val(data.requested_by).attr('disabled',true);
	$('#inputRequestedForName').val(data.requested_for).attr('disabled',true);
	$('#inputTagsName').attr('disabled',true);
	
	if(data.tags != "" && data.tags != null){
		$('#inputTagsName').html('');
		options = [];
		$.each(data.tags.split(","),function(kay,val){
			$('#inputTagsName').append("<option value="+val+">"+val+"</option>");
			options.push(val)	
		});
		$('#inputTagsName').val(options).trigger("change"); 
	}
	
	
	$('.inputProviderSec').removeClass('d-none'); 
	var providerTxt = "Provider ";
	
	if(data.content_type_id == 3){
		providerTxt = "Episode ";
	}
	
	if(data.content_type_id == 4){
		providerTxt = "Author ";
	}
	
	if(data.content_type_id == 6){
		$('.inputProviderSec').addClass('d-none'); 
	}
	$('.inputProviderSec label').text(providerTxt);
			
	if(data.type == 'user'){
		$('#redirectToViewBtn').attr('href',APP_URL+'passport/'+data.type_ref_id).text('View Passport').show();
	}else if(data.type == 'group'){
		$('#redirectToViewBtn').attr('href',APP_URL+'groups/'+data.type_ref_id).text('View Group').show();
	}else{
		$('#redirectToViewBtn').hide();
	}
	
	setTimeout(function(){
		$('#milstoneRequestedView').modal('show');
	},500)
}

//function to filter by journey 
$(document).on('change','.filterByJourneyId',function(){
	filterByJourneyId = $(this).val();
	approvalMangement();
})

//function to filter by milestone count 
$(document).on('change','.filterByMilestoneId',function(){
	filterByMilestoneId = $(this).val();
	approvalMangement();
})

//function to filter by request by
$(document).on('change','.filterByRequestBy',function(){
	filterByRequestBy = $(this).val();
	approvalMangement();
})

//function to filter by request for
$(document).on('change','.filterByRequestFor',function(){
	filterByRequestFor = $(this).val();
	approvalMangement();
})

//function to filter by request date 
$(document).on('change','.filterByRequestDate',function(){
	filterByRequestDate = $(this).val();
	approvalMangement();
})

//function to filter by status option
$(document).on('change','.filterByStatusOption',function(){
	filterByStatusOption = $(this).val();
	approvalMangement();
})

//function to filter by milestone type
$(document).on('change','.filterByMilestoneType',function(){
	filterByMilestoneType = $(this).val();
	approvalMangement();
})


function milstoneApprove(approval_id, status, name) {
	$("#comment-error").remove();
	$("span.error").remove();
	var data = {
		url:APP_URL+'approvals/status/'+approval_id,
		name:name,
		status:'approved',
		title:'Approve Milestone',
		content:'you want to approve the following milestone?'
	};		
	approvalModal(data);
}

function milstoneReject(approval_id, status, name) {
	$("#comment-error").remove();
	$("span.error").remove();
	var data = {
		url:APP_URL+'approvals/status/'+approval_id,
		name:name,
		status:'rejected',
		title:'Reject Milestone',
		content:'you want to reject the following milestone?'
	};
	approvalModal(data);
}

function approvalModal(data){
	
	$('#inputCommentName').val("");
    $("#approval-modal").modal("show");
	
	if(data["title"] !== undefined){
		$('#approval-modal-title').text(data.title);
	}
	
	if(data["content"] !== undefined){
		$('#approval-modal-content').text(data.content);
	}
	
	if(data["name"] !== undefined){
		$('#approval-modal-name').text(data.name);
		$('#approvalMilestoneName').val(data.name);
	}
	
	if(data["url"] !== undefined){
		$('#approval-form').attr('action',data.url);
	}
	
	if(data["status"] !== undefined){
		$('#approvalStauts').val(data.status);
	}
	    
    $(document).on("click","#approvalNo",function(){
		//reset browser Back Confirm Alert
		resetBackConfirmAlert();
		$(document).off('click', '#approvalYes');
		$(document).off('click', '#approvalNo');
    })
}

$(document).on("click","#approval-modal .btn-close",function(){
	//reset browser Back Confirm Alert
	resetBackConfirmAlert();
});

$(document).ready(function() {
	$( ".datepicker" ).datepicker({
	   dateFormat: 'M d, yy'
	});
	
	approvalMangement();
}); 

function approvalMangement(){
	
	if(typeof ApprovalMangementTable != "undefined" && ApprovalMangementTable != ""){
		ApprovalMangementTable.draw();
		return true;
	} 
	
	ApprovalMangementTable = $('#approvalList').DataTable({ 
		"processing": true,
		"dom": '<"top">rt<"bottom"ilp><"clear">',
		"lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
		"serverSide": true,
		"searching": true,
		"ajax": {
			"url": APP_URL+"/approvals/approval_list",
			"data": function ( d ) {
				d.journey_name		= filterByJourneyId;
				d.milestone_id		= filterByMilestoneId;
				d.requested_by		= filterByRequestBy;
				d.requested_for		= filterByRequestFor;
				d.requested_date	= filterByRequestDate;
				d.status			= filterByStatusOption;
				d.milestone_type_id	= filterByMilestoneType;
			},
		},			
		"columns": [
			{data: 'journey_name', name: 'journey_name'},
			{data: 'content_type', name: 'content_type'},
			{data: 'title', name: 'title'},
			{data: 'created_at', name: 'created_at'},
			{data: 'requested_for', name: 'requested_for'},
			{data: 'requested_by', name: 'requested_by'},
			{data: 'status', name: 'status'},
			{data: 'price', name: 'price'},
			{data: 'action'} 
		],
		"createdRow": function ( row, data, index ) {			
			$('td', row).eq(0).html("<span class='maxname'>" + data['journey_name'] + "</span>");
			$('td', row).eq(2).html("<span class='maxname'>" + data['title'] + "</span>");
			$('td', row).eq(4).html("<span class='maxname'>" + $('<div/>').html(data['requested_for']).text() + "</span>");
			$('td', row).eq(5).html("<span class='maxname'>" + data['requested_by'] + "</span>");
			//$('td', row).eq(9).html($('<div/>').html(data['expand']).text());
		},
		"columnDefs": [
			{ className: "journey_name", "targets": [0] },
			{ className: "milestone_type text-center", "targets": [1] },
			{ className: "status", "width": "10%", "targets": [ 6 ] },
			{ className: "price", "width": "10%", "targets": [ 7 ] },
			{ className: "actions action_btn nowrap", "orderable": false, "width": "120px", "targets": [ 8 ] } 
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

$(document).on('keyup change','#dataTableSearch', function () {
    ApprovalMangementTable.search($(this).val()).draw();
});


$(".daterangepicker").each(function(){
	var placeholder = $(this).attr('placeholder'); 

 $(this).daterangepicker({
     datepickerOptions : {
         numberOfMonths : 2,
		 dateFormat: 'M d, yy',
		 maxDate: null
     },
	 initialText : placeholder,
	 presetRanges: [], 
 });

}),

$('.comiseo-daterangepicker-triggerbutton').on('mouseenter', function() {
	var value = $(this).text();
	$(this).attr('title', value);
	//console.log(value); 
});
 