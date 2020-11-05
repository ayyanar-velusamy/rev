$(document).ready(function() {
	$.fn.dataTable.ext.errMode = 'none';  
});  

bannerImgUrl = '';
banner_img_data  = [];
var bannerImgCroppie = (function() {   
	function bannerUp() { 
		var $bannerUploadCrop5;
		$('#bannerUpload').empty(); 	
		function readFile(input) {
 			if (input.files && input.files[0]) {
	            var reader = new FileReader();
	            
	            reader.onload = function (e) {
					$('.add-banner').addClass('ready');
					$('.banner-wrap').show();
					$('#bannerUpload .cr-image').attr('src', '');
					$('#bannerUpload .cr-image').css({'opacity' : '','transform': '', 'transform-origin': ''});
					
						$bannerUploadCrop5.croppie('bind', {
							url: e.target.result
						}).then(function(){
							console.log('jQuery bind complete');
							$('.uploadLabel').hide();
							$('.add-banner ul.list-inline').show(); 
							$('.add-banner .table-small-img-outer').hide();
							//$('.profile-wrap').show();
						});
					
	            }
	            reader.readAsDataURL(input.files[0]);
	        }
	        else {
		        
		    }
			$('#profile-adminImg').hide();
		}
		if($("#bannerUpload").length > 0){
			$bannerUploadCrop5 = $('#bannerUpload').croppie({
				viewport: {
					width: 1200,
					height: 500,
					type: 'rectangle'
				},
				boundary: {
					width: 1300,
					height: 600
				},
				enforceBoundary: true,
				enableOrientation: true,
				showZoomer: false,
				enableExif: false,
				enableZoom:true,
				mouseWheelZoom:false
			});
		}
		
		$('.crop-save').on('click', function (ev) {
			
				$bannerUploadCrop5.croppie('result', {
					type: 'blob',
					size: 'viewport',
					format:'jpg,png,jpeg'
				}).then(function (resp) {  
					profile_image_data = image_data = resp;
					var urlCreator = window.URL || window.webkitURL;
					console.log(image_data);
					bannerImgUrl = urlCreator.createObjectURL(image_data);
					$('#profile-adminImg').attr('src',bannerImgUrl);
					$('#profile-adminImg').show();
					$('.banner-wrap').hide();
					$('.add-banner ul').hide();
					$('.uploadLabel').show();
					$('.add-banner .table-small-img-outer').show();
				});
			
		});
		$('.crop-cancel').click(function(){
			$('.banner-wrap').hide();
			$('.add-banner ul').hide();
			$('#profile-adminImg').show();
			$('.uploadLabel').show();
			$('.add-banner').removeClass('ready');
			$('.profileAdmin').val('');
			$('.add-banner .table-small-img-outer').show();
		});
		
	
		 $(document).on('change','.profileAdmin',function () {
			var extension = $('.profileAdmin').val().replace(/^.*\./, '');
			if($('.profileAdmin').val() != "") {
				if($.inArray(extension, ['png','jpg','jpeg','JPG','PNG','JPEG']) != -1) {
					var size = $('.profileAdmin')[0].files[0].size;
					if(size >= 5000000) {
						$('.add-banner .error').html('Image size cannot exceed 5 MB');
						return false;
					} else if(size <= 10000) {
						$('.add-banner .error').html('Image size must be more than 10 KB');
						return false;
					} else {
						readFile(this);
						$('.add-banner .error').html('');
					}
				} else {
					$('.add-banner .error').html('File format should accept only JPEG,PNG.');
					return false;
				}
			}
		});
	}

	function init() { 
		bannerUp()
	}

	return {
		init: init
	};
})();
 

// $('.account-user #profile-adminImg').on('click',function(){
	// $('#profile-user').click();
// });

bannerImgCroppie.init();