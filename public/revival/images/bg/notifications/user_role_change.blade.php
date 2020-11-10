<li>
	<h5><span>{{ucfirst($notification->data['details']['first_name'])." ".ucfirst($notification->data['details']['last_name'])}}</span> has created the <a href="#">Learning Journey</a></h5>
	<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s,</p>
	<p class="postedTime"><time class="timeago" datetime="{{ $notification->created_at }}" title="{{ $notification->created_at }}"></time></p>
</li>
