@extends('layouts.base')

@section('content')
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
            <div class="mb-3 col-12 col-md-3">
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
            <div class="mb-3 col-12 col-md-9 d-flex justify-content-end">
                <!-- v-show -->
                <div class="mr-2" v-show="check.length > 0">
                    <button type="button" class="btn btn-sm btn-danger px-2" @click="confirm('delete')">
                        <i class="fa fa-minus mr-1"></i> 刪除
                    </button>
                </div>
                <div>
                    <button type="button" class="btn btn-sm btn-primary px-2" data-toggle="modal" data-target="#set-info" @click="create">
                        <i class="fa fa-plus mr-1"></i> 新增產品
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
                                    <th>分類</th>
                                    <th class="text-center">銷售狀態</th>
                                    <th class="text-center">上架管理顯示</th>
                                    <th class="text-center">功能</th>
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
                                        <td> ${item.title} </td>
                                        <td> ${item.product_types_name} </td>
                                        <td class="text-center">
                                            <!-- v-if -->
                                            <span class="right badge badge-success" v-if="item.sales_status == '1'">開放</span>
                                            <span class="right badge badge-danger" v-else="">暫停</span>
                                        </td>
                                        <td class="text-center">
                                            <!-- v-if -->
                                            <span class="right badge badge-success" v-if="item.show_status == '1'">顯示</span>
                                            <span class="right badge badge-danger" v-else="">不顯示</span>
                                        </td>
                                        <td class="text-center">
                                            <button type="button" class="btn btn-sm btn-info px-2 mr-1" data-toggle="modal" data-target="#set-info" @click="modify(item.id)">
                                                <i class="fa fa-edit mr-1"></i> 編輯
                                            </button>
                                            <button type="button" class="btn btn-sm btn-secondary px-2 ml-1" data-toggle="modal" data-target="#set-specification" @click="specification(item.id)">
                                                <i class="fas fa-list-ul mr-1"></i> 規格
                                            </button>
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
                    <div class="row mx-0">
                        <div class="mb-3 px-0 col-12 col-md-3">
                            <select class="form-control form-control-sm w-100 product-types-select2" v-model="value.product_types_id">
                                <option value="">請選擇產品分類</option>
                                <!-- v-for -->
                                <option v-for="item in select.product_types_id" :value="item.id">${item.name}</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
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
                <div class="modal-footer">

                </div>
                <div class="modal-footer justify-content-end">
                    <button type="button" class="btn btn-sm btn-danger px-3 mr-1" data-dismiss="modal" aria-label="Close">取消</button>
                    <button type="button" class="btn btn-sm btn-primary px-3">儲存</button>
                </div>
            </div>
        </div>
    </div>

    <!-- 規格 -->
    <div class="modal fade" id="set-specification" data-backdrop="static">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">
                        規格設定
                    </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body px-5">
                    <div class="d-flex justify-content-between align-items-center specification-sub-title">
                        <div>規格列表</div>
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
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th class="align-middle">
                                        <input type="checkbox" class="checkbox-size" v-model="checkAll">
                                    </th>
                                    <th> 規格名稱 </th>
                                    <th> 原價 </th>
                                    <th> 售價 </th>
                                    <th> 庫存 </th>
                                    <th class="text-center"> 功能 </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td></td>
                                    <td class="bg-light"> <input name="name" type="text" maxlength="50" class="form-control form-control-sm" placeholder="請輸入名稱" v-model="info.name"> </td>
                                    <td class="bg-light"> <input name="original_price" type="text" maxlength="20" class="form-control form-control-sm" placeholder="請輸入原價" v-model="info.original_price"> </td>
                                    <td class="bg-light"> <input name="selling_price" type="text" maxlength="20" class="form-control form-control-sm" placeholder="請輸入售價" v-model="info.selling_price"> </td>
                                    <td class="bg-light"> <input name="inventory" type="text" maxlength="20" class="form-control form-control-sm" placeholder="請輸入庫存" v-model="info.inventory"> </td>
                                    <td class="bg-light text-center">
                                        <button class="btn btn-sm btn-primary" @click="confirm('create')">
                                            <i class="fa fa-plus mr-1"></i> 新增
                                        </button>
                                    </td>
                                </tr>
                                <!-- v-for -->
                                <tr v-for="(item, key) in list">
                                    <template v-if="key !== modify_key">
                                        <td class="align-middle">
                                            <input type="checkbox" class="checkbox-size" :value="item.id" v-model="check">
                                        </td>
                                        <td> ${item.name} <span class="text-danger text-bold" v-if="new_specification && key == 0">new</span> </td>
                                        <td> ${item.original_price} </td>
                                        <td> ${item.selling_price} </td>
                                        <td> ${item.inventory} </td>
                                    </template>
                                    <template v-else>
                                        <td></td>
                                        <td> <input name="name" type="text" maxlength="50" class="form-control form-control-sm" placeholder="請輸入名稱" v-model="modify_info.name"> </td>
                                        <td> <input name="original_price" type="text" maxlength="20" class="form-control form-control-sm" placeholder="請輸入原價" v-model="modify_info.original_price"> </td>
                                        <td> <input name="selling_price" type="text" maxlength="20" class="form-control form-control-sm" placeholder="請輸入售價" v-model="modify_info.selling_price"> </td>
                                        <td> <input name="inventory" type="text" maxlength="20" class="form-control form-control-sm" placeholder="請輸入庫存" v-model="modify_info.inventory"> </td>
                                    </template>
                                    <td class="text-center">
                                        <!-- v-if -->
                                        <button class="btn btn-sm btn-success" @click="save" v-if="key == modify_key">
                                            <i class="fas fa-save mr-1"></i> 儲存
                                        </button>
                                        <button class="btn btn-sm btn-info" @click="modify(key)" v-else>
                                            <i class="fa fa-edit mr-1"></i> 編輯
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
    <script src="plugins/select2/js/select2.full.min.js"></script>
    <script src="js/put-on.js"></script>
@endsection
