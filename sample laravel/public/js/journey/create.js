$(document).ready(function() {
   let url = window.location.href;
   if(url.substring(url.lastIndexOf('/') + 1) == 'create'){
		milestoneJourneyId = "";
   }else{
	   milestoneJourneyId = url.substring(url.lastIndexOf('/') + 1)		
   }  
   render_milestone_list();
   journeyBreakDown(milestoneJourneyId);
});

function setJourneyUrl(data){   
   setMilestoneJourneyId(data.journey_id, data.visibility,data.journey_type_id, data.read);

   if(window.location.href.substring(window.location.href.lastIndexOf('/') + 1) == 'create'){
		window.history.pushState({},"/create","/journeys/create/"+data.journey_id);
   }else{
		window.history.replaceState(null, null,'/journeys/create/'+data.journey_id)
   }
}

function clearJouneyAddForm(){
	if(milestoneJourneyId == ""){
		var from_id = '#journeyAddForm';
		
		if((from_id+'.select_level, select.form-control').length > 0){
			$(from_id+'.select_level, select.form-control').val(null).trigger('change');
		}
		
		$("span.error, div.error, .org-error").hide();		
		$(".form-control").removeClass('error');		
		
		$(from_id)[0].reset();
		resetBackConfirmAlert();

	}else{
		resetBackConfirmAlert();
		window.location.reload(true)
	}
}