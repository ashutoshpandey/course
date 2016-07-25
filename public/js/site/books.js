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

function getData() {

    var subjects = Array();

    $("input[name='subject']").each(function () {

        if ($(this).is(':checked'))
            subjects.push($(this).val());
    });

    var subjectString;
    if (subjects.length > 0)
        subjectString = subjects.toString();
    else
        subjectString = '';

    var url = root + 'get-course-products';

    $.ajax({
        url: url,
        type: 'POST',
        data: 'subjectString=' + subjectString,
        dataType: 'json',
        success: function (result) {

            if (result != undefined && result.message != undefined && result.message.indexOf('found') > -1) {

                if (result.products != undefined && result.products.length > 0) {

                    var str = "<label><input type='checkbox' name='select-all'/> Select all products</label> <br/>";

                    str += "<ul id='content'>";

                    for (var i = 0; i < result.products.length; i++) {

                        var product = result.products[i];

                        str = str + "<li class='data'>";
                        str += "<div class='name-date'>";
                        str += "<span class='name'>" + product.name + "</span>";
                        str += "<br/>";
                        str += result.currency + ' ' + product.price;
                        str += "<br/>";
                        str += "By <b>" + product.author + "</b><br/><br/>";

                        if (product.added == 'y')
                            str += "<span class='added-to-bag' rel='" + product.id + "'>In bag</span>";
                        else
                            str += "<span class='add-to-bag' rel='" + product.id + "'>Add to bag</span>";

                        str += "</div>";
                        str += "</li>";
                    }

                    str += "</ul>";

                    $(".product-list").html(str);
                }
            }
            else {
                $(".product-list").html('No products found');
            }
        }
    });
}

function addToBag(id, obj) {
    $.ajax({
        url: root + 'add-to-bag/' + id,
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
                // $("#modal-1").show();
                // $('.md-effect-1').addClass('md-show');
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
                $(obj).removeClass('add-to-bag');
                $(obj).addClass('added-to-bag');
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

