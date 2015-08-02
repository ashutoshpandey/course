var root;

$(function(){
    root = $('#root').attr('rel');

    getBag();
});

function getBag(){

    $.ajax({
        url: root + '/get-bag',
        type: 'get',
        dataType: 'json',
        success: function(result){
            if(result!=undefined && result.message!=undefined && result.message.indexOf('found')>-1){

                if(result.count!=undefined)
                    $('.bag').html(result.count).show();
                else
                    $('.bag').hide();
            }
            else
                $('.bag').hide();
        }
    });
}