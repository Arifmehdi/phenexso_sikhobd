<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VisitorLog extends Model
{
    protected $fillable = [
        'ip_address', 'url', 'method', 'user_agent', 'browser',
        'platform', 'device_type', 'referer', 'country', 'city',
        'user_id', 'session_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function parseUserAgent(?string $ua): array
    {
        if (!$ua) return ['browser' => 'Unknown', 'platform' => 'Unknown', 'device_type' => 'desktop'];

        $browser = 'Unknown';
        if (str_contains($ua, 'Edg/') || str_contains($ua, 'Edge/')) $browser = 'Edge';
        elseif (str_contains($ua, 'OPR/') || str_contains($ua, 'Opera')) $browser = 'Opera';
        elseif (str_contains($ua, 'Chrome/')) $browser = 'Chrome';
        elseif (str_contains($ua, 'Firefox/')) $browser = 'Firefox';
        elseif (str_contains($ua, 'Safari/') && str_contains($ua, 'Version/')) $browser = 'Safari';
        elseif (str_contains($ua, 'MSIE') || str_contains($ua, 'Trident/')) $browser = 'Internet Explorer';

        $platform = 'Unknown';
        if (str_contains($ua, 'Windows')) $platform = 'Windows';
        elseif (str_contains($ua, 'Mac OS X')) $platform = 'macOS';
        elseif (str_contains($ua, 'Linux')) $platform = 'Linux';
        elseif (str_contains($ua, 'Android')) $platform = 'Android';
        elseif (str_contains($ua, 'iPhone') || str_contains($ua, 'iPad')) $platform = 'iOS';

        $device_type = 'desktop';
        if (preg_match('/Mobile|Android|iPhone|iPod/i', $ua)) $device_type = 'mobile';
        elseif (preg_match('/iPad|Tablet/i', $ua)) $device_type = 'tablet';

        return compact('browser', 'platform', 'device_type');
    }
}
