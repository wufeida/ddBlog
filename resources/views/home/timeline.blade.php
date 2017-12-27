@extends('home.layous.timeline')

@section('title', $config ? $config->meta_title : '')
@section('keywords', $config? $config->meta_keywords : '')
@section('description', $config ? $config->meta_description: '')

@section('content')
<!-- content srart -->
<div class="am-g am-g-fixed blog-fixed blog-content">
    <div class="am-u-sm-12">
        <h1 class="blog-text-center">-- 归档 --</h1>
        @foreach($data as $k=>$v)
        <div class="timeline-year">
            <h1>{{$k}}</h1>
            <hr>
            @foreach($v as $key=>$val)
                <ul>
                <h3>{{$key}}月</h3>
                <hr>
                @foreach($val as $value)
                <li>
                    <span class="am-u-sm-4 am-u-md-2 timeline-span">{{$value['published_at']}}</span>
                    <span class="am-u-sm-8 am-u-md-6"><a href="{{url($value['slug'])}}" target="_blank">{{$value['title']}}</a></span>
                    <span class="am-u-sm-4 am-u-md-2 am-hide-sm-only"><a href="{{url("category").'/'.$value['category']['id']}}" target="_blank">{{$value['category']['name']}}</a></span>
                </li>
                @endforeach
                </ul>
                <br>
            @endforeach

        </div>
        <hr>
        @endforeach
    </div>
</div>
<!-- content end -->
@endsection