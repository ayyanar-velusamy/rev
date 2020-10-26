<li>
	<h5><a href="{{route('libraries.index')}}" data-notif-id="{{$notification->id}}">{{$notification->data['details']['content_name']}}</a> Content has been deleted by <span>{{$notification->data['user_name']}}</span> </h5>
	<p class="postedTime"><time class="timeago" datetime="{{ $notification->created_at }}" title="{{ $notification->created_at }}"></time></p>
</li>