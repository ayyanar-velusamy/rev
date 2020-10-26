<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMilestonesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('milestones', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('journey_id');
			$table->enum('parent_type',['milestone','library'])->default('milestone');
			$table->integer('parent_id')->default(0);
			$table->integer('content_type_id');
			$table->string('title');
			$table->string('provider')->nullable(); // Author | Episode
			$table->string('length')->nullable();   // Minutes | Hours | Pages
			$table->string('url')->nullable();
			$table->enum('difficulty',['beginner','intermediate','advanced'])->default('beginner');
			$table->enum('visibility',['private','public'])->default('public');
			$table->longText('description')->nullable()->default(null);
			$table->longText('tags')->nullable()->default(null);			
			$table->timestamp('start_date')->nullable(true);	
			$table->timestamp('end_date')->nullable(true);
			$table->enum('payment_type',['free','paid'])->default('free');
			$table->enum('read',['optional','compulsory'])->default('optional');
			$table->enum('type',["user","group","grade"])->default('user');
			$table->string('type_ref_id')->nullable();			
			$table->integer('approver_id')->nullable();
			$table->string('price')->nullable();
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
        Schema::dropIfExists('milestones');
    }
}
