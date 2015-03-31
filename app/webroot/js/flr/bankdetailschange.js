var obj = $('#ClientFlrBankdetailschangesForm');
$(obj).validate();

$(function() {
    
    $("input[name*='vc_account_holder_name']").rules(
            "add", {
        required: true,
        maxlength: 100,
        /*alphabetic: true,*/
        messages: {
            required: 'Please enter account holder name',
            maxlength: 'Can not use more than 100 characters'
        }
    });

    $("input[name*='vc_bank_account_no']").rules(
            "add", {
        required: true,
        accountNumber: true,
        maxlength: 25,
        messages: {
            required: 'Please enter bank account no.',
            maxlength: 'Cant use more than 25 characters'
        }
    });

    $("select[name*='vc_account_type']").rules(
            "add", {
        required: true,
        messages: {
            required: 'Please select account type'

        }
    });

    $("select[name*='vc_bank_name']").rules(
            "add", {
        required: true,
        messages: {
            required: 'Please select bank name'

        }
    });



    $(obj).delegate("select[name*='vc_bank_name']", 'change', function() {

        parentValue = $(this).val();

        $(obj).find("input[name *='vc_branch_code']").val('');

        $(obj).find("select[name *='vc_bank_branch_name']").find("option[value !='']").remove();

        if ($(obj).find('#loading').length == 0) {

            $(obj).find("select[name *='vc_bank_branch_name']").replaceWith("<div id='loading' style='position:relative;float:left;left:55px;' ><img width='30px' src='" + GLOBLA_PATH + "img/loading_small.gif' > </img> </div>");


        }

        $.ajax({
            type: "GET",
            url: GLOBLA_PATH + 'flr/clients/getbranchlist',
            data: {
                data: $(this).val()
            }

        }).done(function(data) {

            $(obj).find('#loading').replaceWith(data).trigger('blur');


        });


    });

    $("select[name*='vc_bank_branch_name']").rules(
            "add", {
        required: true,
        messages: {
            required: 'Please select branch name',
        }
    });

    $("input[name*='bankdoc']").rules(
            "add", {
        required: true,
        accept: true,
        filesize: true,
        messages: {
            required: 'Please upload document'
        }});

    $(obj).delegate("select[name*='vc_bank_branch_name']", 'change', function() {

        $(obj).find("input[name *='vc_branch_code']").val($(this).val()).trigger('blur');

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
