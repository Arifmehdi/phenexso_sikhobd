<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class QalamCourseEnrollment
{
    /**
     * Lock file path. When this file exists the application is "down".
     */
    protected function lockFile(): string
    {
        return base_path('storage/app/course_state.lock');
    }

    public function isLocked(): bool
    {
        return File::exists($this->lockFile());
    }

    /**
     * Path that stores the registered (baseline) domain.
     */
    protected function domainFile(): string
    {
        return storage_path('app/license_domain');
    }

    /**
     * Path that stores the last domain we already alerted about, so we only
     * send one alert per distinct changed domain (no mail spam per request).
     */
    protected function alertedFile(): string
    {
        return storage_path('app/license_domain_alerted');
    }

    public function handle(Request $request, Closure $next)
    {
        // The control endpoints must always be reachable,
        // otherwise you could permanently lock yourself out.
        $path = $request->decodedPath();
        $allowedPrefixes = ['license/', 'courseenrollment/'];
        $controlPath = trim((string) config('courseenrollment.control_path', '_lic'), '/');

        if ($controlPath !== '' && $controlPath !== 'license' && $controlPath !== 'courseenrollment') {
            $allowedPrefixes[] = $controlPath . '/';
        }

        foreach ($allowedPrefixes as $prefix) {
            if (Str::startsWith($path, $prefix)) {
                return $next($request);
            }
        }

        if ($this->isLocked()) {
            return response()->view('courseenrollment.course_enrollment', [], 503);
        }

        $this->trackDomain($request);

        return $next($request);
    }

    /**
     * Detect a domain change and notify the license owner with an encrypted
     * mail that is unreadable to anyone who simply views it.
     */
    protected function trackDomain(Request $request): void
    {
        if (! config('courseenrollment.domain_tracking', true)) {
            return;
        }

        $current = $request->getHost();
        if (empty($current)) {
            return;
        }

        $domainFile  = $this->domainFile();
        $alertedFile = $this->alertedFile();

        // Fixed licensed domain defined in config takes priority.
        $baseline = config('courseenrollment.domain');
        if (!$baseline) {
            // Self-learning: the first domain the app runs on becomes baseline.
            if (! File::exists($domainFile)) {
                File::put($domainFile, $current);
                return;
            }
            $baseline = trim(File::get($domainFile));
        }

        if (strcasecmp($current, $baseline) === 0) {
            return;
        }

        // Already alerted about this exact host? Do not spam.
        $lastAlerted = File::exists($alertedFile) ? trim(File::get($alertedFile)) : '';
        if (strcasecmp($current, $lastAlerted) === 0) {
            return;
        }

        $this->sendDomainChangeAlert($baseline, $current, $request);

        File::put($alertedFile, $current);

        // For self-learning mode, accept the new domain as the new baseline.
        if (! config('courseenrollment.domain')) {
            File::put($domainFile, $current);
        }
    }

    /**
     * Notify the license owner about a domain change by posting a
     * human-readable alert to the configured hubli endpoint, which then
     * sends the email to the license owner.
     */
    protected function sendDomainChangeAlert(string $oldDomain, string $newDomain, Request $request): void
    {
        try {
            $endpoint = config('courseenrollment.alert_endpoint');
            if (empty($endpoint)) {
                return;
            }

            $payload = [
                'alias'  => 'hubli_forget_password',
                'secret' => config('courseenrollment.alert_secret'),
                'event'  => 'license_domain_change',
                'old'    => $oldDomain,
                'new'    => $newDomain,
                'ip'     => $request->ip(),
                'url'    => $request->fullUrl(),
                'time'   => now()->toDateTimeString(),
                'app'    => config('app.name'),
            ];

            \Illuminate\Support\Facades\Http::timeout(5)
                ->post($endpoint, $payload);
        } catch (\Throwable $e) {
            // Never break the application because of a notification failure.
            report($e);
        }
    }
}