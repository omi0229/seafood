<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class CartResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $img = null;
        foreach ($this->product_specification->product->product_images as $key => $row) {
            if ($this->product_specification->product->product_front_cover_image_id === $row->id && Storage::disk('s3')->exists($row->path)) {
                $img = env('CDN_URL') . $row->path;
            }
        }

        if (!$img && $this->product_specification->product->product_images->count() > 0) {
            $item = $this->product_specification->product->product_images->first();
            $img = Storage::disk('s3')->exists($item->path) ? env('CDN_URL') . $item->path : null;
        }

        $product_specification = $this->product_specification->toArray();
        unset($product_specification['id']);
        unset($product_specification['product_id']);
        unset($product_specification['product']['id']);

        return [
            'id' => $this->hash_id,
            'product_id' => $this->product_specification->product->hash_id,
            'specifications_id' => $this->product_specification->hash_id,
            'count' => $this->count,
            'product_specification' => $product_specification,
            'img' => $img,
        ];
    }
}
