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
        Schema::create('suppliers', function (Blueprint $table) {
            $table->id();
            $table->string('prefix_id')->nullable()->index();
            $table->foreignId('company_id')->constrained('companies');
            $table->string('name')->index();
            $table->string('street');
            $table->string('house_number');
            $table->string('postal_code');
            $table->string('city');
            $table->string('country_code');
            $table->string('contact_persion_name')->nullable();
            $table->string('contact_persion_email')->nullable();
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
        Schema::dropIfExists('suppliers');
    }
};
