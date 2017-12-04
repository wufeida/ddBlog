<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>后台管理 | 友链管理</title>

    <link href="/admin/css/bootstrap.min.css" rel="stylesheet">
    <link href="/admin/font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="/admin/css/plugins/iCheck/custom.css" rel="stylesheet">
    <link href="/admin/css/animate.css" rel="stylesheet">
    <link href="/admin/css/style.css" rel="stylesheet">
    <link href="/admin/css/plugins/viewer/viewer.min.css" rel="stylesheet">
    <link href="/admin/plugins/switch/css/bootstrap3/bootstrap-switch.min.css" rel="stylesheet">
    <link href="/admin/plugins/toastr/toastr.css" rel="stylesheet">


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
                            <button type="button" class="btn btn-success btn-sm add" data-toggle="modal" data-target="#formModal">添加友链</button>
                            <span style="color: red"> 拖动可以排序</span>
                            <button type="button" onclick="location.reload();" id="loading-example-btn" class="btn btn-white btn-sm" style="float: right;"><i class="fa fa-refresh"></i> Refresh</button>
                        </div>
                        <div class="ibox-content">

                            <table class="table table-hover table-striped">
                                <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th>图片</th>
                                    <th>名字</th>
                                    <th width="300">链接</th>
                                    <th>是否启用</th>
                                    <th>创建时间</th>
                                    <th class="text-center">操作</th>
                                </tr>
                                </thead>
                                <tbody id="dowebok">
                                @foreach($data as $v)
                                <tr id="{{$v->id}}" class="sort">
                                    <td class="text-center">{{$v->id}}</td>
                                    <td><img width="40" height="40" style="cursor: pointer" data-original="{{$v->image}}" src="{{$v->image}}" alt=""></td>
                                    <td>{{$v->name}}</td>
                                    <td>{{$v->link}}</td>
                                    <td>{{$v->status ? '已启用' : '已禁用'}}</td>
                                    <td>{{$v->created_at}}</td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-info edit btn-circle" data-toggle="modal" data-target="#formModal"><i class="glyphicon glyphicon-pencil"></i></button>
                                        <button type="button" class="btn btn-danger delete btn-circle" data-toggle="modal" data-target="#delModal"><i class="glyphicon glyphicon-trash"></i></button>
                                    </td>
                                </tr>
                                @endforeach
                                </tbody>

                            </table>

                        </div>

                    </div>
                </div>
            </div>
        </div>
        </div>
        <!--form Modal -->
        <div class="modal fade" id="formModal" tabindex="-1" role="dialog" aria-labelledby="add-label" aria-hidden="true" data-backdrop="static">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="add-label">添加友链</h4>
                    </div>
                    <div id="error" style="display: none;margin-bottom:0px">
                    </div>
                    <form method="post" id="add-form" action="{{ route('link.store') }}" enctype="multipart/form-data">
                        {{csrf_field()}}
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name">链接名</label>
                            <input type="text" id="name" name="name" class="form-control" placeholder="链接名">
                        </div>
                        <div class="form-group">
                            <label for="link">链接</label>
                            <input type="text" class="form-control" name="link" id="link" placeholder="链接">
                        </div>
                        <div class="form-group">
                            <label for="image">图片</label>
                            <div class="upload-box">
                                <div class="col-lg-12" style="float: left;padding: 0;width: 80%">
                                    <input type="text" class="form-control" id="image_url" name="image">
                                </div>
                                <a href="javascript:;" class="file">选择文件
                                    <input type="file" id="image">
                                </a>
                                <div id="preview1" class="preview">
                                    <img width="100" height="100" class="image" id="J_avatar1">
                                </div>
                                <div class="mask"><i class="ion-upload"></i></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="link">是否启用</label>
                            <div class="switch switch-small">
                                <input type="checkbox" id='status' name="status"/>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                        <button type="button" onclick="save($(this))" class="btn btn-primary">保存</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- delete modal -->
        <div class="modal fade" id="delModal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
            <div class="modal-dialog modal-sm" role="document">
                <div class="modal-content">
                    <form method="post" id="del-form">
                        {{csrf_field()}}
                        {{ method_field('DELETE') }}
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title del-h4" id="del-label">确认删除？</h4>
                        </div>
                        <div class="modal-footer del-footer">
                            <button type="button" class="btn btn-primary" data-dismiss="modal">取消</button>
                            <button type="button" onclick="del($(this))" class="btn btn-danger">确认</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    <!-- Mainly scripts -->
    <script src="/admin/js/jquery-2.1.1.js"></script>
    <script src="/admin/js/jquery-ui-1.10.4.min.js"></script>
    <script src="/admin/js/bootstrap.min.js"></script>
    <script src="/admin/js/plugins/metisMenu/jquery.metisMenu.js"></script>
    <script src="/admin/js/plugins/slimscroll/jquery.slimscroll.min.js"></script>
    <script type="text/javascript" src="/admin/plugins/webuploader/webuploader.js"></script>

    <!-- self -->
    <script src="/admin/js/layer/layer.js"></script>
    <script src="/admin/js/viewer/viewer.min.js"></script>
    <script src="/admin/js/upload-img-show.js"></script>
    <script src="/admin/plugins/toastr/toastr.min.js"></script>
    <script src="/admin/plugins/toastr/toastr.config.js"></script>
    <script src="/admin/plugins/switch/js/bootstrap-switch.min.js"></script>
    <script src="/admin/link.js"></script>
    <script>
        window.Laravel = {
            csrfToken: "{{ csrf_token() }}"
        }

        var fixHelper = function(e, ui) {
            //console.log(ui)
            ui.children().each(function() {
                $(this).width($(this).width());  //在拖动时，拖动行的cell（单元格）宽度会发生改变。在这里做了处理就没问题了
            });
            return ui;
        };
        //排序功能
        $(document).ready(function(){
            $("#dowebok").sortable({
                cursor: "move",
                helper: fixHelper,
                update: function( event, ui ) {
                    var arr = $( "#dowebok" ).sortable( "toArray" );
                    var url = '/dd/link/sort';
                    console.log(arr)
                    $.ajax({
                        type: "POST",
                        url: url,
                        headers:{
                            'X-CSRF-TOKEN': window.Laravel.csrfToken,
                        },
                        data:{'data':arr},
                        async: true,
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
                            toastr.success('排序成功');
                        }
                    });
                }
            }).disableSelection();

        });
        //初始化开关键
        function initSwitch() {
            $('#status').removeAttr('checked');
            $("[name='status']").bootstrapSwitch();
        }
        initSwitch();

        $("#formModal").on("shown.bs.modal",function(){
            var uploader = WebUploader.create({

                // 选完文件后，是否自动上传。
                auto: true,

                // swf文件路径
                swf: '/admin/plugins/webuploader/js/Uploader.swf',

                // 文件接收服务端。
                server: '/dd/file/upload',

                // 选择文件的按钮。可选。
                // 内部根据当前运行是创建，可能是input元素，也可能是flash.
                pick: '.file',

                // 只允许选择图片文件。
                accept: {
                    title: 'Images',
                    extensions: 'gif,jpg,jpeg,bmp,png',
                    mimeTypes: 'image/*'
                }
            });
            uploader.on('beforeFileQueued', function (file) {
                uploader.reset();
                previewImage(file.source.source,'preview1','J_avatar1');
            });
            uploader.on('uploadSuccess', function (file,response) {
                if (response.success) {
                    $('#image_url').val(response.url);
                } else {
                    toastr.error('上传失败');
                }
            });
        });
    </script>
</body>

</html>
