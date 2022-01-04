<?php


namespace App\Services;

use Validator;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\Member;
use App\Models\DiscountRecord;
use App\Models\ProductSpecifications;

class CouponServices
{
    static $model = 'App\Models\Coupon';

    static function authInputData($inputs)
    {
        $model = app()->make(self::$model);

        $auth = [
            'title' => [
                'required',
                Rule::unique('coupons')->ignore($model::find($model::decodeSlug($inputs['id'])))->whereNull('deleted_at')
            ],
            'coupon' => [
                'required',
                'string',
                Rule::unique('coupons')->ignore($model::find($model::decodeSlug($inputs['id'])))->whereNull('deleted_at')
            ],
            'full_amount' => 'required|numeric',
            'discount' => 'required|numeric',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
        ];

        $tip = [
            'title.required' => '請輸入標題',
            'title.unique' => '已有重複標題名稱',
            'coupon.required' => '請輸入優惠劵名稱',
            'coupon.string' => '優惠劵類型需為字串',
            'coupon.unique' => '已有重複優惠劵名稱',
            'full_amount.required' => '請輸入結帳金額',
            'full_amount.numeric' => '結帳金額請輸入數字',
            'discount.required' => '請輸入優惠金額',
            'discount.numeric' => '優惠金額請輸入數字',
            'start_date.required' => '請選擇開始日期',
            'start_date.date' => '開始日期類型需為日期格式',
            'end_date.required' => '請選擇結束日期',
            'end_date.date' => '結束日期類型需為日期格式',
        ];

        return Validator::make($inputs, $auth, $tip);
    }

    public function search($fixed_name)
    {
        if (!$fixed_name) {
            return ['status' => false, 'message' => '無此優惠代碼'];
        }

        $data = app()->make(self::$model)
            ->with(['discount_records'])
            ->where('start_date', '<=', now()->format('Y-m-d H:i:s'))
            ->where('end_date', '>=', now()->format('Y-m-d H:i:s'))
            ->where('records', '>', 0);

        $info = $data->firstWhere('fixed_name', $fixed_name);

        if ($info) {

            if ($info->discount_records->count() >= $info->records) {
                return ['status' => false, 'message' => 'error'];
            }

            return ['status' => true, 'message' => 'success', 'data' => $info];
        }

        return ['status' => false, 'message' => '無此優惠代碼'];
    }

    public function getCoupon($coupon_id, $member_id, $cart_id = null)
    {
        $model = app()->make(self::$model);
        $member_id = Member::decodeSlug($member_id);
        $records = DiscountRecord::where('type', 'coupon')->where('discount_codes_id', $model::decodeSlug($coupon_id));
        if ($records->count() > 0) {
            # 此會員已領取過
            $is_get = clone $records;
            if ($is_get->where('member_id', $member_id)->count() > 0) {
                return false;
            }

            $item = $records->first();
            if ($item) {
                $item->member_id = $member_id;
                $item->cart_id = $cart_id;
                $item->received_at = now();
                $item->save();
                return true;
            }
        }

        return false;
    }

    # 此會員擁有的優惠劵列表
    public function couponList($member_id, $used = null, $inputs = [], $no_order_use = false)
    {
        $data = DiscountRecord::with(['coupon', 'coupon.product_specifications', 'coupon.product_specifications.product'])->where('type', 'coupon')->where('member_id', Member::decodeSlug($member_id))->orderBy('updated_at', 'DESC');

        if ($used === 'true') {
            $data->whereNotNull('used_at');
        } elseif ($used === 'false') {
            $data->whereNull('used_at');
        }

        $start_date = data_get($inputs, 'start_date');
        $end_date = data_get($inputs, 'end_date');
        if ($start_date && $end_date) {
            $data->whereHas('coupon', function ($query) use ($start_date, $end_date) {
                $query->where(function ($query) use ($start_date, $end_date) {
                    $query->where('start_date', '<', $start_date);
                    $query->where('end_date', '>=', $start_date);
                });
                $query->orWhere(function ($query) use ($start_date, $end_date) {
                    $query->where('start_date', '>=', $start_date);
                    $query->where('start_date', '<=', $end_date);
                });
            });
        }

        $all_total = data_get($inputs, 'all_total');
        if ($all_total && is_numeric($all_total)) {
            $data->whereHas('coupon', function ($query) use ($all_total) {
                $query->where('full_amount', '<=', $all_total);
            });
        }

        $product_list = data_get($inputs, 'product_list');
        if ($product_list && is_array($product_list)) {
            $data->whereHas('coupon', function ($query) use ($product_list) {
                $query->whereDoesntHave('product_specifications');
                $query->orWhereHas('product_specifications', function ($query) use ($product_list) {
                    $query->whereIn('id', array_map(['\App\Models\ProductSpecifications', 'decodeSlug'], $product_list));
                });
            });
        }

        if ($no_order_use) {
            $data->whereNull('orders_id');
        }

        $list = [];
        foreach ($data->get() as $key => $row) {
            array_push($list, json_decode($row, true));
            $list[$key]['id'] = $row->hash_id;
        }

        return $list;
    }

    # 釋放所有過期的優惠劵
    public function couponRecordAuth($member_id)
    {
        $member = Member::with(['orders', 'orders.discount_record'])->find($member_id);
        foreach ($member->orders as $row) {
            if ($row->payment_status !== 1 && $row->payment_method === 2 && now() > Carbon::parse($row->ExpireDate . ' 23:59:59')) {
                foreach ($row->discount_record->where('type', 'coupon') as $record) {
                    $record->orders_id = null;
                    $record->save();
                }
            }
        }
    }

    static function setCoupon($params)
    {
        $coupon_discount = null;
        $coupon_record_id = data_get($params, 'coupon_record_id');
        if ($coupon_record_id) {
            $record = DiscountRecord::with(['coupon'])->find(DiscountRecord::decodeSlug($coupon_record_id));
            if ($record) {
                $coupon_discount = $record->coupon->discount;
            }
        }

        return $coupon_discount;
    }
}
