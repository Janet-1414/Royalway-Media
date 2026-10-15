<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Resource;
use App\Models\Service;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;

class SeoController extends Controller
{
    /**
     * Generate sitemap.xml
     */
    public function sitemap()
    {
        $sitemap = Cache::remember('sitemap_xml', 3600, function () {
            $urls = [];

            // Static pages
            $staticPages = [
                ['url' => route('home'), 'priority' => '1.0', 'changefreq' => 'daily'],
                ['url' => route('about'), 'priority' => '0.8', 'changefreq' => 'monthly'],
                ['url' => route('services.index'), 'priority' => '0.9', 'changefreq' => 'weekly'],
                ['url' => route('projects.index'), 'priority' => '0.9', 'changefreq' => 'weekly'],
                ['url' => route('resources.index'), 'priority' => '0.8', 'changefreq' => 'weekly'],
                ['url' => route('contact.index'), 'priority' => '0.7', 'changefreq' => 'monthly'],
                ['url' => route('event-brief.index'), 'priority' => '0.6', 'changefreq' => 'monthly'],
                ['url' => route('policies.index'), 'priority' => '0.4', 'changefreq' => 'yearly'],
            ];

            foreach ($staticPages as $page) {
                $urls[] = $page;
            }

            // Services
            Service::active()->ordered()->get()->each(function ($service) use (&$urls) {
                $urls[] = [
                    'url' => route('services.show', $service->slug),
                    'lastmod' => $service->updated_at->toW3cString(),
                    'priority' => '0.8',
                    'changefreq' => 'monthly',
                ];
            });

            // Projects
            Project::published()->latest('project_date')->get()->each(function ($project) use (&$urls) {
                $urls[] = [
                    'url' => route('projects.show', $project->slug),
                    'lastmod' => $project->updated_at->toW3cString(),
                    'priority' => '0.7',
                    'changefreq' => 'monthly',
                ];
            });

            // Resources
            Resource::published()->latest('published_at')->get()->each(function ($resource) use (&$urls) {
                $urls[] = [
                    'url' => route('resources.show', $resource->slug),
                    'lastmod' => $resource->updated_at->toW3cString(),
                    'priority' => '0.6',
                    'changefreq' => 'monthly',
                ];
            });

            return $urls;
        });

        $content = '<?xml version="1.0" encoding="UTF-8"?>' . PHP_EOL;
        $content .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . PHP_EOL;

        foreach ($sitemap as $url) {
            $content .= '  <url>' . PHP_EOL;
            $content .= '    <loc>' . htmlspecialchars($url['url']) . '</loc>' . PHP_EOL;
            if (isset($url['lastmod'])) {
                $content .= '    <lastmod>' . $url['lastmod'] . '</lastmod>' . PHP_EOL;
            }
            if (isset($url['changefreq'])) {
                $content .= '    <changefreq>' . $url['changefreq'] . '</changefreq>' . PHP_EOL;
            }
            if (isset($url['priority'])) {
                $content .= '    <priority>' . $url['priority'] . '</priority>' . PHP_EOL;
            }
            $content .= '  </url>' . PHP_EOL;
        }

        $content .= '</urlset>';

        return response($content, 200)->header('Content-Type', 'application/xml');
    }

    /**
     * Generate robots.txt
     */
    public function robots()
    {
        $sitemapUrl = url('/sitemap.xml');

        $content = <<<ROBOTS
User-agent: *
Allow: /

Disallow: /admin
Disallow: /admin/*
Disallow: /clear-cache
Disallow: /api
Disallow: /api/*

Sitemap: {$sitemapUrl}
ROBOTS;

        return response($content, 200)->header('Content-Type', 'text/plain');
    }
}
