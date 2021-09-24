@extends('layouts.base')

@section('content')
    <link rel="stylesheet" href="css/product.css">
    <div id="app" v-cloak>
        <div class="content-header px-4">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">產品管理</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="/">首頁</a></li>
                            <li class="breadcrumb-item active">產品管理</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mx-0 px-3">
            <div class="mb-3 col-12 col-md-6">
                <components-search v-model:search_text="search_text" name="產品" @get-count="getCount" @get-data="getData"></components-search>
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
                            <h3 class="card-title">產品列表</h3>
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
                                    <th class="text-center">開始日期</th>
                                    <th class="text-center">結束日期</th>
                                    <th class="text-center">開啟方式</th>
                                    <th class="text-center">跑馬燈顯示</th>
                                    <th class="text-center">功能</th>
                                </tr>
                                <tr v-else>
                                    <th class="text-center" colspan="5"><span class="text-danger">無產品資料</span></th>
                                </tr>
                                </thead>
                                <tbody>
                                <!-- v-for -->
                                <tr v-for="item in list">
                                    <td class="align-middle">
                                        <input type="checkbox" class="checkbox-size" :value="item.id" v-model="check">
                                    </td>
                                    <td>${item.title}</td>
                                    <td class="text-center">${dateFormat(item.start_date)}</td>
                                    <td class="text-center">${dateFormat(item.end_date)}</td>
                                    <td class="text-center"></td>
                                    <td class="text-center"></td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-sm btn-info px-2 mr-1" data-toggle="modal" data-target="#set-info" @click="modify(item.id)">
                                            <i class="fa fa-edit mr-1"></i> 編輯
                                        </button>
                                        <button type="button" class="btn btn-sm btn-secondary px-2 ml-1" data-toggle="modal" data-target="#set-specification" @click="specification(item.id)">
                                            <i class="fas fa-list-ul mr-1"></i> 規格
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
                        <template v-if="mode == 'create'">新增</template><template v-else>編輯</template>產品
                    </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body px-5">
                    <div class="form-group">
                        <label for="sales_status">銷售狀態</label>
                        <div class="d-flex align-items-center s-14">
                            <div class="form-check mr-3">
                                <input id="sales_status_not" class="form-check-input" type="radio" value="0" v-model="info.sales_status">
                                <label for="sales_status_not" class="form-check-label">暫停</label>
                            </div>
                            <div class="form-check">
                                <input id="sales_status" class="form-check-input" type="radio" value="1" v-model="info.sales_status">
                                <label for="sales_status" class="form-check-label">開放</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="show_status">上架顯示</label>
                        <div class="d-flex align-items-center s-14">
                            <div class="form-check mr-3">
                                <input id="show_status_not" class="form-check-input" type="radio" value="0" v-model="info.show_status">
                                <label for="show_status_not" class="form-check-label">不顯示</label>
                            </div>
                            <div class="form-check">
                                <input id="show_status" class="form-check-input" type="radio" value="1" v-model="info.show_status">
                                <label for="show_status" class="form-check-label">顯示</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="type">分類 <span class="text-danger">*</span></label>
                        <select id="type" class="form-control form-control-sm s-14" v-model="info.product_types_id">
                            <option value="">請選擇分類</option>
                            <!-- v-for -->
                            <option v-for="item in select.product_types" :value="item.id">${item.name}</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="title">標題 <span class="text-danger">*</span></label>
                        <input type="text" maxlength="50" class="form-control form-control-sm" id="title" placeholder="請輸入標題" v-model="info.title">
                    </div>
                    <div class="form-group">
                        <label for="content">內文</label>
                        <textarea id="content" placeholder="內文"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="keywords">關鍵字（最多10個）</label>
                        <div class="input-group">
                            <input type="text" class="form-control form-control-sm s-14" maxlength="20" placeholder="請輸入關鍵字" v-model="value.keyword" />
                            <div class="input-group-append cursor" @click="addKeyword">
                                <div class="input-group-text bg-info"><i class="fas fa-plus"></i></div>
                            </div>
                        </div>
                        <div class="d-flex align-items-center s-14 mt-2">
                            <div class="border rounded p-2 keywords d-flex align-content-start flex-wrap">
                                <!-- v-for -->
                                <div class="py-1 px-2 mb-1 mr-2 rounded keywords-border" v-for="(item, key) in info.keywords">${item} <i class="text-danger fas fa-times-circle cursor" @click="deleteKeyword(key)"></i></div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="description">描述</label>
                        <textarea id="description" class="form-control" placeholder="描述" v-model="info.description"></textarea>
                    </div>
                    <div class="form-group">
                        <div class="d-flex align-items-center">
                            <label for="web_img">電腦版圖片</label>
                            <i class="fas fa-minus-circle text-danger ml-2 mb-2 cursor" title="圖片刪除" @click="deletePicture('web')"></i>
                            <a data-fancybox class="ml-2 mb-2" :href="info.web_img_path">
                                <i class="fas fa-image text-info cursor" title="圖片預覽" v-show="mode == 'modify' && info.web_img_path"></i>
                            </a>
                        </div>
                        <div class="custom-file">
                            <input ref="web_img" type="file" class="custom-file-input" id="web_img" @change="(e) => file(e, 'web')">
                            <label class="custom-file-label s-14" for="web_img">${info.web_img_name}</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="d-flex align-items-center">
                            <label for="mobile_img">手機版圖片</label>
                            <i class="fas fa-minus-circle text-danger ml-2 mb-2 cursor" title="圖片刪除" @click="deletePicture('mobile')"></i>
                            <a data-fancybox class="ml-2 mb-2" :href="info.mobile_img_path">
                                <i class="fas fa-image text-info cursor" title="圖片預覽" v-show="mode == 'modify' && info.mobile_img_path"></i>
                            </a>
                        </div>
                        <div class="custom-file">
                            <input ref="mobile_img" type="file" class="custom-file-input" id="mobile_img" @change="(e) => file(e, 'mobile')">
                            <label class="custom-file-label s-14" for="mobile_img">${info.mobile_img_name}</label>
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
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th> 規格名稱 </th>
                                    <th> 原價 </th>
                                    <th> 售價 </th>
                                    <th> 庫存 </th>
                                    <th class="text-center"> 功能 </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td> <input name="name" type="text" maxlength="50" class="form-control form-control-sm" placeholder="請輸入名稱" v-model="info.name"> </td>
                                    <td> <input name="original_price" type="text" maxlength="20" class="form-control form-control-sm" placeholder="請輸入原價" v-model="info.original_price"> </td>
                                    <td> <input name="selling_price" type="text" maxlength="20" class="form-control form-control-sm" placeholder="請輸入售價" v-model="info.selling_price"> </td>
                                    <td> <input name="inventory" type="text" maxlength="20" class="form-control form-control-sm" placeholder="請輸入庫存" v-model="info.inventory"> </td>
                                    <td class="text-center"> <button class="btn btn-sm btn-primary" @click="confirm('create')">新增</button> </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="plugins/ckeditor/ckeditor.js"></script>
    <script src="js/product.js"></script>
@endsection
