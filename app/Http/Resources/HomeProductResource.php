<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Builder;

class HomeProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $this->load(['put_ons' => function ($query) {
            $query->where('status', 1);
            $query->orWhere(function (Builder $query) {
                $query->where('start_date', '<=', now()->format('Y-m-d H:i:s'));
                $query->where('end_date', '>=', now()->format('Y-m-d H:i:s'));
            });
            $query->skip(0)->take(12);
            $query->orderBy('created_at', 'DESC');
            $query->orderBy('id', 'DESC');
            $query->with(['product']);
        }, 'put_ons.product', 'put_ons.product.product_specification', 'put_ons.product.product_images']);

        $put_ons_count = $this->put_ons_count;
        $page_item_count = (int)env('PRODUCT_PAGE_ITEM_COUNT', 10);

        $put_ons = [];

        foreach ($this->put_ons as $product_key => $product_row) {
            $put_ons[$product_key] = [
                'id' => $product_row->hash_id,
                'product_specification' => ProductSpecificationResource::collection($product_row->product->product_specification)->toResponse(app('request'))->getData(true),
                'product' => [
                    'title' => $product_row->product->title,
                ],
                'img' => null,
                'mobile_img' => null,
            ];

            foreach ($product_row->product->product_images as $img_row) {
                if ($product_row->product->product_front_cover_image_id === $img_row->id) {
                    $put_ons[$product_key]['img'] = env('CDN_URL') . $img_row->path;
                }

                if ($product_row->product->product_mobile_front_cover_image_id === $img_row->id) {
                    $put_ons[$product_key]['mobile_img'] = env('CDN_URL') . $img_row->path;
                }
            }

            if (!$put_ons[$product_key]['img']) {
                $image = $product_row->product->product_images->where('type', 'web')->first();
                $put_ons[$product_key]['img'] = $image ? env('CDN_URL') . $image->path : null;
            }

            if (!$put_ons[$product_key]['mobile_img']) {
                $image = $product_row->product->product_images->where('type', 'mobile')->first();
                $put_ons[$product_key]['mobile_img'] = $image ? env('CDN_URL') . $image->path : null;
            }
        }

        return [
            'id' => $this->hash_id,
            'name' => $this->name,
            'all_count' => $put_ons_count,
            'page_count' => ceil($put_ons_count / $page_item_count),
            'page_item_count' => $page_item_count,
            'put_ons' => $put_ons,
        ];
    }
}
