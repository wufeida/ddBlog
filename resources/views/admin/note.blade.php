<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>后台管理 | 便签管理</title>

    <link href="/admin/css/bootstrap.min.css" rel="stylesheet">
    <link href="/admin/font-awesome/css/font-awesome.css" rel="stylesheet">

    <link href="/admin/css/animate.css" rel="stylesheet">
    <link href="/admin/css/style.css" rel="stylesheet">
    <link href="/admin/plugins/toastr/toastr.css" rel="stylesheet">
    <link rel="stylesheet" href="/admin/css/normalize.css">
    <link rel="stylesheet" type="text/css" href="/admin/css/default.css">
    <style type="text/css">
        #gallery-wrapper {
            position: relative;
            max-width: 75%;
            width: 75%;
            margin:20px auto;
        }
        .white-panel {
            position: absolute;
            background: white;
            border-radius: 5px;
            box-shadow: 0px 1px 2px rgba(0,0,0,0.3);
            padding: 10px;
        }
        .white-panel h1 {
            font-size: 1em;
        }
        .white-panel h1 a {
            color: #A92733;
        }
        .white-panel:hover {
            box-shadow: 1px 1px 10px rgba(0,0,0,0.5);
            margin-top: -5px;
            -webkit-transition: all 0.3s ease-in-out;
            -moz-transition: all 0.3s ease-in-out;
            -o-transition: all 0.3s ease-in-out;
            transition: all 0.3s ease-in-out;
        }
    </style>
    <!--[if IE]>
    <script src="http://cdn.bootcss.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <![endif]-->
</head>

<body class="gray-bg">

    <div id="wrapper">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox-title">
                    <button type="button" class="btn btn-success btn-sm add" data-toggle="modal" data-target="#formModal">添加便签</button>
                    <button type="button" onclick="location.reload();" id="loading-example-btn" class="btn btn-white btn-sm" style="float: right;"><i class="fa fa-refresh"></i> Refresh</button>
                </div>
                <div class="wrapper wrapper-content animated fadeInUp">
                    <section id="gallery-wrapper">
                        @foreach($data as $v)
                        <article class="white-panel" data-id="{{$v->id}}">
                            <p class="thumb" style="color: black">{{$v->content}}</p>
                            <h1><a>{{$v->name}}</a></h1>
                            <p style="color: grey">{{$v->created_at->diffForHumans()}}创建</p>
                            <a style="right: 30px;" class="edit" data-toggle="modal" data-target="#formModal"><i class="glyphicon glyphicon-pencil"></i></a>
                            <a data-toggle="modal" data-target="#delModal" class="delete"><i class="fa fa-trash-o"></i></a>
                            <div class="dropdown" style="float: right;width: 15px;height: 10px;margin-top: 5px">
                                <a data-toggle="dropdown" class="dropdown-toggle">
                                    <button class="btn btn-circle @if($v->status == 3) btn-danger @elseif($v->status == 1) btn-success @elseif($v->status == 2) btn-info @endif" class="note-status" style="width: 15px;height: 10px"></button>
                                </a>
                                <ul class="dropdown-menu animated fadeInRight m-t-xs" data-id="{{$v->id}}">
                                    <li><a class="status" data-status="3"><button class="btn btn-danger btn-circle" style="width: 15px;height: 10px;margin-right: 10px"></button>还未开始</a></li>
                                    <li><a class="status" data-status="2"><button class="btn btn-info btn-circle" style="width: 15px;height: 10px;margin-right: 10px"></button>正在进行</a></li>
                                    <li><a class="status" data-status="1"><button class="btn btn-success btn-circle" style="width: 15px;height: 10px;margin-right: 10px"></button>已经完成</a></li>
                                </ul>
                            </div>
                        </article>
                        @endforeach
                    </section>
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
                    <h4 class="modal-title" id="add-label">添加便签</h4>
                </div>
                <div id="error" style="display: none;margin-bottom:0px">
                </div>
                <form method="post" id="add-form" action="{{ route('note.store') }}">
                    {{csrf_field()}}
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name">便签名称</label>
                            <input type="text" id="name" name="name" class="form-control" placeholder="便签名称">
                        </div>
                        <div class="form-group">
                            <label for="link">便签内容</label>
                            <textarea name="content" id="content" cols="30" rows="10" class="form-control"></textarea>
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
    <script src="/admin/js/bootstrap.min.js"></script>
    <script src="/admin/js/plugins/metisMenu/jquery.metisMenu.js"></script>
    <script src="/admin/js/plugins/slimscroll/jquery.slimscroll.min.js"></script>

    <!-- Custom and plugin javascript -->
    <script src="/admin/js/inspinia.js"></script>
    <script src="/admin/js/plugins/pace/pace.min.js"></script>
    <script src="/admin/plugins/toastr/toastr.min.js"></script>
    <script src="/admin/plugins/toastr/toastr.config.js"></script>
    <script src="/admin/note.js"></script>
    <script src="/admin/js/pinterest_grid.js"></script>
    <script type="text/javascript">
        $(function(){
            $("#gallery-wrapper").pinterest_grid({
                no_columns: 4,
                padding_x: 10,
                padding_y: 10,
                margin_bottom: 50,
                single_column_breakpoint: 700
            });
        });
    </script>
</body>

</html>
