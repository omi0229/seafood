@extends('layouts.base')

@section('content')
    <link rel="stylesheet" href="plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
    <link rel="stylesheet" href="plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="css/news.css">
    <div id="app" v-cloak>
        <div class="content-header px-4">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">最新消息管理</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="/">首頁</a></li>
                            <li class="breadcrumb-item active">最新消息管理</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mx-0 px-3">
            <div class="mb-3 col-12 col-md-6">
                <components-search v-model:search_text="search_text" name="最新消息" @get-count="getCount" @get-data="getData"></components-search>
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
                            <h3 class="card-title">最新消息列表</h3>
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
                                    <th class="text-center" colspan="5"><span class="text-danger">無最新消息資料</span></th>
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
                <components-pagination ref="pagination" :all_count="all_count" :page_count="page_count" @get-data="getData"></components-pagination>
            </div>
        </div>
    </div>

    <div class="modal fade" id="set-info" data-backdrop="static">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">
                        <template v-if="mode == 'create'">新增</template><template v-else>編輯</template>最新消息
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
                        <label for="type">分類 <span class="text-danger">*</span></label>
                        <select id="type" class="form-control form-control-sm s-14" v-model="info.news_types_id">
                            <option value="">請選擇分類</option>
                            <!-- v-for -->
                            <option v-for="item in select.news_types" :value="item.id">${item.name}</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="title">標題 <span class="text-danger">*</span></label>
                        <input type="text" maxlength="50" class="form-control form-control-sm" id="title" placeholder="請輸入標題" v-model="info.title">
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
                    <div class="form-group">
                        <label for="href">超連結</label>
                        <input type="href" maxlength="200" class="form-control form-control-sm s-14" id="href" placeholder="請輸入超連結" v-model="info.href">
                    </div>
                    <div class="form-group">
                        <label for="description">描述</label>
                        <textarea id="description" placeholder="請輸入描述" class="form-control s-14" v-model="info.description"></textarea>
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
                        <label for="news_keywords">關鍵字（最多10個）</label>
                        <div class="input-group">
                            <input type="text" class="form-control form-control-sm s-14" maxlength="20" placeholder="請輸入關鍵字" v-model="value.keyword" />
                            <div class="input-group-append cursor" @click="addKeyword">
                                <div class="input-group-text bg-info"><i class="fas fa-plus"></i></div>
                            </div>
                        </div>
                        <div class="d-flex align-items-center s-14 mt-2">
                            <div class="border rounded p-2 news-keywords d-flex align-content-start flex-wrap">
                                <!-- v-for -->
                                <div class="py-1 px-2 mb-1 mr-2 rounded news-keywords-border" v-for="(item, key) in info.keywords">${item} <i class="text-danger fas fa-times-circle cursor" @click="deleteKeyword(key)"></i></div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="web_img">電腦版圖片</label>
                        <div class="custom-file">
                            <input ref="web_img" type="file" class="custom-file-input" id="web_img" @change="(e) => file(e, 'web')">
                            <label class="custom-file-label s-14" for="web_img">${info.web_img_name}</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="mobile_img">手機版圖片</label>
                        <div class="custom-file">
                            <input ref="mobile_img" type="file" class="custom-file-input" id="mobile_img" @change="(e) => file(e, 'mobile')">
                            <label class="custom-file-label s-14" for="mobile_img">${info.mobile_img_name}</label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-end">
                    <button type="button" class="btn btn-sm btn-primary px-3" @click="confirm('save')">儲存</button>
                </div>
            </div>
        </div>
    </div>
    <script src="plugins/select2/js/select2.full.min.js"></script>
    <script src="plugins/moment/moment-with-locales.min.js"></script>
    <script src="plugins/inputmask/jquery.inputmask.min.js"></script>
    <script src="plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
    <script src="js/news.js"></script>
@endsection
