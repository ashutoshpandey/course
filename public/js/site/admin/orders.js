$(function () {

    listOrders(1);
});

function listOrders(page) {

    var status = 'pending';

    $.getJSON(
        root + '/admin-list-orders/' + status + '/' + page,
        function (result) {

            if (result.message.indexOf('not logged') > -1)
                window.location.replace(root);
            else {
                showGrid(result);
            }
        }
    );
}
function showGrid(data) {

    if (data != undefined && data.orders != undefined && data.orders.length > 0) {

        var str = '';

        str = str + '<table id="grid-basic" class="table table-condensed table-hover table-striped"> \
            <thead> \
                <tr>\
                    <th data-column-id="id" data-type="numeric">ID</th> \
                    <th data-column-id="customer_id">Customer id</th> \
                    <th data-column-id="name">Customer name</th> \
                    <th data-column-id="email">Email</th> \
                    <th data-column-id="amount">Amount</th> \
                    <th data-column-id="date">Date</th> \
                    <th data-formatter="link">Action</th> \
                </tr> \
            </thead> \
            <tbody>';

        for (var i = 0; i < data.orders.length; i++) {

            var order = data.orders[i];

            str = str + '<tr> \
                    <td>' + order.id + '</td> \
                    <td>' + order.user_id + '</td> \
                    <td>' + order.billing_name + '</td> \
                    <td>' + order.email + '</td> \
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
                'link': function (column, row) {
                    var str = '<a target="_blank" href="' + root + 'admin-view-order/' + row.id + '" title="View"><span class="fa fa-th"></span></a>';
                    str += '&nbsp;&nbsp;<a target="_blank" href="' + root + 'admin-generate-invoice/' + row.id + '" title="Generate Invoice"><span class="fa fa-file-pdf-o    "></span></a>';
                    // str+= '&nbsp;&nbsp;<a target="_blank" href="' + root + 'admin-send-invoice/' + row.id + '">Send Invoice</a>';
                    str = str + '&nbsp;&nbsp; <a class="send-invoice" href="#" rel="' + row.id + '" title="Send Invoice"><span class="fa fa-envelope"></span></a>';
                    return str;
                }
            }
        }).on("loaded.rs.jquery.bootgrid", function () {
            $(".send-invoice").click(function () {
                $('.message').html("Sending Mail");
                var id = $(this).attr("rel");

                $.getJSON(root + 'admin-send-invoice/' + id,
                    function (result) {
                        if (result.message.indexOf('done') > -1) {
                            alert('Mail Send Successfully');
                            $('.message').html("");
                        }
                        else if (result.message.indexOf('not logged') > -1)
                            window.location.replace(root);
                        else
                            alert("Server returned error : " + result);
                    }
                );
            });
            $('.message').html("");
        });
    }
    else
        $('#order-list').html('No orders found');
}