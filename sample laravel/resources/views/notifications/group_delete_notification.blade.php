<li>
	<h5><span>{{$notification->data['user_name']}}</span> has deleted the <a href="{{route('groups.index')}}" data-notif-id="{{$notification->id}}">{{$notification->data['details']['group_name']}}</a> Group  </h5>
	<p class="postedTime"><time class="timeago" datetime="{{ $notification->created_at }}" title="{{ $notification->created_at }}"></time></p>
</li>
