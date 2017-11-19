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

        <form class="am-form am-g" id="add-form">
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
        <ul class="nav nav-second-level collapse in">
            @foreach($comments as $v)
                <div class="media">
                    <div class="media-left" style="padding-right: 10px">
                        <a href="/user/12465"><img width="64px" height="64px" src="http://rmdd.com/storage/1.jpg" class="media-object img-circle"></a>
                    </div>
                    <div class="media-body box-body" style="border: 1px solid #ECF0F1;border-radius: 5px; background-color: #fff;color: #7F8C8D;">
                        <div class="heading" style="padding: 10px 20px;background: #ECF0F1;">
                            <i class="ion-person"></i><a href="/user/12465">12465</a>
                            &nbsp;&nbsp;&nbsp;&nbsp;
                            <i class="ion-clock"></i>1个月前
                            <span class="pull-right operate">
                                <span class="vote-button">
                                    <a href="javascript:;">
                                        <i class="ion-happy-outline"></i>
                                    </a>
                                    <a href="javascript:;">
                                        <i class="ion-sad-outline"></i>
                                    </a></span>
                                <a href="javascript:;"><i class="ion-ios-undo"></i></a>
                            </span>
                        </div>
                        <div class="comment-body markdown" style="padding: 30px 50px;
    color: #34495e;">
                            <p>hao</p>
                        </div>
                    </div>
                </div>
            {{--<li><img width="50px" height="50px" src="http://rmdd.com/storage/1.jpg" alt="">{!! $v['content']['html'] !!}</li>--}}
            {{--<ul class="nav nav-third-level collapse in" style="width: 95%; float: right">--}}
                {{--@foreach($v['child'] as $val)--}}
                {{--<li><img width="50px" height="50px" src="http://rmdd.com/storage/1.jpg" alt="">{!! $val['content']['html'] !!}</li>--}}
                {{--@endforeach--}}
            {{--</ul>--}}
            @endforeach
        </ul>

    </div>
@endsection
<!-- content end -->
<script>
    function comment(z) {
        var formData = new FormData($('#add-form')[0]);
        $.ajax({
            cache: false,
            contentType: false,
            processData: false,
            type: "POST",
            url: '/home/comment',
            data:formData,
            async: false,
            error: function(msg) {
                console.log(msg)
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
                toastr.success('评论成功');
//                location.reload();
            }
        });
    }
</script>