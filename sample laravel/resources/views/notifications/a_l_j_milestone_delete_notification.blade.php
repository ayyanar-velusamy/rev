<li>
	<h5><a href="{{route('journeys.index')}}" data-notif-id="{{$notification->id}}">{{$notification->data['details']['title']}}</a> Milestone under <span class="subName">{{$notification->data['details']['journey_name']}}</span> Journey has been deleted by <span>{{$notification->data['user_name']}}</span> </h5>
	<p class="postedTime"><time class="timeago" datetime="{{ $notification->created_at }}" title="{{ $notification->created_at }}"></time></p>
</li>
