$(document).ready(function() {	
	//Initial active tab datatable
	activeDataTable = "my_journey";
	journeyListFilter(activeDataTable);
	myLearningjourneyManagement();
});

$(document).ready(function(){
    $('.journey_list .nav-tabs li a[data-toggle="tab"]').on('show.bs.tab', function(e) {
        localStorage.setItem('journeyListActiveTab', $(e.target).attr('href'));
    });
    var journeyListActiveTab = localStorage.getItem('journeyListActiveTab');
	breakDownCateory = (window.location.href.indexOf("assigned") > -1) ? 'owner':'user';
    if(journeyListActiveTab){
        $('#joureyTab a[href="' + journeyListActiveTab + '"]').tab('show').click();
    }
});


$(document).on('keyup change','#dataTableSearch', function () {
	if(activeDataTable == 'my_journey'){
		myLearningjourneyManagementTable.search($(this).val()).draw();
	}else if(activeDataTable == 'predefined_journey'){
		prdefinedLearningjourneyManagementTable.search($(this).val()).draw();
	}else{
		assignedLearningJourneyManagementTable.search($(this).val()).draw();
	}
});