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
        Schema::create('chat_supports', function (Blueprint $table) {
            $table->id();

            // Customer (jo query karega)
            $table->unsignedBigInteger('customer_id');

            // Admin/Support (jo reply karega) - nullable because reply baad mein aayegi
            $table->unsignedBigInteger('support_id')->nullable();

            // Message content
            $table->text('message');

            // Kaun bheja: 'customer' ya 'support'
            $table->enum('sender_type', ['customer', 'support'])->default('customer');

            // Read status
            $table->boolean('is_read')->default(false);

            $table->foreign('customer_id')
                  ->references('id')
                  ->on('customers')
                  ->onDelete('cascade');

            $table->foreign('support_id')
                  ->references('id')
                  ->on('admins')
                  ->onDelete('set null');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chat_supports');
    }
};
