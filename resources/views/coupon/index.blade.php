@extends('layouts.base')

@section('content')
    <link rel="stylesheet" href="plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
    <link rel="stylesheet" href="plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css">
    <link rel="stylesheet" href="css/coupon.css">
    <div id="app" v-cloak>
        <div class="content-header px-4">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">優惠券</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="/">首頁</a></li>
                            <li class="breadcrumb-item active">優惠券</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mx-0 px-3">
            <div class="mb-3 col-12 col-md-6">
                <components-search v-model:search_text="keywords" name="關鍵字" @get-count="getCount" @get-data="setKeywords"></components-search>
            </div>
            <div class="mb-3 col-12 col-md-6 d-flex justify-content-end">
                <!-- v-show -->
                <div class="mr-2" v-show="check.length > 0">
                    <button type="button" class="btn btn-sm btn-danger px-2" @click="confirm('delete')">
                        <i class="fa fa-minus mr-1"></i> 刪除
                    </button>
                </div>
                <div>
                    <button type="button" class="btn btn-sm btn-primary px-2" data-toggle="modal" data-target="#set-info" @click="create">
                        <i class="fa fa-plus mr-1"></i> 新增
                    </button>
                </div>
            </div>
        </div>

        <div class="content px-4">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header row mx-0">
                            <h3 class="card-title col-12 col-lg-6 px-0">優惠券列表</h3>
                            <div class="col-12 col-lg-6 px-0 d-flex align-items-center justify-content-end s-14" v-if="search_text">目前搜尋關鍵字為：<span class="text-primary">${ search_text }</span></div>
                        </div>
                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover text-nowrap">
                                <thead>
                                <!-- v-if -->
                                <tr v-if="list.length > 0">
                                    <th class="align-middle">
                                        <input type="checkbox" class="checkbox-size" v-model="checkAll">
                                    </th>
                                    <th>標題</th>
                                    <th class="width-15">優惠券代碼</th>
                                    <th class="text-center">優惠金額</th>
                                    <th class="text-center">開始時間</th>
                                    <th class="text-center">結束時間</th>
                                    <th class="text-center">優惠開放數量</th>
                                    <th class="text-center">功能</th>
                                </tr>
                                <tr v-else>
                                    <th class="text-center" colspan="8"><span class="text-danger">無優惠券資料</span></th>
                                </tr>
                                </thead>
                                <tbody>
                                <!-- v-for -->
                                <tr v-for="item in list">
                                    <td class="align-middle">
                                        <input type="checkbox" class="checkbox-size" :value="item.id" v-model="check">
                                    </td>
                                    <td class="align-middle text-wrap text-break">${item.title}</td>
                                    <td class="text-nowrap align-middle">${item.coupon}</td>
                                    <td class="text-nowrap align-middle text-center">${item.discount}</td>
                                    <td class="text-nowrap align-middle text-center">${dateFormat(item.start_date)}</td>
                                    <td class="text-nowrap align-middle text-center">${dateFormat(item.end_date)}</td>
                                    <td class="text-nowrap align-middle text-center">
                                        <template v-if="item.coupon_records_count > 0">
                                            <button class="btn btn-link text-bold" data-toggle="modal" data-target="#set-show-items" @click="shotItems(item.id)">${item.coupon_records_count}</button>
                                        </template>
                                        <template v-else>
                                            ${item.coupon_records_count}
                                        </template>
                                    </td>
                                    <td class="text-nowrap align-middle text-center">
                                        <button type="button" class="btn btn-sm btn-info px-2" data-toggle="modal" data-target="#set-info" @click="modify(item.id)">
                                            <i class="fa fa-edit mr-1"></i> 編輯
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
    </div>

    <div class="modal fade" id="set-info" data-backdrop="static">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">
                        <template v-if="mode == 'create'">新增</template><template v-else>編輯</template>優惠券
                    </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body px-5">
                    <div class="form-group">
                        <label for="name">優惠筆數</label><span class="text-danger" v-if="mode === 'create'">*</span>
                        <div class="d-flex align-items-center">
                        本次即將產生
                        <div class="col-4">
                            <input type="text" maxlength="2" class="form-control form-control-sm" id="records" placeholder="請輸入優惠筆數" v-model="info.records">
                        </div>
                        組，請輸入數字
                        </div>
                    </div>
                    <div class="mt-5 text-danger text-bold">以下欄位新增後不得更改</div>
                    <hr />
                    <div class="form-group">
                        <label for="name">標題</label><span class="text-danger" v-if="mode === 'create'">*</span>
                        <template v-if="mode === 'create'">
                            <input type="text" maxlength="50" class="form-control form-control-sm" id="title" placeholder="請輸入標題" v-model="info.title">
                        </template>
                        <template v-else>
                            <div> ${ info.title } </div>
                        </template>
                    </div>
                    <div class="form-group" v-if="mode === 'modify'">
                        <label for="coupon">優惠券代碼</label><span class="text-danger" v-if="mode === 'create'">*</span>
                        <div class="text-bold text-primary"> ${ coupon } </div>
                    </div>
                    <div class="form-group">
                        <label for="name">優惠內容</label><span class="text-danger" v-if="mode === 'create'">*</span>
                        <div class="d-flex align-items-center flex-wrap s-14">
                            結帳時滿
                            <template v-if="mode === 'create'">
                            <div class="col-6">
                                <input type="text" maxlength="11" class="form-control form-control-sm" id="full_amount" placeholder="請輸入結帳金額" v-model="info.full_amount">
                            </div>
                            </template>
                            <template v-else>
                                <div class="text-danger text-bold mx-3"> ${ info.full_amount } </div>
                            </template>
                            可使用，
                        </div>
                        <div class="d-flex align-items-center flex-wrap s-14 mt-2">
                            優惠金額為
                            <template v-if="mode === 'create'">
                            <div class="col-6">
                                <input type="text" maxlength="11" class="form-control form-control-sm" id="discount" placeholder="請輸入優惠金額" v-model="info.discount">
                            </div>
                            </template>
                            <template v-else>
                                <div class="text-danger text-bold mx-3"> ${ info.discount } </div>
                            </template>
                            元，請輸入數字
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="start_date">開始日期 <span class="text-danger" v-if="mode === 'create'">*</span></label>
                        <template v-if="mode === 'create'">
                        <div class="input-group date" id="start_date" data-target-input="nearest">
                            <input type="text" class="form-control form-control-sm datetimepicker-input s-14" placeholder="請選擇開始日期" data-target="#start_date" />
                            <div class="input-group-append" data-target="#start_date" data-toggle="datetimepicker">
                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                            </div>
                        </div>
                        </template>
                        <template v-else>
                            <div> ${ info.start_date.substr(0, 10) } </div>
                        </template>
                    </div>
                    <div class="form-group">
                        <label for="end_date">結束日期 <span class="text-danger" v-if="mode === 'create'">*</span></label>
                        <template v-if="mode === 'create'">
                        <div class="input-group date" id="end_date" data-target-input="nearest">
                            <input type="text" class="form-control form-control-sm datetimepicker-input s-14" placeholder="請選擇結束日期" data-target="#end_date" />
                            <div class="input-group-append" data-target="#end_date" data-toggle="datetimepicker">
                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                            </div>
                        </div>
                        </template>
                        <template v-else>
                            <div> ${ info.end_date.substr(0, 10) } </div>
                        </template>
                    </div>
                    <div class="mt-5 text-bold">可抵用產品</div>
                    <div class="text-danger s-14">如無選擇商品，則此劵可使用於所有訂單，不需選擇指定商品</div>
                    <hr />
                    <div class="form-group d-flex align-items-center">
                        <container :datas="product_specifications_list" :type="0"></container>
                        <div id="btns">
                            <input type="button" class="btn btn-sm btn-default" value=">" @click="change_type(0)" class="to"/>
                            <input type="button" class="btn btn-sm btn-default" value="<" @click="change_type(1)" class="to"/>
                        </div>
                        <container :datas="product_specifications_list" :type="1"></container>
                    </div>
                </div>
                <div class="modal-footer justify-content-end">
                    <button type="button" class="btn btn-sm btn-danger px-3 mr-1" data-dismiss="modal" aria-label="Close">取消</button>
                    <button type="button" class="btn btn-sm btn-primary px-3" @click="confirm('save')">儲存</button>
                </div>
            </div>
        </div>
    </div>

    <!-- 使用此優惠訂單項目 -->
    <div class="modal fade" id="set-show-items" data-backdrop="static">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">
                        優惠劵使用情形
                    </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body px-5">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>項目列表</div>
                    </div>
                    <div class="row justify-content-between align-items-center">
                        <div class="col-2">
                            <select class="form-control form-control-sm" v-model="value.used" @change="recordFilter">
                                <option value="">所有資料</option>
                                <option value="1">已使用</option>
                                <option value="0">未使用</option>
                            </select>
                        </div>
                        <div>
                            <!-- v-show -->
                            <button class="btn btn-sm btn-danger ml-1" @click="confirm('delete')" v-show="check.length > 0">
                                <i class="fa fa-minus mr-1"></i> 刪除
                            </button>
                        </div>
                    </div>
                    <div class="mt-2 table-responsive">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th class="width-5 align-middle">
                                    <input type="checkbox" class="checkbox-size" v-model="checkAll">
                                </th>
                                <th class="align-middle">優惠券</th>
                                <th class="width-10 align-middle text-center">優惠金額</th>
                                <th class="width-15 align-middle text-center">建立時間</th>
                                <th class="width-15 align-middle text-center">使用時間</th>
                                <th class="width-15 align-middle text-center">功能</th>
                            </tr>
                            <tr v-if="coupon_records.length <= 0">
                                <th class="text-center" colspan="6"><span class="text-danger">沒有篩選資料</span></th>
                            </tr>
                            </thead>
                            <tbody>
                            <!-- v-for -->
                            <tr v-for="item in coupon_records">
                                <td class="align-middle">
                                    <input type="checkbox" class="checkbox-size" :value="item.id" v-model="check" v-if="!item.used_at">
                                </td>
                                <td class="align-middle">${coupon_info.title}</td>
                                <td class="align-middle text-center">${coupon_info.discount}</td>
                                <td class="align-middle text-center">${dateFormat(item.created_at)}</td>
                                <td class="align-middle text-center">${item.used_at ? dateFormat(item.used_at) : ''}</td>
                                <td class="align-middle text-center">
                                    <button type="button" class="btn btn-sm btn-default px-2 ml-2" @click="orders(item.order.merchant_trade_no)" v-if="item.order">
                                        <i class="fa fa-list mr-1"></i> 訂單資料
                                    </button>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="plugins/moment/moment-with-locales.min.js"></script>
    <script src="plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
    <script src="plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js"></script>
    <script src="js/coupon.js"></script>
@endsection
