$(document).ready(function(){	
	if(window.location.href.lastIndexOf('edit') >0){
		var res = window.location.href.split("/");
		var pos = res.lastIndexOf('edit');
		milestoneJourneyId = res[pos-1];
		milestoneListType = (res[pos+1] != undefined) ? res[pos+1] : '';
	}	
	render_milestone_list();
})

function setJourneyUrl(data){   
   setMilestoneJourneyId(data.journey_id, data.visibility);
}