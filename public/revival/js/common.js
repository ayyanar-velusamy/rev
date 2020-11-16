(function($) {
    "use strict";  
	//Enquiry Form Validation-->
	$("#reservation_form").validate({
	  submitHandler: function(form) {
		 let url = $('#reservation_form').attr('action'); 
		var form_btn = $(form).find('button[type="submit"]');
		var form_result_div = '#form-result';
		$(form_result_div).remove();
		form_btn.before('<div id="form-result" class="alert alert-success" role="alert" style="display: none;"></div>'); 
		var form_btn_old_msg = form_btn.html();
		form_btn.html(form_btn.prop('disabled', true).data("loading-text"));
		$(form).ajaxSubmit({
		  url: url,
		  dataType:  'json',
		  success: function(data) { 
			if( data.status) { 
			  $(form).find('.form-control').val('');
			} 
			form_btn.prop('disabled', false).html(form_btn_old_msg);
			$(form_result_div).html(data.message).fadeIn('slow');
			setTimeout(function(){ $(form_result_div).fadeOut('slow') }, 6000);
		  },
		  error: function(error) { 
		   var keys = Object.keys(error.responseJSON.errors);
			for (var i = 0; i < keys.length; i++) { 
				if($('#'+keys[i]+'-error').length == 0){
				 $("#reservation_form").find("#"+keys[i]).closest(".form-group").append('<label id="'+keys[i]+'-error" class="error" >'+error.responseJSON.errors[keys[i]][0]+'</label>');
				}else{
					$('#'+keys[i]+'-error').text(error.responseJSON.errors[keys[i]][0]).show();
				}
			}  
			 form_btn.prop('disabled', false).html(form_btn_old_msg);
			// $(form_result_div).html(error.responseJSON.message).fadeIn('slow');
			// setTimeout(function(){ $(form_result_div).fadeOut('slow') }, 6000);
			
		  }
		});
	  }
	}); 
})(jQuery);