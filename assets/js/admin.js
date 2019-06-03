function addCategory() {
    var addBtn=$("#add_btn");
    addBtn.fadeOut('fast',function () {
        addBtn.replaceWith("<form id=\"add_form\" role=\"form\" method=\"post\" action=\"/admin/categoryAdd/\" onSubmit=\"return false\">\n" +
            "                    <div class=\"form-group\">\n" +
            "                        <label>Название:</label>\n" +
            "                        <input name=\"title\" type=\"text\" class=\"form-control rounded\">\n" +
            "                    </div>\n" +
            "                    <div class=\"form-group\">\n" +
            "                        <label>Стиль:</label>\n" +
            "                        <select class=\"form-control custom-select\" name=\"style\" id=\"category\">\n" +
            "                            <option class=\"badge badge-primary\">badge-primary</option>\n" +
            "                            <option class=\"badge badge-secondary\">badge-secondary</option>\n" +
            "                            <option class=\"badge badge-success\">badge-success</option>\n" +
            "                            <option class=\"badge badge-warning\">badge-warning</option>\n" +
            "                            <option class=\"badge badge-info\">badge-info</option>\n" +
            "                            <option class=\"badge badge-danger\">badge-danger</option>\n" +
            "                        </select>\n" +
            "                    </div>\n" +
            "                    <div class=\"form-group\">\n" +
            "                        <button type=\"submit\" class=\"btn btn-dark\" onclick=\"sendCategory()\" data-original-title=\"\" title=\"\">Отправить</button>\n" +
            "                    </div>\n" +
            "                </form>")

    })
}

function sendCategory() {
    $.post('/admin/addCategory/', $('#add_form').serialize(), function(msg){

        var alert = $('#alert');

        if(alert.length){
            alert.remove();
        }

        if(msg.status){
            $(  '                        <tr id="cat_'+msg.id+'">\n' +
                '                            <td class="active col-auto">'+msg.id+'</td>\n' +
                '                            <td class="col-8"><span class="badge '+msg.style+'">'+msg.title+'</span></td>\n' +
                '                            <td class="col-1"><button class="btn btn-danger" onclick="deleteCategory('+msg.id+')">Удалить</button></td>\n' +
                '                        </tr>'
            ).appendTo('#categories_body').slideDown();
        }else {
            $.each(msg.errors,function(k,v){
                $('#add_form').prepend('<div class="alert alert-danger text-info text-dark" ' +
                    'id="alert" role="alert">'+k+': '+v
                    +'</div>');
            });
        }
    }, 'json');

}

function deleteCategory(id) {
    if (confirm("Вы уверены?")){
        $.get('/admin/deleteCategory/'+id, [], function (msg) {
            if(msg.status){
                $('#cat_'+id).slideUp().promise().done(function () {
                    $(this).remove();
                });

            }else{
                $.each(msg.errors,function(k,v) {
                    $('#cat_' + id).append('<div class="alert alert-danger text-info text-dark" role="alert">' +
                        v+'</div>');
                });
            }
        }, 'json');
    }
}

function deleteUser(id) {
    if (confirm("Вы уверены?")){
        $.get('/admin/deleteUser/'+id, [], function (msg) {
            if(msg.status){
                $('#user_'+id).slideUp().promise().done(function () {
                    $(this).remove();
                });

            }else{
                $.each(msg.errors,function(k,v) {
                    $('#user_' + id).append('<div class="alert alert-danger text-info text-dark" role="alert">' +
                        v+'</div>');
                });
            }
        }, 'json');
    }
}