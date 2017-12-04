@extends('home.layous.app')

@section('title', config('blog.meta.title'))
@section('keywords', config('blog.meta.keywords'))
@section('description', config('blog.meta.description'))

@section('content')
    <div class="am-u-md-8 am-u-sm-12">
        @foreach($data as $v)
            <article class="am-g blog-entry-article">
                <div class="am-u-lg-6 am-u-md-12 am-u-sm-12 blog-entry-img">
                    <a href="{{url("/$v->slug")}}" target="_blank"><img src="{{$v->page_image}}" alt="" class="am-u-sm-12"></a>
                </div>
                <div class="am-u-lg-6 am-u-md-12 am-u-sm-12 blog-entry-text">
                    <span><i class="fa fa-list-alt"></i>
                        @if($v->category)
                            <a href="{{url("category").'/'.$v->category->id}}" class="blog-color"> &nbsp;{{$v->category->name}} &nbsp;</a>
                        @else
                            <a> &nbsp;暂无分类 &nbsp;</a>
                        @endif
                    </span>
                    <span><i class="fa fa-user"></i> &nbsp;{{ $v->user ? $v->user->name : '无' }} &nbsp;</span>
                    <span><i class="fa fa-calendar"></i> &nbsp;{{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $v->published_at)->diffForHumans() }} &nbsp;</span>
                    <span><i class="fa fa-eye"></i> &nbsp;{{$v->view_count}}</span>
                    <h1><a href="{{url("/$v->slug")}}" target="_blank">{{$v->title}}</a></h1>
                    <p>
                        {{str_limit($v->meta_description, $limit = 200, $end = '...')}}
                    </p>
                    <p>
                        <i class="fa fa-tags"></i>
                        @foreach($v->tags as $val)
                            &nbsp;<a href="{{url("tag").'/'.$val->id}}">{{$val->tag}}</a>&nbsp;
                        @endforeach
                        <a href="{{url("/$v->slug")}}" class="blog-continue" target="_blank">阅读全文</a></p>
                </div>
            </article>
        @endforeach
            <div style="text-align: center">
            {{$data->links()}}
            </div>
    </div>
@endsection