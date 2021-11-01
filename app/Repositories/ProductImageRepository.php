<?php

namespace App\Repositories;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Repositories\Repository;
use App\Models\ProductImages;

class ProductImageRepository extends Repository
{
    protected $request, $model;

    public function __construct(Request $request, ProductImages $model)
    {
        $this->request = $request;
        $this->model = $model;
    }

    public function model()
    {
        return 'App\Models\ProductImages';
    }

    public function createImage($list_type, $product_id, $type)
    {
        $array = [];
        if ($this->request->hasFile($list_type)) {
            $model = app()->make($this->model());
            foreach ($this->request->file($list_type) as $file) {
                $item = $model->create([
                    'name' => $file->getClientOriginalName(),
                    'product_id' => $product_id,
                    'path' => $file->store('product'),
                    'type' => $type,
                ]);
                array_push($array, $item->id);
            }
        }
        return $array;
    }
}
