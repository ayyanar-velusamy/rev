<?php

use Illuminate\Database\Seeder;
use App\Model\ContentType;

class ContentTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $type = new ContentType();
		$type->name = "Article";
        $type->save();
		
		$type = new ContentType();
		$type->name = "Video";
        $type->save();
		
		$type = new ContentType();
		$type->name = "Podcast";
        $type->save();
		
		$type = new ContentType();
		$type->name = "Book";
        $type->save();
		
		$type = new ContentType();
		$type->name = "Course";
        $type->save();
		
		$type = new ContentType();
		$type->name = "Event";
        $type->save();
		
		$type = new ContentType();
		$type->name = "Assessment";
        $type->save();

    }
}
