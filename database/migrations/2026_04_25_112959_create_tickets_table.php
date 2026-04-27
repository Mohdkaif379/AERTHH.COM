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
    Schema::create('tickets', function (Blueprint $table) {
        $table->id();

        // Vendor relation
        $table->foreignId('vendor_id')
              ->constrained('vendors')
              ->onDelete('cascade');

     
        $table->string('subject');
        $table->text('message');

        
        $table->enum('status', ['open', 'in_progress', 'resolved', 'closed'])
              ->default('open');

        $table->enum('priority', ['low', 'medium', 'high'])
              ->default('medium');

        // Optional (future useful)
        $table->string('attachment')->nullable(); // file/image
        $table->timestamp('closed_at')->nullable();

        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
