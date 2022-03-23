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
                if ($order_product->product->product_front_cover_image_id === $image_row->id && $image_row->path) {
                    $img = env('CDN_URL') . $image_row->path;
                }
            }

            if (!$img && $order_product->product->product_images->count() > 0) {
                $item = $order_product->product->product_images->first();
                $img = $item->path ? env('CDN_URL') . $item->path : null;
            }

            array_push($order_products, $order_product);
            $order_products[$key]['product'] = $order_product->product;
            unset($order_products[$key]['product']['content']);
            $order_products[$key]['product_specifications'] = $order_product->product_specifications;
            $order_products[$key]['img'] = $img;
        }

        $coupon_record = null;
        $record = $this->discount_record->where('type', 'coupon')->first();
        if ($record) {
            $coupon_record = $record->toArray();
            $coupon_record['id'] = $record->hash_id;
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
            'freight_name' => $this->freight_name,
            'delivery_method' => $this->delivery_method,
            'payment_method' => $this->payment_method,
            'TradeNo' => $this->TradeNo,
            'BankCode' => $this->BankCode,
            'vAccount' => $this->vAccount,
            'ExpireDate' => $this->ExpireDate,
            'invoice_method' => $this->invoice_method,
            'invoice_tax_id_number' => $this->invoice_tax_id_number,
            'invoice_name' => $this->invoice_name,
            'shipment_at' => $this->shipment_at,
            'MerchantTradeNo' => $this->MerchantTradeNo,
            'AllPayLogisticsID' => $this->AllPayLogisticsID,
            'BookingNote' => $this->BookingNote,
            'RtnCode' => $this->RtnCode,
            'RtnMsg' => $this->RtnMsg,
            'bookmark' => $this->bookmark,
            'admin_bookmark' => $this->admin_bookmark,
            'order_status' => $this->order_status,
            'payment_status' => $this->payment_status,
            'created_at' => $this->created_at,
            'member' => $this->member,
            'order_products' => $order_products,
            'discount_record' => $this->discount_record->where('type', 'discount_codes')->first(),
            'coupon_record' => $coupon_record,
        ];
    }
}
