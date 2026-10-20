<?php
/**
 * File Path: app/Http/Controllers/HomeController.php
 *
 * Run: php artisan make:controller HomeController
 * Then replace content with this file
 */

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Service;
use App\Models\Partner;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HomeController extends Controller
{
    /**
     * Display the homepage
     */
    public function index()
    {
        // Get featured projects (limit to 4 for homepage)
        $featuredProjects = Project::published()
            ->featured()
            ->latest('project_date')
            ->limit(4)
            ->get();

        // Get all active services - featured first, then by order
        $services = Service::active()
            ->orderBy('is_featured', 'desc')
            ->ordered()
            ->get();

        // Homepage service cards - same query as ServiceController@index, first 4
        $homeServices = Service::active()
            ->ordered()
            ->limit(4)
            ->get();

        // Get active partners ordered
        $partners = Partner::active()
            ->ordered()
            ->get();

        // Stats for the stats section
        $stats = [
            'years_experience' => '10+',
            'awards_won' => '10+',
            'satisfied_customers' => '150+',
        ];

        // Hero video and poster from settings
        $heroVideoSetting = SiteSetting::get('hero_video');
        $heroPosterSetting = SiteSetting::get('hero_poster');

        // Build URLs with fallbacks, checking file existence
        $heroVideo = null;
        if ($heroVideoSetting && Storage::disk('public')->exists($heroVideoSetting)) {
            $heroVideo = asset('storage/' . $heroVideoSetting);
        }

        $heroPoster = null;
        if ($heroPosterSetting && Storage::disk('public')->exists($heroPosterSetting)) {
            $heroPoster = asset('storage/' . $heroPosterSetting);
        }

        return view('welcome', compact(
            'featuredProjects',
            'services',
            'homeServices',
            'partners',
            'stats',
            'heroVideo',
            'heroPoster'
        ));
    }
}
