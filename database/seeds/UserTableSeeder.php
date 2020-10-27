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
		$user->password 	= bcrypt('Admin@123');
		$user->save();
		
		$role = Role::where('name','Admin')->first();
		$user->assignRole($role->name);
		
		$user = new User();
		$user->first_name 	= "MK";
		$user->last_name 	= "Dev";
		$user->email 		= "mail2mk.dev@gmail.com";
		$user->password 	= bcrypt('Admin@123');
		$user->save();
		
		$role = Role::where('name','User')->first();
		$user->assignRole($role->name);
		
		
		$user = new User();
		$user->first_name 	= "Ayyanar";
		$user->last_name 	= "Dev";
		$user->email 		= "inr@gmail.com";
		$user->password 	= bcrypt('Admin@123');
		$user->save();
		
		$role = Role::where('name','User')->first();
		$user->assignRole($role->name); 
    }
}
