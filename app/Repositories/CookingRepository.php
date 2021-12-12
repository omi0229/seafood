<?php

namespace App\Repositories;

use Illuminate\Http\Request;
use App\Repositories\Repository;
use App\Models\Cooking;
use App\Models\CookingTypes;

class CookingRepository extends Repository
{
    public function model()
    {
        return 'App\Models\Cooking';
    }

    public function list($page, array $params = [])
    {
        $keywords = data_get($params, 'keywords');

        $data = !$keywords ? $this->model : $this->model->where('title', 'LIKE', '%' . $keywords . '%');

        return $this->__formatData($data, $page);
    }

    public function apiList($type_id = null, $page = null)
    {
        $data = $type_id ? $this->model->where('cooking_types_id', CookingTypes::decodeSlug($type_id)) : $this->model;

        $data = $data->where('status', 1);

        # 此分類的全部數量
        $all_count = $data->count();

        # 此分類共有幾頁
        $page_count = ceil($all_count / env('COOKING_PAGE_ITEM_COUNT', 10));

        return ['list' => $this->__formatData($data, $page, env('COOKING_PAGE_ITEM_COUNT', 10)), 'all_count' => $all_count, 'page_count' => $page_count, 'page_item_count' => env('COOKING_PAGE_ITEM_COUNT', 10)];
    }

    public function searchList($page, $keywords = null)
    {
        $data = $this->model::with(['cooking_types'])->where('status', 1);

        # 有 關鍵字
        $data = !$keywords ? $data : $data->where('title', 'LIKE', '%' . $keywords . '%');

        # 此搜尋結果全部數量
        $all_count = $data->count();

        # 此搜尋結果共有幾頁
        $page_count = ceil($all_count / env('COOKING_PAGE_ITEM_COUNT', 10));

        $page = $page ? $page : 1;

        return ['list' => $this->__formatData($data, $page, env('COOKING_PAGE_ITEM_COUNT', 10)), 'all_count' => $all_count, 'page_count' => $page_count, 'page_item_count' => (int)env('COOKING_PAGE_ITEM_COUNT', 10)];
    }

    private function __formatData($data, $set_page = null, $page_item_count = 10)
    {
        $page = $set_page ? $set_page : 1;

        # 是否分頁顯示
        $start = $page !== 'all' && is_numeric($page) ? ($page - 1) * $page_item_count : null;
        $data  = $page !== 'all' && is_numeric($page) ? $data->skip($start)->take($page_item_count)->get() : $data->get();

        $list = [];
        foreach ($data as $key => $row) {
            array_push($list, json_decode($row, true));
            $list[$key]['id'] = $row->hash_id;
            $list[$key]['cooking_types_id'] = $row->cooking_types->hash_id ?? '';
            $list[$key]['cooking_types_name'] = $row->cooking_types->name ?? '';
            $list[$key]['youtube_url'] = 'https://www.youtube.com/embed/' . $row->youtube_id;
        }

        return $list;
    }

    public function count(array $params = [])
    {
        $keywords = data_get($params, 'keywords');

        $data = !$keywords ? $this->model : $this->model->where('title', 'LIKE', '%' . $keywords . '%');

        return $data->count();
    }

    public function insertData($inputs, Request $request)
    {
        unset($inputs['id']);
        $inputs['cooking_types_id'] = CookingTypes::decodeSlug($inputs['cooking_types_id']);
        $inputs['keywords'] = implode(',', $inputs['keywords']);
        $this->model::create($inputs);

        return true;
    }

    public function updateData($inputs, Request $request)
    {
        $id = $inputs['id'];
        unset($inputs['id']);

        $news = $this->model::find($this->model::decodeSlug($id));
        if ($news) {
            $inputs['cooking_types_id'] = CookingTypes::decodeSlug($inputs['cooking_types_id']);
            $inputs['keywords'] = implode(',', $inputs['keywords']);
            $news->update($inputs);

            return true;
        }

        return false;
    }
}
