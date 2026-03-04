<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('booking_notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id')->constrained()->cascadeOnDelete();
            $table->foreignId('hotel_id')->constrained()->cascadeOnDelete();
            $table->foreignId('recipient_user_id')->constrained('users')->cascadeOnDelete();
            $table->enum('recipient_role', ['staff', 'admin', 'super_admin']);
            $table->unsignedTinyInteger('priority');
            $table->enum('status', ['pending', 'accepted', 'expired'])->default('pending');
            $table->timestamp('seen_at')->nullable();
            $table->timestamp('accepted_at')->nullable();
            $table->foreignId('accepted_by_user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();

            $table->index(['recipient_user_id', 'status', 'created_at']);
            $table->index(['booking_id', 'status', 'priority']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('booking_notifications');
    }
};
