<li>
	<h5><span>{{$notification->data['user_name']}}</span> has made you the Group Admin for the <a href="{{route('groups.show',[encode_url($notification->data['details']['group_id'])])}}" data-notif-id="{{$notification->id}}">{{$notification->data['details']['group_name']}}</a> Group  </h5>
	<p class="postedTime"><time class="timeago" datetime="{{ $notification->created_at }}" title="{{ $notification->created_at }}"></time></p>
</li>
