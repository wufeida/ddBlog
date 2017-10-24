{{--<nav class="navbar-default navbar-static-side" role="navigation">--}}
    {{--<div class="sidebar-collapse">--}}
        {{--<ul class="nav metismenu" id="side-menu">--}}
            {{--<li class="nav-header">--}}
                {{--<div class="dropdown profile-element"> <span>--}}
                            {{--<img alt="image" class="img-circle" src="/admin/img/profile_small.jpg" />--}}
                             {{--</span>--}}
                    {{--<a data-toggle="dropdown" class="dropdown-toggle">--}}
                            {{--<span class="clear"> <span class="block m-t-xs"> <strong class="font-bold">{{Auth::user()->name}}</strong>--}}
                             {{--</span> <span class="text-muted text-xs block">More <b class="caret"></b></span> </span> </a>--}}
                    {{--<ul class="dropdown-menu animated fadeInRight m-t-xs">--}}
                        {{--<li><a href="profile.html">Profile</a></li>--}}
                        {{--<li class="divider"></li>--}}
                        {{--<li><a href="login.html">Logout</a></li>--}}
                    {{--</ul>--}}
                {{--</div>--}}
                {{--<div class="logo-element">--}}
                    {{--哒哒--}}
                {{--</div>--}}
            {{--</li>--}}
            {{--<li  class="active">--}}
                {{--<a href="{{url('/dd/index')}}"><i class="fa fa-home"></i> <span class="nav-label">Home</span></a>--}}
            {{--</li>--}}
            {{--<li  class="active">--}}
                {{--<a href="{{url('/dd/categories')}}"><i class="fa fa-home"></i> <span class="nav-label">Categories</span></a>--}}
            {{--</li>--}}
        {{--</ul>--}}

    {{--</div>--}}
{{--</nav>--}}
<nav class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav metismenu" id="side-menu">
            <li class="nav-header">
                <div class="dropdown profile-element"> <span>
                            <img alt="image" class="img-circle" src="/admin/img/profile_small.jpg" />
                             </span>
                    <a data-toggle="dropdown" class="dropdown-toggle">
                            <span class="clear"> <span class="block m-t-xs"> <strong class="font-bold">David Williams</strong>
                             </span> <span class="text-muted text-xs block">Art Director <b class="caret"></b></span> </span> </a>
                    <ul class="dropdown-menu animated fadeInRight m-t-xs">
                        <li><a href="mailbox.html">Mailbox</a></li>
                        <li class="divider"></li>
                        <li><a href="login.html">Logout</a></li>
                    </ul>
                </div>
                <div class="logo-element">
                    DA+
                </div>
            </li>
            <li class="active">
                <a><i class="fa fa-th-large"></i> <span class="nav-label">个人博客</span> <span class="fa arrow"></span></a>
                <ul class="nav nav-second-level" id="menuSideBar">
                    <li mid="tab2" funurl="{{url('dd/category')}}"><a>分类管理</a></li>
                    <li mid="tab3" funurl="{{url('dd/tag')}}"><a>标签管理</a></li>
                    <li mid="tab4" funurl="{{url('dd/article')}}"><a>文章管理</a></li>
                    <li mid="tab5" funurl="{{url('dd/link')}}"><a>友情链接</a></li>
                    <li mid="tab6" funurl="{{url('dd/visitor')}}"><a>访问列表</a></li>
                </ul>
            </li>
        </ul>
    </div>
</nav>