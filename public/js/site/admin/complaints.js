$(function(){
    $("input[name='btn-create']").click(createComplaint);

    $('a[href="#tab-edit"]').hide();
    $('#tab-edit').hide();

    listComplaints(1);
});

function createComplaint(){

    if(isComplaintFormValid()){

        var data = $("#form-create-complaint").serialize();

        $.ajax({
            url: root + '/save-complaint',
            type: 'post',
            data: data,
            dataType: 'json',
            success: function(result){

                if(result.message.indexOf('not logged')>-1)
                    window.location.replace(root);
                else if(result.message.indexOf('duplicate')>-1){
                    $('.message').html('Duplicate name for complaint');
                }
                else if(result.message.indexOf('done')>-1){
                    $('.message').html('Complaint created successfully');

                    $('#form-container').find('input[type="text"],input[type="password"],input[type="email"], textarea').val('');

                    listComplaints(1);
                }
            }
        });
    }
}
function isComplaintFormValid(){
    return true;
}

function listComplaints(page){

    var status = 'active';

    $.getJSON(
        root + '/pending-complaints/' + page,
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

    if(data!=undefined && data.complaints!=undefined && data.complaints.length>0){

        var str = '';

        str = str + '<table id="grid-basic" class="table table-condensed table-hover table-striped"> \
            <thead> \
                <tr> \
                    <th data-column-id="id" data-type="numeric">ID</th> \
                    <th data-column-id="name">Name</th> \
                    <th data-column-id="city">Location</th> \
                    <th data-formatter="link">Action</th> \
                </tr> \
            </thead> \
            <tbody>';

            for(var i =0;i<data.complaints.length;i++){

                var complaint = data.complaints[i];

                str = str + '<tr> \
                    <td>' + complaint.id + '</td> \
                    <td>' + complaint.name + '</td> \
                    <td>' + complaint.location.city + ' / ' + complaint.location.state + '</td> \
                    <td></td> \
                </tr>';
            }

            str = str + '</tbody> \
        </table>';

    $('#complaint-list').html(str);

    $("#grid-basic").bootgrid({
        formatters: {
            'link': function(column, row)
            {
                var str = '<a target="_blank" href="' + root + '/admin-view-complaint/' + row.id + '">View</a>';
                str = str + '&nbsp;&nbsp; <a class="remove" href="#" rel="' + row.id + '">Remove</a>';
                str = str + '&nbsp;&nbsp; <a href="' + root + '/admin-courses/' + row.id + '">Courses</a>';

                return str;
            }
        }
    }).on("loaded.rs.jquery.bootgrid", function()
        {
            $(".remove").click(function(){
                var id = $(this).attr("rel");

                if(!confirm("Are you sure to remove this complaint?"))
                    return;

                $.getJSON(root + '/remove-complaint/' + id,
                    function(result){
                        if(result.message.indexOf('done')>-1)
                            listComplaints(1);
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
        $('#complaint-list').html('No complaints found');
}
