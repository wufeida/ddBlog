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
    <div class="row wrapper border-bottom white-bg page-heading" style="padding-bottom: 10px">
        <div class="col-lg-9">
            <h2>File Manager</h2>
        </div>
    </div>
    <div class="wrapper wrapper-content">
            <div class="row">
                <div class="col-lg-3">
                    <div class="ibox float-e-margins">
                        <div class="ibox-content">
                            <div class="file-manager">
                                <h5>Show:</h5>
                                <a href="file_manager.html#" class="file-control active">Ale</a>
                                <a href="file_manager.html#" class="file-control">Documents</a>
                                <a href="file_manager.html#" class="file-control">Audio</a>
                                <a href="file_manager.html#" class="file-control">Images</a>
                                <div class="hr-line-dashed"></div>
                                <button class="btn btn-primary btn-block">Upload Files</button>
                                <div class="hr-line-dashed"></div>
                                <h5>Folders</h5>
                                <ul class="folder-list" style="padding: 0">
                                    <li><a href="file_manager.html"><i class="fa fa-folder"></i> Files</a></li>
                                    <li><a href="file_manager.html"><i class="fa fa-folder"></i> Pictures</a></li>
                                    <li><a href="file_manager.html"><i class="fa fa-folder"></i> Web pages</a></li>
                                    <li><a href="file_manager.html"><i class="fa fa-folder"></i> Illustrations</a></li>
                                    <li><a href="file_manager.html"><i class="fa fa-folder"></i> Films</a></li>
                                    <li><a href="file_manager.html"><i class="fa fa-folder"></i> Books</a></li>
                                </ul>
                                <h5 class="tag-title">Tags</h5>
                                <ul class="tag-list" style="padding: 0">
                                    <li><a href="file_manager.html">Family</a></li>
                                    <li><a href="file_manager.html">Work</a></li>
                                    <li><a href="file_manager.html">Home</a></li>
                                    <li><a href="file_manager.html">Children</a></li>
                                    <li><a href="file_manager.html">Holidays</a></li>
                                    <li><a href="file_manager.html">Music</a></li>
                                    <li><a href="file_manager.html">Photography</a></li>
                                    <li><a href="file_manager.html">Film</a></li>
                                </ul>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-9 animated fadeInRight">
                    <div class="row">
                        <div class="col-lg-12">
                            @foreach($data as $v)
                                @switch($v->flag)
                                    @case('article')
                                    <div class="file-box">
                                        <div class="file">
                                            <a href="file_manager.html#">
                                                <span class="corner"></span>
                                                @if($v->page_image)
                                                <div class="image">
                                                    <img alt="image" class="img-responsive" src="{{$v->page_image}}">
                                                </div>
                                                @else
                                                    <div class="icon">
                                                        <i class="fa fa-file"></i>
                                                    </div>
                                                @endif
                                                <div class="file-name">
                                                    <button class="btn btn-danger btn-xs">文章</button>{{str_limit($v->title, $limit = 18, $end = '...')}}
                                                    <br/>
                                                    <small>删除时间: {{$v->deleted_at->diffForHumans()}}</small>
                                                    <div style="float: right">
                                                        <a class="btn btn-white btn-xs btn-bitbucket" title="永久删除？">
                                                            <i class="glyphicon glyphicon-trash"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                    @break
                                    @case('link')
                                    <div class="file-box">
                                        <div class="file">
                                            <a href="file_manager.html#">
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
                                                    <div style="float: right">
                                                        <a class="btn btn-white btn-xs btn-bitbucket" title="永久删除？">
                                                            <i class="glyphicon glyphicon-trash"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                    @break
                                    @case('category')
                                    <div class="file-box">
                                        <div class="file">
                                            <a href="file_manager.html#">
                                                <span class="corner"></span>

                                                <div class="icon">
                                                    <i class="fa fa-list-alt"></i>
                                                </div>
                                                <div class="file-name">
                                                    <button class="btn btn-success btn-xs">分类</button>{{str_limit($v->name, $limit = 18, $end = '...')}}
                                                    <br/>
                                                    <small>删除时间: {{$v->deleted_at->diffForHumans()}}</small>
                                                    <div style="float: right">
                                                        <a class="btn btn-white btn-xs btn-bitbucket" title="永久删除？">
                                                            <i class="glyphicon glyphicon-trash"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                    @break
                                    @case('tag')
                                    <div class="file-box">
                                        <div class="file">
                                            <a href="file_manager.html#">
                                                <span class="corner"></span>

                                                <div class="icon">
                                                    <i class="fa fa-tags"></i>
                                                </div>
                                                <div class="file-name">
                                                    <button class="btn btn-warning btn-xs">标签</button>{{str_limit($v->tag, $limit = 18, $end = '...')}}
                                                    <br/>
                                                    <small>删除时间: {{$v->deleted_at->diffForHumans()}}</small>
                                                    <div style="float: right">
                                                        <a class="btn btn-white btn-xs btn-bitbucket" title="永久删除？">
                                                            <i class="glyphicon glyphicon-trash"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                    @break
                                    @case('comment')
                                    <div class="file-box">
                                        <div class="file">
                                            <a href="file_manager.html#">
                                                <span class="corner"></span>

                                                <div class="icon">
                                                    <i class="fa fa-comments"></i>
                                                </div>
                                                <div class="file-name">
                                                    <button class="btn btn-primary btn-xs">评论</button>
                                                    <br/>
                                                    <small>删除时间: {{$v->deleted_at->diffForHumans()}}</small>
                                                    <div style="float: right">
                                                        <a class="btn btn-white btn-xs btn-bitbucket" title="永久删除？">
                                                            <i class="glyphicon glyphicon-trash"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                    @break
                                @endswitch
                            @endforeach

                        </div>
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
    </script>
</body>

</html>
