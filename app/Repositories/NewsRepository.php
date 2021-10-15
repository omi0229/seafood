<?php

namespace App\Repositories;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Repositories\Repository;
use App\Models\News;
use App\Models\NewsTypes;

class NewsRepository extends Repository
{
    protected $model, $types;

    public function __construct(News $model, NewsTypes $types)
    {
        $this->model = $model;
        $this->types = $types;
    }

    public function model()
    {
        return 'App\Models\News';
    }

    public function list($page, array $params = [])
    {

        $keywords = data_get($params, 'keywords');
        $status = data_get($params, 'status');

        $data = !$keywords ? $this->model : $this->model->where('title', 'LIKE', '%' . $keywords . '%');

        # 有 是否於上架管理顯示
        $data = $status ? $data->where('status', $status) : $data;

        # 是否分頁顯示
        $start = $page !== 'all' && is_numeric($page) ? ($page - 1) * 10 : null;
        $data  = $page !== 'all' && is_numeric($page) ? $data->skip($start)->take(10) : $data;

        $data = $data->orderBy('created_at', 'DESC')->get();

        $list = [];
        foreach ($data as $key => $row) {
            array_push($list, json_decode($row, true));
            $list[$key]['id'] = $row->hash_id;
            $list[$key]['news_types_id'] = $row->news_types->hash_id ?? '';
            $list[$key]['news_types_name'] = $row->news_types->name ?? '';
            $list[$key]['web_img_path'] = $row->web_img && Storage::disk('s3')->exists($row->web_img) ? Storage::disk('s3')->url($row->web_img) : null;
            $list[$key]['mobile_img_path'] = $row->mobile_img && Storage::disk('s3')->exists($row->mobile_img) ? Storage::disk('s3')->url($row->mobile_img) : null;
        }

        return $list;
    }

    public function apiData($type_id = null, $page = null)
    {
        $data = $type_id ? $this->model->where('news_types_id', NewsTypes::decodeSlug($type_id)) : $this->model->where('carousel', 1);

        $data = $data->where('status', 1);

        # 此分類的全部數量
        $all_count = $data->count();

        # 此分類共有幾頁
        $page_count = $type_id ? ceil($all_count / 10) : 1;

        if ($type_id) {
            $page = $page ? $page : 1;

            # 是否分頁顯示
            $start = $page !== 'all' && is_numeric($page) ? ($page - 1) * 10 : null;
            $data = $page !== 'all' && is_numeric($page) ? $data->skip($start)->take(10)->get() : $data->get();
        } else {
            $data = $data->get();
        }

        $list = [];
        foreach ($data as $key => $row) {
            array_push($list, json_decode($row, true));
            $list[$key]['id'] = $row->hash_id;
            $list[$key]['news_types_id'] = $row->news_types->hash_id ?? '';
            $list[$key]['news_types_name'] = $row->news_types->name ?? '';
            $list[$key]['web_img_path'] = $row->web_img && Storage::disk('s3')->exists($row->web_img) ? Storage::disk('s3')->url($row->web_img) : null;
            $list[$key]['mobile_img_path'] = $row->mobile_img && Storage::disk('s3')->exists($row->mobile_img) ? Storage::disk('s3')->url($row->mobile_img) : null;
        }

        return ['list' => $list, 'all_count' => $all_count, 'page_count' => $page_count, 'page_item_count' => 10];
    }

    public function apiInfo($id)
    {
        $info = $this->model->where('id', $this->model::decodeSlug($id))->where('status', 1)->get()->first();
        $item = $info->toArray();
        $item['web_img_path'] = $info->web_img && Storage::disk('s3')->exists($info->web_img) ? Storage::disk('s3')->url($info->web_img) : null;
        $item['mobile_img_path'] = $info->mobile_img && Storage::disk('s3')->exists($info->mobile_img) ? Storage::disk('s3')->url($info->mobile_img) : null;
        return $item;
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
        $inputs['news_types_id'] = $this->types::decodeSlug($inputs['news_types_id']);

        if ($request->hasFile('web_img')) {
            $inputs['web_img'] = $request->file('web_img')->store('news');
        } else {
            $inputs['web_img_name'] = null;
            $inputs['web_img'] = null;
        }

        if ($request->hasFile('mobile_img')) {
            $inputs['mobile_img'] = $request->file('mobile_img')->store('news');
        } else {
            $inputs['mobile_img_name'] = null;
            $inputs['mobile_img'] = null;
        }

        $this->model::create($inputs);

        return true;
    }

    public function updateData($inputs, Request $request)
    {
        $news_id = $inputs['id'];

        $web_img_delete = (int)$request->all()['web_img_delete'] ?? 0;
        $mobile_img_delete = (int)$request->all()['mobile_img_delete'] ?? 0;

        unset($inputs['id']);

        $news = $this->model::find($this->model::decodeSlug($news_id));
        if ($news) {
            $inputs['news_types_id'] = $this->types::decodeSlug($inputs['news_types_id']);

            if (!$web_img_delete) {
                if ($request->hasFile('web_img')) {
                    $inputs['web_img'] = $request->file('web_img')->store('news');
                } else {
                    $inputs['web_img_name'] = !$news['web_img'] ? null : $inputs['web_img_name'];
                }
            } else {
                $inputs['web_img_name'] = null;
                $inputs['web_img'] = null;
                Storage::disk('s3')->delete($news->web_img);
            }

            if (!$mobile_img_delete) {
                if ($request->hasFile('mobile_img')) {
                    $inputs['mobile_img'] = $request->file('mobile_img')->store('news');
                } else {
                    $inputs['mobile_img_name'] = !$news['mobile_img'] ? null : $inputs['mobile_img_name'];
                }
            } else {
                $inputs['mobile_img_name'] = null;
                $inputs['mobile_img'] = null;
                Storage::disk('s3')->delete($news->mobile_img);
            }

            $news->update($inputs);

            return true;
        }

        return false;
    }
}
