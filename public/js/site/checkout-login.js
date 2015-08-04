$(function(){
    $("input[name='btn-checkout-login']").click(doLogin);

    $("input[name='btn-continue-guest']").click(moveToAddress);
});

function doLogin(){

    if(isLoginFormValid()){

        var data = $("#form-checkout-login").serialize();

        $.ajax({
            url: root + '/is-valid-checkout-user',
            type: 'post',
            data: data,
            dataType: 'json',
            success: function(result){

                if(result.message.indexOf('wrong')>-1)
                    $('.message-login').html('Invalid username or password');
                else if(result.message.indexOf('correct')>-1)
                    window.location.replace(root + '/checkout-address');
                else
                    $('.message-login').html('Server returned error : ' + result.message);
            }
        });
    }
}
function isLoginFormValid(){
    return true;
}

function moveToAddress(){

    var guestEmail = $("input[name='guest-email']").val();
    $(".message-guest").html("");

    if(guestEmail.length>0){

        var data = 'email=' + guestEmail;

        $.ajax({
            url: root + '/checkout-guest',
            type: 'get',
            data: data,
            dataType: 'json',
            success: function(result){

                if(result!=undefined && result.message!=undefined) {

                    if (result.message.indexOf('done') > -1)
                        window.location.replace(root + '/checkout-address');
                    else if (result.message.indexOf('session') > -1)
                        window.location.replace(root);
                }
                else
                    $(".message-guest").html('Invalid operation');
            }
        });
    }
    else
        $(".message-guest").html("Please provide valid email");
}