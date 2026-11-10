<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('resource_reactions')) {
            return;
        }

        Schema::create('resource_reactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('resource_id')->constrained('resources')->cascadeOnDelete();
            $table->char('visitor_hash', 64);
            $table->char('ip_hash', 64)->nullable();
            $table->string('type', 20);
            $table->timestamps();
            $table->unique(['resource_id', 'visitor_hash'], 'resource_reactions_unique');
            $table->index(['resource_id', 'ip_hash']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('resource_reactions');
    }
};
