<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;  

 
class EnquiryController extends BaseController  
{  
	Public function __construct(){
		parent::__construct();
	} 
	
	public function ajax_list(Request $request)
    {
		$data = $whereArray = array(); 
		$enquiries = DB::table('enquiries'); 
		$enquiries->select('*');   
		if(!empty($whereArray)){
			foreach($whereArray as $key => $where){
				$enquiries->where($where['field'],$where['condition'],$where['value']);
			} 
		}
		
		if($request->input('search.value')){
			$search_for = $request->input('search.value');
			$enquiries->where(function($query) use ($search_for){
				$query->where('enquiries.name', 'LIKE', '%'.$search_for.'%');
				$query->orWhere('enquiries.email', 'LIKE', '%'.$search_for.'%');
				$query->orWhere('enquiries.phone', 'LIKE', '%'.$search_for.'%'); 
				$query->orWhere('enquiries.comment', 'LIKE', '%'.$search_for.'%'); 
			});			
		}
		$enquiries->orderBy('enquiries.id', 'DESC'); 
		$pageData = $enquiries->get(); 
		foreach($pageData as $key => $row){
		   
           $data[$key]['id']        = ''; 
		   $data[$key]['name'] 		= $row->name;
		   $data[$key]['email']		= $row->email; 
		   $data[$key]['phone']		= $row->phone;   
		   $data[$key]['comment']	= $row->comment;   
	   }
	   
	   return datatables()->of($data)->make(true); 
    } 
	 
	public function index()
	{ 						
		return view('enquiry.list');
	}   
}
