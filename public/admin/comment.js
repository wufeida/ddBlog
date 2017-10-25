//点击删除按钮
$(document).on("click", ".delete", function () {
    var id = $(this).parent().parent().children().eq(0).html();
    var url = "/dd/comment/"+id;
    $('#del-form').attr('action',url)
})


//确认删除
function del(z) {
    var formData = new FormData($('#del-form')[0]);
    $.ajax({
        cache: false,
        contentType: false,
        processData: false,
        type: "POST",
        url: $("#del-form").attr('action'),
        data:formData,
        async: false,
        error: function(msg) {
            toastr.error('删除失败');
        },
        success: function (msg) {
            notice(parent.success, '删除成功');
            location.reload();
        }
    });
}

function notice(fname, msg) {
    if (fname && typeof(fname) == 'function') {
        fname(msg);
    }
}
