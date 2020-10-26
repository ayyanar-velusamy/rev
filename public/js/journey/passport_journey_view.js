$(document).ready(function(){
	var res = window.location.href.split("/");
	var lastSegment = window.location.href.substring(window.location.href.lastIndexOf('/') + 1);
	var pos = res.lastIndexOf(lastSegment);
	if(res[pos-1] == 'journey'){
		milestoneJourneyId = lastSegment;
		requestUserId = '';
	}else{
		milestoneJourneyId = res[pos-1];
		requestUserId = lastSegment;
	}
	render_milestone_list();
});

function loadPassportViewMilestone(milestone_id){
	$('#loadPassportMilstoneAddModal').html('');
	$('#milstoneAdd').modal('show');
	getPassportMilestoneDetail(milestone_id)
}

function getPassportMilestoneDetail(id){
	lxp_submit_loader(true);
	sendGetHtmlRequest(APP_URL+'milestone_detail/'+id+'/'+requestUserId,{'action':'view'},function(response){
		$('#loadPassportMilstoneAddModal').html(response);	
		setTimeout(function () {
			lxp_submit_loader(false);
		},500);
	});
}