<?php
/**
 * File Path: app/Http/Controllers/PageController.php
 *
 * Run: php artisan make:controller PageController
 * Then replace content with this file
 */

namespace App\Http\Controllers;

use App\Models\TeamMember;
use App\Models\Service;
use App\Models\Partner;
use Illuminate\Http\Request;

class PageController extends Controller
{
    /**
     * Display the about page
     */
    public function about()
    {
        $teamMembers = TeamMember::active()
            ->ordered()
            ->get();

        $services = Service::active()
            ->ordered()
            ->limit(3)
            ->get();

        $partners = Partner::active()
            ->ordered()
            ->get();

        return view('about', compact('teamMembers', 'services', 'partners'));
    }
}
