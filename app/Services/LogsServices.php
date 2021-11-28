<?php


namespace App\Services;

use Validator;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Facade;

class LogsServices extends Facade
{
    static $model = 'App\Models\Log';

    public function record($data)
    {
        $model = app()->make(self::$model);
        $array = [];
        $array['type'] = data_get($data, 'type') ? data_get($data, 'type') : null;
        $array['user_id'] = data_get($data, 'user_id') ? data_get($data, 'user_id') : null;
        $array['data_id'] = data_get($data, 'data_id') ? data_get($data, 'data_id') : null;
        $array['content'] = data_get($data, 'content') ? data_get($data, 'content') : null;

        $model->create($array);
    }
}
