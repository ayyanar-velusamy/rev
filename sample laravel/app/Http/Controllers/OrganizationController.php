<?php

namespace App\Http\Controllers;

use App\Authorizable;
use Session;
use Notification;

use App\Model\OrganizationChart;
use App\Model\UserGrade;
use App\Model\ChartSidebar;

use Illuminate\Http\Request;
use App\Laravelapi\MagentoConnect;
use Redirect;

class OrganizationController extends BaseController
{

	use Authorizable;
	
    public $magento_data;
    public $current_user_data;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    Public function __construct(){
		parent::__construct();
	}


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
	    return view('organization_chart/organization_chart_view');
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
		$data = array();
        $check_company_data = OrganizationChart::all(); 
        if(count($check_company_data) != 0 ) {
                OrganizationChart::truncate();
                ChartSidebar::truncate();
                $data['status'] = 1;
                $data['message'] = "Organization chart updated";
        }
	   
       $responce_data = $this->unique_multidim_array($request->data,'id'); 
	   
       if(isset($request->side_text)){        
			$side_data = array();
			foreach($request->side_text as $sidebar_data){
				$side_data['set_id'] = $sidebar_data['name'];
				$side_data['set_name'] = $sidebar_data['value'];
				ChartSidebar::firstOrCreate($side_data);
			}
			
			$org_data = array();
			foreach ($responce_data as $organization_data)
			{
				$org_data['node_id'] 		= $organization_data['id'];
				$org_data['node_name'] 		= $organization_data['name'];
				$org_data['node_parent'] 	= $organization_data['parent'];
				$org_data['set_id'] 		= $organization_data['set_id'];
				OrganizationChart::firstOrCreate($org_data); 
			}
			
			//Send update Chart web notification to privileged user
			$users = \App\Model\User::permission('view_organizations')->where('id','!=',user_id())->where('status','active')->get();
			
			Notification::send($users, new \App\Notifications\ChartUpdateNotifiaciton(auth()->user()));
				
			$this->response['status']  = true;
			//$this->response['reload']  = true;
			$this->response['message'] = __('message.organization_update_success');
		}else{			
			$this->response['status']  = false;
			$this->response['message'] = __('message.organization_update_failed');
		}    
        return $this->response();
    }

    private function unique_multidim_array($array, $key) { 

        $temp_array = array(); 
        $i = 0; 
        $key_array = array(); 
        foreach($array as $val) { 
            if (!in_array($val[$key], $key_array)) { 
                $key_array[$i] = $val[$key]; 
                $temp_array[$i] = $val; 
            } 
            $i++; 
        } 
            return $temp_array; 
    } 



    /**
     * Display the specified resource.
     *
     * @param  \App\Organization_chart  $organization_chart
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {	     
		$organization_chart_data = OrganizationChart::all();
	   
	    $org_data['permissions'] = array(
			'add'=>$this->user->hasPermissionTo('add_organizations'),
			'edit'=>$this->user->hasPermissionTo('edit_organizations'),
			'delete'=>$this->user->hasPermissionTo('delete_organizations')
		);
	   
        if($organization_chart_data->count() != 0)
        {
            $chart_sidebar = ChartSidebar::all();
            $emp_user_data = UserGrade::all();
            
            $org_data['chart_data'] = array();
            $id = 0;
            foreach($organization_chart_data as $org_chart_data){
                $org_data['chart_data'][$id]['id']		=  $org_chart_data['node_id'];
                $org_data['chart_data'][$id]['name']	=  $org_chart_data['node_name'];
                $org_data['chart_data'][$id]['parent']	=  $org_chart_data['node_parent'];
                $org_data['chart_data'][$id]['set_id']	=  $org_chart_data['set_id'];
                $id++;
            }
            
            $emp_node_id = array();
            foreach($emp_user_data as $emp_data){
                $emp_node_id[]= $emp_data->chart_value_id;
            }
			$org_data['delete_access']   = true;
            $org_data['used_node']    = $emp_node_id;
            $org_data['sidebar_data'] = $chart_sidebar;   
            return  json_encode($org_data);
            
        }else{
            return  json_encode($org_data);
        }   
    }

    public function check_node(Request $request){
        
        $node_data_emp = UserGrade::where(['chart_value_id' => $request->input('node_id')])->count();
        return $node_data_emp;
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Organization_chart  $organization_chart
     * @return \Illuminate\Http\Response
     */
    public function edit(OrganizationChart $organization_chart)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Organization_chart  $organization_chart
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, OrganizationChart $organization_chart)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Organization_chart  $organization_chart
     * @return \Illuminate\Http\Response
     */
    public function destroy(OrganizationChart $organization_chart)
    {
        //
    }

    public function organization_list(){       

       $organizations = OrganizationChart::where("node_parent", "=","0")->get();
		$this->list_view = '<ul id="browser" class="filetree">';
		if($organizations->count() > 0){
			foreach ($organizations as $organization) {
				$this->list_view .=  '<li class="tree-view closed"> <a class="tree-name firstparent "> '.$organization->node_name. '</a>';	
				
				$this->list_view .= "<ul>";
				
				//build child li
				$this->build_child($organization);
				$this->list_view .= "</ul>";
					
			}
		}else{
			$this->list_view .=  '<li class="tree-view closed"> <a class="tree-name org-maxname firstparent "> My Organization </a></li>';
		}
		$this->list_view .= "</ul>";
        $list_view = $this->list_view;
		
	    return view('organization_chart/organization_list_view',compact('list_view'));
    }

    public function build_child($organization,$li_flag=false){
		
		 if($this->hasChild($organization)){
			 
			if($li_flag){
				$this->list_view .= "<ul>";
			}
			 
			foreach($this->child_arr as $org){
				$class = "";
				if(!$this->hasChild($org)){
					$class = "nochild";
				}
				$this->list_view .= '<li class="tree-view closed  company_1 '.$class.'"><a class="tree-nametree-name org-maxname">'.$org->node_name.'</a>';				

				$this->build_child($org,true);
			}			 
			$this->list_view .= "</li>";
			if($li_flag){
				$this->list_view .= "</ul>";
			}
			
		 }
	}
	
	
	public function hasChild($organization){
		$org_arr = OrganizationChart::where('node_parent', '=', $organization->node_id);
		if($org_arr->exists()){
			$this->child_arr = $org_arr->get();			
			return true;
		}
		return false;
	}


}
