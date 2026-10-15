<?php
/**
 * File Path: app/Http/Controllers/ResourceController.php
 *
 * Run: php artisan make:controller ResourceController
 * Then replace content with this file
 */

namespace App\Http\Controllers;

use App\Models\Resource as ResourceModel;
use Illuminate\Http\Request;

class ResourceController extends Controller
{
    /**
     * Display a listing of resources
     */
    public function index(Request $request)
    {
        $query = ResourceModel::published();

        // Filter by type if provided
        if ($request->has('type') && $request->type) {
            $query->where('type', $request->type);
        }

        // Get resources with pagination
        $resources = $query->latest('published_at')->paginate(12);

        // Get resource types for filter
        $types = [
            'blog' => 'Blog Posts',
            'publication' => 'Publications',
            'communication_asset' => 'Communication Assets',
            'other' => 'Other',
        ];

        return view('resources.index', compact('resources', 'types'));
    }

    /**
     * Display the specified resource
     */
    public function show($slug)
    {
        $resource = ResourceModel::where('slug', $slug)
            ->published()
            ->firstOrFail();

        // Get related resources (same type, exclude current)
        $relatedResources = ResourceModel::published()
            ->where('type', $resource->type)
            ->where('id', '!=', $resource->id)
            ->limit(3)
            ->get();

        return view('resources.show', compact('resource', 'relatedResources'));
    }
}
