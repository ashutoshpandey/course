$(function(){
    $("input[name='btn-add']").click(saveBook);

    listBooks(1);
});

function saveBook(){

    if(isBookFormValid()){

        var data = $("#form-institute").serialize();

        $.ajax({
            url: root + '/save-book',
            type: 'post',
            data: data,
            dataType: 'json',
            success: function(result){

                if(result.message.indexOf('not logged')>-1)
                    window.location.replace(root);
                else{

                }
            }
        });
    }
}

function isBookFormValid(){
    return true;
}

function listBooks(page){

    var bookId = $('.book-id').attr('rel');
    var status = 'active';

    $.getJSON(
        root + '/admin-list-books/' + bookId + '/' + status + '/' + page,
        function(result){

            if(result.message.indexOf('not logged')>-1)
                window.location.replace(root);
            else{

            }
        }
    );
}
