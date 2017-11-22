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
function comment(z) {
    $.get('/auth/home/check',function (msg) {
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
            $('#loginModal').modal('show');
        }
    });

}

function reply(z) {
    var aid = z.attr('aid');
    var pid = z.attr('pid');
    var username = z.attr('username');
    var boxTextarea= $('.nav-second-level').find('.dd-comment-box');
    if(boxTextarea.length >= 1){
        boxTextarea.remove();
    }
    var str = '<fieldset class="dd-comment-box"><form class="add-form"><div class="am-form-group"><textarea name="content" rows="5" placeholder="回复'+username+'的评论"></textarea></div><input type="hidden" name="commentable_id" value="'+aid+'"><input type="hidden" name="pid" value="'+pid+'"><input type="hidden" name="commentable_type" value="articles"><p><button type="button" data-user="'+username+'" onclick="comment($(this))" class="am-btn am-btn-default">发表评论</button></p></form></fieldset>';
    z.parents('.dd-comment').eq(0).append(str);
    $('.dd-comment-box textarea').focus();
}