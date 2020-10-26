<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTempcheckAssignmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tempcheck_assignments', function (Blueprint $table) {
            $table->increments('id');
			$table->integer('tempcheck_id');
			$table->enum('type',["user","group","grade"])->default('user');
			$table->integer('type_ref_id');
			$table->integer('user_id');
			$table->date('survay_date')->nullable();
			$table->integer('rating')->nullable();
			$table->longText('comment')->nullable();
			$table->integer('created_by');
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
        Schema::dropIfExists('tempcheck_assignments');
    }
}
