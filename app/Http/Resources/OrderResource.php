<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $order_products = [];
        foreach ($this->order_products as $key => $order_product) {
            $img = null;
            foreach ($order_product->product->product_images as $image_row) {
                if ($order_product->product->product_front_cover_image_id === $image_row->id && Storage::disk('s3')->exists($image_row->path)) {
                    $img = env('CDN_URL') . $image_row->path;
                }
            }

            if (!$img && $order_product->product->product_images->count() > 0) {
                $item = $order_product->product->product_images->first();
                $img = Storage::disk('s3')->exists($item->path) ? env('CDN_URL') . $item->path : null;
            }

            array_push($order_products, $order_product);
            $order_products[$key]['product'] = $order_product->product;
            $order_products[$key]['product_specifications'] = $order_product->product_specifications;
            $order_products[$key]['img'] = $img;
        }

        return [
            'id' => $this->hash_id,
            'merchant_trade_no' => $this->merchant_trade_no,
            'name' => $this->name,
            'cellphone' => $this->cellphone,
            'email' => $this->email,
            'zipcode' => $this->zipcode,
            'country' => $this->country,
            'city' => $this->city,
            'address' => $this->address,
            'freight' => $this->freight,
            'delivery_method' => $this->delivery_method,
            'payment_method' => $this->payment_method,
            'invoice_method' => $this->invoice_method,
            'invoice_tax_id_number' => $this->invoice_tax_id_number,
            'invoice_name' => $this->invoice_name,
            'bookmark' => $this->bookmark,
            'order_status' => $this->order_status,
            'payment_status' => $this->payment_status,
            'order_products' => $order_products,
        ];
    }
}
