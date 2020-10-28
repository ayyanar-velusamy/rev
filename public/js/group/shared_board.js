$(document).on('click','.sharedBoardCommntentGroup .reply', function() {
	$(this).parents('.sharedBoardCommntentGroup').find('.sharedBoard_textarea').slideToggle();
	$(this).parents('.sharedBoardCommntentGroup').find('.sharedBoardReplies').slideToggle();
	 $('html, body').animate({
		scrollTop: $(this).parents('.sharedBoardCommntentGroup').find('.commentFocus').offset().top+50
	}, 2000);
	
});

$(document).on('click','.sharedBoard_textarea .btn-footer a.btnCancel', function() { 
	$(this).parents('.sharedBoard_textarea').slideUp();
	$(this).parents('.sharedBoardCommntentGroup').find('.sharedBoardReplies').slideUp();
	$(this).parents('.sharedBoardCommntentGroup .sharedBoard_textarea ').find('span.error').hide();  
});


function loadGroupPost(group_id){
	$('#loadGroupPost_'+group_id).load(APP_URL+'/groups/'+group_id+'/load_post', function(){  
	});
}

function loadGroupComment(post_id){
	$('#loadGroupComment_'+post_id).load(APP_URL+'/groups/load_post_comment/'+post_id, function(){ 
		$('#loadGroupComment_'+post_id+' .sharedBoard_textarea').show()
		$('#loadGroupComment_'+post_id+' .sharedBoardReplies').show()
		var replay_count = $('#loadGroupComment_'+post_id+' .display-comment').length;	
		$('.post_'+post_id+' .replies_count .count').text(replay_count);
	});
}

function loadGroupReplayComment(post_id,comment_id){
	$('#loadGroupReplayComment_'+post_id+'_'+comment_id).load(APP_URL+'/groups/load_replay_comment/'+comment_id, function(){});
}

function resetPost(){
	$('#groupPostAddForm').attr('action',APP_URL+'groups/store_post');
	$('#inputBodyName').val('');
	$('#inputJourneyName').prop('selectedIndex',0).trigger('change').val("");
	setTimeout(function(){$('#postSumit').text('Post');});
	resetBackConfirmAlert();
	$('.editBtn').show();
}

function editPost(post_id) {
	resetPost();
	rev_submit_loader(true);
	sendGetRequest(APP_URL+'groups/get_post/'+post_id,function(response){
		if(response.status){
			$('#groupPostAddForm').attr('action',APP_URL+'groups/update_post/'+post_id);
			$('#inputBodyName').val(response.data.content);
			$('#inputJourneyName').val(response.data.journey_id).trigger("change");
			$('#postSumit').text('Update');
			$('.editBtn_'+post_id).hide();
		}
		setTimeout(function(){
			rev_submit_loader(false);
		},700)		
	})
}

function deletePost(post_id) {
	
	var data = {
		_token:$('meta[name="csrf-token"]').attr('content'),
		_method:'DELETE',
		post_id:post_id,
		title:'Delete',
		content:'you want to delete this Post?'
	};
	commonConfirm(data, delete_post);
}

function delete_post(data, callback) {
    sendPostRequest(APP_URL+'/groups/post/'+data.post_id, data, function (response) {
        if (response.status) {
			$('.post_'+data.post_id).remove()
			resetPost();
            showMessage(response.message, "success", "toastr");
        }else{
			showMessage(response.message, "error", "toastr");
		}
    });
    callback();
}

function editComment(comment_id,comment,post_id) {
	var form_id = '#groupCommentAddForm_'+post_id;
	resetComment();	
	$(form_id).attr('action',APP_URL+'groups/update_comment/'+comment_id);
	$(form_id+' textarea').val(comment);
	setTimeout(function(){$('#groupCommentAddForm_'+post_id+' .replyBtn').text('Update');});
	$('.editCmtBtn_'+comment_id).hide();
}

function resetComment(){
	$('.groupCommentAddForm').attr('action',APP_URL+'groups/store_comment');
	$('.groupCommentAddForm textarea').val('');
	setTimeout(function(){$('.groupCommentAddForm .replyBtn').text('Reply')});
	resetBackConfirmAlert();
	$('.editCmtBtn').show();
}

function deleteComment(comment_id,post_id) {
	
	var data = {
		_token:$('meta[name="csrf-token"]').attr('content'),
		_method:'DELETE',
		post_id:post_id,
		comment_id:comment_id,
		name:'Comment'
		};		
	confirmDelete(data, delete_comment);
}

function delete_comment(data, callback) {
    sendPostRequest(APP_URL+'/groups/comment/'+data.comment_id, data, function (response) {
        if (response.status) {
			var $target = $('.replies_count_'+data.post_id+' span');
			$target.text(parseInt($target.text()) -1);
			$('.comment_'+data.comment_id).remove()
            showMessage(response.message, "success", "toastr");
        }else{
			showMessage(response.message, "error", "toastr");
		}
    });
    callback();
}