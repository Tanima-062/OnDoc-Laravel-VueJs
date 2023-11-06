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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('prefix_id')->nullable();
            $table->foreignId('language_id')->default(1)->constrained('language', 'id');
            $table->foreignId('company_id')->nullable()->constrained('companies');
            $table->string('first_name', 30)->index('first_name');
            $table->string('last_name', 30)->index('last_name');
            $table->string('email');
            $table->string('avatar')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->enum('type', ['system_admin', 'company_admin', 'company_sub_admin']);
            $table->string('verification_token')->nullable();
            $table->enum('status', ['pending', 'active', 'inactive',])->default('pending');
            $table->enum('permission', ['view', 'full'])->default('view');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
};
