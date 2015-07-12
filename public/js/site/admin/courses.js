$(function(){
    $("input[name='btn-create']").click(createCourse);

    $('a[href="#tab-edit"]').hide();
    $('#tab-edit').hide();

    listCourses(1);
});

function createCourse(){

    if(isCourseFormValid()){

        var data = $("#form-course").serialize();

        $.ajax({
            url: root + '/save-course',
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

function isCourseFormValid(){
    return true;
}

function listCourses(page){

    var instituteId = $('.institute-id').attr('rel');
    var status = 'active';

    $.getJSON(
        root + '/admin-list-courses/' + instituteId + '/' + status + '/' + page,
        function(result){

            if(result.message.indexOf('not logged')>-1)
                window.location.replace(root);
            else{

            }
        }
    );
}
