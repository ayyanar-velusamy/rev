<?php

namespace App\Http\Controllers;

use \stdClass;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail; 

use App\Model\Page;  
 
use App\Http\Requests\StoreEnquiryPost;

use App\Mail\EnquiryMail;

  

class PagesController extends Controller  
{
    //
    public function index()
    {
		$page = Page::findOrFail(1); 
        return view('pages.index', compact('page')); 	
    }
	
	public function about()
    {
		$page = Page::findOrFail(2); 
        return view('pages.about', compact('page'));  
        
    }
	public function history()
    {
        $page = Page::findOrFail(3); 
        return view('pages.history', compact('page'));  
        
    }
	public function quality_measures()
    {
		$page = Page::findOrFail(4);  
        return view('pages.quality-measures', compact('page'));
        
    }
	public function our_services()
    {
		$page = Page::findOrFail(5);  
        return view('pages.our-services', compact('page'));
        
    }
	public function nursing_services()
    {
		$page = $this->default_page_content();   
        return view('pages.nursing-services', compact('page'));
        
    }
	public function health_aid_services()
    {
		$page = $this->default_page_content();   
        return view('pages.health-aid-services', compact('page'));
        
    }
	public function physical_occupational_services()
    {
		$page = $this->default_page_content();   
        return view('pages.physical-occupational-services', compact('page'));
        
    }
	public function revival_university()
    {
		$page = $this->default_page_content();   
        return view('pages.revival-university', compact('page'));
        
    }
	public function waiver_program()
    {
		$page = $this->default_page_content();   
        return view('pages.waiver-program', compact('page'));
        
    } 
	public function find_location()
    {
		$page = $this->default_page_content();   
        return view('pages.find-location', compact('page'));  
        
    }	
	public function maryland_contact_form()
    {
		$page = $this->default_page_content();   
        return view('pages.maryland-contact-form', compact('page'));  
        
    } 
	public function annandale_contact_form()
    {
		$page = $this->default_page_content();
        return view('pages.annandale-contact-form', compact('page'));  
        
    } 
	public function richmond_contact_form()
    {
		$page = $this->default_page_content();   
        return view('pages.richmond-contact-form', compact('page'));  
        
    } 
	public function houston_contact_form()
    {
		$page = $this->default_page_content();   
        return view('pages.houston-contact-form');  
        
    } 
    public function careers()
    {
		$page = Page::findOrFail(6);   
        return view('pages.careers', compact('page'));
        
    }
    public function resources()
    {
		$page = Page::findOrFail(7);   
        return view('pages.resources', compact('page'));
        
    }
    public function contact()
    {
		$page = $this->default_page_content();   
        return view('pages.contact', compact('page'));
        
    } 
	
	public function enquiry(StoreEnquiryPost $request)
	{ 
		$enquiry = [
			'form_name' => (!empty($request->form_name))? $request->form_name : "Contact Form",
			'name' => $request->name,
			'email' => $request->email,
			'phone' => $request->phone,
			'comment' => $request->comment 
		];
		$inserted = DB::table('enquiries')->insert($enquiry);  
		
        if($inserted){ 
			//Mail::to($request->email)->send(new EnquiryMail($enquiry));		
			$this->response['status']   = true;  
			$this->response['message']  = str_replace("{enquiry}",$request->title,__('message.enquiry_save_success'));  
		}else{
			$this->response['status']   = false;
			$this->response['message']  = str_replace("{enquiry}",$request->title." ".$request->title,__('message.enquiry_save_failed'));
		} 
        return $this->response();  
	} 
	
	function default_page_content(){
		$page = new stdClass();
		$page->title = "Revival";
		$page->meta_description = "Revival";
		$page->meta_keyword = "Revival"; 
		return $page;
	}
}
