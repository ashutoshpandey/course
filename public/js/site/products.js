$(document).ready(function () {

    $("#grid").click(function () {

        $(".data").addClass("show1");

    });
    $("#list").click(function () {

        $(".data").removeClass("show1");

    });

    $("input[name='subject']").click(getData);

    $(".add-to-bag").click(function(){
        var id = $(this).attr("rel");

        addToBag(id, $(this));
    });

//    $("input[name='select-all']").click(selectAll);
});

function getData(){

    var courseId = $('.book-list').attr('rel');

    var subjects = Array();

    $("input[name='subject']").each(function(){

        if($(this).is(':checked'))
            subjects.push($(this).val());
    });

    var subjectString;
    if(subjects.length>0)
        subjectString = subjects.toString();
    else
        subjectString = '';

    var url = root + '/get-course-books/' + courseId;

    $.ajax({
        url: url,
        type: 'POST',
        data: 'subjectString=' + subjectString,
        dataType: 'json',
        success: function(result){

            if(result!=undefined && result.message!=undefined && result.message.indexOf('found')>-1){

                if(result.books!=undefined && result.books.length>0){

                    var str = "<label><input type='checkbox' name='select-all'/> Select all products</label> <br/>";

                    str += "<ul id='content'>";

                    for(var i=0; i<result.books.length;i++){

                        var book = result.books[i];

                        str = str + "<li class='data'>";
                        str += "<div class='name-date'>";
                        str += "<span class='name'>" + book.name + "</span>";
                        str += "<br/>";
                        str += result.currency + ' ' + book.price;
                        str += "<br/>";
                        str += "By <b>" + book.author + "</b><br/><br/>";
                        str += "<label><input type='checkbox' name='pick-book' value='" + book.id + "'/> Pick this book </label>";
                        str += "</div>";
                        str += "</li>";
                    }

                    str += "</ul>";

                    $(".book-list").html(str);

//                    $("input[name='select-all']").unbind('click');
//                    $("input[name='select-all']").click(selectAll);

                    $(".add-to-bag").unbind('click');
                    $(".add-to-bag").click(function(){
                        var id = $(this).attr("rel");

                        addToBag(id, $(this));
                    });
                }
            }
            else{
                $(".book-list").html('No books found');
            }
        }
    });
}

function addToBag(id, obj){
    $.ajax({
        url: root + '/add-to-bag/' + id + '/1',
        type: 'get',
        dataType: 'json',
        success: function(result){

            if(result!=undefined && result.message!=undefined && (result.message.indexOf('done')>-1 || result.message.indexOf('duplicate')>-1)){
                $(obj).html('In bag');
                $('.bag').html(result.count).show();
                $(obj).removeClass('add-to-bag');
                $(obj).addClass('added-to-bag');
            }
        }
    });
}


function selectAll(){

    if($(this).is(':checked'))
        $("input[name='pick-book']").prop('checked', true);
    else
        $("input[name='pick-book']").prop('checked', false);
}

