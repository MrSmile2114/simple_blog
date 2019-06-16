$(document).ready(function () {
    $('#reg_form').validator().on('submit', function (e) {
        if (e.isDefaultPrevented()) {
            // handle the invalid form...
        } else {
            // Prevent form submission which refreshes page
            e.preventDefault();

            // Serialize data
            var formData = $(this).serialize();

            $.post('/main/register/',formData, function (msg) {

                if(msg.status){
                    location.reload();
                }else{

                }

            }, 'json');
        }
    });

    $('#login_form').validator().on('submit', function (e) {
        if (e.isDefaultPrevented()) {
            // handle the invalid form...
        } else {
            // Prevent form submission which refreshes page
            e.preventDefault();
            var formData = $(this).serialize();

            $.post('/main/login/',formData, function (msg) {

                if(msg.status){
                    location.reload();
                }else{
                    $.each(msg.errors,function(k,v){
                        if(k==='login_error'){
                            $('#alert').remove();
                            $('<div class="alert alert-danger text-info text-dark" id="alert" role="alert">'+v+'</div>')
                                .hide().prependTo('#login_form').slideDown();
                        }else{

                        }
                    });
                }

            }, 'json');
        }
        });


    $("#logout").on('click', function (e) {
        e.preventDefault();
        $.get('/main/logout/',[], function (msg) {
            if(msg.status){
                location.reload();
            }else{

            }
        }, 'json');
    });
});