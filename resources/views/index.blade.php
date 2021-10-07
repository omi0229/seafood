@extends('layouts.base')

@section('content')
    <div id="app" v-cloak>
        <div class="content-header px-4">
            <!--
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">儀表版</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="/">首頁</a></li>
                            <li class="breadcrumb-item active">儀表版</li>
                        </ol>
                    </div>
                </div>
            </div>
            -->
        </div>

        <div class="content px-4">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-12">
                        <h2>海龍王 後台管理系統</h2>
                    </div>
                </div>
            </div>
            <div class="mt-4">
                <div>更新紀錄</div>
                <div>2021.10.08 大圖輪播初版完成</div>
                <div>2021.09.29 上架設定管理初版完成</div>
                <div>2021.09.25 產品設定初版完成</div>
                <div>2021.09.17 烹飪教學管理初版完成</div>
                <div>2021.09.15 最新消息管理初版完成</div>
                <div>2021.09.01 專案開始</div>
            </div>
        </div>
    </div>
    <script src="js/dashboard.js"></script>
@endsection
