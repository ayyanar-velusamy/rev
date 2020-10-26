var milestoneContentTypeId;
var backfillMilestoneTable;

function addMilestone(journey_id){	
	milestoneContentTypeId = "";	
	getMilestonePostData = {};
	getMilestonePostData['journey_id'] = journey_id;
	$("input:radio[class^=backfillMilestoneContentType]").each(function(i) {
        $(this).attr('checked',false);
    });	
	$('#milstoneContentTypeAdd').modal('show');	
	
	var opts =new Date();
	$(".modal-body .milstoneGrid  #start_date").datepicker("setDate", opts);
}

$(document).on('change','.backfillMilestoneContentType',function(){
	milestoneContentTypeId = $(this).val();	
	if(milestoneContentTypeId != ""){
		$('#contentTypeId').val(milestoneContentTypeId);
		$('#backfill_content_type_id').prop('selectedIndex',milestoneContentTypeId).trigger("change");
		$('#milstoneContentTypeAdd').modal('hide');
		$('#loadMilstoneAddModal').html('');
		setTimeout(function(){
			$('#milstoneAdd').modal('show');
		},500)
		getMilestonePostData['content_type_id'] = milestoneContentTypeId;
		getMilestonePostData['action'] = 'add';
		getBackfillMilestoneDetail("");
	}
});

$(document).ready(function() {
	backfillMilestoneManagement(); 
});




