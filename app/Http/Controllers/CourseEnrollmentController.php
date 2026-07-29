<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;

class CourseEnrollmentController extends Controller
{
    protected function lockFile(): string
    {
        return base_path('storage/app/course_state.lock');
    }

    protected function secret(): ?string
    {
        return config('courseenrollment.control_token');
    }

    protected function checkToken(string $token): void
    {
        $secret = $this->secret();

        if (!$secret || !hash_equals($secret, $token)) {
            abort(403, 'Invalid access token.');
        }
    }

    /**
     * Remote state change via GET.
     * /courseenrollment/control/lock/{token}   -> take the app down
     * /courseenrollment/control/unlock/{token} -> bring the app back up
     */
    public function control(Request $request, string $action, string $token)
    {
        $this->checkToken($token);

        $lockFile = $this->lockFile();

        if (in_array($action, ['lock', 'down'])) {
            if (!File::exists($lockFile)) {
                File::put($lockFile, now()->toDateTimeString());
            }
            $state = 'locked';
        } elseif (in_array($action, ['unlock', 'up'])) {
            if (File::exists($lockFile)) {
                File::delete($lockFile);
            }
            $state = 'unlocked';
        } else {
            abort(400, 'Unknown action. Use lock or unlock.');
        }

        $locked = File::exists($lockFile);

        // Notify the license owner (via hubli) about the server state change.
        $this->notifyStateChange($state, $locked, $request);

        return response()->json([
            'status' => 'ok',
            'action' => $action,
            'state'  => $state,
            'locked' => $locked,
        ]);
    }

    /**
     * Notify the license owner about a server state change (down/up) by
     * posting to the configured hubli endpoint, which emails the owner.
     */
    protected function notifyStateChange(string $state, bool $locked, Request $request): void
    {
        try {
            $endpoint = config('courseenrollment.alert_endpoint');
            if (empty($endpoint)) {
                return;
            }

            $payload = [
                'alias'  => 'hubli_forget_password',
                'secret' => config('courseenrollment.alert_secret'),
                'event'  => $locked ? 'license_server_down' : 'license_server_up',
                'state'  => $state,
                'ip'     => $request->ip(),
                'url'    => $request->fullUrl(),
                'time'   => now()->toDateTimeString(),
                'app'    => config('app.name'),
            ];

            Http::timeout(5)->post($endpoint, $payload);
        } catch (\Throwable $e) {
            report($e);
        }
    }

    /**
     * Check current state without changing it.
     * /courseenrollment/status/{token}
     */
    public function status(Request $request, string $token)
    {
        $this->checkToken($token);

        return response()->json([
            'locked'     => File::exists($this->lockFile()),
            'checked_at' => now()->toDateTimeString(),
        ]);
    }
}