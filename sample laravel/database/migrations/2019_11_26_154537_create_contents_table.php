<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contents', function (Blueprint $table) {
            $table->increments('id');
			$table->integer('milestone_id')->nullable()->default(null);
            $table->integer('content_type_id');
			$table->string('title');
			$table->string('provider')->nullable(); // Author | Episode
			$table->string('length')->nullable();   // Minutes | Hours | Pages
			$table->string('url')->nullable();
			$table->string('price')->nullable();
			$table->integer('approver_id')->nullable();
			$table->enum('difficulty',['beginner','intermediate','advanced'])->default('beginner');
			$table->enum('payment_type',['free','paid'])->default('free');
			$table->enum('type',['library','journey'])->default('library');
			$table->longText('description')->nullable()->default(null);
			$table->longText('tags')->nullable()->default(null);
			$table->integer('created_by')->nullable();
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
        Schema::dropIfExists('contents');
    }
}
