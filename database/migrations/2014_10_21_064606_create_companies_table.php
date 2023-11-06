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
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('prefix_id')->nullable()->index();
            $table->string('name')->index('name');
            $table->string('logo')->nullable();
            $table->string('street');
            $table->string('house_number');
            $table->string('postal_code');
            $table->string('city');
            $table->string('country_code');
            $table->string('contact_persion_first_name');
            $table->string('contact_persion_last_name');
            $table->string('contact_persion_email');
            $table->string('country_iso_code', 10)->nullable();
            $table->string('phone_number')->nullable();
            $table->string('full_phone_number')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active')->index();
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
        Schema::dropIfExists('companies');
    }
};
