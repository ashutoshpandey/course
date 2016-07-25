/**
 * Created by Hp on 19-07-2016.
 */
$(document).ready(function () {

    $(".add-to-bag").on('click', function () {
        var id = $(this).attr("rel");

        addToBag(id, $(this));
    });

    $("#grid").click(function () {

        $(".data").addClass("show1");

    });
    $("#list").click(function () {

        $(".data").removeClass("show1");

    });

    $("input[name='subject']").click(getData);

    $(".select-all-change").click(function () { //remove only -change from this line
        var checkClass=$(this).hasClass('checked');
        if(checkClass == false){
            $("input[name='check-item']").prop('checked', true);
            $(this).addClass('checked');
            $('.add-all-to-bag').removeClass('hidden');
        }else{
            $("input[name='check-item']").prop('checked', false);
            $(this).removeClass('checked');
            $('.add-all-to-bag').addClass('hidden');
        }
        // selectAll();
    });
    $(".add-all-to-bag").click(selectAll);
});

function addToBag(id, obj) {
    $.ajax({
        url: root + 'add-accessory-to-bag/' + id,
        type: 'get',
        dataType: 'json',
        success: function (result) {

            if (result != undefined && result.message != undefined && (result.message.indexOf('done') > -1)) {
                //$(obj).html('In bag');
                // $('.bag').html(result.count).show();
                $('.bag').html("<span class='fa fa-shopping-cart'>["+result.count+"]</span>").show();
                $(obj).removeClass('add-to-bag');
                $(obj).addClass('added-to-bag');
            }else if(result.message.indexOf('duplicate') > -1){
                alert('Already added to bag');
            }
            else if (result.message.indexOf('not logged') > -1) {
                //window.location.replace(root);
                // $("#modal-1").modal('show');
                alert('Please Login');
            }
            else {

            }
        }
    });
}


function selectAll() {

    var ids = Array();

    $("input[name='check-item']").each(function(){

        if($(this).prop('checked'))
            ids.push($(this).val());
    });

    var data = '';
    if(ids.length>0)
        data = ids;
    else{
        $("#message").html("No item selected");
        return;
    }
    $.ajax({
        url: root + 'add-all-to-bag/' + data ,
        type: 'get',
        dataType: 'json',
        success: function (result) {

            if (result != undefined && result.message != undefined && (result.message.indexOf('done') > -1)) {
                //$(obj).html('In bag');
                // $('.bag').html(result.count).show();
                $('.bag').html("<span class='fa fa-shopping-cart'>["+result.count+"]</span>").show();
                //$(obj).removeClass('add-to-bag');
                //$(obj).addClass('added-to-bag');
            }else if(result.message.indexOf('duplicate') > -1){
                alert('Book :'+result.name+'<br>'+'Qty'+result.quantity);
            }
            else if (result.message.indexOf('not logged') > -1) {
                //window.location.replace(root);
                //$("#modal-1").modal('show');
                alert('Please Login');
            }
            else {

            }
        }
    });
}

