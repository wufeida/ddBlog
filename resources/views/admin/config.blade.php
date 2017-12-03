<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>后台管理 | 文章管理</title>

    <link href="/admin/css/bootstrap.min.css" rel="stylesheet">
    <link href="/admin/font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="/admin/css/plugins/iCheck/custom.css" rel="stylesheet">
    <link href="/admin/css/animate.css" rel="stylesheet">
    <link href="/admin/css/style.css" rel="stylesheet">
    <link href="/admin/plugins/toastr/toastr.css" rel="stylesheet">
    <link href="/admin/css/plugins/switchery/switchery.css" rel="stylesheet">


</head>
<style>
    .pagination {
        margin: 0px 0px;
    }
    .alert {
        margin-bottom: 0px;
    }
    .del-footer {
        padding: 5px;
        text-align: center;
    }
    .del-h4 {
        text-align: center;
    }
    .file {
        position: relative;
        display: inline-block;
        background: #D0EEFF;
        border: 1px solid #99D3F5;
        padding: 6px 12px;
        overflow: hidden;
        color: #1E88C7;
        text-decoration: none;
        text-indent: 0;
        line-height: 20px;
        margin: 0;
        width: 20%;
        text-align: center;
        height: 34px;
    }
    .file input {
        position: absolute;
        width: 100%;
        height: 100%;
        right: 0;
        top: 0;
        opacity: 0;
    }
    .file:hover {
        background: #AADFFD;
        border-color: #78C3F3;
        color: #004974;
        text-decoration: none;
    }
    @media only screen and (min-width: 100px) and (max-width: 640px) {
        .file {
            padding: 6px 0px;
        }
    }
</style>
<body class="gray-bg">
        <div class="gray-bg">
        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-12" style="padding-left: 0;padding-right: 0">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h2 style="display: inline-block">基本设置</h2>
                            <button type="button" onclick="location.reload();" id="loading-example-btn" class="btn btn-white btn-sm" style="float: right;"><i class="fa fa-refresh"></i> Refresh</button>
                        </div>
                        <fieldset class="form-horizontal">
                        <div class="ibox-content">
                            <form method="post" id="add-form" action="{{url('/dd/config')}}" enctype="multipart/form-data">
                                {{csrf_field()}}
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label class="col-sm-1 control-label" for="title">博客名称：</label>
                                        <div class="col-sm-11">
                                            <input type="text" value="{{$data ? $data->name : ''}}" name="name" class="form-control" placeholder="博客名称">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-1 control-label" for="title">博客icon标：</label>
                                        <div class="col-sm-11">
                                            <input type="text" value="{{$data ? $data->default_icon : ''}}" name="default_icon" class="form-control" placeholder="博客icon标">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-1 control-label" for="title">水印开关：</label>
                                        <div class="col-sm-11">
                                            <input class="water_status" id="water_status" @if($data && $data->water_status) checked @endif type="checkbox" name="water_status" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-1 control-label" for="title">水印内容：</label>
                                        <div class="col-sm-11">
                                            <input type="text" value="{{$data ? $data->water_text : ''}}" name="water_text" class="form-control" placeholder="水印内容">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-1 control-label" for="title">主要标题：</label>
                                        <div class="col-sm-11">
                                            <input type="text" value="{{$data ? $data->meta_title : ''}}" name="meta_title" class="form-control" placeholder="主要标题">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-1 control-label" for="title">主要关键字：</label>
                                        <div class="col-sm-11">
                                            <input type="text" value="{{$data ? $data->meta_keywords : ''}}" name="meta_keywords" class="form-control" placeholder="主要关键字">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-1 control-label" for="title">主要描述：</label>
                                        <div class="col-sm-11">
                                            <input type="text" value="{{$data ? $data->meta_description : ''}}" name="meta_description" class="form-control" placeholder="主要描述">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-1 control-label" for="title">文章页面标题：</label>
                                        <div class="col-sm-11">
                                            <input type="text" value="{{$data ? $data->article_title : ''}}" name="article_title" class="form-control" placeholder="">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-1 control-label" for="title">文章页面描述：</label>
                                        <div class="col-sm-11">
                                            <input type="text" value="{{$data ? $data->article_description : ''}}" name="article_description" class="form-control" placeholder="">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-1 control-label" for="title">文章显示条数：</label>
                                        <div class="col-sm-11">
                                            <input type="text" value="{{$data ? $data->article_number : ''}}" name="article_number" class="form-control" placeholder="">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-1 control-label" for="title">文章顺序：</label>
                                        <div class="col-sm-11">
                                            <input type="text" value="{{$data ? $data->article_sort : ''}}" name="article_sort " class="form-control" placeholder="文章顺序 desc倒序 asc正序">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-1 control-label" for="title">文章排序字段：</label>
                                        <div class="col-sm-11">
                                            <input type="text" value="{{$data ? $data->article_sortColumn : ''}}" name="article_sortColumn" class="form-control" placeholder="">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-1 control-label" for="title">底部github图标开关：</label>
                                        <div class="col-sm-11">
                                            <input class="footer_github_status" id="water_status" @if($data && $data->footer_github_status) checked @endif type="checkbox" name="footer_github_status" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-1 control-label" for="title">底部github图标地址：</label>
                                        <div class="col-sm-11">
                                            <input type="text" value="{{$data ? $data->footer_github_url : ''}}" name="footer_github_url" class="form-control" placeholder="">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-1 control-label" for="title">底部qq图标开关：</label>
                                        <div class="col-sm-11">
                                            <input class="footer_qq_status" @if($data && $data->footer_qq_status) checked @endif type="checkbox" name="footer_qq_status" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-1 control-label" for="title">底部qq图标地址：</label>
                                        <div class="col-sm-11">
                                            <input type="text" value="{{$data ? $data->footer_qq_url : ''}}" name="footer_qq_url" class="form-control" placeholder="">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-1 control-label" for="title">底部版权信息：</label>
                                        <div class="col-sm-11">
                                            <input type="text" value="{{$data ? $data->license : ''}}" name="license" class="form-control" placeholder="">
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" onclick="save($(this))" class="btn btn-primary">保存</button>
                                </div>
                            </form>
                        </div>
                        </fieldset>
                        <input type="hidden" id="flag" value="1">
                    </div>
                </div>
            </div>
        </div>
        </div>
    <!-- Mainly scripts -->
    <script src="/admin/js/jquery-2.1.1.js" charset="UTF-8"></script>
    <script src="/admin/js/bootstrap.min.js"></script>
    <script src="/admin/js/plugins/metisMenu/jquery.metisMenu.js"></script>
    <script src="/admin/js/plugins/slimscroll/jquery.slimscroll.min.js"></script>
    <script type="text/javascript" src="/admin/js/plugins/switchery/switchery.js"></script>

    <!-- self -->
    <script src="/admin/js/upload-img-show.js"></script>
    <script src="/admin/article.js"></script>
    <script src="/admin/plugins/toastr/toastr.min.js"></script>
    <script src="/admin/plugins/toastr/toastr.config.js"></script>

    <script>
        var elem1 = document.querySelector('.water_status');
        var switch1 = new Switchery(elem1);
        var elem2 = document.querySelector('.footer_github_status');
        var switch2 = new Switchery(elem2);
        var elem3 = document.querySelector('.footer_qq_status');
        var switch3 = new Switchery(elem3);

        function save(z) {
            var formData = new FormData($('#add-form')[0]);
            $.ajax({
                cache: false,
                contentType: false,
                processData: false,
                type: "POST",
                url: $("#add-form").attr('action'),
                data:formData,
                async: false,
                error: function(msg) {
                    if(msg.responseJSON.errors) {
                        for (x in msg.responseJSON.errors) {
                            toastr.error(msg.responseJSON.errors[x]);
                        }
                    } else if(msg.responseJSON.message) {
                        toastr.error(msg.responseJSON.message);
                    } else {
                        toastr.error('服务器错误');
                    }
                },
                success: function (msg) {
                    if (msg.code == 'error') {
                        notice(parent.error,msg.msg);
                    } else {
                        notice(parent.success,msg.msg);
                        location.reload();
                    }
                }
            });
        }

        function notice(fname, msg) {
            if (fname && typeof(fname) == 'function') {
                fname(msg);
            }
        }
    </script>
</body>

</html>
