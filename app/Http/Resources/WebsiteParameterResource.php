<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class WebsiteParameterResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return parent::toArray($request);
    }
}


namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class WebsiteParameterResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'logo' => $this->logo,
            'favicon' => $this->favicon,
            'website_title' => $this->website_title,
            'shipping_charge' => $this->shipping_charge,
            'contact' => [
                'mobile' => $this->contact_mobile,
                'email' => $this->contact_email,
                'address' => $this->contact_address,
            ],
            'social' => [
                'facebook' => $this->fb_url,
                'twitter' => $this->twitter_url,
                'youtube' => $this->youtube_url,
            ],
            'meta' => [
                'author' => $this->meta_author,
                'description' => $this->meta_description,
            ],
            'footer' => $this->footer_copyright,
        ];
    }
}
