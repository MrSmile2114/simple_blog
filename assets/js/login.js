$(document).ready(function () {

    $('#login_form').submit(function (e) {

        // Prevent form submission which refreshes page
        e.preventDefault();


        var formData = $(this).serialize();

        $.post('/main/login/',formData, function (msg) {

            if(msg.status){
                location.reload();
            }else{

                $.each(msg.errors,function(k,v){
                    if(k==='login_error'){
                        $('<div class="alert alert-danger text-info text-dark" id="alert" role="alert">'+v+'</div>')
                            .hide().prependTo('#login_form').slideDown();
                    }else{

                    }
                });
            }

        }, 'json');

    });

    $('#reg_form').submit(function (e) {

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
    });
});

function logout(){
    $.get('/main/logout/',[]);
    location.reload();
}