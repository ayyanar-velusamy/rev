<div class="white-content pt-0">
	<div class="inner-content">
		<div class="sharedBoardPostContent">
			@foreach($posts as $post)
			<div class="post_{{encode_url($post->id)}} sharedBoardCommntentGroup">
				<div class="row">
					<div class="col-md-9 pl-0">
						<div class="row">
							<div class="col-md-1 sharedboarduser p-0">
								<img width=50 height=50 src="{{ profile_image($post->user->image) }}" class="img-responsive" alt="Shared Board User" />
							</div>
							<div class="col-md-10 sharedboardInfo pl-2">
								<h4>{{ $post->user->first_name." ".$post->user->last_name }} - {{ $post->journey->journey_name }}
								 <span class="boardDateTime">{{ get_date_time($post->created_at) }}</span></h4>
									 
							</div>
						</div>
					</div>
					<div class="col-md-3 top_right_btn mb-0">						
						@if($post->created_by == user_id())
						<a onclick="editPost('{{encode_url($post->id)}}')" class="editBtn_{{encode_url($post->id)}} editBtn btn btn-lightblue">Edit</a>
						<a onclick="deletePost('{{encode_url($post->id)}}')" class="btn btn-lightRed">Delete</a>
						@endif
					</div>
				</div>
				<div class="sbPostContent">
						<p>{{ $post->content }}</p>
						<p class="reply"><a class="replies_count replies_count_{{encode_url($post->id)}}"><span class="count">{{$post->comments->count()}}</span> Replies</a> | <a class="replies_comment"><i class="icon-comment"></i> Reply Comment</a>
				</div>
				<div id="loadGroupComment_{{encode_url($post->id)}}" class="commentFocus">
					@include('group_management/shared_board_comments')
				</div>
			</div>
			@endforeach
		</div>
	</div>	
</div>
