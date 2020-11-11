@extends('layouts.app')
@section('content')
<div class="page-innerwrap">
	<div class="page-head">
		<ul class="list-inline breadcrumb"> 
			<li class="active"><a>Enquiry List</a></li>  
		</ul>
		<div class="top_search_box">
			<form>
				<input id="dataTableSearch" type="input" name="serching" placeholder="Search" />
			</form>	
		</div>
	</div>
	<div class="page-content"> 
		<div class="comn_dataTable"> 
			<div class="table-responsive">
				<table id="enquiryList" class="table dataTable" style="width:100%"> 
					<thead> 
						<tr>
							<th>Name</th>
							<th>Email</th> 
							<th>Mobile</th> 
							<th>comment</th> 
						</tr>
					</thead>
				</table>
			</div>
		</div>
	</div>
</div>  

@endsection
