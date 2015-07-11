$(function(){
    $("input[name='btn-add']").click(saveInstitute);

    listInstitutes(1);
});

function saveInstitute(){

    if(isInstituteFormValid()){

        var data = $("#form-institute").serialize();

        $.ajax({
            url: root + '/save-institute',
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
function isInstituteFormValid(){
    return true;
}
function listInstitutes(page){

    var status = 'active';

    $.getJSON(
        root + '/admin-list-institutes/' + status + '/' + page,
        function(result){

            if(result.message.indexOf('not logged')>-1)
                window.location.replace(root);
            else{

            }
        }
    );
}
