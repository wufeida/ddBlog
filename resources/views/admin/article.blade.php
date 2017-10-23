<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>哒哒后台管理 | 文章管理</title>

    <link href="/admin/css/bootstrap.min.css" rel="stylesheet">
    <link href="/admin/font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="/admin/css/plugins/iCheck/custom.css" rel="stylesheet">
    <link href="/admin/css/animate.css" rel="stylesheet">
    <link href="/admin/css/style.css" rel="stylesheet">
    <link href="/admin/css/plugins/viewer/viewer.min.css" rel="stylesheet">
    <link href="/admin/css/plugins/markdown-edit/simplemde.min.css" rel="stylesheet">

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
</style>
<body class="gray-bg">
        <div class="gray-bg">
        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-12" style="padding-left: 0;padding-right: 0">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <a href="{{url('dd/article/create')}}" class="btn btn-success btn-sm">添加文章</a>
                            <button type="button" onclick="location.reload();" id="loading-example-btn" class="btn btn-white btn-sm" style="float: right;"><i class="fa fa-refresh"></i> Refresh</button>
                        </div>
                        <div class="ibox-content">

                            <table class="table table-hover table-striped">
                                <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th>标题</th>
                                    <th>副标题</th>
                                    <th>发布时间</th>
                                    <th class="text-center">操作</th>
                                </tr>
                                </thead>
                                <tbody id="dowebok">
                                @foreach($data as $v)
                                <tr>
                                    <td class="text-center">{{$v->id}}</td>
                                    <td>{{$v->title}}</td>
                                    <td>{{$v->subtitle}}</td>
                                    <td>{{$v->created_at}}</td>
                                    <td class="text-center">
                                        <a target="_blank" class="btn btn-success edit btn-circle"><i class="glyphicon glyphicon-eye-open"></i></a>
                                        <a href="{{url('dd/article/'.$v->id.'/edit')}}" class="btn btn-info edit btn-circle"><i class="glyphicon glyphicon-pencil"></i></a>
                                        <button type="button" class="btn btn-danger delete btn-circle" data-toggle="modal" data-target="#delModal"><i class="glyphicon glyphicon-trash"></i></button>
                                    </td>
                                </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div style="float: right;">
                            {{ $data->links() }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
        </div>
        <!--form Modal -->
        <div class="modal fade" id="formModal" tabindex="-1" role="dialog" aria-labelledby="add-label" aria-hidden="true" data-backdrop="static">
            <div class="modal-dialog" style="margin-bottom: 200px;" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="add-label">添加文章</h4>
                    </div>
                    <div id="error" style="display: none;margin-bottom:0px">
                    </div>
                    <form method="post" id="add-form" action="{{ route('article.store') }}" enctype="multipart/form-data">
                        {{csrf_field()}}
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="title">标题</label>
                            <input type="text" id="title" name="title" class="form-control" placeholder="标题">
                        </div>
                        <div class="form-group">
                            <label for="subtitle">副标题</label>
                            <input type="text" id="subtitle" name="subtitle" class="form-control" placeholder="副标题">
                        </div>
                        <div class="form-group">
                            <label for="up_cdes">分类</label>
                            <select name="category_id" class="form-control">
                                <option value="1">1</option>
                                <option>2</option>
                                <option>3</option>
                                <option>4</option>
                                <option>5</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="image">页面图片</label>
                            <div class="upload-box">
                                <input type="file" class="form-control" id="page_image" name="page_image" onchange="previewImage(this,'preview1','J_avatar1')">
                                <div id="preview1" class="preview">
                                    <img width="100" height="100" class="image" id="J_avatar1">
                                </div>
                                <div class="mask"><i class="ion-upload"></i></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="content">内容</label>
                            <textarea name="content" id="editor"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="up_cdes">标签</label>
                            <input class="form-control" type="text">
                        </div>
                        <div class="form-group">
                            <label for="content">主要描述</label>
                            <textarea class="form-control" name="meta_description"></textarea>
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

    <!-- self -->
    <script src="/admin/js/layer/layer.js"></script>
    <script src="/admin/js/viewer/viewer.min.js"></script>
    <script src="/admin/js/upload-img-show.js"></script>
    <script src="/admin/article.js"></script>
    <script src="/admin/js/plugins/markdown-edit/simplemde.min.js"></script>
</body>

</html>
