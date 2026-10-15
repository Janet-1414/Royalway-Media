<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->dropColumn(['objectives', 'activities', 'results', 'stats', 'chart_data']);
        });
    }

    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->json('objectives')->nullable();
            $table->json('activities')->nullable();
            $table->longText('results')->nullable();
            $table->json('stats')->nullable();
            $table->json('chart_data')->nullable();
        });
    }
};
