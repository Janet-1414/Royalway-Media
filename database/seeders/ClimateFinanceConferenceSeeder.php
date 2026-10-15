<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\Service;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class ClimateFinanceConferenceSeeder extends Seeder
{
    public function run(): void
    {
        $title = '3rd Africa Climate Finance Conference';

        $overview = <<<'HTML'
<p>This is the third annual conference organized by the Climate Finance and Sustainability (CFS) Centre in collaboration with the Africa Research and Impact Network (ARIN), Frankfurt School of Finance and Management (FS), and the Uganda Institute of Banking and Financial Services (UIBFS).</p>
<p>The 2026 conference builds on the momentum of the 2025 conference and focuses on translating Africa's climate finance commitments into bankable investments, implementable policies, and scalable innovations. Grounded in evidence from ARIN's regional convenings and the forthcoming <em>Africa's Climate Finance Outlook, 2026</em>, this year's agenda is built on real-world experiences from across the continent.</p>
HTML;

        $details = <<<'HTML'
<p>The 2025 conference drew over 200 participants from across the continent and catalyzed national dialogue on climate finance. Building on these outcomes, ARIN has been convening a series of regional climate finance convenings across Africa. Insights from these convenings, alongside fellow-led research, are being synthesized into <em>Africa's Climate Finance Outlook, 2026</em>, a flagship continental report.</p>
<p>The Third Annual Climate Finance Conference (#3ACFC26) aligns with post-COP28 efforts to define country-led Article 6 pathways and ongoing continental efforts under the Africa Climate Change Strategy. The goal is to accelerate the translation of Africa's climate finance commitments into bankable investments, inclusive financial innovations, and actionable delivery systems through a high-level convening of multiple stakeholders.</p>
<p>The two-day conference took place from 1st to 2nd September 2026 at the Marriott Hotel, Kampala, with proceedings delivered through keynote speeches, panel discussions, and research disseminations organized along thematic sessions, gathering a multi-disciplinary audience of about 300 stakeholders in climate finance and sustainability.</p>
HTML;

        $data = [
            'title' => $title,
            'client' => 'Climate Finance and Sustainability (CFS) Centre',
            'description' => "From Commitments to Capital: Operationalizing Africa's Climate Finance Architecture — a two-day high-level convening of about 300 stakeholders in Kampala, Uganda.",
            'challenge' => '<h3>Overview</h3>' . trim($overview) . '<h3>Details</h3>' . trim($details),
            'results' => null,
            'featured_image' => '',
            'gallery' => null,
            'category' => 'Events Planning',
            'is_featured' => true,
            'is_published' => true,
            'project_date' => '2026-09-01',
        ];

        $optional = [
            'location' => 'Marriott Hotel, Kampala, Uganda',
            'lead' => "From Commitments to Capital: Operationalizing Africa's Climate Finance Architecture.",
            'narrative_blocks' => [
                ['heading' => 'Overview', 'body' => trim($overview)],
                ['heading' => 'Details', 'body' => trim($details)],
            ],
            'side_card_title' => 'Conference at a glance',
            'side_card_items' => [
                ['item' => '1–2 September 2026'],
                ['item' => 'Marriott Hotel, Kampala'],
                ['item' => 'About 300 stakeholders'],
                ['item' => 'Keynotes, panels and research disseminations'],
                ['item' => 'Partners: CFS Centre, ARIN, Frankfurt School, UIBFS'],
            ],
        ];

        foreach ($optional as $column => $value) {
            if (Schema::hasColumn('projects', $column)) {
                $data[$column] = $value;
            }
        }

        $project = Project::updateOrCreate(['slug' => Str::slug($title)], $data);

        $serviceIds = Service::whereIn('slug', [
            'events-experiences',
            'audio-visual-production',
            'pr-media-coordination',
        ])->pluck('id');

        $project->services()->syncWithoutDetaching($serviceIds);

        $this->command->info("Project seeded: {$project->title}");
    }
}
