<li>
	<h5><a href="javascript:;" data-notif-id="{{$notification->id}}"><span>{{ $notification->data['details']['title'] }}</span></a> Milestone has been rejected by {{$notification->data['user_name']}}</h5>
	<p class="postedTime"><time class="timeago" datetime="{{ $notification->created_at }}" title="{{ $notification->created_at }}"></time></p>
</li>