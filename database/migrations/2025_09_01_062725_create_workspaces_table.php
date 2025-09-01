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
        Schema::create('workspaces', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            // Dueño del workspace
            $table->foreignId('owner_user_id')->constrained('users')->cascadeOnDelete();
            $table->ulid('public_id')->unique();

            // Para URLs amigables o routing futuro
            $table->string('slug')->unique()->nullable();
            $table->timestamps();

            $table->index(['owner_user_id']);
            $table->index(['public_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('workspaces');
    }
};
