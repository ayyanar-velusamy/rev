$(document).ready(function() {
   let url = window.location.href;
   if(url.substring(url.lastIndexOf('/') + 1) == 'create'){
	   activeGroupId = "";
   }else{
	   activeGroupId = url.substring(url.lastIndexOf('/') + 1)		
   }
   groupMemberManagement();   
});

function setGroupUrl(data){   
   setActiveGroupId(data.group_id);

   if(window.location.href.substring(window.location.href.lastIndexOf('/') + 1) == 'create'){
		window.history.pushState({},"/create","/groups/create/"+data.group_id);
   }else{
		window.history.replaceState(null, null,'/groups/create/'+data.group_id)
   }
}

function clearGroupAddForm(){
	if($('#groupPrimaryId').val() == ""){
		var from_id = '#groupAddForm';
		
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