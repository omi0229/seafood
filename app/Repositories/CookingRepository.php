<?php

namespace App\Repositories;

use Illuminate\Http\Request;
use App\Repositories\Repository;
use App\Models\Cooking;
use App\Models\CookingTypes;

class CookingRepository extends Repository
{
    protected $model;

    public function __construct(Cooking $model)
    {
        $this->model = $model;
    }

    public function model()
    {
        return 'App\Models\Cooking';
    }

    public function list($page, array $params = [])
    {

        $keywords = data_get($params, 'keywords');

        $data = !$keywords ? $this->model : $this->model->where('title', 'LIKE', '%' . $keywords . '%');

        if ($page !== 'all' && is_numeric($page)) {
            $start = ($page - 1) * 10;
            $data = $data->skip($start)->take(10)->get();
        } else {
            $data = $data->get();
        }

        $list = [];
        foreach ($data as $key => $row) {
            array_push($list, json_decode($row, true));
            $list[$key]['id'] = $row->hash_id;
            $list[$key]['cooking_types_id'] = $row->cooking_types->hash_id ?? '';
            $list[$key]['cooking_types_name'] = $row->cooking_types->name ?? '';

            $list[$key]['youtube_url'] = $row->youtube_id;
        }

        return $list;
    }

    public function count(array $params = [])
    {
        $keywords = data_get($params, 'keywords');

        dd($this->model->count());

        $data = !$keywords ? $this->model : $this->model->where('title', 'LIKE', '%' . $keywords . '%');

        return $data->count();
    }

    public function insertCooking($inputs, Request $request)
    {
        unset($inputs['id']);
        $inputs['cooking_types_id'] = CookingTypes::decodeSlug($inputs['news_types_id']);
        $inputs['youtube_id'] = 'test';
        $this->model::create($inputs);

        return true;
    }

    public function updateCooking($inputs, Request $request)
    {
        $id = $inputs['id'];
        unset($inputs['id']);

        $news = $this->model::find($this->model::decodeSlug($id));
        if ($news) {
            $inputs['cooking_types_id'] = CookingTypes::decodeSlug($inputs['cooking_types_id']);
            $inputs['youtube_id'] = 'test';
            $news->update($inputs);

            return true;
        }

        return false;
    }
}
