$(function(){
    $("input[name='btnlogin']").click(isValidUser);
});

function isValidUser(){

    var data = $('.frmuserlogin').serialize();

    ajaxCall('is-valid-user', 'post', data, userLoginResult);
}

function userLoginResult(result){

    if(result.indexOf('correct')>-1)
        location.reload();
    else
        $('.frmuserlogin').find('.message').html('Invalid email or password');
}

