@extends('layouts.base')

@section('content')
    <link rel="stylesheet" href="plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
    <link rel="stylesheet" href="plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="css/put-on.css">
    <div id="app" v-cloak>
        <div class="content-header px-4">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">上架管理</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="/">首頁</a></li>
                            <li class="breadcrumb-item active">上架管理</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mx-0 px-3">
            <div class="col-12 col-md-3">
                <!--
                <components-search v-model:search_text="search_text" name="上架" @get-count="getCount" @get-data="getData"></components-search>
                -->
                <div class="form-group">
                    <select class="form-control form-control-sm directory-select2" v-model="value.directory" @change="getData">
                        <option value="">請選擇目錄</option>
                        <!-- v-for -->
                        <option :value="item.id" v-for="item in select.directories">${item.name}</option>
                    </select>
                </div>
            </div>
            <div class="col-12 col-md-9 d-flex justify-content-end">
                <!-- v-show -->
                <div class="mr-2" v-show="check.length > 0">
                    <button type="button" class="btn btn-sm btn-info px-2" data-toggle="modal" data-target="#set-put" @click="put">
                        <i class="fas fa-arrows-alt-v mr-1"></i> 上下架設定
                    </button>
                </div>
                <!-- v-show -->
                <div v-show="value.directory">
                    <button type="button" class="btn btn-sm btn-primary px-2" data-toggle="modal" data-target="#set-info" @click="modify">
                        <i class="fa fa-plus mr-1"></i> 修改上架產品
                    </button>
                </div>
            </div>
        </div>

        <div class="content px-4">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">上架列表</h3>
                        </div>
                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover text-nowrap">
                                <thead>
                                <!-- v-if -->
                                <tr v-if="!value.directory">
                                    <th class="text-center" colspan="6">
                                        <div class="text-danger">請選擇一個目錄</div>
                                        <div class="text-danger">上架產品</div>
                                    </th>
                                </tr>
                                <tr v-else-if="list.length > 0">
                                    <th class="align-middle">
                                        <input type="checkbox" class="checkbox-size" v-model="checkAll">
                                    </th>
                                    <th>產品名稱</th>
                                    <th class="text-center">開始時間</th>
                                    <th class="text-center">結束時間</th>
                                    <th class="text-center">上架狀態</th>
                                </tr>
                                <tr v-else>
                                    <th class="text-center" colspan="6"><span class="text-danger">無上架資料</span></th>
                                </tr>
                                </thead>
                                <tbody>
                                <template v-if="value.directory">
                                    <!-- v-for -->
                                    <tr v-for="item in list">
                                        <td class="align-middle">
                                            <input type="checkbox" class="checkbox-size" :value="item.id" v-model="check">
                                        </td>
                                        <td> ${item.product.title} </td>
                                        <td class="text-center"> ${item.start_date ? item.start_date : '未設定'} </td>
                                        <td class="text-center"> ${item.end_date ? item.end_date : '未設定'} </td>
                                        <td class="text-center">
                                            <!-- v-if -->
                                            <span class="right badge badge-success" v-if="item.status == '1'">已上架</span>
                                            <span class="right badge badge-info" v-else-if="item.status == '2'">已排程</span>
                                            <span class="right badge badge-danger" v-else>未上架</span>
                                        </td>
                                    </tr>
                                </template>
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
                        新增上架產品
                    </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body px-4">
                    <div class="s-14">
                        <div class="s-1-1-rem">已選擇產品</div>
                        <div class="border rounded p-2 d-flex align-content-start flex-wrap mt-2 check-list">
                            <!-- v-for -->
                            <div class="py-1 px-2 mb-1 mr-2 rounded check-list-border" v-for="(item, key) in check_list">
                                ${item.title}
                            </div>
                        </div>
                    </div>
                    <div class="row mx-0 mt-3">
                        <div class="px-0 col-12 col-md-3">
                            <select class="form-control form-control-sm w-100 product-types-select2" v-model="value.product_types_id">
                                <option value="">請選擇產品分類</option>
                                <!-- v-for -->
                                <option v-for="item in select.product_types_id" :value="item.id">${item.name}</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">產品列表</h3>
                                </div>
                                <div class="card-body table-responsive p-0">
                                    <table class="table table-hover text-nowrap">
                                        <thead>
                                        <!-- v-if -->
                                        <tr v-if="!value.product_types_id">
                                            <th class="text-center" colspan="6">
                                                <div class="text-danger">請選擇一個產品分類</div>
                                            </th>
                                        </tr>
                                        <tr v-else-if="list.length > 0">
                                            <th class="align-middle">
                                                <input type="checkbox" class="checkbox-size" v-model="checkAll">
                                            </th>
                                            <th>標題</th>
                                            <th>分類</th>
                                            <th class="text-center">銷售狀態</th>
                                        </tr>
                                        <tr v-else>
                                            <th class="text-center" colspan="6"><span class="text-danger">無產品資料</span></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <template v-if="value.product_types_id">
                                            <!-- v-for -->
                                            <tr v-for="item in list">
                                                <td class="align-middle">
                                                    <input type="checkbox" class="checkbox-size" :value="item.id" v-model="check">
                                                </td>
                                                <td> ${item.title} </td>
                                                <td> ${item.product_types_name} </td>
                                                <td class="text-center">
                                                    <!-- v-if -->
                                                    <span class="right badge badge-success" v-if="item.sales_status == '1'">開放</span>
                                                    <span class="right badge badge-danger" v-else="">暫停</span>
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
                <div class="modal-footer justify-content-end">
                    <button type="button" class="btn btn-sm btn-danger px-3 mr-1" data-dismiss="modal" aria-label="Close">取消</button>
                    <button type="button" class="btn btn-sm btn-primary px-3" @click="confirm">儲存</button>
                </div>
            </div>
        </div>
    </div>

    <!-- 產品 上/下架 設定 -->
    <div class="modal fade" id="set-put" data-backdrop="static">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">
                        產品上/下架設定
                    </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body px-5 mb-4">
                    <div class="s-14">
                        <div class="s-1-1-rem">已選擇產品</div>
                        <div class="border rounded p-2 d-flex align-content-start flex-wrap mt-2 check-list">
                            <!-- v-for -->
                            <div class="py-1 px-2 mb-1 mr-2 rounded check-list-border" v-for="(item, key) in list">
                                ${item.product.title}
                            </div>
                        </div>
                    </div>
                    <div class="s-14 mt-4">
                        <div class="s-1-1-rem mb-2">上/下架設定</div>
                        <div class="d-flex align-items-center radio mb-2">
                            <input type="radio" id="status1" name="status" class="mr-2" value="1" v-model="value.status">
                            <label class="s-14 mb-0" for="status1">上架</label>
                        </div>
                        <div class="d-flex align-items-center radio mb-2">
                            <input type="radio" id="status0" name="status" class="mr-2" value="0" v-model="value.status">
                            <label class="s-14 mb-0" for="status0">下架</label>
                        </div>
                        <div class="d-flex align-items-center radio flex-wrap h-auto">
                            <div class="mb-2 mr-3">
                                <input type="radio" id="status2" name="status" class="mr-2" value="2" v-model="value.status">
                                <label class="s-14 mb-0" for="status2">排程</label>
                            </div>
                            <div class="input-group date mb-2 mr-3" id="start_date" data-target-input="nearest">
                                <input type="text" class="form-control form-control-sm datetimepicker-input s-14" placeholder="上架時間" data-target="#start_date" />
                                <div class="input-group-append" data-target="#start_date" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>
                            <div class="input-group date mb-2" id="end_date" data-target-input="nearest">
                                <input type="text" class="form-control form-control-sm datetimepicker-input s-14" placeholder="下架時間" data-target="#end_date" />
                                <div class="input-group-append" data-target="#end_date" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>
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
    <script src="plugins/select2/js/select2.full.min.js"></script>
    <script src="plugins/moment/moment-with-locales.min.js"></script>
    <script src="plugins/inputmask/jquery.inputmask.min.js"></script>
    <script src="plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
    <script src="js/put-on.js"></script>
@endsection
