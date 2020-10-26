<li>
	<h5><span>{{$notification->data['user_name']}}</span> has replied to your <a href="{{route('groups.shared_board',[encode_url($notification->data['details']['group_id'])])}}" data-notif-id="{{$notification->id}}">Post</a></h5>
	<p class="postedTime"><time class="timeago" datetime="{{ $notification->created_at }}" title="{{ $notification->created_at }}"></time></p>
</li>
