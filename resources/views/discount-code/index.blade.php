@extends('layouts.base')

@section('content')
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
                        <template v-if="mode == 'create'">新增</template><template v-else>編輯</template>分類
                    </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body px-5">
                    <div class="form-group">
                        <label for="name">名稱</label>
                        <input type="text" maxlength="20" class="form-control form-control-sm" id="name" placeholder="請輸入名稱" v-model="user_info.name">
                    </div>
                </div>
                <div class="modal-footer justify-content-end">
                    <button type="button" class="btn btn-sm btn-danger px-3 mr-1" data-dismiss="modal" aria-label="Close">取消</button>
                    <button type="button" class="btn btn-sm btn-primary px-3" @click="confirm('save')">儲存</button>
                </div>
            </div>
        </div>
    </div>
    <script src="js/discount-code.js"></script>
@endsection