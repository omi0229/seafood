@extends('layouts.base')

@section('content')
    <div id="app" v-cloak>
        <div class="content-header px-4">
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
        </div>

        <div class="content px-4">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-12">
                        <h2>海龍王 後台管理系統</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="js/dashboard.js"></script>
@endsection
