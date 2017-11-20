@extends('home.layous.app')

@section('title', $data->title.config('blog.article.title'))
@section('keywords', $data->subtitle)
@section('description', config('blog.article.description'))

@section('css')
    <link href="/admin/plugins/toastr/toastr.css" rel="stylesheet">
    <link href="/home/assets/css/article.css" rel="stylesheet">
@endsection

@section('js')
    <script src="/admin/plugins/toastr/toastr.min.js"></script>
    <script src="/home/assets/js/article.js"></script>
@endsection

@section('content')
<!-- content srart -->
    <div class="am-u-md-8 am-u-sm-12">
      <article class="am-article blog-article-p">
        <div class="am-article-hd">
          <h1 class="am-article-title blog-text-center">{{$data->title}}</h1>
          <p class="am-article-meta blog-text-center">
              <span><i class="fa fa-list-alt"></i>&nbsp;
                  @if($data->category)
                      <a href="{{url("category").'/'.$data->category->id}}" class="blog-color"> &nbsp;{{$data->category->name}} &nbsp;</a>
                  @else
                      <a> &nbsp;暂无分类 &nbsp;</a>
                  @endif</span>-
              <span><i class="fa fa-user"></i> &nbsp;{{$data->user->name}} </span>-
              <span><i class="fa fa-calendar"></i> &nbsp;{{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $data->published_at)->diffForHumans() }}&nbsp;</span>
              <span><i class="fa fa-eye"></i> &nbsp;{{$data->view_count}}</span>
          </p>
        </div>        
        <div class="am-article-bd">
        {!! $data->content['html'] !!}
        </div>
      </article>
        
        <div class="am-g blog-article-widget blog-article-margin">
          <div class="am-u-lg-4 am-u-md-5 am-u-sm-7 am-u-sm-centered blog-text-center">
            <span class="am-icon-tags"> &nbsp;</span>
              @foreach($data->tags as $v)
                  @if (!$loop->last)
                        <a href="{{url("tag").'/'.$v->id}}">{{$v->tag}}</a> ,
                  @endif
                  @if ($loop->last)
                        <a href="{{url("tag").'/'.$v->id}}">{{$v->tag}}</a>
                  @endif
              @endforeach
            <hr>
          </div>
        </div>
        <hr>
        <ul class="am-pagination blog-article-margin">
            @if($prev_article)
                <li class="am-pagination-prev"><a href="{{url("/$prev_article->slug")}}">&laquo; {{$prev_article->title}}</a></li>
            @else
                <li class="am-pagination-prev"><span>&laquo; 没有了</span></li>
            @endif
            @if($next_article)
                <li class="am-pagination-next"><a href="{{url("/$next_article->slug")}}">{{$next_article->title}} &raquo;</a></li>
            @else
                <li class="am-pagination-next"><span>没有了 &raquo;</span></li>
            @endif
        </ul>
        
        <hr>

        <form class="am-form am-g add-form">
            <h3 class="blog-comment">评论</h3>
          <fieldset>
            <div class="am-form-group">
              <textarea name="content" class="" rows="5" placeholder="markdown"></textarea>
            </div>
              <input type="hidden" name="commentable_id" value="{{$data->id}}">
              <input type="hidden" name="commentable_type" value="articles">
            <p><button type="button" onclick="comment($(this))" class="am-btn am-btn-default">发表评论</button></p>
          </fieldset>
        </form>
        <hr>
        <div class="nav nav-second-level collapse in">
            @foreach($comments as $v)
                <div class="dd-comment">
                    <div class="media">
                        <div class="media-left">
                            <img src="http://rmdd.com/storage/1.jpg" class="media-object img-circle">
                        </div>
                        <div class="media-body box-body">
                            <div class="heading">
                                <i class="fa fa-user"></i>&nbsp;{{$v['user'] ? $v['user']['name'] : '无'}}
                                &nbsp;&nbsp;&nbsp;&nbsp;
                                <i class="fa fa-clock-o"></i>&nbsp;{{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $v['created_at'])->diffForHumans() }}
                                <span class="pull-right operate">
                                    <a href="javascript:;" pid="{{$v['id']}}" aid="{{$data->id}}" username="{{$v['user']['name']}}" onclick="reply($(this))">
                                        <i class="fa fa-comment"></i>&nbsp;回复
                                    </a>
                                </span>
                            </div>
                            <div class="comment-body markdown">
                                {!! $v['content']['html'] !!}
                            </div>
                        </div>
                    </div>

                    @if($v['child'])
                        @foreach($v['child'] as $val)
                    <div class="media dada-media-child">
                        <div class="media-left">
                            <img src="http://rmdd.com/storage/1.jpg" class="media-object img-circle">
                        </div>
                        <div class="media-body box-body">
                            <div class="heading">
                                <i class="fa fa-user"></i><span class="child-user">&nbsp;{{$val['user'] ? $val['user']['name'] : '无'}}</span> &nbsp;<span class="re-black">回复:</span>&nbsp;{{$val['reply_name']}}&nbsp;
                                <i class="fa fa-clock-o"></i>&nbsp;{{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $val['created_at'])->diffForHumans() }}
                                <span class="pull-right operate">
                                    <a href="javascript:;" pid="{{$val['id']}}" aid="{{$data->id}}" username="{{$val['user']['name']}}" onclick="reply($(this))">
                                        <i class="fa fa-comment"></i>&nbsp;回复
                                    </a>
                                </span>
                            </div>
                            <div class="comment-body markdown">
                                {!! $val['content']['html'] !!}
                            </div>
                        </div>
                    </div>
                        @endforeach
                    @endif
                </div>
            @endforeach
        </div>
    </div>
@endsection
<!-- content end -->