/**
 * Created by Hp on 18-07-2016.
 */
$(function () {
    $("input[name='btn-update']").click(updateAccessory);
});

function updateAccessory() {

    if (isFormValid()) {


        $("#ifr").load(function(){
            $('.message').html('Accessory updated successfully');

            $('#form-container').find('input[type="text"], input[type="date"],input[type="file"] ,textarea').val('');

        });

        return true;

    }
}
function isFormValid() {
    return true;
}