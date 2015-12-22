function isValidAdmin(){

    var data = $('.frmadminlogin').serialize();

    ajaxCall('authenticate/isvalidadmin', 'post', data, adminLoginResult);
}

function adminLoginResult(result){

    if(result.indexOf('correct')>-1){
        window.location.replace('adminsection');
    }
    else{
        $('.frmadminlogin').find('.message').html('Invalid username or password');
    }
}