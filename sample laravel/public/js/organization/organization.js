var formData , sidebar_data, used_nodes = '';
var accessPermissions = [];
$(document).ready(function(){
	
	//Initialize Chart
	build_organization_chart();

	
	// first example
	if($('#browser').length > 0){
		$("#browser").treeview();
	}
});

$(document).on('click','.org_close_bt',function(){
	  formmodified = 0;
	  location.reload();
});

$(document).on('click',".org-del-button").click(function(){
	var check_val = $(this).attr('data_set_id');
	if(check_val == 1)
	{	
		return false;
	}
});

function build_organization_chart(){
	if($('#orgChart').length > 0){
		get_organization_chart(function(){
			org_chart = $('#orgChart').orgChart({
				data: formData,
				showControls: true,
				allowEdit: true,
				onAddNode: function(node){ 
					log('Created new node on node '+node.data.id);
					org_chart.newNode(node.data.id); 
				},
				onDeleteNode: function(node){
					console.log(node);
					log('Deleted node '+node.data.id);
					org_chart.deleteNode(node.data.id, node.data.set_id); 
				},
				onClickNode: function(node){
					log('Clicked node '+node.data.id);
				}

			});
		});
	}
}

function get_organization_chart(callback){
	
	$.ajax({
		method: "GET",
		url: APP_URL+'/organization-chart/3',			
	}).done(function(response) {
		if(response.length != 0)
		{
			var get_json_data = JSON.parse(response);
			formData = get_json_data.chart_data;
			sidebar_data = get_json_data.sidebar_data;
			used_nodes = get_json_data.used_node;
			accessPermissions = get_json_data.permissions;
			
			var readonly = "";
			
			if(accessPermissions.add && accessPermissions.edit && accessPermissions.delete){
				readonly = "";
			}else if(accessPermissions.add && !accessPermissions.edit && !accessPermissions.delete){
				readonly = "readonly";
			}else if(!accessPermissions.add && !accessPermissions.edit && accessPermissions.delete){
				readonly = "readonly";
			}			 
			
			if(sidebar_data == undefined){
				$(".sidebar ").append('<input '+readonly+' type="text" name="0" maxlength="40" value="Grade 1" class="form-control root_node side_bar_data" data-index="0" node-id="0">')
			}
												
			$(sidebar_data).each(function(index,element){
				if(element.set_id != 0){
					$(".sidebar ").append('<input '+readonly+' type="text" name="'+element.set_id+'" value="'+element.set_name+'" maxlength="40" class="form-control side_bar_data" data-index="1" node-id="1">')
				}else{
					$(".sidebar ").append('<input '+readonly+' type="text" name="'+element.set_id+'" value="'+element.set_name+'" maxlength="40" class="form-control root_node side_bar_data" data-index="0" node-id="0">')
				}				
			});
		}else{			
			used_nodes = '';
			formData = [{id: 1, name: 'My Organization', parent: 0, set_id: 0} ];
		}
		callback();
	});
}


$('#organization_chart_form').on('keyup keypress', function(e) {
  var keyCode = e.keyCode || e.which;
	  if (keyCode === 13) { 
		e.preventDefault();
		return false;
	  }
});

/*organization chart submit function*/
$('#organization_chart_form').submit(function(e){ 
	e.preventDefault();	 

	is_grade_show_duplicate_msg = false;
	is_node_show_duplicate_msg = false;
	is_maxlength_msg = false;
	var sidebarInputValues = [];	 
	
	$('.sidebar input').each(function(index, value){
		sidebarInputValues.push({"id":value.name, "value": value.value})		 
	})
	
	var duplicateVal = duplicateValues(sidebarInputValues);
	if (typeof duplicateVal != 'undefined' && duplicateVal.length > 0) {
		$("input[name="+duplicateVal[(duplicateVal.length - 1)].id+"]").focus();
		is_grade_show_duplicate_msg = true;
	}
	var is_show_grade_empty_msg = false;
	var is_node_maxlength_msg = false;
	is_show_node_empty_msg = false;
	$('.sidebar input').each(function(index){	 
		$(this).val($(this).val().trim());
		if($(this).val().length > 40){
			$(this).focus();
			is_maxlength_msg = true;
		}
		$(this).val($(this).val().trim());
		if($(this).val() == ""){
			$(this).focus();
			is_show_grade_empty_msg = true;
		}
		
		$('.node').each(function(i){
			if($(this).find('h2').text().trim() == ""){
				// console.log(index+' - '+i+' input empty');
				$(this).css({'background-color':'#e6d1d1'});
				is_show_node_empty_msg = true;
			}else if($(this).find('h2').text().trim().length > 40){
				// console.log(index+' - '+i+' input empty');
				$(this).css({'background-color':'#e6d1d1'});
				is_node_maxlength_msg = true;
			}else{
			 
				$('.org-input').each(function(){
					var divId = $(this).attr("data-node_id");
					$(this).val().trim();
					if($(this).val() == "" ) {
						$('[node-id='+divId+']').css({'background-color':'#f7f7f7'});
						$('.sidebar .org-error').fadeOut();
					}
				});
				/* $(this).css({'background-color':'#f7f7f7'}); */
			}
		});
		/* if(!is_show_node_empty_msg){			 
			var formInputValues = [];
			$(".node[data_set_id="+index+"]").each(function(){
				formInputValues.push({"node_id": $(this).attr('node-id'), "value": $(this).find('h2').text().trim()})
				$(this).css({'background-color':'#f7f7f7'});
			})
			var duplicateInputVal = duplicateValues(formInputValues);
			if (typeof duplicateInputVal != 'undefined' && duplicateInputVal.length > 0) {
				$(duplicateInputVal).each(function(i, dupItem){			 
					$('[node-id='+dupItem.node_id+']').css({'background-color':'#e6d1d1'});
				});
				is_node_show_duplicate_msg = true;
			}	
		} */		
	});
	if(is_show_grade_empty_msg){
		// $('.sidebar .org-error').html('Node Name cannot be empty').fadeIn();
		showMessage('Grade Name cannot be empty', "error", "toastr");
		return false;
	}else if(is_show_node_empty_msg){
		// $('.sidebar .org-error').html('Node Name cannot be empty').fadeIn();
		showMessage('Node Name cannot be empty', "error", "toastr");
		return false;
	}else if(is_grade_show_duplicate_msg) {
		// $('.sidebar .org-error').html('Node Name already exists').fadeIn();
		showMessage('Grade Name already exists', "error", "toastr");
		return false;
	}/* else if(is_node_show_duplicate_msg) {
		// $('.sidebar .org-error').html('Node Name already exists').fadeIn();
		showMessage('Node Name already exists', "error", "toastr");
		return false;
	}*/ else if(is_maxlength_msg) {
		// $('.sidebar .org-error').html('Node Name cannot be more than 40 characters').fadeIn();
		showMessage('Grade Name cannot be more than 40 characters', "error", "toastr");
		return false;
	}else if(is_node_maxlength_msg) {
		// $('.sidebar .org-error').html('Node Name cannot be more than 40 characters').fadeIn();
		showMessage('Node Name cannot be more than 40 characters', "error", "toastr");
		return false;
	}else{
		//$(":submit").attr('disabled', 'disabled');
		loadingSubmitButton('#org-submit'); 
        var form_url = $(this).attr('action');
		var side_bar_data =$(".side_bar_data").serializeArray();
			sendPostRequest(form_url,{data:form_data,side_text:side_bar_data}, function(response){
				if (response.status) {
					formmodified = 0;
					showMessage(response.message, "success", "toastr");
					if(response.reload){
						setTimeout(function(){
							window.location.reload();
						},2500);						
					}else{
						unloadingSubmitButton('#org-submit'); 
					}
				}else{
					unloadingSubmitButton('#org-submit'); 
					//$(":submit").removeAttr("disabled");
					showMessage(response.message, "error", "toastr");
				}
			});
		} 
});

$(document).on("change",".sidebar input, input.org-input",function(){ 
	$('.sidebar .org-error').fadeOut();
}); 

function resetOrg(){
	formmodified = 0;
	location.reload();
}

$(document).ready(function() {
    setTimeout(function(){
		$(".org-maxname").each(function(index, value){ 
			if(value.innerText.length > 10){
				$(this).attr("title", value.innerText);
			}
		})
	},500);
}); 



