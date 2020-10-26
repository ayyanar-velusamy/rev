<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
			$table->string('last_name')->nullable()->after('first_name');
			$table->string('designation')->nullable()->after('last_name');
			$table->string('team')->nullable()->after('designation');
			$table->string('department')->nullable()->after('team');
            $table->string('image')->nullable()->after('remember_token');
            $table->string('mobile')->nullable()->after('image');
			$table->string('change_email')->nullable()->after('mobile');
			$table->string('change_email_token')->nullable()->after('change_email');
			$table->timestamp('changed_at')->nullable(true)->after('change_email_token');
			$table->enum('status',['active','inactive'])->default('active')->after('changed_at');
			$table->enum('login',['yes','no'])->default('no')->after('status');
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
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('last_name');
			$table->dropColumn('designation');
			$table->dropColumn('team');
			$table->dropColumn('department');
            $table->dropColumn('image');
            $table->dropColumn('mobile');
            $table->dropColumn(['status']);
            $table->dropColumn(['login']);
			$table->dropSoftDeletes();
        });
    }
}
