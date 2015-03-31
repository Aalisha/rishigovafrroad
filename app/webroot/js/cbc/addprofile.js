 var obj = $('#CustomerCbcCustomerProfileForm');
 $(obj).validate();

 $(function() {   

    
    $.validator.addMethod("onlyNumberWithoutFloat", function(value, element) {

        return this.optional(element) || Number(value) >= 0 && /^\+?(0|[0-9]\d*)$/.test(value);

    }, "Decimal not accepted");

    $("#vc_company").rules(
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

    $("#vc_first_name").rules(
            "add", {
        required: true,
        maxlength: 50,
        /*alphabetic: true*/
        messages: {
            required: 'Please enter first name',
            maxlength: 'Should not be more than 50 characters'
            /*alphabetic: 'Alphabets only'*/
        }
    });

    $("#CustomerVcSurname").rules(
            "add", {
        required: true,
        maxlength: 50,
        /*alphabetic: true,*/
        messages: {
            required: 'Please enter surname',
            maxlength: 'Should not be more <br/>than 50 characters'
            /*alphabetic: 'Alphabets only'*/
        }
    });

    $("#vc_cont_per").rules(
            "add", {
        required: true,
        maxlength: 50,
        /*alphabetic: true*/
        messages: {
            required: 'Please enter contact <br/>person name',
            maxlength: 'Should not be more <br/>than 50 characters'
            /*alphabetic: 'Alphabets only'*/
        }
    });

    $("#vc_address1").rules(
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
            maxlength: 'Should  not be more <br/> than 15 characters',
            minlength: 'Should not be less than<br/>  7 characters',
            faxUS: 'Please enter a valid fax number'
        }
    });
    $("#vc_mobile_no").rules(
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

    $("#DocumentUploadCbcVcUploadDocName").rules(
            "add", {
        required: true,
        acceptdoc: true,
        filesize: true,
        messages: {
            required: 'Please upload a file'
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
           /* alphabetic: 'Alphabets only'*/
        }
    });

});

$("#submitcustomerprofileid").click(function () {

	if($(obj).valid()==true){
	
			$('#submitcustomerprofileid').attr('disabled', 'disabled');			
			$('#CustomerCbcCustomerProfileForm').submit();
			return true;
	}

});

/*
$('form').bind('submit', function(e) {
		//alert($(obj).valid());
		if($(obj).valid()==true){
			$('.submit').attr('disabled', 'disabled');    
			obj.submit();
			return true;
			}

	});*/