<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasColumn('services', 'offer_background_image')) {
            return;
        }

        Schema::table('services', function (Blueprint $table) {
            $table->string('offer_background_image')->nullable()->after('poster_image');
        });
    }

    public function down(): void
    {
        if (! Schema::hasColumn('services', 'offer_background_image')) {
            return;
        }

        Schema::table('services', function (Blueprint $table) {
            $table->dropColumn('offer_background_image');
        });
    }
};
