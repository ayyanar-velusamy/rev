<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTempchecksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tempchecks', function (Blueprint $table) {
            $table->increments('id');
            $table->text('question');
            $table->enum('frequency',["weekly","bi-weekly","monthly"])->default('weekly');
			$table->string('frequency_day');
			$table->timestamp('due_date')->nullable(true);
			$table->enum('status',["new","assigned","completed"])->default('new');
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
        Schema::dropIfExists('tempchecks');
    }
}
