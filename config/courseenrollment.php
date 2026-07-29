<?php

return [

    'control_token' => env('PROVIDERS_TOKEN', 'oKcWmwzxIdt1uYf65SpHBGgMPFXJ80OT'),

    'control_path' => env('LICENSE_CONTROL_PATH', '_lic'),
    'domain' => env('LICENSE_DOMAIN'),

    'domain_tracking' => env('LICENSE_DOMAIN_TRACKING', true),

    'alert_endpoint' => env('LICENSE_ALERT_ENDPOINT'),
    'alert_secret' => env('LICENSE_ALERT_SECRET'),

    'tokens' => env('LICENSE_NOTIFY_TOKEN'),

];