$(function() {

    var obj = $('#ClientFlrConfirmbankdetailschangesForm');

    //var commonPopupObj = $('#commonmessage');

    $(obj).validate();


    $("input[name*='vc_random_code']").rules(
            "add", {
        required: true,       
        messages: {
            required: 'Please enter the verification pin'
        }
    });


});