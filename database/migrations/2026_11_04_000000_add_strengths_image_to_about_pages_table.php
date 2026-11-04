<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasColumn('about_pages', 'strengths_image')) {
            return;
        }

        Schema::table('about_pages', function (Blueprint $table) {
            $table->string('strengths_image')->nullable()->after('strengths_intro');
        });
    }

    public function down(): void
    {
        if (! Schema::hasColumn('about_pages', 'strengths_image')) {
            return;
        }

        Schema::table('about_pages', function (Blueprint $table) {
            $table->dropColumn('strengths_image');
        });
    }
};
