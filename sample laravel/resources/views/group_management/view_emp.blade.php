@extends('layout.default')
@section('content')

<div class="col-sm-11 main_sec padding-none">
	<div class="text_shadow">
		<ul class="list-inline breadcrumb">
			<li><a href="{{ url('/emp-management') }}">Employee Management</a></li>
			<li class="active"><a href="#">List</a></li>
		</ul>
	</div>
	<div class="chart_design clearfix">
		<div class="filter_icons clearfix col-sm-12 text-right">
			<div class="filter_search col-sm-11 text-right padding-none">
				<form class="form-horizontal" id="form-filter_emp">
					<div class="row">
						<div class="form-group col-sm-2 padding-none">
							<select class="form-control">
								<option hidden>Select Unit</option>
								<option>Unit-1</option>
								<option>Unit-2</option>
							</select>
						</div>
						<div class="form-group col-sm-3 padding-none">
							<select class="form-control">
								<option hidden>Select Department</option>
								<option>RMS</option>
								<option>WaMDS</option>
							</select>
						</div>
						<div class="form-group col-sm-2 padding-none">
							<select class="form-control">
								<option hidden>Select Division</option>
								<option>Business Analysis</option>
								<option>Development</option>
							</select>
						</div>
						<div class="form-group col-sm-2 padding-none">
							<select class="form-control">
								<option hidden>Select Level</option>
								<option>Senior</option>
								<option>Junior</option>
							</select>
						</div>
						<div class="form-group col-sm-2 padding-none">
							<select class="form-control">
								<option hidden>Active Users</option>
								<option>Active</option>
							</select>
						</div>
					</div>
				</form>
			</div>
			<div class="filter_emp col-sm-1 padding-none">
				<div class="col-sm-6 padding-none">
					<span>
						<i class="icon-filter"></i>
					</span>
				</div>
				<div class="col-sm-6">
						
					
				</div>
			
			</div><!--filter employee add form-->
		</div>
	</div>
	<div class="content_sec">
		<div class="row">
			<div id="employee_view" class="col-sm-6 padding-left-none">
				<table id="employee_view_table" class="display" cellspacing="0" width="100%"></table>
			</div>
			<!--active employee starts-->
			<div class="col-sm-6 active-employee padding-none animation">
				<div class="col-sm-12 active_employee_profile">
					<div class="row">
						<div class="col-sm-3 view_emp_profile">
							<img src="images/hr_profile.png" alt="hr_profile" class="img-responsive" />
							<div class="active_emp_small">
								<img src="images/profile_small_green.png" alt="profile_small_green" class="img-responsive" />
							</div>
						</div>
						<div class="col-sm-9 view_emp_content padding-left-none">
							<div class="col-sm-6  padding-left-none">
								<span class="fw300">ST-956</span>
								<h4>Charles Carter</h4>
							</div>
							<div class="admin_count text-right col-sm-6">
								<i class="icon-points"></i><span class="fw300">225</span>
							</div>
						</div>
					</div>
				</div>
				<div class="col-sm-12 active-employee_content padding-none text-center">
					<div class="row">
						<div class="col-sm-12">
							<div class="col-sm-3"></div>
							<div class="admin_mail col-sm-9 padding-none">
								<span>Jamescmorrison@jourrapide.com |</span>
								<span>336-971-6771</span>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-12 text-left">
							<h4 class="text-green MTB10">Level</h4>
							<div class="col-sm-12 padding-none level-content MTB10">
								<div class="col-sm-3 padding-none MB10">
									<h5 class="text-upper fw600 text-center">unit</h5>
									<div class="col-sm-12 padding-none text-center MTB10">
										<span class="text-green fw600">Unit A</span>
									</div>
								</div>
								<div class="col-sm-3 padding-none MB10">
									<h5 class="text-upper fw600 text-center">department</h5>
									<div class="col-sm-12 padding-none text-center MTB10">
										<span class="text-green fw600">WaMDS</span>
									</div>
								</div>
								<div class="col-sm-3 padding-none MB10">
									<h5 class="text-upper fw600 text-center">Team</h5>
									<div class="col-sm-12 padding-none MTB10 text-center">
										<span class="text-green fw600">Design</span>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-12  text-left">
							<h4 class="text-green MTB10">Preferences/Employee interests</h4>
							<div class="col-sm-12  padding-none preference-content MTB30">
								<div class="col-sm-3 padding-none text-center">
									<span class="fw600">Politics</span>
								</div>
								<div class="col-sm-3  padding-none text-center">
									<span class="fw600">Sports</span>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!--active employee starts-->
		</div>
	</div>

<div id="emp_edit_modal" class="modal right fade" role="dialog">
	<div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content text-left">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Edit Employee</h4>
			</div>
			<div class="modal-body emp_edit_panel">

			</div>
		</div>
	</div>
</div>


					

<script>
$(document).ready(function(){


 var table = $('#employee_view_table').DataTable({
	  processing: true,
	  language: {processing: "Searching..."},
      serverside: true,
      responsive: true,
      autoWidth: false,
      colReorder: true,
      select: {style: 'single'},
      //initComplete: function ( settings, json ),
      pageLength: 10,
      order: [1, 'asc'],
      dom: "<'row'<'col-sm-2 col-md-4'l><'col-sm-6 col-md-4 text-center'B><'col-sm-4 col-md-4'f>>" + "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-5'i><'col-sm-7'p>>",
      ajax: "list_emp",
	    columns: [
	   {
          title: 'Employee Name',
          data: 'emp_name'
        },
        {
          title: 'Email ID',
          data: 'emp_email_id'
        },
		

		 ],
    });


});
</script>
@endsection