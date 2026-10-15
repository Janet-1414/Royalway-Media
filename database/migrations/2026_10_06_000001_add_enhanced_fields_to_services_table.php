<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('services', function (Blueprint $table) {
            $table->string('category')->nullable()->after('slug');
            $table->string('headline')->nullable()->after('category');
            $table->text('intro')->nullable()->after('headline');
            $table->json('checklist')->nullable()->after('intro');
            $table->string('poster_image')->nullable()->after('image');
            $table->json('gallery')->nullable()->after('poster_image');
            $table->boolean('is_featured')->default(false)->after('is_active');
        });
    }

    public function down(): void
    {
        Schema::table('services', function (Blueprint $table) {
            $table->dropColumn([
                'category',
                'headline',
                'intro',
                'checklist',
                'poster_image',
                'gallery',
                'is_featured',
            ]);
        });
    }
};
