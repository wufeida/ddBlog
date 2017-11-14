//移除file里面的值  兼容ie
function resetFileInput(file){
    file.after(file.clone().val(""));
    file.remove();
}
//清空form表单
function clearForm() {
    $('#error').html('');
    $('#name').val('');
    $('#description').val('');
    $('#path').val('');
    $('#J_avatar1').removeAttr('src');
    $('#image_url').val('');
    $('#put').remove();
    resetFileInput($('#image'))
}
//点击编辑按钮
$(document).on("click", ".edit", function () {
    clearForm();
    var id = $(this).parent().parent().children().eq(0).html();
    var url = "/dd/category/"+id+"/edit"
    $.getJSON(url, function(msg){
        $('#name').val(msg.name)
        $('#description').val(msg.description)
        $('#path').val(msg.path)
        $('#image_url').val(msg.image_url);
        $('#J_avatar1').attr('src',msg.image_url);
        $('#add-label').html('修改分类')
        var up_url = "/dd/category/"+msg.id
        $('#add-form').attr('action',up_url)
        var put = '<input id="put" type="hidden" name="_method" value="PUT">'
        $('#add-form').append(put)
    })
})
//点击删除按钮
$(document).on("click", ".delete", function () {
    var id = $(this).parent().parent().children().eq(0).html();
    var url = "/dd/category/"+id;
    $('#del-form').attr('action',url)
})
//点击添加按钮
$(document).on("click", ".add", function () {
    clearForm();
    $('#add-label').html('添加分类')
    var add_url = "/dd/category";
    $('#add-form').attr('action',add_url)
})
//确认保存数据
function save(z) {
    //清空错误提示
    $('#error').html('');
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