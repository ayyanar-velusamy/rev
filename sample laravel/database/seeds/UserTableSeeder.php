<?php

use Illuminate\Database\Seeder;
use App\Model\User;
use App\Model\Role;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		$user = new User();
		$user->first_name 	= "Admin";
		$user->last_name 	= "Admin";
		$user->email 		= "admin@gmail.com";
		$user->password 	= bcrypt('Velan@123');
		$user->save();
		
		$role = Role::where('name','Admin')->first();
		$user->assignRole($role->name);
		
		$user = new User();
		$user->first_name 	= "Vijayabakar";
		$user->last_name 	= "Rajamani";
		$user->email 		= "baskar.dev@velaninfo.com";
		$user->password 	= bcrypt('Velan@123');
		$user->save();
		
		$role = Role::where('name','User')->first();
		$user->assignRole($role->name);
		
		
		$user = new User();
		$user->first_name 	= "Ramesh";
		$user->last_name 	= "Kumar";
		$user->email 		= "ramesh.dev@velaninfo.com";
		$user->password 	= bcrypt('Velan@123');
		$user->save();
		
		$role = Role::where('name','User')->first();
		$user->assignRole($role->name);
		
		$user = new User();
		$user->first_name 	= "Baskar";
		$user->last_name 	= "Vijay";
		$user->email 		= "test@velaninfo.com";
		$user->password 	= bcrypt('Velan@123');
		$user->save();
		
		$role = Role::where('name','User')->first();
		$user->assignRole($role->name);
    }
}
