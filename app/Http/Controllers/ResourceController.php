<?php
/**
 * File Path: app/Http/Controllers/ResourceController.php
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

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('search')) {
            $term = trim((string) $request->input('search'));
            $query->where(function ($q) use ($term) {
                $q->where('title', 'like', '%' . $term . '%')
                    ->orWhere('excerpt', 'like', '%' . $term . '%')
                    ->orWhere('author', 'like', '%' . $term . '%');
            });
        }

        $resources = $query->latest('published_at')->paginate(12)->withQueryString();

        $types = [
            'blog' => 'Insights',
            'publication' => 'Publications',
            'communication_asset' => 'Communication Assets',
            'other' => 'Other',
        ];

        return view('resources.index', compact('resources', 'types'));
    }

    /**
     * Display the Insights page (published resources of type "blog")
     */
    public function insights(Request $request)
    {
        $base = ResourceModel::published()->blogs();
        $search = trim((string) $request->input('search'));

        // The newest article is shown in the hero
        $featured = (clone $base)->latest('published_at')->latest('id')->first();

        $query = clone $base;

        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', '%' . $search . '%')
                    ->orWhere('excerpt', 'like', '%' . $search . '%')
                    ->orWhere('author', 'like', '%' . $search . '%');
            });
        } elseif ($featured) {
            $query->where('id', '!=', $featured->id);
        }

        $posts = $query->latest('published_at')->latest('id')->paginate(9)->withQueryString();

        return view('insights.index', compact('posts', 'featured', 'search'));
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
