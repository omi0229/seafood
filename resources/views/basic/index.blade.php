@extends('layouts.base')

@section('content')
    <link rel="stylesheet" href="css/basic.css">
    <div id="app" v-cloak>
        <div class="content-header px-4">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">基本設定</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="/">首頁</a></li>
                            <li class="breadcrumb-item active">基本設定</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div class="content px-4">
            <div class="col-12">
                <div class="card card-primary card-outline card-outline-tabs">
                    <div class="card-header p-0 border-bottom-0">
                        <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
                            <li class="nav-item" @click="setMode('basic')">
                                <a class="nav-link active" id="custom-tabs-basic-tab" data-toggle="pill"
                                   href="#custom-tabs-basic" role="tab" aria-controls="custom-tabs-basic"
                                   aria-selected="true">基本設定</a>
                            </li>
                            <li class="nav-item" @click="setMode('goldflow')">
                                <a class="nav-link" id="custom-tabs-goldflow-tab" data-toggle="pill"
                                   href="#custom-tabs-goldflow" role="tab" aria-controls="custom-tabs-goldflow"
                                   aria-selected="false">金物流設定</a>
                            </li>
                            <li class="nav-item" @click="setMode('seo')">
                                <a class="nav-link" id="custom-tabs-seo-tab" data-toggle="pill"
                                   href="#custom-tabs-seo" role="tab"
                                   aria-controls="custom-tabs-seo" aria-selected="false">SEO設定</a>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body">
                        <div class="tab-content" id="custom-tabs-four-tabContent">
                            <div class="tab-pane fade show active" id="custom-tabs-basic" role="tabpanel" aria-labelledby="custom-tabs-four-home-tab">
                                <div class="basic-tab-pane-height">
                                    <div class="form-group row">
                                        <div class="col-12 col-sm-6">
                                            <label for="web_title">網站標題</label>
                                            <input type="text" maxlength="50" class="form-control form-control-sm" id="web_title" placeholder="請輸入網站標題" v-model="config.basic.basic_title">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-12 col-sm-6">
                                            <label for="web_phone">訂購專線</label>
                                            <input type="text" maxlength="20" class="form-control form-control-sm" id="web_phone" placeholder="請輸入訂購專線" v-model="config.basic.basic_phone">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-12 col-sm-6">
                                            <label for="web_address">地址</label>
                                            <input type="text" maxlength="100" class="form-control form-control-sm" id="web_address" placeholder="請輸入地址" v-model="config.basic.basic_address">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-12 col-sm-6">
                                            <label for="web_email">電子郵件</label>
                                            <input type="text" maxlength="50" class="form-control form-control-sm" id="web_email" placeholder="請輸入電子郵件" v-model="config.basic.basic_email">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-12 col-sm-6">
                                            <label for="web_facebook">Facebook連結</label>
                                            <input type="text" class="form-control form-control-sm" id="web_facebook" placeholder="請輸入Facebook連結" v-model="config.basic.basic_facebook">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-12 col-sm-6">
                                            <label for="web_line">Line連結</label>
                                            <input type="text" class="form-control form-control-sm" id="web_line" placeholder="Line連結" v-model="config.basic.basic_line">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="custom-tabs-goldflow" role="tabpanel" aria-labelledby="custom-tabs-four-profile-tab">
                                <div class="basic-tab-pane-height">
                                    串接金流時補上
                                </div>
                            </div>
                            <div class="tab-pane fade" id="custom-tabs-seo" role="tabpanel" aria-labelledby="custom-tabs-four-messages-tab">
                                <div class="basic-tab-pane-height">
                                    <div class="form-group row">
                                        <div class="col-12 col-sm-6">
                                            <label for="meta_keyword">頁面關鍵字</label>
                                            <input type="text" class="form-control form-control-sm" id="web_facebook" placeholder="請輸入頁面關鍵字" v-model="config.seo.seo_keyword">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-12 col-sm-6">
                                            <label for="meta_description">頁面描述</label>
                                            <textarea id="meta_description" class="form-control" v-model="config.seo.seo_description"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-end mt-3">
                                <button type="button" class="btn btn-sm btn-primary px-3" @click="confirm">
                                    儲存
                                </button>
                            </div>
                        </div>
                    </div>
                    <!-- /.card -->
                </div>
            </div>
        </div>
    </div>
    <script src="js/basic.js"></script>
@endsection
