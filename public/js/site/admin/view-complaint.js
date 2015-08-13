$(function(){
    $("input[name='btn-update-personal']").click(updatePersonal);
    $("input[name='btn-update-complaint']").click(updateComplaint);

    loadComplaintUpdates();
});

function updatePersonal(){

    if(isPersonalFormValid()){

        var data = $("#form-update-personal").serialize();

        $.ajax({
            url: root + '/update-complaint-personal',
            type: 'post',
            data: data,
            dataType: 'json',
            success: function(result){

                if(result.message.indexOf('not logged')>-1)
                    window.location.replace(root);
                else if(result.message.indexOf('done')>-1){
                    $('.message-personal').html('Personal information updated successfully');
                }
            }
        });
    }
}
function isPersonalFormValid(){
    return true;
}

function updateComplaint(){

    if(isComplaintFormValid()){

        var data = $("#form-update-complaint").serialize();

        $.ajax({
            url: root + '/add-complaint-update',
            type: 'post',
            data: data,
            dataType: 'json',
            success: function(result){

                if(result.message.indexOf('not logged')>-1)
                    window.location.replace(root);
                else if(result.message.indexOf('done')>-1){
                    loadComplaintUpdates();
                }
            }
        });
    }
}
function isComplaintFormValid(){
    return true;
}

function loadComplaintUpdates(){

    $.ajax({
        url: root + '/get-complaint-updates',
        type: 'get',
        dataType: 'json',
        success: function(result){

            if(result!=undefined && result.message!=undefined) {
                if (result.message == "found") {

                    var str = '';

                    var months = Array('Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec');

                    for (var i = 0; i < result.complaintUpdates.length; i++) {

                        var complaintUpdate = result.complaintUpdates[i];

                        var d = new Date(complaintUpdate.created_at);
                        var date = d.getDay() + '/' + months[d.getMonth()] + '/' + d.getFullYear() + ' , ' + pad(d.getHours()) + ':' + pad(d.getMinutes());

                        str += "<span class='date'>" + date + "</span><br/><br/>";

                        str += complaintUpdate.description;

                        str += "<br/><br/>";
                    }

                    $("#complaint-update-list").html(str);
                }
            }
        }
    });
}

function pad(x){
    if(x>9)
        return x;
    else
        return '0' + x;
}