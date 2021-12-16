@extends('layouts.base')

@section('content')
    <link rel="stylesheet" href="plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
    <div id="app" v-cloak>
        <div class="content-header px-4">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">優惠代碼</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="/">首頁</a></li>
                            <li class="breadcrumb-item active">優惠代碼</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mx-0 px-3">
            <div class="mb-3 col-12 col-md-6">
                <components-search v-model:search_text="search_text" name="關鍵字" @get-count="getCount" @get-data="getData"></components-search>
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
                        <div class="card-header">
                            <h3 class="card-title">優惠代碼列表</h3>
                        </div>
                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover text-nowrap">
                                <thead>
                                <!-- v-if -->
                                <tr v-if="list.length > 0">
                                    <th class="align-middle">
                                        <input type="checkbox" class="checkbox-size" v-model="checkAll">
                                    </th>
                                    <th>分類名稱</th>
                                    <th class="text-center">建立日期</th>
                                    <th class="text-center">上次異動日期</th>
                                    <th class="text-center">功能</th>
                                </tr>
                                <tr v-else>
                                    <th class="text-center" colspan="5"><span class="text-danger">無分類資料</span></th>
                                </tr>
                                </thead>
                                <tbody>
                                <!-- v-for -->
                                <tr v-for="item in list">
                                    <td class="align-middle">
                                        <input type="checkbox" class="checkbox-size" :value="item.id" v-model="check">
                                    </td>
                                    <td>${item.name}</td>
                                    <td class="text-center">${dateFormat(item.created_at)}</td>
                                    <td class="text-center">${dateFormat(item.updated_at)}</td>
                                    <td class="text-center">
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
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">
                        <template v-if="mode == 'create'">新增</template><template v-else>編輯</template>優惠代碼
                    </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body px-5">
                    <div class="form-group">
                        <label for="name">優惠筆數</label><span class="text-danger">*</span>
                        <div class="d-flex align-items-center">
                        本次即將產生
                        <div class="col-4">
                            <input type="text" maxlength="11" class="form-control form-control-sm" id="records" placeholder="請輸入優惠筆數" v-model="info.records">
                        </div>
                        組，請輸入數字
                        </div>
                    </div>
                    <div class="mt-5 text-danger text-bold">以下欄位新增後不得更改</div>
                    <hr />
                    <div class="form-group">
                        <label for="name">標題</label><span class="text-danger">*</span>
                        <input type="text" maxlength="50" class="form-control form-control-sm" id="title" placeholder="請輸入標題" v-model="info.title">
                    </div>
                    <div class="form-group">
                        <label for="name">優惠內容</label><span class="text-danger">*</span>
                        <div class="d-flex align-items-center flex-wrap s-14">
                            結帳時滿
                            <div class="col-6">
                                <input type="text" maxlength="11" class="form-control form-control-sm" id="full_amount" placeholder="請輸入結帳金額" v-model="info.full_amount">
                            </div>
                            可使用，
                        </div>
                        <div class="d-flex align-items-center flex-wrap s-14 mt-2">
                            優惠金額為
                            <div class="col-6">
                                <input type="text" maxlength="11" class="form-control form-control-sm" id="discount" placeholder="請輸入優惠金額" v-model="info.discount">
                            </div>
                            元，請輸入數字
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="name">固定名稱</label><span class="text-danger">*</span>
                        <div class="d-flex align-items-center s-14">
                            <div class="form-check d-flex align-items-center">
                                <input id="is_fixed_enabled" class="form-check-input" type="radio" value="1" v-model="info.is_fixed">
                                <label for="is_fixed_enabled" class="form-check-label">是，欲產生的名稱為</label>
                                <div class="col-7">
                                    <input type="text" maxlength="10" class="form-control form-control-sm" id="title" placeholder="請輸入名稱" v-model="info.fixed_name">
                                </div>
                            </div>
                            <div class="form-check">
                                <input id="is_fixed_disabled" class="form-check-input" type="radio" value="0" v-model="info.is_fixed">
                                <label for="is_fixed_disabled" class="form-check-label">否</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="start_date">開始日期 <span class="text-danger">*</span></label>
                        <div class="input-group date" id="start_date" data-target-input="nearest">
                            <input type="text" class="form-control form-control-sm datetimepicker-input s-14" placeholder="請選擇開始日期" data-target="#start_date" />
                            <div class="input-group-append" data-target="#start_date" data-toggle="datetimepicker">
                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="end_date">結束日期 <span class="text-danger">*</span></label>
                        <div class="input-group date" id="end_date" data-target-input="nearest">
                            <input type="text" class="form-control form-control-sm datetimepicker-input s-14" placeholder="請選擇結束日期" data-target="#end_date" />
                            <div class="input-group-append" data-target="#end_date" data-toggle="datetimepicker">
                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
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
    <script src="plugins/moment/moment-with-locales.min.js"></script>
    <script src="plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
    <script src="js/discount-code.js"></script>
@endsection
