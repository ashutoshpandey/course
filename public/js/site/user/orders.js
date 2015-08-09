$(function () {

    $("#grid-items").bootgrid({
        formatters: {
            'link': function (column, row) {
                var str = '&nbsp;&nbsp; <a class="remove" href="#" rel="' + row.id + '">Remove</a>';

                return str;
            }
        }
    }).on("loaded.rs.jquery.bootgrid", function () {
        $(".remove").click(function () {
            var id = $(this).attr("rel");

            if (!confirm("Are you sure to remove this software user?"))
                return;

            $.getJSON(root + '/remove-software-user/' + id,
                function (result) {
                    if (result.message.indexOf('done') > -1)
                        listSoftwareUsers(1);
                    else if (result.message.indexOf('not logged') > -1)
                        window.location.replace(root);
                    else
                        alert("Server returned error : " + result);
                }
            );
        });
    });
});