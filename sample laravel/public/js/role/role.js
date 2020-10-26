var roleMangementTable;

$(document).on('submit','form',function(e){
    if($(this).hasClass('ajax-form')){
    e.preventDefault()
    let url = $(this).attr('action');
    let target = ('#'+$(this).attr('id') == '#undefined') ? 'body' : '#'+$(this).attr('id');
    let myEle = document.getElementById("inputFile");
    let file = false;
    
	if(myEle){
        file = (document.getElementById("inputFile").files.length == 0) ? false : true
    }       
    let messagePosition = 'toastr';
    $.easyAjax({
        url: url,
        container: target,
        type: "POST",
        redirect: true,
        disableButton: true,
        file: file,
        data: $(this).serialize(),
        messagePosition:messagePosition,
    }, function(res){
       if(res.cartProductCount){
          $('#cartProductCount').text(res.cartProductCount);
       }
    });
  }
});

function deleteRole(role_id, name) {
	
	var data = {
		_token:$('meta[name="csrf-token"]').attr('content'),
		_method:'DELETE',
		role_id:role_id,
		title:'Delete Role',
		content:'you want to delete '+name+'?'
	};		
	commonConfirm(data, delete_role);
}

function delete_role(data, callback) {
    sendPostRequest(APP_URL+'/roles/'+data.role_id, data, function (response) {
        if (response.status) {
			roleMangementTable.draw();
            showMessage(response.message, "success", "toastr");
        }else{
			showMessage(response.message, "error", "toastr");
		}
    });
    callback();
}

$(document).ready(function() {
		roleMangementTable = $('#roleList').DataTable({
		"processing": true,
		"dom": '<"top">rt<"bottom"ilp><"clear">',
		"serverSide": true, 
		"ajax": APP_URL+"/role_list",
		"columns": [
			{data: 'name', name: 'name'},
			{data: 'created_at', name: 'created_at'},
			{data: 'status', name: 'status'},
			{data: 'action', name: 'action', orderable: false, searchable: false},
		],
		"order": [],
		"columnDefs": [
			{ className: "actions action_btn", "orderable": false, "targets": [ 3 ] }
		],
		"createdRow": function ( row, data, index ) {
			$('td', row).eq(0).html("<span class='maxname'>" + data['name'] + "</span>");
			if(data.status == 'Inactive'){
				$(row).find('td').addClass("table_row_disabled").css({"background-color": '#fbfbfb', "opacity":"0.5"});
				$(row).find('td .btn').css({"color": '#ffffff'});
			}
		},
		"lengthMenu": [[10, 25, 50,100 , -1], [10, 25, 50, 100, "All"]],
		language: {
			search: "_INPUT_",
			searchPlaceholder: "Search...",
			sInfo: "Showing _START_ to _END_ of _TOTAL_",
			lengthMenu: "Show _MENU_",
			"paginate": {
			  "previous": "Prev."
			}
		}
	});
	//$(".dataTables_filter").append('');
});



//Permission check box for role management
$(document).on('change',"input[name='permissions[]']", function(e){
	var className = $(this).attr('class').split(' ')[0];
	var view_checked = 0;
	if($(this).hasClass('full')){
		if($(this).is(":checked")){
			$('.'+className).prop('checked', true);
			view_checked++;
		}else{
			$('.'+className).prop('checked', false);
		}
	}else{
		var checked_all = true;		
		$('.'+className).each(function(index, currentElement) {
			if(!$(currentElement).hasClass('full')){
				if(!$(currentElement).is(":checked")){
					checked_all = false;
				}
				
				//If any single permission checked
				//view permission made as checked				
				if(!$(currentElement).hasClass('view')){
					if($(currentElement).is(":checked")){
						view_checked++;
					}
				}
				
			}
		});
	}
	
	setTimeout(function(){
		//If any single permission checked
		//view permission made as checked	
		var checked = (view_checked > 0) ? true : false;
		$('.'+className+'.view').prop('checked', checked);
		
		$('.'+className+'.full').prop('checked', checked_all);
		setFullAccessCheckBox()
	});

});

//Full access check box
$(document).on('change','.full_access',function(e){
	if($(this).is(":checked")){
		$("input[name='permissions[]']").prop('checked', true);
	}else{
		$("input[name='permissions[]']").prop('checked', false);
	}
});

//Set Full access check box checked/unchecked
$(document).ready(function(){
	setFullAccessCheckBox();
});

$(document).on('keyup change','#dataTableSearch', function () {
    roleMangementTable.search($(this).val()).draw();
});

function setFullAccessCheckBox(){
	var fullAccess = true;
	$('.full').each(function(index, currentElement) {
		if(!$(currentElement).is(":checked")){
			fullAccess = false;
		}
	});
	
	setTimeout(function(){
		$('.full_access').prop('checked', fullAccess);
	});
}




