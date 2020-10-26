<?php
namespace App;

trait Authorizable
{
    private $abilities = [
        'index' => 'view',
        'edit' => 'edit',
        'show' => 'view',
        'update' => 'edit',
        'create' => 'add',
        'store' => 'add',
        'destroy' => 'delete'
    ];

    /**
     * Override of callAction to perform the authorization before
     *
     * @param $method
     * @param $parameters
     * @return mixed
     */
    public function callAction($method, $parameters)
    {
        if( $ability = $this->getAbility($method) ) {
		   if(!$this->appSkipPermissionRestriction($ability,$parameters)){
			   $this->authorize($ability);
		   }
        }
        return parent::callAction($method, $parameters);
    }

    public function getAbility($method)
    {
        list($controller, $method) = GetActionControllerAndMethodName();
        $action = array_get($this->getAbilities(), $method);
        return $action ? $action . '_' . str_plural($controller) : null;
    }
	
	private function appSkipPermissionRestriction($ability,$parameters){
		if($this->lxpSkip($ability,$parameters)){
			return true;
		}
		return false;
	}
	
	private function lxpSkip($ability, $parameters)
    {
		if($ability == "add_organizations"){
			if((auth()->user()->hasAnyPermission(['edit_organizations','delete_organizations']))){
				return true;
			}
		}elseif(strpos($ability, 'groups') !== false){
			if(isset($parameters['group'])){
				if(is_group_admin(decode_url($parameters['group']))){
					return true;
				}
			}
		}
		return false;
    }
	

    private function getAbilities()
    {
        return $this->abilities;
    }

    public function setAbilities($abilities)
    {
        $this->abilities = $abilities;
    }
}