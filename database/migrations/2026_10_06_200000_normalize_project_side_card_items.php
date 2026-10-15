<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Normalize side_card_items from [{item: 'x'}] to ['x'] for simple repeater
     */
    public function up(): void
    {
        $projects = DB::table('projects')
            ->whereNotNull('side_card_items')
            ->get(['id', 'side_card_items']);

        foreach ($projects as $project) {
            $items = json_decode($project->side_card_items, true);

            if (!is_array($items) || empty($items)) {
                continue;
            }

            // Check if already normalized (flat strings)
            if (isset($items[0]) && is_string($items[0])) {
                continue;
            }

            // Normalize: extract 'item' key from each array element
            $normalized = array_map(function ($item) {
                return is_array($item) && isset($item['item']) ? $item['item'] : $item;
            }, $items);

            DB::table('projects')
                ->where('id', $project->id)
                ->update(['side_card_items' => json_encode($normalized)]);
        }
    }

    /**
     * Reverse the normalization (convert back to nested format)
     */
    public function down(): void
    {
        $projects = DB::table('projects')
            ->whereNotNull('side_card_items')
            ->get(['id', 'side_card_items']);

        foreach ($projects as $project) {
            $items = json_decode($project->side_card_items, true);

            if (!is_array($items) || empty($items)) {
                continue;
            }

            // Check if already in nested format
            if (isset($items[0]) && is_array($items[0])) {
                continue;
            }

            // Convert back to nested format
            $nested = array_map(function ($item) {
                return ['item' => $item];
            }, $items);

            DB::table('projects')
                ->where('id', $project->id)
                ->update(['side_card_items' => json_encode($nested)]);
        }
    }
};
