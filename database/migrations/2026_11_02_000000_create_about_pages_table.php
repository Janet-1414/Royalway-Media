<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('about_pages')) {
            return;
        }

        Schema::create('about_pages', function (Blueprint $table) {
            $table->id();
            $table->string('hero_title')->nullable();
            $table->string('hero_subtitle')->nullable();
            $table->string('hero_image')->nullable();
            $table->string('intro_badge')->nullable();
            $table->string('intro_heading')->nullable();
            $table->longText('intro_body')->nullable();
            $table->longText('intro_images')->nullable();
            $table->longText('stats')->nullable();
            $table->string('mission_image')->nullable();
            $table->text('mission')->nullable();
            $table->text('vision')->nullable();
            $table->text('purpose')->nullable();
            $table->string('strengths_badge')->nullable();
            $table->text('strengths_intro')->nullable();
            $table->longText('strengths')->nullable();
            $table->string('cta_title')->nullable();
            $table->text('cta_text')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('about_pages');
    }
};
