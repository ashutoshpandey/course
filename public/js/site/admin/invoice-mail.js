/**
 * Created by Hp on 07-07-2016.
 */
$(function(){
    $("input[name='btn-send']").click(sendMail);
});

function sendMail(){

    if(isFormValid()){

        var data = $("#form-send-mail").serialize();

        $.ajax({
            url: root + '/save-location',
            type: 'post',
            data: data,
            dataType: 'json',
            success: function(result){

                if(result.message.indexOf('not logged')>-1)
                    window.location.replace(root);
                else if(result.message.indexOf('done')>-1){
                    $('.message').html('Mail Send successfully');

                    $('#form-container').find('input[type="text"],input[type="file"],input[type="email"], textarea').val('');

                    listLocations(1);
                }
            }
        });
    }
}
function isFormValid(){
    return true;
}
