<?php

namespace App\Services;

use Illuminate\Support\Facades\Facade;

class SystemServices extends Facade
{
    # 儲存各類型分類的排序
    public function saveSort($inputs): bool
    {
        if (!(data_get($inputs, 'type') && data_get($inputs, 'list'))) {
            return false;
        }

        $model = app()->make('App\\Models\\' . $inputs['type']);
        collect($inputs['list'])->map(function ($d) use ($model) {
            $item = $model->find($model::decodeSlug($d['id']));
            $item->location = $d['location'] ?? 0;
            $item->save();
        });

        return true;
    }
}
