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

    var userType = '';

    if(data!=undefined && data.complaints!=undefined && data.complaints.length>0){

        userType = data.userType;

        var str = '';

        str = str + '<table id="grid-basic" class="table table-condensed table-hover table-striped"> \
            <thead> \
                <tr> \
                    <th data-column-id="id" data-type="numeric">ID</th> \
                    <th data-column-id="name">Name</th> \
                    <th data-column-id="city">Phone</th> \
                    <th data-formatter="link"></th> \
                </tr> \
            </thead> \
            <tbody>';

            for(var i =0;i<data.complaints.length;i++){

                var complaint = data.complaints[i];

                str = str + '<tr> \
                    <td>' + complaint.id + '</td> \
                    <td>' + complaint.name + '</td> \
                    <td>' + complaint.contact_number_1 + ' / ' + complaint.contact_number_2 + '</td> \
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
                if(userType=='Administrator')
                    str = str + '&nbsp;&nbsp; <a class="resolve" href="#" rel="' + row.id + '">Resolve</a>';

                return str;
            }
        }
    }).on("loaded.rs.jquery.bootgrid", function()
        {
            $(".resolve").click(function(){
                var id = $(this).attr("rel");

                if(!confirm("Are you sure to resolve this complaint?"))
                    return;

                $.getJSON(root + '/resolve-complaint/' + id,
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
