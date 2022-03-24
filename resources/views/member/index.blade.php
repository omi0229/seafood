@extends('layouts.base')

@section('content')
    <div id="app" v-cloak>
        <div class="content-header px-4">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">會員設定</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="/">首頁</a></li>
                            <li class="breadcrumb-item active">會員設定</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mx-0 px-3">
            <div class="mb-3 col-12 col-md-6">
                <components-search v-model:search_text="keywords" name="手機號碼或" @get-count="getCount" @get-data="setKeywords"></components-search>
            </div>
            <div class="mb-3 col-12 col-md-6 d-flex justify-content-end">
                <!-- v-show -->
                <div class="mr-2" v-show="check.length > 0">
                    <button type="button" class="btn btn-sm btn-danger px-2" @click="confirm('delete')">
                        <i class="fa fa-minus mr-1"></i> 刪除
                    </button>
                </div>
                <div class="mr-2">
                    <button type="button" class="btn btn-sm btn-primary px-2" data-toggle="modal" data-target="#set-user" @click="create">
                        <i class="fa fa-plus mr-1"></i> 新增
                    </button>
                </div>
                <div>
                    <button type="button" class="btn btn-sm btn-success px-2" @click="exportMembers">
                        <i class="fas fa-file-export mr-1"></i> 會員資料匯出
                    </button>
                </div>
            </div>
        </div>

        <div class="content px-4">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header row mx-0">
                            <h3 class="card-title col-12 col-lg-6 px-0">會員列表</h3>
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
                                    <th>手機</th>
                                    <th>姓名</th>
                                    <th>電子郵件</th>
                                    <th class="text-center">狀態</th>
                                    <th class="text-center">功能</th>
                                </tr>
                                <tr v-else>
                                    <th class="text-center" colspan="7"><span class="text-danger">無會員資料</span></th>
                                </tr>
                                </thead>
                                <tbody>
                                <!-- v-for -->
                                <tr v-for="item in list">
                                    <td class="align-middle">
                                        <input type="checkbox" class="checkbox-size" :value="item.id" v-model="check">
                                    </td>
                                    <td>${item.cellphone}</td>
                                    <td>${item.name}</td>
                                    <td>${item.email}</td>
                                    <td class="text-center">
                                        <!-- v-if -->
                                        <span class="right badge badge-success" v-if="item.active == '1'">啟用</span>
                                        <span class="right badge badge-danger" v-else="">停用</span>
                                    </td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-sm btn-info px-2" data-toggle="modal" data-target="#set-user" @click="modify(item.id)">
                                            <i class="fa fa-edit mr-1"></i> 編輯
                                        </button>
                                        <button type="button" class="btn btn-sm btn-default px-2 ml-2" @click="orders(item.name)">
                                            <i class="fa fa-list mr-1"></i> 會員訂單
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

    <div class="modal fade" id="set-user" data-backdrop="static">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">
                        <template v-if="mode == 'create'">新增</template><template v-else>編輯</template>會員
                    </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body px-5">
                    <div class="form-group">
                        <label>帳號啟用</label>
                        <div class="d-flex align-items-center">
                            <div class="form-check mr-3">
                                <input id="disabled" class="form-check-input" type="radio" value="0" v-model="user_info.active">
                                <label for="disabled" class="form-check-label">停用</label>
                            </div>
                            <div class="form-check">
                                <input id="enabled" class="form-check-input" type="radio" value="1" v-model="user_info.active">
                                <label for="enabled" class="form-check-label">啟用</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="cellphone">手機號碼 <span class="text-danger">*</span></label>
                        <input type="text" maxlength="10" class="form-control form-control-sm" id="cellphone" placeholder="請輸入手機號碼(帳號)" v-model="user_info.cellphone">
                    </div>
                    <div class="form-group">
                        <label for="name">姓名 <span class="text-danger">*</span></label>
                        <input type="text" maxlength="20" class="form-control form-control-sm" id="name" placeholder="請輸入姓名" v-model="user_info.name">
                    </div>
                    <div class="form-group">
                        <label for="password"><template v-if="mode == 'modify'">修改</template>密碼 <span class="text-danger" v-if="mode == 'create'">*</span></label>
                        <input type="password" maxlength="20" class="form-control form-control-sm" id="password" placeholder="請輸入密碼" v-model="user_info.password">
                    </div>
                    <div class="form-group">
                        <label for="password_auth">密碼確認 <span class="text-danger" v-if="mode == 'create'">*</span></label>
                        <input type="password" maxlength="20" class="form-control form-control-sm" id="password_auth" placeholder="請再次確認密碼" v-model="user_info.auth_password">
                    </div>
                    <div class="form-group">
                        <label for="email">電子郵件</label>
                        <input type="email" class="form-control form-control-sm" id="email" placeholder="請輸入電子郵件" v-model="user_info.email">
                    </div>
                    <div class="form-group">
                        <label for="telephone">市內電話</label>
                        <input type="telephone" class="form-control form-control-sm" id="telephone" placeholder="請輸入市內電話" v-model="user_info.telephone">
                    </div>
                    <div class="form-group">
                        <label for="address">通訊地址</label>
                        <div class="row">
                            <div class="col-4">
                                <select class="form-control form-control-sm" v-model="user_info.country" @change="selectCountry">
                                    <option value="">請選擇城市</option>
                                    <!-- v-for -->
                                    <option :value="item.id" v-for="item in select.counties">${ item.name }</option>
                                </select>
                            </div>
                            <div class="col-4">
                                <select class="form-control form-control-sm" v-model="user_info.city" @change="selectCity">
                                    <option value="">請選擇地區</option>
                                    <!-- v-for -->
                                    <option :value="item.city" v-for="item in select.cities">${ item.city }</option>
                                </select>
                            </div>
                            <div class="col-4">
                                <input class="form-control form-control-sm" type="text" placeholder="郵遞區號" v-model="user_info.zipcode" disabled>
                            </div>
                        </div>
                        <div class="mt-2">
                            <input type="address" class="form-control form-control-sm" id="address" placeholder="請輸入通訊地址" v-model="user_info.address">
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
    <script src="js/member.js"></script>
@endsection
