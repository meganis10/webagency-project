$(document).ready(function(){

    $('.error-msg, .success-msg').each(function(){
        var msg = $(this);
        setTimeout(function(){
            msg.fadeOut(500, function(){
                msg.remove();
            });
        }, 4000);
    });

    var current = window.location.href;
    $('header nav a').each(function(){
        if($(this).attr('href') && current.indexOf($(this).attr('href')) !== -1){
            $(this).addClass('active');
        }
    });

});