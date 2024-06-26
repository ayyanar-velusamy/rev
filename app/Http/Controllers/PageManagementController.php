<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash; 
use Illuminate\Support\Facades\Cache;
use Intervention\Image\Facades\Image; 
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\DB;

use App\Authorizable;  
use App\Http\Requests\StorePagePost;   
use App\Model\Page;  
use App\Model\Menu;

class PageManagementController extends BaseController  
{
	use Authorizable;
	
	Public function __construct(){
		parent::__construct();
	} 
	
	public function ajax_list(Request $request)
    {
		$data = $whereArray = array(); 
		$pages = DB::table('pages'); 
		$pages->select('*');   
		if(!empty($whereArray)){
			foreach($whereArray as $key => $where){
				$pages->where($where['field'],$where['condition'],$where['value']);
			} 
		}
		
		if($request->input('search.value')){
			$search_for = $request->input('search.value');
			$pages->where(function($query) use ($search_for){
				$query->where('pages.title', 'LIKE', '%'.$search_for.'%');
				$query->orWhere('pages.meta_description', 'LIKE', '%'.$search_for.'%');
				$query->orWhere('pages.meta_keyword', 'LIKE', '%'.$search_for.'%'); 
				$query->orWhere('pages.status', 'LIKE', '%'.$search_for.'%'); 
			});			
		}
		$pages->orderBy('pages.id', 'DESC'); 
		$pageData = $pages->get(); 
		
		foreach($pageData as $key => $row){
		   $action = "";
		 
		   
		   $action .='<a title="View" href="'.route('pages.show',[encode_url($row->id)]).'" class="btn btn-blue '.$row->status.'">View</a>';
			
			//if($this->page->hasPermissionTo('edit_pages')){
				$action .='<a title="Edit" href="'.route('pages.edit',[encode_url($row->id)]).'" class="btn btn-lightblue">Edit</a>';
			//}

			if($row->default_page == 0){
				$action .='<button type="button" title="Delete"  onclick="deletePage('."'".encode_url($row->id)."'".','."'".$row->status."'".','."'".$row->title."'".')" class="btn btn-red">Delete</button>';
			}	 
           $data[$key]['id']        		= ''; 
		   $data[$key]['title'] 			= $row->title;
		   $data[$key]['meta_description']	= $row->meta_description; 
		   $data[$key]['meta_keyword']		= $row->meta_keyword;  
           $data[$key]['status']   			= ucfirst($row->status); 
		   $data[$key]['action']            = $action; 
	   }
	   
	   return datatables()->of($data)->make(true); 
    }
	
	
	//Function to list out app pages 
	public function index()
	{ 						
		return view('page_management.list');
	}

	//Function to render page add view
	//Input : NA
	//Output : render view
	public function create()
	{ 
		$menus = Menu::where(['status' => "1", 'parent_menu'=> 0, 'type' => "1"])->select('*')->get(); 
		return view('page_management.add', compact('menus'));
	}

	//Function to create/store the app page
	//Input : Request/Post data
	//Output : status message
	public function store(StorePagePost $request)
	{ 
		$page = new Page();
        $page->title   			= $request->title; 
        $page->meta_description = $request->meta_description;
        $page->meta_keyword   	= $request->meta_keyword;
        $page->content_en   	= $request->content_en;
        $page->content_es   	= $request->content_es;
        $page->content_ar   	= $request->content_ar;
        $page->status   	    = $request->status;
		$page->parent_menu 		= $request->parent_menu;
        $page->page_name     	= str_replace(" ","_",strtolower($request->menu_en));
		
        $menu = new Menu();
		$menu->menu_en = $request->menu_en;
		$menu->menu_es = $request->menu_es;
		$menu->menu_ar = $request->menu_ar;
		$menu->route = $page->page_name;
		$menu->link = config('app.url')."/revival/".$page->page_name;
		$menu->type = 2;
		$menu->parent_menu = $request->parent_menu;
		$menu->status = ($request->status == "active")? 1 : 2; 
		
        if ($request->hasFile('image')) {
            $page->image = $this->bannerUpload($request);
        }
              
        if($page->save() && $menu->save()){
			$page = Page::findOrFail($page->id); 
			$page->menu_id = $menu->id;
			$page->save();			
			$this->response['status']   = true;
			$this->response['message']  = str_replace("{page}",$request->title,__('message.page_create_success'));
			$this->response['redirect'] = route('pages.index');  
		}else{
			$this->response['status']   = false;
			$this->response['message']  = str_replace("{page}",$request->title." ".$request->title,__('message.page_create_success'));
		} 
        return $this->response();  
	}  
	
	//Function to render the app page view page
	//Input : page id
	//Output : render view page
	public function show($id)
    {
        $page = Page::findOrFail(decode_url($id)); 
		$menus = Menu::where(['status' => "1", 'parent_menu'=> 0, 'type' => "1"])->select('*')->get();
		if($page->menu_id > 0){		
			$edit_menu = Menu::findOrFail($page->menu_id); 
		}
        return view('page_management.show', compact('page', 'menus', 'edit_menu'));
    }

	//Function to render the app page edit page
	//Input : page id
	//Output : render edit page
	public function edit($id)
	{
		$menus = Menu::where(['status' => "1", 'parent_menu'=> 0, 'type' => "1"])->select('*')->get();  
		$page = Page::findOrFail(decode_url($id)); 
		if($page->menu_id > 0){
			$edit_menu = Menu::findOrFail($page->menu_id); 
		}
        return view('page_management.edit', compact('page', 'menus', 'edit_menu'));
	}

	//Function to update the app page
	//Input : Request/Post data
	//Output : status message
	public function update(StorePagePost $request, Page $page)
	{ 
		$page->title   			= $request->title;
        $page->meta_description = $request->meta_description;
        $page->meta_keyword   	= $request->meta_keyword;
        $page->content_en   	= $request->content_en;
        $page->content_es   	= $request->content_es;
        $page->content_ar   	= $request->content_ar;
        $page->status   		= $request->status; 
		$page->parent_menu 		= $request->parent_menu;
       
        if ($request->hasFile('image')) {
            $page->image = $this->bannerUpload($request);
        } 
		 
		if($page->save()){
			if($request->menu_id > 0){
				$menu = Menu::findOrFail($request->menu_id); 
				$menu->menu_en = $request->menu_en;
				$menu->menu_es = $request->menu_es;
				$menu->menu_ar = $request->menu_ar;
				$menu->status = ($request->status == "active")? 1 : 2; 
				$menu->parent_menu 	= $request->parent_menu;
				$menu->save();
			} 
			$this->response['status']   = true;
			$this->response['message']  = str_replace("{page}",$request->title,__('message.page_update_success'));
			$this->response['redirect'] = route('pages.index');
		}else{
			$this->response['status']   = false;
			$this->response['message']  = str_replace("{pagename}",$request->title,__('message.page_update_failed'));
		} 
        return $this->response();
	}

	//Function to delete the app page
	//Input : Page Id
	//Output : status message
	public function destroy($id)
	{
		$page = Page::findOrFail(decode_url($id)); 
		if(Page::find($page->id)->delete() ) { 
		   $deleteMenu = Menu::where('route',$page->page_name)->delete();
			$this->response['status']   = true;
			$this->response['message']  = str_replace("{page}",$page->title,__('message.page_delete_success'));
			$this->response['redirect'] = route('pages.index');
		} else {
			$this->response['status']   = false;
			$this->response['message']  = str_replace("{page}",$page->title,__('message.page_delete_failed'));
		}
		return $this->response();
	} 
	
	//Function to store the page banner image 
	private function bannerUpload($request){ 
	   $request->image->store('public/banner-uploads'); 
	   $file_name = $request->image->hashName(); 
	   return $file_name;
    } 
	 
	//Function to Activate and Inativate the App Page 
	//Input : Page ID and status
	//Output: NA
	public function status(Request $request, $id){ 
		$page = Page::findOrFail(decode_url($id));  
		$page->status = $request->status;
		if($page->save()){
			if($request->status == 'active'){ 
				$this->response['message']  = str_replace("{page}",$page->title,__('message.page_activate_success'));
			}else{ 
				$this->response['message']  = str_replace("{page}",$page->title,__('message.page_inactivate_success'));
			}
			$this->response['status']   = true;
		}else{
			$this->response['status']   = false;
			$this->response['message']  = __('message.something_went_wrong');
		} 
		return $this->response();
	}  
}
