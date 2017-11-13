<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>后台管理 | 分类管理</title>

    <link href="/admin/css/bootstrap.min.css" rel="stylesheet">
    <link href="/admin/font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="/admin/css/plugins/iCheck/custom.css" rel="stylesheet">
    <link href="/admin/css/animate.css" rel="stylesheet">
    <link href="/admin/css/style.css" rel="stylesheet">
    <link href="/admin/css/plugins/viewer/viewer.min.css" rel="stylesheet">
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
    }
    .file input {
        position: absolute;
        font-size: 100px;
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
</style>
<body class="gray-bg">
        <div class="gray-bg">
        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-12" style="padding-left: 0;padding-right: 0">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <button type="button" class="btn btn-success btn-sm add" data-toggle="modal" data-target="#formModal">添加分类</button>
                            <button type="button" onclick="location.reload();" id="loading-example-btn" class="btn btn-white btn-sm" style="float: right;"><i class="fa fa-refresh"></i> Refresh</button>
                        </div>
                        <div class="ibox-content">

                            <table class="table table-hover">
                                <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th>名称</th>
                                    <th>描述</th>
                                    <th>图片</th>
                                    <th>添加时间</th>
                                    <th>更新时间</th>
                                    <th class="text-center">操作</th>
                                </tr>
                                </thead>
                                <tbody id="dowebok">
                                @foreach($data as $v)
                                <tr>
                                    <td class="text-center">{{$v->id}}</td>
                                    <td>{{$v->name}}</td>
                                    <td>{{$v->description}}</td>
                                    <td><img width="40" height="40" style="cursor: pointer" data-original="{{$v->image_url}}" src="{{$v->image_url}}" alt=""></td>
                                    <td>{{$v->created_at}}</td>
                                    <td>{{$v->updated_at}}</td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-info edit btn-circle" data-toggle="modal" data-target="#formModal"><i class="glyphicon glyphicon-pencil"></i></button>
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
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="add-label">添加分类</h4>
                    </div>
                    <div id="error" style="display: none;margin-bottom:0px">
                    </div>
                    <form method="post" id="add-form" action="{{ route('category.store') }}" enctype="multipart/form-data">
                        {{csrf_field()}}
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="up_cname">分类名称</label>
                            <input type="text" id="name" name="name" class="form-control" placeholder="分类名称">
                        </div>
                        <div class="form-group">
                            <label for="up_cdes">描述</label>
                            <input type="text" class="form-control" name="description" id="description" placeholder="描述">
                        </div>
                        <div class="form-group">
                            <label for="image">分类图片</label>
                            <div class="upload-box">
                                <div class="col-lg-12" style="float: left;padding: 0;width: 80%">
                                    <input type="text" class="form-control" name="image">
                                </div>
                                <a href="javascript:;" class="file">选择文件
                                    <input type="file" name="" id="" id="image" name="image" onchange="previewImage(this,'preview1','J_avatar1')">
                                </a>

                                {{--<input type="file" class="form-control" id="image" name="image" onchange="previewImage(this,'preview1','J_avatar1')">--}}
                                <div id="preview1" class="preview">
                                <img width="100" height="100" class="image" id="J_avatar1">
                                </div>
                                <div class="mask"><i class="ion-upload"></i></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="up_cpath">分类地址</label>
                            <input type="text" id="path" name="path" class="form-control">
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
    <script src="/admin/plugins/toastr/toastr.min.js"></script>
    <script src="/admin/plugins/toastr/toastr.config.js"></script>
    <script src="/admin/category.js"></script>
</body>

</html>
