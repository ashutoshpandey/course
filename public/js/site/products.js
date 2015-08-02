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

                    var str = "<label><input type='checkbox' name='select-all'/> Select all books</label> <br/>";

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
        url: root + '/add-to-bag/' + id,
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

/***************************************************************************************************/
/*************************************** pagging code*******************************/
$(document).ready(function () {

    //how much items per page to show
    var show_per_page = 12;
    //getting the amount of elements inside content div
    var number_of_items = $('#content').children().size();
    //calculate the number of pages we are going to have
    var number_of_pages = Math.ceil(number_of_items / show_per_page);

    //set the value of our hidden input fields
    $('#current_page').val(0);
    $('#show_per_page').val(show_per_page);

    //now when we got all we need for the navigation let's make it '

    /*
     what are we going to have in the navigation?
     - link to previous page
     - links to specific pages
     - link to next page
     */
    var navigation_html = '<a class="previous_link" href="javascript:previous();">Prev</a>';
    var current_link = 0;
    while (number_of_pages > current_link) {
        navigation_html += '<a class="page_link" href="javascript:go_to_page(' + current_link + ')" longdesc="' + current_link + '">' + (current_link + 1) + '</a>';
        current_link++;
    }
    navigation_html += '<a class="next_link" href="javascript:next();">Next</a>';

    $('#page_navigation').html(navigation_html);

    //add active_page class to the first page link
    $('#page_navigation .page_link:first').addClass('active_page');

    //hide all the elements inside content div
    $('#content').children().css('display', 'none');

    //and show the first n (show_per_page) elements
    $('#content').children().slice(0, show_per_page).css('display', 'block');

});

function previous() {

    new_page = parseInt($('#current_page').val()) - 1;
    //if there is an item before the current active link run the function
    if ($('.active_page').prev('.page_link').length == true) {
        go_to_page(new_page);
    }

}

function next() {
    new_page = parseInt($('#current_page').val()) + 1;
    //if there is an item after the current active link run the function
    if ($('.active_page').next('.page_link').length == true) {
        go_to_page(new_page);
    }

}
function go_to_page(page_num) {
    //get the number of items shown per page
    var show_per_page = parseInt($('#show_per_page').val());

    //get the element number where to start the slice from
    start_from = page_num * show_per_page;

    //get the element number where to end the slice
    end_on = start_from + show_per_page;

    //hide all children elements of content div, get specific items and show them
    $('#content').children().css('display', 'none').slice(start_from, end_on).css('display', 'block');

    /*get the page link that has longdesc attribute of the current page and add active_page class to it
     and remove that class from previously active page link*/
    $('.page_link[longdesc=' + page_num + ']').addClass('active_page').siblings('.active_page').removeClass('active_page');

    //update the current page input field
    $('#current_page').val(page_num);
}
/********************************************** pop-up-code*****************************************/

