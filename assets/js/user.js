$(document).ready(function () {
    $('#password_form').validator().on('submit', function (e) {
        if (e.isDefaultPrevented()) {
            // handle the invalid form...
        } else {
            e.preventDefault();
            var formAction = $(this).attr("action");
            var formData = $(this).serialize();
            var alert = $('#alert');
            if (alert.length) {
                alert.remove();
            }
            $.post(formAction, formData, function (msg) {
                if (msg.status) {
                    $('<div class="alert alert-success text-info text-dark" id="alert" >' + msg.message + '</div>')
                        .hide().prependTo('#password').slideDown();
                } else {
                    $.each(msg.errors, function (k, v) {
                        if(k==='login_error'){
                            $('#password').prepend('<div class="alert alert-danger text-info text-dark" ' +
                                'id="alert" role="alert">' + v + '</div>');
                        }else{

                        }

                    });
                }
            }, 'json');

        }
    });
});


function editUser(id) {
    var tableInfo =$('#table_info');
    var reg=$('#td_reg').html();
    var name=$('#td_name').html();
    var email=$('#td_email').html();
    var city=$('#td_city').html();
    var sex=$('#td_sex').html();

    tableInfo.fadeOut('fast' ,function () {
        tableInfo.replaceWith("<form method=\"post\" id=\"form_user\">\n" +
            "                                <table class=\"table table-th-block\" id=\"table_info\">\n" +
            "                                    <tbody>\n" +
            "                                    <tr><td class=\"active\">Зарегистрирован:</td><td>"+reg+"</td></tr>\n" +
            "                                    <tr><td class=\"active\">Имя:</td><td><input class=\"form-control\" type=\"text\" name=\"name\" value=\""+name+"\"></td></tr>\n" +
            "                                    <tr><td class=\"active\">Email:</td><td><input class=\"form-control\" type=\"text\" name=\"email\" value=\""+email+"\"></td></tr>\n" +
            "                                    <tr><td class=\"active\">Город:</td><td><input class=\"form-control\" type=\"text\" name=\"city\" value=\""+city+"\"></td></tr>\n" +
            "                                    <tr><td class=\"active\">Пол:</td><td><input class=\"form-control\" type=\"text\" name=\"sex\" value=\""+sex+"\"></td></tr>\n" +
            "                                    </tbody>\n" +
            "                                </table>\n" +
            "                                </form>");

    });
    $('#edit_btn').replaceWith("<div id=\"edit_controls\">\n" +
        "                                    <button id=\"update_btn\" class=\"btn btn-dark col-auto\" onclick=\"updateUser("+id+")\">Сохранить</button>\n" +
        "                                </div>")
}

function updateUser(id) {
    /* Send Form: */
    $.post('/user/infoUpdate/'+id, $('#form_user').serialize(), function(msg){

        var alert = $('#alert');

        if(alert.length){
            alert.remove();
        }

        if(msg.status){
            $('<div class="alert alert-success text-info text-dark" id="alert" >'+msg.message+'</div>')
                .hide().prependTo('#form_user').slideDown();
        }else {
            $.each(msg.errors,function(k,v){
                $('#form_user').prepend('<div class="alert alert-danger text-info text-dark" ' +
                    'id="alert" role="alert">'+k+': '+v
                    +'</div>');
            });
        }
    }, 'json');

}


function setAvatar(id){
    /* Send Form: */
    var formData = new FormData();
    formData.append('upload',$('#upload').get(0));
    $.ajax({
        type: "POST",
        url: '/user/avatarSet/'+id,
        data: formData,
        mimeType: "multipart/form-data",
        formData: false,
        contentType: false,
        success: function(msg){

            var alert = $('#alert');

            if(alert.length){
                alert.remove();
            }

            if(msg.status){
                $('<div class="alert alert-success text-info text-dark" id="alert" >'+msg.message+'</div>')
                    .hide().prependTo('#avatar').slideDown();


                $('#avatar_img').replaceWith("<img id=\"avatar_img\" alt=\"Аватар\" class=\"img-fluid\" width=\"256\" height=\"256\" src=\"/assets/img/avatars/"+msg.filename+"\">")
            }else {
                $.each(msg.errors,function(k,v){
                    $('#avatar').prepend('<div class="alert alert-danger text-info text-dark" ' +
                        'id="alert" role="alert">'+k+': '+v
                        +'</div>');
                });
            }
        },
        dataType: 'json'
    });
}

