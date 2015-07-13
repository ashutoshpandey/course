$(function(){
    $("input[name='btn-create']").click(createSoftwareUser);

    $('a[href="#tab-edit"]').hide();
    $('#tab-edit').hide();

    listSoftwareUsers(1);
});

function createSoftwareUser(){

    if(isSoftwareUserFormValid()){

        var data = $("#form-create-softwareUser").serialize();

        $.ajax({
            url: root + '/save-softwareUser',
            type: 'post',
            data: data,
            dataType: 'json',
            success: function(result){

                if(result.message.indexOf('not logged')>-1)
                    window.location.replace(root);
                else if(result.message.indexOf('duplicate')>-1){
                    $('.message').html('Duplicate name for softwareUser');
                }
                else if(result.message.indexOf('done')>-1){
                    $('.message').html('SoftwareUser created successfully');

                    $('#form-container').find('input[type="text"], textarea').val('');

                    listSoftwareUsers(1);
                }
            }
        });
    }
}
function isSoftwareUserFormValid(){
    return true;
}

function listSoftwareUsers(page){

    var status = 'active';

    $.getJSON(
        root + '/admin-list-softwareUsers/' + status + '/' + page,
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

    if(data!=undefined && data.softwareUsers!=undefined && data.softwareUsers.length>0){

        var str = '';

        str = str + '<table id="grid-basic" class="table table-condensed table-hover table-striped"> \
            <thead> \
                <tr> \
                    <th data-column-id="id" data-type="numeric">ID</th> \
                    <th data-column-id="name">Name</th> \
                    <th data-column-id="email">Email</th> \
                    <th data-column-id="contact">Contact</th> \
                    <th data-formatter="link">Action</th> \
                </tr> \
            </thead> \
            <tbody>';

            for(var i =0;i<data.softwareUsers.length;i++){

                var softwareUser = data.softwareUsers[i];

                str = str + '<tr> \
                    <td>' + softwareUser.id + '</td> \
                    <td>' + softwareUser.name + '</td> \
                    <td>' + softwareUser.email + '</td> \
                    <td>' + softwareUser.contact_number_1 + '</td> \
                    <td></td> \
                </tr>';
            }

            str = str + '</tbody> \
        </table>';

    $('#softwareUser-list').html(str);

    $("#grid-basic").bootgrid({
        formatters: {
            'link': function(column, row)
            {
                var str = '<a target="_blank" href="' + root + '/admin-view-softwareUser/' + row.id + '">View</a>';
                str = str + '&nbsp;&nbsp; <a class="remove" href="#" rel="' + row.id + '">Remove</a>';
                str = str + '&nbsp;&nbsp; <a href="' + root + '/admin-courses/' + row.id + '">Courses</a>';

                return str;
            }
        }
    }).on("loaded.rs.jquery.bootgrid", function()
        {
            $(".remove").click(function(){
                var id = $(this).attr("rel");

                if(!confirm("Are you sure to remove this softwareUser?"))
                    return;

                $.getJSON(root + '/remove-softwareUser/' + id,
                    function(result){
                        if(result.message.indexOf('done')>-1)
                            listSoftwareUsers(1);
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
        $('#software-user-list').html('No software users found');
}