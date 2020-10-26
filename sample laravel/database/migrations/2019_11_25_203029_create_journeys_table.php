<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJourneysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('journeys', function (Blueprint $table) {
            $table->increments('id');
            $table->string('journey_name');
            $table->integer('journey_type_id');
			$table->integer('parent_id')->default(0);
			$table->enum('visibility',['private','public'])->default('private');
			$table->enum('status',['draft','active','inactive'])->default('active');
			$table->enum('read',['optional','compulsory'])->default('optional');
			$table->longText('journey_description')->nullable();
			$table->enum('type',["user","group","grade"])->default('user');
			$table->string('type_ref_id')->nullable();
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
        Schema::dropIfExists('journeys');
    }
}
