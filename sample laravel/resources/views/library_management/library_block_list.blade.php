@foreach($data as $key=>$content)
	@if(is_array($content))
	<div class="col-md-4 lib_grid">
		<div class="lib_grid_inner">
			<div class="lib_grid_top">
				<img src="{{asset('images/lib_'.strtolower($content['content_type']).'.png') }}"  alt="User Image">
				<h4>{{$content['title']}}</h4>
				<p class="content_type">{{$content['content_type']}}</p>
				<p class="uploaded_by">{{$content['created_name']}}</p>
				<p class="rating">{{$content['rating']}}</p>
			</div>	
			<div class="lib_grid_bottom">	
				<h5 class="date">{{$content['created_date']}}</h5>
				<span class="expand"><i class="icon-Expand animation " title="More"></i>
					<div class="btn-dropdown">
						<ul class="list-unstyled"> 
							{!! $content['action'] !!}
							<!--<li><a class="btn btn-blue">Assign</a></li>
							<li><a class="btn btn-lightblue">Edit</a></li>
							<li><a class="btn btn-red">Delete</a></li>
							<li><a class="btn btn-darkblue">Add to My Journey</a></li>-->
						</ul>
					</div>
				</span>
			</div>
		</div> 
	</div> 	
	@endif
@endforeach
