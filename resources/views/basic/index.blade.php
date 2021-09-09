@extends('layouts.base')

@section('content')
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
                            <li class="nav-item">
                                <a class="nav-link active" id="custom-tabs-basic-tab" data-toggle="pill"
                                   href="#custom-tabs-basic" role="tab" aria-controls="custom-tabs-basic"
                                   aria-selected="true">基本設定</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="custom-tabs-goldflow-tab" data-toggle="pill"
                                   href="#custom-tabs-goldflow" role="tab" aria-controls="custom-tabs-goldflow"
                                   aria-selected="false">金物流設定</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="custom-tabs-seo-tab" data-toggle="pill"
                                   href="#custom-tabs-seo" role="tab"
                                   aria-controls="custom-tabs-seo" aria-selected="false">SEO設定</a>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body">
                        <div class="tab-content" id="custom-tabs-four-tabContent">
                            <div class="tab-pane fade show active" id="custom-tabs-basic" role="tabpanel"
                                 aria-labelledby="custom-tabs-four-home-tab">
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin malesuada lacus
                                ullamcorper dui molestie, sit amet congue quam finibus. Etiam ultricies nunc non magna
                                feugiat commodo. Etiam odio magna, mollis auctor felis vitae, ullamcorper ornare ligula.
                                Proin pellentesque tincidunt nisi, vitae ullamcorper felis aliquam id. Pellentesque
                                habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Proin
                                id orci eu lectus blandit suscipit. Phasellus porta, ante et varius ornare, sem enim
                                sollicitudin eros, at commodo leo est vitae lacus. Etiam ut porta sem. Proin porttitor
                                porta nisl, id tempor risus rhoncus quis. In in quam a nibh cursus pulvinar non
                                consequat neque. Mauris lacus elit, condimentum ac condimentum at, semper vitae lectus.
                                Cras lacinia erat eget sapien porta consectetur.
                            </div>
                            <div class="tab-pane fade" id="custom-tabs-goldflow" role="tabpanel"
                                 aria-labelledby="custom-tabs-four-profile-tab">
                                Mauris tincidunt mi at erat gravida, eget tristique urna bibendum. Mauris pharetra purus
                                ut ligula tempor, et vulputate metus facilisis. Lorem ipsum dolor sit amet, consectetur
                                adipiscing elit. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices
                                posuere cubilia Curae; Maecenas sollicitudin, nisi a luctus interdum, nisl ligula
                                placerat mi, quis posuere purus ligula eu lectus. Donec nunc tellus, elementum sit amet
                                ultricies at, posuere nec nunc. Nunc euismod pellentesque diam.
                            </div>
                            <div class="tab-pane fade" id="custom-tabs-seo" role="tabpanel"
                                 aria-labelledby="custom-tabs-four-messages-tab">
                                Morbi turpis dolor, vulputate vitae felis non, tincidunt congue mauris. Phasellus
                                volutpat augue id mi placerat mollis. Vivamus faucibus eu massa eget condimentum. Fusce
                                nec hendrerit sem, ac tristique nulla. Integer vestibulum orci odio. Cras nec augue
                                ipsum. Suspendisse ut velit condimentum, mattis urna a, malesuada nunc. Curabitur
                                eleifend facilisis velit finibus tristique. Nam vulputate, eros non luctus efficitur,
                                ipsum odio volutpat massa, sit amet sollicitudin est libero sed ipsum. Nulla lacinia, ex
                                vitae gravida fermentum, lectus ipsum gravida arcu, id fermentum metus arcu vel metus.
                                Curabitur eget sem eu risus tincidunt eleifend ac ornare magna.
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
