<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>海龍王：後台管理系統</title>
        <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
        <link rel="stylesheet" href="dist/css/adminlte.min.css">
        <link rel="stylesheet" href="css/app.css">
        <script src="plugins/jquery/jquery.min.js"></script>
        <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="dist/js/adminlte.js"></script>
        <script src="js/app.js"></script>
    </head>
    <body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed">
        <div id="loading">
            <template v-if="show">
                <div class="position-fixed d-flex justify-content-center align-items-center loading">
                    <div class="la-ball-scale-ripple la-3x">
                        <div></div>
                    </div>
                </div>
            </template>
        </div>
        <div class="wrapper">
            <!-- Navbar -->
            <nav class="main-header navbar navbar-expand navbar-white navbar-light">
                <!-- Left navbar links -->
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                    </li>
                    <li class="nav-item d-none d-sm-inline-block">
                        <a href="index3.html" class="nav-link">Home</a>
                    </li>
                    <li class="nav-item d-none d-sm-inline-block">
                        <a href="#" class="nav-link">Contact</a>
                    </li>
                </ul>

                <!-- Right navbar links -->
                <ul class="navbar-nav ml-auto">
                    <li id="logout" class="nav-item dropdown">
                        <a class="nav-link" data-toggle="dropdown" href="#">
                            <i class="fas fa-th-large"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                            <div class="dropdown-divider"></div>
                            <a href="#" class="dropdown-item dropdown-footer" @click="confirm">
                                <i class="fas fa-sign-out-alt mr-2"></i>
                                登出系統
                            </a>
                        </div>
                    </li>
                </ul>
            </nav>
            <!-- /.navbar -->

            <!-- Main Sidebar Container -->
            <aside class="main-sidebar sidebar-dark-primary elevation-4">
                <!-- Brand Logo -->
                <a href="/" class="brand-link text-center">
                    <span class="brand-text font-weight-light">海龍王 後台管理系統</span>
                </a>

                <!-- Sidebar -->
                <div class="sidebar">
                    <!-- Sidebar user panel (optional) -->
                    <div class="user-panel mt-3 pb-3 mb-3 d-flex align-items-center">
                        <div class="image">
                            <i class="fas fa-user text-white ml-1" style="font-size: 24px;"></i>
                        </div>
                        <div class="info ml-2">
                            <a href="#" class="d-block">{{ $login_user->name }}</a>
                        </div>
                    </div>

                    <!-- Sidebar Menu -->
                    <nav class="mt-2">
                        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                            @php
                                $basic = $permissions->where('name', 'set_basic')->first();
                            @endphp
                            @if($basic && $login_user->can('set_basic'))
                            <li class="nav-item">
                                <a href="/basic" class="nav-link">
                                    <i class="nav-icon fas fa-th"></i>
                                    <p>
                                        {{$basic->display_name}}
                                    </p>
                                </a>
                            </li>
                            @endif

                            @php
                                $set_manager = $permissions->where('name', 'set_manager')->first();
                            @endphp
                            @if($set_manager && $login_user->can('set_manager'))
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="nav-icon fas fa-user-cog"></i>
                                    <p>
                                        {{$set_manager->display_name}}
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="/role" class="nav-link">
                                            <i class="nav-icon far fa-circle"></i>
                                            <p>權限設定</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="/user" class="nav-link">
                                            <i class="nav-icon far fa-circle"></i>
                                            <p>管理員設定</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            @endif

                            @php
                                $set_message = $permissions->where('name', 'set_message')->first();
                            @endphp
                            @if($set_message && $login_user->can('set_message'))
                            <li class="nav-item">
                                <a href="/sms" class="nav-link">
                                    <i class="nav-icon fas fa-sms"></i>
                                    <p>
                                        {{$set_message->display_name}}
                                    </p>
                                </a>
                            </li>
                            @endif

                            @php
                                $news_manage = $permissions
                                    ->filter(function ($p){
                                        if($p->name == 'news-type' || $p->name == 'news'){
                                            return true;
                                        }

                                        return false;
                                    });
                            @endphp
                            @if($news_manage->count() > 0 && ($login_user->can('news-type') || $login_user->can('news')))
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="nav-icon far fa-newspaper"></i>
                                    <p>
                                        最新消息
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    @if($login_user->can('news-type'))
                                    <li class="nav-item">
                                        <a href="/news-type" class="nav-link">
                                            <i class="nav-icon far fa-circle"></i>
                                            <p>{{ $news_manage->where('name', 'news-type')->first()->display_name  }}</p>
                                        </a>
                                    </li>
                                    @endif
                                    @if($login_user->can('news'))
                                    <li class="nav-item">
                                        <a href="/news" class="nav-link">
                                            <i class="nav-icon far fa-circle"></i>
                                            <p>{{ $news_manage->where('name', 'news')->first()->display_name  }}</p>
                                        </a>
                                    </li>
                                    @endif
                                </ul>
                            </li>
                            @endif

                            @php
                                $cooking_manage = $permissions
                                    ->filter(function ($p){
                                        if($p->name == 'cooking-type' || $p->name == 'cooking'){
                                            return true;
                                        }

                                        return false;
                                    });
                            @endphp
                            @if($cooking_manage->count() > 0 && ($login_user->can('cooking-type') || $login_user->can('cooking')))
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="nav-icon fab fa-youtube"></i>
                                    <p>
                                        烹飪教學
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    @if($login_user->can('cooking-type'))
                                    <li class="nav-item">
                                        <a href="/cooking-type" class="nav-link">
                                            <i class="nav-icon far fa-circle"></i>
                                            <p>{{ $cooking_manage->where('name', 'cooking-type')->first()->display_name  }}</p>
                                        </a>
                                    </li>
                                    @endif
                                    @if($login_user->can('cooking'))
                                    <li class="nav-item">
                                        <a href="/cooking" class="nav-link">
                                            <i class="nav-icon far fa-circle"></i>
                                            <p>{{ $cooking_manage->where('name', 'cooking')->first()->display_name  }}</p>
                                        </a>
                                    </li>
                                    @endif
                                </ul>
                            </li>
                            @endif

                            @php
                                $product_manage = $permissions
                                    ->filter(function ($p){
                                        if($p->name == 'product-type' || $p->name == 'product'){
                                            return true;
                                        }

                                        return false;
                                    });
                            @endphp
                            @if($product_manage->count() > 0 && ($login_user->can('product-type') || $login_user->can('product')))
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="nav-icon fas fa-fish"></i>
                                    <p>
                                        產品設定
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    @if($login_user->can('product-type'))
                                    <li class="nav-item">
                                        <a href="/product-type" class="nav-link">
                                            <i class="nav-icon far fa-circle"></i>
                                            <p>{{ $product_manage->where('name', 'product-type')->first()->display_name  }}</p>
                                        </a>
                                    </li>
                                    @endif
                                    @if($login_user->can('product'))
                                    <li class="nav-item">
                                        <a href="/product" class="nav-link">
                                            <i class="nav-icon far fa-circle"></i>
                                            <p>{{ $product_manage->where('name', 'product')->first()->display_name  }}</p>
                                        </a>
                                    </li>
                                    @endif
                                </ul>
                            </li>
                            @endif

                        </ul>
                    </nav>
                    <!-- /.sidebar-menu -->
                </div>
                <!-- /.sidebar -->
            </aside>

            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                @yield('content')
            </div>
            <!-- /.content-wrapper -->

            <!-- Control Sidebar -->
            <aside class="control-sidebar control-sidebar-dark">
                <!-- Control sidebar content goes here -->
            </aside>
            <!-- /.control-sidebar -->

            <!-- Main Footer -->
            <footer class="main-footer">
                <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong>
                All rights reserved.
                <div class="float-right d-none d-sm-inline-block">
                    <b>Version</b> 3.1.0
                </div>
            </footer>
        </div>
        <script src="js/base.js"></script>
        <script src="js/logout.js"></script>
    </body>
</html>
