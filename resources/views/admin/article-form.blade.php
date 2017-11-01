<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>后台管理 | 文章管理</title>

    <link href="/admin/css/bootstrap.min.css" rel="stylesheet">
    <link href="/admin/font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="/admin/css/plugins/iCheck/custom.css" rel="stylesheet">
    <link href="/admin/css/animate.css" rel="stylesheet">
    <link href="/admin/css/style.css" rel="stylesheet">
    <link href="/admin/css/plugins/viewer/viewer.min.css" rel="stylesheet">
    <link href="/admin/css/plugins/markdown-edit/simplemde.min.css" rel="stylesheet">
    <link href="/admin/css/plugins/date/bootstrap-datetimepicker.min.css" rel="stylesheet">
    <link href="/admin/plugins/switch/css/bootstrap3/bootstrap-switch.min.css" rel="stylesheet">
    <link href="/admin/plugins/select/css/bootstrap-select.min.css" rel="stylesheet">
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
</style>
<body class="gray-bg">
        <div class="gray-bg">
        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-12" style="padding-left: 0;padding-right: 0">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <a href="{{url('dd/article')}}" class="btn btn-success btn-sm">返回</a>
                            <button type="button" onclick="location.reload();" id="loading-example-btn" class="btn btn-white btn-sm" style="float: right;"><i class="fa fa-refresh"></i> Refresh</button>
                        </div>
                        <div class="ibox-content">
                            <form method="post" id="add-form" action="{{ isset($id) ? url('dd/article').'/'.$id : route('article.store') }}" enctype="multipart/form-data">
                                {{csrf_field()}}
                                @if(isset($id))
                                {{ method_field('PUT') }}
                                @endif
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="title">标题</label>
                                        <input type="text" id="title" value="{{ isset($data) ? $data['title'] : '' }}" name="title" class="form-control" placeholder="标题">
                                    </div>
                                    <div class="form-group">
                                        <label for="subtitle">副标题</label>
                                        <input type="text" id="subtitle" value="{{ isset($data) ? $data['subtitle'] : '' }}" name="subtitle" class="form-control" placeholder="副标题">
                                    </div>
                                    <div class="form-group">
                                        <label for="category_id">分类</label>
                                        <select id="cate" name="category_id" value="{{ isset($data) ? $data['category_id'] : '' }}" class="form-control selectpicker" data-live-search="true">
                                            @foreach($categories as $v)
                                            <option value="{{$v->id}}">{{$v->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="image">页面图片</label>
                                        <div class="upload-box">
                                            <input type="file" class="form-control" id="page_image" name="page_image" onchange="previewImage(this,'preview1','J_avatar1')">
                                            <div id="preview1" class="preview">
                                                <img width="100" src="{{ isset($data) ? $data['page_image'] : '' }}" height="100" class="image" id="J_avatar1">
                                            </div>
                                            <div class="mask"><i class="ion-upload"></i></div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="content">内容</label>
                                        <textarea name="content" id="editor">{{ isset($data) ? $data['content']['raw'] : '' }}</textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="tag">标签:</label>
                                        <?php
                                            if (isset($data)) {
                                                $tag = '';
                                                foreach ($data['tags'] as $v) {
                                                    $tag .= $v['id'].',';
                                                }
                                                $tag = trim($tag, ',');
                                            } else {
                                                $tag = '';
                                            }

                                        ?>
                                        <select id="tag" name="tag" value="{{$tag}}" class="form-control selectpicker" multiple data-live-search="true">
                                            @foreach($tags as $v)
                                            <option value="{{$v->id}}">{{$v->tag}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="meta_description">主要描述</label>
                                        <textarea class="form-control" value="" name="meta_description">{{ isset($data) ? $data['meta_description'] : '' }}</textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="content">日期时间</label>
                                        <div class="input-group date col-md-5" data-link-field="dtp_input1">
                                            <input name="published_at" class="form-control form_datetime" data-date="" data-date-format="yyyy-mm-dd hh:ii:ss" size="16" type="text" value="{{ isset($data) ? $data['published_at'] : '' }}" readonly>
                                        </div>
                                    </div>
                                    <div class="form-group" style="margin-bottom: 30px;">
                                        <label class="col-sm-1 control-label" style="padding-left: 0">
                                            是否原创
                                        </label>
                                        <div class="switch switch-mini col-sm-2" data-on-text="YES" data-off-text="NO">
                                            <input type="checkbox" name="is_original" @if(isset($data))@if($data['is_original']) checked @endif @endif />
                                        </div>

                                        <label class="col-sm-1 control-label" style="padding-left: 0">
                                            是否草稿
                                        </label>
                                        <div class="switch bootstrap-switch-mini col-sm-2" data-on-text="YES" data-off-text="NO">
                                            <input type="checkbox" name="is_draft"  @if(isset($data))@if($data['is_draft']) checked @endif @endif />
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" onclick="save($(this))" class="btn btn-primary">保存</button>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        </div>
    <!-- Mainly scripts -->
    <script src="/admin/js/jquery-2.1.1.js" charset="UTF-8"></script>
    <script src="/admin/js/bootstrap.min.js"></script>
    <script src="/admin/js/plugins/metisMenu/jquery.metisMenu.js"></script>
    <script src="/admin/js/plugins/slimscroll/jquery.slimscroll.min.js"></script>

    <!-- self -->
    <script src="/admin/js/layer/layer.js"></script>
    <script src="/admin/js/viewer/viewer.min.js"></script>
    <script src="/admin/js/upload-img-show.js"></script>
    <script src="/admin/article.js"></script>
    <script src="/admin/js/plugins/markdown-edit/simplemde.min.js"></script>
    <script src="/admin/js/plugins/date/bootstrap-datetimepicker.min.js" charset="UTF-8"></script>
    <script src="/admin/js/plugins/date/locales/bootstrap-datetimepicker.zh-CN.js" charset="UTF-8"></script>
    <script src="/admin/plugins/switch/js/bootstrap-switch.min.js"></script>
    <script src="/admin/plugins/select/js/bootstrap-select.js"></script>
    <script src="/admin/plugins/toastr/toastr.min.js"></script>
    <script src="/admin/plugins/toastr/toastr.config.js"></script>
    <script>
        //markdown编辑器
        var simplemde = new SimpleMDE({ element: $("#editor")[0] });

        //日期选择器
        $('.form_datetime').datetimepicker({
            language:  'zh-CN',
            weekStart: 1,
            todayBtn:  1,
            autoclose: 1,
            todayHighlight: 1,
            startView: 1,
            forceParse: 0,
            showMeridian: 1
        });
        // 开关按钮
        $("[name='is_original']").bootstrapSwitch({
            size:'small',
            onText:'YES',
            offText:'NO'
        });
        $("[name='is_draft']").bootstrapSwitch({
            size:'small',
            onText:'YES',
            offText:'NO'
        });

        function save(z) {
            var formData = new FormData($('#add-form')[0]);
            formData.append('tag',$('#tag').val());
            formData.append('content',simplemde.value());
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
                    notice(parent.success,'成功');
                    window.location.href = document.referrer;
                }
            });
        }

        var cate = $('#cate').attr('value');
        if (cate) {
            $('#cate').val(cate);
        }

        var tag = $('#tag').attr('value')
        if (tag) {
            var s = tag.split(',');
            $('#tag').val(s)
        }

        function notice(fname, msg) {
            if (fname && typeof(fname) == 'function') {
                fname(msg);
            }
        }
    </script>
</body>

</html>
