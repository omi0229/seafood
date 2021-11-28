<?php


namespace App\Services;

use Validator;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\ProductSpecifications;
use App\Models\OrderProducts;
use Ecpay\Sdk\Services\CheckMacValueService;

class OrderServices
{
    static $model = 'App\Models\Orders';

    static function authInputData($inputs)
    {
        $auth = [
            'name' => 'required',
            'cellphone' => 'required',
            'email' => 'email',
            'zipcode' => 'required',
            'country' => 'required',
            'city' => 'required',
            'address' => 'required',
        ];

        $tip = [
            'name.required' => '收件人姓名不得為空',
            'cellphone.required' => '收件人手機號碼不得為空',
            'email.email' => '電子郵件格式錯誤',
            'zipcode.required' => '收件人地址格式錯誤',
            'country.required' => '收件人地址格式錯誤',
            'city.required' => '收件人地址格式錯誤',
            'address.required' => '收件人地址格式錯誤',
        ];

        return Validator::make($inputs, $auth, $tip);
    }

    static function ecpayForm($order_no, $time, $payment_method, $list, $order_id, $freight, $mode = null)
    {
        $model = \App\Models\Config::where('config_name', 'goldflow_MerchantID')->orWhere('config_name', 'goldflow_HashKey')->orWhere('config_name', 'goldflow_HashIV')->get();
        $MerchantID = $model->find('goldflow_MerchantID') ? $model->find('goldflow_MerchantID')->config_value : null;
        $HashKey = $model->find('goldflow_HashKey') ? $model->find('goldflow_HashKey')->config_value : null;
        $HashIV = $model->find('goldflow_HashIV') ? $model->find('goldflow_HashIV')->config_value : null;

        switch ($payment_method) {
            case 2:
                $ChoosePayment = 'ATM';
                break;
            default:
                $ChoosePayment = 'Credit';
        }

        $array = [
            'MerchantID' => $MerchantID,
            'MerchantTradeNo' => $order_no,
            'MerchantTradeDate' => $time->format('Y/m/d H:i:s'),
            'PaymentType' => 'aio',
            'TotalAmount' => self::listTotalAmount($list, $freight, $mode),
            'TradeDesc' => '海龍王商城購物',
            'ItemName' => self::listItemName($list, $freight, $mode),
            'ReturnURL' => env('APP_URL') . '/ecpay-return',
            'ChoosePayment' => $ChoosePayment,
            'EncryptType' => 1,
            'CustomField1' => $order_id,
        ];

        switch ($payment_method) {
            case 2:
                $array['ClientRedirectURL'] = env('APP_URL') . '/ecpay-redirect';
                $array['ExpireDate'] = 1;
                break;
            default:
                $array['OrderResultURL'] = env('APP_URL') . '/ecpay-result';

        }

        $CheckMacValueService = new CheckMacValueService($HashKey, $HashIV, 'sha256');
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

    static function listTotalAmount($list, $freight = 0, $mode = null)
    {
        $total = 0;
        foreach ($list as $row) {
            if($mode === 'make_up') {
                $total += $row['count'] * $row['price'];
            } else {
                $total += $row['count'] * $row['product_specification']['selling_price'];
            }
        }

        $total += $freight;

        return $total;
    }

    static function listItemName($list, $freight = 0, $mode = null)
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

        $item_name .= '#運費 ' . $freight . '元';

        return $item_name;
    }

    # 匯出
    public function exportOrders($type)
    {
        switch ($type) {
            case 'orders':
                return $this->__exportOrders();
            case 'all':
                return $this->__exportAll();
            case 'products':
                return $this->__exportProducts();
        }
    }

    # 匯出訂單
    private function __exportOrders()
    {
        $model = app()->make(self::$model);

        $xls = '<table>';

        $xls .= '<tr>
            <th><span>訂單編號</span></th>
            <th><span>訂單狀態</span></th>
            <th><span>出貨日期</span></th>
            <th><span>付款狀態</span></th>
            <th><span>管理員備註</span></th>
            <th><span>小計</span></th>
            <th><span>運送地點</span></th>
            <th><span>運費</span></th>
            <th><span>總計</span></th>
            <th><span>付款方式</span></th>
            <th><span>配送方式</span></th>
            <th><span>發票種類</span></th>
            <th><span>發票抬頭</span></th>
            <th><span>統一編號</span></th>
            <th><span>訂購人姓名</span></th>
            <th><span>訂購人連絡電話</span></th>
            <th><span>訂購人手機號碼</span></th>
            <th><span>訂購人電子信箱</span></th>
            <th><span>收件人姓名</span></th>
            <th><span>收件人手機號碼</span></th>
            <th><span>收件人縣市</span></th>
            <th><span>收件人鄉鎮市區</span></th>
            <th><span>收件人郵遞區號</span></th>
            <th><span>收件人地址</span></th>
            <th><span>備註</span></th>
            <th><span>訂購時間</span></th>
            <th><span>訂單詳細(品名^規格^單價^數量^價格)</span></th>
        </tr>';

        foreach ($model->all() as $row) {
            $payment_status = '';
            switch ($row['payment_status']) {
                case 0:
                    $payment_status = '尚未付款';
                    break;
                case 1:
                    $payment_status = '付款成功';
                    break;
                case -1:
                    $payment_status = '付款金額錯誤';
                    break;
                case -2:
                    $payment_status = '付款失敗';
                    break;
            }

            $row->load(['order_products', 'member']);
            $order_total = 0;
            $details = '';
            $row->order_products->load('product_specifications.product');
            foreach ($row->order_products as $order_product) {
                $order_total += $order_product->count * $order_product->price;
                $details .= $order_product->product_specifications->product->title . '^';
                $details .= $order_product->product_specifications->name . '^';
                $details .= $order_product->price . '^';
                $details .= $order_product->count . '^';
                $details .= ($order_product->price * $order_product->count) . '; ';
            }

            $invoice_method = $row['invoice_method'] === 2 ? '三聯式發票' : '二聯式發票';

            $xls .= '<tr>
                <td>' . $row['merchant_trade_no'] . '</td>
                <td>' . $this->__orderStatus($row['order_status']) . '</td>
                <td>' . substr($row['shipment_at'], 0, 10) . '</td>
                <td>' . $payment_status  . '</td>
                <td>' . $row['admin_bookmark'] . '</td>
                <td>' . $order_total . '</td>
                <td>' . $row['freight_name'] . '</td>
                <td>' . $row['freight'] . '</td>
                <td>' . ($order_total + $row['freight']) . '</td>
                <td>' . $this->__paymentMethod($row['payment_method']) . '</td>
                <td>' . '宅配到府' . '</td>
                <td>' . $invoice_method . '</td>
                <td>' . $row['invoice_tax_id_number'] . '</td>
                <td>' . $row['invoice_name'] . '</td>
                <td>' . $row['member']['name'] . '</td>
                <td>' . $row['member']['telephone'] . '</td>
                <td style="vnd.ms-excel.numberformat:@">' . $row['member']['cellphone'] . '</td>
                <td>' . $row['member']['email'] . '</td>
                <td>' . $row['name'] . '</td>
                <td style="vnd.ms-excel.numberformat:@">' . $row['cellphone'] . '</td>
                <td>' . $row['country'] . '</td>
                <td>' . $row['city'] . '</td>
                <td>' . $row['zipcode'] . '</td>
                <td>' . $row['address'] . '</td>
                <td>' . $row['bookmark'] . '</td>
                <td>' . $row['created_at'] . '</td>
                <td>' . $details . '</td>
            </tr>';
        }

        $xls .= '</table>';

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="orders.xls"');
        header('Cache-Control: max-age=0');

        return $xls;
    }

    # 匯出全部
    private function __exportAll()
    {
        $data = OrderProducts::all();

        $xls = '<table>';

        $xls .= '<tr>
            <th><span>訂單編號</span></th>
            <th><span>訂購日期</span></th>
            <th><span>商品號碼</span></th>
            <th><span>商品名稱</span></th>
            <th><span>商品規格</span></th>
            <th><span>售價</span></th>
            <th><span>購買數</span></th>
            <th><span>小計</span></th>
            <th><span>加收運費</span></th>
            <th><span>訂單金額</span></th>
            <th><span>會員姓名</span></th>
            <th><span>訂購人手機號碼</span></th>
            <th><span>訂購人連絡電話</span></th>
            <th><span>訂購人電子信箱</span></th>
            <th><span>訂購人地址</span></th>
            <th><span>訂購人備註</span></th>
            <th><span>收件地址</span></th>
            <th><span>付款方式</span></th>
            <th><span>運送地點</span></th>
            <th><span>配送方式</span></th>
            <th><span>訂單狀態</span></th>
            <th><span>訂單備註</span></th>
            <th><span>付款日期</span></th>
        </tr>';

        foreach ($data as $row) {
            $row->load(['order.order_products', 'order.member', 'order.payment_data', 'product', 'product_specifications']);

            $order_total = 0;
            foreach ($row->order->order_products as $product) {
                $order_total += $product->count * $product->price;
            }

            $payment_date = '';
            if ($row->order->payment_data && data_get(json_decode($row->order->payment_data->content, true), 'PaymentDate')) {
                $payment_data = json_decode($row->order->payment_data->content, true);
                $payment_date = substr($payment_data['PaymentDate'], 0, 10);
            }

            $xls .= '<tr>
                <td>' . $row->order->merchant_trade_no  . '</td>
                <td>' . substr($row->order->created_at, 0, 10) . '</td>
                <td>' . $row['id'] . '</td>
                <td>' . $row->product->title . '</td>
                <td>' . $row->product_specifications->name . '</td>
                <td>' . $row['price'] . '</td>
                <td>' . $row['count'] . '</td>
                <td>' . ($row['price'] * $row['count']) . '</td>
                <td>' . $row->order->freight . '</td>
                <td>' . ($order_total + $row->order->freight) . '</td>
                <td>' . $row->order->member->name . '</td>
                <td style="vnd.ms-excel.numberformat:@">' . $row->order->member->cellphone . '</td>
                <td>' . $row->order->member->telephone . '</td>
                <td>' . $row->order->member->email . '</td>
                <td>' . $row->order->member->zipcode . '' . $row->order->member->country . $row->order->member->city . $row->order->member->address . '</td>
                <td>' . $row->order->bookmark . '</td>
                <td>' . $row->order->zipcode . ' ' . $row->order->country . $row->order->city . $row->order->address . '</td>
                <td>' . $this->__paymentMethod($row->order->payment_method) . '</td>
                <td>' . $row->order->freight_name . '</td>
                <td>' . '宅配到府' . '</td>
                <td>' . $this->__orderStatus($row->order->order_status) . '</td>
                <td>' . $row->order->admin_bookmark . '</td>
                <td>' . $payment_date . '</td>
            </tr>';
        }

        $xls .= '</table>';

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="all.xls"');
        header('Cache-Control: max-age=0');

        return $xls;
    }

    # 匯出揀貨單
    private function __exportProducts()
    {
        $data = OrderProducts::all()->sortByDesc('updated_at')->sortByDesc('product_specifications_id');

        $xls = '<table>';

        $xls .= '<tr>
            <th><span>訂單編號</span></th>
            <th><span>會員姓名</span></th>
            <th><span>訂購人手機號碼</span></th>
            <th><span>訂購人連絡電話</span></th>
            <th><span>收件地址</span></th>
            <th><span>商品名稱</span></th>
            <th><span>商品規格</span></th>
            <th><span>購買數</span></th>
            <th><span>小計</span></th>
        </tr>';

        foreach ($data as $row) {
            $row->load(['order.member', 'product', 'product_specifications']);

            $xls .= '<tr>
                <td>' . $row->order->merchant_trade_no . '</td>
                <td>' . $row->order->member->name . '</td>
                <td style="vnd.ms-excel.numberformat:@">' . $row->order->member->cellphone . '</td>
                <td>' . $row->order->member->telephone . '</td>
                <td>' . $row->order->zipcode . ' ' . $row->order->country . $row->order->city . $row->order->address . '</td>
                <td>' . $row->product->title . '</td>
                <td>' . $row->product_specifications->name . '</td>
                <td>' . $row['count'] . '</td>
                <td>' . ($row['price'] * $row['count']) . '</td>
            </tr>';
        }

        $xls .= '</table>';

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="picking-list.xls"');
        header('Cache-Control: max-age=0');

        return $xls;
    }

    private function __paymentMethod($payment)
    {
        $payment_method = '';
        switch ($payment) {
            case 1:
                $payment_method = '信用卡';
                break;
            case 2:
                $payment_method = 'ATM';
                break;
        }

        return $payment_method;
    }

    private function __orderStatus($status)
    {
        $order_status = '';
        switch ($status) {
            case 0:
                $order_status = '新單';
                break;
            case 1:
                $order_status = '收款';
                break;
            case 2:
                $order_status = '出貨';
                break;
            case 3:
                $order_status = '取消';
                break;
            case -1:
                $order_status = '退貨';
                break;
            case -2:
                $order_status = '完成';
                break;
        }

        return $order_status;
    }
}
