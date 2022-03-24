@extends('layouts.base')

@section('content')
    <link rel="stylesheet" href="plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
    <link rel="stylesheet" href="plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="css/freight.css">
    <div id="app" v-cloak>
        <div class="content-header px-4">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">運費設定</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="/">首頁</a></li>
                            <li class="breadcrumb-item active">運費設定</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mx-0 px-3">
            <div class="mb-3 col-12 col-md-6">
                <components-search v-model:search_text="keywords" name="類型" @get-count="getCount" @get-data="setKeywords"></components-search>
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
                            <h3 class="card-title col-12 col-lg-6 px-0">運費類型</h3>
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
                                    <th>類型名稱</th>
                                    <th class="text-center">預設值</th>
                                    <th class="text-center">開始日期</th>
                                    <th class="text-center">結束日期</th>
                                    <th class="text-center">功能</th>
                                </tr>
                                <tr v-else>
                                    <th class="text-center" colspan="5"><span class="text-danger">無類型資料</span></th>
                                </tr>
                                </thead>
                                <tbody>
                                <!-- v-for -->
                                <tr v-for="item in list">
                                    <td class="align-middle">
                                        <input type="checkbox" class="checkbox-size" :value="item.id" v-model="check" v-if="dateAuth(item.start_date, item.end_date)">
                                    </td>
                                    <td>${item.title}</td>
                                    <td class="text-center">${item.default === 1 ? '是' : '否'}</td>
                                    <td class="text-center">${dateFormat(item.start_date)}</td>
                                    <td class="text-center">${dateFormat(item.end_date)}</td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-sm btn-info px-2" data-toggle="modal" data-target="#set-info" @click="modify(item.id)">
                                            <i class="fa fa-edit mr-1"></i> 編輯
                                        </button>
                                        <button type="button" class="btn btn-sm btn-secondary px-2 ml-1" data-toggle="modal" data-target="#set-floor2" @click="floor2(item.id)">
                                            <i class="fas fa-list-ul mr-1"></i> 下一層設定
                                        </button>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <components-pagination ref="pagination" :all_count="all_count" :page_count="page_count" @get-data="getFloor1Data"></components-pagination>
            </div>
        </div>
    </div>

    <div class="modal fade" id="set-info" data-backdrop="static">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">
                        <template v-if="mode == 'create'">新增</template><template v-else>編輯</template>運費類型
                    </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body px-5">
                    <div class="form-group">
                        <label>預設值 <span class="text-danger">*</span></label>
                        <div class="d-flex align-items-center s-14">
                            <div class="form-check mr-3">
                                <input id="default_enabled" class="form-check-input" type="radio" value="1" v-model="freight.default">
                                <label for="default_enabled" class="form-check-label">是（只能有一筆，不受開始時間及結束時間影響）</label>
                            </div>
                            <div class="form-check">
                                <input id="default_disabled" class="form-check-input" type="radio" value="0" v-model="freight.default">
                                <label for="default_disabled" class="form-check-label">否</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="name">標題 <span class="text-danger">*</span></label>
                        <input type="text" maxlength="20" class="form-control form-control-sm" id="name" placeholder="請輸入標題" v-model="freight.title">
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

    <!-- 運費第二層設定 -->
    <div class="modal fade" id="set-floor2" data-backdrop="static">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">
                        第二層設定
                    </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body px-5">
                    <div class="d-flex justify-content-between align-items-center floor2-sub-title">
                        <div>子項目列表</div>
                        <div>
                            <!-- v-show -->
                            <button class="btn btn-sm btn-danger ml-1" @click="cancel" v-show="modify_key !== null">
                                <i class="fas fa-ban mr-1"></i> 取消
                            </button>
                            <!-- v-show -->
                            <button class="btn btn-sm btn-danger ml-1" @click="confirm('delete')" v-show="check.length > 0 && modify_key === null">
                                <i class="fa fa-minus mr-1"></i> 刪除
                            </button>
                        </div>
                    </div>
                    <div class="mt-2 table-responsive">
                        <table class="table table-bordered floor2-table">
                            <thead>
                                <tr>
                                    <th class="width-5 align-middle">
                                        <input type="checkbox" class="checkbox-size" v-model="checkAll" @change="checkAllChange">
                                    </th>
                                    <th class="width-15"> 第一層分類 </th>
                                    <th class="width-15"> 是否顯示 </th>
                                    <th class="width-15"> 排序 </th>
                                    <th class="width-30"> 標題 </th>
                                    <th class="width-20 text-center"> 功能 </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="bg-light"></td>
                                    <td class="bg-light"> ${ freight1_title } </td>
                                    <td class="bg-light align-middle">
                                        <div class="d-flex s-14">
                                            <div class="form-check mr-3">
                                                <input id="status_enabled" class="form-check-input" type="radio" name="status" value="1" v-model="freight2.status">
                                                <label for="status_enabled" class="form-check-label">是</label>
                                            </div>
                                            <div class="form-check">
                                                <input id="status_disabled" class="form-check-input" type="radio" name="status" value="0" v-model="freight2.status">
                                                <label for="status_disabled" class="form-check-label">否</label>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="bg-light"> <input type="text" maxlength="20" class="form-control form-control-sm" placeholder="請輸入排序" v-model.number="freight2.sort"> </td>
                                    <td class="bg-light"> <input type="text" maxlength="20" class="form-control form-control-sm" placeholder="請輸入標題" v-model="freight2.title"> </td>
                                    <td class="bg-light text-center">
                                        <button class="btn btn-sm btn-primary" @click="confirm('create')">
                                            <i class="fa fa-plus mr-1"></i> 新增
                                        </button>
                                    </td>
                                </tr>
                                <!-- v-for -->
                                <template v-for="(item, key) in list">
                                    <tr>
                                        <template v-if="key !== modify_key">
                                            <td class="align-middle" :class="modify_floor3_parents_id === item.id ? 'floor3-content-top floor3-content-left' : ''">
                                                <input type="checkbox" class="checkbox-size" :value="item.id" v-model="check">
                                            </td>
                                            <td :class="modify_floor3_parents_id === item.id ? 'floor3-content-top' : ''"> ${freight1_title} </td>
                                            <td :class="modify_floor3_parents_id === item.id ? 'floor3-content-top' : ''"> ${item.status === 1 ? '是' : '否'} </td>
                                            <td :class="modify_floor3_parents_id === item.id ? 'floor3-content-top' : ''"> ${item.sort} </td>
                                            <td :class="modify_floor3_parents_id === item.id ? 'floor3-content-top' : ''"> ${item.title} </td>
                                        </template>
                                        <template v-else>
                                            <td></td>
                                            <td>
                                                <select class="form-control form-control-sm" v-model="modify_freight2.parents_id">
                                                    <option value="">請選擇上層分類</option>
                                                    <!-- -->
                                                    <option :value="item.id" v-for="item in select.floor1">${item.title}</option>
                                                </select>
                                            </td>
                                            <td class="align-middle">
                                                <div class="d-flex s-14">
                                                    <div class="form-check mr-3">
                                                        <input id="modify_status_enabled" class="form-check-input" type="radio" name="modify_status" value="1" v-model="modify_freight2.status">
                                                        <label for="modify_status_enabled" class="form-check-label">是</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input id="modify_status_disabled" class="form-check-input" type="radio" name="modify_status" value="0" v-model="modify_freight2.status">
                                                        <label for="modify_status_disabled" class="form-check-label">否</label>
                                                    </div>
                                                </div>
                                            </td>
                                            <td> <input type="text" maxlength="20" class="form-control form-control-sm" placeholder="請輸入排序" v-model.number="modify_freight2.sort"> </td>
                                            <td> <input type="text" maxlength="20" class="form-control form-control-sm" placeholder="請輸入標題" v-model="modify_freight2.title"> </td>
                                        </template>
                                        <td class="text-center" :class="modify_floor3_parents_id === item.id ? 'floor3-content-top floor3-content-right' : ''">
                                            <template v-if="key == modify_key">
                                                <button class="btn btn-sm btn-success" @click="save">
                                                    <i class="fas fa-save mr-1"></i> 儲存
                                                </button>
                                            </template>
                                            <template v-else>
                                                <button class="btn btn-sm btn-info mr-1" @click="modify(key)">
                                                    <i class="fa fa-edit mr-1"></i> 編輯
                                                </button>
                                                <button class="btn btn-sm btn-secondary" @click="setFloor3(item.id)">
                                                    <i class="fas fa-list-ul mr-1"></i> 運費設定
                                                </button>
                                            </template>
                                        </td>
                                    </tr>
                                    <tr v-if="modify_floor3_parents_id === item.id">
                                        <td colspan="6" class="floor3-content">

                                            <!-- 第三層 設定運費內容 -->
                                            <div class="p-4">
                                                <div class="d-flex justify-content-between align-items-center floor2-sub-title">
                                                    <div></div>
                                                    <div>
                                                        <!-- v-show -->
                                                        <button class="btn btn-sm btn-danger ml-1" @click="cancel(3)" v-show="floor3.modify_key !== null">
                                                            <i class="fas fa-ban mr-1"></i> 取消
                                                        </button>
                                                        <!-- v-show -->
                                                        <button class="btn btn-sm btn-danger ml-1" @click="confirm('delete', 3)" v-show="floor3.check.length > 0 && floor3.modify_key === null">
                                                            <i class="fa fa-minus mr-1"></i> 刪除
                                                        </button>
                                                    </div>
                                                </div>
                                                <table class="mt-2 table table-sm table-striped">
                                                    <thead class="thead-dark">
                                                    <tr>
                                                        <th class="text-center align-middle width-5">
                                                            <input type="checkbox" class="checkbox-size" v-model="floor3.checkAll" @change="checkAllChange(3)">
                                                        </th>
                                                        <th class="text-center width-40"> 上層分類</th>
                                                        <th class="text-center width-15"> 金額起始範圍</th>
                                                        <th class="text-center width-15"> 金額結束範圍</th>
                                                        <th class="text-center width-15"> 運費為</th>
                                                        <th class="text-center width-10"> 功能</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td class="bg-light"></td>
                                                            <td class="bg-light align-middle"> ${item.title} </td>
                                                            <td class="bg-light"> <input type="text" maxlength="11" class="form-control form-control-sm text-center" placeholder="請輸入起始範圍" v-model.number="freight3.start_total"> </td>
                                                            <td class="bg-light"> <input type="text" maxlength="11" class="form-control form-control-sm text-center" placeholder="請輸入結束範圍" v-model.number="freight3.end_total"> </td>
                                                            <td class="bg-light"> <input type="text" maxlength="11" class="form-control form-control-sm text-center" placeholder="請輸入運費金額" v-model.number="freight3.freight"> </td>
                                                            <td class="bg-light text-center">
                                                                <button class="btn btn-sm btn-primary" @click="confirm('create', 3)">
                                                                    <i class="fa fa-plus mr-1"></i> 新增
                                                                </button>
                                                            </td>
                                                        </tr>
                                                        <template v-for="(floor3_item, floor3_key) in floor3.list">
                                                            <tr>
                                                                <template v-if="floor3_key !== floor3.modify_key">
                                                                    <td class="text-center align-middle">
                                                                        <input type="checkbox" class="checkbox-size" :value="floor3_item.id" v-model="floor3.check">
                                                                    </td>
                                                                    <td> ${item.title} </td>
                                                                    <td class="text-center"> ${floor3_item.start_total} </td>
                                                                    <td class="text-center"> ${floor3_item.end_total} </td>
                                                                    <td class="text-center"> ${floor3_item.freight} </td>
                                                                </template>
                                                                <template v-else>
                                                                    <td></td>
                                                                    <td>
                                                                        <select class="form-control form-control-sm" v-model="modify_freight3.parents_id">
                                                                            <option value="">請選擇上層分類</option>
                                                                            <!-- -->
                                                                            <option :value="item.id" v-for="item in floor3.select.floor_type">${item.title}</option>
                                                                        </select>
                                                                    </td>
                                                                    <td> <input type="text" maxlength="11" class="form-control form-control-sm text-center" placeholder="請輸入起始範圍" v-model.numbe="modify_freight3.start_total"> </td>
                                                                    <td> <input type="text" maxlength="11" class="form-control form-control-sm text-center" placeholder="請輸入結束範圍" v-model.number="modify_freight3.end_total"> </td>
                                                                    <td> <input type="text" maxlength="11" class="form-control form-control-sm text-center" placeholder="請輸入運費金額" v-model.numbe="modify_freight3.freight"> </td>
                                                                </template>
                                                                <td class="text-center">
                                                                    <template v-if="floor3_key == floor3.modify_key">
                                                                        <button class="btn btn-sm btn-success" @click="save(3)">
                                                                            <i class="fas fa-save mr-1"></i> 儲存
                                                                        </button>
                                                                    </template>
                                                                    <template v-else>
                                                                        <button class="btn btn-sm btn-info mr-1" @click="modify(floor3_key, 3)">
                                                                            <i class="fa fa-edit mr-1"></i> 編輯
                                                                        </button>
                                                                    </template>
                                                                </td>
                                                            </tr>
                                                        </template>
                                                    </tbody>
                                                </table>
                                            </div>

                                        </td>
                                    </tr>
                                </template>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="plugins/select2/js/select2.full.min.js"></script>
    <script src="plugins/moment/moment-with-locales.min.js"></script>
    <script src="plugins/inputmask/jquery.inputmask.min.js"></script>
    <script src="plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
    <script src="js/freight.js"></script>
@endsection
