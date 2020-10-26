$(document).ready(function(){		
	milestoneJourneyId = window.location.href.substring(window.location.href.lastIndexOf('/') + 1);
	render_milestone_list();
	//journeyBreakDown(milestoneJourneyId);
});