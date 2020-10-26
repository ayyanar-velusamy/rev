<?php

namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Hashids\Hashids;

class BaseController extends Controller
{
	public $data 	 = [];
	public $response = [];
	
	/**
     * @param $name
     * @param $value
     */
    public function __set($name, $value)
    {
        $this->data[$name] = $value;
    }

    /**
     * @param $name
     * @return mixed
     */
    public function __get($name)
    {
        return $this->data[$name];
    }

    /**
     * @param $name
     * @return bool
     */
    public function __isset($name)
    {
        return isset($this->data[ $name ]);
    }
	
    public function __construct(){
		$this->middleware(function ($request, $next) {
            $this->user = auth()->user();
            //$this->notifications = $this->user->notifications;
			
			return $next($request);
		});
	}
	
	public function response($type = "json"){
		
		if(isset($this->response['redirect'])){
            $this->response['action'] = 'redirect';
            $this->response['url']    = $this->response['redirect'];
        }
		
		if($type === "json"){
			return json_encode($this->response);
		}
		
		return $this->response;
	}

	protected function encode_url($data){
		$hashids = new Hashids(config('app.name'));
		return $hashids->encode($data);  
    }


	protected function decode_url($ciphertext){
		$hashids = new Hashids(config('app.name'));
		return $hashids->encode($ciphertext);  
    }

}
