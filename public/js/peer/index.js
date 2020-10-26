$(function(){
	peerManagementList(); 

	//Remove milestone count dropdown duplicates
	removeDuplicateOption('.peersFilter .filterByPoint');
	removeDuplicateOption('.peersFilter .filterByCount');
});