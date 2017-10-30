@extends('home.layous.app')

@section('title', '首页')

@section('content')
    <div class="am-u-md-8 am-u-sm-12">
        @foreach($data as $v)
            <article class="am-g blog-entry-article">
                <div class="am-u-lg-6 am-u-md-12 am-u-sm-12 blog-entry-img">
                    <a href="{{url("/$v->slug")}}"><img src="{{$v->page_image}}" alt="" class="am-u-sm-12"></a>
                </div>
                <div class="am-u-lg-6 am-u-md-12 am-u-sm-12 blog-entry-text">
                    <span><i class="fa fa-list-alt"></i><a href="" class="blog-color"> &nbsp;{{$v->category->name}} &nbsp;</a></span>
                    <span><i class="fa fa-user"></i> &nbsp;{{ $v->user->name }} &nbsp;</span>
                    <span><i class="fa fa-calendar"></i> &nbsp;{{$v->publish_at}}</span>
                    <h1><a href="{{url("/$v->slug")}}">{{$v->title}}</a></h1>
                    <p>
                        {{str_limit($v->meta_description, $limit = 100, $end = '...')}}
                    </p>
                    <p>
                        <i class="fa fa-tags"></i>
                        @foreach($v->tags as $val)
                            &nbsp;<a href="">{{$val->tag}}</a>&nbsp;
                        @endforeach
                        <a href="{{url("/$v->slug")}}" class="blog-continue">阅读全文</a></p>
                </div>
            </article>
        @endforeach
            <div style="text-align: center">
            {{$data->links()}}
            </div>
    </div>
@endsection