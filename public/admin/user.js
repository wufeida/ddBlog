//移除file里面的值  兼容ie
function resetFileInput(file){
    file.after(file.clone().val(""));
    file.remove();
}
//清空form表单
function clearForm() {
    $('#add-form')[0].reset();
    $('#J_avatar1').attr('src','');
    $('#put').remove();
    $('#is_admin').removeAttr('checked');
    $('#status').removeAttr('checked', 'checked');
    $('#email_notify').removeAttr('checked', 'checked');
    resetFileInput($('#image'))
}
//点击编辑按钮
$(document).on("click", ".edit", function () {
    clearForm();
    var id = $(this).parent().parent().children().eq(0).html();
    var url = "/dd/user/"+id+"/edit";
    $.getJSON(url, function(msg){
        $('#name').val(msg.name);
        $('#description').val(msg.description);
        $('#email').val(msg.email);
        $('#avatar').val(msg.avatar);
        $('#J_avatar1').attr('src',msg.avatar);
        if (msg.is_admin == 1) {
            $('#is_admin').attr('checked', true);
        }
        $('#add-label').html('修改用户');
        var up_url = "/dd/user/"+msg.id;
        $('#add-form').attr('action',up_url);
        var put = '<input id="put" type="hidden" name="_method" value="PUT">';
        $('#add-form').append(put);
    })
});
//点击删除按钮
$(document).on("click", ".delete", function () {
    var id = $(this).parent().parent().children().eq(0).html();
    var url = "/dd/user/"+id;
    $('#del-form').attr('action',url);
})
//点击添加按钮
$(document).on("click", ".add", function () {
    clearForm();
    $('#add-label').html('添加用户');
    var add_url = "/dd/user";
    $('#add-form').attr('action',add_url);
})
//确认保存数据
function save(z) {
    //清空错误提示
    var formData = new FormData($('#add-form')[0]);
    $.ajax({
        cache: false,
        contentType: false,
        processData: false,
        type: "POST",
        url: $("#add-form").attr('action'),
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
            notice(parent.success, '成功');
            location.reload();
        }
    });
}


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
//viewer.js图片显示
$('#dowebok').viewer({
    url: 'data-original',
});