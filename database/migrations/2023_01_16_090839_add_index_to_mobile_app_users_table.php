<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mobile_app_users', function (Blueprint $table) {
            $table->index('first_name');
            $table->index('last_name');
            $table->index('email');
            // $table->index('status');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('mobile_app_users', function (Blueprint $table) {
            $table->dropIndex('mobile_app_users_first_name_index');
            $table->dropIndex('mobile_app_users_last_name_index');
            $table->dropIndex('mobile_app_users_email_index');
            $table->dropIndex('mobile_app_users_created_at_index');
        });
    }
};
