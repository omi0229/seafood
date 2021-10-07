@extends('layouts.base')

@section('content')
    <link rel="stylesheet" href="css/banners.css">
    <div id="app" v-cloak>
        <div class="content-header px-4">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">大圖輪播管理</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="/">首頁</a></li>
                            <li class="breadcrumb-item active">大圖輪播管理</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mx-0 px-3 methods">
            <div class="mb-3 col-12 d-flex justify-content-end">
                <!-- v-show -->
                <div v-show="check.length > 0">
                    <button type="button" class="btn btn-sm btn-danger px-2" @click="confirm('delete')">
                        <i class="fa fa-minus mr-1"></i> 刪除
                    </button>
                </div>
                <div class="ml-2" v-show="list.length < 5">
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
                            <h3 class="card-title">大圖輪播列表</h3>
                        </div>
                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover text-nowrap">
                                <thead>
                                <!-- v-if -->
                                <tr v-if="list.length > 0">
                                    <th class="align-middle">
                                        <input type="checkbox" class="checkbox-size" v-model="checkAll">
                                    </th>
                                    <th>網頁圖片</th>
                                    <th>手機圖片</th>
                                    <th class="text-center">開啟方式</th>
                                    <th class="text-center">跑馬燈顯示</th>
                                    <th class="text-center">功能</th>
                                </tr>
                                <tr v-else>
                                    <th class="text-center" colspan="5"><span class="text-danger">無大圖輪播資料</span></th>
                                </tr>
                                </thead>
                                <tbody>
                                <!-- v-for -->
                                <tr v-for="item in list">
                                    <td class="align-middle">
                                        <input type="checkbox" class="checkbox-size" :value="item.id" v-model="check">
                                    </td>
                                    <td>
                                        <div class="text-wrap">
                                            <a data-fancybox :href="item.web_img_path"> ${item.web_img_name} </a>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="text-wrap">
                                            <a data-fancybox :href="item.mobile_img_path"> ${item.mobile_img_name} </a>
                                        </div>
                                    </td>
                                    <td class="text-center">${targetFormat(item.target)}</td>
                                    <td class="text-center">${statusFormat(item.status)}</td>
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
            </div>
        </div>
    </div>

    <div class="modal fade" id="set-info" data-backdrop="static">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">
                        <template v-if="mode == 'create'">新增</template><template v-else>編輯</template>大圖
                    </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body px-5">
                    <div class="form-group">
                        <label>是否顯示</label>
                        <div class="d-flex align-items-center s-14">
                            <div class="form-check mr-3">
                                <input id="disabled" class="form-check-input" type="radio" value="0" v-model="info.status">
                                <label for="disabled" class="form-check-label">不顯示</label>
                            </div>
                            <div class="form-check">
                                <input id="enabled" class="form-check-input" type="radio" value="1" v-model="info.status">
                                <label for="enabled" class="form-check-label">顯示</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="href">超連結</label>
                        <input type="href" maxlength="200" class="form-control form-control-sm s-14" id="href" placeholder="請輸入超連結" v-model="info.href">
                    </div>
                    <div class="form-group">
                        <label for="target">開啟方式</label>
                        <div class="d-flex align-items-center s-14">
                            <div class="form-check mr-3">
                                <input id="_top" class="form-check-input" type="radio" value="0" v-model="info.target">
                                <label for="_top" class="form-check-label">直接開啟</label>
                            </div>
                            <div class="form-check">
                                <input id="_blank" class="form-check-input" type="radio" value="1" v-model="info.target">
                                <label for="_blank" class="form-check-label">開新視窗</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="d-flex align-items-center">
                            <label for="web_img">網頁版圖片</label>
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
    <script src="js/banners.js"></script>
@endsection
