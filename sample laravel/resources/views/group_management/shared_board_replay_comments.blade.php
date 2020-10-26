<hr />
<form method="post" class="ajax-form" id="groupReplayAddForm" action="{{ route('groups.store_comment') }}">
	@csrf
	<div class="form-group">
		<input type="text" name="comment" class="form-control" />
		<input type="hidden" name="post_id" value="{{ $post_id }}" />
		<input type="hidden" name="comment_id" value="{{ $comment_id }}" />
		<input type="hidden" name="is_replay_comment" value="true" />
	</div>
	<div class="form-group">
		<input type="submit" class="btn btn-warning" value="Reply" />
	</div>
</form>

@if($comments->count() > 0)
<div class="ml-5">
@foreach($comments as $comment)
	<div class="display-comment comment_{{encode_url($comment->id)}}">
		<div class="row">
			<div class="col-md-10">
				<p><strong>{{ $comment->user->first_name." ".$comment->user->last_name }}</strong>
						 <span class="boardDateTime">{{ get_date_time($comment->created_at) }}</span></p>
				<p>{{ $comment->comment }}</p>
			</div>
			<div class="col-md-2">
				@if($comment->user_id == user_id())
				<a onclick="deleteComment('{{encode_url($comment->id)}}')" class="btn btn-danger">Delete</a>
				@endif
			</div>
		</div>
	</div>
@endforeach
</div>
@endif
					