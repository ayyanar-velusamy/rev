<li>
	<h5><a href="{{route('journeys.show',[encode_url($notification->data['details']['journey_id'])])}}" data-notif-id="{{$notification->id}}">{{$notification->data['details']['title']}}</a> Milestone under <span class="subName">{{$notification->data['details']['journey_name']}}</span> Journey has been updated by <span>{{$notification->data['user_name']}}</span> </h5>
	<p class="postedTime"><time class="timeago" datetime="{{ $notification->created_at }}" title="{{ $notification->created_at }}"></time></p>
</li>