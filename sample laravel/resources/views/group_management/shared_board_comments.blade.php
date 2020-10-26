<div class="sharedBoard_textarea">
	<form method="post" class="ajax-form groupCommentAddForm" id="groupCommentAddForm_{{encode_url($post->id)}}" action="{{ route('groups.store_comment') }}">
		@csrf
		<div class="form-group">
			<textarea name="comment" class="form-control" maxlength="1024" placeholder="Comment"></textarea>
			<input type="hidden" name="post_id" value="{{ $post->id }}" />
		</div>
		<div class="btn-footer text-right mb-0">
			<a href="javascript:" onclick="resetComment()" class="btn btn-grey btnCancel">{{ __('Cancel') }}</a>
			<button type="submit"  class="btn btn-green replyBtn">Reply</button>
		</div>
	</form>
</div>	

@if($post->comments->count() > 0)
<div class="sharedBoardReplies">
@foreach($post->comments as $comment)
	<div class="display-comment comment_{{encode_url($comment->id)}}"> 
		<div class="row">
			<div class="col-md-12 pl-0">
				<div class="row">
					<div class="col-md-1 p-0 sharedBoarduser">
						<img src="{{ profile_image($comment->user->image)}}" class="img-responsive" alt="Shared Board User" />
					</div>
					<div class="col-md-11 sharedboardInfo p-0 pl-2">
						<h4>{{ $comment->user->first_name." ".$comment->user->last_name }} <span class="boardDateTime">{{ get_date_time($comment->created_at) }}</span></h4>
						<div class="sbPostContent pb-0">
							<p class="mb-0">{{ $comment->comment }}</p>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-12 top_right_btn mb-0 pb-1">						
				@if($comment->user_id == user_id())
				<a onclick="editComment('{{encode_url($comment->id)}}','{{ $comment->comment }}','{{encode_url($post->id)}}')" class="editCmtBtn_{{encode_url($comment->id)}} editCmtBtn btn btn-lightblue">Edit</a>
				<a onclick="deleteComment('{{encode_url($comment->id)}}','{{encode_url($post->id)}}')" class="btn btn-lightRed">Delete</a>
				@endif
			</div>
		</div>
		<!--<a href="" id="reply"></a>
		<div id="loadGroupReplayComment_{{ $post->id }}_{{$comment->id}}">
			@include('group_management/shared_board_replay_comments', ['post_id'=>$post->id,'comment_id'=>$comment->id,'comments'=>$comment->replies])
		</div>-->
	</div>	
@endforeach
</div>
@endif
