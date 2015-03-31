var obj = $('#ClientsupplierFlrIndexForm');
$(function() {
	
	
	var commonPopupObj = $('#commonmessage');
	
	var backproceesingPopupObj = $('#backproceesing');
	
	$(obj).validate();
	
	$.validator.addMethod( "onlyNumberWithoutFloat",function(value, element) {
    
			return this.optional(element) || Number(value) >= 0 && /^\+?(0|[0-9]\d*)$/.test(value);
	
	}, "Decimal not accepted");
	

    $("input[name*='vc_client_name']").rules(
            "add", {
        required: true,
        alphabetic: true,
        maxlength: 100,
        messages: {
            required: 'Please enter client name',
            maxlength: 'Can not use more than 100 characters'
        }
    });

    $("input[name*='vc_fuel_outlet']").rules(
            "add", {
        required: true,
        alphabetic: true,
        maxlength: 100,
        messages: {
            required: 'Please enter fuel outlet name',
            maxlength: 'Can not use more than 100 characters'
        }
    });

    $("input[name*='vc_address1']").rules(
            "add", {
        maxlength: 100,
        required: true,
        messages: {
            required: 'Please enter address  ',
            maxlength: 'Can not use more than 100 characters'
        }
    });

    $("input[name*='vc_address2']").rules(
            "add", {
        maxlength: 50,
        messages: {
            maxlength: 'Can not use more than 50 characters'
        }
    });

    $("input[name*='vc_address3']").rules(
            "add", {
        maxlength: 50,
        messages: {
            maxlength: 'Can not use more than 50 characters'
        }
    });


    $("input[name*='vc_postal_code1']").rules(
            "add", {
        maxlength: 25,
       // required: true,
        postalCode: true,
        messages: {
            required: 'Please enter postal code',
            maxlength: 'Can not use more than 25 characters'
        }
    });



 $("input[name*='vc_tel_no']").rules(
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

    $("input[name*='vc_cell_no']").rules(
            "add", {
        required:true,
        maxlength: 15,
        minlength: 7,
        mobileUS: true,
        messages: {
            maxlength: 'Can not use more than 15 characters',
            minlength: 'Should not be less than  7 characters',
            mobileUS: 'Please enter a valid mobile number',
            required: 'Please enter mobile number'
        }
    });


    $("input[name*='vc_fax_no']").rules(
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



    $("input[name*='vc_email']").rules(
            "add", {
        maxlength: 50,
        required: true,
        email: true,
        messages: {
            required: 'Please enter email id',
            maxlength: 'Can not use more than 50 characters',
        }
    });
	 $("input[name*='fuelusagedoc']").rules(
            "add", {
       // required: true,
        accept: true,
        filesize: true,
        messages: {
            required: 'Please upload document'
        }
    });


  
	
	

    

    

    

   

   
    function runtimeIndex(obj, number) {

        ObjLength = number != '' ? number : $(obj).length;

        if ($(obj).find('[' + ObjLength + ']').length == 0) {

            return ObjLength;

        }

        number = Math.floor(Math.random() * 30) + 1;

        runtimeIndex(obj, number);

    }
});


$('form').bind('submit', function(e) {
		if($(obj).valid()==true){
			$('.submit').attr('disabled', 'disabled');    
			return true;
			}});