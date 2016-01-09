var root;

$(function(){
    root = $('#root').attr('rel') + "/";

    getBag();
});

function getBag(){

    $.ajax({
        url: root + 'get-bag',
        type: 'get',
        dataType: 'json',
        success: function(result){
            if(result!=undefined) {

                if (result.message.indexOf('found') > -1)
                    $('.bag').html("[" + result.count + "] items").show();
                else if (result.message.indexOf('empty') > -1)
                    $('.bag').html("[0] items").show();
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
                data: data,
                success: function (result) {
                    callback(result);
                }
            });
        }
    }
}