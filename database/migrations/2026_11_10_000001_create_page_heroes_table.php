<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('page_heroes')) {
            return;
        }

        Schema::create('page_heroes', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->string('heading')->nullable();
            $table->text('intro')->nullable();
            $table->string('image')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('page_heroes');
    }
};
