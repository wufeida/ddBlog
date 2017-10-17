<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>哒哒后台管理 | 分类管理</title>

    <link href="/admin/css/bootstrap.min.css" rel="stylesheet">
    <link href="/admin/font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="/admin/css/plugins/iCheck/custom.css" rel="stylesheet">
    <link href="/admin/css/animate.css" rel="stylesheet">
    <link href="/admin/css/style.css" rel="stylesheet">

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
                <div class="col-lg-12">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <button type="button" class="btn btn-success btn-sm add-categories" data-toggle="modal" data-target="#formModal">添加分类</button>
                            <a onclick="location.reload();" class="glyphicon glyphicon-refresh" style="float: right;color: green;font-size: 25px"></a>
                        </div>
                        <div class="ibox-content">

                            <table class="table table-hover">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>名称</th>
                                    <th>描述</th>
                                    <th>图片</th>
                                    <th>添加时间</th>
                                    <th>更新时间</th>
                                    <th>操作</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($data as $v)
                                <tr>
                                    <td>{{$v->id}}</td>
                                    <td>{{$v->name}}</td>
                                    <td>{{$v->description}}</td>
                                    <td>{{$v->image_url}}</td>
                                    <td>{{$v->created_at}}</td>
                                    <td>{{$v->updated_at}}</td>
                                    <td>
                                        <button type="button" class="btn btn-info btn-xs up-categories" data-toggle="modal" data-target="#formModal">编辑</button>
                                        <button type="button" class="btn btn-danger btn-xs del-categories" data-toggle="modal" data-target=".delModal">删除</button>
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
        <div class="modal fade" id="formModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">分类修改</h4>
                    </div>
                    <div id="error" style="display: none;margin-bottom:0px">
                    </div>
                    <form method="post" id="cate-form" action="{{ route('categories.store') }}" enctype="multipart/form-data">
                        {{csrf_field()}}
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="up_cname">分类名称</label>
                            <input type="text" id="up_cname" name="name" class="form-control" placeholder="分类名称">
                        </div>
                        <div class="form-group">
                            <label for="up_cdes">描述</label>
                            <input type="text" class="form-control" name="description" id="up_cdes" placeholder="描述">
                        </div>
                        <div class="form-group">
                            <label for="InputFile">分类图片</label>
                            <input type="file" id="InputFile" name="file">
                            <p class="help-block">Example block-level help text here.</p>
                        </div>
                        <div class="form-group">
                            <label for="up_cpath">分类地址</label>
                            <input type="text" id="up_cpath" name="path" class="form-control">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                        <button type="button" onclick="saveCate($(this))" class="btn btn-primary">保存</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- delete modal -->
        <div class="modal fade delModal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
            <div class="modal-dialog modal-sm" role="document">
                <div class="modal-content">
                    <form method="post" id="del-form">
                        {{csrf_field()}}
                        {{ method_field('DELETE') }}
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title del-h4" id="myModalLabel">确认删除？</h4>
                        </div>
                        <div class="modal-footer del-footer">
                            <button type="button" class="btn btn-primary" data-dismiss="modal">取消</button>
                            <button type="button" onclick="delCate($(this))" class="btn btn-danger">确认</button>
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

    <!-- Peity -->
    <script src="/admin/js/plugins/peity/jquery.peity.min.js"></script>

    <!-- Custom and plugin javascript -->
    <script src="/admin/js/inspinia.js"></script>
    <script src="/admin/js/plugins/pace/pace.min.js"></script>

    <!-- iCheck -->
    <script src="/admin/js/plugins/iCheck/icheck.min.js"></script>

    <!-- Peity -->
    <script src="/admin/js/demo/peity-demo.js"></script>
    <script src="/admin/js/layer/layer.js"></script>

    <script>
        $(document).ready(function(){
            $('.i-checks').iCheck({
                checkboxClass: 'icheckbox_square-green',
                radioClass: 'iradio_square-green',
            });
        });
        //点击编辑按钮
        $(document).on("click", ".up-categories", function () {
            $('#error').html('')
            var id = $(this).parent().parent().children().eq(0).html();
            var url = "/dd/categories/"+id+"/edit"
            $.getJSON(url, function(msg){
                $('#up_cname').val(msg.name)
                $('#up_cdes').val(msg.description)
                $('#up_cpath').val(msg.path)
                var up_url = "/dd/categories/"+msg.id
                $('#cate-form').attr('action',up_url)
                var put = '<input id="put" type="hidden" name="_method" value="PUT">'
                $('#cate-form').append(put)
            })
        })
        //点击删除按钮
        $(document).on("click", ".del-categories", function () {
            var id = $(this).parent().parent().children().eq(0).html();
            var url = "/dd/categories/"+id;
            $('#del-form').attr('action',url)
        })
        //点击添加按钮
        $(document).on("click", ".add-categories", function () {
            $('#error').html('')
            $('#up_cname').val('')
            $('#up_cdes').val('')
            $('#up_cpath').val('')
            var add_url = "/dd/categories";
            $('#cate-form').attr('action',add_url)
            $('#put').remove()
        })
        //确认保存数据
        function saveCate(z) {
            var formData = new FormData($('#cate-form')[0]);
            $.ajax({
                cache: false,
                contentType: false,
                processData: false,
                type: "POST",
                url: $("#cate-form").attr('action'),
                data:formData,
                async: false,
                error: function(msg) {
                    if(msg.responseJSON.errors) {
                        var str = '';
                        for (x in msg.responseJSON.errors) {
                            str += "<div class='alert alert-danger'>";
                            str += msg.responseJSON.errors[x];
                            str += "</div>";
                        }
                        if (str) {
                            $('#error').append(str)
                            $('#error').css('display','block');
                        }
                    }
                },
                success: function (msg) {
                    location.reload();
                }
            });
        }
        //确认删除
        function delCate(z) {
            var formData = new FormData($('#del-form')[0]);
            $.ajax({
                cache: false,
                contentType: false,
                processData: false,
                type: "POST",
                url: $("#del-form").attr('action'),
                data:formData,
                async: false,
                error: function(msg) {
                    layer.alert('删除失败', {icon: 5}, function () {
                        location.reload();
                    });
                },
                success: function (msg) {
                    location.reload();
                }
            });
        }

    </script>

</body>

</html>
