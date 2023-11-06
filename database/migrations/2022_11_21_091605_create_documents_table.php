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
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->string('prefix_id')->nullable();
            $table->foreignId('product_id')->constrained('products', 'id');
            $table->string('name');
            $table->enum('type', ['file', 'url']);
            $table->enum('section', ['technical', 'supplier', 'drawing', 'instruction', 'modification_guide']);
            $table->longText('filepath');
            $table->string('disk')->nullable();
            $table->foreignId('user_id')->constrained('users', 'id');
            $table->foreignId('company_id')->constrained('companies', 'id');
            $table->string('image_path')->nullable();
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
        Schema::dropIfExists('documents');
    }
};
