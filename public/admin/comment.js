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
            layer.alert('删除失败', {icon: 5}, function () {
                location.reload();
            });
        },
        success: function (msg) {
            location.reload();
        }
    });
}
