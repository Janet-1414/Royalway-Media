<?php
/**
 * File Path: app/Http/Controllers/ProjectController.php
 *
 * Run: php artisan make:controller ProjectController
 * Then replace content with this file
 */

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    /**
     * Display a listing of projects with filters
     */
    public function index(Request $request)
    {
        $query = Project::published();

        // Filter by category if provided
        if ($request->has('category') && $request->category) {
            $query->where('category', $request->category);
        }

        // Search functionality
        if ($request->has('search') && $request->search) {
            $query->where(function($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                    ->orWhere('description', 'like', '%' . $request->search . '%')
                    ->orWhere('client', 'like', '%' . $request->search . '%');
            });
        }

        // Get all projects with pagination
        $projects = $query->latest('project_date')->paginate(9);

        // Get unique categories for filter dropdown
        $categories = Project::published()
            ->select('category')
            ->distinct()
            ->pluck('category');

        return view('projects.index', compact('projects', 'categories'));
    }

    /**
     * Display the specified project
     */
    public function show($slug)
    {
        $project = Project::with(['services', 'partner'])
            ->where('slug', $slug)
            ->published()
            ->firstOrFail();

        // Get related projects (same category, exclude current)
        $relatedProjects = Project::published()
            ->where('category', $project->category)
            ->where('id', '!=', $project->id)
            ->limit(3)
            ->get();

        return view('projects.show', compact('project', 'relatedProjects'));
    }
}
