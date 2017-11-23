<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
  <title>@yield('title')</title>
  <meta name="keywords" content="@yield('keywords')">
  <meta name="description" content="@yield('description')">
  <meta name="renderer" content="webkit">
  <meta http-equiv="Cache-Control" content="no-siteapp"/>
  <link rel="shortcut icon" href="{{ config('blog.default_icon') }}">
  <meta name="mobile-web-app-capable" content="yes">
  <meta name="apple-mobile-web-app-capable" content="yes">
  <meta name="apple-mobile-web-app-status-bar-style" content="black">
  <meta name="apple-mobile-web-app-title" content="@yield('title')"/>
  <meta name="msapplication-TileColor" content="#0e90d2">
  <link rel="stylesheet" href="/admin/css/bootstrap.min.css">
  <link rel="stylesheet" href="/home/assets/css/amazeui.min.css">
  <link rel="stylesheet" href="/home/assets/css/app.css">
  <link rel="stylesheet" href="/admin/font-awesome/css/font-awesome.min.css">
    @yield('css')
</head>

<body id="blog">
<nav class="am-g am-g-fixed blog-fixed blog-nav">
<button class="am-topbar-btn am-topbar-toggle am-btn am-btn-sm am-btn-success am-show-sm-only blog-button" data-am-collapse="{target: '#blog-collapse'}" ><span class="am-sr-only">导航切换</span> <span class="am-icon-bars"></span></button>

  <div class="am-collapse am-topbar-collapse" id="blog-collapse">
    <ul class="am-nav am-nav-pills am-topbar-nav">
        <li><a href="/" style="font-size: 30px;">{{config('blog.name')}}</a></li>
      <li class="{{isset($id) ? '' : 'am-active'}}"><a href="/">首页</a></li>
      @foreach($categories as $v)
      <li class="{{isset($id) ? $v->id == $id ? 'am-active' : '' : ''}}"><a href="{{url('category').'/'.$v->id}}">{{$v->name}}</a></li>
      @endforeach
    </ul>
      <div style="float: right;padding: 0 10px;margin-top: 8px">
          @if(Auth::check())
              @if(Auth::user()->is_admin)
                  <img width="30" height="30" src="{{Auth::user()->avatar}}" alt="">
                  <div class="am-dropdown" data-am-dropdown>
                  <a href="{{url('dd/index')}}" class="am-dropdown-toggle" data-am-dropdown-toggle href="javascript:;">
                  {{Auth::user()->name}}&nbsp;<span class="am-icon-caret-down"></span>
                  </a>
                      <ul class="am-dropdown-content">
                          <li><a href="{{url('dd/index')}}" target="_blank">我的后台</a></li>
                      </ul>
                  </div>
              @else
                  <img width="30" height="30" src="{{Auth::user()->avatar}}" alt="">
                  <span>{{Auth::user()->name}}</span>
              @endif
              &nbsp;<a style="color: #10D07A" href="{{url('auth/home/logout')}}">退出</a>
          @else
              <a style="color: #10D07A;cursor: pointer" data-am-modal="{target: '#loginModal'}">登录</a>
          @endif
      </div>
    <form class="am-topbar-form am-topbar-right am-form-inline" role="search">
      <div class="am-form-group">
        <input type="text" class="am-form-field am-input-sm" placeholder="搜索">
      </div>
    </form>
  </div>
</nav>
<hr>
<!-- content srart -->
<div class="am-g am-g-fixed blog-fixed">
    @yield('content')

    <div class="am-u-md-4 am-u-sm-12 blog-sidebar">
        <div class="blog-clear-margin blog-sidebar-widget blog-bor am-g ">
            <h2 class="blog-title"><span>TAG cloud</span></h2>
            <div class="am-u-sm-12 blog-clear-padding">
            @foreach($tags as $v)
            <a href="{{url("tag/$v->id")}}" class="blog-tag">{{$v->tag}}</a>
            @endforeach
            </div>
        </div>
        <div class="blog-sidebar-widget blog-bor">
            <h2 class="blog-title"><span>置顶推荐</span></h2>
            <ul class="am-list">
                @foreach($recommend as $v)
                <li><a href="{{url("/$v->slug")}}">{{$v->title}}</a></li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
<!-- content end -->


 <footer class="blog-footer">
    <div class="am-g am-g-fixed blog-fixed am-u-sm-centered blog-footer-padding" style="padding: 0">
        <p style="text-align: center">
            @if(config('blog.footer.qq.open'))
            <a href="{{ config('blog.footer.qq.url') }}" target="_blank"><span class="am-icon-qq am-icon-fw am-primary blog-icon blog-icon"></span></a>
            @endif
            @if(config('blog.footer.github.open'))
            <a href="{{ config('blog.footer.github.url') }}" target="_blank"><span class="am-icon-github am-icon-fw blog-icon blog-icon"></span></a>
            @endif
        </p>
    </div>
    <div class="blog-text-center">{!! config('blog.license') !!}<a target="_blank" href="http://www.miitbeian.gov.cn/">{{env('ICP')}}</a></div>
  </footer>
{{--登录模态--}}
<div class="am-modal-actions" id="loginModal">
    <div class="am-modal-actions-group">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="add-label">选择登录方式</h4>
            </div>

            <div class="am-g am-g-fixed blog-fixed am-u-sm-centered blog-footer-padding" style="text-align: center;padding: 2rem 0">
                <div class="am-u-sm-12 am-u-md-4- am-u-lg-4">
                    <h3>QQ登录</h3>
                    <p class="am-text-sm">
                        <a href="{{url('auth/qq')}}"><span class="am-icon-qq am-icon-lg am-primary blog-icon dd-login-ico"></span></a>
                    </p>
                </div>
                <div class="am-u-sm-12 am-u-md-4- am-u-lg-4">
                    <h3>微博登录</h3>
                    <p>
                        <a href="{{url('auth/weibo')}}"><span class="am-icon-weibo am-icon-lg blog-icon dd-login-ico"></span></a>
                    </p>
                </div>
                <div class="am-u-sm-12 am-u-md-4- am-u-lg-4">
                    <h3>github登录</h3>
                    <p>
                        <a href="{{url('auth/github')}}"><span class="am-icon-github am-icon-lg blog-icon dd-login-ico"></span></a>
                    </p>
                </div>
            </div>
        </div>
    </div>
    <div class="am-modal-actions-group">
        <button class="am-btn am-btn-secondary am-btn-block" data-am-modal-close>取消</button>
    </div>
</div>
</div>


<!--[if (gte IE 9)|!(IE)]><!-->
<script src="http://cdn.bootcss.com/jquery/2.1.4/jquery.min.js"></script>
<!--<![endif]-->
<!--[if lte IE 8 ]>
<script src="http://libs.baidu.com/jquery/1.11.3/jquery.min.js"></script>
<script src="http://cdn.staticfile.org/modernizr/2.8.3/modernizr.js"></script>
<script src="/home/assets/js/amazeui.ie8polyfill.min.js"></script>
<![endif]-->
<script src="/home/assets/js/amazeui.min.js"></script>
<script src="/home/assets/js/pace.min.js"></script>
@yield('js')
<!-- <script src="/home/assets/js/app.js"></script> -->
</body>
</html>