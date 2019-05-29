function addComment(){
    /* Send Form: */
    $.post('/comment/create/',$('#addCommentForm').serialize(),function(msg){

        var alert = $('#comm_alert');

        if(alert.length){
            alert.remove();
        }

        if(msg.status){
                $(msg.html).hide().appendTo('#commentsBody').slideDown();
                $('#commentContent').val('');
        }else {
                $.each(msg.errors,function(k,v){
                    $('#addCommentContainer').prepend('<div class="alert alert-danger text-info text-dark" ' +
                        'id="comm_alert" role="alert">'+v+'</div>');
                });
        }
    }, 'json');
}

function delComment(id){
    $.get('/comment/delete/'+id, [], function (msg) {
        if(msg.status){
            $('#comment_'+id).slideUp().promise().done(function () {
                $(this).remove();
            });

        }else{
            $.each(msg.errors,function(k,v) {
                $('#comment_' + id).append('<div class="alert alert-danger text-info text-dark" role="alert">' +
                    v+'</div>');
            });
        }
    }, 'json');
}

function editComment(id) {
    var divText =$('#content_'+id);
    var text = divText.text();

    text = text.replace(/\r?\n/g, "");
    text = text.trim();




    divText.fadeOut('fast' ,function () {
        divText.replaceWith("<form method=\"post\" enctype=\"multipart/form-data\" name=\"update_"+id+"\" " +
            "id=\"update_"+id+"\" onSubmit=\"return false\" >" +
                "<textarea class=\"form-control\" id='text_"+id+"' name=\"content\">"+text+"</textarea>" +
            "</form>");
        let editBtn=$('#editBtn_'+id);
        let delBtn=$('#delBtn_'+id);

        editBtn.replaceWith("<button class=\"btn btn-dark\" onclick=\"updateComment("+id+")\" id=\"btnUpdate_"+id+"\">Сохранить</button>");

        delBtn.replaceWith("<button class=\"btn btn-danger col-auto\" onclick=\"updateCancel("+id+")\" id=\"btnCancel_"+id+"\">Отменить</a>");
    });
}

function updateComment(id) {
    /* Send Form: */

    $.post('/comment/update/'+id,$('#update_'+id).serialize(),function(msg){
        var alert = $('#alert_'+id);

        if(alert.length){
            alert.remove();
        }
        if(msg.status){
            $('#text_'+id).text(msg.content);
            updateCancel(id);
        }else {
            $.each(msg.errors,function(k,v){
                $('#update_'+id).append('<div class="alert alert-danger text-info text-dark" id="alert_'+id+'"' +
                    'role="alert">'+v+'</div>');
            });
        }
    }, 'json');

}

function updateCancel(id) {
    var btnUpdate =$("#btnUpdate_"+id);
    var btnCancel =$("#btnCancel_"+id);
    var form = $("#update_"+id);
    var textarea = $("#text_"+id);
    var text = textarea.text();

    btnUpdate.replaceWith("<button class=\"btn btn-dark\" onclick=\"editComment("+id+")\" id=\"editBtn_"+id+"\">Редактировать</button>");
    btnCancel.replaceWith("<button class=\"btn btn-danger col-auto confirmation\" onclick=\"delComment("+id+")\" id=\"delBtn_"+id+"\">Удалить</a>")
    form.replaceWith("<div id='content_"+id+"'>"+text+"</div>");

}