@extends('layouts.base')

@section('content')
    <link rel="stylesheet" href="css/sms.css">
    <div id="app" v-cloak>
        <div class="content-header px-4">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">簡訊設定</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="/">首頁</a></li>
                            <li class="breadcrumb-item active">簡訊設定</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div class="content px-4">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">簡訊設定</h3>
                        </div>
                        <div class="card-body">
                            <div class="form-group row">
                                <div class="col-12 col-sm-6">
                                    <label for="web_title">平台網址</label>
                                    <div>
                                        <a href="http://www.943.tw" class="text-primary" target="_blank">http://www.943.tw</a>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-12 col-sm-6">
                                    <label for="web_title">簡訊帳號</label>
                                    <input type="text" maxlength="50" class="form-control form-control-sm" id="web_title" placeholder="請輸入簡訊帳號" v-model="config.sms.sms_account">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-12 col-sm-6">
                                    <label for="web_title">簡訊密碼</label>
                                    <input type="text" maxlength="50" class="form-control form-control-sm" id="web_title" placeholder="請輸入簡訊密碼" v-model="config.sms.sms_password">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-12 col-sm-6">
                                    <label for="web_title" class="mb-0">剩餘點數</label>
                                    <div class="row">
                                        <div class="col-12 col-xl-10 mt-2">
                                            <input type="text" maxlength="10" class="form-control form-control-sm" disabled v-model="points">
                                        </div>
                                        <div class="col-12 col-xl-2 mt-2">
                                            <button type="button" class="btn btn-sm btn-info w-100 sms-point-button" @click="queryPoints">查詢點數</button>
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
                </div>
            </div>
        </div>
    </div>
    <script src="js/sms.js"></script>
@endsection
