<li>
	<h5><a href="{{route('journeys.assigned_journey_show',[encode_url($notification->data['details']['journey_id'])])}}" data-notif-id="{{$notification->id}}">{{$notification->data['details']['milestone_name']}}</a> Milestone under {{$notification->data['details']['journey_name']}} Journey has been completed by <span>{{$notification->data['user_name']}}</span> Rating {{$notification->data['details']['rating']}}</h5>
	<p class="postedTime"><time class="timeago" datetime="{{ $notification->created_at }}" title="{{ $notification->created_at }}"></time></p>
</li>
