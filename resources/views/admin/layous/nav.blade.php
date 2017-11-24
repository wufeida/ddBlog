<nav class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav metismenu" id="side-menu">
            <li class="nav-header">
                <div class="dropdown profile-element"> <span>
                        @if(Auth::user()->avatar)
                            <img alt="image" width="48" height="48" class="img-circle" src="{{Auth::user()->avatar}}" />
                        @else
                            <img alt="image" width="48" height="48" class="img-circle" src="/home/images/default_avatar.jpg" />
                        @endif
                             </span>
                    <a data-toggle="dropdown" class="dropdown-toggle">
                            <span class="clear"> <span class="block m-t-xs"> <strong class="font-bold">{{Auth::user()->name}}</strong>
                             </span> <span class="text-muted text-xs block">更多<b class="caret"></b></span> </span> </a>
                    <ul class="dropdown-menu animated fadeInRight m-t-xs">
                        <li><a href="mailbox.html">Mailbox</a></li>
                        <li class="divider"></li>
                        <li><a href="{{url('dd/logout')}}">Logout</a></li>
                    </ul>
                </div>
                <div class="logo-element">
                    @if(Auth::user()->avatar)
                        <img alt="image" width="48" height="48" class="img-circle" src="{{Auth::user()->avatar}}" />
                    @else
                        <img alt="image" width="48" height="48" class="img-circle" src="/home/images/default_avatar.jpg" />
                    @endif
                </div>
            </li>
            <li class="active">
                <a><i class="fa fa-th-large"></i> <span class="nav-label">个人博客</span> <span class="fa arrow"></span></a>
                <ul class="nav nav-second-level" id="menuSideBar">
                    <li mid="tab1" funurl="{{url('dd/user')}}"><a>用户管理</a></li>
                    <li mid="tab2" funurl="{{url('dd/category')}}"><a>分类管理</a></li>
                    <li mid="tab3" funurl="{{url('dd/tag')}}"><a>标签管理</a></li>
                    <li mid="tab4" funurl="{{url('dd/article')}}"><a>文章管理</a></li>
                    <li mid="tab5" funurl="{{url('dd/recommend')}}"><a>推荐文章管理</a></li>
                    <li mid="tab6" funurl="{{url('dd/link')}}"><a>友情链接</a></li>
                    <li mid="tab7" funurl="{{url('dd/comment')}}"><a>评论管理</a></li>
                    <li mid="tab8" funurl="{{url('dd/visitor')}}"><a>访问列表</a></li>
                    <li mid="tab9" funurl="{{url('dd/file')}}"><a>文件管理</a></li>
                    <li mid="tab10" funurl="{{url('dd/trash')}}"><a>回收站</a></li>
                </ul>
            </li>
        </ul>
    </div>
</nav>