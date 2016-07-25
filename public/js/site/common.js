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
                    // $('.bag').html("[" + result.count + "] items").show();
                    $('.bag').html("<span class='fa fa-shopping-cart'>["+result.count+"]</span>").show();
                else if (result.message.indexOf('empty') > -1)
                    // $('.bag').html("[0] items").show();
                    $('.bag').html("<span class='fa fa-shopping-cart'>["+0+"]</span>").show();
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