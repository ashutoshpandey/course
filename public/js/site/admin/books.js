$(function(){
    $("input[name='btn-create']").click(createBook);

    $('a[href="#tab-edit"]').hide();
    $('#tab-edit').hide();

    listBooks(1);
});

function createBook(){

    if(isBookFormValid()){

        var data = $("#form-create-book").serialize();

        $.ajax({
            url: root + '/save-book',
            type: 'post',
            data: data,
            dataType: 'json',
            success: function(result){

                if(result.message.indexOf('not logged')>-1)
                    window.location.replace(root);
                else{
                    $('.message').html('Book created successfully');

                    $('#form-container').find('input[type="text"], textarea').val('');

                    listBooks(1);
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
        root + '/admin-list-books/' + status + '/' + page,
        function(result){

            if(result.message.indexOf('not logged')>-1)
                window.location.replace(root);
            else{
                showGrid(result);
            }
        }
    );
}

function showGrid(data){

    if(data!=undefined && data.books!=undefined && data.books.length>0){

        var str = '';

        str = str + '<table id="grid-basic" class="table table-condensed table-hover table-striped"> \
            <thead> \
                <tr> \
                    <th data-column-id="id" data-type="numeric">ID</th> \
                    <th data-column-id="name">Name</th> \
                    <th data-column-id="author">Author</th> \
                    <th data-formatter="link">Action</th> \
                </tr> \
            </thead> \
            <tbody>';

        for(var i =0;i<data.books.length;i++){

            var book = data.books[i];

            str = str + '<tr> \
                    <td>' + book.id + '</td> \
                    <td>' + book.name + '</td> \
                    <td>' + book.author + '</td> \
                    <td></td> \
                </tr>';
        }

        str = str + '</tbody> \
        </table>';

    $('#book-list').html(str);

    $("#grid-basic").bootgrid({
        formatters: {
            'link': function(column, row)
            {
                var str = '<a target="_blank" href="' + root + '/admin-view-book/' + row.id + '">View</a>';
                str = str + '&nbsp;&nbsp; <a class="remove" href="#" rel="' + row.id + '">Remove</a>';

                return str;
            }
        }
    }).on("loaded.rs.jquery.bootgrid", function()
        {
            $(".remove").click(function(){
                var id = $(this).attr("rel");

                if(!confirm("Are you sure to remove this book?"))
                    return;

                $.getJSON(root + '/remove-book/' + id,
                    function(result){
                        if(result.message.indexOf('done')>-1)
                            listBooks(1);
                        else if(result.message.indexOf('not logged')>-1)
                            window.location.replace(root);
                        else
                            alert("Server returned error : " + result);
                    }
                );
            });
        });
    }
    else
        $('#book-list').html('No books found');

}