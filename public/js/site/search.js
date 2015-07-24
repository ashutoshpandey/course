var keywordType;

$(function () {

    keywordType = 'i';

    $("#city").autocomplete({
        appendTo: "#reference-pane",
        source: function (request, response) {
            $.ajax({
                type: 'GET',
                url: root + '/search-cities/' + request.term,
                dataType: "json",
                success: function (data) {

                    if(data.message=="found")
                    response($.map(data.locations, function(obj) {
                        return {
                            label: obj.city + '-' + obj.state,
                            value: obj.city + '-' + obj.state,
                            id: obj.id
                        };
                    }));
                }
            })
        },
        minLength: 1,
        delay: 100,
        select: function(event, ui){
            $("#search-city").val(ui.item.id);
        }
    }).data("ui-autocomplete")._renderItem = function (ul, item) {
        return $("<li>")
            .data("item.autocomplete", item)
            .append("<a class='search-city' href='javascript:void(0)' rel='" + item.id + "'>" + item.label + "</a>")
            .appendTo(ul);
    };

    $("#keyword").autocomplete({
        appendTo: "#explore-by",
        source: function (request, response) {

            var url;
            var cityId = $("#search-city").val();

            if(cityId.length==0)
                url = root + '/search-keyword/' + request.term;
            else
                url = root + '/search-keyword/' + request.term + '/' + cityId;

            $.ajax({
                type: 'GET',
                url: url,
                dataType: "json",
                success: function (data) {

                    if(data.message=="found")
                    response($.map(data.institutes, function(obj) {

                        return {
                            label: obj.name,
                            value: obj.name,
                            id: obj.id
                        };
                    }));
                }
            })
        },
        minLength: 1,
        delay: 100,
        select: function(event, ui){
            $("#search-city").val(ui.item.id);
        }
    }).data("ui-autocomplete")._renderItem = function (ul, item) {
        return $("<li>")
            .data("item.autocomplete", item)
            .append("<a class='search-city' href='javascript:void(0)' rel='" + item.id + "'>" + item.label + "</a>")
            .appendTo(ul);
    };
});
