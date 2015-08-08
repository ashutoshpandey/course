$(function(){

    listOrders(1);
});

function listOrders(page){

    var status = 'active';

    $.getJSON(
        root + '/get-user-orders/' + status + '/' + page,
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

    if(data!=undefined && data.orders!=undefined && data.orders.length>0){

        var str = '';

        str = str + '<table id="grid-basic" class="table table-condensed table-hover table-striped"> \
            <thead> \
                <tr> \
                    <th data-column-id="id" data-type="numeric">ID</th> \
                    <th data-column-id="amount">Amount</th> \
                    <th data-column-id="date">Date</th> \
                    <th data-formatter="link">Action</th> \
                </tr> \
            </thead> \
            <tbody>';

        for(var i =0;i<data.orders.length;i++){

            var order = data.orders[i];

            str = str + '<tr> \
                    <td>' + order.id + '</td> \
                    <td>' + order.net_amount + '</td> \
                    <td>' + order.created_at + '</td> \
                    <td></td> \
                </tr>';
        }

        str = str + '</tbody> \
        </table>';

        $('#order-list').html(str);

        $("#grid-basic").bootgrid({
            formatters: {
                'link': function(column, row)
                {
                    var str = '<a target="_blank" href="' + root + '/user-order/' + row.id + '">View</a>';

                    return str;
                }
            }
        });
    }
    else
        $('#order-list').html('No orders found');
}