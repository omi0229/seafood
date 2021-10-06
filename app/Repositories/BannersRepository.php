<?php

namespace App\Repositories;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Repositories\Repository;
use App\Models\Banners;

class BannersRepository extends Repository
{
    protected $model;

    public function __construct(Banners $model)
    {
        $this->model = $model;
    }

    public function model()
    {
        return 'App\Models\Banners';
    }

    public function list($page, array $params = [])
    {
        $status = data_get($params, 'status');

        # 是否設定顯示
        $data = $status ? $this->model->where('status', $status) : $this->model;

        $data = $data->orderBy('created_at', 'DESC')->get();

        $list = [];
        foreach ($data as $key => $row) {
            array_push($list, json_decode($row, true));
            $list[$key]['id'] = $row->hash_id;
            $list[$key]['web_img_path'] = $row->web_img ? asset('storage/' . $row->web_img) : null;
            $list[$key]['mobile_img_path'] = $row->mobile_img ? asset('storage/' . $row->mobile_img) : null;
        }

        return $list;
    }

    public function apiData($type_id, $page = null)
    {
        $data = $this->model->where('news_types_id', NewsTypes::decodeSlug($type_id))->where('status', 1);

        # 此分類的全部數量
        $all_count = $data->count();

        # 此分類共有幾頁
        $page_count = ceil($all_count / 10);

        $page = $page ? $page : 1;

        # 是否分頁顯示
        $start = $page !== 'all' && is_numeric($page) ? ($page - 1) * 10 : null;
        $data  = $page !== 'all' && is_numeric($page) ? $data->skip($start)->take(10)->get() : $data->get();

        $list = [];
        foreach ($data as $key => $row) {
            array_push($list, json_decode($row, true));
            $list[$key]['id'] = $row->hash_id;
            $list[$key]['news_types_id'] = $row->news_types->hash_id ?? '';
            $list[$key]['news_types_name'] = $row->news_types->name ?? '';

            $list[$key]['web_img_path'] = $row->web_img ? asset('storage/' . $row->web_img) : null;
            $list[$key]['mobile_img_path'] = $row->mobile_img ? asset('storage/' . $row->mobile_img) : null;
        }

        return ['list' => $list, 'all_count' => $all_count, 'page_count' => $page_count, 'page_item_count' => 10];
    }

    public function apiInfo($id)
    {
        $info = $this->model->where('id', $this->model::decodeSlug($id))->where('status', 1)->get()->first();
        $item = $info->toArray();
        $item['web_img_path'] = $info->web_img ? asset('storage/' . $info->web_img) : null;
        $item['mobile_img_path'] = $info->mobile_img ? asset('storage/' . $info->mobile_img) : null;
        return $item;
    }

    public function count(array $params = [])
    {
        $keywords = data_get($params, 'keywords');

        $data = !$keywords ? $this->model : $this->model->where('title', 'LIKE', '%' . $keywords . '%');

        return $data->count();
    }

    public function insertData(Request $request)
    {
        $inputs = $request->only('href', 'target', 'status', 'web_img_name', 'mobile_img_name');

        if ($request->hasFile('web_img')) {
            $inputs['web_img'] = $request->file('web_img')->store('banners');
        } else {
            $inputs['web_img_name'] = null;
            $inputs['web_img'] = null;
        }

        if ($request->hasFile('mobile_img')) {
            $inputs['mobile_img'] = $request->file('mobile_img')->store('banners');
        } else {
            $inputs['mobile_img_name'] = null;
            $inputs['mobile_img'] = null;
        }

        $this->model::create($inputs);

        return true;
    }

    public function updateData(Request $request)
    {
        $inputs = $request->only('id', 'href', 'target', 'status', 'web_img_name', 'mobile_img_name');

        $web_img_delete = (int)$request->all()['web_img_delete'] ?? 0;
        $mobile_img_delete = (int)$request->all()['mobile_img_delete'] ?? 0;

        $banners = $this->model::find($this->model::decodeSlug($inputs['id']));
        if ($banners) {
            if (!$web_img_delete) {
                if ($request->hasFile('web_img')) {
                    $inputs['web_img'] = $request->file('web_img')->store('banners');
                } else {
                    $inputs['web_img_name'] = !$banners['web_img'] ? null : $inputs['web_img_name'];
                }
            } else {
                $inputs['web_img_name'] = null;
                $inputs['web_img'] = null;
                Storage::disk('local')->delete($banners->web_img);
            }

            if (!$mobile_img_delete) {
                if ($request->hasFile('mobile_img')) {
                    $inputs['mobile_img'] = $request->file('mobile_img')->store('banners');
                } else {
                    $inputs['mobile_img_name'] = !$banners['mobile_img'] ? null : $inputs['mobile_img_name'];
                }
            } else {
                $inputs['mobile_img_name'] = null;
                $inputs['mobile_img'] = null;
                Storage::disk('local')->delete($banners->mobile_img);
            }

            $banners->update($inputs);

            return true;
        }

        return false;
    }
}
