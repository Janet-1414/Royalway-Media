<?php
/**
 * File Path: app/Http/Controllers/ServiceController.php
 *
 * Run: php artisan make:controller ServiceController
 * Then replace content with this file
 */

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    /**
     * Display a listing of services
     */
    public function index()
    {
        $services = Service::active()
            ->ordered()
            ->get();

        return view('services.index', compact('services'));
    }

    /**
     * Display the specified service
     */
    public function show($slug)
    {
        $service = Service::active()
            ->where('slug', $slug)
            ->firstOrFail();

        // Get projects linked to this service
        $projects = $service->projects()
            ->published()
            ->orderBy('project_date', 'desc')
            ->get();

        // If no linked projects, fallback to same category or latest
        if ($projects->isEmpty()) {
            $projects = \App\Models\Project::published()
                ->orderBy('project_date', 'desc')
                ->limit(3)
                ->get();
        }

        $otherServices = Service::active()
            ->where('id', '!=', $service->id)
            ->ordered()
            ->get();

        return view('services.show', compact('service', 'projects', 'otherServices'));
    }
}
