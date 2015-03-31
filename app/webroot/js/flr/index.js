var obj = $('#ClientFlrIndexForm');
 $(obj).validate();

$(function() {

    var commonPopupObj = $('#commonmessage');

    var backproceesingPopupObj = $('#backproceesing');

    $.validator.addMethod("onlyNumberWithoutFloat", function(value, element) {

        return this.optional(element) || Number(value) >= 0 && /^\+?(0|[0-9]\d*)$/.test(value);

    }, "Decimal not accepted");


    $("#ClientHeaderNuAgronomicPercnt").rules(
            "add", {
        required: true,
        maxlength: 5,
        messages: {
            required: 'Required ',
            maxlength: 'Maximum 5 characters '
        }
    });

    $("#ClientHeaderNuLivestockPercnt").rules(
            "add", {
        required: true,
        maxlength: 5,
        messages: {
            required: 'Required ',
            maxlength: 'Maximum 5 characters '
        }
    });

    $("#ClientHeaderNuBuildingPercnt").rules(
            "add", {
        required: true,
        maxlength: 5,
        messages: {
            required: 'Required ',
            maxlength: 'Maximum 5 characters '
        }
    });
    $("#ClientHeaderNuCivilPercnt").rules(
            "add", {
        required: true,
        maxlength: 5,
        messages: {
            required: 'Required ',
            maxlength: 'Maximum 5 characters '
        }
    });

    $(obj).delegate("#ClientHeaderNuAgronomicPercnt", 'change', function() {

        if ($.trim($("#ClientHeaderNuAgronomicPercnt").val()) != '')
            var agroValue = parseFloat($.trim($("#ClientHeaderNuAgronomicPercnt").val()));
        else
            var agroValue = 0;

        if ($.trim($("#ClientHeaderNuLivestockPercnt").val()) != '')
            var livestockValue = parseFloat($("#ClientHeaderNuLivestockPercnt").val());
        else
            var livestockValue = 0;

        var sumValue = agroValue + livestockValue;
        sumValue = sumValue.toFixed(2);
        if (sumValue != 100 && livestockValue != '') {

            $(backproceesingPopupObj).css('display', 'none');

            $(commonPopupObj).find('#messagetitle').html('');

            $(commonPopupObj).find('#messageshow').html('Sum value of Livestock and Agronomic should be equal to 100 ');

            $(commonPopupObj).css('display', 'block');
            $("#ClientHeaderNuAgronomicPercnt").val('');

        }

    });

    $(obj).delegate("#ClientHeaderNuLivestockPercnt", 'change', function() {

        if ($.trim($("#ClientHeaderNuAgronomicPercnt").val()) != '')
            var agroValue = parseFloat($.trim($("#ClientHeaderNuAgronomicPercnt").val()));
        else
            var agroValue = 0;

        if ($.trim($("#ClientHeaderNuLivestockPercnt").val()) != '')
            var livestockValue = parseFloat($("#ClientHeaderNuLivestockPercnt").val());
        else
            var livestockValue = 0;

        var sumValue = agroValue + livestockValue;
        sumValue = sumValue.toFixed(2);
        if (sumValue != 100 && agroValue != '') {

            $(backproceesingPopupObj).css('display', 'none');

            $(commonPopupObj).find('#messagetitle').html('');

            $(commonPopupObj).find('#messageshow').html('Sum value of Livestock and Agronomic should be equal to 100 ');

            $(commonPopupObj).css('display', 'block');

            $("#ClientHeaderNuLivestockPercnt").val('');

        }

    });


    $(obj).delegate("#ClientHeaderNuBuildingPercnt", 'change', function() {

        if ($.trim($("#ClientHeaderNuBuildingPercnt").val()) != '')
            var buildingValue = parseFloat($.trim($("#ClientHeaderNuBuildingPercnt").val()));
        else
            var buildingValue = 0;

        if ($.trim($("#ClientHeaderNuCivilPercnt").val()) != '')
            var CivilValue = parseFloat($("#ClientHeaderNuCivilPercnt").val());
        else
            var CivilValue = 0;

        var sumValue = buildingValue + CivilValue;
        sumValue = sumValue.toFixed(2);
        if (sumValue != 100 && CivilValue != '') {
            $(backproceesingPopupObj).css('display', 'none');

            $(commonPopupObj).find('#messagetitle').html('');

            $(commonPopupObj).find('#messageshow').html('Sum value of Building and Civil should be equal to 100 ');

            $(commonPopupObj).css('display', 'block');


            $("#ClientHeaderNuCivilPercnt").val('');

        }

    });

    $(obj).delegate("#ClientHeaderNuCivilPercnt", 'change', function() {

        if ($.trim($("#ClientHeaderNuBuildingPercnt").val()) != '')
            var buildingValue = parseFloat($.trim($("#ClientHeaderNuBuildingPercnt").val()));
        else
            var buildingValue = 0;

        if ($.trim($("#ClientHeaderNuCivilPercnt").val()) != '')
            var CivilValue = parseFloat($("#ClientHeaderNuCivilPercnt").val());
        else
            var CivilValue = 0;

        var sumValue = buildingValue + CivilValue;
        sumValue = sumValue.toFixed(2);

        if (sumValue != 100 && buildingValue != '') {

            $(backproceesingPopupObj).css('display', 'none');

            $(commonPopupObj).find('#messagetitle').html('');

            $(commonPopupObj).find('#messageshow').html('Sum value of Building and Civil should be equal to 100 ');

            $(commonPopupObj).css('display', 'block');

            $("#ClientHeaderNuBuildingPercnt").val('');

        }

    });


    $(obj).delegate("select[name*='vc_cateogry']", 'change', function() {
        //alert($('#ClientHeaderVcCateogry option:selected').text());
        var categoryValue = $('#ClientHeaderVcCateogry option:selected').val();
				//alert(categoryValue);

        if (categoryValue != '' && (categoryValue == 'A' || categoryValue == 'L')) {
            $('#rowid_agriculture').show();
            $('#rowid_construction').hide();
        }
        else if (categoryValue != '' && (categoryValue == 'B' || categoryValue == 'C')) {
            $('#rowid_construction').show();
            $('#rowid_agriculture').hide();
        } else {
            $('#rowid_construction').hide();
            $('#rowid_agriculture').hide();
        }
        //alert($("#ClientHeaderAgriculturehidden").val());
        //alert($("#ClientHeaderConstructionhidden").val());
        if ($("#ClientHeaderAgriculturehidden").val() == 'A') {

            $("#ClientHeaderNuAgronomicPercnt").val();
            $("#ClientHeaderNuLivestockPercnt").val();

        } else {

            $("#ClientHeaderNuAgronomicPercnt").val('');
            $("#ClientHeaderNuLivestockPercnt").val('');

        }

        if ($("#ClientHeaderConstructionhidden").val() == 'C') {
            $("#ClientHeaderNuBuildingPercnt").val();
            $("#ClientHeaderNuCivilPercnt").val();
        } else {
            $("#ClientHeaderNuBuildingPercnt").val('');
            $("#ClientHeaderNuCivilPercnt").val('');
        }



        parentValue = $(this).val();
        //alert(parentValue);

        $.ajax({
            type: "POST",
            url: GLOBLA_PATH + 'flr/clients/getRefundPercent',
            data: {
                data: $(this).val()
            },
            beforeSend: function() {
                $(backproceesingPopupObj).css('display', 'block');
            },
            success: function(data) {

                objJson = jQuery.parseJSON(data);

                if (objJson.nu_refund) {

                    $('#nu_refund').val(objJson.nu_refund);
                } else {
                    $('#nu_refund').val('');
                }
            },
            error: function(xhr, textStatus, errorThrown) {

                $(backproceesingPopupObj).css('display', 'none');

                $(commonPopupObj).find('#messagetitle').html('');

                $(commonPopupObj).find('#messageshow').html('Internet related error has been come please try again! ');

                $(commonPopupObj).css('display', 'block');

            }, complete: function() {
                $(backproceesingPopupObj).css('display', 'none');
            }
        });

    });

    $("input[name*='vc_id_no']").rules(
            "add", {
        required: true,
        alphanumericSpace: true,
        maxlength: 50,
        remote: {
            url: GLOBLA_PATH + "flr/clients/checkbussinessregid",
            type: "post",
            data: {
                id: function() {

                    if ($(obj).find("input[name *='enusrno']").length > 0) {
                        return $.trim($(obj).find("input[name *='enusrno']").val());
                    } else {
                        return '';
                    }
                }
            }

        },
        messages: {
            required: 'Please enter business reg. id',
            maxlength: 'Cannot use more than 50 characters',
            remote: 'Already used'
        }
    });

    $("input[name*='vc_client_name']").rules(
            "add", {
        required: true,
        /*alphabetic: true,*/
        maxlength: 200,
        messages: {
            required: 'Please enter client name',
            maxlength: 'Can not use more than 200 characters'
        }
    });

    $("input[name*='vc_contact_person']").rules(
            "add", {
        required: true,
       /*alphabetic: true,*/
        maxlength: 200,
        messages: {
            required: 'Please enter contact person name',
            maxlength: 'Can not use more than 200 characters'
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
            maxlength: 'Can not use more than 25 characters'
        }
    });


    $("input[name*='vc_postal_code2']").rules(
            "add", {
        maxlength: 25,
        required: true,
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
        required: true,
        messages: {
            maxlength: 'Can not use more than 15 characters',
            minlength: 'Should not be less than  7 characters',
            mobileUS: 'Please enter a valid mobile number',
            required: 'Please enter mobile number'
        }
    });

    $("input[name*='vc_cell_no2']").rules(
            "add", {
        maxlength: 15,
        minlength: 7,
        mobileUS: true,
        messages: {
            maxlength: 'Can not use more than 15 characters',
            minlength: 'Should not be less than  7 characters',
            mobileUS: 'Please enter a valid mobile number'
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
            required: 'Please enter email id',
            maxlength: 'Can not use more than 50 characters',
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

    $("select[name*='vc_cateogry']").rules(
            "add", {
        required: true,
        remote: {
            url: GLOBLA_PATH + "flr/clients/checkcategoryexist",
            type: "post",
            data: {
                emailId: function() {

                    return $(obj).find("input[name *='encemid']").val()

                },
                id: function() {

                    if ($(obj).find("input[name *='enusrno']").length > 0) {
                        return $.trim($(obj).find("input[name *='enusrno']").val());
                    } else {
                        return '';
                    }
                }

            },
            complete: function() {



            }
        },
        messages: {
            required: 'Please select Client Category',
            remote: 'Already used with email'

        }
    });

    $("input[name*='nu_fuel_usage']").rules(
            "add", {
        maxlength: 10,
        required: true,
        positiveNumber: true,
        onlyNumberWithoutFloat: true,
        messages: {
            required: 'Please enter fuel usage prev. year',
            maxlength: 'Can not use more than 10 characters',
            positiveNumber: 'Should be a number '
        }
    });


    $("input[name*='nu_expected_usage']").rules(
            "add", {
        maxlength: 10,
        required: true,
        positiveNumber: true,
        onlyNumberWithoutFloat: true,
        messages: {
            required: 'Please enter expected usages next year',
            maxlength: 'Can not use more than 10 characters',
            positiveNumber: 'Should be a number '
        }
    });


    $("input[name*='nu_off_road_usage']").rules(
            "add", {
        maxlength: 10,
        required: true,
        positiveNumber: true,
        onlyNumberWithoutFloat: true,
        messages: {
            required: 'Please enter off road usage prev. year',
            maxlength: 'Can not use more than 10 characters',
            positiveNumber: 'Should be a number '
        }
    });

    $("input[name*='nu_off_expected_usage']").rules(
            "add", {
        maxlength: 10,
        required: true,
        positiveNumber: true,
        onlyNumberWithoutFloat: true,
        messages: {
            required: 'Please enter off road usages next year',
            maxlength: 'Can not use more than 10 characters',
            positiveNumber: 'Should be a number '
        }
    });


    $("input[name*='fuelusagedoc']").rules(
            "add", {
        required: true,
        accept: true,
        filesize: true,
        messages: {
            required: 'Please upload document'
        }
    });

    $("input[name*='bankdoc']").rules(
            "add", {
        required: true,
        accept: true,
        filesize: true,
        messages: {
            required: 'Please upload document'
        }
    });

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
            maxlength: 'Can not use more than 25 characters'
        }
    });

    $("select[name*='vc_account_type']").rules(
            "add", {
        required: true,
        messages: {
            required: 'Please select account type',
        }
    });

    $("select[name*='vc_bank_name']").rules(
            "add", {
        required: true,
        messages: {
            required: 'Please select bank name',
        }
    });



    $("select[name*='vc_bank_branch_name']").rules(
            "add", {
        required: true,
        messages: {
            required: 'Please select branch name',
        }
    });

    function ApplyValidateOutlets() {

        $.validator.addMethod('uniqueCheck', function(value, element) {

            index = $(obj).find("select[name*='fueloutlets']").index(element);

            erro = true;

            $(obj).find("select[name*='fueloutlets']").each(function() {

                current = $(obj).find("select[name*='fueloutlets']").index(this);

                if ($.trim(value) == $(this).val() && index != current) {

                    erro = false;

                    return false;
                    ;
                }

            });

            return  erro;

        }, function(value, element) {
            $(element).val('');
            return "Already selected"
        });

        $(obj).find("select[name*='fueloutlets']").each(function() {

            $(this).rules(
                    "add", {
                required: true,
                uniqueCheck: true,
                messages: {
                    required: "Please select fuel outlet "

                }
            });

        });

    }

    ApplyValidateOutlets();

    $(obj).delegate("select[name*='vc_bank_name']", 'change', function() {

        parentValue = $(this).val();

        $(obj).find("input[name *='vc_branch_code']").val('');

        $(obj).find("select[name *='vc_bank_branch_name']").find("option[value !='']").remove();

        if ($(obj).find('#loading').length == 0) {

            $(obj).find("select[name *='vc_bank_branch_name']").replaceWith("<div id='loading' style='text-align:center;' ><img width='30px' src='" + GLOBLA_PATH + "img/loading.gif' > </img> </div>");


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

    $(obj).delegate("select[name*='vc_bank_branch_name']", 'change', function() {

        $(obj).find("input[name *='vc_branch_code']").val($(this).val()).trigger('blur');

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

            $(obj).find("input[name*='vc_email2']").val($.trim($(obj).find("input[name*='vc_email']").val())).trigger('blur');


        } else {

            var confirmObj = $('<p> Are you sure, you want to remove business address detail </p>');

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

                            $(obj).find("input[name*='vc_email2']").val('').trigger('blur');

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


    $(obj).delegate('#add img', 'click', function() {

        var max = 15;
		//var newarray[];

        var callObj = $(this);
		
        var parentObj = $(obj).find("select[name *='data[ClientFuelOutlet][fueloutlets]']");

        var outlestLenght = parentObj.length;

        var emptyValue = false;

        if (max >= outlestLenght) {

            var addStr = [];

            $(parentObj).each(function(k, v) {

                if ($.trim($(this).val()) == '') {

                    emptyValue = true;

                    return false;

                }
                if ($.trim($(this).val()) !== '') {

                    addStr[k] = $(this).val();

                }

            });

            if (emptyValue) {

                $(commonPopupObj).find('#messagetitle').html('');

                $(commonPopupObj).find('#messageshow').html(' Don\'t Leave Blank before adding a new row');

                $(commonPopupObj).css('display', 'block');

                return false;

            }

            $.ajax({
                type: "POST",
                url: GLOBLA_PATH + 'flr/clients/getoutletsdropdown',
                data: {
                    data: addStr
                },
                beforeSend: function() {
                    $(backproceesingPopupObj).css('display', 'block');
                },
                success: function(response) {
                    if ($(callObj).closest('tr').next('tr').length == 0) {
                        $(callObj).closest('tr').after('<tr><td width="75%" align="left" valign="top">&nbsp;</td><td width="25%" align="left" valign="top">&nbsp;</td></tr>');
                    }
                    var selectTr = $(callObj).closest('tr').next('tr');
                    var index = runtimeIndex(parentObj, '');

					
					var allexistfueloutlet = '';
					var selectname='data[ClientFuelOutlet][fueloutlets]';					
					allexistfueloutlet= $(obj).find('select[name*="'+selectname+'"]').length;				
					
					$(obj).find('select[name *="'+selectname+'"]').each(function() {
					
						var selectnewname='data[ClientFuelOutlet][fueloutlets]['+index+']';
						var currentname = $(this).attr('name');
						if(selectnewname==currentname){						
						index=index+1;
						}
						
					});
					
                    selectTr.find('td:first').html("<div class='outletslist'><select class='round_select5' name='data[ClientFuelOutlet][fueloutlets][" + index + "]'>" + response + "</select></div>");
                    selectTr.find('td:last').html($(callObj).closest('tr').find('.button-addmore').clone());
					
                    $(callObj).closest('tr').find('.button-addmore #add').remove();

                    ApplyValidateOutlets();

                },
                error: function(xhr, textStatus, errorThrown) {

                    $(backproceesingPopupObj).css('display', 'none');

                    $(commonPopupObj).find('#messagetitle').html('');

                    $(commonPopupObj).find('#messageshow').html('Internet related error has been come please try again! ');

                    $(commonPopupObj).css('display', 'block');

                },
                complete: function() {

                    $(commonPopupObj).css('display', 'none');

                    $(backproceesingPopupObj).css('display', 'none');
                }

            });

        }

    });


    $(obj).delegate('#remove img', 'click', function() {

        var min = 1;

        var callObj = $(this);

        var outlestLenght = $(obj).find("select[name*='data[ClientFuelOutlet][fueloutlets]']").length;

        var popmessage = $.trim($(this).closest('tr').find("select[name*='data[ClientFuelOutlet][fueloutlets]']").val());

        var message = popmessage != '' ? popmessage : 'this fuel outlet';

        widthdialog = 400 + parseInt(message.length);

        var confirmObj = $('<p> Are you sure, you want to remove ' + message + '.  </p>')

        if (outlestLenght > min) {
            $(function() {
                $(confirmObj).dialog({
                    resizable: false,
                    height: 160,
                    width: widthdialog,
                    modal: true,
                    buttons: {
                        "ok": function() {

                            if ($(callObj).closest('tr').find('#add').length > 0) {

                                $(callObj).closest('tr').prev('tr').find('td:last').html($(callObj).closest('tr').find('.button-addmore').clone());

                            }

                            $(callObj).closest('tr').remove();

                            $(this).dialog("close");
                        },
                        Cancel: function() {
                            $(this).dialog("close");
                        }
                    }
                });
            });

        }

    });

    function runtimeIndex(obj, number) {
		// alert($(obj).attr('id'));
		// alert(number+'--no');
	    //	alert($(obj).length+'--obj.length');
        ObjLength = number != '' ? number : $(obj).length;
		
		//alert(ObjLength);
	    //alert($(obj).find('[' + ObjLength + ']').length+'--olength');
        //var newfuelarray=Array();
	    var selectname='data[ClientFuelOutlet][fueloutlets]';
		
		/*
		$('#ClientFlrIndexForm').find('select[name *='"+selectname+"']').each(function() {
				//alert($(this).attr('name'));
		
		//newfuelarray[]=$(this).attr('name');
				console.log($(this).attr('name'));

		});
		*/
		
		if ($(obj).find('[' + ObjLength + ']').length == 0) {

            return ObjLength;

        }
		
        number = Math.floor(Math.random() * 30) + 1;

        runtimeIndex(obj, number);

    }
});

$('form').bind('submit', function(e) {
    if ($(obj).valid() == true) {
        $('.submit').attr('disabled', 'disabled');
        return true;
    }

});