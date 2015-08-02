$(document).ready(function () {

    $(".remove-bag-item").click(function(){
        var id = $(this).attr("rel");

        removeFromBag(id, $(this));
    });
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