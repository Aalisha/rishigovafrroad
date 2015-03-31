/** 
 *
 */
var obj = $('#ClientFlrChangeofownershipForm');

/**
 *
 */

$(obj).validate();

$(function() {

    $("input[name*='vc_id_no']").each(function() {

        $(this).rules(
                "add", {
            required: true,
            alphanumericSpace: true,
            maxlength: 50,
            messages: {
                required: 'Please enter reg. id',
                maxlength: 'Cant use more than 50 characters'
            }
        });

    });

    $("input[name*='vc_client_name']").each(function() {

        $(this).rules(
                "add", {
            required: true,
            /*alphabetic: true,*/
            maxlength: 200,
            messages: {
                required: 'Please enter client Name',
                maxlength: 'Cant use more than 200 characters'
            }
        });

    });

    $("input[name*='vc_contact_person']").each(function() {

        $(this).rules(
                "add", {
            required: true,
            /*alphabetic: true,*/
            maxlength: 200,
            messages: {
                required: 'Please enter contact person name',
                maxlength: 'Cant use more than 200 characters'
            }
        });

    });

    $("input[name*='vc_address1']").rules(
            "add", {
        maxlength: 100,
        required: true,
        messages: {
            required: 'Please enter Address  ',
            maxlength: 'Cant use more than 100 characters'
        }
    });

    $("input[name*='vc_address2']").rules(
            "add", {
        maxlength: 50,
        messages: {
            maxlength: 'Cant use more than 50 characters'
        }
    });

    $("input[name*='vc_address3']").rules(
            "add", {
        maxlength: 50,
        messages: {
            maxlength: 'Can not use more than 50 characters'
        }
    });


    $("input[name*='vc_address4']").rules(
            "add", {
        maxlength: 100,
        required: true,
        messages: {
            required: 'Please enter address  ',
            maxlength: 'Can not use more than 100 characters'
        }
    });

    $("input[name*='vc_address5']").rules(
            "add", {
        maxlength: 50,
        messages: {
            maxlength: 'Can not use more than 50 characters'
        }
    });

    $("input[name*='vc_address6']").rules(
            "add", {
        maxlength: 50,
        messages: {
            maxlength: 'Can not use more than 50 characters'
        }
    });


    $("input[name*='vc_postal_code1']").rules(
            "add", {
        maxlength: 25,
        required: true,
        postalCode: true,
        messages: {
            required: 'Please enter postal code',
            maxlength: 'Cant use more than 25 characters'
        }
    });


    $("input[name*='vc_postal_code2']").rules(
            "add", {
        maxlength: 25,
        required: true,
        postalCode: true,
        messages: {
            required: 'Please enter postal code',
            maxlength: 'Cant use more than 25 characters'
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


    $("input[name*='vc_tel_no2']").rules(
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
        maxlength: 15,
        minlength: 7,
        mobileUS: true,
        required:true,
        messages: {
            maxlength: 'Can not use more than 15 characters',
            minlength: 'Should not be less than  7 characters',
            mobileUS: 'Please enter a valid mobile number',
            required:'Please enter mobile number'
        }
    });

    $("input[name*='vc_cell_no2']").rules(
            "add", {
        maxlength: 15,
        minlength: 7,
        mobileUS: true,
        required:true,
        messages: {
            maxlength: 'Can not use more than 15 characters',
            minlength: 'Should not be less than  7 characters',
            mobileUS: 'Please enter a valid mobile number',
            required:'Please enter mobile number'
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


    $("input[name*='vc_fax_no2']").rules(
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
            required: 'Please enter E-Mail Id',
            maxlength: 'Can not use more than 50 characters'
        }
    });


    $("input[name*='vc_email2']").rules(
            "add", {
        maxlength: 50,
        required: true,
        email: true,
        messages: {
            required: 'Please enter email id',
            maxlength: 'Can not use more than 50 characters'
        }
    });


    $(obj).delegate("input[type='checkbox']", 'change', function() {

        var checkObj = $(this);

        if ($(this).is(":checked")) {

            $(obj).find("input[name*='vc_address4']").val($.trim($(obj).find("input[name*='vc_address1']").val())).trigger('blur');

            $(obj).find("input[name*='vc_address5']").val($.trim($(obj).find("input[name*='vc_address2']").val())).trigger('blur');

            $(obj).find("input[name*='vc_address6']").val($.trim($(obj).find("input[name*='vc_address3']").val())).trigger('blur');

            $(obj).find("input[name*='vc_postal_code2']").val($.trim($(obj).find("input[name*='vc_postal_code1']").val())).trigger('blur');

            $(obj).find("input[name*='vc_tel_no2']").val($.trim($(obj).find("input[name*='vc_tel_no']").val())).trigger('blur');

            $(obj).find("input[name*='vc_cell_no2']").val($.trim($(obj).find("input[name*='vc_cell_no']").val())).trigger('blur');

            $(obj).find("input[name*='vc_fax_no2']").val($.trim($(obj).find("input[name*='vc_fax_no']").val())).trigger('blur');

        } else {

            var confirmObj = $('<p> Are you sure you want to remove Business Address Details ? </p>');

            $(function() {

                $(confirmObj).dialog({
                    resizable: false,
                    height: 160,
                    width: 475,
                    modal: true,
                    buttons: {
                        "ok": function() {

                            $(obj).find("input[name*='vc_address4']").val('').trigger('blur');

                            $(obj).find("input[name*='vc_address5']").val('').trigger('blur');

                            $(obj).find("input[name*='vc_address6']").val('').trigger('blur');

                            $(obj).find("input[name*='vc_postal_code2']").val('').trigger('blur');

                            $(obj).find("input[name*='vc_tel_no2']").val('').trigger('blur');

                            $(obj).find("input[name*='vc_cell_no2']").val('').trigger('blur');

                            $(obj).find("input[name*='vc_fax_no2']").val('').trigger('blur');

                            $(this).dialog("close");
                        },
                        Cancel: function() {

                            $(checkObj).prop('checked', true);

                            $(this).dialog("close");
                        }

                    }
                });
            });


        }

    });

    $("input[name*='ownershipchange']").rules(
            "add", {
        required: true,
        accept: true,
        filesize: true,
        messages: {
            required: 'Please upload document'
        }
    });

});

$(obj).bind('submit', function(e) {

    if ($(this).valid()) {


        if ($(this).find('input[type ="submit"]').length > 0) {

            $(this).find('input[type ="submit"]').attr('disabled', 'disabled');
        }

        if ($(this).find('button[type ="submit"]').length > 0) {

            $(this).find('button[type ="submit"]').attr('disabled', 'disabled');
        }

        return true;
    }
    return false;
});