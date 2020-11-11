<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail; 
 
use App\Http\Requests\StoreEnquiryPost;

use App\Mail\EnquiryMail;
  

class PagesController extends Controller  
{
    //
    public function index()
    {
        return view('pages.index');
        
    }
	
	public function about()
    {
        return view('pages.about');
        
    }
	public function history()
    {
        return view('pages.history');
        
    }
	public function quality_measures()
    {
        return view('pages.quality-measures');
        
    }
	public function our_services()
    {
        return view('pages.our-services');
        
    }
	public function nursing_services()
    {
        return view('pages.nursing-services');
        
    }
	public function health_aid_services()
    {
        return view('pages.health-aid-services');
        
    }
	public function physical_occupational_services()
    {
        return view('pages.physical-occupational-services');
        
    }
	public function revival_university()
    {
        return view('pages.revival-university');
        
    }
	public function waiver_program()
    {
        return view('pages.waiver-program');
        
    } 
	
	public function enquiry(StoreEnquiryPost $request)
	{ 
		$enquiry = [
			'name' => $request->name,
			'email' => $request->email,
			'phone' => $request->phone,
			'comment' => $request->comment 
		];
		$inserted = DB::table('enquiries')->insert($enquiry);  
		
        if($inserted){ 
			Mail::to($request->email)->send(new EnquiryMail($enquiry));		
			$this->response['status']   = true;  
			$this->response['message']  = str_replace("{enquiry}",$request->title,__('message.enquiry_save_success'));  
		}else{
			$this->response['status']   = false;
			$this->response['message']  = str_replace("{enquiry}",$request->title." ".$request->title,__('message.enquiry_save_failed'));
		} 
        return $this->response();  
	} 
}
