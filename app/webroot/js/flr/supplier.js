$(function() {

    var obj = $('#SupplierFlrSupplierForm');

    //var commonPopupObj = $('#commonmessage');

    $(obj).validate();


    $("input[name*='saledetails']").rules(
            "add", {
        required: true,
        accept: true,
        filesize: true,
        messages: {
            required: 'Please upload document'
        }
    });


});