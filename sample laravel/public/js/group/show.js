$(document).ready(function(){		
	activeGroupId = window.location.href.substring(window.location.href.lastIndexOf('/') + 1);
	groupMemberManagement();
	groupJourneyManagement();
});