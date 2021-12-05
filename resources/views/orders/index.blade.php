@extends('layouts.base')

@section('content')
    <link rel="stylesheet" href="plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
    <link rel="stylesheet" href="plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="css/orders.css">
    <div id="app" v-cloak>
        <div class="content-header px-4">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">訂單管理</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="/">首頁</a></li>
                            <li class="breadcrumb-item active">訂單管理</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mx-0 px-3">
            <div class="mb-3 col-12 col-md-6">
                <components-search v-model:search_text="search_text" name="訂單編號或" @get-count="getCount" @get-data="getData"></components-search>
            </div>
            <div class="mb-3 col-12 col-md-6 d-flex justify-content-end">
                <div>
                    <button type="button" class="btn btn-sm btn-primary px-2 mr-2" @click="print">
                        <i class="fas fa-print mr-1"></i> 列印託運單
                    </button>
                    <button type="button" class="btn btn-sm btn-primary px-2 mr-2" @click="specification">
                        <i class="fas fa-truck mr-1"></i> 物流訂單產生
                    </button>
                    <button type="button" class="btn btn-sm btn-success px-2 mr-2" @click="exportData('products')">
                        <i class="fa fa-file-export mr-1"></i> 匯出揀貨單
                    </button>
                    <button type="button" class="btn btn-sm btn-success px-2 mr-2" @click="exportData('all')">
                        <i class="fa fa-file-export mr-1"></i> 匯出全部
                    </button>
                    <button type="button" class="btn btn-sm btn-success px-2" @click="exportData('orders')">
                        <i class="fa fa-file-export mr-1"></i> 匯出訂單
                    </button>
                </div>
{{--                <!-- v-show -->--}}
{{--                <div class="mr-2" v-show="check.length > 0">--}}
{{--                    <button type="button" class="btn btn-sm btn-danger px-2" @click="confirm('delete')">--}}
{{--                        <i class="fa fa-minus mr-1"></i> 刪除--}}
{{--                    </button>--}}
{{--                </div>--}}
{{--                <div>--}}
{{--                    <button type="button" class="btn btn-sm btn-primary px-2" data-toggle="modal" data-target="#set-info" @click="create">--}}
{{--                        <i class="fa fa-plus mr-1"></i> 新增--}}
{{--                    </button>--}}
{{--                </div>--}}
            </div>
        </div>

        <div class="content px-4">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">訂單列表</h3>
                        </div>
                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover text-nowrap">
                                <thead>
                                <!-- v-if -->
                                <tr v-if="list.length > 0">
                                    <th class="align-middle">
                                        <input type="checkbox" class="checkbox-size-for-print" v-model="checkAll">
                                    </th>
                                    <th>訂單編號</th>
                                    <th class="text-center">訂購人姓名</th>
                                    <th class="text-center">訂購時間</th>
                                    <th class="text-center">付款狀態</th>
                                    <th class="text-center">訂單狀態</th>
                                    <th class="text-center">訂單金額</th>
                                    <th class="text-center">物流取號狀態</th>
                                    <th class="text-center">功能</th>
                                </tr>
                                <tr v-else>
                                    <th class="text-center" colspan="5"><span class="text-danger">無訂單資料</span></th>
                                </tr>
                                </thead>
                                <tbody>
                                <!-- v-for -->
                                <tr v-for="item in list">
                                    <td class="align-middle">
                                        <input type="checkbox" class="checkbox-size" :value="item.id" v-model="check" v-if="item.payment_status === 1 && !item.AllPayLogisticsID">
                                        <input type="checkbox" class="checkbox-size-for-print" style="border: 1px solid #28a745" :value="item.AllPayLogisticsID" v-model="check_print" v-if="item.AllPayLogisticsID">
                                    </td>
                                    <td>${item.merchant_trade_no}</td>
                                    <td class="text-center">${item.member.name}</td>
                                    <td class="text-center">${dateFormat(item.created_at)}</td>
                                    <td class="text-center" :class="item.payment_status === 0 ? 'text-danger' : ''">${paymentStatusFormat(item.payment_status)}</td>
                                    <td class="text-center" :class="orderStatusColor(item.order_status)">${orderStatusFormat(item.order_status)}</td>
                                    <td class="text-center text-danger">${orderTotal(item.freight, item.order_products)}</td>
                                    <td class="text-center" :class="item.AllPayLogisticsID ? 'text-success text-bold' : ''">
                                        ${item.AllPayLogisticsID ? '已取號' : '未取號'}
                                    </td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-sm btn-info px-2" data-toggle="modal" data-target="#detail" @click="detail(item.id)">
                                            <i class="fa fa-edit mr-1"></i> 明細
                                        </button>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <components-pagination ref="pagination" :all_count="all_count" :page_count="page_count" @get-data="getData"></components-pagination>
            </div>
        </div>

        <div class="modal fade" id="specification" data-backdrop="static">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">
                            請選擇寄送規格
                        </h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <h6>規格選擇</h6>
                        <template v-for="(item, key) in radio.specification">
                            <label :for="'send-specification' + key" class="mr-3">
                                <input type="radio" :id="'send-specification' + key" :value="item.value" v-model="value.specification" />
                                ${ item.name }
                            </label>
                        </template>
                        <hr />
                        <h6>此訂單商品明細</h6>
                        <div class="order_products_list">
                            <div class="table-responsive">
                                <table class="table table-sm table-bordered">
                                    <thead>
                                    <tr>
                                        <th class="text-center width-20">圖片</th>
                                        <th class="width-20">商品</th>
                                        <th class="width-30">規格</th>
                                        <th class="text-center width-10">數量</th>
                                        <th class="text-center width-10">價格</th>
                                        <th class="text-center width-10">小計</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <!-- v-for -->
                                    <tr v-for="item in order_products">
                                        <td class="text-center"><img :src="item.img"/></td>
                                        <td class="align-middle">${ item.product.title }</td>
                                        <td class="align-middle">${ item.product_specifications.name }</td>
                                        <td class="text-center align-middle">${ item.count }</td>
                                        <td class="text-center align-middle">${ item.price.toLocaleString() }</td>
                                        <td class="text-center align-middle">${ (item.count *
                                            item.price).toLocaleString() }
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-end">
                        <button type="button" class="btn btn-sm btn-danger px-3 mr-1" data-dismiss="modal" aria-label="Close">取消</button>
                        <button type="button" class="btn btn-sm btn-primary px-3" @click="confirm">儲存</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="d-none">
            <form id="form" type="post" :action="url.print" method="post" target="_blank">
                <input type="hidden" :name="item.key" :value="item.value" v-for="item in ECPay" />
            </form>
        </div>

    </div>

    <div class="modal fade" id="detail" data-backdrop="static">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">
                        訂單明細
                    </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="card card-primary card-outline card-outline-tabs">
                        <div class="card-header p-0 border-bottom-0">
                            <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="custom-tabs-order-detail-tab" data-toggle="pill" href="#custom-tabs-order-detail" role="tab" aria-controls="custom-tabs-order-detail" aria-selected="true">訂單明細</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="custom-tabs-member-tab" data-toggle="pill" href="#custom-tabs-member" role="tab" aria-controls="custom-tabs-member" aria-selected="false">訂購人資料</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="custom-tabs-receiver-tab" data-toggle="pill" href="#custom-tabs-receiver" role="tab" aria-controls="custom-tabs-receiver" aria-selected="false">收件人資料</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="custom-tabs-products-tab" data-toggle="pill" href="#custom-tabs-products" role="tab" aria-controls="custom-tabs-products" aria-selected="false">商品明細</a>
                                </li>
                            </ul>
                        </div>
                        <div class="card-body">
                            <div class="tab-content" id="custom-tabs-four-tabContent">
                                <div class="tab-pane fade show active" id="custom-tabs-order-detail" role="tabpanel" aria-labelledby="custom-tabs-order-detail-tab">
                                    <h5 class="text-bold">訂單明細</h5>
                                    <hr />
                                    <div class="row">
                                        <div class="col-3">
                                            訂單編號
                                        </div>
                                        <div class="col-9 text-bold">
                                            ${info.merchant_trade_no}
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-3">
                                            訂單狀態
                                        </div>
                                        <div class="col-9 text-bold">
                                            <label for="order_status-0" class="mr-3">
                                                <input type="radio" id="order_status-0" name="order_status" value="0" v-model="info.order_status" /> 新單
                                            </label>
                                            <label for="order_status-1" class="mr-3">
                                                <input type="radio" id="order_status-1" name="order_status" value="1" v-model="info.order_status" /> 收款
                                            </label>
                                            <label for="order_status-2" class="mr-3">
                                                <input type="radio" id="order_status-2" name="order_status" value="2" v-model="info.order_status" /> 出貨
                                            </label>
                                            <label for="order_status--1" class="mr-3">
                                                <input type="radio" id="order_status--1" name="order_status" value="-1" v-model="info.order_status" /> 取消
                                            </label>
                                            <label for="order_status--2" class="mr-3">
                                                <input type="radio" id="order_status--2" name="order_status" value="-2" v-model="info.order_status" /> 退貨
                                            </label>
                                            <label for="order_status-3" class="mr-3">
                                                <input type="radio" id="order_status-3" name="order_status" value="3" v-model="info.order_status" /> 完成
                                            </label>
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-3">
                                            出貨日期
                                        </div>
                                        <div class="col-4 text-bold">
                                            <div class="input-group date" id="shipment_date" data-target-input="nearest">
                                                <input type="text" class="form-control form-control-sm datetimepicker-input s-14" placeholder="請選擇開始日期" data-target="#shipment_date" />
                                                <div class="input-group-append" data-target="#shipment_date" data-toggle="datetimepicker">
                                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-3">
                                            管理員備註
                                        </div>
                                        <div class="col-9 text-bold">
                                            <textarea class="form-control" rows="4" placeholder="請輸入備註" v-model="info.admin_bookmark"></textarea>
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-3">
                                            訂購時間
                                        </div>
                                        <div class="col-9 text-bold">
                                            ${dateFormat(info.created_at)}
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-3">
                                            付款方式
                                        </div>
                                        <div class="col-9 text-bold">
                                            ${paymentMethodFormat(info.payment_method)}
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-3">
                                            發票資訊
                                        </div>
                                        <div class="col-9 text-bold">
                                            <template v-if="info.invoice_method === 1">個人收銀發票</template>
                                            <template v-else-if="info.invoice_method === 2">公司戶收銀發票</template>
                                        </div>
                                    </div>
                                    <!-- v-if -->
                                    <div class="row mt-3" v-if="info.invoice_method === 2">
                                        <div class="col-3">
                                            統一編號
                                        </div>
                                        <div class="col-9 text-bold">
                                            ${info.invoice_tax_id_number}
                                        </div>
                                    </div>
                                    <!-- v-if -->
                                    <div class="row mt-3" v-if="info.invoice_method === 2">
                                        <div class="col-3">
                                            發票抬頭
                                        </div>
                                        <div class="col-9 text-bold">
                                            ${info.invoice_name}
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-3">
                                            物流取號狀態
                                        </div>
                                        <div class="col-9 text-bold" :class="info.AllPayLogisticsID ? 'text-success' : ''">
                                            ${info.AllPayLogisticsID ? '已取號' : '未取號'}
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-3">
                                            備註
                                        </div>
                                        <div class="col-9 text-bold">
                                            ${info.bookmark}
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="custom-tabs-member" role="tabpanel" aria-labelledby="custom-tabs-member-tab">
                                    <h5 class="text-bold">訂購人資料</h5>
                                    <hr />
                                    <div class="row mt-3">
                                        <div class="col-3">
                                            訂購人姓名
                                        </div>
                                        <div class="col-9 text-bold">
                                            ${info.member.name}
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-3">
                                            訂購人手機號碼
                                        </div>
                                        <div class="col-9 text-bold">
                                            ${info.member.cellphone}
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-3">
                                            訂購人聯絡電話
                                        </div>
                                        <div class="col-9 text-bold">
                                            ${info.member.telephone}
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-3">
                                            訂購人電子信箱
                                        </div>
                                        <div class="col-9 text-bold">
                                            ${info.member.email}
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="custom-tabs-receiver" role="tabpanel"aria-labelledby="custom-tabs-receiver-tab">
                                    <h5 class="text-bold">收件人資料</h5>
                                    <hr />
                                    <div class="row align-items-center mt-2">
                                        <div class="col-3">
                                            收件人姓名
                                        </div>
                                        <div class="col-9 text-bold">
                                            <input type="text" maxlength="20" class="form-control form-control-sm" v-model="info.receiver.name">
                                        </div>
                                    </div>
                                    <div class="row align-items-center mt-2">
                                        <div class="col-3">
                                            收件人手機號碼
                                        </div>
                                        <div class="col-9 text-bold">
                                            <input type="text" maxlength="10" class="form-control form-control-sm" v-model="info.receiver.cellphone">
                                        </div>
                                    </div>
                                    <div class="row align-items-center mt-2">
                                        <div class="col-3">
                                            收件人電子信箱
                                        </div>
                                        <div class="col-9 text-bold">
                                            <input type="text" maxlength="200" class="form-control form-control-sm" v-model="info.receiver.email">
                                        </div>
                                    </div>
                                    <div class="row align-items-center mt-2">
                                        <div class="col-3">
                                            收件人地址
                                        </div>
                                        <div class="col-3">
                                            <select class="form-control form-control-sm" v-model="info.receiver.country" @change="selectCountry('receiver')">
                                                <option value="">請選擇城市</option>
                                                <!-- v-for -->
                                                <option :value="item.id" v-for="item in select.main_island_counties">${ item.name }</option>
                                            </select>
                                        </div>
                                        <div class="col-3">
                                            <select class="form-control form-control-sm" v-model="info.receiver.city" @change="selectCity('receiver')">
                                                <option value="">請選擇地區</option>
                                                <!-- v-for -->
                                                <option :value="item.city" v-for="item in select.main_island_cities">${ item.city }</option>
                                            </select>
                                        </div>
                                        <div class="col-3">
                                            <input class="form-control form-control-sm" type="text" placeholder="郵遞區號" v-model="info.receiver.zipcode" disabled>
                                        </div>
                                    </div>
                                    <div class="row align-items-center mt-2">
                                        <div class="col-3"></div>
                                        <div class="col-9">
                                            <input type="text" maxlength="200" class="form-control form-control-sm" v-model="info.receiver.address">
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="custom-tabs-products" role="tabpanel"aria-labelledby="custom-tabs-products-tab">
                                    <h5 class="text-bold">商品明細</h5>
                                    <hr />
                                    <div class="table-responsive">
                                        <table class="table table-sm table-bordered">
                                            <thead>
                                            <tr>
                                                <th class="text-center width-20">圖片</th>
                                                <th class="width-20">商品</th>
                                                <th class="width-30">規格</th>
                                                <th class="text-center width-10">數量</th>
                                                <th class="text-center width-10">價格</th>
                                                <th class="text-center width-10">小計</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <!-- v-for -->
                                            <tr v-for="item in info.order_products">
                                                <td class="text-center"><img :src="item.img" /></td>
                                                <td class="align-middle">${ item.product.title }</td>
                                                <td class="align-middle">${ item.product_specifications.name }</td>
                                                <td class="text-center align-middle">${ item.count }</td>
                                                <td class="text-center align-middle">${ item.price.toLocaleString() }</td>
                                                <td class="text-center align-middle">${ (item.count * item.price).toLocaleString() }</td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="row align-middle justify-content-end">
                                        <div class="col-9 text-right">小計：</div>
                                        <div class="col-3 text-right text-danger">
                                            $ ${ orderTotal(0, info.order_products).toLocaleString() }</div>
                                    </div>
                                    <div class="row align-middle justify-content-end">
                                        <div class="col-9 text-right">運費<span v-if="info.freight_name">(${ info.freight_name })</span>：
                                        </div>
                                        <div class="col-3 text-right text-danger">
                                            $ ${ info.freight.toLocaleString() }</div>
                                    </div>
                                    <div class="row align-middle justify-content-end">
                                        <div class="col-9 text-right">本訂單需付款總金額：</div>
                                        <div class="col-3 text-right text-danger">
                                            $ ${ orderTotal(info.freight, info.order_products).toLocaleString() }</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-end">
                    <button type="button" class="btn btn-sm btn-danger px-3 mr-1" data-dismiss="modal" aria-label="Close">取消</button>
                    <button type="button" class="btn btn-sm btn-primary px-3" @click="confirm('save')">儲存</button>
                </div>
            </div>
        </div>
    </div>
    <script src="plugins/select2/js/select2.full.min.js"></script>
    <script src="plugins/moment/moment-with-locales.min.js"></script>
    <script src="plugins/inputmask/jquery.inputmask.min.js"></script>
    <script src="plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
    <script src="plugins/ckeditor/ckeditor.js"></script>
    <script src="js/orders.js"></script>
@endsection
