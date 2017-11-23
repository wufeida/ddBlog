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
    <link href="/admin/css/plugins/viewer/viewer.min.css" rel="stylesheet">
    <link href="/admin/plugins/toastr/toastr.css" rel="stylesheet">
    <link href="/admin/css/plugins/dropzone/basic.css" rel="stylesheet">
    <link href="/admin/css/plugins/dropzone/dropzone.css" rel="stylesheet">

</head>

<body class="gray-bg">
    <div id="wrapper">
            <div class="row wrapper border-bottom white-bg page-heading" style="padding: 10px 10px;">
                <div class="col-xs-5">
                    <ol class="breadcrumb">
                        @if($data['breadcrumbs'] == false)
                        <li class="active" >
                            <a><strong>root</strong></a>
                        </li>
                        @else
                            @foreach($data['breadcrumbs'] as $k=>$v)
                                <li>
                                    <a href="{{url('dd/file').'/?folder='.$k}}">{{$v}}</a>
                                </li>
                            @endforeach
                                <li class="active">
                                    <strong>{{$data['folderName']}}</strong>
                                </li>
                        @endif
                    </ol>
                </div>
                <button type="button" onclick="location.reload();" id="loading-example-btn" class="btn btn-white btn-xs" style="float: right;margin-right: 15px;"><i class="fa fa-refresh"></i> Refresh</button>
            </div>
        <div class="wrapper wrapper-content">
            <div class="row">
                <div class="col-lg-3">
                    <div class="ibox float-e-margins">
                        <div class="ibox-content">
                            <div class="file-manager">
                                <div class="hr-line-dashed"></div>
                                <button class="btn btn-primary btn-block" data-toggle="modal" data-target="#uploadModal">上传文件</button>
                                <div class="hr-line-dashed"></div>

                                <h5 style="display: inline-block">文件夹</h5>
                                <button class="btn btn-file btn-xs" style="float: right" data-toggle="modal" data-target="#formModal">创建文件夹</button>
                                <ul class="folder-list" style="padding: 0">
                                    @if($data['subfolders'] == false)
                                        没有了！！！
                                    @endif
                                    @foreach($data['subfolders'] as $k=>$v)
                                    <li>
                                        <a style="display: inline-block" href="{{url('dd/file').'/?folder='.$k}}">
                                            <i class="fa fa-folder"></i>
                                            <span>{{$v}}</span>
                                        </a>
                                        <button data-toggle="modal" data-target="#delModal" class="btn btn-danger btn-xs delete" style="float: right;margin: 3px 0 0;">
                                            <i class="glyphicon glyphicon-trash" style="margin-right: 0;color: white"></i>
                                        </button>
                                    </li>
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
                            @foreach($data['files'] as $v)
                            <div class="file-box">
                                <a target="_blank" href="{{$v['webPath']}}">
                                <div class="file">
                                    <span class="corner"></span>
                                    @if(is_image($v['mimeType']))
                                        <div class="image">
                                            <img alt="image" class="img-responsive" src="{{$v['webPath']}}">
                                        </div>
                                    @else
                                        <div class="icon">
                                        <i class="fa fa-file"></i>
                                        </div>
                                    @endif
                                    <div class="file-name">
                                        <span title="{{$v['name']}}">{{str_limit($v['name'], $limit = 18, $end = '...')}}</span>
                                        <br/>
                                        <small>{{$v['size']}}</small>
                                        <div style="float: right">
                                            <a class="btn btn-danger btn-xs btn-bitbucket del" data-folder="{{$data['folder']}}" data-name="{{$v['name']}}" onclick="delFile($(this))" title="永久删除？">
                                                <i class="glyphicon glyphicon-trash"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                </a>
                            </div>
                            @endforeach
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
                    <h4 class="modal-title" id="add-label">创建文件夹</h4>
                </div>
                <div id="error" style="display: none;margin-bottom:0px">
                </div>
                <form method="post" id="add-form" action="{{ url('dd/folder') }}" enctype="multipart/form-data">
                    {{csrf_field()}}
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="up_cname">文件夹名称</label>
                            <input type="text" id="folder" name="name" class="form-control" placeholder="文件夹名称">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                        <button type="button" onclick="save($(this))" data-folder="{{$data['folder']}}" class="btn btn-primary">保存</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!--form Modal -->
    <div class="modal fade" id="uploadModal" tabindex="-1" role="dialog" aria-labelledby="add-label" aria-hidden="true" data-backdrop="static">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="add-label">上传文件</h4>
                </div>
                <form id="my-awesome-dropzone" class="dropzone" action="{{url('dd/upload')}}" enctype="multipart/form-data">
                    {{csrf_field()}}
                    <input type="hidden" name="folder" value="{{$data['folder']}}">
                    <div class="dropzone-previews"></div>
                    <button type="submit" class="btn btn-primary pull-right">Submit this form!</button>
                </form>
            </div>
        </div>
    </div>
    <!-- delete modal -->
    <div class="modal fade" id="delModal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <form method="post" id="del-form" action="{{url('dd/folder')}}">
                    {{csrf_field()}}
                    {{ method_field('DELETE') }}
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title del-h4" id="del-label">确认删除？</h4>
                    </div>
                    <div class="modal-footer del-footer">
                        <button type="button" class="btn btn-primary" data-dismiss="modal">取消</button>
                        <button type="button" onclick="del($(this))" id="del-info" data-folder="{{$data['folder']}}" class="btn btn-danger">确认</button>
                    </div>
                </form>
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
    <script src="/admin/js/viewer/viewer.min.js"></script>
    <script src="/admin/plugins/toastr/toastr.min.js"></script>
    <script src="/admin/plugins/toastr/toastr.config.js"></script>
    <script src="/admin/js/plugins/pace/pace.min.js"></script>
    <script src="/admin/js/plugins/dropzone/dropzone.js"></script>


    <script>
        // 拖拽上传设置
        $(document).ready(function(){
            Dropzone.options.myAwesomeDropzone = {
                autoProcessQueue: false,
                uploadMultiple: true,
                parallelUploads: 100,
                maxFiles: 100,
                // Dropzone settings
                init: function() {
                    var myDropzone = this;

                    this.element.querySelector("button[type=submit]").addEventListener("click", function(e) {
                        e.preventDefault();
                        e.stopPropagation();
                        myDropzone.processQueue();
                    });
                    this.on("sendingmultiple", function() {
                    });
                    this.on("successmultiple", function(files, response) {
                        console.log(response)
                        var le = response.length;
                        for (var i=0; i<le; i++) {
                            if (!response[i].success) {
                                toastr.error(response[i]);
                            } else {
                                toastr.success(response[i].filename+'上传成功');
                            }
                        }
                    });
                    this.on("errormultiple", function(files, response) {
                        toastr.error(response.message);
                    });
                }
            }
        });

        $(document).ready(function(){
            $('.file-box').each(function() {
                animationHover(this, 'pulse');
            });
        });

        //点击添加按钮
        $(document).on("click", ".add", function () {
            $('#folder').val('');
        })

        //确认保存数据
        function save(z) {
            var formData = new FormData($('#add-form')[0]);
            var name = $('#folder').val();
            var parentFloder = z.attr('data-folder');
            formData.append('folder',parentFloder+'/'+name);
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
                    notice(parent.success, '成功');
                    location.reload();
                }
            });
        }

        //点击删除按钮
        $(document).on("click", ".delete", function () {
            var name = $(this).parent().children().children().eq(1).html();
            $('#del-info').attr('data-name',name);
        })

        //确认删除文件夹
        function del(z) {
            var formData = new FormData($('#del-form')[0]);
            var parentFloder = z.attr('data-folder');
            var name = z.attr('data-name');
            formData.append('folder',parentFloder+'/'+name);
            $.ajax({
                cache: false,
                contentType: false,
                processData: false,
                type: "POST",
                url: $("#del-form").attr('action'),
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
                    notice(parent.success, '删除成功');
                    location.reload();
                }
            });
        }

        //确认删除文件
        function delFile(z) {
            var parentFloder = z.attr('data-folder');
            var name = z.attr('data-name');
            $.ajax({
                type: "GET",
                url: '/dd/file/delete',
                data:{'path': parentFloder+'/'+name},
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
                    notice(parent.success, '删除成功');
                    location.reload();
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
