$(function() {

    var obj = $('#MemberCbcEditprofileForm');

    $(obj).validate();

    $.validator.addMethod("onlyNumberWithoutFloat", function(value, element) {

        return this.optional(element) || Number(value) >= 0 && /^\+?(0|[0-9]\d*)$/.test(value);

    }, "Decimal not accepted");

    $("#CustomerVcCompany").rules(
            "add", {
        required: true,
        maxlength: 50,
        /*alphabetic: true,*/
        messages: {
            required: 'Please enter company name',
            maxlength: 'Should not be more <br/>than 50 characters'
            /*alphabetic: 'Alphabets only'*/
        }
    });

    $("#CustomerVcFirstName").rules(
            "add", {
        required: true,
        maxlength: 50,
		/*alphabetic: true,*/
        messages: {
            required: 'Please enter first name',
            maxlength: 'Should not be more<br/> than 50 characters'
            /*alphabetic: 'Alphabets only' */
        }
    });

    $("#CustomerVcSurname").rules(
            "add", {
        required: true,
        maxlength: 50,
        /*alphabetic: true,*/
        messages: {
            required: 'Please enter surname ',
            maxlength: 'Should not be more<br/> than 50 characters'
            /*alphabetic: 'Alphabets only'*/
        }
    });

    $("#CustomerVcContPer").rules(
            "add", {
        required: true,
        maxlength: 50,
        /*alphabetic: true,*/
        messages: {
            required: 'Please enter contact<br/> person name',
            maxlength: 'Should not be more<br/> than 50 characters'
            /*alphabetic: 'Alphabets only'*/
        }
    });

    $("#CustomerVcAddress1").rules(
            "add", {
        required: true,
        maxlength: 50,
        messages: {
            required: 'Please enter address 1',
            maxlength: 'Should not be more <br/>than 50 characters'
        }
    });

    $("#CustomerVcAddress2").rules(
            "add", {
        maxlength: 50,
        messages: {
            maxlength: 'Should not be more <br/>than 50 characters'
        }
    });

    $("#CustomerVcAddress3").rules(
            "add", {
        maxlength: 50,
        messages: {
            maxlength: 'Should not be more <br/>than 50 characters'
        }
    });

    $("#CustomerVcTelNo").rules(
            "add", {
        maxlength: 15,
        minlength: 7,
        phoneUS: true,
        messages: {
            maxlength: 'Should not no be more <br/>than 15 characters',
            minlength: 'Should not be less than  7 characters',
            phoneUS: 'Please enter a valid phone number'
        }
    });

    $("#CustomerVcFaxNo").rules(
            "add", {
        maxlength: 15,
        minlength: 7,
        faxUS: true,
        messages: {
            maxlength: 'Can not use more than 15 characters',
            minlength: 'Should not be less than  7 characters',
            faxUS: 'Please enter a valid fax number'
        }
    });


    $("#CustomerVcMobileNo").rules(
            "add", {
        required:true,
        maxlength: 15,
        minlength: 7,
        mobileUS: true,
        messages: {
            required:'Please enter mobile number',
            maxlength: 'Should  not be more<br/> than 15 characters',
            minlength: 'Should not be less than  7 characters',
            mobileUS: 'Please enter a valid mobile number'
        }
    });
    $("#CustomerVcEmail").rules(
            "add", {
        required: true,
        email: true,
        maxlength: 50,
        messages: {
            required: 'Required',
            maxlength: 'Should not be more <br/>than 50 characters'
        }
    });

    $("#CustomerVcAlterEmail").rules(
            "add", {
        email: true,
        maxlength: 50,
        remote: {
            url: GLOBLA_PATH + "cbc/customers/getAlterEmailCheck",
            type: "post",
            data: {
                CustomerEditvalue: function() {
                    return $(obj).find("input[id=CustomerEditvalue]").val();
                },
                CustomerVcEmail: function() {
                    return $(obj).find("input[id=CustomerVcEmail]").val();
                },
                CustomerVcAlterEmail: function() {
                    return $(obj).find("input[id=CustomerVcAlterEmail]").val();
                }
            }
        },
        messages: {
            maxlength: 'Should not be more <br/>than 50 characters',
            remote: 'Email Id Already used '
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

    $("#DocumentUploadCbcVcUploadDocName").rules(
            "add", {
        required: true,
        acceptdoc: true,
        filesize: true,
        messages: {
            required: 'Please upload a file'
        }
    });

});