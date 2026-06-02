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
        Schema::create('tenants', function (Blueprint $table) {
            $table->id();
            $table->ulid('ulid')->unique()->index(); // Public ID for browser display and routing

            // Company / Institution information
            $table->string('name');
            $table->string('domain_prefix')->unique();
            $table->text('address')->nullable();
            $table->string('logo_path')->nullable();

            // Status & Subscription management
            $table->enum('status', ['active', 'trial', 'suspended'])->default('trial');
            $table->timestamp('trial_ends_at')->nullable();
            $table->string('email')->unique();

            $table->softDeletes(); // Security feature for soft deletion

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tenants');
    }
};
