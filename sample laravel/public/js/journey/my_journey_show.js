$(document).ready(function(){	

	if(window.location.href.substring(window.location.href.lastIndexOf('/') + 1) == 'show'){
		var res = window.location.href.split("/");
		var pos = res.indexOf('show');
		milestoneJourneyId = res[pos-1];
	}	
	render_milestone_list();
	//journeyBreakDown(milestoneJourneyId);
})