@extends('layouts.app')
@section('content')
<div class="page-innerwrap">
	<div class="page-head">
		<ul class="list-inline breadcrumb">
			<li class="active"><a>Organizational List</a></li>
		</ul>
	</div>
<div class="page-content">	
	<div class="chart_design clearfix">
		<div class="row">
			<div class="col-sm-12 fullorgView" id="org_list_scroll">
				{!! $list_view !!}
			</div>
		</div>
	 </div>
</div> 
@endsection                    
@section('footer_script')
<script src="{{ asset('js/jquery-treeview.js') }}"></script>
@endsection

