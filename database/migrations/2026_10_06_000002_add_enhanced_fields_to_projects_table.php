<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->string('location')->nullable()->after('category');
            $table->text('lead')->nullable()->after('description');
            $table->json('narrative_blocks')->nullable()->after('challenge');
            $table->string('side_card_title')->nullable()->after('narrative_blocks');
            $table->json('side_card_items')->nullable()->after('side_card_title');
            $table->json('headline_stats')->nullable()->after('side_card_items');
            $table->json('result_channels')->nullable()->after('results');
            $table->json('result_kpis')->nullable()->after('result_channels');
            $table->text('results_footnote')->nullable()->after('result_kpis');
            $table->text('outcome_text')->nullable()->after('results_footnote');
            $table->string('report_url')->nullable()->after('outcome_text');
            $table->string('summary_pdf')->nullable()->after('report_url');
        });
    }

    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->dropColumn([
                'location',
                'lead',
                'narrative_blocks',
                'side_card_title',
                'side_card_items',
                'headline_stats',
                'result_channels',
                'result_kpis',
                'results_footnote',
                'outcome_text',
                'report_url',
                'summary_pdf',
            ]);
        });
    }
};
