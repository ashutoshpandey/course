var keywordType;

$(function () {

    keywordType = 'i';

    $("#city").autocomplete({
        appendTo: "#reference-pane",
        source: root + '/search-cities',
        minLength: 1,
        delay: 100,
        select: function(item){
            alert(item);
        }
    });

    $("#keyword").autocomplete({
        appendTo: "#explore-by",
        source: root + '/search-keyword/' + keywordType,                 // i=> institute, b=> book
        minLength: 1,
        delay: 100,
        select: function(item){
            alert(item);
        }
    });

});

//$('#loc').click(function () {
//
//    $('#arw1').toggleClass('hide', 'show'); //Adds 'a', removes 'b' and vice versa
//
//
//});
/*******************second autosuggest**************/
//$(function () {
//    var availableTutorials = [
//        "ActionScript",
//        "Boostrap",
//        "C",
//        "C++",
//        "Ecommerce",
//        "Jquery",
//        "Groovy",
//        "Java",
//        "JavaScript",
//        "Lua",
//        "Perl",
//        "Ruby",
//        "Scala",
//        "Swing",
//        "XHTML"
//    ];
//    $("#keywords_input").autocomplete({
//        appendTo: "#explore-by",
//        minLength: 1,
//        delay: 100,
//        source: availableTutorials
//    });
//});