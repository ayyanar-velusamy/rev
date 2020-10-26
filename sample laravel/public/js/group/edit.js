$(document).ready(function(){		
	if(window.location.href.substring(window.location.href.lastIndexOf('/') + 1) == 'edit'){
		var res = window.location.href.split("/");
		var pos = res.indexOf('edit');
		activeGroupId = res[pos-1];
	}
	groupMemberManagement();
	groupJourneyManagement();
})

function setGroupUrl(data){   
   setActiveGroupId(data.group_id);
}
