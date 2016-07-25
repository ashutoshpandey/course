$(function(){
    $("input[name='btn-update']").click(updateInstitute);
});

function updateInstitute(){

    if(isInstituteFormValid()){

        var data = $("#form-update-institute").serialize();

        $.ajax({
            url: root + '/update-institute',
            type: 'post',
            data: data,
            dataType: 'json',
            success: function(result){

                if(result.message.indexOf('not logged')>-1)
                    window.location.replace(root);
                else if(result.message.indexOf('duplicate')>-1){
                    $('.message').html('Duplicate name for institute');
                }
                else if(result.message.indexOf('done')>-1){
                    $('.message').html('Institute updated successfully');
                }
            }
        });
    }
}
function isInstituteFormValid(){
    return true;
}

function loadCities(){

    var state = $("select[name='state']").val();

    $.ajax({
        url: root + '/admin-get-cities/' + state,
        type: 'get',
        dataType: 'json',
        success: function(result){

           $("select[name='city']").find('option').remove();
            
            if(result.message=="found"){

                for(var i=0; i<result.locations.length; i++){

                    var location = result.locations[i];

                    $("select[name='city']").append('<option value="' + location.id + '">' + location.city + '</option>');
                }
            }
        }
    });
}