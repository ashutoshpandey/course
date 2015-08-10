$(function(){
    $("input[name='btn-create']").click(createCourier);

    $('a[href="#tab-edit"]').hide();
    $('#tab-edit').hide();

    listCouriers(1);

    loadCities();
});

function createCourier(){

    if(isCourierFormValid()){

        var data = $("#form-create-courier").serialize();

        $.ajax({
            url: root + '/save-courier',
            type: 'post',
            data: data,
            dataType: 'json',
            success: function(result){

                if(result.message.indexOf('not logged')>-1)
                    window.location.replace(root);
                else if(result.message.indexOf('duplicate')>-1){
                    $('.message').html('Duplicate name for courier');
                }
                else if(result.message.indexOf('done')>-1){
                    $('.message').html('Courier created successfully');

                    $('#form-container').find('input[type="text"], textarea').val('');

                    listCouriers(1);
                }
            }
        });
    }
}
function isCourierFormValid(){
    return true;
}

function listCouriers(page){

    var status = 'active';

    $.getJSON(
        root + '/admin-list-couriers/' + status + '/' + page,
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

    if(data!=undefined && data.couriers!=undefined && data.couriers.length>0){

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

            for(var i =0;i<data.couriers.length;i++){

                var courier = data.couriers[i];

                str = str + '<tr> \
                    <td>' + courier.id + '</td> \
                    <td>' + courier.name + '</td> \
                    <td>' + courier.email + '</td> \
                    <td>' + courier.contact_number_1 + '</td> \
                    <td></td> \
                </tr>';
            }

            str = str + '</tbody> \
        </table>';

    $('#courier-list').html(str);

    $("#grid-basic").bootgrid({
        formatters: {
            'link': function(column, row)
            {
                var str = '<a target="_blank" href="' + root + '/admin-view-courier/' + row.id + '">View</a>';
                str = str + '&nbsp;&nbsp; <a class="remove" href="#" rel="' + row.id + '">Remove</a>';
                str = str + '&nbsp;&nbsp; <a href="' + root + '/admin-courses/' + row.id + '">Courses</a>';

                return str;
            }
        }
    }).on("loaded.rs.jquery.bootgrid", function()
        {
            $(".remove").click(function(){
                var id = $(this).attr("rel");

                if(!confirm("Are you sure to remove this courier?"))
                    return;

                $.getJSON(root + '/remove-courier/' + id,
                    function(result){
                        if(result.message.indexOf('done')>-1)
                            listCouriers(1);
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
        $('#courier-list').html('No couriers found');
}

function loadCities(){

    var state = $("select[name='state']").val();

    $.ajax({
        url: root + '/admin-get-cities/' + state,
        type: 'get',
        dataType: 'json',
        success: function(result){

            $("select[name='city']").find('option').remove();

            if(result.message=="found"){

                for(var i=0; i<result.locations.length; i++){

                    var location = result.locations[i];

                    $("select[name='city']").append('<option value="' + location.id + '">' + location.city + '</option>');
                }
            }
        }
    });
}