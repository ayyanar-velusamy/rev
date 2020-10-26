<li>
	<h5><a href="javascript:;" data-notif-id="{{$notification->id}}">{{ $notification->data['details']['title'] }}</a> Milestone has been approved by <span>{{$notification->data['user_name']}}</span></h5>
	<p class="postedTime"><time class="timeago" datetime="{{ $notification->created_at }}" title="{{ $notification->created_at }}"></time></p>
</li>
