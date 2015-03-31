var obj = $('#CustomerCbcAddcomplaintForm');
$(function() {





    $(obj).validate();

    $.validator.addMethod("onlyNumberWithoutFloat", function(value, element) {

        return this.optional(element) || Number(value) >= 0 && /^\+?(0|[0-9]\d*)$/.test(value);

    }, "Decimal not accepted");

    $("#FeedbackDataLoggedBy").rules(
            "add", {
        required: true,
        maxlength: 100,
        /*alphabetic: true,*/
        messages: {
            required: 'Please enter your name',
            maxlength: 'Should not be more than 100 characters'
            /*alphabetic: 'Please enter only alphabets'*/
        }

    });

    $("#complaint_desc").rules(
            "add", {
        required: true,
        messages: {
            required: 'Please enter complaint description'
        }
    });

    $("#FeedbackDataContactNo").rules(
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

    $("#FeedbackDataUploadDoc1").rules(
            "add", {
        accept: true,
        filesize: true,
        messages: {
        }
    });



});

$('form').bind('submit', function(e) {
		if($(obj).valid()==true){
			$('.submit').attr('disabled', 'disabled');    
			return true;
			}

	});