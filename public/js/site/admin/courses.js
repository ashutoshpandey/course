$(function(){
    $("input[name='btn-create']").click(createCourse);

    $('a[href="#tab-edit"]').hide();
    $('#tab-edit').hide();

    listCourses(1);
});

function createCourse(){

    if(isCourseFormValid()){

        var data = $("#form-create-course").serialize();

        $.ajax({
            url: root + '/save-course',
            type: 'post',
            data: data,
            dataType: 'json',
            success: function(result){

                if(result.message.indexOf('not logged')>-1)
                    window.location.replace(root);
                else if(result.message.indexOf('done')>-1){
                    $('#form-container').find('input[type="text"], textarea').val('');

                    $('.message').html('Course created successfully');

                    listCourses(1);
                }
            }
        });
    }
}

function isCourseFormValid(){
    return true;
}

function listCourses(page){

    var courseId = $('.course-id').attr('rel');
    var status = 'active';

    $.getJSON(
        root + '/admin-list-courses/' + status + '/' + page,
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

    if(data!=undefined && data.courses!=undefined && data.courses.length>0){

        var str = '';

        str = str + '<table id="grid-basic" class="table table-condensed table-hover table-striped"> \
            <thead> \
                <tr> \
                    <th data-column-id="id" data-type="numeric">ID</th> \
                    <th data-column-id="name">Name</th> \
                    <th data-column-id="description">Description</th> \
                    <th data-formatter="link">Action</th> \
                </tr> \
            </thead> \
            <tbody>';

        for(var i =0;i<data.courses.length;i++){

            var course = data.courses[i];

            str = str + '<tr> \
                    <td>' + course.id + '</td> \
                    <td>' + course.name + '</td> \
                    <td>' + course.description + '</td> \
                    <td></td> \
                </tr>';
        }

        str = str + '</tbody> \
        </table>';

        $('#course-list').html(str);

        $("#grid-basic").bootgrid({
            formatters: {
                'link': function(column, row)
                {
                    var str = '<a target="_blank" href="' + root + '/admin-view-course/' + row.id + '">View</a>';
                    str = str + '&nbsp;&nbsp; <a class="remove" href="#" rel="' + row.id + '">Remove</a>';
                    str = str + '&nbsp;&nbsp; <a href="' + root + '/admin-books/' + row.id + '">Books</a>';

                    return str;
                }
            }
        }).on("loaded.rs.jquery.bootgrid", function()
            {
                $(".remove").click(function(){
                    var id = $(this).attr("rel");

                    if(!confirm("Are you sure to remove this course?"))
                        return;

                    $.getJSON(root + '/remove-course/' + id,
                        function(result){
                            if(result.message.indexOf('done')>-1)
                                listCourses(1);
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
        $('#course-list').html('No courses found');
}