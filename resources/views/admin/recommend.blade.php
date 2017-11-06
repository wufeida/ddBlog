<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>后台管理 | 推荐文章管理</title>

    <link href="/admin/css/bootstrap.min.css" rel="stylesheet">
    <link href="/admin/font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="/admin/css/plugins/iCheck/custom.css" rel="stylesheet">
    <link href="/admin/css/animate.css" rel="stylesheet">
    <link href="/admin/css/style.css" rel="stylesheet">
    <link href="/admin/css/plugins/viewer/viewer.min.css" rel="stylesheet">
    <link href="/admin/plugins/switch/css/bootstrap3/bootstrap-switch.min.css" rel="stylesheet">
    <link href="/admin/css/plugins/markdown-edit/simplemde.min.css" rel="stylesheet">
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
    .highlight{
        color: #1a1a1a;
        background-color: #4472C4;
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
                        <table class="table table-hover " >
                            <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th>标题</th>
                                <th>副标题</th>
                                <th>发布时间</th>
                                <th>创建时间</th>
                                <th>是否推荐</th>
                                <th class="text-center">操作</th>
                            </tr>
                            </thead>
                            <tbody id="dowebok">
                            @foreach($data as $v)
                                <tr id="{{$v->id}}" class="sort">
                                    <td class="text-center id">{{$v->id}}</td>
                                    <td>{{$v->title}}</td>
                                    <td>{{$v->subtitle}}</td>
                                    <td>{{$v->publish_at}}</td>
                                    <td>{{$v->created_at}}</td>
                                    <td>
                                        <div class="switch switch-small">
                                            <input type="checkbox" @if($v['is_recommend']) checked @endif  name="is_recommend"/>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <a href="{{url("/$v->slug")}}" target="_blank" class="btn btn-success edit btn-circle"><i class="glyphicon glyphicon-eye-open"></i></a>
                                        <a href="{{url('dd/article/'.$v->id.'/edit')}}" class="btn btn-info edit btn-circle"><i class="glyphicon glyphicon-pencil"></i></a>
                                        <button type="button" class="btn btn-danger delete btn-circle" data-toggle="modal" data-target="#delModal"><i class="glyphicon glyphicon-trash"></i></button>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div style="float: right;">
                    </div>
                </div>
            </div>
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

<!-- self -->
<script src="/admin/js/layer/layer.js"></script>
<script src="/admin/js/viewer/viewer.min.js"></script>
<script src="/admin/js/upload-img-show.js"></script>
<script src="/admin/js/jquery.tablednd-0.5.js"></script>
<script src="/admin/js/plugins/markdown-edit/simplemde.min.js"></script>
<script src="/admin/plugins/toastr/toastr.min.js"></script>
<script src="/admin/plugins/toastr/toastr.config.js"></script>
<script src="/admin/plugins/switch/js/bootstrap-switch.min.js"></script>
<script src="/admin/article.js"></script>
<script>
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
                var url = '/dd/sort';
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
//                          location.reload();
                        }
                    });
            }
        }).disableSelection();

    });
    // 开关按钮
    $("[name='is_recommend']").bootstrapSwitch({
        size:'small',
        onText:'YES',
        offText:'NO'
    });

    window.Laravel = {
        csrfToken: "{{ csrf_token() }}"
    }
    //是否推荐按钮
    $("[name='is_recommend']").on('switchChange.bootstrapSwitch', function (event,state) {
        var id = $(this).parents('tr').find('.id').html();
        var url = '/dd/recommend/'+id;
        var is_recommend = state;
        $.ajax({
            type: "POST",
            url: url,
            headers:{
                'X-CSRF-TOKEN': window.Laravel.csrfToken,
            },
            data:{'is_recommend':is_recommend},
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
                if (state == true) {
                    notice(parent.success, '推荐成功');
                    location.reload();
                } else {
                    notice(parent.success, '关闭推荐');
                    location.reload();
                }

            }
        });
    });
</script>
</body>

</html>
