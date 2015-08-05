$(function(){

    $("input[name='chk-billing-same']").click(function(){
        if($(this).prop('checked'))
            $("#billing-container").hide();
        else
            $("#billing-container").show();
    });

    $("input[name='btn-address']").click(moveToPayment);
});

function moveToPayment(){

    var data = $("#form-address").serialize();

    $.ajax({
        url: root + '/checkout-update-address',
        type: 'post',
        data: data,
        dataType: 'json',
        success: function(result){

            if(result!=undefined && result.message!=undefined) {

                if (result.message.indexOf('done') > -1)
                    window.location.replace(root + '/checkout-payment');
                else if (result.message.indexOf('session') > -1)
                    window.location.replace(root);
            }
            else
                $(".message-guest").html('Invalid operation');
        }
    });
}