$(function(){
    $("input[name='btn-update']").click(updateBook);
});

function updateBook(){

    if(isBookFormValid()){

        var data = $("#form-update-book").serialize();

        $.ajax({
            url: root + '/update-book',
            type: 'post',
            data: data,
            dataType: 'json',
            success: function(result){

                if(result.message.indexOf('not logged')>-1)
                    window.location.replace(root);
                else if(result.message.indexOf('duplicate')>-1){
                    $('.message').html('Duplicate name for book');
                }
                else if(result.message.indexOf('done')>-1){
                    $('.message').html('Book updated successfully');
                }
            }
        });
    }
}
function isBookFormValid(){
    return true;
}