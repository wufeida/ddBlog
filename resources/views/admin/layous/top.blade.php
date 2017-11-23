<div class="row border-bottom">
    <nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
        <div class="navbar-header">
            <a class="navbar-minimalize minimalize-styl-2 btn btn-primary "><i class="fa fa-bars"></i> </a>
            <form role="search" class="navbar-form-custom" action="">
                <div class="form-group">
                    <input type="text" placeholder="Search for something..." class="form-control" name="top-search" id="top-search">
                </div>
            </form>
        </div>
        <ul class="nav navbar-top-links navbar-right">
            {{--<li class="dropdown">--}}
                {{--<a class="dropdown-toggle count-info" data-toggle="dropdown" href="widgets.html#">--}}
                    {{--<i class="fa fa-envelope"></i>  <span class="label label-warning">16</span>--}}
                {{--</a>--}}
                {{--<ul class="dropdown-menu dropdown-messages">--}}
                    {{--<li>--}}
                        {{--<div class="dropdown-messages-box">--}}
                            {{--<a href="profile.html" class="pull-left">--}}
                                {{--<img alt="image" class="img-circle" src="/admin/img/a7.jpg">--}}
                            {{--</a>--}}
                            {{--<div class="media-body">--}}
                                {{--<small class="pull-right">46h ago</small>--}}
                                {{--<strong>Mike Loreipsum</strong> started following <strong>Monica Smith</strong>. <br>--}}
                                {{--<small class="text-muted">3 days ago at 7:58 pm - 10.06.2014</small>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    {{--</li>--}}
                    {{--<li class="divider"></li>--}}
                    {{--<li>--}}
                        {{--<div class="dropdown-messages-box">--}}
                            {{--<a href="profile.html" class="pull-left">--}}
                                {{--<img alt="image" class="img-circle" src="/admin/img/a4.jpg">--}}
                            {{--</a>--}}
                            {{--<div class="media-body ">--}}
                                {{--<small class="pull-right text-navy">5h ago</small>--}}
                                {{--<strong>Chris Johnatan Overtunk</strong> started following <strong>Monica Smith</strong>. <br>--}}
                                {{--<small class="text-muted">Yesterday 1:21 pm - 11.06.2014</small>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    {{--</li>--}}
                    {{--<li class="divider"></li>--}}
                    {{--<li>--}}
                        {{--<div class="dropdown-messages-box">--}}
                            {{--<a href="profile.html" class="pull-left">--}}
                                {{--<img alt="image" class="img-circle" src="/admin/img/profile.jpg">--}}
                            {{--</a>--}}
                            {{--<div class="media-body ">--}}
                                {{--<small class="pull-right">23h ago</small>--}}
                                {{--<strong>Monica Smith</strong> love <strong>Kim Smith</strong>. <br>--}}
                                {{--<small class="text-muted">2 days ago at 2:30 am - 11.06.2014</small>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    {{--</li>--}}
                    {{--<li class="divider"></li>--}}
                    {{--<li>--}}
                        {{--<div class="text-center link-block">--}}
                            {{--<a href="mailbox.html">--}}
                                {{--<i class="fa fa-envelope"></i> <strong>Read All Messages</strong>--}}
                            {{--</a>--}}
                        {{--</div>--}}
                    {{--</li>--}}
                {{--</ul>--}}
            {{--</li>--}}
            {{--<li class="dropdown">--}}
                {{--<a class="dropdown-toggle count-info" data-toggle="dropdown" href="widgets.html#">--}}
                    {{--<i class="fa fa-bell"></i>  <span class="label label-primary">8</span>--}}
                {{--</a>--}}
                {{--<ul class="dropdown-menu dropdown-alerts">--}}
                    {{--<li>--}}
                        {{--<a href="mailbox.html">--}}
                            {{--<div>--}}
                                {{--<i class="fa fa-envelope fa-fw"></i> You have 16 messages--}}
                                {{--<span class="pull-right text-muted small">4 minutes ago</span>--}}
                            {{--</div>--}}
                        {{--</a>--}}
                    {{--</li>--}}
                    {{--<li class="divider"></li>--}}
                    {{--<li>--}}
                        {{--<a href="profile.html">--}}
                            {{--<div>--}}
                                {{--<i class="fa fa-twitter fa-fw"></i> 3 New Followers--}}
                                {{--<span class="pull-right text-muted small">12 minutes ago</span>--}}
                            {{--</div>--}}
                        {{--</a>--}}
                    {{--</li>--}}
                    {{--<li class="divider"></li>--}}
                    {{--<li>--}}
                        {{--<a href="grid_options.html">--}}
                            {{--<div>--}}
                                {{--<i class="fa fa-upload fa-fw"></i> Server Rebooted--}}
                                {{--<span class="pull-right text-muted small">4 minutes ago</span>--}}
                            {{--</div>--}}
                        {{--</a>--}}
                    {{--</li>--}}
                    {{--<li class="divider"></li>--}}
                    {{--<li>--}}
                        {{--<div class="text-center link-block">--}}
                            {{--<a href="notifications.html">--}}
                                {{--<strong>See All Alerts</strong>--}}
                                {{--<i class="fa fa-angle-right"></i>--}}
                            {{--</a>--}}
                        {{--</div>--}}
                    {{--</li>--}}
                {{--</ul>--}}
            {{--</li>--}}

            <li>
                <a data-toggle="modal" data-target="#delModal" ><i class="glyphicon glyphicon-trash"></i>&nbsp;清除缓存</a>
            </li>
            <li>
                <a href="/" target="_blank" ><i class="fa fa-home"></i>&nbsp;去前台</a>
            </li>
            <li>
                <a href="{{url('dd/logout')}}">
                    <i class="fa fa-sign-out"></i> Log out
                </a>
            </li>
        </ul>

    </nav>
</div>
<!-- delete modal -->
<div class="modal fade" id="delModal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title del-h4" id="del-label">确认清除？</h4>
            </div>
            <div class="modal-footer del-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">取消</button>
                <button type="button" onclick="delCache($(this))" class="btn btn-danger">确认</button>
            </div>
        </div>
    </div>
</div>
<script>
    //确认删除
    function delCache(z) {
        $.ajax({
            type: "GET",
            url: '/dd/cache',
            async: false,
            error: function(msg) {
                toastr.error('清除失败');
            },
            success: function (msg) {
                toastr.success('清除成功');
                $('#delModal').modal('hide');
            }
        });
    }
</script>