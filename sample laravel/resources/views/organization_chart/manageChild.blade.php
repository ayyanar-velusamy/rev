<ul>
@foreach($childs as $child)
	<li>
	    {{ $child->node_name }}
	@if(count($child->childs))
            @include('organization_chart.manageChild',['childs' => $child->childs])
        @endif
	</li>
@endforeach
</ul>