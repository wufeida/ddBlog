<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>哒哒后台管理 | 首页</title>

    <link href="/admin/css/bootstrap.min.css" rel="stylesheet">
    <link href="/admin/font-awesome/css/font-awesome.css" rel="stylesheet">

    <!-- Toastr style -->
    <link href="/admin/css/plugins/toastr/toastr.min.css" rel="stylesheet">

    <!-- Gritter -->
    <link href="/admin/js/plugins/gritter/jquery.gritter.css" rel="stylesheet">

    <link href="/admin/css/animate.css" rel="stylesheet">
    <link href="/admin/css/style.css" rel="stylesheet">

</head>

<body>
<style type="text/css">
    .bTabs button.navTabsCloseBtn {
        font-size: 23px !important;
        cursor: pointer;

        margin-left: 10px;
        font-style: normal;
        line-height: 20px;
        font-family: inherit;
        font-weight: normal;

        position: relative;
        top: -2px;
        color: #AAAAAA;

        -webkit-appearance: none;
        padding: 0;
        cursor: pointer;
        background: 0 0;
        border: 0;

        float: right;
        line-height: 1;
        text-shadow: 0 1px 0 #fff;
    }
    .bTabs button.navTabsCloseBtn:hover{
        color: red !important;
        font-weight: 700;
    }
    .bTabs .nav-tabs li.active a button.navTabsCloseBtn{
        color: #666666;
    }
</style>
    <div id="wrapper" style="overflow: hidden;height: 100%">
        @include('admin.layous.nav')
        <div id="page-wrapper" class="gray-bg dashbard-1">
            @include('admin.layous.top')
            <div class="col-md-12" id="mainFrameTabs" style="padding : 0px;">
                <div class="row  border-bottom white-bg dashboard-header" style="padding: 5px 20px 0 20px;">
                     <ul class="nav nav-tabs" role="tablist">
                         <li role="presentation" class="active noclose"><a href="#bTabs_navTabsMainPage" data-toggle="tab">首页</a></li>
                     </ul>
                </div>
                <div class="tab-content">
                    <div class="tab-pane active" id="bTabs_navTabsMainPage" style="height: 100%">
                        <div class="wrapper wrapper-content animated fadeInRight">
                            <div class="row">
                                <div class="col-lg-3">
                                    <div class="widget style1 navy-bg">
                                        <div class="row">
                                            <div class="col-xs-4">
                                                <i class="fa fa-server fa-5x"></i>
                                            </div>
                                            <div class="col-xs-8 text-right">
                                                <span> Server </span>
                                                <h2 class="font-bold">{{$data['server']}}</h2>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="widget style1 lazur-bg">
                                        <div class="row">
                                            <div class="col-xs-4">
                                                <i class="fa fa-h-square fa-5x"></i>
                                            </div>
                                            <div class="col-xs-8 text-right">
                                                <span> Http Host </span>
                                                <h2 class="font-bold">{{$data['http_host']}}</h2>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="widget style1 yellow-bg">
                                        <div class="row">
                                            <div class="col-xs-4">
                                                <i class="fa fa-h-square fa-5x"></i>
                                            </div>
                                            <div class="col-xs-8 text-right">
                                                <span> Remote Host </span>
                                                <h2 class="font-bold">{{$data['remote_host']}}</h2>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="widget style1 lazur-bg">
                                        <div class="row">
                                            <div class="col-xs-4">
                                                <i class="fa fa-language fa-5x"></i>
                                            </div>
                                            <div class="col-xs-8 text-right">
                                                <span> PHP </span>
                                                <h2 class="font-bold">{{$data['php']}}</h2>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="widget style1 red-bg">
                                        <div class="row">
                                            <div class="col-xs-4">
                                                <i class="fa fa-language fa-5x"></i>
                                            </div>
                                            <div class="col-xs-8 text-right">
                                                <span> Sapi Name </span>
                                                <h2 class="font-bold">{{$data['sapi_name']}}</h2>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="widget style1 red-bg">
                                        <div class="row">
                                            <div class="col-xs-4">
                                                <i class="fa fa-database fa-5x"></i>
                                            </div>
                                            <div class="col-xs-8 text-right">
                                                <span> Database </span>
                                                <h2 class="font-bold">{{$data['db_connection']}}</h2>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="widget style1 red-bg">
                                        <div class="row">
                                            <div class="col-xs-4">
                                                <i class="fa fa-database fa-5x"></i>
                                            </div>
                                            <div class="col-xs-8 text-right">
                                                <span> Database Name </span>
                                                <h2 class="font-bold">{{$data['db_database']}}</h2>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="widget style1 red-bg">
                                        <div class="row">
                                            <div class="col-xs-4">
                                                <i class="fa fa-database fa-5x"></i>
                                            </div>
                                            <div class="col-xs-8 text-right">
                                                <span> Database Version </span>
                                                <h2 class="font-bold">{{$data['db_version']}}</h2>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="widget navy-bg no-padding">
                                        <div class="p-m">
                                            <h1 class="m-xs">php扩展</h1>

                                            <h3 class="font-bold no-margins">
                                                {{$data['extensions']}}
                                            </h3>
                                        </div>
                                        <div class="flot-chart">
                                            <div class="flot-chart-content" id="flot-chart1"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="widget red-bg no-padding">
                                        <div class="p-m">
                                            <h1 class="m-xs">浏览器</h1>

                                            <h3 class="font-bold no-margins">
                                                {{$data['user_agent']}}
                                            </h3>
                                        </div>
                                        <div class="flot-chart">
                                            <div class="flot-chart-content" id="flot-chart1"></div>
                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>
                    </div>
                </div>
            </div>
            @include('admin/layous/footer')
        </div>
        </div>

    <!-- Mainly scripts -->
    <script src="/admin/js/jquery-2.1.1.js"></script>
    <script src="/admin/js/bootstrap.min.js"></script>
    <script src="/admin/js/plugins/metisMenu/jquery.metisMenu.js"></script>
    <script src="/admin/js/plugins/slimscroll/jquery.slimscroll.min.js"></script>

    {{--<!-- Peity -->--}}
    {{--<script src="/admin/js/plugins/peity/jquery.peity.min.js"></script>--}}
    {{--<script src="/admin/js/demo/peity-demo.js"></script>--}}

    <!-- Custom and plugin javascript -->
    <script src="/admin/js/inspinia.js"></script>
    {{--<script src="/admin/js/plugins/pace/pace.min.js"></script>--}}

    <!-- jQuery UI -->
    {{--<script src="/admin/js/plugins/jquery-ui/jquery-ui.min.js"></script>--}}
    <!-- GITTER -->
    {{--<script src="/admin/js/plugins/gritter/jquery.gritter.min.js"></script>--}}

    <!-- Toastr -->
    {{--<script src="/admin/js/plugins/toastr/toastr.min.js"></script>--}}
    <script src="/admin/js/b.tabs.js"></script>
    <script src="/admin/js/demo.js"></script>
</body>
</html>
