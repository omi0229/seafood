<?php

namespace App\Repositories;

use App\Repositories\Repository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Builder;
use App\Http\Resources\ProductSpecificationResource;

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

    public function apiMenu()
    {
        $data = $this->model->select(['id', 'name'])->whereHas('put_ons', function (Builder $query) {
            $query->where('status', 1);
        })->get();

        $list = [];
        foreach ($data as $key => $row) {
            array_push($list, json_decode($row, true));
            $list[$key]['id'] = $row->hash_id;
        }

        return $list;
    }

    public function apiList($page, array $params = [])
    {
//        $data = $this->model::with(['put_ons' => function ($query) {
//            $query->where('status', 1);
//            $query->orWhere(function (Builder $query) {
//                $query->where('start_date', '<=', now()->format('Y-m-d H:i:s'));
//                $query->where('end_date', '>=', now()->format('Y-m-d H:i:s'));
//            });
//            $query->skip(0)->take(12);
//            $query->orderBy('created_at', 'DESC');
//            $query->orderBy('id', 'DESC');
//            $query->with(['product']);
//        }, 'put_ons.product', 'put_ons.product.product_specification', 'put_ons.product.product_images'])
//        ->whereHas('put_ons', function (Builder $query) {
//            $query->where('status', 1);
//            $query->orWhere(function (Builder $query) {
//                $query->where('start_date', '<=', now()->format('Y-m-d H:i:s'));
//                $query->where('end_date', '>=', now()->format('Y-m-d H:i:s'));
//            });
//        })->withCount(['put_ons' => function ($query) {
//            $query->where('status', 1);
//            $query->orWhere(function (Builder $query) {
//                $query->where('start_date', '<=', now()->format('Y-m-d H:i:s'));
//                $query->where('end_date', '>=', now()->format('Y-m-d H:i:s'));
//            });
//        }]);

        $data = $this->model::whereHas('put_ons', function (Builder $query) {
            $query->where('status', 1);
            $query->orWhere(function (Builder $query) {
                $query->where('start_date', '<=', now()->format('Y-m-d H:i:s'));
                $query->where('end_date', '>=', now()->format('Y-m-d H:i:s'));
            });
        })->withCount(['put_ons' => function ($query) {
            $query->where('status', 1);
            $query->orWhere(function (Builder $query) {
                $query->where('start_date', '<=', now()->format('Y-m-d H:i:s'));
                $query->where('end_date', '>=', now()->format('Y-m-d H:i:s'));
            });
        }]);

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
                $query->orWhere(function (Builder $query) {
                    $query->where('start_date', '<=', now()->format('Y-m-d H:i:s'));
                    $query->where('end_date', '>=', now()->format('Y-m-d H:i:s'));
                });
                $query->skip(0)->take(12);
                $query->orderBy('created_at', 'DESC');
                $query->orderBy('id', 'DESC');
                $query->with(['product']);
            }, 'put_ons.product', 'put_ons.product.product_specification', 'put_ons.product.product_images']);

            array_push($list, json_decode($row, true));
            $list[$key]['id'] = $row->hash_id;
            $list[$key]['all_count'] = $row->put_ons_count;
            $list[$key]['page_count'] = ceil($row->put_ons_count / $page_item_count);
            $list[$key]['page_item_count'] = (int)$page_item_count;

            foreach ($row['put_ons'] as $product_key => $product_row) {
                unset($list[$key]['put_ons'][$product_key]['product']['content']);

                $list[$key]['put_ons'][$product_key]['id'] = $product_row->hash_id;

                $list[$key]['put_ons'][$product_key]['product_specification'] = ProductSpecificationResource::collection($product_row->product->product_specification)->toResponse(app('request'))->getData(true);

                $list[$key]['put_ons'][$product_key]['web_img_list'] = $list[$key]['put_ons'][$product_key]['mobile_img_list'] = [];
                $list[$key]['put_ons'][$product_key]['img'] = null;
                $list[$key]['put_ons'][$product_key]['mobile_img'] = null;
                foreach ($product_row->product->product_images as $img_key => $img_row) {
                    $type = $img_row->type === 'web' ? 'web_img_list' : 'mobile_img_list';
                    $list[$key]['put_ons'][$product_key][$type][$img_key]['path'] = env('CDN_URL') . $img_row->path;

                    if ($product_row->product->product_front_cover_image_id === $img_row->id) {
                        $list[$key]['put_ons'][$product_key]['img'] = $list[$key]['put_ons'][$product_key][$type][$img_key]['path'];
                    }

                    if ($product_row->product->product_mobile_front_cover_image_id === $img_row->id) {
                        $list[$key]['put_ons'][$product_key]['mobile_img'] = $list[$key]['put_ons'][$product_key][$type][$img_key]['path'];
                    }
                }

                $web_img_list = collect($list[$key]['put_ons'][$product_key]['web_img_list']);
                $list[$key]['put_ons'][$product_key]['web_img_list'] = $web_img_list->values()->toArray();

                $mobile_img_list = collect($list[$key]['put_ons'][$product_key]['mobile_img_list']);
                $list[$key]['put_ons'][$product_key]['mobile_img_list'] = $mobile_img_list->values()->toArray();

                if (!$product_row->product->product_front_cover_image_id && $web_img_list->count() > 0) {
                    $list[$key]['put_ons'][$product_key]['img'] = $web_img_list->first()['path'];
                }

                if (!$product_row->product->product_mobile_front_cover_image_id && $mobile_img_list->count() > 0) {
                    $list[$key]['put_ons'][$product_key]['mobile_img'] = $mobile_img_list->first()['path'];
                }
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
