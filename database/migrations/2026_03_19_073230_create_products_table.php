<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('product_name');
            $table->text('description')->nullable();
            $table->foreignId('category_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('sub_category_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('sub_sub_category_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('brand_id')->nullable()->constrained()->nullOnDelete();
            $table->enum('product_type', ['physical', 'digital'])->default('physical');
            $table->string('image')->nullable();
            $table->json('tags')->nullable(); 
            $table->string('sku')->unique()->nullable();
            $table->decimal('unit_price', 10, 2)->default(0);
            $table->integer('stock_quantity')->default(0);
            $table->decimal('discount', 10, 2)->nullable();
            $table->string('product_unit')->nullable();
            $table->enum('discount_type', ['flat', 'percent'])->nullable();
            $table->boolean('status')->default(1);
            $table->decimal('shipping_cost', 10, 2)->nullable();
            $table->decimal('tax_amount', 10, 2)->nullable();
            $table->foreignId('attribute_id')->nullable()->constrained()->nullOnDelete();
            $table->string('attribute_value')->nullable();
            $table->json('additional_image')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
