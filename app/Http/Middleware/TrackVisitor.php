<?php

namespace App\Http\Middleware;

use App\Models\VisitorLog;
use Closure;
use Illuminate\Http\Request;

class TrackVisitor
{
    // Skip admin panel, asset requests, and AJAX calls
    private array $skipPrefixes = ['admin/', 'api/', '_debugbar', 'telescope'];
    private array $skipExtensions = ['css', 'js', 'png', 'jpg', 'jpeg', 'gif', 'ico', 'svg', 'woff', 'woff2', 'ttf', 'map'];

    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        if ($this->shouldTrack($request)) {
            try {
                $ua = $request->userAgent();
                $parsed = VisitorLog::parseUserAgent($ua);

                VisitorLog::create([
                    'ip_address'  => $request->ip(),
                    'url'         => $request->fullUrl(),
                    'method'      => $request->method(),
                    'user_agent'  => $ua,
                    'browser'     => $parsed['browser'],
                    'platform'    => $parsed['platform'],
                    'device_type' => $parsed['device_type'],
                    'referer'     => $request->header('referer'),
                    'user_id'     => auth()->id(),
                    'session_id'  => $request->session()->getId(),
                ]);
            } catch (\Throwable $e) {
                // Never break the app due to tracking failure
            }
        }

        return $response;
    }

    private function shouldTrack(Request $request): bool
    {
        if ($request->ajax()) return false;

        $path = $request->path();

        foreach ($this->skipPrefixes as $prefix) {
            if (str_starts_with($path, $prefix)) return false;
        }

        $ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));
        if (in_array($ext, $this->skipExtensions)) return false;

        return true;
    }
}
