$(function(){

    initPopup($("input[name='btn-update-order']"));

    $("#grid-items").bootgrid({
        formatters: {
            'link': function(column, row)
            {
                var str = '<a target="_blank" href="' + root + '/admin-view-order/' + row.id + '">View</a>';

                return str;
            },
            'check': function(column, row){
                return '<input type="checkbox" name="check-item" value="' + row.id + '"/>';
            }
        }
    });

    $("input[name='check-select-all']").click(function(){

        if($(this).prop('checked'))
            $("input[name='check-item']").prop('checked', true);
        else
            $("input[name='check-item']").prop('checked', false);
    });

    $("input[name='btn-set-courier']").click(function(){

        $("#message-courier").html("");

        var docket = $("input[name='docket']").val();
        var courier = $("select[name='courier']").val();
        var ids = Array();

        $("input[name='check-item']").each(function(){

            if($(this).prop('checked'))
                ids.push($(this).val());
        });

        var data = 'docket=' + docket + '&courier=' + courier;
        if(ids.length>0)
            data = data + '&ids=' + ids.join();
        else{
            $("#message-courier").html("No item selected");
            return;
        }

        $.ajax({
            url: root + '/update-order-courier',
            data: data,
            type: 'post',
            dataType: 'json',
            success: function(result){

                if(result!=undefined && result.message!=undefined){

                    if(result.message.indexOf('done')>-1){
                        $("input[name='docket']").val('');
                        $("#message-courier").html("");

                        $("input[name='check-item']").prop('checked', false);

                        closePopup();
                    }
                    else{
                        $("#message-courier").html("Server returned invalid");
                    }
                }
                else{
                    $("#message-courier").html("Server returned error");
                }
            }
        });
    });
});