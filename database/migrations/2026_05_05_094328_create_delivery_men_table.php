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
        Schema::create('delivery_men', function (Blueprint $table) {
            $table->id();
            $table->string('full_name');
            $table->string('mobile', 15)->unique();
            $table->string('email')->unique();
            $table->string('password');
            $table->date('date_of_birth');
            $table->enum('gender', ['male', 'female', 'other'])->nullable();
            $table->string('profile_photo')->nullable();

            // ========== Address Information ==========
            $table->text('address_line')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('pincode', 10)->nullable();

            // ========== ID Proof ==========
            $table->string('aadhaar_number', 12)->unique()->nullable();
            $table->string('aadhaar_image')->nullable();

            // ========== Vehicle Details ==========
            $table->enum('vehicle_type', ['bike', 'bicycle', 'scooter', 'auto'])->nullable();
            $table->string('vehicle_number')->unique()->nullable();
            $table->string('driving_license_number')->unique()->nullable();
            $table->string('rc_upload')->nullable();
            $table->string('dl_upload')->nullable();

            // ========== Account Status ==========
            $table->enum('status', ['pending', 'approved', 'rejected', 'active', 'inactive'])->default('pending');
            $table->text('rejection_reason')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->timestamps();

            $table->index(['mobile', 'email']);
            $table->index(['city', 'state']);
            $table->index('status');
            $table->index('vehicle_type');
            $table->index('aadhaar_number');
            $table->index('vehicle_number');
            $table->index('driving_license_number');
            $table->unsignedBigInteger('created_by')->nullable();
            $table->foreign('created_by')
                ->references('id')
                ->on('admins')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('delivery_men');
    }
};
