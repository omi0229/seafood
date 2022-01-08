<?php


namespace App\Services;

use App\Models\PutOn;

class EventServices
{
    # 增加一筆此產品瀏覽人數
    public function addProductVisits($product_id): bool
    {
        $model = new PutOn;
        $put_on = $model::with(['product'])->find(PutOn::decodeSlug($product_id));
        if ($put_on) {
            $put_on->product->number_of_visits += 1;
            $put_on->product->save();
            return true;
        }

        return false;
    }
}
