<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>后台管理 | 回收站</title>

    <link href="/admin/css/bootstrap.min.css" rel="stylesheet">
    <link href="/admin/font-awesome/css/font-awesome.css" rel="stylesheet">

    <link href="/admin/css/animate.css" rel="stylesheet">
    <link href="/admin/css/style.css" rel="stylesheet">

</head>
<body class="gray-bg">
    <div class="wrapper wrapper-content">
            <div class="row">
                <div class="ibox-title">
                    <h2 style="display: inline-block">回收站</h2>
                    <button type="button" onclick="location.reload();" id="loading-example-btn" class="btn btn-white btn-sm" style="float: right;margin-left: 5px;"><i class="fa fa-refresh"></i> Refresh</button>
                    <button type="button" data-toggle="modal" data-target="#delModal" id="loading-example-btn" class="btn btn-danger btn-sm" style="float: right;margin-left: 5px;"><i class="glyphicon glyphicon-trash"></i> 清空回收站</button>
                    <button type="button" data-toggle="modal" data-target="#resetModal" id="loading-example-btn" class="btn btn-info btn-sm" style="float: right;"><i class="fa fa-undo"></i> 还原所有</button>
                </div>
                <div class="row m-t-lg" style="margin-top: 0">
                    <div class="col-lg-12">
                        <div class="tabs-container">
                                <ul class="nav nav-tabs">
                                    <li class="active"><a data-toggle="tab" href="#tab-1"><i class="fa fa-file-archive-o"></i>所有内容</a></li>
                                    <li class=""><a data-toggle="tab" href="#tab-2"><i class="fa fa-file-word-o"></i>文章列表</a></li>
                                    <li class=""><a data-toggle="tab" href="#tab-3"><i class="fa fa-list-alt"></i>分类列表</a></li>
                                    <li class=""><a data-toggle="tab" href="#tab-4"><i class="fa fa-tags"></i>标签列表</a></li>
                                    <li class=""><a data-toggle="tab" href="#tab-5"><i class="fa fa-link"></i>友情链接</a></li>
                                    <li class=""><a data-toggle="tab" href="#tab-6"><i class="fa fa-comments"></i>评论列表</a></li>
                                </ul>
                                <div class="tab-content">
                                    <div id="tab-1" class="tab-pane active">
                                        <div class="panel-body da-body">
                                            <div class="col-lg-12 animated fadeInRight">
                                                <div class="row">
                                                    @foreach($data as $v)
                                                        @switch($v->flag)
                                                        @case('article')
                                                        <div class="file-box">
                                                            <div class="file">
                                                                <span class="corner"></span>
                                                                @if($v->page_image)
                                                                    <div class="image">
                                                                        <img alt="image" class="img-responsive" src="{{$v->page_image}}">
                                                                    </div>
                                                                @else
                                                                    <div class="icon">
                                                                        <i class="fa fa-file-word-o"></i>
                                                                    </div>
                                                                @endif
                                                                <div class="file-name">
                                                                    <button class="btn btn-danger btn-xs">文章</button>{{str_limit($v->title, $limit = 18, $end = '...')}}
                                                                    <br/>
                                                                    <small>删除时间: {{$v->deleted_at->diffForHumans()}}</small>
                                                                    <div data-type="{{$v->flag}}" data-id="{{$v->id}}" style="float: right">
                                                                        <a class="btn btn-white btn-xs btn-bitbucket reset" title="还原">
                                                                            <i class="fa fa-undo"></i>
                                                                        </a>
                                                                        <a class="btn btn-white btn-xs btn-bitbucket del" title="永久删除？">
                                                                            <i class="glyphicon glyphicon-trash"></i>
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        @break
                                                        @case('link')
                                                        <div class="file-box">
                                                            <div class="file">
                                                                <span class="corner"></span>
                                                                @if($v->image)
                                                                    <div class="image">
                                                                        <img alt="image" class="img-responsive" src="{{$v->image}}">
                                                                    </div>
                                                                @else
                                                                    <div class="icon">
                                                                        <i class="fa fa-link"></i>
                                                                    </div>
                                                                @endif
                                                                <div class="file-name">
                                                                    <button class="btn btn-info btn-xs">友链</button>{{str_limit($v->name, $limit = 18, $end = '...')}}
                                                                    <br/>
                                                                    <small>删除时间: {{$v->deleted_at->diffForHumans()}}</small>
                                                                    <div style="float: right" data-type="{{$v->flag}}" data-id="{{$v->id}}">
                                                                        <a class="btn btn-white btn-xs btn-bitbucket reset" title="还原">
                                                                            <i class="fa fa-undo"></i>
                                                                        </a>
                                                                        <a class="btn btn-white btn-xs btn-bitbucket del" title="永久删除？">
                                                                            <i class="glyphicon glyphicon-trash"></i>
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        @break
                                                        @case('category')
                                                        <div class="file-box">
                                                            <div class="file">
                                                                <span class="corner"></span>

                                                                <div class="icon">
                                                                    <i class="fa fa-list-alt"></i>
                                                                </div>
                                                                <div class="file-name">
                                                                    <button class="btn btn-success btn-xs">分类</button>{{str_limit($v->name, $limit = 18, $end = '...')}}
                                                                    <br/>
                                                                    <small>删除时间: {{$v->deleted_at->diffForHumans()}}</small>
                                                                    <div style="float: right" data-type="{{$v->flag}}" data-id="{{$v->id}}">
                                                                        <a class="btn btn-white btn-xs btn-bitbucket reset" title="还原">
                                                                            <i class="fa fa-undo"></i>
                                                                        </a>
                                                                        <a class="btn btn-white btn-xs btn-bitbucket del" title="永久删除？">
                                                                            <i class="glyphicon glyphicon-trash"></i>
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        @break
                                                        @case('tag')
                                                        <div class="file-box">
                                                            <div class="file">
                                                                <span class="corner"></span>

                                                                <div class="icon">
                                                                    <i class="fa fa-tags"></i>
                                                                </div>
                                                                <div class="file-name">
                                                                    <button class="btn btn-warning btn-xs">标签</button>{{str_limit($v->tag, $limit = 18, $end = '...')}}
                                                                    <br/>
                                                                    <small>删除时间: {{$v->deleted_at->diffForHumans()}}</small>
                                                                    <div style="float: right" data-type="{{$v->flag}}" data-id="{{$v->id}}">
                                                                        <a class="btn btn-white btn-xs btn-bitbucket reset" title="还原">
                                                                            <i class="fa fa-undo"></i>
                                                                        </a>
                                                                        <a class="btn btn-white btn-xs btn-bitbucket del" title="永久删除？">
                                                                            <i class="glyphicon glyphicon-trash"></i>
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        @break
                                                        @case('comment')
                                                        <div class="file-box">
                                                            <div class="file">
                                                                <span class="corner"></span>

                                                                <div class="icon">
                                                                    <i class="fa fa-comments"></i>
                                                                </div>
                                                                <div class="file-name">
                                                                    <button class="btn btn-primary btn-xs">评论</button>{{str_limit($v->content['raw'], $limit = 18, $end = '...')}}
                                                                    <br/>
                                                                    <small>删除时间: {{$v->deleted_at->diffForHumans()}}</small>
                                                                    <div style="float: right" data-type="{{$v->flag}}" data-id="{{$v->id}}">
                                                                        <a class="btn btn-white btn-xs btn-bitbucket reset" title="还原">
                                                                            <i class="fa fa-undo"></i>
                                                                        </a>
                                                                        <a class="btn btn-white btn-xs btn-bitbucket del" title="永久删除？">
                                                                            <i class="glyphicon glyphicon-trash"></i>
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        @break
                                                        @endswitch
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="tab-2" class="tab-pane">
                                        <div class="panel-body da-body">
                                            <div class="col-lg-12 animated fadeInRight">
                                                <div class="row">
                                                    @foreach($articles as $v)
                                                        <div class="file-box">
                                                            <div class="file">
                                                                <span class="corner"></span>
                                                                @if($v->page_image)
                                                                    <div class="image">
                                                                        <img alt="image" class="img-responsive" src="{{$v->page_image}}">
                                                                    </div>
                                                                @else
                                                                    <div class="icon">
                                                                        <i class="fa fa-file-word-o"></i>
                                                                    </div>
                                                                @endif
                                                                <div class="file-name">
                                                                    <button class="btn btn-danger btn-xs">文章</button>{{str_limit($v->title, $limit = 18, $end = '...')}}
                                                                    <br/>
                                                                    <small>删除时间: {{$v->deleted_at->diffForHumans()}}</small>
                                                                    <div style="float: right" data-type="{{$v->flag}}" data-id="{{$v->id}}">
                                                                        <a class="btn btn-white btn-xs btn-bitbucket reset" title="还原">
                                                                            <i class="fa fa-undo"></i>
                                                                        </a>
                                                                        <a class="btn btn-white btn-xs btn-bitbucket del" title="永久删除？">
                                                                            <i class="glyphicon glyphicon-trash"></i>
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="tab-3" class="tab-pane">
                                        <div class="panel-body da-body">
                                            <div class="col-lg-12 animated fadeInRight">
                                                <div class="row">
                                                    @foreach($categories as $v)
                                                        <div class="file-box">
                                                            <div class="file">
                                                                <span class="corner"></span>

                                                                <div class="icon">
                                                                    <i class="fa fa-list-alt"></i>
                                                                </div>
                                                                <div class="file-name">
                                                                    <button class="btn btn-success btn-xs">分类</button>{{str_limit($v->name, $limit = 18, $end = '...')}}
                                                                    <br/>
                                                                    <small>删除时间: {{$v->deleted_at->diffForHumans()}}</small>
                                                                    <div style="float: right" data-type="{{$v->flag}}" data-id="{{$v->id}}">
                                                                        <a class="btn btn-white btn-xs btn-bitbucket reset" title="还原">
                                                                            <i class="fa fa-undo"></i>
                                                                        </a>
                                                                        <a class="btn btn-white btn-xs btn-bitbucket del" title="永久删除？">
                                                                            <i class="glyphicon glyphicon-trash"></i>
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="tab-4" class="tab-pane">
                                        <div class="panel-body da-body">
                                            <div class="col-lg-12 animated fadeInRight">
                                                <div class="row">
                                                    @foreach($tags as $v)
                                                        <div class="file-box">
                                                            <div class="file">
                                                                <span class="corner"></span>

                                                                <div class="icon">
                                                                    <i class="fa fa-tags"></i>
                                                                </div>
                                                                <div class="file-name">
                                                                    <button class="btn btn-warning btn-xs">标签</button>{{str_limit($v->tag, $limit = 18, $end = '...')}}
                                                                    <br/>
                                                                    <small>删除时间: {{$v->deleted_at->diffForHumans()}}</small>
                                                                    <div style="float: right" data-type="{{$v->flag}}" data-id="{{$v->id}}">
                                                                        <a class="btn btn-white btn-xs btn-bitbucket reset" title="还原">
                                                                            <i class="fa fa-undo"></i>
                                                                        </a>
                                                                        <a class="btn btn-white btn-xs btn-bitbucket del" title="永久删除？">
                                                                            <i class="glyphicon glyphicon-trash"></i>
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="tab-5" class="tab-pane">
                                        <div class="panel-body da-body">
                                            <div class="col-lg-12 animated fadeInRight">
                                                <div class="row">
                                                    @foreach($links as $v)
                                                        <div class="file-box">
                                                            <div class="file">
                                                                <span class="corner"></span>
                                                                @if($v->image)
                                                                    <div class="image">
                                                                        <img alt="image" class="img-responsive" src="{{$v->image}}">
                                                                    </div>
                                                                @else
                                                                    <div class="icon">
                                                                        <i class="fa fa-link"></i>
                                                                    </div>
                                                                @endif
                                                                <div class="file-name">
                                                                    <button class="btn btn-info btn-xs">友链</button>{{str_limit($v->name, $limit = 18, $end = '...')}}
                                                                    <br/>
                                                                    <small>删除时间: {{$v->deleted_at->diffForHumans()}}</small>
                                                                    <div style="float: right" data-type="{{$v->flag}}" data-id="{{$v->id}}">
                                                                        <a class="btn btn-white btn-xs btn-bitbucket reset" title="还原">
                                                                            <i class="fa fa-undo"></i>
                                                                        </a>
                                                                        <a class="btn btn-white btn-xs btn-bitbucket del" title="永久删除？">
                                                                            <i class="glyphicon glyphicon-trash"></i>
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="tab-6" class="tab-pane">
                                        <div class="panel-body da-body">
                                            <div class="col-lg-12 animated fadeInRight">
                                                <div class="row">
                                                    @foreach($comments as $v)
                                                        <div class="file-box">
                                                            <div class="file">
                                                                <span class="corner"></span>

                                                                <div class="icon">
                                                                    <i class="fa fa-comments"></i>
                                                                </div>
                                                                <div class="file-name">
                                                                    <button class="btn btn-primary btn-xs">评论</button>
                                                                    <br/>
                                                                    <small>删除时间: {{$v->deleted_at->diffForHumans()}}</small>
                                                                    <div style="float: right" data-type="{{$v->flag}}" data-id="{{$v->id}}">
                                                                        <a class="btn btn-white btn-xs btn-bitbucket reset" title="还原">
                                                                            <i class="fa fa-undo"></i>
                                                                        </a>
                                                                        <a class="btn btn-white btn-xs btn-bitbucket del" title="永久删除？">
                                                                            <i class="glyphicon glyphicon-trash"></i>
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
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
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title del-h4" id="del-label">确认清空回收站？</h4>
                        <span style="color: red;">警告：清空后不可恢复！！！</span>
                    </div>
                    <div class="modal-footer del-footer">
                        <button type="button" class="btn btn-primary" data-dismiss="modal">取消</button>
                        <button type="button" onclick="del($(this))" class="btn btn-danger">确认</button>
                    </div>
            </div>
        </div>
    </div>
    <!-- reset modal -->
    <div class="modal fade" id="resetModal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title del-h4" id="del-label">确认还原所有数据？</h4>
                </div>
                <div class="modal-footer del-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">取消</button>
                    <button type="button" onclick="undo($(this))" class="btn btn-danger">确认</button>
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
        //删除单个
        $(document).on('click', '.del', function () {
            var type = $(this).parent().attr('data-type');
            var id = $(this).parent().attr('data-id');
            var url = "/dd/del/"+type+"/"+id;
            $.ajax({
                cache: false,
                contentType: false,
                processData: false,
                type: "GET",
                url: url,
                async: false,
                error: function(msg) {
                    toastr.error('删除失败');
                },
                success: function (msg) {
                    notice(parent.success, '删除成功');
                    location.reload();
                }
            });
        });
        //撤销单个删除
        $(document).on('click', '.reset', function () {
            var type = $(this).parent().attr('data-type');
            var id = $(this).parent().attr('data-id');
            var url = "/dd/undo/"+type+"/"+id;
            $.ajax({
                cache: false,
                contentType: false,
                processData: false,
                type: "GET",
                url: url,
                async: false,
                error: function(msg) {
                    toastr.error('删除失败');
                },
                success: function (msg) {
                    notice(parent.success, '删除成功');
                    location.reload();
                }
            });
        });
        //还原所有数据
        function undo(z) {
            var url = "/dd/undo/all";
            $.ajax({
                cache: false,
                contentType: false,
                processData: false,
                type: "GET",
                url: url,
                async: false,
                error: function(msg) {
                    toastr.error('还原失败');
                },
                success: function (msg) {
                    notice(parent.success, '还原成功');
                    location.reload();
                }
            });
        }
        //清空回收站
        function del(z) {
            var url = "/dd/empty";
            $.ajax({
                cache: false,
                contentType: false,
                processData: false,
                type: "GET",
                url: url,
                async: false,
                error: function(msg) {
                    toastr.error('删除失败');
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
