<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Str;

/**
 * Anonymous visitor identity for readership and reactions.
 * Raw IP addresses are never stored, only salted sha256 hashes.
 */
class Visitor
{
    public const COOKIE = 'rw_vid';

    protected const BOT_PATTERN = '/bot|crawl|spider|slurp|mediapartners|facebookexternalhit|embedly|preview|headless|lighthouse|pingdom|monitor|curl|wget|python|java\/|httpclient|okhttp|go-http/i';

    public static function isBot(Request $request): bool
    {
        $agent = (string) $request->userAgent();

        return $agent === '' || preg_match(self::BOT_PATTERN, $agent) === 1;
    }

    /**
     * Logged in users are admin panel users on this site
     */
    public static function isAdmin(): bool
    {
        return auth()->check();
    }

    /**
     * One hash per browser and network, used to count a view once per day
     */
    public static function viewHash(Request $request): string
    {
        return hash('sha256', $request->ip() . '|' . $request->userAgent() . '|' . config('app.key'));
    }

    public static function ipHash(Request $request): string
    {
        return hash('sha256', 'ip|' . $request->ip() . '|' . config('app.key'));
    }

    /**
     * Random id kept in a cookie for one year. Created when $create is true.
     */
    public static function id(Request $request, bool $create = true): ?string
    {
        if ($request->attributes->has(self::COOKIE)) {
            return $request->attributes->get(self::COOKIE);
        }

        $id = $request->cookie(self::COOKIE);

        if (! is_string($id) || ! preg_match('/^[A-Za-z0-9]{32}$/', $id)) {
            if (! $create) {
                return null;
            }

            $id = Str::random(32);
            Cookie::queue(self::COOKIE, $id, 60 * 24 * 365);
        }

        $request->attributes->set(self::COOKIE, $id);

        return $id;
    }

    public static function reactionHash(Request $request, bool $create = true): ?string
    {
        $id = static::id($request, $create);

        return $id ? hash('sha256', 'vid|' . $id . '|' . config('app.key')) : null;
    }
}
