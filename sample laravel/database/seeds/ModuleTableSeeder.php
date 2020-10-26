<?php

use Illuminate\Database\Seeder;
use App\Model\Module;

class ModuleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $modules = Module::defaultModules();
		
        foreach ($modules as $module) {
	        Module::firstOrCreate(['name' => $module['name'],'display_name'=> $module['display_name']]);
        }
    }
}
