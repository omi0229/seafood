<?php

namespace App\Repositories;

use App\Repositories\Repository;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;

class DirectoryRepository extends Repository
{
    public function model()
    {
        return 'App\Models\Directory';
    }

    public function list($page, array $params = [])
    {
        # 是否有關鍵字
        $keywords = data_get($params, 'keywords');
        $data = $keywords ? $this->model->where('name', 'LIKE', '%' . $keywords . '%') : $this->model;

        return $this->__formatData($data, $page);
    }

    public function apiList($page, array $params = [])
    {
        $data = $this->model->whereHas('put_ons', function (Builder $query) {
            $query->where('status', 1);
        });

        # 是否有關鍵字
        $keywords = data_get($params, 'keywords');
        $data = $keywords ? $data->where('name', 'LIKE', '%' . $keywords . '%') : $data;

        return $this->__formatData($data, $page, env('PRODUCT_PAGE_ITEM_COUNT', 10));
    }

    private function __formatData($data, $set_page = null, $page_item_count = 10)
    {
        $page = $set_page ? $set_page : 1;

        # 是否分頁顯示
        $start = $page !== 'all' && is_numeric($page) ? ($page - 1) * $page_item_count : null;
        $data  = $page !== 'all' && is_numeric($page) ? $data->skip($start)->take($page_item_count)->get() : $data->get();

        $list = [];
        foreach ($data as $key => $row) {
            $row->load(['put_ons' => function ($query) {
                $query->where('status', 1);
                $query->skip(0)->take(12);
                $query->orderBy('created_at', 'DESC');
                $query->with(['product']);
            }])->loadCount(['put_ons']);

            array_push($list, json_decode($row, true));
            $list[$key]['id'] = $row->hash_id;
            $list[$key]['all_count'] = $row->put_ons_count;
            $list[$key]['page_count'] = ceil($row->put_ons_count / $page_item_count);
            $list[$key]['page_item_count'] = (int)$page_item_count;

            foreach ($row['put_ons'] as $product_key => $product_row) {
                $list[$key]['put_ons'][$product_key]['id'] = $product_row->hash_id;
                $list[$key]['put_ons'][$product_key]['web_img_path'] = $product_row->product->web_img ? asset('storage/' . $product_row->product->web_img) : null;
                $list[$key]['put_ons'][$product_key]['mobile_img_path'] = $product_row->product->mobile_img ? asset('storage/' . $product_row->product->mobile_img) : null;
            }
        }

        return $list;
    }

    public function count(array $params = [])
    {
        $keywords = data_get($params, 'keywords');

        $data = !$keywords ? $this->model : $this->model->where('name', 'LIKE', '%' . $keywords . '%');

        return $data->count();
    }
}
