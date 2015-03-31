
$(function() {

    var obj = $('#AllFeedbackUserfeedbackForm');

    $(obj).validate();

    /*
     **
     **
     **
     */

    $("#AllFeedbackVcCustomerName").rules(
            "add", {
        required: true,
        maxlength: 100,
        alphabetic: true,
        messages: {
            required: 'Please enter customer name',
            maxlength: 'Should not be more <br/>than 50 characters',
            alphabetic: 'Alphabets only'
        }
    });

    $("#AllFeedbackVcAddress1").rules(
            "add", {
        required: true,
        maxlength: 50,
        messages: {
            required: 'Please enter address 1',
            maxlength: 'Should not be more <br/>than 50 characters'
        }
    });

    $("#AllFeedbackVcAddress2").rules(
            "add", {
        maxlength: 50,
        messages: {
            maxlength: 'Should not be more <br/>than 50 characters'
        }
    });

    $("#AllFeedbackVcAddress3").rules(
            "add", {
        maxlength: 50,
        messages: {
            maxlength: 'Should not be more <br/>than 50 characters'
        }
    });
    $("#AllFeedbackVcTelNo").rules(
            "add", {
        maxlength: 15,
        minlength: 7,
        phoneUS: true,
        messages: {
            maxlength: 'Can not use more than 15 characters',
            minlength: 'Should not be less than  7 characters',
            phoneUS: 'Please enter a valid phone number'
        }
    });

    $("#AllFeedbackVcFaxN").rules(
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

    $("#AllFeedbackVcMobileNo").rules(
            "add", {
        required:true,
        maxlength: 15,
        minlength: 7,
        mobileUS: true,
        messages: {
            required: 'Please enter a mobile number',
            maxlength: 'Can not use more than 15 characters',
            minlength: 'Should not be less than  7 characters',
            mobileUS: 'Please enter a valid mobile number'
        }
    });

    $("#AllFeedbackVcEmailId").rules(
            "add", {
        required: true,
        email: true,
        maxlength: 50,
        messages: {
            required: 'Please enter email id',
            email: 'Please enter a valid emial id',
            maxlength: 'Should not be more <br/>than 50 characters'

        }
    });


    $("#AllFeedbackLoggedBy").rules(
            "add", {
        required: true,
        maxlength: 100,
        alphabetic: true,
        messages: {
            required: 'Please enter your name',
            maxlength: 'Should not be more than 100 characters',
            alphabetic: 'Alphabets only'
        }

    });


    $("#AllFeedbackCustomerType").rules(
            "add", {
        required: true,
        messages: {
            required: 'Please select type '

        }
    });

    $("#AllFeedbackPriorityType").rules(
            "add", {
        required: true,
        messages: {
            required: 'Please select complaint priority '

        }
    });

    $("#AllFeedbackComplaintType").rules(
            "add", {
        required: true,
        messages: {
            required: 'Please select complaint type'

        }
    });

    $("#AllFeedbackContactNo").rules(
            "add", {
        required:true,
        maxlength: 15,
        minlength: 7,
        phoneUS: true,
        messages: {
            required:'Please enter contact number',
            maxlength: 'Can not use more than 15 characters',
            minlength: 'Should not be less than  7 characters',
            phoneUS: 'Please enter a valid phone number'
        }
    });

    $("#complaint_desc").rules(
            "add", {
        required: true,
        messages: {
            required: 'Please enter complaint description'

        }
    });

    $("#AllFeedbackUploadDoc").rules(
            "add", {
        accept: true,
        filesize: true,
    });

});