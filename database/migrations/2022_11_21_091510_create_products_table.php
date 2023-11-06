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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('prefix_id')->nullable()->index();
            $table->string('serial_number')->nullable()->index();
            $table->date('warranty_start_date')->nullable();
            $table->date('warranty_end_date')->nullable();
            $table->string('name')->index('name');
            $table->foreignId('company_id')->constrained('companies', 'id');
            $table->foreignId('category_id')->nullable()->constrained('categories', 'id');
            $table->foreignId('supplier_id')->nullable()->constrained('suppliers', 'id');
            $table->foreignId('user_id')->constrained('users', 'id');
            $table->boolean('public_access')->default(false);
            $table->enum('status', ['active', 'inactive'])->default('active')->index();
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
        Schema::dropIfExists('products');
    }
};
