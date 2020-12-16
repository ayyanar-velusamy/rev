<?php

namespace App\Http\Controllers;

use \stdClass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail; 

use App\Model\Page;
use App\Model\Slider;
use App\Model\Menu;
use App\Http\Requests\StoreEnquiryPost;
use App\Mail\EnquiryMail; 
use View; 

class PagesController extends Controller  
{
    public $pathName = "";
    public $menus = [];
   
	
	public function __construct(){ 
		$this->pathName = Route::currentRouteName(); 
		$this->menus = Menu::where(['status' => "1"])->select('*')->get(); 
		$menu_list = [];  
		foreach($this->menus as $key=>$nav){
			  $menu = new stdClass();
			  $menu->id = $nav->id;
			  $menu->menu = $nav->menu;
			  $menu->type = $nav->type;
			  $menu->link = $nav->link;
			  $menu->route = $nav->route;
			  $menu->parent_menu = $nav->parent_menu;
			  $menu->status = $nav->status;	
			  $menu->isActive = ($this->pathName == $nav->route)? true : false;				  
			if($nav->parent_menu <= 0){ 
			  $menu->submenu = [];
			  $menu_list[$nav->id] = $menu;
			} else{ 
				if($menu->isActive){
				 $menu_list[$nav->parent_menu]->isActive = true;
				} 
			  array_push($menu_list[$nav->parent_menu]->submenu,$menu);  
			}				
		} 
		
		// echo '<pre>';
		// print_r($menu_list);
		// exit;
		View::share ( 'menus', $menu_list );
	}
	
	 
    public function index()
    {
		$page = Page::where('page_name', '=', $this->pathName)->firstOrFail(); 
		$sliders =  Slider::where(['status' => "active"])->select('image', 'id')->get(); 
        return view('pages.index', compact('page', 'sliders')); 	
    }
	
	public function pages()
    {
		$page = Page::where(['page_name' => $this->pathName, 'status' => "active"])->firstOrFail(); 
        return view('pages.pages', compact('page')); 
    }
	
	public function dynamic_pages(Request $request, $route){  
		$page = Page::where(['page_name' => $route, 'status' => "active"])->firstOrFail();  
        return view('pages.pages', compact('page'));
	} 
	
	public function about()
    {		
		$page = Page::where('page_name', '=', $this->pathName)->firstOrFail(); 
        return view('pages.pages', compact('page')); 
        
    }
	public function history()
    {
        $page = Page::where('page_name', '=', $this->pathName)->firstOrFail(); 
        return view('pages.history', compact('page'));  
        
    }
	public function quality_measures()
    {
		$page = Page::where('page_name', '=', $this->pathName)->firstOrFail(); 
        return view('pages.quality-measures', compact('page'));
        
    }
	public function our_services()
    {
		$page = Page::where('page_name', '=', $this->pathName)->firstOrFail(); 
        return view('pages.our-services', compact('page'));
        
    }
	public function nursing_services()
    {
		$page = $this->default_page_content();   
        return view('pages.nursing-services', compact('page'));
        
    }
	public function health_aid_services()
    {
		$page = Page::where('page_name', '=', $this->pathName)->firstOrFail(); 
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
		$page = $this->default_page_content();   
        return view('pages.careers', compact('page'));
        
    }
    public function resources()
    {
		$page = Page::where('page_name', '=', $this->pathName)->firstOrFail(); 
        return view('pages.resources', compact('page'));
        
    }
    public function contact()
    {
		$page = $this->default_page_content();   
        return view('pages.contact', compact('page'));
        
    } 
    public function schedule_an_assessment()
    {
		$page = $this->default_page_content();   
        return view('pages.schedule_an_assessment', compact('page'));
        
    } 
    public function insurance_accepted()
    {
		$page = $this->default_page_content();   
        return view('pages.insurance-accepted', compact('page'));
        
    } 
    public function meet_our_staff()
    {
		$page = $this->default_page_content();   
        return view('pages.meet-our-staff', compact('page'));
        
    } 
    public function submit_referrals()
    {
		$page = $this->default_page_content();   
        return view('pages.submit-referrals', compact('page'));
        
    } 
    public function testimonials()
    {
		$page = $this->default_page_content();   
        return view('pages.testimonials', compact('page'));
        
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
