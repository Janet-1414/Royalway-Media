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
        Schema::table('services', function (Blueprint $table) {
            if (!Schema::hasColumn('services', 'tagline')) {
                $table->string('tagline')->nullable()->after('title');
            }
            if (!Schema::hasColumn('services', 'content')) {
                $table->longText('content')->nullable()->after('full_description');
            }
            if (!Schema::hasColumn('services', 'features')) {
                $table->json('features')->nullable()->after('content');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('services', function (Blueprint $table) {
            if (Schema::hasColumn('services', 'tagline')) {
                $table->dropColumn('tagline');
            }
            if (Schema::hasColumn('services', 'content')) {
                $table->dropColumn('content');
            }
            if (Schema::hasColumn('services', 'features')) {
                $table->dropColumn('features');
            }
        });
    }
};
