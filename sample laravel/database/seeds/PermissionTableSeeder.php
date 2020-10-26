<?php

use Illuminate\Database\Seeder;
use App\Model\Permission;
use App\Model\Module;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		$modules = Module::all();

		$abilities 		= Permission::all_passible_permissions(); 
		$methods 		= Permission::module_wise_permission_methods(); 
		
		foreach ($modules as $module) {
			
			$name = $this->getNameArgument($module->name);
			
			foreach($abilities as $ability){
				if(in_array($ability, $methods[$module->name])){
					Permission::firstOrCreate(['name' => $ability .'_'.$name,'module_id' => $module->id]);
				}else{
					Permission::firstOrCreate(['name' => $ability.'_'.$name,'module_id' => $module->id,'status'=>'inactive']);
				}
			}
		}
    }
		
	private function getNameArgument($name)
    {
        return strtolower(str_plural($name));
    }
}
