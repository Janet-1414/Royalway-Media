<?php

namespace Database\Seeders;

use App\Models\Service;
use App\Models\Project;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ContentEnhancementSeeder extends Seeder
{
    /**
     * Category mapping for services
     */
    protected array $categoryMap = [
        'Advertising' => 'Media & PR',
        'Digital Marketing' => 'Media & PR',
        'PR & Media Coordination' => 'Media & PR',
        'Experiential Marketing' => 'Events & Activations',
        'Events & Experiences' => 'Events & Activations',
        'Design & Printing' => 'Creative & Production',
        'Audio & Visual Production' => 'Creative & Production',
        'Media Planning, Buying & Monitoring' => 'Strategy & Research',
        'Social Behavioural Change Communications' => 'Strategy & Research',
    ];

    public function run(): void
    {
        $this->backfillServices();
        $this->backfillProjects();
    }

    protected function backfillServices(): void
    {
        $services = Service::all();
        $featuredCount = 0;

        foreach ($services as $service) {
            $updates = [];

            // Category - only if null
            if (is_null($service->category)) {
                $updates['category'] = $this->categoryMap[$service->title] ?? 'Media & PR';
            }

            // Headline - derive from short_description if null
            if (is_null($service->headline) && $service->short_description) {
                $headline = Str::limit($service->short_description, 80, '');
                $updates['headline'] = $headline;
            }

            // Intro - extract first paragraphs from full_description if null
            if (is_null($service->intro) && $service->full_description) {
                $intro = $this->extractIntro($service->full_description);
                if ($intro) {
                    $updates['intro'] = $intro;
                }
            }

            // Checklist - extract strong items from full_description if null
            if (is_null($service->checklist) && $service->full_description) {
                $checklist = $this->extractChecklist($service->full_description);
                if (!empty($checklist)) {
                    $updates['checklist'] = $checklist;
                }
            }

            // Poster image - copy from image if null
            if (is_null($service->poster_image) && $service->image) {
                $updates['poster_image'] = $service->image;
            }

            // Is featured - mark first 8 by order as featured if null
            if (is_null($service->is_featured)) {
                if ($featuredCount < 8) {
                    $updates['is_featured'] = true;
                    $featuredCount++;
                } else {
                    $updates['is_featured'] = false;
                }
            } elseif ($service->is_featured) {
                $featuredCount++;
            }

            if (!empty($updates)) {
                $service->update($updates);
                $this->command->info("Updated service: {$service->title}");
            }
        }

        $this->command->info("Services backfill complete. {$featuredCount} marked as featured.");
    }

    protected function backfillProjects(): void
    {
        $projects = Project::all();

        foreach ($projects as $project) {
            $updates = [];

            // Lead - copy from description if null
            if (is_null($project->lead) && $project->description) {
                $updates['lead'] = $project->description;
            }

            // Location - default to Uganda if null
            if (is_null($project->location)) {
                $updates['location'] = 'Uganda';
            }

            // Narrative blocks - extract from challenge if null
            if (is_null($project->narrative_blocks) && $project->challenge) {
                $blocks = $this->extractNarrativeBlocks($project->challenge);
                if (!empty($blocks)) {
                    $updates['narrative_blocks'] = $blocks;
                }
            }

            // Side card - extract services from challenge if null
            if (is_null($project->side_card_title)) {
                $updates['side_card_title'] = 'Services delivered';
            }

            if (is_null($project->side_card_items) && $project->challenge) {
                $items = $this->extractServicesFromChallenge($project->challenge);
                if (!empty($items)) {
                    $updates['side_card_items'] = $items;
                }
            }

            // Outcome text - copy from results as plain text if null
            if (is_null($project->outcome_text) && $project->results) {
                $plainText = strip_tags($project->results);
                $plainText = html_entity_decode($plainText, ENT_QUOTES | ENT_HTML5);
                $plainText = preg_replace('/\s+/', ' ', trim($plainText));
                if ($plainText) {
                    $updates['outcome_text'] = Str::limit($plainText, 500);
                }
            }

            if (!empty($updates)) {
                $project->update($updates);
                $this->command->info("Updated project: {$project->title}");
            }
        }

        $this->command->info("Projects backfill complete.");
    }

    /**
     * Extract introduction paragraphs from HTML content
     */
    protected function extractIntro(string $html): ?string
    {
        // Try to get first 1-2 paragraphs
        preg_match_all('/<p[^>]*>(.*?)<\/p>/is', $html, $matches);

        if (!empty($matches[1])) {
            $paragraphs = array_slice($matches[1], 0, 2);
            $intro = implode(' ', $paragraphs);
            $intro = strip_tags($intro);
            $intro = html_entity_decode($intro, ENT_QUOTES | ENT_HTML5);
            $intro = preg_replace('/\s+/', ' ', trim($intro));

            if (strlen($intro) > 50) {
                return Str::limit($intro, 400);
            }
        }

        return null;
    }

    /**
     * Extract checklist items from strong tags in lists
     */
    protected function extractChecklist(string $html): array
    {
        $checklist = [];

        // Try to find strong tags within list items
        preg_match_all('/<li[^>]*>.*?<strong[^>]*>(.*?)<\/strong>/is', $html, $matches);

        if (!empty($matches[1])) {
            foreach (array_slice($matches[1], 0, 6) as $item) {
                $item = strip_tags($item);
                $item = html_entity_decode($item, ENT_QUOTES | ENT_HTML5);
                $item = trim($item, ': ');
                if ($item && strlen($item) < 100) {
                    $checklist[] = $item;
                }
            }
        }

        // If no strong tags in lists, try h3/h4 headings
        if (empty($checklist)) {
            preg_match_all('/<h[34][^>]*>(.*?)<\/h[34]>/is', $html, $matches);

            if (!empty($matches[1])) {
                foreach (array_slice($matches[1], 0, 6) as $item) {
                    $item = strip_tags($item);
                    $item = html_entity_decode($item, ENT_QUOTES | ENT_HTML5);
                    $item = trim($item);
                    if ($item && strlen($item) < 100) {
                        $checklist[] = $item;
                    }
                }
            }
        }

        return $checklist;
    }

    /**
     * Extract narrative blocks from challenge content
     */
    protected function extractNarrativeBlocks(string $html): array
    {
        $blocks = [];

        // Split on h3 headings
        $parts = preg_split('/<h3[^>]*>/i', $html);

        if (count($parts) > 1) {
            // First part is content before first h3
            array_shift($parts);

            foreach ($parts as $part) {
                // Extract heading and body
                if (preg_match('/^(.*?)<\/h3>(.*)/is', $part, $match)) {
                    $heading = strip_tags($match[1]);
                    $heading = html_entity_decode($heading, ENT_QUOTES | ENT_HTML5);
                    $heading = trim($heading);

                    $body = trim($match[2]);

                    if ($heading && $body) {
                        $blocks[] = [
                            'heading' => $heading,
                            'body' => $body,
                        ];
                    }
                }
            }
        }

        return $blocks;
    }

    /**
     * Extract services list from challenge content
     */
    protected function extractServicesFromChallenge(string $html): array
    {
        $items = [];

        // Look for "Services Provided" or "Services Offered" section
        if (preg_match('/Services\s+(?:Provided|Offered|Delivered)[^<]*<\/(?:h\d|p|strong)>(.*?)(?=<h|$)/is', $html, $match)) {
            $listContent = $match[1];

            // Extract list items
            preg_match_all('/<li[^>]*>(.*?)<\/li>/is', $listContent, $listMatches);

            if (!empty($listMatches[1])) {
                foreach ($listMatches[1] as $item) {
                    $item = strip_tags($item);
                    $item = html_entity_decode($item, ENT_QUOTES | ENT_HTML5);
                    $item = trim($item);
                    if ($item) {
                        $items[] = ['item' => $item];
                    }
                }
            }
        }

        return $items;
    }
}
