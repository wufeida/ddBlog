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
    <link href="/admin/plugins/summernote/summernote.css" rel="stylesheet">


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
        height: 34px;
    }
    .file input {
        position: absolute;
        width: 100%;
        height: 100%;
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
    @media only screen and (min-width: 100px) and (max-width: 640px) {
        .file {
            padding: 6px 0px;
        }
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
                        <fieldset class="form-horizontal">
                        <div class="ibox-content">
                            <form method="post" id="add-form" action="{{ isset($id) ? url('dd/article').'/'.$id : route('article.store') }}" enctype="multipart/form-data">
                                {{csrf_field()}}
                                @if(isset($id))
                                {{ method_field('PUT') }}
                                @endif
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label class="col-sm-1 control-label" for="title">标题：</label>
                                        <div class="col-sm-11">
                                            <input type="text" id="title" value="{{ isset($data) ? $data['title'] : '' }}" name="title" class="form-control" placeholder="标题">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-1 control-label" for="subtitle">副标题：</label>
                                        <div class="col-sm-11">
                                            <input type="text" id="subtitle" value="{{ isset($data) ? $data['subtitle'] : '' }}" name="subtitle" class="form-control" placeholder="副标题">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-1 control-label" for="category_id">分类：</label>
                                        <div class="col-sm-11">
                                            <select id="cate" name="category_id" value="{{ isset($data) ? $data['category_id'] : '' }}" class="form-control selectpicker" data-live-search="true">
                                            @foreach($categories as $v)
                                            <option value="{{$v->id}}">{{$v->name}}</option>
                                            @endforeach
                                        </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-1 control-label" for="image">页面图片：</label>
                                        <div class="col-sm-11">
                                            <div class="upload-box">
                                                <div class="col-lg-12" style="float: left;padding: 0;width: 80%">
                                                    <input type="text" value="{{isset($data) ? $data['page_image'] : ''}}" class="form-control" id="image_url" name="page_image">
                                                </div>
                                                <a href="javascript:;" class="file">选择文件
                                                    <input type="file" name="" id="" id="image">
                                                </a>
                                                <div id="preview1" class="preview">
                                                    <img width="100" height="100" class="image" id="J_avatar1" src="{{isset($data) ? $data['page_image'] : ''}}">
                                                </div>
                                                <div class="mask"><i class="ion-upload"></i></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-1 control-label" for="content">内容：</label>
                                        <div class="tabs-container col-sm-11">
                                            <ul class="nav nav-tabs ">
                                                <li class="active"><a data-toggle="tab" href="#tab-1"><i class="fa fa-file-archive-o"></i>markdown</a></li>
                                                <li class=""><a data-toggle="tab" href="#tab-2"><i class="fa fa-file-word-o"></i>富文本</a></li>
                                            </ul>
                                            <div class="tab-content">
                                                <div id="tab-1" class="tab-pane active">
                                                    <textarea name="content" id="editor">{{ isset($data) ? $data['content']['raw'] : '' }}</textarea>
                                                </div>
                                                <div id="tab-2" class="tab-pane">
                                                    <div id="summernote">{!! isset($data) ? $data['content']['html'] : '' !!}</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-1 control-label" for="tag">标签：</label>
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
                                        <div class="col-sm-11">
                                        <select id="tag" name="tag" value="{{$tag}}" class="form-control selectpicker" multiple data-live-search="true">
                                            @foreach($tags as $v)
                                            <option value="{{$v->id}}">{{$v->tag}}</option>
                                            @endforeach
                                        </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-1 control-label" for="meta_description">主要描述：</label>
                                        <div class="col-sm-11">
                                        <textarea class="form-control" value="" name="meta_description">{{ isset($data) ? $data['meta_description'] : '' }}</textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-1 control-label" for="content">日期时间：</label>
                                        <div class="col-sm-11">
                                        <div class="input-group date col-md-5" data-link-field="dtp_input1">
                                            <input name="published_at" class="form-control form_datetime" data-date="" data-date-format="yyyy-mm-dd hh:ii:ss" size="16" type="text" value="{{ isset($data) ? $data['published_at'] : '' }}" readonly>
                                        </div>
                                        </div>
                                    </div>
                                    <div class="form-group" style="margin-bottom: 30px;">
                                        <label class="col-sm-1 control-label">
                                            是否原创：
                                        </label>
                                        <div class="col-sm-1">
                                        <div class="switch switch-mini" data-on-text="YES" data-off-text="NO">
                                            <input type="checkbox" name="is_original" @if(isset($data))@if($data['is_original']) checked @endif @endif />
                                        </div>
                                        </div>

                                        <label class="col-sm-1 control-label">
                                            是否草稿：
                                        </label>
                                        <div class="col-sm-1">
                                        <div class="switch bootstrap-switch-mini" data-on-text="YES" data-off-text="NO">
                                            <input type="checkbox" name="is_draft"  @if(isset($data))@if($data['is_draft']) checked @endif @endif />
                                        </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" onclick="save($(this))" class="btn btn-primary">保存</button>
                                </div>
                            </form>
                        </div>
                        </fieldset>
                        <input type="hidden" id="flag" value="1">
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
    <script src="/admin/plugins/summernote/summernote.min.js"></script>
    <script src="/admin/plugins/summernote/lang/summernote-zh-CN.js"></script>
    <script type="text/javascript" src="/admin/plugins/webuploader/webuploader.js"></script>

    <script>
        var uploader = WebUploader.create({

            // 选完文件后，是否自动上传。
            auto: true,

            // swf文件路径
            swf: '/admin/plugins/webuploader/js/Uploader.swf',

            // 文件接收服务端。
            server: '/dd/file/upload',

            // 选择文件的按钮。可选。
            // 内部根据当前运行是创建，可能是input元素，也可能是flash.
            pick: '.file',

            // 只允许选择图片文件。
            accept: {
                title: 'Images',
                extensions: 'gif,jpg,jpeg,bmp,png',
                mimeTypes: 'image/*'
            }
        });
        uploader.on('beforeFileQueued', function (file) {
            uploader.reset();
            previewImage(file.source.source,'preview1','J_avatar1');
        });
        uploader.on('uploadSuccess', function (file,response) {
            if (response.success) {
                $('#image_url').val(response.url);
            } else {
                toastr.error('上传失败');
            }
        });
        $(function(){
            $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
                // 获取已激活的标签页的名称
                var activeTab = $(e.target).text();
                if (activeTab == '富文本') {
                    $('#flag').val('0');
                } else {
                    $('#flag').val('1');
                }
            });
        });
        //sumernote富文本编辑器
        $('#summernote').summernote({
            lang: 'zh-CN',
            minHeight: 300,
            maxHeight: null,
            focus: true,
            toolbar: [
                ['paragraph style', ['style']],
                ['font style', ['bold', 'italic', 'underline', 'fontname', 'fontsize', 'color', 'strikethrough', 'superscript', 'subscript', 'clear']],
                ['insert', ['picture', 'link', 'video', 'table', 'hr']],
                ['paragraph style', ['ol', 'ul', 'paragraph', 'height']],
                ['misc', ['redo', 'undo', 'codeview', 'fullscreen', 'help']],
            ],
            callbacks: {
                onImageUpload: function(files, editor, $editable) {
                    sendFile(files);
                }
            }
        });

        function sendFile(files, editor, $editable) {
            var data = new FormData();
            data.append("file", files[0]);
            data.append('folder', 'summernote');
            $.ajax({
                data : data,
                type : "POST",
                url : "/dd/file/upload",
                cache : false,
                contentType : false,
                processData : false,
                dataType : "json",
                success: function(data) {
                    $('#summernote').summernote('insertImage', data.url);
                },
                error:function(){
                    alert("上传失败");
                }
            });
        }

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
            var content = $('#summernote').summernote('code');
            var formData = new FormData($('#add-form')[0]);
            formData.append('tag',$('#tag').val());
            var flag = $('#flag').val();
            formData.append('flag',flag);
            if (flag == 1) {
                formData.append('content',simplemde.value());
            } else {
                formData.append('content',content);
            }
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
