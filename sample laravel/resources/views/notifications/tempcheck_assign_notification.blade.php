<li>
	<h5><span>{{$notification->data['user_name']}}</span>  has assigned a <a href="{{route('tempchecks.assigned_index')}}" data-notif-id="{{$notification->id}}">tempcheck</a> to you </h5>
	<p class="postedTime"><time class="timeago" datetime="{{ $notification->created_at }}" title="{{ $notification->created_at }}"></time></p>
</li>
