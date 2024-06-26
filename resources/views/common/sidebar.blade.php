<div class="col-sm-1 left-sidebar padding-none" >
	<div class="main_menu text-center clearfix" id="sidebar_scroll">
	<ul class="list-unstyled">  
		<li class="left_menu_list dashboard {{ request()->is('dashboard*') ? 'active' : '' }}">
			<a href="{{ route('dashboard.index')}}" tabindex="1">
				<i class="icon-dashboard" title="Dashboard"></i>
				<h5 class="fw600">Dashboard</h5>
			</a>
		</li>  
		 <li class="left_menu_list user_management {{ request()->is('pages*') ? 'active' : '' }}">
			<a title="Page Management" href="{{ route('pages.index')}}"  tabindex="2">
				<i class="icon-user"></i>
				<h5 class="fw600">Pages Management</h5>
			</a>
		</li> 
		<li class="left_menu_list enquiries_management {{ request()->is('enquiries*') ? 'active' : '' }}">
			<a title="Enquiries" href="{{ route('enquiries.index')}}"  tabindex="2">
				<i class="icon-mail"></i>
				<h5 class="fw600">Enquiries</h5>
			</a>
		</li> 
	</ul>
	</div>
	<div class="side_footer text-center col-sm-12 padding-none">
		<span>&copy;</span>
		<span class="text-upper">{{ date('Y') }} Revival</span>
	</div>
</div>
 

<div id="loadAddLearningJourney"></div>

<div class="modal modal-danger fade" id="modal-danger" data-backdrop="static">
		<div class="modal-dialog modal-dialog-centered">
		  <div class="modal-content">
			<div class="modal-header">	
				<h2>Delete</h2>
				<button type="button" class="btn-close" title="Close" data-dismiss="modal">x</button>
			</div>
			<div class="modal-body">
				<input type="hidden" id="commonDeleteId">
				<h4>Are you sure <span>you want to delete <span id="commonDeleteName"></span>?</span></h4>
				<div class="btn-footer">
				  <button type="button" id="deleteNo" class="btn btn-grey" data-dismiss="modal">No</button>
				  <button type="button" id="deleteYes" class="btn btn-green modal-submit-yes">Yes</button>
				</div>
		  </div>
		  <!-- /.modal-content -->
		</div>
		<!-- /.modal-dialog -->
	</div>
</div>
<div class="modal modal600 modal-danger fade" id="common-confirm" data-backdrop="static" data-keyboard="false">
		<div class="modal-dialog modal-dialog-centered">
		  <div class="modal-content">
			<div class="modal-header">	
				<h2 id="common-confirm-title"></h2>
				<button type="button" class="btn-close" title="Close" data-dismiss="modal">x</button>
			</div>
			<div class="modal-body">
				<input type="hidden" id="commonConfirmId">
				<h4>Are you sure <span id="common-confirm-content"></span> <span id="common-confirm-name"></span></h4>
				<div class="btn-footer">
				  <button type="button" id="commonNo" class="btn btn-grey" data-dismiss="modal">No</button>
				  <button type="button" id="commonYes" class="btn btn-green modal-submit-yes">Yes</button>
				</div>
		  </div>
		  <!-- /.modal-content -->
		</div>
		<!-- /.modal-dialog -->
	</div>
</div>