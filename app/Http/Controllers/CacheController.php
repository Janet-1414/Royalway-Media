<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;

class CacheController extends Controller
{
    /**
     * Clear all application caches
     */
    public function clearAll()
    {
        try {
            // Clear application cache
            Artisan::call('cache:clear');

            // Clear route cache
            Artisan::call('route:clear');

            // Clear config cache
            Artisan::call('config:clear');

            // Clear view cache
            Artisan::call('view:clear');

            // Clear compiled classes
            Artisan::call('clear-compiled');

            // Optimize clear (clears all caches)
            Artisan::call('optimize:clear');

            return response()->json([
                'success' => true,
                'message' => 'All caches cleared successfully!',
                'cleared' => [
                    'Application Cache',
                    'Route Cache',
                    'Config Cache',
                    'View Cache',
                    'Compiled Classes',
                    'Optimized Cache'
                ]
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error clearing cache: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Clear specific cache
     */
    public function clearSpecific($type)
    {
        try {
            $message = '';

            switch ($type) {
                case 'cache':
                    Artisan::call('cache:clear');
                    $message = 'Application cache cleared!';
                    break;

                case 'route':
                    Artisan::call('route:clear');
                    $message = 'Route cache cleared!';
                    break;

                case 'config':
                    Artisan::call('config:clear');
                    $message = 'Config cache cleared!';
                    break;

                case 'view':
                    Artisan::call('view:clear');
                    $message = 'View cache cleared!';
                    break;

                default:
                    return response()->json([
                        'success' => false,
                        'message' => 'Invalid cache type'
                    ], 400);
            }

            return response()->json([
                'success' => true,
                'message' => $message
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Show cache clearing page (for browser access)
     */
    public function showClearPage()
    {
        return view('admin.clear-cache');
    }

    /**
     * Clear cache and redirect back with message
     */
    public function clearAndRedirect()
    {
        try {
            Artisan::call('cache:clear');
            Artisan::call('route:clear');
            Artisan::call('config:clear');
            Artisan::call('view:clear');
            Artisan::call('clear-compiled');
            Artisan::call('optimize:clear');

            return redirect()->back()->with('success', 'All caches cleared successfully!');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error clearing cache: ' . $e->getMessage());
        }
    }
}
