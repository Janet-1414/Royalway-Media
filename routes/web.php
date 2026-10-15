<?php
/**
 * File Path: routes/web.php
 */

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ResourceController;
use App\Http\Controllers\PolicyController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\EventBriefController;
use App\Http\Controllers\CacheController;
use App\Http\Controllers\SeoController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Legacy Redirects (Old Nexelit URLs)
|--------------------------------------------------------------------------
| Must be BEFORE the main routes
*/

// Service slug mapping (old -> new)
$serviceMapping = [
    'advertising' => 'advertising',
    'design-&-printing' => 'design-printing',
    'design-%26-printing' => 'design-printing',
    'digital-marketing' => 'digital-marketing',
    'experiential-marketing' => 'experiential-marketing',
    'pr&-media-coordination' => 'pr-media-coordination',
    'pr%26-media-coordination' => 'pr-media-coordination',
    'media-planning-&-buying-monitoring' => 'media-planning-buying-monitoring',
    'media-planning-%26-buying-monitoring' => 'media-planning-buying-monitoring',
    'events-&-experiences' => 'events-experiences',
    'events-%26-experiences' => 'events-experiences',
    'audio-&-visual-production' => 'audio-visual-production',
    'audio-%26-visual-production' => 'audio-visual-production',
    'social-behavioural-change-communications' => 'social-behavioural-change-communications',
];

// Project slug mapping (old -> new)
$projectMapping = [
    '10-years-of-impact:-enhancing-standard-chartered-bank-uganda' => '10-years-of-impact-standard-chartered-bank',
    '10-years-of-impact%3A-enhancing-standard-chartered-bank-uganda' => '10-years-of-impact-standard-chartered-bank',
    'airtel-uganda:-nationwide-mobile-marketing-success' => 'airtel-nationwide-mobile-marketing-success',
    'airtel-uganda%3A-nationwide-mobile-marketing-success' => 'airtel-nationwide-mobile-marketing-success',
    'empowering-voices-nurturing-futures' => 'unicefs-media-services-for-child-rights-in-uganda',
    'shaping-futures:-the-european-union\'s' => 'the-european-unions-impact-in-uganda',
    'shaping-futures%3A-the-european-union%27s' => 'the-european-unions-impact-in-uganda',
    'cultivating-prosperity:-abi\'s-impact' => 'cultivating-prosperity-abis-impact',
    'cultivating-prosperity%3A-abi%27s-impact' => 'cultivating-prosperity-abis-impact',
];

// Legacy service redirects
Route::get('/service/{old}', function ($old) use ($serviceMapping) {
    $decoded = urldecode($old);
    $newSlug = $serviceMapping[$old] ?? $serviceMapping[$decoded] ?? null;
    if ($newSlug) {
        return redirect()->route('services.show', $newSlug, 301);
    }
    return redirect()->route('services.index', [], 301);
});

Route::get('/services/{old}', function ($old) use ($serviceMapping) {
    $decoded = urldecode($old);
    // Check if it's an old slug that needs mapping
    if (isset($serviceMapping[$old]) || isset($serviceMapping[$decoded])) {
        $newSlug = $serviceMapping[$old] ?? $serviceMapping[$decoded];
        return redirect()->route('services.show', $newSlug, 301);
    }
    // Otherwise, let it fall through to the normal route
    return null;
})->where('old', '.*&.*|.*%26.*');

// Legacy project redirects
Route::get('/case-study/{old}', function ($old) use ($projectMapping) {
    $decoded = urldecode($old);
    $newSlug = $projectMapping[$old] ?? $projectMapping[$decoded] ?? null;
    if ($newSlug) {
        return redirect()->route('projects.show', $newSlug, 301);
    }
    return redirect()->route('projects.index', [], 301);
});

// Legacy static page redirects
Route::get('/about-us', fn() => redirect()->route('about', [], 301));
Route::get('/our-purpose', fn() => redirect()->route('about', [], 301));
Route::get('/diversity-&-inclusion', fn() => redirect()->route('about', [], 301));
Route::get('/diversity-%26-inclusion', fn() => redirect()->route('about', [], 301));
Route::get('/our-commitment-to-sustainability', fn() => redirect()->route('about', [], 301));
Route::get('/communication-assets', fn() => redirect()->route('resources.index', ['type' => 'communication_asset'], 301));
Route::get('/image-gallery', fn() => redirect()->route('projects.index', [], 301));
Route::get('/video-gallery', fn() => redirect()->route('projects.index', [], 301));
Route::get('/blog', fn() => redirect()->route('resources.index', ['type' => 'blog'], 301));
Route::get('/service', fn() => redirect()->route('services.index', [], 301));
Route::get('/case-study', fn() => redirect()->route('projects.index', [], 301));
Route::get('/p/privacy-policy', fn() => redirect()->route('policies.index', [], 301));

/*
|--------------------------------------------------------------------------
| SEO Routes
|--------------------------------------------------------------------------
*/
Route::get('/sitemap.xml', [SeoController::class, 'sitemap'])->name('sitemap');
Route::get('/robots.txt', [SeoController::class, 'robots'])->name('robots');

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Homepage
Route::get('/', [HomeController::class, 'index'])->name('home');

// About Page
Route::get('/about', [PageController::class, 'about'])->name('about');

// Services
Route::get('/services', [ServiceController::class, 'index'])->name('services.index');
Route::get('/services/{slug}', [ServiceController::class, 'show'])->name('services.show');

// Projects
Route::get('/projects', [ProjectController::class, 'index'])->name('projects.index');
Route::get('/projects/{slug}', [ProjectController::class, 'show'])->name('projects.show');

// Resources (Blog, Publications, etc.)
Route::get('/resources', [ResourceController::class, 'index'])->name('resources.index');
Route::get('/resources/{slug}', [ResourceController::class, 'show'])->name('resources.show');

// Policies
Route::get('/policies', [PolicyController::class, 'index'])->name('policies.index');
Route::get('/policies/{slug}', [PolicyController::class, 'show'])->name('policies.show');

// Contact
Route::get('/contact', [ContactController::class, 'index'])->name('contact.index');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

// Event Brief
Route::get('/event-brief', [EventBriefController::class, 'index'])->name('event-brief.index');
Route::post('/event-brief', [EventBriefController::class, 'store'])->name('event-brief.store');

// Simple URL to clear all caches (accessible via browser)
Route::get('/clear-cache', [CacheController::class, 'clearAndRedirect'])->name('cache.clear');

// API endpoints for cache clearing (returns JSON)
Route::prefix('api/cache')->group(function () {
    Route::get('/clear-all', [CacheController::class, 'clearAll'])->name('api.cache.clear.all');
    Route::get('/clear/{type}', [CacheController::class, 'clearSpecific'])->name('api.cache.clear.specific');
});

// Optional: Protected admin page for cache management
Route::get('/admin/cache', [CacheController::class, 'showClearPage'])->name('admin.cache');
