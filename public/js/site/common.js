var root;

$(function(){
    root = $('#root').attr('rel') + "/";

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

function ajaxCall(url, type, data, callback){

    if(data==null || data==undefined) {

        if(callback==null || callback==undefined) {
            $.ajax({
                url: root + url,
                type: type,
                success: function (result) {
                }
            });
        }
        else{
            $.ajax({
                url: url,
                type: type,
                success: function (result) {
                    callback(result);
                }
            });
        }
    }
    else{

        if(callback==null || callback==undefined) {

            $.ajax({
                url: url,
                type: type,
                data: data,
                success: function (result) {
                }
            });
        }
        else{
            $.ajax({
                url: url,
                type: type,
                success: function (result) {
                    callback(result);
                }
            });
        }
    }
}