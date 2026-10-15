<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Add SEO fields to services
        Schema::table('services', function (Blueprint $table) {
            $table->string('meta_title', 60)->nullable()->after('is_featured');
            $table->string('meta_description', 160)->nullable()->after('meta_title');
        });

        // Add SEO fields to projects
        Schema::table('projects', function (Blueprint $table) {
            $table->string('meta_title', 60)->nullable()->after('summary_pdf');
            $table->string('meta_description', 160)->nullable()->after('meta_title');
        });

        // Add SEO fields to resources
        Schema::table('resources', function (Blueprint $table) {
            $table->string('meta_title', 60)->nullable()->after('published_at');
            $table->string('meta_description', 160)->nullable()->after('meta_title');
        });
    }

    public function down(): void
    {
        Schema::table('services', function (Blueprint $table) {
            $table->dropColumn(['meta_title', 'meta_description']);
        });

        Schema::table('projects', function (Blueprint $table) {
            $table->dropColumn(['meta_title', 'meta_description']);
        });

        Schema::table('resources', function (Blueprint $table) {
            $table->dropColumn(['meta_title', 'meta_description']);
        });
    }
};
