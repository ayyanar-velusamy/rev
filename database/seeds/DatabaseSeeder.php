<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(ModuleTableSeeder::class);
        $this->call(PermissionTableSeeder::class);
		$this->call(RoleTableSeeder::class);
		$this->call(UserTableSeeder::class);
		$this->call(ContentTypeTableSeeder::class);
		$this->call(JourneyTypeTableSeeder::class);
		$this->call(JourneyTableSeeder::class);
    }
}
