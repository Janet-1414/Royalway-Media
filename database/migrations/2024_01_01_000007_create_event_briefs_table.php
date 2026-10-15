<?php
/**
 * File Path: database/migrations/2024_01_01_000007_create_event_briefs_table.php
 *
 * Run: php artisan make:migration create_event_briefs_table
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
        Schema::create('event_briefs', function (Blueprint $table) {
            $table->id();

            // Basic Information
            $table->string('organization_name');
            $table->string('key_contact');
            $table->string('venue');
            $table->string('event_nature');

            // Event Setup
            $table->enum('setup', ['indoor', 'outdoor']);
            $table->string('guest_count'); // e.g., 'less50', '50-70', etc.

            // Venue Setup Options
            $table->json('venue_setup')->nullable(); // Array of selected options

            // Sound & Visuals Options
            $table->json('sound_visuals')->nullable(); // Array of selected options

            // Decoration Items
            $table->json('decoration')->nullable(); // Array of selected options

            // Hospitality & Entertainment
            $table->json('hospitality')->nullable(); // Array of selected options

            // Branding & Communication
            $table->json('branding')->nullable(); // Array of selected options

            // Additional Information
            $table->text('additional_info')->nullable();

            // Status & Tracking
            $table->enum('status', ['new', 'reviewed', 'quoted', 'confirmed', 'completed'])->default('new');
            $table->string('ip_address')->nullable();
            $table->string('user_agent')->nullable();

            $table->timestamps();

            // Indexes
            $table->index('status');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_briefs');
    }
};
