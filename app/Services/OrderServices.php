<?php


namespace App\Services;

use Validator;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\ProductSpecifications;
use Ecpay\Sdk\Services\CheckMacValueService;

class OrderServices
{
    static $model = 'App\Models\Orders';

    static function ecpayForm($order_no, $time, $list, $order_id, $mode = null)
    {
        $array = [
            'MerchantID' => env('ECPAY.MerchantID', '2000132'),
            'MerchantTradeNo' => $order_no,
            'MerchantTradeDate' => $time->format('Y/m/d H:i:s'),
            'PaymentType' => 'aio',
            'TotalAmount' => self::listTotalAmount($list, $mode),
            'TradeDesc' => '海龍王商城購物',
            'ItemName' => self::listItemName($list, $mode),
            'ReturnURL' => env('APP_URL') . '/ecpay-return',
            'ChoosePayment' => 'Credit',
            'OrderResultURL' => env('APP_URL') . '/ecpay-result',
            'EncryptType' => 1,
            'CustomField1' => $order_id,
        ];

        $CheckMacValueService = new CheckMacValueService(env('ECPAY.HashKey'), env('ECPAY.HashIV'), 'sha256');
        $CheckMacValue = $CheckMacValueService->generate($array);

        $array['CheckMacValue'] = $CheckMacValue;

        return $array;
    }

    static function generate($arParameters = array(), $HashKey = '', $HashIV = '', $encType = 0)
    {
        $sMacValue = '';
        if (isset($arParameters)) {
            // arParameters 為傳出的參數，並且做字母 A-Z 排序
            unset($arParameters['CheckMacValue']);
            uksort($arParameters, array('ECPay_CheckMacValue', 'merchantSort'));
            // 組合字串
            $sMacValue = 'HashKey=' . $HashKey;
            foreach ($arParameters as $key => $value) {
                $sMacValue .= '&' . $key . '=' . $value;
            }
            $sMacValue .= '&HashIV=' . $HashIV;
            // URL Encode 編碼
            $sMacValue = urlencode($sMacValue);
            // 轉成小寫
            $sMacValue = strtolower($sMacValue);
            // 取代為與 dotNet 相符的字元
            $sMacValue = str_replace('%2d', '-', $sMacValue);
            $sMacValue = str_replace('%5f', '_', $sMacValue);
            $sMacValue = str_replace('%2e', '.', $sMacValue);
            $sMacValue = str_replace('%21', '!', $sMacValue);
            $sMacValue = str_replace('%2a', '*', $sMacValue);
            $sMacValue = str_replace('%28', '(', $sMacValue);
            $sMacValue = str_replace('%29', ')', $sMacValue);
            // 編碼
            switch ($encType) {
                case ECPay_EncryptType::ENC_SHA256:
                    // SHA256 編碼
                    $sMacValue = hash('sha256', $sMacValue);
                    break;
                case ECPay_EncryptType::ENC_MD5:
                default:
                    // MD5 編碼
                    $sMacValue = md5($sMacValue);
            }
            $sMacValue = strtoupper($sMacValue);
        }
        return $sMacValue;
    }

    static function listTotalAmount($list, $mode = null)
    {
        $total = 0;
        foreach ($list as $row) {
            if($mode === 'make_up') {
                $total += $row['count'] * $row['price'];
            } else {
                $total += $row['count'] * $row['product_specification']['selling_price'];
            }
        }

        return $total;
    }

    static function listItemName($list, $mode = null)
    {
        $item_name = '';
        foreach ($list as $row) {
            if($mode === 'make_up') {
                $item = $row['product_specifications']['name'] . ' ' .$row['price'] . '元 x ' . $row['count'] . $row['product_specifications']['unit'];
            } else {
                $data = ProductSpecifications::find(ProductSpecifications::decodeSlug($row['specifications_id']));
                $item = $data->name . ' ' .$row['product_specification']['selling_price'] . '元 x ' . $row['count'] . $data->unit;
            }
            $item_name .= $item_name ? '#' . $item : $item;
        }

        return $item_name;
    }
}
