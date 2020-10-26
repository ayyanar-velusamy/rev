$(document).ready(function(){		
	if(window.location.href.substring(window.location.href.lastIndexOf('/') + 1) == 'edit'){
		var res = window.location.href.split("/");
		var pos = res.indexOf('edit');
		milestoneJourneyId = res[pos-1];
	}	
	render_milestone_list();
	//journeyBreakDown(milestoneJourneyId);
})

function setJourneyUrl(data){   
   setMilestoneJourneyId(data.journey_id, data.visibility,data.journey_type_id, data.read);
}