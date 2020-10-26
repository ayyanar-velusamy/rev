$(document).ready(function(){
    var libraryContentType = localStorage.getItem('libraryContentType');
	if(libraryContentType > 0){
		$('#content_type_id').prop('selectedIndex',libraryContentType).trigger("change");
	}
});

$(document).on('change','#content_type_id',function(){	
	 $('.inputProviderSec').removeClass('d-none'); 
     $('.inputProviderSec label').text('Provider ').append('<span class="required">*</span>');
	 $('.inputURLSec label').text('URL ').append('<span class="required">*</span>');
	 $('#inputProviderName').attr('placeholder','Enter Provider');
	 
	 if($(this).val() > 1 && $(this).val() < 6){
		var lengthTxt = providerTxt = "";		
		$('.inputLengthSec').removeClass('d-none');				
		if($(this).val() == 2 || $(this).val() == 3){
			lengthTxt = "(minutes) ";
			if($(this).val() == 3){
				providerTxt = "Episode Name ";
			}
		}
		
		if($(this).val() == 4){
		$('.inputURLSec label span').remove();
		  lengthTxt = "(pages) ";
		  providerTxt = "Author ";
		}
		
		if($(this).val() == 5){
			lengthTxt = "(hours) ";
			providerTxt = "Provider Name ";
		}
		
		if(lengthTxt != ""){
			$('.inputLengthSec label').text('Length '+lengthTxt);
			$('#inputLengthName').attr('placeholder','Enter Length '+lengthTxt);
		}
		
		if(providerTxt != ""){
			$('.inputProviderSec label').text(providerTxt).append('<span class="required">*</span>');
		    $('#inputProviderName').attr('placeholder','Enter '+providerTxt);
		}			
	 }else{		
		$('.inputLengthSec').addClass('d-none');
		if($(this).val() == 6){
			$('.inputProviderSec').addClass('d-none');
		}	
	 }
})