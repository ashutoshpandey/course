var root;

$(function(){
    root = $('#root').attr('rel');

    getBag();
});

function getBag(){

    $.ajax({
        url: root + '/get-bag',
        type: 'get',
        dataType: 'json',
        success: function(result){
            if(result!=undefined && result.message!=undefined && result.message.indexOf('found')>-1){

                if(result.count!=undefined)
                    $('.bag').html(result.count).show();
                else
                    $('.bag').hide();
            }
            else
                $('.bag').hide();
        }
    });
}

function initPopup(source){

    var appendthis =  ("<div class='modal-overlay js-modal-close'></div>");

    $(source).click(function(e) {
        e.preventDefault();
        $("body").append(appendthis);
        $(".modal-overlay").fadeTo(500, 0.7);
        //$(".js-modalbox").fadeIn(500);
        var modalBox = $(this).attr('data-modal-id');
        $('#'+modalBox).fadeIn($(this).data());
    });


    $(".js-modal-close, .modal-overlay").click(function() {
        $(".modal-box, .modal-overlay").fadeOut(500, function() {
            $(".modal-overlay").remove();
        });
    });

    $(window).resize(function() {
        $(".modal-box").css({
            top: ($(window).height() - $(".modal-box").outerHeight()) / 2,
            left: ($(window).width() - $(".modal-box").outerWidth()) / 2
        });
    });

    $(window).resize();
}

function closePopup(){
    $(".modal-box, .modal-overlay").fadeOut(500, function() {
        $(".modal-overlay").remove();
    });
}