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
        Schema::create('notifications', function (Blueprint $notifiable) {
            $notifiable->uuid('id')->primary();
            $notifiable->string('type');
            $notifiable->morphs('notifiable');
            $notifiable->text('data');
            $notifiable->timestamp('read_at')->nullable();
            $notifiable->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
