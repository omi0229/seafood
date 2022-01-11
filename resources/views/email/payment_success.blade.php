<div style="font-size: 20px; margin: 30px 0;">您的訂單已付款成功！</div>
<div style="font-size: 16px; margin-top: 30px; color: #fff; background-color: #007bff; padding: 5px; display: inline-block;">訂單編號</div>
<div style="font-size: 16px; margin-top: 10px; font-weight: bold;">{{ $order->merchant_trade_no }}</div>

<div style="font-size: 16px; margin-top: 30px; color: #fff; background-color: #007bff; padding: 5px; display: inline-block;">收件人資訊</div>
<div style="font-size: 16px; margin-top: 10px; font-weight: bold;">姓名：{{ $order->name }}</div>
<div style="font-size: 16px; font-weight: bold;">行動電話：{{ $order->cellphone }}</div>
<div style="font-size: 16px; font-weight: bold;">E-mail：{{ $order->email }}</div>
<div style="font-size: 16px; font-weight: bold;">收件地址：{{ $order->zipcode }} {{ $order->country }}{{ $order->city }}{{ $order->address }}</div>

@php
    $basic_company = $config->where('config_name', 'basic_company')->first();
    $basic_email = $config->where('config_name', 'basic_email')->first();
    $basic_phone = $config->where('config_name', 'basic_phone')->first();
@endphp
@if($basic_company && $basic_email && $basic_phone)
    <div style="margin-top: 30px;">
        <hr />
        <img src="{{ env('APP_URL') }}/images/logo/S__111558660.jpg" style="width: 300px;" />
        @if($basic_company)
        <div style="font-size: 14px;">Copyright © {{ $basic_company->config_value }}</div>
        @endif
        @if($basic_phone)
        <div style="font-size: 14px;">Email: {{ $basic_email->config_value }}</div>
        @endif
        @if($basic_email)
        <div style="font-size: 14px;">客服專線: {{ $basic_phone->config_value }}</div>
        @endif
    </div>
@endif
