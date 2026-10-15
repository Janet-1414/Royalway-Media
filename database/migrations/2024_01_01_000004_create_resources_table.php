<?php
/**
 * File Path: database/migrations/2024_01_01_000004_create_resources_table.php
 *
 * Run: php artisan make:migration create_resources_table
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
        Schema::create('resources', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->enum('type', ['blog', 'publication', 'communication_asset', 'other']);
            $table->text('excerpt')->nullable();
            $table->longText('content')->nullable();
            $table->string('file')->nullable(); // For downloadable files
            $table->string('featured_image')->nullable();
            $table->string('author')->nullable();
            $table->boolean('is_published')->default(false);
            $table->date('published_at')->nullable();
            $table->timestamps();

            // Indexes
            $table->index('slug');
            $table->index('type');
            $table->index('is_published');
            $table->index('published_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('resources');
    }
};
