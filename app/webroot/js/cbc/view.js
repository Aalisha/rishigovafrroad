
$(function() {

    var obj = $('#CustomerCbcViewForm');

    $(obj).validate();

    $.validator.addMethod("onlyNumberWithoutFloat", function(value, element) {

        return this.optional(element) || Number(value) >= 0 && /^\+?(0|[0-9]\d*)$/.test(value);

    }, "Decimal not accepted");

    $("#CustomerVcAlterEmail").rules(
            "add", {
        email: true,
        maxlength: 50,
        messages: {
            maxlength: 'Should not be more <br/>than 50 characters'
        }
    });

    $("#CustomerVcAlterPhoneNo").rules(
            "add", {
        maxlength: 15,
        minlength: 7,
        phoneUS: true,
        messages: {
            maxlength: 'Should not no be more <br/>than 15 characters',
            minlength: 'Should not be less than  7 characters',
            phoneUS: 'Please enter a valid contact number'
        }
    });

    $("#CustomerVcAlterContPerson").rules(
            "add", {
        maxlength: 50,
        /*alphabetic: true,*/
        messages: {
            maxlength: 'Should not be more <br/>than 50 characters'
            /*alphabetic: 'Alphabets only'*/
        }
    });

});