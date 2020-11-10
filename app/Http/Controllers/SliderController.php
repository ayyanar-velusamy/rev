<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash; 
use Illuminate\Support\Facades\Cache;
use Intervention\Image\Facades\Image; 
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\DB;

use App\Authorizable;  
use App\Http\Requests\StoreSliderPost;   
use App\Model\Slider;  

class SliderController extends BaseController  
{
	use Authorizable;
	
	Public function __construct(){
		parent::__construct();
	} 
	
	public function ajax_list(Request $request)
    {
		$data = $whereArray = array(); 
		$sliders = DB::table('sliders'); 
		$sliders->select('*');   
		if(!empty($whereArray)){
			foreach($whereArray as $key => $where){
				$sliders->where($where['field'],$where['condition'],$where['value']);
			} 
		}
		
		if($request->input('search.value')){
			$search_for = $request->input('search.value');
			$sliders->where(function($query) use ($search_for){
				$query->where('sliders.name', 'LIKE', '%'.$search_for.'%'); 
				$query->orWhere('sliders.status', 'LIKE', '%'.$search_for.'%'); 
			});			
		}
		$sliders->orderBy('sliders.id', 'DESC'); 
		$pageData = $sliders->get(); 
		
		foreach($pageData as $key => $row){
		   $action = "";  
			$action .='<a title="Edit" href="'.route('sliders.edit',[encode_url($row->id)]).'" class="btn btn-lightblue">Edit</a>'; 
			$action .='<button type="button" title="Delete"  onclick="deletePage('."'".encode_url($row->id)."'".','."'".$row->status."'".','."'".$row->name."'".')" class="btn btn-red">Delete</button>'; 
		 
           $data[$key]['id']        		= ''; 
		   $data[$key]['name'] 			    = $row->name; 
		   $data[$key]['image'] 			= banner_image($row->image); 
           $data[$key]['status']   			= ucfirst($row->status); 
		   $data[$key]['action']            = $action; 
	   }
	   
	   return datatables()->of($data)->make(true); 
    }
	
	
	//Function to list out app slider 
	public function index()
	{ 						
		return view('slider.list');
	}

	//Function to render slider add view
	//Input : NA
	//Output : render view
	public function create()
	{ 
		return view('slider.add');
	}

	//Function to create/store the app slider
	//Input : Request/Post data
	//Output : status message
	public function store(StoreSliderPost $request)
	{ 
		$slider = new Slider();
        $slider->name   	= $request->name; 
        $slider->status   	= $request->status;
        
        if ($request->hasFile('image')) {
            $slider->image = $this->SilderUpload($request);
        }
              
        if($slider->save()){  
			$this->response['status']   = true;
			$this->response['message']  = str_replace("{slider}",$request->name,__('message.slider_create_success'));
			$this->response['redirect'] = route('sliders.index');  
		}else{
			$this->response['status']   = false;
			$this->response['message']  = str_replace("{slider}",$request->name,__('message.slider_create_success'));
		} 
        return $this->response();  
	}  
	
	//Function to render the app slider view slider
	//Input : slider id
	//Output : render view slider
	public function show($id)
    {
        $slider = Slider::findOrFail(decode_url($id)); 
        return view('slider.show', compact('slider'));
    }

	//Function to render the app slider edit slider
	//Input : slider id
	//Output : render edit slider
	public function edit($id)
	{
		$slider = Slider::findOrFail(decode_url($id));  
        return view('slider.edit', compact('slider'));
	}

	//Function to update the app slider
	//Input : Request/Post data
	//Output : status message
	public function update(StoreSliderPost $request, Slider $slider)
	{ 
		$slider->name   = $request->name; 
        $slider->status = $request->status; 
       
        if ($request->hasFile('image')) {
            $slider->image = $this->SilderUpload($request);
        } 
		 
		if($slider->save()){  
			$this->response['status']   = true;
			$this->response['message']  = str_replace("{slider}",$request->name,__('message.slider_update_success'));
			$this->response['redirect'] = route('sliders.index');
		}else{
			$this->response['status']   = false;
			$this->response['message']  = str_replace("{slider}",$request->name,__('message.slider_update_failed'));
		} 
        return $this->response();
	}

	//Function to delete the app slider
	//Input : slider Id
	//Output : status message
	public function destroy($id)
	{
		$slider = Slider::findOrFail(decode_url($id)); 
		if(Slider::find($slider->id)->delete() ) { 
			$this->response['status']   = true;
			$this->response['message']  = str_replace("{slider}",$slider->name,__('message.slider_delete_success'));
			$this->response['redirect'] = route('sliders.index');
		} else {
			$this->response['status']   = false;
			$this->response['message']  = str_replace("{slider}",$slider->name,__('message.slider_delete_failed'));
		}
		return $this->response();
	} 
	
	//Function to store the slider banner image 
	private function SilderUpload($request){ 
	   $request->image->store('public/banner-uploads'); 
	   $file_name = $request->image->hashName(); 
	   return $file_name;
    } 
	 
	//Function to Activate and Inativate the App slider 
	//Input : slider ID and status
	//Output: NA
	public function status(Request $request, $id){ 
		$slider = Slider::findOrFail(decode_url($id));  
		$slider->status = $request->status;
		if($slider->save()){
			if($request->status == 'active'){ 
				$this->response['message']  = str_replace("{slider}",$slider->name,__('message.slider_activate_success'));
			}else{ 
				$this->response['message']  = str_replace("{slider}",$slider->name,__('message.slider_inactivate_success'));
			}
			$this->response['status']   = true;
		}else{
			$this->response['status']   = false;
			$this->response['message']  = __('message.something_went_wrong');
		} 
		return $this->response();
	}  
}
