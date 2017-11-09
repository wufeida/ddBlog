<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>后台管理 | 文件管理</title>

    <link href="/admin/css/bootstrap.min.css" rel="stylesheet">
    <link href="/admin/font-awesome/css/font-awesome.css" rel="stylesheet">

    <link href="/admin/css/animate.css" rel="stylesheet">
    <link href="/admin/css/style.css" rel="stylesheet">

</head>

<body class="gray-bg">
    <div id="wrapper">
            <div class="row wrapper border-bottom white-bg page-heading" style="padding: 10px 10px;">
                <div class="col-lg-9">
                    <ol class="breadcrumb">
                        @if($data['breadcrumbs'] == false)
                        <li>
                            <a class="active" href="index.html">root</a>
                        </li>
                        @else
                            @foreach($data['breadcrumbs'] as $v)
                                <li>
                                    {{$v}}
                                </li>
                            @endforeach
                                <li class="active">
                                    <strong>{{$data['folderName']}}</strong>
                                </li>
                        @endif

                    </ol>
                </div>
            </div>
        <div class="wrapper wrapper-content">
            <div class="row">
                <div class="col-lg-3">
                    <div class="ibox float-e-margins">
                        <div class="ibox-content">
                            <div class="file-manager">
                                <div class="hr-line-dashed"></div>
                                <button class="btn btn-primary btn-block">Upload Files</button>
                                <div class="hr-line-dashed"></div>
                                <h5>文件夹</h5>
                                <ul class="folder-list" style="padding: 0">
                                    @if($data['subfolders'] == false)
                                        没有了！！！
                                    @endif
                                    @foreach($data['subfolders'] as $v)
                                    <li><a href="file_manager.html"><i class="fa fa-folder"></i>{{$v}}</a></li>
                                    @endforeach
                                </ul>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-9 animated fadeInRight">
                    <div class="row">
                        <div class="col-lg-12">
                            {{--<div class="file-box">--}}
                                {{--<div class="file">--}}
                                    {{--<a href="file_manager.html#">--}}
                                        {{--<span class="corner"></span>--}}

                                        {{--<div class="icon">--}}
                                            {{--<i class="fa fa-file"></i>--}}
                                        {{--</div>--}}
                                        {{--<div class="file-name">--}}
                                            {{--Document_2014.doc--}}
                                            {{--<br/>--}}
                                            {{--<small>Added: Jan 11, 2014</small>--}}
                                        {{--</div>--}}
                                    {{--</a>--}}
                                {{--</div>--}}

                            {{--</div>--}}
                            @foreach($data['files'] as $v)
                            <div class="file-box">
                                <div class="file">
                                    <a href="{{$v['webPath']}}">
                                        <span class="corner"></span>

                                        <div class="image">
                                            <img alt="image" class="img-responsive" src="{{$v['webPath']}}">
                                        </div>
                                        <div class="file-name">
                                            {{$v['name']}}
                                            <br/>
                                            <small>最后修改: {{$v['modified']}}</small>
                                        </div>
                                    </a>

                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    </div>
                </div>
                </div>
            </div>


    <!-- Mainly scripts -->
    <script src="/admin/js/jquery-2.1.1.js"></script>
    <script src="/admin/js/bootstrap.min.js"></script>
    <script src="/admin/js/plugins/metisMenu/jquery.metisMenu.js"></script>
    <script src="/admin/js/plugins/slimscroll/jquery.slimscroll.min.js"></script>

    <!-- Custom and plugin javascript -->
    <script src="/admin/js/inspinia.js"></script>
    <script src="/admin/js/plugins/pace/pace.min.js"></script>

    <script>
        $(document).ready(function(){
            $('.file-box').each(function() {
                animationHover(this, 'pulse');
            });
        });
    </script>
</body>

</html>
