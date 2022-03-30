<?php


namespace App\Services;

use Carbon\Carbon;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\ProductSpecifications;
use App\Models\OrderProducts;
use App\Models\DiscountCode;
use App\Models\DiscountRecord;
use App\Models\Member;
use App\Repositories\OrderRepository;
use App\Services\DiscountCodeServices;
use App\Services\CouponServices;
use Ecpay\Sdk\Services\CheckMacValueService;

class OrderServices
{
    static $model = 'App\Models\Orders';

    static function authInputData($inputs, $delivery_method = 1)
    {
        if ($delivery_method === 0) {
            $auth = [
                'name' => 'required',
                'cellphone' => 'required',
                'email' => 'email',
            ];

            $tip = [
                'name.required' => '收件人姓名不得為空',
                'cellphone.required' => '收件人手機號碼不得為空',
                'email.email' => '電子郵件格式錯誤',
            ];
        } else {
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
        }

        return Validator::make($inputs, $auth, $tip);
    }

    static function ecpayForm($order_no, $time, $payment_method, $list, $order_id, $freight, $mode = null, array $params = [])
    {
        $order_model = app()->make(self::$model);
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

        # 如果有優惠代碼
        $discount = DiscountCodeServices::setDiscountCode($order_id, $mode, $params, $list, $freight);

        # 如果有優惠劵
        $coupon_record_id = data_get($params, 'coupon_record_id');
        $coupon_discount = CouponServices::setCoupon($params);

        $array = [
            'MerchantID' => $MerchantID,
            'MerchantTradeNo' => $order_no,
            'MerchantTradeDate' => $time->format('Y/m/d H:i:s'),
            'PaymentType' => 'aio',
            'TotalAmount' => self::listTotalAmount($list, $freight, $mode, 'all_total', $discount, $coupon_discount),
            'TradeDesc' => '海龍王商城購物',
            'ItemName' => self::listItemName($list, $freight, $mode, $discount, $coupon_discount),
            'ReturnURL' => env('APP_URL') . '/ecpay-return',
            'ChoosePayment' => $ChoosePayment,
            'EncryptType' => 1,
            'CustomField1' => $order_id,
            'CustomField2' => null,
        ];

        switch ($payment_method) {
            case 2:
                $array['ClientRedirectURL'] = env('APP_URL') . '/ecpay-redirect';
                $array['ExpireDate'] = 1;
                break;
            default:
                $array['OrderResultURL'] = env('APP_URL') . '/ecpay-result';

        }

        # 如果有選優惠劵
        if ($coupon_record_id && $coupon_discount) {
            $array['CustomField2'] = $coupon_record_id;
        }

        $CheckMacValueService = new CheckMacValueService($HashKey, $HashIV, env('ECPAY.PAYMENT_METHOD', 'sha256'));
        $CheckMacValue = $CheckMacValueService->generate($array);

        $array['CheckMacValue'] = $CheckMacValue;

        return $array;
    }

    # 建立 物流訂單產生的 form data
    static function ecpayLogisticsForm($inputs)
    {
        $model = \App\Models\Config::where('config_name', 'goldflow_MerchantID')->orWhere('config_name', 'goldflow_HashKey')->orWhere('config_name', 'goldflow_HashIV')->get();
        $MerchantID = $model->find('goldflow_MerchantID') ? $model->find('goldflow_MerchantID')->config_value : null;
        $HashKey = $model->find('goldflow_HashKey') ? $model->find('goldflow_HashKey')->config_value : null;
        $HashIV = $model->find('goldflow_HashIV') ? $model->find('goldflow_HashIV')->config_value : null;

        $order_model = app()->make(self::$model);
        $order = $order_model->with('member')->find($order_model::decodeSlug($inputs['order_id']));
        if ($order) {
            $array = [
                'MerchantID' => $MerchantID,
                'MerchantTradeDate' => Carbon::parse($order->created_at)->format('Y/m/d H:i:s'),
                'LogisticsType' => 'HOME',
                'LogisticsSubType' => 'TCAT',
                'GoodsAmount' => (int)str_replace(',', '', $inputs['order_total']),
//                'SenderName' => $order->member->name,
//                'SenderCellPhone' => $order->member->cellphone,
//                'SenderZipCode' => $order->member->zipcode,
//                'SenderAddress' => $order->member->country . $order->member->city . $order->member->address,
                'SenderName' => env('SENDER_NAME', '海龍王水產'),
                'SenderCellPhone' => env('SENDER_CELL_PHONE', '0903080848'),
                'SenderZipCode' => env('SENDER_ZIP_CODE', '813'),
                'SenderAddress' => env('SENDER_ADDRESS', '高雄市左營區重和路230號'),
                'ReceiverName' => $order->name,
                'ReceiverCellPhone' => $order->cellphone,
                'ReceiverZipCode' => $order->zipcode,
                'ReceiverAddress' => $order->country . $order->city . $order->address,
                'Temperature' => '0003',
                'Distance' => '00',
                'Specification' => $inputs['Specification'],
                'ScheduledDeliveryTime' => $inputs['ScheduledDeliveryTime'],
                'ServerReplyURL' => env('APP_URL') . '/ecpay-server-reply',
            ];

            $CheckMacValueService = new CheckMacValueService($HashKey, $HashIV, 'md5');
            $CheckMacValue = $CheckMacValueService->generate($array);

            $array['CheckMacValue'] = $CheckMacValue;

            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => env('ECPAY.LOGISTICS_URL'),
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => http_build_query($array),
                CURLOPT_HTTPHEADER => array(
                    'Content-Type: application/x-www-form-urlencoded'
                ),
            ));

            # 1|message or other|error_message
            $response = curl_exec($curl);
            curl_close($curl);

            ### 產生物流訂單LOG
            #目前的後台使用操作者
            $user = session()->get('seafood_user');
            \AppLog::record([
                'type' => 'create_logistics',
                'user_id' => $user->id,
                'data_id' => $order->id,
                'content' => $response,
            ]);

            $return_message = explode('|', $response);

            if (is_array($return_message) && count($return_message) === 2) {
                $status = (int)$return_message[0];
                $message = $return_message[1];
                if ($status === 1) {
                    $response_array = explode('&', substr($response, 2));
                    $content_array = [];
                    foreach ($response_array as $res) {
                        $info = explode('=', $res);
                        if (is_array($info) && count($info) === 2) {
                            $content_array[$info[0]] = $info[1];
                        }
                    }
                    $order->update([
                        'MerchantTradeNo' => $content_array['MerchantTradeNo'],
                        'AllPayLogisticsID' => $content_array['AllPayLogisticsID'],
                        'BookingNote' => $content_array['BookingNote'],
                        'RtnCode' => $content_array['RtnCode'],
                        'RtnMsg' => $content_array['RtnMsg'],
                    ]);
                    return ['status' => true, 'message' => '訂單資料建構成功'];
                } else {
                    return ['status' => false, 'message' => $message];
                }
            }
            return ['status' => false, 'message' => '綠界回傳錯誤'];
        }

        return ['status' => false, 'message' => '無此訂單資料'];
    }

    # 列印託運單
    static function ecpayLogisticsPrint($AllPayLogisticsID) {
        $model = \App\Models\Config::where('config_name', 'goldflow_MerchantID')->orWhere('config_name', 'goldflow_HashKey')->orWhere('config_name', 'goldflow_HashIV')->get();
        $MerchantID = $model->find('goldflow_MerchantID') ? $model->find('goldflow_MerchantID')->config_value : null;
        $HashKey = $model->find('goldflow_HashKey') ? $model->find('goldflow_HashKey')->config_value : null;
        $HashIV = $model->find('goldflow_HashIV') ? $model->find('goldflow_HashIV')->config_value : null;

        $array = [
            'MerchantID' => $MerchantID,
            'AllPayLogisticsID' => implode(',', $AllPayLogisticsID),
        ];

        $CheckMacValueService = new CheckMacValueService($HashKey, $HashIV, 'md5');
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

    static function listTotalAmount($list, $freight = 0, $mode = null, $get_type = null, $discount = null, $coupon_discount = null)
    {
        $total = 0;
        foreach ($list as $row) {
            if($mode === 'make_up') {
                $total += $row['count'] * $row['price'];
            } else {
                $total += $row['count'] * $row['product_specification']['selling_price'];
            }
        }

        if ($get_type === 'all_total') {
            # 扣優惠代碼折扣
            if ($discount && is_numeric($discount)) {
                $total -= $discount;
            }

            # 扣優惠劵折扣
            if ($coupon_discount && is_numeric($coupon_discount)) {
                $total -= $coupon_discount;
            }

            # 加運費
            $total += $freight;
        }

        return $total;
    }

    static function listItemName($list, $freight = 0, $mode = null, $discount = null, $coupon_discount = null)
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

        # 優惠代碼名稱
        if ($discount) {
            $item_name .= '#優惠代碼折扣 -' . $discount . '元';
        }

        # 優惠劵名稱
        if ($coupon_discount) {
            $item_name .= '#優惠劵折扣 -' . $coupon_discount . '元';
        }

        $item_name .= '#運費 ' . $freight . '元';

        return $item_name;
    }

    # line pay
    static function linepayInit($order_no, $list, $order_id, $freight, $mode = null, array $params = [])
    {
        $model = \App\Models\Config::where('config_name', 'line_channel_id')->orWhere('config_name', 'line_secret_key')->get();
        $channelId = $model->find('line_channel_id') ? $model->find('line_channel_id')->config_value : null;
        $channelSecret = $model->find('line_secret_key') ? $model->find('line_secret_key')->config_value : null;

        if ($channelId && $channelSecret) {
            # 如果有優惠代碼
            $discount = DiscountCodeServices::setDiscountCode($order_id, $mode, $params, $list, $freight);

            # 如果有優惠劵
            $coupon_discount = CouponServices::setCoupon($params);
            if ($coupon_discount) {
                $coupon_record_id = data_get($params, 'coupon_record_id');
                if ($coupon_record_id) {
                    $record = DiscountRecord::find(DiscountRecord::decodeSlug($coupon_record_id));
                    if ($record) {
                        $record->orders_id = app()->make(self::$model)::decodeSlug($order_id);
                        $record->save();
                    }
                }
            }

            # 總額
            $amount = self::listTotalAmount($list, $freight, $mode, 'all_total', $discount, $coupon_discount);

            $content = [
                'amount' => $amount,
                'currency' => 'TWD',
                'orderId' => $order_no,
                'packages' => [
                    [
                        'id' => $order_no,
                        'amount' => $amount,
                        'name' => '海龍王商城購物',
                        'products' => [
                            [
                                'name' => '海龍王商品',
                                'imageUrl' => env('APP_URL') . '/images/logo/S__111558660.jpg',
                                'quantity' => 1,
                                'price' => $amount
                            ],
                        ],
                    ]
                ],
                'redirectUrls' => [
                    'confirmUrl' => env('APP_URL') . '/linepay-result',
                ],
            ];

            $uri = '/v3/payments/request';
            $response = (new self)->linePayApi($channelId, $channelSecret, $uri, $content);

            return json_decode($response);
        }

        return false;
    }

    public function linePayApi($channelId, $channelSecret, $uri, $content)
    {
        $Nonce = date('c') . uniqid('-');
        $authMacText = $channelSecret . $uri . json_encode($content) . $Nonce;
        $Authorization = base64_encode(hash_hmac('sha256', $authMacText, $channelSecret, true));

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => env('LINEPAY.API_URL') . $uri,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode($content),
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json',
                'X-LINE-ChannelId: ' . $channelId,
                'X-LINE-Authorization-Nonce: ' . $Nonce,
                'X-LINE-Authorization: ' . $Authorization
            ],
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        return $response;
    }

    # 匯出
    public function exportOrders($type, $params)
    {
        switch ($type) {
            case 'orders':
                return $this->__exportOrders($params);
            case 'all':
                return $this->__exportAll($params);
            case 'products':
                return $this->__exportProducts($params);
        }
    }

    # 匯出訂單
    private function __exportOrders($params = [])
    {
        ini_set('memory_limit', -1);

        $repository = new OrderRepository;
        $model = $repository->searchCondition(app()->make(self::$model), $params);

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

        foreach ($model->get() as $row) {
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
                <td>' . $this->__deliveryMethod($row['delivery_method']) . '</td>
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
    private function __exportAll($params = [])
    {
        ini_set('memory_limit', -1);

        $data = OrderProducts::whereHas('order', function ($query) use ($params) {
            $this->__orderProductsSearchCondition($query, $params);
        })->get();

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
                <td>' . $this->__deliveryMethod($row->order->delivery_method) . '</td>
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
    private function __exportProducts($params = [])
    {
        ini_set('memory_limit', -1);

        $data = OrderProducts::with(['order'])->whereHas('order', function ($query) use ($params) {
            $this->__orderProductsSearchCondition($query, $params);
        })->get()->sortByDesc('product_specifications_id')->sortByDesc('order.id');

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

    private function __orderProductsSearchCondition($query, $params)
    {
        # 關鍵字
        $keywords = data_get($params, 'keywords');
        if ($keywords) {
            $query->where(function ($query) use ($keywords) {
                $query->where('merchant_trade_no', 'LIKE', '%' . $keywords . '%');
                $query->orWhere('name', 'LIKE', '%' . $keywords . '%');
            });
        }

        # 訂單狀態
        $order_status = data_get($params, 'order_status');
        if ($order_status !== null) {
            $query->where('order_status', $order_status);
        }

        # 付款狀態
        $payment_status = data_get($params, 'payment_status');
        if ($payment_status !== null) {
            $query->where('payment_status', $payment_status);
        }

        # 會員編號
        $member_id = data_get($params, 'member_id');
        if ($member_id) {
            $query->where('member_id', Member::decodeSlug($member_id));
        }

        # 訂購時間範圍
        $start_date = data_get($params, 'start_date');
        $end_date = data_get($params, 'end_date');
        if ($start_date && $end_date) {
            $query->whereBetween('created_at', [$start_date . ' 00:00:00', $end_date . ' 23:59:59']);
        }
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

    private function __deliveryMethod($delivery)
    {
        $delivery_method = '';
        switch ($delivery) {
            case 0:
                $delivery_method = '自取';
                break;
            case 1:
                $delivery_method = '宅配到府';
                break;
        }

        return $delivery_method;
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
