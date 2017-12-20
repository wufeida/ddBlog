// 通知框设置
toastr.options=
    {
        "closeButton":false,//显示关闭按钮
        "debug":false,//启用debug
        "positionClass":"toast-bottom-right",//弹出的位置
        "showDuration":"300",//显示的时间
        "hideDuration":"500",//消失的时间
        "timeOut":"2000",//停留的时间
        "extendedTimeOut":"1000",//控制时间
        "showEasing":"swing",//显示时的动画缓冲方式
        "hideEasing":"linear",//消失时的动画缓冲方式
        "showMethod":"fadeIn",//显示时的动画方式
        "hideMethod":"fadeOut"//消失时的动画方式
    };
//评论
function comment(z) {
    $.get('/dd/home/check',function (msg) {
        if (msg == 1) {
            var formData = new FormData(z.parents('.add-form').eq(0)[0]);
            $.ajax({
                cache: false,
                contentType: false,
                processData: false,
                type: "POST",
                url: '/home/comment',
                data:formData,
                async: false,
                error: function(msg) {
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
                    if (msg.code == 'error') {
                        toastr.error(msg.msg);
                    } else {
                        toastr.success('评论成功');
                        location.reload();
                    }
                }
            });
        } else {
            $('#loginModal').modal('open');
        }
    });

}
//回复
function reply(z) {
    $.get('/dd/home/check',function (msg) {
        if (msg == 1) {
            var aid = z.attr('aid');
            var pid = z.attr('pid');
            var username = z.attr('username');
            var boxTextarea= $('.nav-second-level').find('.dd-comment-box');
            if(boxTextarea.length >= 1){
                boxTextarea.remove();
            }
            var str = '<fieldset class="dd-comment-box"><form class="add-form"><div class="dd-box"><textarea name="content" rows="5" placeholder="回复'+username+'的评论"></textarea><input type="hidden" name="commentable_id" value="'+aid+'"><input type="hidden" name="pid" value="'+pid+'"><input type="hidden" name="commentable_type" value="articles"><span class="email-span">邮箱：</span><input type="text" class="email-input" placeholder="接收回复邮箱" name="email"><button type="button" data-user="'+username+'" onclick="comment($(this))" class="am-btn am-btn-default">发表评论</button></div></form></fieldset>';
            z.parents('.dd-comment').eq(0).append(str);
            $('.dd-comment-box textarea').focus();
        } else {
            $('#loginModal').modal('open');
        }
    });

}
//viewer初始化 图片查看
// $('.am-article-bd').viewer({
//     url: 'src',
// });


function auto_data_size(){
    $(".am-article-bd img").each(function(i, elm) {
        console.log(i,elm,this);
        var imgs = new Image();
        imgs.src=$(this).attr("src");
        var w = imgs.width,
            h =imgs.height;
        $(this).parent("a").attr("data-size","").attr("data-size",w+"x"+h);
        $(this).parent("a").wrap(function(){
            return "<figure></figure>"
        })
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

// window.onload=function(){
    auto_data_size();
    initPhotoSwipeFromDOM('.am-article-bd');
// };
// execute above function