<?php

use Illuminate\Database\Seeder;
use App\Model\Journey;

class JourneyTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $journey = new Journey();
		$journey->journey_name 			= "Default Learning Journey";
		$journey->journey_type_id 		= 4;
		$journey->parent_id 			= 0;
		$journey->visibility 			= 'public';
		$journey->status 				= 'active';
		$journey->read	 				= 'optional';
		$journey->journey_description 	= 'Default Learning Journey';
		$journey->created_by 			= 1;
        $journey->save();
		
		$journey = new Journey();
		$journey->journey_name 			= "Backfilled Milestone";
		$journey->journey_type_id 		= 5;
		$journey->parent_id 			= 0;
		$journey->visibility 			= 'public';
		$journey->status 				= 'active';
		$journey->read	 				= 'optional';
		$journey->journey_description 	= 'This Journey is meant for users to record Milestones that they have completed in the past.We encourage you to add relevant and important Milestones from your past so that all decisions made by your firm for your growth and progress are well informed.Please note that these milestones will not impact any of the statistics you see elsewhere on this platform.';
		$journey->type	 				= 'user';
		$journey->created_by 			= 1;
        $journey->save();
    }
}
