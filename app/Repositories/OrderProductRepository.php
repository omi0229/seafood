<?php

namespace App\Repositories;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Products;
use App\Models\ProductSpecifications;
use App\Repositories\Repository;

class OrderProductRepository extends Repository
{
    public function model()
    {
        return 'App\Models\OrderProducts';
    }

    public function insertData($orders_id, $list)
    {
        foreach ($list as $row) {
            $array = [
                'orders_id' => $orders_id,
                'product_id' => Products::decodeSlug($row['product_id']),
                'product_specifications_id' => ProductSpecifications::decodeSlug($row['specifications_id']),
                'count' => $row['count'],
                'price' => $row['product_specification']['selling_price'],
            ];
            $this->create($array);
        }
    }
}
