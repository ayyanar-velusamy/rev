<li>
	<h5><span>{{$notification->data['user_name']}}</span> has Updated <a href="{{route('profile_view')}}" data-notif-id="{{$notification->id}}">Your Profile</a></h5>
	<p class="postedTime"><time class="timeago" datetime="{{ $notification->created_at }}" title="{{ $notification->created_at }}"></time></p>
</li>
