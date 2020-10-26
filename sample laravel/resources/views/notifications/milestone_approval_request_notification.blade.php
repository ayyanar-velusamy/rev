<li>
	<h5><span>{{$notification->data['user_name']}}</span> has submitted the milestone <a href="{{ route('approvals.index') }}" data-notif-id="{{$notification->id}}">{{$notification->data['details']['title']}}</a> for approval</h5>
	<p class="postedTime"><time class="timeago" datetime="{{ $notification->created_at }}" title="{{ $notification->created_at }}"></time></p>
</li>
