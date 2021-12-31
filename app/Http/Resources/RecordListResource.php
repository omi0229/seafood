<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class RecordListResource extends JsonResource
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
            'merchant_trade_no' => $this->merchant_trade_no,
            'payment_method' => $this->payment_method,
            'freight' => $this->freight,
            'payment_status' => $this->payment_status,
            'order_status' => $this->order_status,
            'created_at' => $this->created_at,
            'order_products' => $this->order_products,
            'discount_record' => $this->discount_record->where('type', 'discount_codes')->first(),
            'coupon_record' => $this->discount_record->where('type', 'coupon')->first(),
        ];
    }
}
