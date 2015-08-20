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

            if(result!=undefined && result.message!=undefined){

                if(result.message.indexOf('done')>-1) {

                    $(obj).closest('tr').remove();

                    if (result.count == 0) {
                        $('.bag').hide();
                        $(".course-list").html('');

                        var str = "<br/>";
                        str += "<h3>Your bag is empty</h3>";
                        str += "<br/>";
                        str += "<a href='{{$root}}'>Go to home</a>"

                        $(".course-list").append(str);
                    }
                    else
                        $('.bag').html(result.count).show();
                }
                else{
                    $('.bag').hide();
                    $(".course-list").html('');

                    var str = "<br/>";
                    str += "<h3>Your bag is empty</h3>";
                    str += "<br/>";
                    str += "<a href='{{$root}}'>Go to home</a>"

                    $(".course-list").append(str);
                }
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