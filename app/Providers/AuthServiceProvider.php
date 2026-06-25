<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Auth\Notifications\ResetPassword;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        // Build the password-reset email link using the current request's base URL
        // (dynamic host/scheme) so the link always points to the site the user is on.
        ResetPassword::createUrlUsing(function ($notifiable, $token) {
            $request = request();

            $base = ($request && $request->getHttpHost())
                ? $request->getSchemeAndHttpHost()      // e.g. https://sikhobd.com  (dynamic)
                : rtrim(config('app.url'), '/');         // fallback for queue/CLI

            return $base . '/reset-password/' . $token
                . '?email=' . urlencode($notifiable->getEmailForPasswordReset());
        });
    }
}
