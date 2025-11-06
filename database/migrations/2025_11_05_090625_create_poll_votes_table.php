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
        Schema::create('poll_votes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('poll_id')->constrained()->cascadeOnDelete();
            $table->foreignId('option_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete(); // if login-based voting
            $table->string('ip_address', 45)->nullable(); // for guest/IP based restriction
            $table->string('device_id')->nullable();
            $table->timestamps();

            $table->unique(['poll_id', 'user_id']); // prevent multiple votes per poll per user
            $table->unique(['poll_id', 'ip_address']); // if guests vote by IP
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('poll_votes');
    }
};
