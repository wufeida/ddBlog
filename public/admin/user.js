//移除file里面的值  兼容ie
function resetFileInput(file){
    file.after(file.clone().val(""));
    file.remove();
}
//清空form表单
function clearForm() {
    setSwitchery(switch1, false);
    setSwitchery(switch2, false);
    setSwitchery(switch3, false);
    $('#add-form')[0].reset();
    $('#J_avatar1').attr('src','');
    $('#put').remove();
    $('#is_admin').removeAttr('checked');
    $('#status').removeAttr('checked', 'checked');
    $('#email_notify').removeAttr('checked', 'checked');
    resetFileInput($('#image'))
}

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
            // location.reload();
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