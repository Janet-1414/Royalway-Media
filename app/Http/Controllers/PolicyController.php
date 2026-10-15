<?php

namespace App\Http\Controllers;

use App\Models\Policy;
use Illuminate\Http\Request;

class PolicyController extends Controller
{
    public function index()
    {
        $policies = Policy::where('is_published', true)
            ->orderBy('order', 'asc')
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        return view('policies.index', compact('policies'));
    }

    public function show($slug)
    {
        // Fetch the policy
        $policy = Policy::where('slug', $slug)->firstOrFail();

        // Safely decode JSON fields
        $jsonFields = ['contact_info', 'sections', 'attachments', 'metadata'];
        foreach ($jsonFields as $field) {
            if (isset($policy->$field) && is_string($policy->$field) && !empty($policy->$field)) {
                try {
                    $decoded = json_decode($policy->$field, true);
                    $policy->$field = is_array($decoded) ? $decoded : [];
                } catch (\Exception $e) {
                    $policy->$field = [];
                }
            } else {
                $policy->$field = [];
            }
        }

        // Set default values for optional fields that might not exist in database
        $policy->category = $policy->category ?? null;
        $policy->subtitle = $policy->subtitle ?? null;
        $policy->introduction = $policy->introduction ?? null;
        $policy->additional_info = $policy->additional_info ?? null;
        $policy->pdf_file = $policy->pdf_file ?? null;

        // Get related policies (without category since column doesn't exist)
        $relatedPolicies = Policy::where('id', '!=', $policy->id)
            ->where('is_published', true)
            ->orderBy('order', 'asc')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return view('policies.show', compact('policy', 'relatedPolicies'));
    }
}
