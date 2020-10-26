<li>
	<h5><span>{{$notification->data['user_name']}}</span> has Created <a href="{{route('roles.show',[encode_url($notification->data['details']['id'])])}}" data-notif-id="{{$notification->id}}" >{{ $notification->data['details']['name'] }}</a></h5>
	<p class="postedTime"><time class="timeago" datetime="{{ $notification->created_at }}" title="{{ $notification->created_at }}"></time></p>
</li>
