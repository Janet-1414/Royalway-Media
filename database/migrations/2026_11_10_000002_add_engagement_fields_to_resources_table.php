<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('resources')) {
            return;
        }

        Schema::table('resources', function (Blueprint $table) {
            if (! Schema::hasColumn('resources', 'topic')) {
                $table->string('topic')->nullable()->after('type');
            }
            if (! Schema::hasColumn('resources', 'is_featured')) {
                $table->boolean('is_featured')->default(false)->after('is_published');
            }
            if (! Schema::hasColumn('resources', 'allow_comments')) {
                $table->boolean('allow_comments')->default(true)->after('is_featured');
            }
            if (! Schema::hasColumn('resources', 'views_count')) {
                $table->unsignedInteger('views_count')->default(0)->after('allow_comments');
            }
        });
    }

    public function down(): void
    {
        if (! Schema::hasTable('resources')) {
            return;
        }

        foreach (['topic', 'is_featured', 'allow_comments', 'views_count'] as $column) {
            if (Schema::hasColumn('resources', $column)) {
                Schema::table('resources', fn (Blueprint $table) => $table->dropColumn($column));
            }
        }
    }
};
