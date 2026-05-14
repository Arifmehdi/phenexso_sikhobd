<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\WebsiteParameter;

class WebsiteParameterController extends Controller
{
    public function index()
    {
        $settings = WebsiteParameter::select([
            'logo',
            'favicon',
            'website_title',
            'shipping_charge',
            'meta_author',
            'meta_description',
            'footer_copyright',
            'contact_mobile',
            'contact_address',
            'contact_email',
            'fb_url',
            'twitter_url',
            'youtube_url'
        ])->first();

        return response()->json([
            'status' => true,
            'message' => 'Settings fetched successfully',
            'data' => $settings
        ]);
    }
}
