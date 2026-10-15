<?php
/**
 * File Path: database/migrations/2024_01_01_000005_create_policies_table.php
 *
 * Run: php artisan make:migration create_policies_table
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
        Schema::create('policies', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('badge_text')->nullable(); // e.g., "Ethical Today, Thriving Tomorrow"
            $table->longText('content'); // Full policy content (HTML)
            $table->string('sidebar_image')->nullable(); // Image for sidebar
            $table->json('contact_info')->nullable(); // JSON for email, phone, office hours
            $table->date('effective_date')->nullable();
            $table->string('version')->default('1.0');
            $table->boolean('is_published')->default(false);
            $table->integer('order')->default(0);
            $table->timestamps();

            // Indexes
            $table->index('slug');
            $table->index('is_published');
            $table->index('order');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('policies');
    }
};
