<li>
	<h5>You have successfully gained {{$notification->data['details']['point'] }} more points
 {{$notification->data['details']['total_point'] }} <a href="{{url('/passport')}}" data-notif-id="{{$notification->id}}">Total Points</a></h5>
	<p class="postedTime"><time class="timeago" datetime="{{ $notification->created_at }}" title="{{ $notification->created_at }}"></time></p>
</li>
