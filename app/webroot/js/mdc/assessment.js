var obj = $('#ProfileAddassessmentForm');

var commonPopupObj = $('#commonmessage');

var logpopupObj = $('#logpopup');

var backproceesingPopupObj = $('#backproceesing');

var objDate = new Date();

var selectedFromDate;

var selectedToDate;

$(obj).validate();

$(function() {

    /*************Delete Row*************************/

    $(obj).find('#rmrow').click(function() {

        var setDefautShow = 1;

        var rowCount = $(obj).find('.listsr1 table tbody tr').length;

        var addobject = $(obj).find('.listsr1 table tbody');

        if (setDefautShow !== rowCount) {

            $(addobject).find('tr:last').remove();

        }

    });

    $(obj).find('#addrow').click(function() {

        var setMinNo = 1;

        var rowCount = $(obj).find('.listsr1 tbody tr').length;

        if (rowCount >= setMinNo) {

            addobject = $(obj).find('.listsr1 tbody');

            var vehiclelist = new Array();

            error = false;

            i = 0;

            $(addobject).find('tr').each(function() {

                if ($(this).find("[name*='vc_vehicle_lic_no']").val() === '') {

                    error = true;

                    return false;

                } else {

                    vehiclelist[i] = $(this).find("[name*='vc_vehicle_lic_no']").val();

                    i++;

                }

            });



            if (error) {

                $(commonPopupObj).find('#messageshow').html('Please fill above fields first');

                $(commonPopupObj).css('display', 'block');

            } else {


                if ($(addobject).find('#loading').length === 0) {

                    $(addobject).find('tr:last').after("<tr> <td colspan='10'> <div id='loading' style='text-align:center;' ><img width='30px' src='" + GLOBLA_PATH + "img/loading.gif' > </img> </div></td> </tr>");

                }
				
			$.ajax({
				type: "POST",
				url: GLOBLA_PATH + 'vehicles/gettableassessment',								
				data: {
					rowCount: rowCount,
					vehiclelist: vehiclelist
				},			
				beforeSend : function (){
							
				},
				success : function (data) {					
					
					$(addobject).find('tr:last').remove();

                    $(addobject).find('tr:last').after(data);

                    applylogdetailValidation();
					
				},
				error : function (xhr, textStatus, errorThrown) {
						
				},
				complete : function (){
						
				}
			});                


            }


        }

    });


    $('#vc_pay_from').datepicker({
        maxDate: "-" + objDate.getDate() + "D",
        defaultDate: "+1w",
        changeMonth: true,
        changeYear: true,
        dateFormat: 'MM yy',
        showButtonPanel: true,
        onClose: function() {

            var iMonth = $("#ui-datepicker-div .ui-datepicker-month :selected").val();

            var iYear = $("#ui-datepicker-div .ui-datepicker-year :selected").val();

            $("#vc_pay_to").datepicker("option", "minDate", new Date(iYear, iMonth, 1));

            $(this).datepicker('setDate', new Date(iYear, iMonth, 1));
			var clocnt=0;
			$(this).trigger('blur');
			   
			   $(obj).find('.listsr1').find("select[name*='[vc_vehicle_lic_no]']").each(function() {
					$("#"+$(this).attr('id')).prop("selectedIndex", 0);
				});
				$(obj).find('.listsr1').find("select[name*='[vc_vehicle_reg_no]']").each(function() {
					$("#"+$(this).attr('id')).prop("selectedIndex", 0);
				});
			   
			   
			//alert('hua');
        },
        beforeShow: function() {

            if ((selDate = $(this).val()).length > 0)
            {

                iYear = selDate.substring(selDate.length - 4, selDate.length);

                iMonth = jQuery.inArray(selDate.substring(0, selDate.length - 5), $(this).datepicker('option', 'monthNames'));

                $(this).datepicker('option', 'defaultDate', new Date(iYear, iMonth, 1));

                $(this).datepicker('setDate', new Date(iYear, iMonth, 1));
            }
        }
    });

    $('#vc_pay_to').datepicker({
        maxDate: "-" + objDate.getDate() + "D",
        defaultDate: "+1w",
        changeMonth: true,
        changeYear: true,
        dateFormat: 'MM yy',
        showButtonPanel: true,
        onClose: function(selectedDate) {

            var iMonth = $("#ui-datepicker-div .ui-datepicker-month :selected").val();

            var iYear = $("#ui-datepicker-div .ui-datepicker-year :selected").val();

            $(this).datepicker('setDate', new Date(iYear, iMonth, 1));
			
			$(this).trigger('blur');
			
			$(obj).find('.listsr1').find("select[name*='[vc_vehicle_lic_no]']").each(function() {
					$("#"+$(this).attr('id')).prop("selectedIndex", 0);
				});
				$(obj).find('.listsr1').find("select[name*='[vc_vehicle_reg_no]']").each(function() {
					$("#"+$(this).attr('id')).prop("selectedIndex", 0);
				});
        },
        beforeShow: function() {

            if ((selDate = $(this).val()).length > 0)
            {
                iYear = selDate.substring(selDate.length - 4, selDate.length);
                iMonth = jQuery.inArray(selDate.substring(0, selDate.length - 5), $(this).datepicker('option', 'monthNames'));
                $(this).datepicker('option', 'defaultDate', new Date(iYear, iMonth, 1));
                $(this).datepicker('setDate', new Date(iYear, iMonth, 1));
            }
        }
    });

    $(obj).find('.listsr1').delegate("select[name*='vc_vehicle_']", 'change', function() {

        parentObj = $(this);

        errorSet = false;

        counter = 0;

        $(obj).find('.listsr1').find("select[name*='vc_vehicle_']").each(function() {


            if ($(parentObj).val() === $(this).val()) {

                counter++;


            }



        });

        if (counter === 0 || counter > 1) {

            $(commonPopupObj).find('#messageshow').html('Already selected Vehicle License No. / Vehicle Registration No.   ');

            $(commonPopupObj).css('display', 'block');


        } else {

            fromDate = $(obj).find('#vc_pay_from').val();

            toDate = (obj).find('#vc_pay_to').val();

            selectedFromDate = fromDate;

            selectedToDate = toDate;

            if (toDate !== '' && fromDate !== '') {

                if ('license' === $(parentObj).attr('rel')) {

                    postdata = 'registration';


                } else if ('registration' === $(parentObj).attr('rel')) {

                    postdata = 'license';

                }

                $(parentObj).parent().parent().find('select[rel ="' + postdata + '"]').val($(parentObj).val());

                selectedValue = $(parentObj).parent().parent().find('select[rel ="license"]').val();

                licenseno = $(parentObj).parent().parent().find('select[rel ="license"]').find('option:selected').text();

                regisatrationno = $(parentObj).parent().parent().find('select[rel ="registration"]').find('option:selected').text();

                if (selectedValue !== '') {
					
					
			$.ajax({
				type: "POST",
				url: GLOBLA_PATH + 'vehicles/getselectvehicledetails',
				data: {
					licenseno: licenseno,
					regisatrationno: regisatrationno,
					toDate: toDate,
					fromDate: fromDate

				},	
				beforeSend : function (){
								
				 $(backproceesingPopupObj).css('display','block');				
								
				},
				success : function (data) {					
					
					objJson = jQuery.parseJSON(data);

                        if (objJson.checkExist) {

                            $(parentObj).parent().parent().find("[name*='vc_vehicle_lic_no']").trigger('blur');

                            $(parentObj).parent().parent().find("[name*='vc_vehicle_reg_no']").trigger('blur');

                            $(parentObj).parent().parent().find("[name*='vc_pay_frequency']").val(objJson.payFrequency).trigger('blur');

                            $(parentObj).parent().parent().find("[name*='vc_prev_end_om']").val(objJson.prevEndOm).trigger('blur');

                            $(parentObj).parent().parent().find("[name*='vc_end_om']").val(objJson.EndOm).trigger('blur');

                            $(parentObj).parent().parent().find("[name*='vc_km_travelled']").val(objJson.kmtraveled).trigger('blur');

                            $(parentObj).parent().parent().find("[name*='vc_rate']").val(objJson.rate).trigger('blur');

                            $(parentObj).parent().parent().find("[name*='vc_payable']").val(objJson.payable).trigger('blur');

                        } else {

                            $(parentObj).parent().parent().find('select[rel ="license"]').val('');

                            $(parentObj).parent().parent().find('select[rel ="registration"]').val('');

                            $(parentObj).parent().parent().find("[name*='vc_pay_frequency']").val('');

                            $(parentObj).parent().parent().find("[name*='vc_prev_end_om']").val('');

                            $(parentObj).parent().parent().find("[name*='vc_end_om']").val('');

                            $(parentObj).parent().parent().find("[name*='vc_km_travelled']").val('');

                            $(parentObj).parent().parent().find("[name*='vc_rate']").val('');

                            $(parentObj).parent().parent().find("[name*='vc_payable']").val('');

                            $(commonPopupObj).find('#messageshow').html('No Log has been made for selected date');

                            $(commonPopupObj).css('display', 'block');


                        }
					
				},
				error : function (xhr, textStatus, errorThrown) {
						
					$(backproceesingPopupObj).css('display','none');	

					$(commonPopupObj).find('#messageshow').html('Some error has been occured please try again !!!.');
					
                    $(commonPopupObj).css('display', 'block');	
					
					window.location.reload();
					
				},
				complete : function (){
						
					$(backproceesingPopupObj).css('display','none');
				
				}
			});                

			

                } else {

                    $(parentObj).parent().parent().find("[name*='vc_pay_frequency']").val('');

                    $(parentObj).parent().parent().find("[name*='vc_prev_end_om']").val('');

                    $(parentObj).parent().parent().find("[name*='vc_end_om']").val('');

                    $(parentObj).parent().parent().find("[name*='vc_km_travelled']").val('');

                    $(parentObj).parent().parent().find("[name*='vc_rate']").val('');

                    $(parentObj).parent().parent().find("[name*='vc_payable']").val('');

                    $(commonPopupObj).find('#messageshow').html('Please Select Vehicle License or Registration No.');

                    $(commonPopupObj).css('display', 'block');

                }


            } else {

                $(parentObj).val('');
                $(commonPopupObj).find('#messageshow').html('Please select Pay From and  Pay To Date');
                $(commonPopupObj).css('display', 'block');
            }

        }


    });

	
	
	

    $(obj).find('.listsr1').delegate("button[rel*='addlog']", "click", function() {

		//alert($(this).id);
        parentObj = $(this);
		var buttonid = parseInt($(this).attr('rel').split("addlog")[1],6);
		//buttonid= parseInt(split(parentObj,6));
		//alert(buttonid);
		//alert(parentObj);
		//	alert('nonew==='+$(parentObj).next().find('input[name ="logbuttonid"]').val());
        
		$fromDate = $(obj).find('#vc_pay_from').val();

        $toDate = (obj).find('#vc_pay_to').val();
        if ($toDate !== '' && $fromDate !== '') {

            selectedValue = $(parentObj).parent().parent().find('select[rel ="license"]').val();

            licenseno = $(parentObj).parent().parent().find('select[rel ="license"]').find('option:selected').text();

            regisatrationno = $(parentObj).parent().parent().find('select[rel ="registration"]').find('option:selected').text();

            if (selectedValue !== '') {

                $.ajax({
                    type: "POST",
                    url: GLOBLA_PATH + 'vehicles/getvehiclelogdetails',
                    data: {
                        licenseno: licenseno,
                        regisatrationno: regisatrationno,
                        toDate: $toDate,
                        fromDate: $fromDate
                    }

                }).done(function(data) {
					
                    $(logpopupObj).find('#showlogdata').html(data);
			    	//	alert(parentObj.attr('id'));
                    //  $(logpopupObj).find('#showlogdata1').html(parentObj.attr('id'));
					  //alert('last======'+$('#lastvalueodometerid').val());
				    //	data[AssessmentVehicleDetail][0][vc_end_om]
					 $('#vc_end_om_'+buttonid).val($('#lastvalueodometerid').val());
					 $('#vc_km_travelled_'+buttonid).val($('#lastvaluetotalkilometerid').val());
					
                    $(logpopupObj).css('display', 'block');

                });

            } else {
                $(commonPopupObj).find('#messageshow').html('Please Select Vehicle License or Registration No.');
                $(commonPopupObj).css('display', 'block');

            }

        } else {

            $(commonPopupObj).find('#messageshow').html('Please select Pay From  to Pay To Date');
            $(commonPopupObj).css('display', 'block');

        }

    });
	
    $(obj).delegate("input[id*='vc_pay_']", "change", function() {
		//alert('do');
		//$("select[name*='vc_vehicle_']").trigger('blur');
        fromDate = $(obj).find('#vc_pay_from').val();

        toDate = (obj).find('#vc_pay_to').val();

        document.getElementById("ProfileAddassessmentForm").reset();

        $(obj).find('#vc_pay_from').val(fromDate);

        $(obj).find('#vc_pay_to').val(toDate);


        selectedFromDate = fromDate;

        selectedToDate = toDate;

    });

});




$(obj).find("input[name *=vc_pay_month_to]").each(function() {

    $(this).rules("add", {
        required: true,
        messages: {
            required: 'Required'
        }});
});

$(obj).find("input[name *=vc_pay_month_from]").each(function() {

    $(this).rules("add", {
        required: true,
        messages: {
            required: 'Required'
        }});
});
/**** Main Validation ***********/

function applylogdetailValidation() {


    $(obj).find(".listsr1 input[name *=vc_vehicle_lic_no]").each(function() {

        $(this).rules("add", {
            required: true,
            messages: {
                required: 'Required'


            }});



    });

    $(obj).find(".listsr1 input[name *=vc_vehicle_reg_no]").each(function() {

        $(this).rules("add", {
            required: true,
            messages: {
                required: 'Required'


            }});


    });


    /***Validation For nu_start_ometer ******/

    $(obj).find(".listsr1 input[name *=vc_pay_frequency]").each(function() {

        $(this).rules("add", {
            maxlength: 20,
            messages: {
                maxlength: 'Maximum accept 20 character'


            }});


    });

    $(obj).find(".listsr1 input[name *=vc_prev_end_om]").each(function() {


        $(this).rules("add", {
            required: true,
            positiveNumber: true,
            maxlength: 15,
            messages: {
                required: 'Required',
                positiveNumber: 'only number',
                maxlength: 'Maximum accept 15 character'


            }});


    });


    $(obj).find(".listsr1 input[name *=vc_end_om]").each(function() {


        $(this).rules("add", {
            required: true,
            positiveNumber: true,
            maxlength: 15,
            messages: {
                required: 'Required',
                positiveNumber: 'only number',
                maxlength: 'Maximum accept 15 character'


            }});


    });

    $(obj).find(".listsr1 input[name *=vc_rate]").each(function() {


        $(this).rules("add", {
            required: true,
            positiveNumber: true,
            maxlength: 15,
            messages: {
                required: 'Required',
                positiveNumber: 'only number',
                maxlength: 'Maximum accept 15 character'


            }});


    });


    $(obj).find(".listsr1 input[name *=vc_payable]").each(function() {


        $(this).rules("add", {
            required: true,
            positiveNumber: true,
            maxlength: 15,
            messages: {
                required: 'Required',
                number: 'only number',
                maxlength: 'Maximum accept 15 character'


            }});


    });

    /***Validation For vc_orign******/

    $(obj).find(".listsr1 input[name *=vc_remarks]").each(function() {

        $(this).rules("add", {
            maxlength: 100,
            alphanumericSpace: true,
            messages: {
                maxlength: 'Maximum accept 100 character',
                alphanumericSpace: 'Accept only<br/>alphanumeric'

            }});
    });



}
/******End*********************/

applylogdetailValidation();


$(obj).bind('submit', function(e) {
		  
		   if($(this).valid()) {
				
				if( $(this).find('input[type ="submit"]').length > 0 ) {
				 
					$(this).find('input[type ="submit"]').attr('disabled', 'disabled');    
				} 
				
				if( $(this).find('button[type ="submit"]').length > 0 ) {
				 
					$(this).find('button[type ="submit"]').attr('disabled', 'disabled');    
				}
				
				$(this).find('button[type ="button"]').attr('disabled', 'disabled');
				
				return true;
		   }
		   
		   return false;

	 });	
