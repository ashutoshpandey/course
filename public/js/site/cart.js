$(document).ready(function () {

    $(".remove-bag-item").click(function(){
        var id = $(this).attr("rel");

        removeFromBag(id, $(this));
    });

    $(".checkout").click(function(){
        $.ajax({
            url: root + '/save-order/',
            type: 'get',
            dataType: 'json',
            success: function(result){

                if(result!=undefined && result.message!=undefined && result.message.indexOf('done')>-1){
                    window.location.replace(root + '/checkout');
                }
            }
        });
    });

    $(".payment").click(payment);
});

function removeFromBag(id, obj){
    $.ajax({
        url: root + '/remove-from-bag/' + id,
        type: 'get',
        dataType: 'json',
        success: function(result){

            if(result!=undefined && result.message!=undefined && result.message.indexOf('done')>-1){
                $(obj).html('In bag');
                $('.bag').html(result.count).show();
                $(obj).closest('.data').remove();
            }
        }
    });
}

function payment(){
    $.ajax({
        url: root + '/save-order',
        type: 'get',
        dataType: 'json',
        success: function(result){

            if(result!=undefined && result.message!=undefined){
                if(result.message.indexOf('done')>-1 || result.message.indexOf('exists')>-1) {
                    window.location.replace(root + '/checkout-login');
                }
            }
        }
    });
}