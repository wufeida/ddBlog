@extends('home.layous.app')

@section('title', $data->title.config('blog.article.title'))
@section('keywords', $data->subtitle)
@section('description', config('blog.article.description'))

@section('content')
<!-- content srart -->
<style>
    .am-article-bd blockquote p {
        overflow: auto;
    }
</style>
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

        <form class="am-form am-g">
            <h3 class="blog-comment">评论</h3>
          <fieldset>
            <div class="am-form-group am-u-sm-4 blog-clear-left">
              <input type="text" class="" placeholder="名字">
            </div>
            <div class="am-form-group am-u-sm-4">
              <input type="email" class="" placeholder="邮箱">
            </div>

            <div class="am-form-group am-u-sm-4 blog-clear-right">
              <input type="password" class="" placeholder="网站">
            </div>
        
            <div class="am-form-group">
              <textarea class="" rows="5" placeholder="一字千金"></textarea>
            </div>
        
            <p><button type="submit" class="am-btn am-btn-default">发表评论</button></p>
          </fieldset>
        </form>

        <hr>
    </div>
@endsection
<!-- content end -->