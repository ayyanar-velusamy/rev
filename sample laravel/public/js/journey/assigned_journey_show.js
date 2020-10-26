$(document).ready(function(){	
	if(window.location.href.lastIndexOf('show') >0){
		var res = window.location.href.split("/");
		var pos = res.lastIndexOf('show');
		milestoneJourneyId = res[pos-1];
		milestoneListType = (res[pos+1] != undefined) ? res[pos+1] : '';
	}	
	render_milestone_list();
})