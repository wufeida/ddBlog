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
                    <ul class="notes">
                        @foreach($data as $v)
                        <li>
                            <div>
                                <small>{{$v->created_at}}</small>
                                <h4>{{$v->name}}</h4>
                                <p>{{$v->content}}</p>
                                <a style="right: 30px" data-toggle="modal" data-target="#formModal"><i class="glyphicon glyphicon-pencil"></i></a>
                                <a><i class="fa fa-trash-o "></i></a>
                            </div>
                        </li>
                        @endforeach
                    </ul>
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
    <!-- Mainly scripts -->
    <script src="/admin/js/jquery-2.1.1.js"></script>
    <script src="/admin/js/bootstrap.min.js"></script>
    <script src="/admin/js/plugins/metisMenu/jquery.metisMenu.js"></script>
    <script src="/admin/js/plugins/slimscroll/jquery.slimscroll.min.js"></script>

    <!-- Custom and plugin javascript -->
    <script src="/admin/js/inspinia.js"></script>
    <script src="/admin/js/plugins/pace/pace.min.js"></script>

    <script src="/admin/note.js"></script>

</body>

</html>
