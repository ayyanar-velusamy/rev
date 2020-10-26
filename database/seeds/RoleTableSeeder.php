<?php

use Illuminate\Database\Seeder;
use App\Model\Permission;
use App\Model\Role;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       $role = Role::firstOrCreate(['name' => 'Admin']);
	   $role->syncPermissions(Permission::all());

	   $role = Role::firstOrCreate(['name' => 'User','created_by' => 1]);
	   $role->syncPermissions(Permission::all());
    }
}
