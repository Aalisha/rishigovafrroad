
$(function() {

    var objDate = new Date();

    var commonPopupObj = $('#commonmessage');
	
	var backproceesingPopupObj = $('#backproceesing');

    var popObj = $('#popDiv3');

    var obj = $('#InspectorFeedbackformForm');

    var defaultExist = 0;

    var submitValue = false;

    $(obj).validate();

    var focusEndOdometerValue = 0;


    $(obj).find('.innerbody').delegate("#addshow", 'click', function() {

        $(popObj).css('display', 'block');

    });

    $(popObj).delegate("input[type *='radio']", 'click', function() {

        value = $(this).val();

        selectObj = $(this);
		
		$(commonPopupObj).css('display','none');	
		
		$(popObj).css('display', 'none');
		
		$(backproceesingPopupObj).css('display','block');
        
		$.ajax({
            type: "POST",
            url: GLOBLA_PATH + 'inspectors/getuserdetail',
            data: {
                data: value

            }

        }).done(function(data) {

            if (data) {

                $(obj).find('.innerbody:first').html(data);

                $(obj).scrollTop();

                applyValidateSelect();

                $(popObj).find("input[name *='search']").val('');

                $(popObj).find("input[type *='button']").trigger('click');

                $(popObj).css('display', 'none');
				
				$(backproceesingPopupObj).css('display','none');
							

            } else {

                $(parentObj).val('');
				
				$(backproceesingPopupObj).css('display','none');
				
                $(commonPopupObj).find('#messagetitle').html('Customer Name / RFA Account No.');

                $(commonPopupObj).find('#messageshow').html('In valid user name try again ');

                $(commonPopupObj).css('display', 'block');


            }
        });


    });

    $(obj).find('.innerbody').delegate("select[name*='vc_vehicle_']", 'change', function() {

        value = $(this).val();

        selectObj = $(this);

        comp_code = '';

        customer_no = '';

		$(backproceesingPopupObj).css('display','block');

        $.ajax({
            type: "POST",
            url: GLOBLA_PATH + 'inspectors/getvehicledetail',
            data: {
                value: value,
                customer_no: $('#vc_rfa_account_no').val()
            }

        }).done(function(data) {

            objJson = jQuery.parseJSON(data);
			
			$(backproceesingPopupObj).css('display','none');
			
            $('#vc_vehicle_lic_no').val(objJson.vc_vehicle_lic_no).trigger('blur');

            $('#vc_vehicle_reg_no').val(objJson.vc_vehicle_reg_no).trigger('blur');

            $('#vc_pay_frequency').val(objJson.vc_pay_frequency).trigger('blur');

            $.ajax({
                type: "POST",
                url: GLOBLA_PATH + 'inspectors/getvehiclelog',
                data: {
                    lic_no: objJson.vc_vehicle_lic_no,
                    reg_no: objJson.vc_vehicle_reg_no
                }

            }).done(function(data) {

                $(obj).find('.listsr1 tbody').html(data);

                defaultExist = $(obj).find('.listsr1 table tbody tr').length;

                getDate();

                applylogdetailValidation();

            });



        });

    });

    $(obj).find('.innerbody').delegate("textarea[name*='vc_remark']", 'change', function() {

        $(obj).find('.innerbody').find("textarea[name*='vc_remark']").each(function() {

            if ($(this).val() == '') {
                submitValue = true;
                return false;

            }


        });

    });

    $(obj).find('#rmrow').click(function() {

        var setDefautShow = 1;

        var rowCount = $(obj).find('.listsr1 table tbody tr').length;

        var addobject = $(obj).find('.listsr1 table tbody');

        if (setDefautShow != rowCount && defaultExist < rowCount) {

            $(addobject).find('tr:last').remove();

        }

        if (defaultExist == $(obj).find('.listsr1 table tbody tr').length) {

            submitValue = false;

        }

    });


    $(obj).find('#addrow').click(function() {

        var setMinNo = 1;

        var rowCount = $(obj).find('.listsr1 tbody tr').length;

        if (rowCount >= setMinNo && defaultExist > 0) {

            addobject = $(obj).find('.listsr1 tbody');

            var vehiclelist = new Array();

            error = false;

            i = 0;

            $(addobject).find('tr').each(function() {

                if ($(this).find("[name*='dt_log_date']").val() == ''

                        || $(this).find("[name*='vc_driver_name']").val() == ''

                        || $(this).find("[name*='nu_start_ometer']").val() == ''

                        || $(this).find("[name*='nu_end_ometer']").val() == ''

                        ) {

                    error = true;

                    return false;

                } else {

                    i++;

                }

            });



            if (error) {

                $(commonPopupObj).find('#messagetitle').html('Vehicle License No. / Vehicle Registration No.');

                $(commonPopupObj).find('#messageshow').html('Please fill firstly above fields');

                $(commonPopupObj).css('display', 'block');

            } else {


                if ($(addobject).find('#loading').length == 0) {

                    $(addobject).find('tr:last').after("<tr> <td colspan='10'> <div id='loading' style='text-align:center;' ><img width='30px' src='" + GLOBLA_PATH + "img/loading.gif' > </img> </div></td> </tr>");

                }


                $.ajax({
                    type: "POST",
                    url: GLOBLA_PATH + 'inspectors/getnewtablerow',
                    data: {
                        rowCount: rowCount


                    }

                }).done(function(data) {

                    $(addobject).find('tr:last').remove();

                    lastTrObj = $(addobject).find('tr:last');

                    $(lastTrObj).after(data);

                    afteAddTrObj = $(addobject).find('tr:last');

                    curr = parseInt($(lastTrObj).find("input[name *=nu_end_ometer]").val());

                    $(afteAddTrObj).find("input[name *=nu_start_ometer]").val(curr);

                    submitValue = true;

                    if (!$(addobject).find('tr:last').find(".addlog").hasClass("hasDatepicker")) {

                        $(addobject).find('tr:last').find(".addlog").datepicker({
                            maxDate: "0 D",
                            minDate: $(lastTrObj).find('[name*="dt_log_date"]').val(),
                            defaultDate: "+1w",
                            changeMonth: true,
                            dateFormat: 'd M yy',
                            numberOfMonths: 1
                        });

                    }


                    applylogdetailValidation();




                });


            }


        }

    });

    $(obj).validate({
	
        submitHandler: function(form) {

            // do other things for a valid form

            if (submitValue) {


                if (defaultExist > 0) {

                    $(form).submit();

                } else {

                    return false;

                }

            } else {


                $(commonPopupObj).find('#messagetitle').html('Vehicle License No. / Vehicle Registration No.');

                $(commonPopupObj).find('#messageshow').html('You  have not added any fields to submit ');

                $(commonPopupObj).css('display', 'block');


            }
        }
    });

    $(obj).find('.innerbody').delegate("input[name*='nu_end_ometer']", 'change', function() {

        if (/^\+?(0|[1-9]\d*)$/.test($(this).val())) {


            currentTrObj = $(this).parent().parent();

            nu_end_ometer = parseInt($(currentTrObj).find("input[name*='nu_end_ometer']").val());

            nu_start_ometer = parseInt($(currentTrObj).find("input[name*='nu_start_ometer']").val());

            var trObj = $(obj).find('.innerbody').find('[name*="nu_end_ometer"]');

            var total = $(trObj).length;

            var index = $(obj).find('.innerbody').find('[name*="nu_end_ometer"]').index(this);

            if (nu_end_ometer <= nu_start_ometer) {

                $(commonPopupObj).find('#messagetitle').html('End Odometer Reading');

                $(commonPopupObj).find('#messageshow').html('End Odometer Must be greater than Start Odometer');

                $(commonPopupObj).css('display', 'block');

                $(this).val(focusEndOdometerValue);


            } else {


                totalTraveled = nu_end_ometer - nu_start_ometer;

                $(currentTrObj).find("input[name*='nu_km_traveled']").val(totalTraveled).trigger('blur');

                i = 0;

                $(trObj).each(function() {

                    curIndex = $(obj).find('.innerbody').find('[name*="nu_end_ometer"]').index(this);

                    if (curIndex > index) {

                        if (i == 0) {

                            newenddometer = $(this).parent().parent().prev().find('[name*="nu_end_ometer"]').val();

                            $(this).parent().parent().find('[name*="nu_start_ometer"]').val(parseInt(newenddometer));

                        } else {


                            $(this).parent().parent().find('[name*="nu_start_ometer"]').val('');


                        }


                        $(this).parent().parent().find('[name*="nu_end_ometer"]').val('');

                        $(this).parent().parent().find('[name*="nu_km_traveled"]').val('');

                        $(this).parent().parent().find('[name*="nu_other_road_km_traveled"]').val('');

                        i++;


                    }

                });

            }

        } else {


            $(commonPopupObj).find('#messagetitle').html('Alert message');

            $(commonPopupObj).find('#messageshow').html('Invalid Data type');

            $(commonPopupObj).css('display', 'block');

            $(this).val(focusEndOdometerValue);


        }


    });

    /*** *** Apply Validates*************/

    function applyValidateSelect( ) {


        $(obj).find('.innerbody').find("select[name *='vc_vehicle_']").each(function() {

            $(this).rules("add", {
                required: true,
                messages: {
                    required: 'Required'

                }
            });

        });

    }

    applyValidateSelect();

    function getDate() {

        $(".addlog").datepicker({
            minDate: "0 D",
            maxDate: "0 D",
            defaultDate: "+1w",
            changeMonth: true,
            changeYear: true,
            dateFormat: 'd M yy'


        });
    }


    $(popObj).delegate("input[type='button']", 'click', function() {

        selectVal = $(this).prev("input[name *='search']").val();

        $.ajax({
            type: "POST",
            url: GLOBLA_PATH + 'inspectors/getcustomerdetailbysearch',
            data: {
                data: selectVal

            }

        }).done(function(data) {

            $(popObj).find('#ajaxshow').html(data);

        });

    });

    /**** Main Validation ***********/

    function applylogdetailValidation() {

        /***Validation For Date******/

        $(obj).find(".listsr1 input[name *=dt_log_date]").each(function() {

            $(this).rules("add", {
                required: true,
                maxlength: 12,
                date: true,
                messages: {
                    required: 'Required',
                    date: 'Should be format',
                    maxlength: 'Maximum accept 12 character'

                }
            });



        });

        /***Validation For vc_driver_name******/

        $(obj).find(".listsr1 input[name *=vc_driver_name]").each(function() {

            $(this).rules("add", {
                required: true,
                alphabetic: true,
                maxlength: 90,
                messages: {
                    required: 'Required',
                    alphabetic: 'only character',
                    maxlength: 'Maximum accept 90 character'


                }
            });



        });


        /***Validation For nu_start_ometer ******/

        $(obj).find(".listsr1 input[name *=nu_start_ometer]").each(function() {

            $(this).rules("add", {
                required: true,
                positiveNumber: true,
                maxlength: 15,
                messages: {
                    required: 'Required',
                    positiveNumber: 'only number',
                    maxlength: 'Maximum accept 15 character'


                }
            });



        });


        /***Validation For nu_end_ometer******/

        $(obj).find(".listsr1 input[name *=nu_end_ometer]").each(function() {


            $(this).rules("add", {
                required: true,
                positiveNumber: true,
                maxlength: 15,
                messages: {
                    required: 'Required',
                    positiveNumber: 'only number',
                    maxlength: 'Maximum accept 15 character'


                }
            });


        });


        /***Validation For vc_orign******/

        $(obj).find(".listsr1 input[name *=vc_orign]").each(function() {

            $(this).rules("add", {
                required: true,
                alphanumericSpace: true,
                maxlength: 50,
                messages: {
                    required: 'Required',
                    alphanumericSpace: 'Accept only<br/>alphanumeric',
                    maxlength: 'Maximum accept 50 character'


                }
            });



        });



        /***Validation For vc_destination******/



        $(obj).find(".listsr1 input[name *=vc_destination]").each(function() {


            $(this).rules("add", {
                required: true,
                alphanumericSpace: true,
                maxlength: 50,
                messages: {
                    required: 'Required',
                    alphanumericSpace: 'Accept only<br/>alphanumeric',
                    maxlength: 'Maximum accept 50 character'


                }
            });


        });
		
		 $(obj).find(".listsr1 input[name *=vc_other_road_destination]").each(function() {


            $(this).rules("add", {
                
                alphanumericSpace: true,
                maxlength: 50,
                messages: {
                   
                    alphanumericSpace: 'Accept only<br/>alphanumeric',
                    maxlength: 'Maximum accept 50 character'


                }
            });


        });
		
		
		 $(obj).find(".listsr1 input[name *=vc_other_road_orign]").each(function() {


            $(this).rules("add", {
               
                alphanumericSpace: true,
                maxlength: 50,
                messages: {
                   
                    alphanumericSpace: 'Accept only<br/>alphanumeric',
                    
					maxlength: 'Maximum accept 50 character'


                }
            });


        });

        /***Validation For nu_km_traveled******/

        $(obj).find(".listsr1 input[name *=nu_km_traveled]").each(function() {


            $(this).rules("add", {
                required: true,
                positiveNumber: true,
                maxlength: 15,
                messages: {
                    required: 'Required',
                    positiveNumber: 'only number',
                    maxlength: 'Maximum accept 15 character'


                }
            });


        });
	
       	
		$(obj).find(".listsr1 input[name *=nu_other_road_km_traveled]").each(function(){
		
		
				$(this).rules("add",{
					
					required 			: false,
					positiveNumber    	: true,
					
					lessThanEqualTo 	: true,
					
					maxlength    		: 15,
					
					messages 			: {

							positiveNumber     		: 'only number',
							
							maxlength    			: 'Maximum accept 15 characters',
							
							lessThanEqualTo			: 'Should be <br/>less than <br/> km travled on namibian <br/>road'


										}
				});


		});

        /***Validation For vc_remark******/

        $(obj).find(".listsr1 textarea[name *=vc_remark]").each(function() {


            $(this).rules("add", {
                maxlength: 500,
                alphanumericSpace: true,
                messages: {
                    maxlength: 'Maximum accept 500 character',
                    alphanumericSpace: 'Accept only<br/>alphanumeric'
                }
            });


        });
		
		
		 $(obj).find(".listsr1 input[name *=uploaddocs]").each(function() {


            $(this).rules( 
				  "add",	{
					accept:true,
					filesize:true
				});	


        });
		
		


        /******End*********************/
    }


    $(popObj).delegate(".close", 'click', function() {

        $(popObj).find("input[name *='search']").val('');

        $(popObj).find("input[type *='button']").trigger('click');

        $(popObj).css('display', 'none');

    });

    $(obj).find('.innerbody').delegate('[name*="nu_end_ometer"]', "focus", function() {

        focusEndOdometerValue = $.trim($(this).val());

    });
});