@extends('home.layous.app')
@if($config)
@section('title', $data->title.$config->article_title)
@else
@section('title', $data->title)
@endif
@section('keywords', $data->subtitle)
@section('description', $config ? $config->article_description : '')

@section('css')
    <link href="/admin/plugins/toastr/toastr.min.css" rel="stylesheet">
    {{--<link href="/admin/css/plugins/viewer/viewer.min.css" rel="stylesheet">--}}
    <link href="/home/assets/plugins/photo/photoswipe.css" rel="stylesheet">
    <link href="/home/assets/plugins/photo/default-skin/default-skin.css" rel="stylesheet">
    <link href="/home/assets/css/article.css" rel="stylesheet">
@endsection

@section('js')
    <script src="/admin/plugins/toastr/toastr.min.js"></script>
    {{--<script src="/admin/js/viewer/viewer.min.js"></script>--}}
    <script src="/home/assets/plugins/photo/photoswipe.js"></script>
    <script src="/home/assets/plugins/photo/photoswipe-ui-default.js"></script>
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
              <span><i class="fa fa-user"></i> &nbsp;{{ $data->user ? $data->user->nickname : '无' }} </span>-
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
              <textarea name="content" @if(!Auth::check()) disabled placeholder="请登录后评论" @else placeholder="支持markdown" @endif rows="5" ></textarea>
            </div>
              <input type="hidden" name="commentable_id" value="{{$data->id}}">
              <input type="hidden" name="commentable_type" value="articles">
              <p><input type="text" placeholder="邮箱，有人回复您的评论以便发送通知邮件，可不填" name="email"></p>
            <p><button type="button" onclick="comment($(this))" class="am-btn am-btn-default">发表评论</button></p>
          </fieldset>
        </form>
        <hr>
        <div class="nav nav-second-level collapse in">
            @foreach($comments as $v)
                <div class="dd-comment">
                    <div class="media">
                        <div class="media-left">
                            @if($v['user']['avatar'])
                                <img src="{{$v['user']['avatar']}}" class="media-object img-circle">
                            @else
                                <img src="/home/images/default_avatar.jpg" class="media-object img-circle">
                            @endif
                        </div>
                        <div class="media-body box-body">
                            <div class="heading">
                                <i class="fa fa-user"></i>&nbsp;{{$v['user'] ? $v['user']['nickname'] : '无'}}
                                &nbsp;&nbsp;&nbsp;&nbsp;
                                <i class="fa fa-clock-o"></i>&nbsp;{{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $v['created_at'])->diffForHumans() }}
                                <span class="pull-right operate">
                                    <a href="javascript:;" pid="{{$v['id']}}" aid="{{$data->id}}" username="{{$v['user']['nickname']}}" onclick="reply($(this))">
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
                            @if($val['user']['avatar'])
                                <img src="{{$val['user']['avatar']}}" class="media-object img-circle">
                            @else
                                <img src="/home/images/default_avatar.jpg" class="media-object img-circle">
                            @endif
                        </div>
                        <div class="media-body box-body">
                            <div class="heading">
                                <i class="fa fa-user"></i><span class="child-user">&nbsp;{{$val['user'] ? $val['user']['nickname'] : '无'}}</span> &nbsp;<span class="re-black">回复:</span>&nbsp;{{$val['reply_name']}}&nbsp;
                                <i class="fa fa-clock-o"></i>&nbsp;{{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $val['created_at'])->diffForHumans() }}
                                <span class="pull-right operate">
                                    <a href="javascript:;" pid="{{$val['id']}}" aid="{{$data->id}}" username="{{$val['user']['nickname']}}" onclick="reply($(this))">
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

<div class="pswp" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="pswp__bg"></div>
    <div class="pswp__scroll-wrap">
        <div class="pswp__container">
            <div class="pswp__item"></div>
            <div class="pswp__item"></div>
            <div class="pswp__item"></div>
        </div>
        <div class="pswp__ui pswp__ui--hidden">
            <div class="pswp__top-bar">
                <div class="pswp__counter"></div>
                <button class="pswp__button pswp__button--close" title="Close (Esc)"></button>
                <div class="pswp__preloader">
                    <div class="pswp__preloader__icn">
                        <div class="pswp__preloader__cut">
                            <div class="pswp__preloader__donut"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="pswp__share-modal pswp__share-modal--hidden pswp__single-tap">
                <div class="pswp__share-tooltip"></div>
            </div>
            <button class="pswp__button pswp__button--arrow--left" title="Previous (arrow left)"></button>
            <button class="pswp__button pswp__button--arrow--right" title="Next (arrow right)"></button>
            <div class="pswp__caption">
                <div class="pswp__caption__center"></div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">

    function auto_data_size(){
        $(".am-article-bd img").each(function() {
            var imgs = new Image();
            imgs.src=$(this).attr("src");
            var w = imgs.width,
                h =imgs.height;
            $(this).parent("a").attr("data-size","").attr("data-size",w+"x"+h);
            var figure = $("<figure></figure>").html($(this).parent().parent().html());
            $(this).parent().parent().html(figure)
        })
    };


    var initPhotoSwipeFromDOM = function(gallerySelector) {
        // parse slide data (url, title, size ...) from DOM elements
        // (children of gallerySelector)
        var parseThumbnailElements = function(el) {
            var thumbElements = el.childNodes,
                numNodes = thumbElements.length,
                items = [],
                figureEl,
                linkEl,
                size,
                item;
            for (var i = 0; i < numNodes; i++) {

                figureEl = thumbElements[i]; // <figure> element
                // include only element nodes
                if (thumbElements[i].tagName !== 'FIGURE') {
                    continue;
                }

                linkEl = figureEl.children[0]; // <a> element
                size = linkEl.getAttribute('data-size').split('x');
                // create slide object
                item = {
                    src: linkEl.getAttribute('href'),
                    w: parseInt(size[0], 10),
                    h: parseInt(size[1], 10)
                };



                if (figureEl.children.length > 1) {
                    // <figcaption> content
                    item.title = figureEl.children[1].innerHTML;
                }

                if (linkEl.children.length > 0) {
                    // <img> thumbnail element, retrieving thumbnail url
                    item.msrc = linkEl.children[0].getAttribute('src');
                }

                item.el = figureEl; // save link to element for getThumbBoundsFn
                items.push(item);
            }

            return items;
        };

        // find nearest parent element
        var closest = function closest(el, fn) {
            return el && (fn(el) ? el : closest(el.parentNode, fn));
        };

        // triggers when user clicks on thumbnail
        var onThumbnailsClick = function(e) {
            e = e || window.event;
            e.preventDefault ? e.preventDefault() : e.returnValue = false;

            var eTarget = e.target || e.srcElement;

            // find root element of slide
            var clickedListItem = closest(eTarget, function(el) {
                return (el.tagName && el.tagName.toUpperCase() === 'FIGURE');
            });

            if (!clickedListItem) {
                return;
            }

            // find index of clicked item by looping through all child nodes
            // alternatively, you may define index via data- attribute
            var clickedGallery = clickedListItem.parentNode,
                childNodes = clickedListItem.parentNode.childNodes,
                numChildNodes = childNodes.length,
                nodeIndex = 0,
                index;

            for (var i = 0; i < numChildNodes; i++) {
                if (childNodes[i].nodeType !== 1) {
                    continue;
                }

                if (childNodes[i] === clickedListItem) {
                    index = nodeIndex;
                    break;
                }
                nodeIndex++;
            }



            if (index >= 0) {
                // open PhotoSwipe if valid index found
                openPhotoSwipe(index, clickedGallery);
            }
            return false;
        };

        // parse picture index and gallery index from URL (#&pid=1&gid=2)
        var photoswipeParseHash = function() {
            var hash = window.location.hash.substring(1),
                params = {};

            if (hash.length < 5) {
                return params;
            }

            var vars = hash.split('&');
            for (var i = 0; i < vars.length; i++) {
                if (!vars[i]) {
                    continue;
                }
                var pair = vars[i].split('=');
                if (pair.length < 2) {
                    continue;
                }
                params[pair[0]] = pair[1];
            }

            if (params.gid) {
                params.gid = parseInt(params.gid, 10);
            }

            return params;
        };

        var openPhotoSwipe = function(index, galleryElement, disableAnimation, fromURL) {
            var pswpElement = document.querySelectorAll('.pswp')[0],
                gallery,
                options,
                items;

            items = parseThumbnailElements(galleryElement);

            // define options (if needed)
            options = {
                // define gallery index (for URL)
                galleryUID: galleryElement.getAttribute('data-pswp-uid'),
                getThumbBoundsFn: function(index) {
                    // See Options -> getThumbBoundsFn section of documentation for more info
                    var thumbnail = items[index].el.getElementsByTagName('img')[0], // find thumbnail
                        pageYScroll = window.pageYOffset || document.documentElement.scrollTop,
                        rect = thumbnail.getBoundingClientRect();

                    return {x: rect.left, y: rect.top + pageYScroll, w: rect.width};
                }

            };

            // PhotoSwipe opened from URL
            if (fromURL) {
                if (options.galleryPIDs) {
                    // parse real index when custom PIDs are used
                    // http://photoswipe.com/documentation/faq.html#custom-pid-in-url
                    for (var j = 0; j < items.length; j++) {
                        if (items[j].pid == index) {
                            options.index = j;
                            break;
                        }
                    }
                } else {
                    // in URL indexes start from 1
                    options.index = parseInt(index, 10) - 1;
                }
            } else {
                options.index = parseInt(index, 10);
            }

            // exit if index not found
            if (isNaN(options.index)) {
                return;
            }

            if (disableAnimation) {
                options.showAnimationDuration = 0;
            }

            // Pass data to PhotoSwipe and initialize it
            gallery = new PhotoSwipe(pswpElement, PhotoSwipeUI_Default, items, options);
            gallery.init();
        };

        // loop through all gallery elements and bind events
        var galleryElements = document.querySelectorAll(gallerySelector);

        for (var i = 0, l = galleryElements.length; i < l; i++) {
            galleryElements[i].setAttribute('data-pswp-uid', i + 1);
            galleryElements[i].onclick = onThumbnailsClick;
        }

        // Parse URL and open gallery if it contains #&pid=3&gid=1
        var hashData = photoswipeParseHash();
        if (hashData.pid && hashData.gid) {
            openPhotoSwipe(hashData.pid, galleryElements[ hashData.gid - 1 ], true, true);
        }
    };

    window.onload=function(){
        auto_data_size();
        initPhotoSwipeFromDOM('.am-article-bd');
    };
    // execute above function

</script>

@endsection
<!-- content end -->