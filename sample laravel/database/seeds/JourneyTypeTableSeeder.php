<?php

use Illuminate\Database\Seeder;
use App\Model\JourneyType;

class JourneyTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		$type = new JourneyType();
		$type->name = "My Learning Journey";
        $type->save();
		
		$type = new JourneyType();
		$type->name = "Predefined Learning Journey";
        $type->save();
		
		$type = new JourneyType();
		$type->name = "Assigned Learning Journey";
        $type->save();
		
		$type = new JourneyType();
		$type->name = "Default Learning Journey";
        $type->save();
		
		$type = new JourneyType();
		$type->name = "Backfill Learning Journey";
        $type->save();
    }
}
