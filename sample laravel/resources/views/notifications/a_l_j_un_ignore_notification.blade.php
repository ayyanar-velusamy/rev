<li>
	<h5><a href="{{route('journeys.assigned_journey_show',[encode_url($notification->data['details']['journey_id'])])}}" data-notif-id="{{$notification->id}}">{{$notification->data['details']['journey_name']}}</a> Journey has been un-ignored by <span>{{$notification->data['user_name']}}</span> </h5>
	<p class="postedTime"><time class="timeago" datetime="{{ $notification->created_at }}" title="{{ $notification->created_at }}"></time></p>
</li>
