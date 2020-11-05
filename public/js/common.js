$(document).ready(function() {
	if($("time.timeago").length > 0){
		$("time.timeago").timeago();
	}
});

function sendGetRequest(url, callback){
	$.ajax({
        url: url,
        type: 'GET',
        dataType: 'json',
        cache:false,
        success: function(response) {
            callback(response);
        }
    });
}

function sendGetHtmlRequest(url, data, callback){
	$.ajax({
        url: url,
        type: 'GET',
        data: data,
        dataType: 'html',
        cache:false,
        success: function(response) {
            callback(response);
        }
    });
}

function sendPostRequest(url, data, callback){
	$.ajax({
		url: url,
		type: 'POST',
		data: data,
		dataType: 'json',
		success: function(response) {
			if(response.status){
				if (response.action == "redirect") {
					setTimeout(function(){
						window.location.href = response.url;
					},1200);
				}else if(response.reload){
					setTimeout(function(){
						window.location.reload(true);
					},1200);						
				}
			}
			callback(response);
		}
	});
}



function showMessage(msg, type, messagePosition) {
	
	var typeClasses = {
		"error": "danger",
		"success": "success",
		"primary": "primary",
		"warning": "warning",
		"info": "info"
	};

	var iconClasses = {
		"error": "error",
		"success": "success",
		"warning": "warning",
		"info": "info"
	};
	
	var bgColor = {
		"error": "#d42f2f",
		"success": "#384f98",
		"warning": "warning",
		"info": "info"
	};

	var headingClasses = {
		"error": "",
		"success": "",
		"warning": "",
		"info": ""
	};

	if (messagePosition == "toastr") {
		$.toast().reset('all');		
		$.toast({
			heading: headingClasses[type],
			text: msg,
			position: 'top-center',
			bgColor: bgColor[type],
			textColor: "#fff",
			loaderBg:'#ff6849',
			icon: iconClasses[type],
			allowToastClose: false,
			hideAfter: 2500 
		});
	}
	else {
		var ele = $(opt.container).find("#alert");
		var html = '<div class="alert alert-'+ typeClasses[type] +'">' + msg +'</div>';
		if (ele.length == 0) {
			$(opt.container).find(".form-group:first")
				.before('<div id="alert">' + html + "</div>");
		}
		else {
			ele.html(html);
		}
	}
}

// if($('#roleStatus').length > 0){
	// if(document.getElementById("roleStatus").checked) {
		// document.getElementById('roleStatusHidden').disabled = true;
	// }
// }


function confirmDelete(id,callback){
    $("#modal-danger").modal("show");
	$('#commonDeleteName').text('');
	if(id["name"] !== undefined){
		$('#commonDeleteName').text(id.name);
	}
    $(document).on("click","#deleteYes",function(){
		loadingSubmitButton('#deleteYes');
		callback(id,function (){
			$("#modal-danger").modal("hide");
			unloadingSubmitButton('#deleteYes');
			$(document).off('click', '#deleteYes');
		});
    })
    
    $(document).on("click","#deleteNo",function(){
		$(document).off('click', '#deleteYes');
		$(document).off('click', '#deleteNo');
    })
}

function commonConfirm(data,callback){
    $("#common-confirm").modal("show");
	$('#common-confirm-title').text('');
	$('#common-confirm-content').html('');
	$('#common-confirm-name').text('')
	
	if(data["title"] !== undefined){
		$('#common-confirm-title').text(data.title);
	}
	
	if(data["content"] !== undefined){
		$('#common-confirm-content').html(data.content);
	}
	
	if(data["name"] !== undefined){
		$('#common-confirm-name').text(data.name);
	}
	
    $(document).on("click","#commonYes",function(){
		loadingSubmitButton('#commonYes');
		callback(data,function (){
			$("#common-confirm").modal("hide");
			unloadingSubmitButton('#commonYes');
			$(document).off('click', '#commonYes');
		});
    })
    
    $(document).on("click","#commonNo",function(){
		$(document).off('click', '#commonYes');
		$(document).off('click', '#commonNo');
    })
}


function timeago(){
	jQuery("time.timeago").timeago();
}

function duplicateValues(data){
	data = _.map(data, function(a) {  a.value = a.value.toLowerCase();   return a; });	
	return _.filter(
	_.uniq(
    _.map(data, function (item) {
      if (_.filter(data, { value: item.value }).length > 1) {
        return item;
      }

      return false;
    })),
	function (value) { return value; });
}

$(document).ready(function() { 
    if(is_logged_in){
		//Set Sidebar menu collapse and expend
		if(localStorage.getItem('sidemenu_expand')){
				$(".header").addClass("haeder-change");
			$('.sidemenu_list').addClass('animation');
			$('.page-wrap').addClass('menu-close');
		}
		
		//Set Confirm alert on leave form form page
		$('form *').change(function(){
			var attr = $(this).attr('id');
			if (typeof attr !== typeof undefined && attr !== false && attr == 'dataTableSearch') {
				//do nothing
			}else{
				formmodified=1;
			}
		});
		window.onbeforeunload = function () {
			if (formmodified == 1) {
				return "Are you sure you want to leave the page without saving?";
			}
		}
	}
});

//Set Sidebar menu collapse and expend
$(document).on('click','.sidemenu_list', function(){
	if($(this).hasClass('animation')){
		localStorage.setItem('sidemenu_expand', true);
	}else{
		localStorage.removeItem('sidemenu_expand');
	}	 
})


function loadingSubmitButton(selector) {
	var button = $(selector);
	var text = "Submitting...";

	rev_submit_loader(true);
	
	if (button.width() < 20) {
		text = "...";
	}

	if (!button.is("input")) {
		button.attr("data-prev-text", button.html());
		button.text(text);
		button.prop("disabled", true);
	}
	else {
		button.attr("data-prev-text", button.val());
		button.val(text);
		button.prop("disabled", true);
	}
}

function unloadingSubmitButton(selector) {
	var button = $(selector);
	
	rev_submit_loader(false);
	
	if (!button.is("input")) {
		button.html(button.attr("data-prev-text"));
		button.prop("disabled", false);
	}
	else {
		button.val(button.attr("data-prev-text"));
		button.prop("disabled", false);
	}
}

function rev_submit_loader(show){
	if(show){
		$(".preloaderOne").css({'display':'block'});
	}else{
		$(".preloaderOne").css({'display':'none'});
		$( "body" ).css({'overflow':'visible'});
	}	
}

$( function() {
  //$( ".datepicker" ).datepicker( );
});

$(document).ajaxComplete(function() {
    setTimeout(function(){
		$(".maxname").each(function(index, value){
			if(value.innerText.length > 12){
				$(this).attr("title", value.innerText);
			}
		})
	},500);
});
