/**
 * Created by Hp on 18-07-2016.
 */
$(function(){
    $("input[name='btn-create']").click(createAccessory);

    $('a[href="#tab-edit"]').hide();
    $('#tab-edit').hide();

    listAccessory(1);
});

function createAccessory(){

    if(isBookFormValid()){

        $("#ifr").load(function(){
            $('.message').html('Accessory created successfully');

            $('#form-container').find('input[type="text"], input[type="date"],input[type="file"] ,textarea').val('');

            listAccessory(1);
        });

        return true;
    }
}

function isBookFormValid(){
    return true;
}

function listAccessory(page){

    var status = 'active';

    $.getJSON(
        root + 'admin-list-accessories/' + status + '/' + page,
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

    if(data!=undefined && data.accessories!=undefined && data.accessories.length>0){

        var str = '';

        str = str + '<table id="grid-basic" class="table table-condensed table-hover table-striped"> \
            <thead> \
                <tr> \
                    <th data-column-id="id" data-type="numeric">ID</th> \
                    <th data-column-id="name">Name</th> \
                    <th data-column-id="description">Type</th> \
                    <th data-formatter="link">Action</th> \
                </tr> \
            </thead> \
            <tbody>';

        for(var i =0;i<data.accessories.length;i++){

            var accessories = data.accessories[i];

            str = str + '<tr> \
                    <td>' + accessories.id + '</td> \
                    <td>' + accessories.name + '</td> \
                    <td>' + accessories.product_type + '</td> \
                    <td></td> \
                </tr>';
        }

        str = str + '</tbody> \
        </table>';

        $('#accessory-list').html(str);

        $("#grid-basic").bootgrid({
            formatters: {
                'link': function(column, row)
                {
                    var str = '<a target="_blank" href="' + root + 'admin-view-accessory/' + row.id + '">View</a>';
                    str = str + '&nbsp;&nbsp; <a class="remove" href="#" rel="' + row.id + '">Remove</a>';

                    return str;
                }
            }
        }).on("loaded.rs.jquery.bootgrid", function()
        {
            $(".remove").click(function(){
                var id = $(this).attr("rel");

                if(!confirm("Are you sure to remove this accessory?"))
                    return;

                $.getJSON(root + '/remove-accessory/' + id,
                    function(result){
                        if(result.message.indexOf('done')>-1)
                            listAccessory(1);
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
        $('#accessory-list').html('No accessories found');
}