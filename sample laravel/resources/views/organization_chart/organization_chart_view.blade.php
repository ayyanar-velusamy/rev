@extends('layouts.app')
@section('content')
<div class="page-innerwrap">
	<div class="page-head">
		<ul class="list-inline breadcrumb"> 
			<li class="active"><a>Organizational Chart</a></li>
		</ul>
	</div>
    <div class="page-content">
        {!! Form::open([ 'route' => 'organization-chart.store', 'enctype' => 'multipart/form-data', 'class' => 'clearfix', 'id' => 'organization_chart_form' ]) !!}  
        <div class="org_container">
            <!--form class="form-horizontal clearfix" id="chart_form"-->
                <div id="orgChartContainer" class="clearfix">
                    <div class="sidebar padding-none">
						<div class="org-error"></div>
                    </div>
                    <div class="org-chart-sec padding-none "> 
                        <div id="orgChart"></div> 
                    </div>
                </div>
                <div class="chart_footer btn-footer text-center clearfix">
                    <button type="button" class="btn btn-grey"  data-toggle="modal" data-target="#org-modal">Restore</button>
                    <button type="submit" id="org-submit" class="btn btn-blue">Save</button>
                </div>
            <!--/form-->
        </div>
       	{{ Form::close() }}
    </div>
 </div>
 
<!--Reset-->
<div id="org-modal" class="modal fade in" role="dialog" data-backdrop="static">
	<div class="modal-dialog modal-dialog-centered">
	<!-- Modal content-->
		<div class="modal-content text-left">
			<div class="modal-header">
				<h2>Restore</h2>
				<button type="button" class="btn-close" data-dismiss="modal" title="Close" >x</button>
			</div>
			<div class="modal-body text-center">
				<h4><span>Are you sure </span>you want to restore this organization?</h4>
				<div class="PTB20 btn-footer">
					<button type="button" class="btn-grey btn" data-dismiss="modal">No</button>
					<button type="button" class="btn btn-green" onClick="resetOrg()" >Yes</button>
				</div>
			</div>
		</div>
	</div>
</div>
 
<!--Delete node delete all its sub-divisions first-->
<div id="delete-node1" class="modal fade in" role="dialog" data-backdrop="static">
	<div class="modal-dialog modal-dialog-centered">
	<!-- Modal content-->
		<div class="modal-content text-left">
			<div class="modal-header">
				<h2>Delete Node</h2>
				<button type="button" class="btn-close" data-dismiss="modal" title="Close" >x</button>
			</div>
			<div class="modal-body text-center">
				<h4><span>To remove this node, </span>please remove all its sub-divisions first</h4>
				<div class="PTB20 btn-footer">
					<button type="button" class="btn-green btn" data-dismiss="modal">Ok</button>
				</div>
			</div>
		</div>
	</div>
</div>
 
<!--Delete node already used in employee table-->
<div id="delete-node2" class="modal fade in" role="dialog" data-backdrop="static">
	<div class="modal-dialog modal-dialog-centered">
	<!-- Modal content-->
		<div class="modal-content text-left">
			<div class="modal-header">
				<h2>Delete Node</h2>
				<button type="button" class="btn-close" data-dismiss="modal" title="Close" >x</button>
			</div>
			<div class="modal-body text-center">
				<h4><span>This divisions data already used in employee table</span></h4>
				<div class="PTB20 btn-footer">
					<button type="button" class="btn-green btn" data-dismiss="modal">Ok</button>
				</div>
			</div>
		</div>
	</div>
</div>

<!--Delete node Permission-->
<div id="delete_node_persmision" class="modal fade in" role="dialog" data-backdrop="static">
	<div class="modal-dialog modal-dialog-centered">
	<!-- Modal content-->
		<div class="modal-content text-left">
			<div class="modal-header">
				<h2>Delete Node</h2>
				<button type="button" class="btn-close" data-dismiss="modal" title="Close" >x</button>
			</div>
			<div class="modal-body text-center">
				<h4></h4>
				<div class="PTB20 btn-footer">
					<button type="button" class="btn-grey btn" data-dismiss="modal">No</button>
					<button type="button" id="org-delete-btn" class="btn btn-green">Yes</button>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection   


