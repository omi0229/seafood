<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class HomeBannerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->hash_id,
            'href' => $this->href,
            'target' => $this->target,
            'web_img_path' => $this->web_img ? env('CDN_URL') . $this->web_img : null,
            'mobile_img_path' => $this->mobile_img ? env('CDN_URL'). $this->mobile_img : null,
        ];
    }
}
