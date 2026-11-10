<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('resource_views')) {
            return;
        }

        Schema::create('resource_views', function (Blueprint $table) {
            $table->id();
            $table->foreignId('resource_id')->constrained('resources')->cascadeOnDelete();
            $table->char('visitor_hash', 64);
            $table->date('viewed_on');
            $table->unique(['resource_id', 'visitor_hash', 'viewed_on'], 'resource_views_unique');
            $table->index('viewed_on');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('resource_views');
    }
};
