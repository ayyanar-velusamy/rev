<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMilestoneAssignmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('milestone_assignments', function (Blueprint $table) {
            $table->increments('id');
			$table->integer('journey_id');
			$table->integer('milestone_id');
			$table->integer('user_id');
			$table->enum('assignment_type',['my','predefined','add_to','library'])->default('my');
			$table->enum('type',["user","group","grade"])->default('user');
			$table->integer('type_ref_id')->nullable();
			$table->timestamp('completed_date')->nullable(true);
			$table->integer('point')->nallable()->default(0);
			$table->enum('status',["revoked","assigned","ignored","completed","deleted"])->default('assigned');
			$table->integer('rating')->nullable()->default(0);
			$table->longText('comment')->nullable(true);
			$table->longText('notes')->nullable(true);
			$table->integer('created_by');
			$table->integer('updated_by')->nullable();
            $table->timestamps();
			$table->softDeletes(); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('milestone_assignments');
    }
}
