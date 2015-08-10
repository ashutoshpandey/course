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
        $.ajax({
            url: root + '/update-order-courier',
            data: data,
            type: 'post',
            success: function(result){
                closePopup();
            }
        });
    });
});