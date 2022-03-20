<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
<table width='600' border='0' align='center' cellpadding='0' cellspacing='0'>
    <tr>
        <td height='40' align='center' valign='middle'><strong style='font-family: 微軟正黑體;font-size: 13px;color: #CC3300;line-height: 20px;letter-spacing: 1px;font-weight: bold;'>※ 此郵件是系統自動發送，請勿直接回覆此郵件！</strong></td>
    </tr>
    <tr>
        <td height='30' align='center'  valign='middle' style='font-family: 微軟正黑體;font-size: 13px;color: #333333;line-height: 20px;letter-spacing: 1px;text-align: center;'>
        您好，感謝您訂購本站產品，以下為您的訂購資訊<br><span style='font-family: 微軟正黑體;font-size: 13px;color: #333333;line-height: 20px;letter-spacing: 1px;font-weight: bold;'></span></td>
    </tr>
    <tr>
        <td align='left' valign='top'>
            <table width='600' border='0' align='center' cellpadding='0' cellspacing='0'>
                <tr>
                    <td height='30' align='left' valign='middle' style='font-family: 微軟正黑體;font-size: 13px;color: #333333;line-height: 20px;letter-spacing: 1px;'>
                        網站網址：<a href="{{ env('FRONT_PAGE_URL') }}" target="_blank">{{ env('FRONT_PAGE_URL') }}</a>
					</td>
                    <td height='30' align='right' valign='middle' style='font-family: 微軟正黑體;font-size: 13px;color: #333333;line-height: 20px;letter-spacing: 1px;' width='250'>
                        寄送日期：{{(new \DateTime())->format('Y-m-d h:i:s a')}}
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td align='left' valign='top'>
            <table width='600' border='0' align='center' cellpadding='0' cellspacing='0'>
                <tr>
                    <td height='30' align='left' valign='middle'><strong style='font-family: 微軟正黑體;font-size: 14px;font-weight: bold;color: #996633;line-height: 24px;'>【訂購人資訊】</strong></td>
                    <td height='30' align='right' valign='middle' style='font-family: 微軟正黑體;font-size: 13px;color: #333333;line-height: 20px;letter-spacing: 1px;'>IP位置：{{ request()->ip() }}</td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td align='center' valign='middle'>
            <table width='600' align='center' border='0' cellpadding='3' cellspacing='1' bgcolor='#FF9900'>
                <tr bgcolor='#ffffff'>
                    <td width='15%' height='30' align='right' bgcolor='#fef9f0' style='font-family: 微軟正黑體;font-size: 13px;color: #666666;line-height: 20px;letter-spacing: 1px;'>
                        訂單編號︰
                    </td>
                    <td height='30' style='font-family: 微軟正黑體;font-size: 13px;color: #666666;line-height: 20px;letter-spacing: 1px;' align='left'>
                        &nbsp;{{ $order->merchant_trade_no }}
                    </td>
                </tr>
                <tr bgcolor='#ffffff'>
                    <td width='15%' height='30' align='right' bgcolor='#fef9f0' style='font-family: 微軟正黑體;font-size: 13px;color: #666666;line-height: 20px;letter-spacing: 1px;'>
                        訂購姓名︰
                    </td>
                    <td height='30' style='font-family: 微軟正黑體;font-size: 13px;color: #666666;line-height: 20px;letter-spacing: 1px;' align='left'>&nbsp;{{ $order->member->name }}</td>
                </tr>
                <tr bgcolor='#ffffff'>
                    <td width='15%' height='30' align='right' bgcolor='#fef9f0' style='font-family: 微軟正黑體;font-size: 13px;color: #666666;line-height: 20px;letter-spacing: 1px;'>
                        聯絡電話︰
                    </td>
                    <td height='30' style='font-family: 微軟正黑體;font-size: 13px;color: #666666;line-height: 20px;letter-spacing: 1px;' align='left'>&nbsp;{{ $order->member->telephone }}</td>
                </tr>
                <tr bgcolor='#ffffff'>
                    <td width='15%' height='30' align='right' bgcolor='#fef9f0' style='font-family: 微軟正黑體;font-size: 13px;color: #666666;line-height: 20px;letter-spacing: 1px;'>
                        手機電話︰
                    </td>
                    <td height='30' style='font-family: 微軟正黑體;font-size: 13px;color: #666666;line-height: 20px;letter-spacing: 1px;' align='left'>&nbsp;{{ $order->member->cellphone }}</td>
                </tr>
                <tr bgcolor='#ffffff'>
                    <td width='15%' height='30' align='right' bgcolor='#fef9f0' style='font-family: 微軟正黑體;font-size: 13px;color: #666666;line-height: 20px;letter-spacing: 1px;'>
                        電子信箱︰
                    </td>
                    <td height='30' style='font-family: 微軟正黑體;font-size: 13px;color: #666666;line-height: 20px;letter-spacing: 1px;' align='left'>&nbsp;{{ $order->member->email }}</td>
                </tr>
                <tr bgcolor='#ffffff'>
                    <td width='15%' height='30' align='right' bgcolor='#fef9f0' style='font-family: 微軟正黑體;font-size: 13px;color: #666666;line-height: 20px;letter-spacing: 1px;'>
                        收件地址︰
                    </td>
                    <td height='30' style='font-family: 微軟正黑體;font-size: 13px;color: #666666;line-height: 20px;letter-spacing: 1px;' align='left'>&nbsp;{{ $order->zipcode }} {{ $order->country }}{{ $order->city }}{{ $order->address }}</td>
                </tr>
            </table>
        </td>
    </tr>
	<tr>
		<td align='left' valign='top'>
			<table width='600' align='center' border='0' cellpadding='0' cellspacing='0'>
				<tr>
					<td height='30' align='left' valign='middle'><strong style='font-family: 微軟正黑體, sans-serif;font-size: 14px;font-weight: bold;color: #996633;line-height: 24px;'>【訂購備註】</strong></td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td align='left' valign='middle'>
			<table width='600' align='center' border='0' cellpadding='10' cellspacing='1' bgcolor='#FF9900'>
				<tr bgcolor='#ffffff'>
					<td height='30' align='left' bgcolor='#fef9f0' style='font-family: 微軟正黑體, sans-serif;font-size: 13px;color: #666666;line-height: 20px;letter-spacing: 1px;'>&nbsp;{!! nl2br($order->bookmark) !!}</td>
				</tr>
			</table>
		</td>
	</tr>
    <tr>
        <td align='left' valign='top'>
            <table width='600' border='0' align='center' cellpadding='0' cellspacing='0'>
                <tr>
                    <td height='30' align='left' valign='middle'><strong style='font-family: 微軟正黑體;font-size: 14px;font-weight: bold;color: #996633;line-height: 24px;'>【訂單明細】</strong></td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td align='center' valign='middle'>
            <table width='600' align='center' border='0' cellpadding='3' cellspacing='1' bgcolor='#FF9900'>
                <tr bgcolor='#ffffff'>
                    <td width='405' height='30' align='center' bgcolor='#fef9f0' style='font-family: 微軟正黑體;font-size: 13px;color: #666666;line-height: 20px;letter-spacing: 1px;'>產品名稱
                    </td>
                    <td width='65' height='30' align='center' bgcolor='#fef9f0' style='font-family: 微軟正黑體;font-size: 13px;color: #666666;line-height: 20px;letter-spacing: 1px;'>單價
                    </td>
                    <td width='65' height='30' align='center' bgcolor='#fef9f0' style='font-family: 微軟正黑體;font-size: 13px;color: #666666;line-height: 20px;letter-spacing: 1px;'>數量
                    </td>
                    <td width='65' height='30' align='center' bgcolor='#fef9f0' style='font-family: 微軟正黑體;font-size: 13px;color: #666666;line-height: 20px;letter-spacing: 1px;'>金額
                    </td>
                </tr>
                @php
                    # 小計
                    $subtotal = 0;
                @endphp
                @foreach($order->order_products as $order_product)
                <tr bgcolor="#ffffff">
                    <td height="30" style="font-family: 微軟正黑體;font-size: 13px;color: #666666;line-height: 20px;letter-spacing: 1px;" align="left">{{ $order_product->product->title }} - {{ $order_product->product_specifications->name }}</td>
                    <td height="30" style="font-family: 微軟正黑體;font-size: 13px;color: #666666;line-height: 20px;letter-spacing: 1px;" align="center">$ {{ number_format($order_product->price) }}</td>
                    <td height="30" style="font-family: 微軟正黑體;font-size: 13px;color: #666666;line-height: 20px;letter-spacing: 1px;" align="center">{{ $order_product->count }}</td>
                    <td height="30" style="font-family: 微軟正黑體;font-size: 13px;color: #666666;line-height: 20px;letter-spacing: 1px;" align="right">$ {{ number_format($order_product->price * $order_product->count) }}</td>
                    @php
                        $subtotal += $order_product->price * $order_product->count;
                    @endphp
                </tr>
                @endforeach
                <tr bgcolor="#ffffff">
                    <td height='30' style='font-family: 微軟正黑體;font-size: 13px;color: #666666;line-height: 20px;letter-spacing: 1px;' align='right' colspan='3'>小計：</td>
                    <td height='30' style='font-family: 微軟正黑體;font-size: 13px;color: #666666;line-height: 20px;letter-spacing: 1px;' align='right'>$ {{ number_format($subtotal) }}</td>
                </tr>
                @php
                    # 優惠代碼
                    $discount_codes = $order->discount_record->where('type', 'discount_codes')->first();
                @endphp
                @if($discount_codes)
                <tr bgcolor="#ffffff">
                    <td height='30' style='font-family: 微軟正黑體;font-size: 13px;color: #DA88B1;line-height: 20px;letter-spacing: 1px;' align='right' colspan='3'>優惠代碼【{{ $discount_codes->discount_codes->title }}】：<br /></td>
                    <td height='30' style='font-family: 微軟正黑體;font-size: 13px;color: #DA88B1;line-height: 20px;letter-spacing: 1px;' align='right'>-$ {{ $discount_codes->discount_codes->discount }}</td>
                </tr>
                @endif
                @php
                    # 優惠劵
                    $coupon = $order->discount_record->where('type', 'coupon')->first();
                @endphp
                @if($coupon)
                <tr bgcolor="#ffffff">
                    <td height='30' style='font-family: 微軟正黑體;font-size: 13px;color: #DA88B1;line-height: 20px;letter-spacing: 1px;' align='right' colspan='3'>優惠券【{{ $coupon->discount_codes->title }}】：<br /></td>
                    <td height='30' style='font-family: 微軟正黑體;font-size: 13px;color: #DA88B1;line-height: 20px;letter-spacing: 1px;' align='right'>-$ {{ $coupon->discount_codes->discount }}</td>
                </tr>
                @endif
                <tr bgcolor="#ffffff">
                    <td height='30' style='font-family: 微軟正黑體;font-size: 13px;color: #666666;line-height: 20px;letter-spacing: 1px;' align='right' colspan='3'>運送地點：台灣本島（不含郵政信箱）　運費：</td>
                    <td height='30' style='font-family: 微軟正黑體;font-size: 13px;color: #666666;line-height: 20px;letter-spacing: 1px;' align='right'>$ {{ $order->freight }}</td>
                </tr>
                @php
                    $all_total = $subtotal;

                    if($discount_codes) {
                        $all_total -= $discount_codes->discount_codes->discount;
                    }

                    if($coupon) {
                        $all_total -= $coupon->discount_codes->discount;
                    }

                    $all_total += $order->freight;

                @endphp
                <tr bgcolor="#ffffff">
                    <td height='30' style='font-family: 微軟正黑體;font-size: 13px;color: #666666;line-height: 20px;letter-spacing: 1px;' align='right' colspan='3'>總計：</td>
                    <td height='30' style='font-family: 微軟正黑體;font-size: 13px;color: #666666;line-height: 20px;letter-spacing: 1px;' align='right'>$ {{ number_format($all_total) }}</td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td height="15"></td>
    </tr>
    <tr>
        <td align='left' valign='top'>
            <table width='600' border='0' align='center' cellpadding='0' cellspacing='0'>
                <tr>
                    <td height='30' align='left' valign='middle'><strong style='font-family: 微軟正黑體;font-size: 14px;font-weight: bold;color: #996633;line-height: 24px;'>【付款資料】</strong></td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td align='center' valign='middle'>
            <table width='600' align='center' border='0' cellpadding='3' cellspacing='1' bgcolor='#FF9900'>
                <tr bgcolor='#ffffff'>
                    <td width='15%' height='30' align='right' bgcolor='#fef9f0' style='font-family: 微軟正黑體;font-size: 13px;color: #666666;line-height: 20px;letter-spacing: 1px;'>
                        付款方式︰
                    </td>
                    <td height='30' style='font-family: 微軟正黑體;font-size: 13px;color: #666666;line-height: 20px;letter-spacing: 1px;' align='left'>
                        @php
                            switch($order->payment_method) {
                                case 1:
                                    $payment = '線上刷卡';
                                    break;
                                case 2:
                                    $payment = 'ATM轉帳付款';
                                    break;
                                case 3:
                                    $payment = 'LinePay付款';
                                    break;
                                default:
                                    $payment = '';
                            }
                        @endphp
                        &nbsp;{{ $payment }}&nbsp;
                    </td>
                </tr>
                <tr bgcolor='#ffffff'>
                    <td width='15%' height='30' align='right' bgcolor='#fef9f0' style='font-family: 微軟正黑體;font-size: 13px;color: #666666;line-height: 20px;letter-spacing: 1px;'>
                        配送方式︰
                    </td>
                    <td height='30' style='font-family: 微軟正黑體;font-size: 13px;color: #666666;line-height: 20px;letter-spacing: 1px;' align='left'>
                        @php
                            switch($order->delivery_method) {
                                case 0:
                                    $delivery = '自取';
                                    break;
                                case 1:
                                    $delivery = '宅配';
                                    break;
                                default:
                                    $delivery = '';
                            }
                        @endphp
                        &nbsp;{{ $delivery  }}&nbsp;
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td height="15"></td>
    </tr>
    <tr>
        <td align='left' valign='top' style='border-top-width: 1px;border-right-width: 1px;border-bottom-width: 1px;border-left-width: 1px;border-top-style: solid;border-bottom-style: solid;border-top-color: #FF9900;border-right-color: #FF9900;border-bottom-color: #FF9900;border-left-color: #FF9900;'>
            <p align='center'><br />
                <span style='font-family: 微軟正黑體;font-size: 13px;color: #CC3300;line-height: 20px;letter-spacing: 1px;font-weight: bold;'>※ 此郵件是系統自動發送，請勿直接回覆此郵件！</span>
            </p>
            @php
                $basic_company = $config->where('config_name', 'basic_company')->first();
                $basic_email = $config->where('config_name', 'basic_email')->first();
                $basic_phone = $config->where('config_name', 'basic_phone')->first();
            @endphp
            @if($basic_company && $basic_email && $basic_phone)
                <p align='center'>
                    <ul style='font-family: 微軟正黑體;font-size: 13px;color: #333333;line-height: 20px;letter-spacing: 1px;font-weight: bold;padding: 0;text-align: center;list-style-type: none;'>
                        <li>{{ $basic_company->config_value }}</li>
                    </ul>
                    <div style="font-family: 微軟正黑體;font-size: 13px;color: #333333;line-height: 20px;letter-spacing: 1px;font-weight: bold;padding: 0;text-align: center;list-style-type: none; display: flex;">
                        <div style="flex-basis: 50%; width: 50%; white-space: nowrap;">客服電話：{{ $basic_phone->config_value }}</div>
                        <div style="flex-basis: 50%; width: 50%; white-space: nowrap;">客服信箱：{{ $basic_email->config_value }}</div>
                    </div>
                </p>
                <br>
            @endif
        </td>
    </tr>
    <tr>
        <td align='left' valign='top'>&nbsp;</td>
    </tr>
</table>
