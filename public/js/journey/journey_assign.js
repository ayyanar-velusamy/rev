var assignMembers = [];
var assignGroups  = [];
var assignGrades  = [];

$(document).ready(function(){		
	if(window.location.href.substring(window.location.href.lastIndexOf('/') + 1) == 'assign'){
		var res = window.location.href.split("/");
		var pos = res.indexOf('assign');
		milestoneJourneyId = res[pos-1];
	}
});

function activeAssignTab(active_tab){
	if(active_tab == 'user'){		
		assignGroups  = [];
		assignGrades  = [];
		$('ul#addMulGroupList').html('');
		$('span.error').remove();
		$('ul#addMulGradeList').html('')
		$('.adduser-error').hide().text('');
		$('.userempty-error').hide().text('');
	}else if(active_tab == 'group'){
		assignMembers  = [];
		assignGrades  = [];
		$('ul#addMulUserList').html('');
		$('span.error').remove();
		$('ul#addMulGradeList').html('')
		$('.adduser-error').hide().text('');
		$('.userempty-error').hide().text('');
	}else{
		assignMembers  = [];
		assignGroups  = [];
		$('ul#addMulUserList').html('');
		$('span.error').remove();
		$('ul#addMulGroupList').html('');
		$('.adduser-error').hide().text('');
		$('.userempty-error').hide().text('');
	}
}


$(document).on('submit','#journeyAssignForm', function(e){
	e.preventDefault();
	rev_submit_loader(true);
    let url = $(this).attr('action');
	var data = $('#journeyAssignForm').serializeArray();
	
	$.each(assignMembers, function(k,v){
		data.push({name:'user['+k+']', value:v.id});
	});
	
	$.each(assignGroups, function(k,v){
		data.push({name:'group['+k+']', value:v.id});
	});
	
	$.each(assignGrades, function(k,v){
		data.push({name:'grade['+k+']', value:v.id});
	});
	
	
    $.easyAjax({
        url: url,
        container: "#journeyAssignForm",
        type: "POST",
		disableButton: true,
        redirect: true,
        file: false,
        data: data,
        messagePosition:'toastr',
    }, function(response){
       if(response.status){
		  //showMessage(response.message, "success", "toastr");
	   }else{
		  //showMessage(response.message, "error", "toastr");
	   }
	   setTimeout(function(){
			rev_submit_loader(false);
		},500)
    });
});

$(document).on('click','#assignAddUser',function(e){
	if($('#inputUserName').val() != ""){
		var id = $('#inputUserName').val()
		if(!memberExist(assignMembers, id)){
			var name = $("#inputUserName option:selected").html();
			var rand = Math.floor(1000 + Math.random() * 9000);
			$('ul#addMulUserList').append('<li id="' + rand + '">'+ name + '<span id=" user_' + rand + ' " title="Remove" class="close_icon"><i class=" icon-close-button"></i></span></li>');
			assignMembers.push({'id':id,'name':name,'rand':rand});
		}else{
			showMessage('User already added', "error", "toastr");
		}
		$('.userempty-error').hide().text('');
	}else{
		//alert();
		$('.adduser-error').show().text('Please select a User');
	}
});

$(document).on('click','#assignAddGroup',function(e){
	console.log($('#inputGroupName').val())
	if($('#inputGroupName').val() != ""){
		var id = $('#inputGroupName').val()
		if(!memberExist(assignGroups, id)){
			var name = $("#inputGroupName option:selected").html();
			var rand = Math.floor(1000 + Math.random() * 9000);
			$('ul#addMulGroupList').append('<li id="' + rand + '">' + name + '<span id="group_' + rand + '" title="Remove" class="close_icon"><i class=" icon-close-button"></i></span></li>');
			assignGroups.push({'id':id,'name':name,'rand':rand});
		}else{
			showMessage('Group already added', "error", "toastr");
		}
		$('.userempty-error').hide().text('');
	}else{
		//alert();
		$('.adduser-error').show().text('Please select a Group');
	}
});

$(document).on('click','#assignAddGrade',function(e){
	if($('#inputGradeName').val() != ""){
		var id = $('#inputGradeName').val()
		if(!memberExist(assignGrades, id)){
			var name = $("#inputGradeName option:selected").html();
			var rand = Math.floor(1000 + Math.random() * 9000);
			$('ul#addMulGradeList').append('<li id="' + rand + '">'+ name +' <span id="grade_' + rand + '" title="Remove" class="close_icon"><i class=" icon-close-button"></i></span></li>');
			assignGrades.push({'id':id,'name':name,'rand':rand});
		}else{
			showMessage('Grade already added', "error", "toastr");
		}
		$('.userempty-error').hide().text('');
	}else{
		//alert();
		$('.adduser-error').show().text('Please select a Grade');
	}
});
$(document).on('click','#assign_btn',function(e){
	$('#journeyAssignForm').valid();
	
	if ($('#assignUser').hasClass('active')){
		if ($('ul#addMulUserList li').length == 0){
			$('#inputUserName').focus();
			$('.userempty-error').show().text('User cannot be empty');
			return false;
		}else {
			$('.userempty-error').hide().text('');
		}
	}else if ($('#assignGroup').hasClass('active')){
		if ($('ul#addMulGroupList li').length == 0){
			$('#inputGroupName').focus();
			$('.userempty-error').show().text('Group cannot be empty');
			return false;
		}else {
			$('.userempty-error').hide().text('');
		}
	}else {
		if ($('ul#addMulGradeList li').length == 0){
			$('#inputGradeName').focus();
			$('.userempty-error').show().text('Grade cannot be empty'); 
			return false;
		}else {
			$('.userempty-error').hide().text('');
		}
	}

});


if($('.addMultipleUser #inputUserName').length > 0){
	$('.addMultipleUser #inputUserName').on('change', function(evt){
		//$(this).valid();
		$('.adduser-error').hide().text('');
	});
}

if($('.addMultipleUser #inputGroupName').length > 0){
	$('.addMultipleUser #inputGroupName').on('change', function(evt){
		//$(this).valid();
		$('.adduser-error').hide().text('');
	});
}

if($('.addMultipleUser #inputGradeName').length > 0){
	$('.addMultipleUser #inputGradeName').on('change', function(evt){
		//$(this).valid();
		$('.adduser-error').hide().text('');
	});
}

$(document).on('click','.addMulUserList .close_icon',function(e){
	var $target = $(this).parent('li');
	var rand = $(this).attr('id');
	var data_arr = rand.split('_');
	if((data_arr[0]).trim() == 'user'){
		var index = _.findIndex(assignMembers, function(item){
			return item.rand === parseInt(data_arr[1]);
		});
		if(index != -1){
			assignMembers.splice(index, 1);
			$target.remove();
		}
	}else if((data_arr[0]).trim() == 'group'){
		var index = _.findIndex(assignGroups, function(item){
			return item.rand === parseInt(data_arr[1]);
		});
		if(index != -1){
			assignGroups.splice(index, 1);
			$target.remove();
		}
	}else{
		var index = _.findIndex(assignGrades, function(item){
			return item.rand === parseInt(data_arr[1]);
		});
		if(index != -1){
			assignGrades.splice(index, 1);
			$target.remove();
		}
	} 
});



function memberExist(arr, id) {
    for(var i = 0, len = arr.length; i < len; i++) {
        if( arr[ i ].id === id )
            return true;
    }
    return false;
}


if($('.plj_assign .form-group select, .plj_assign .form-group .datepicker').length > 0){
	$('.plj_assign .form-group select, .plj_assign .form-group .datepicker').on('change', function(evt){
		$(this).valid();
	});
}

$(document).ready(function(){
    $('.plj_assign .nav-tabs li a[data-toggle="tab"]').on('show.bs.tab', function(e) {
        localStorage.setItem('AssignActiveTab', $(e.target).attr('href'));
    });
    var AssignActiveTab = localStorage.getItem('AssignActiveTab');
	breakDownCateory = (window.location.href.indexOf("assigned") > -1) ? 'owner':'user';
    if(AssignActiveTab){
        $('#plj_assignTab a[href="' + AssignActiveTab + '"]').tab('show').click();
    }

	var res = window.location.href.split("/");
	var lastSegment = window.location.href.substring(window.location.href.lastIndexOf('/') + 1);
	var pos = res.indexOf(lastSegment);
	if((lastSegment != 'assign')){
		localStorage.removeItem('AssignActiveTab');
	}
});

/* $(document).on('click','#resetAssign',function(e){
	if(('.plj_assign .form-group select#inputVisibility_group').length > 0){
		$('.plj_assign .form-group  select#inputVisibility_group').val(null).trigger('change');
	}
	if(('.plj_assign .form-group select#inputJourneyCompulOpt_group').length > 0){
		$('.plj_assign .form-group  select#inputJourneyCompulOpt_group').val(null).trigger('change');
	}
	$("span.error, div.error, .org-error").hide();		
	$(".form-control").removeClass('error');	
}); */