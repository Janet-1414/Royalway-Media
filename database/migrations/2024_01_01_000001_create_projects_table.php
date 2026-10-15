<?php
/**
 * File Path: database/migrations/2024_01_01_000001_create_projects_table.php
 *
 * Run: php artisan make:migration create_projects_table
 * Then replace content with this file
 */

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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('client');
            $table->string('client_logo')->nullable();
            $table->text('description');
            $table->longText('challenge')->nullable();
            $table->json('objectives')->nullable(); // Array of objective items
            $table->json('activities')->nullable(); // Array of activity items
            $table->longText('results')->nullable();
            $table->string('featured_image');
            $table->json('gallery')->nullable(); // Array of image paths
            $table->string('category'); // e.g., 'Strategic Communications', 'PR & Media'
            $table->string('tags')->nullable();
            $table->json('stats')->nullable(); // Array of stats like [['label' => 'Children reached', 'value' => '3,470']]
            $table->json('chart_data')->nullable(); // For donut/bar charts in project details
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_published')->default(false);
            $table->date('project_date')->nullable();
            $table->string('download_link')->nullable(); // For project summary download
            $table->timestamps();

            // Indexes for better performance
            $table->index('slug');
            $table->index('category');
            $table->index('is_published');
            $table->index('is_featured');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
