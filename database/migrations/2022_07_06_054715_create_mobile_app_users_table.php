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
        Schema::create('mobile_app_users', function (Blueprint $table) {
            $table->id();
            $table->foreignId('language_id')->default(2)->constrained('language');
            $table->string('first_name');
            $table->string('last_name');
            // $table->integer('company_id');
            $table->string('photo');
            $table->string('city')->nullable();
            $table->string('street')->nullable();
            $table->string('zip_code')->nullable();
            $table->string('country')->nullable();
            $table->string('company')->nullable();
            $table->string('house_number')->nullable();

            $table->string('email');
            $table->string('country_iso_code', 10)->nullable();
            $table->string('phone_number')->nullable();
            $table->string('full_phone_number')->nullable();

            $table->string('password')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('verification_token')->nullable();

            // $table->enum('status', ['active', 'inactive', 'pending'])->default('pending');
            $table->integer('tos')->nullable();

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mobile_app_users');
    }
};
