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
        Schema::table('users', function (Blueprint $table) {
            $table->index('prefix_id');
            $table->index('type');
            $table->index('status');
            $table->index('created_at');
            $table->index('permission');
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
            $table->dropIndex('users_prefix_id_index');
            $table->dropIndex('users_type_index');
            $table->dropIndex('users_status_index');
            $table->dropIndex('users_created_at_index');
            $table->dropIndex('users_permission_index');
        });
    }
};
