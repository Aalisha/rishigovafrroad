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
		$.ajax({
			type: "POST",
			url: GLOBLA_PATH + 'inspectors/feedbackgetuserdetail',							
			data: {
                data: value.toString()
            },		
			beforeSend : function (){
				$(backproceesingPopupObj).css('display','block');
			},
			success : function (data) {	
				if (data) {
					
					$(obj).find('.innerbody:first').html(data);

					$(obj).scrollTop();

					applyValidateSelect();

					$(popObj).find("input[name *='search']").val('');

					$(popObj).find("input[type *='button']").trigger('click');
					
					$.ajax({
						type: "POST",
						url: GLOBLA_PATH + 'inspectors/getvehiclelog',
						data: {
							lic_no: $('#vc_vehicle_lic_no').val(),
							reg_no: $('#vc_vehicle_reg_no').val()
						}

					}).done(function(data) {

						$(obj).find('#tbody1').html(data);

						defaultExist = $(obj).find('#tbody1 tr').length;

						getDate();

						applylogdetailValidation();

					});
					
					$(popObj).css('display', 'none');
				
					$(backproceesingPopupObj).css('display','none');
						

				} else {

					$(backproceesingPopupObj).css('display','none');

					$(commonPopupObj).find('#messagetitle').html('Customer Name / RFA Account No.');

					$(commonPopupObj).find('#messageshow').html('In valid user name try again ');

					$(commonPopupObj).css('display', 'block');


				}
				
			},
			error : function (xhr, textStatus, errorThrown) {
					
					$(popObj).css('display', 'none');
					
					$(backproceesingPopupObj).css('display','none');
					
					$(commonPopupObj).find('#messagetitle').html('Customer Name / RFA Account No.');

					$(commonPopupObj).find('#messageshow').html('Internet related error has been come please try again! ');

					$(commonPopupObj).css('display', 'block');	
			},
			complete : function (){
				$(popObj).css('display', 'none');
				$(backproceesingPopupObj).css('display','none');		
			}
		});
        
    });

	/*
	**
	**same function for 2nd Row
	**
	*/
	$(popObj).delegate("input[type *='radio']", 'click', function() {
		value = $(this).val();
		selectObj = $(this);		
		$.ajax({
			type: "POST",
			url: GLOBLA_PATH + 'inspectors/feedbackgetuserdetail',							
			data: {
                data: value.toString()
            },		
			beforeSend : function (){
				$(backproceesingPopupObj).css('display','block');
			},
			success : function (data) {	
				if (data) {
					
					$(obj).find('.innerbody:first').html(data);

					$(obj).scrollTop();

					applyValidateSelect();

					$(popObj).find("input[name *='search']").val('');

					$(popObj).find("input[type *='button']").trigger('click');
					
					$.ajax({
						type: "POST",
						url: GLOBLA_PATH + 'inspectors/getvehiclelog2',
						data: {
							lic_no: $('#vc_vehicle_lic_no').val(),
							reg_no: $('#vc_vehicle_reg_no').val()
						}

					}).done(function(data) {

							$(obj).find('#tbody2').html(data);

						defaultExist = $(obj).find('#tbody2 tr').length;

						getDate();

						applylogdetailValidation1();

					});
					
					$(popObj).css('display', 'none');
				
					$(backproceesingPopupObj).css('display','none');
						

				} else {

					$(backproceesingPopupObj).css('display','none');

					$(commonPopupObj).find('#messagetitle').html('Customer Name / RFA Account No.');

					$(commonPopupObj).find('#messageshow').html('In valid user name try again ');

					$(commonPopupObj).css('display', 'block');


				}
				
			},
			error : function (xhr, textStatus, errorThrown) {
					
					$(popObj).css('display', 'none');
					
					$(backproceesingPopupObj).css('display','none');
					
					$(commonPopupObj).find('#messagetitle').html('Customer Name / RFA Account No.');

					$(commonPopupObj).find('#messageshow').html('Internet related error has been come please try again! ');

					$(commonPopupObj).css('display', 'block');	
			},
			complete : function (){
				$(popObj).css('display', 'none');
				$(backproceesingPopupObj).css('display','none');		
			}
		});
        
    });
	
	/**
	**
	** end of function
	**
	*/
    
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

                $(obj).find('#tbody1').html(data);

                defaultExist = $(obj).find('#tbody1 tr').length;

                getDate();

                applylogdetailValidation();

            });



        });

    });
	
	/*
	**
	**same function for 2nd Row
	**
	**
	*/
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
                url: GLOBLA_PATH + 'inspectors/getvehiclelog2',
                data: {
                    lic_no: objJson.vc_vehicle_lic_no,
                    reg_no: objJson.vc_vehicle_reg_no
                }

            }).done(function(data) {

                $(obj).find('#tbody2').html(data);

                defaultExist = $(obj).find('#tbody2 tr').length;

                getDate();

                applylogdetailValidation1();

            });



        });

    });
	
	/*
	**
	*/
	

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

                    $(addobject).find('tr:last').after("<tr> <td colspan='12'> <div id='loading' style='text-align:center;' ><img width='30px' src='" + GLOBLA_PATH + "img/loading.gif' > </img> </div></td> </tr>");

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
                            numberOfMonths: 1,
							onClose: function() {
								$(this).trigger('blur');
							}	

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
				
				$(currentTrObj).find("select[name*='vc_orign']").val('');

				$(currentTrObj).find("select[name*='vc_destination']").val('');
				
				$(currentTrObj).find("select[name*='vc_other_road_orign']").val('');
				
				$(currentTrObj).find("select[name*='vc_other_road_destination']").val('');
				
				$(currentTrObj).find("input[name*='nu_other_road_km_traveled']").val('');

            }

        } else {


            $(commonPopupObj).find('#messagetitle').html('Alert message');

            $(commonPopupObj).find('#messageshow').html('Invalid Data type');

            $(commonPopupObj).css('display', 'block');

            $(this).val(focusEndOdometerValue);


        }


    });
	/******Same Function For(total calculation) the 2nd row*******/
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

                $(currentTrObj).find("input[name*='nu_km_traveled1']").val(totalTraveled).trigger('blur');

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

                        $(this).parent().parent().find('[name*="nu_km_traveled1"]').val('');

                        $(this).parent().parent().find('[name*="nu_other_road_km_traveled"]').val('');

                        i++;


                    }

                });
				
				$(currentTrObj).find("select[name*='vc_orign']").val('');

				$(currentTrObj).find("select[name*='vc_destination']").val('');
				
				$(currentTrObj).find("select[name*='vc_other_road_orign']").val('');
				
				$(currentTrObj).find("select[name*='vc_other_road_destination']").val('');
				
				$(currentTrObj).find("input[name*='nu_other_road_km_traveled']").val('');

            }

        } else {


            $(commonPopupObj).find('#messagetitle').html('Alert message');

            $(commonPopupObj).find('#messageshow').html('Invalid Data type');

            $(commonPopupObj).css('display', 'block');

            $(this).val(focusEndOdometerValue);


        }


    });
		
	
	/***************End****************/
	$(obj).find('.innerbody').delegate('select[name*="[vc_orign]"]',"change",function(){
			
			parentObj = $(this);
			
			$(backproceesingPopupObj).css('display','block'); 
			
			$.ajax({				
				url: GLOBLA_PATH+"inspectors/getdistanceselectedlocationto",
				type: "post",
				data: {
					data	: $.trim($(this).val())
				}
			}).done(function( responseString ) {
				$(backproceesingPopupObj).css('display','none');
				if( responseString ) {							
					$(parentObj).parent().parent().find("select[name *=vc_destination]").html(responseString);
				}
			});	
	});
	
	 $(obj).find('.innerbody').delegate('select[name*="[vc_destination]"]',"change",function(){
			parentObj = $(this);
			$(backproceesingPopupObj).css('display','block'); 
			$.ajax({				
				url: GLOBLA_PATH+"inspectors/calculatedistancelocation",
				type: "post",
				data: {					
					vc_orign 	: $.trim($(parentObj).parent().parent().find("select[name *='[vc_orign]']").val()),
					data		: $.trim($(this).val()),
					k			: $(obj).find('select[name*="[vc_destination]"]').index(this)
				}
			}).done(function( responseString ) {
				
				$(backproceesingPopupObj).css('display','none');
				
				if( $.trim(responseString) ) {							

					if( $(parentObj).parent().parent().find('input[name *="[eprkmtrl]"]').length > 0 ) {
						
						$(parentObj).parent().parent().find('input[name *="[eprkmtrl]"]').remove();
						
					} 
					
					$(parentObj).parent().parent().append(responseString);
					
					$(parentObj).parent().parent().find('input[name*="[nu_km_traveled]"]').trigger('blur');
					
				}
			});	
			
	});

	 $(obj).find('.innerbody').delegate('select[name*="[vc_other_road_orign]"]',"change",function(){
			parentObj = $(this);			
			$(backproceesingPopupObj).css('display','block'); 
			$.ajax({				
				url: GLOBLA_PATH+"inspectors/getdistanceselectedlocationto",
				type: "post",
				data: {
					data	: $.trim($(this).val())
				}
			}).done(function( responseString ) {
				$(backproceesingPopupObj).css('display','none');
				if( responseString ) {							
					$(parentObj).parent().parent().find("select[name *=vc_other_road_destination]").html(responseString);
				}
			});	
	});
	
	 $(obj).find('.innerbody').delegate('select[name*="[vc_other_road_destination]"]',"change",function(){
			parentObj = $(this);
			$(backproceesingPopupObj).css('display','block'); 
			$.ajax({				
				url: GLOBLA_PATH+"inspectors/calculatedistancelocationother",
				type: "post",
				data: {					
					vc_orign 	: $.trim($(parentObj).parent().parent().find("select[name *='[vc_other_road_orign]']").val()),
					data		: $.trim($(this).val()),
					k			: $(obj).find('select[name*="[vc_other_road_destination]"]').index(this)
				}
			}).done(function( responseString ) {
				
				$(backproceesingPopupObj).css('display','none');
				
				if( $.trim(responseString) ) {							

					if( $(parentObj).parent().parent().find('input[name *=oteprkmtrl]').length > 0 ) {
						
						$(parentObj).parent().parent().find('input[name *=oteprkmtrl]').remove();
						
					} 

					$(parentObj).parent().parent().append(responseString);

					$(parentObj).parent().parent().find("input[name *='[nu_other_road_km_traveled]']").val();
					
				}
			});	
			
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
            dateFormat: 'd M yy',
			onClose: function() {
				$(this).trigger('blur');
			}	



        });
    }
	
	$(popObj).delegate("input[name *='search']", 'keyup', function() {
		
		selectVal = $(this).val();

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
	
	
    $(obj).find(".listsr1 input[name *=dt_log_date]").each(function(){
						
        $(this).rules("add",{

            required 	: true,
            maxlength	: 12,
            date		: true,
            messages : {

                required	: 	'Required',
                date		:	'Should be format',
                maxlength	: 	'Maximum accept 12 character'
									
            }
        });
						
						
						
    });
						
    /***Validation For vc_driver_name******/
						
    $(obj).find(".listsr1 input[name *=vc_driver_name]").each(function(){
						
        $(this).rules("add",{

            required 	: true,
            alphabetic	: true,
            maxlength	: 50,
            messages : {

                required	: 	'Required',
                alphabetic	:	'only character',
                maxlength	: 	'Maximum accept 50 character'
										

            }
			
        });
						
						
						
    });
						
						
    /***Validation For nu_start_ometer ******/
	$.validator.addMethod( "onlyNumberWithoutFloat",function(value, element) {
						
			return this.optional(element) || Number(value) >= 0 && /^\+?(0|[1-9]\d*)$/.test(value);
			
		}, "Decimal not accepted");	
		
						
    $(obj).find(".listsr1 input[name *=nu_start_ometer]").each(function(){
						
        $(this).rules("add",{

            required 	: true,
            positiveNumber	: true,
            maxlength	: 15,
			messages : {

                required	: 	'Required',
                positiveNumber		:	'only number',
                maxlength	: 	'Maximum accept 15 character'
										

            }
        });
						
							
						
    });
						
						
    /***Validation For nu_end_ometer******/
	
	$.validator.addMethod( "greaterThan",function(value, element) {
						
			if( parseInt(value) >  parseInt($(element).parent().parent().find("input[name *=nu_start_ometer]").val()) ) {
				
				$(element).parent().parent().find("input[name *=nu_km_traveled]").val(parseInt(value) - parseInt($(element).parent().parent().find("input[name *=nu_start_ometer]").val()));
						
				return true;
			
			} 
				
			return false;
			
		}, "Should be greater then start");	
						
    $(obj).find(".listsr1 input[name *=nu_end_ometer]").each(function(){	
	
					//	alert('hua');
		parentObj = $(this);
		
        $(this).rules("add",{
			
			required 	: true,
			
            positiveNumber : true,
			
			//greaterThan	:  true,
			         
			maxlength	: 15,
			
			onlyNumberWithoutFloat : true,
            
			messages : {

                required	: 	'Required',
				
                positiveNumber		:	'only number',
				
                maxlength	: 	'Maximum accept 15 character'
										

            }
        });
		
		//////
		 $(obj).find(".listsr1 input[name *=nu_km_traveled]").each(function(){	
	
					//	alert('hua');
			$(this).rules("add",{
		
            required 	: true,
            positiveNumber	: true,
			rightExist	: true,
            maxlength	: 15,
            messages : {
                required	: 	'Required',
                positiveNumber		:	'only number',
                maxlength	: 	'Maximum accept 15 character'										
            }
        });
        
		});
		
		////////
						
						
    });
						
						
    /***Validation For vc_orign******/
		
    $(obj).find(".listsr1 select[name *=vc_orign]").each(function(){
					
		parentObj = $(this);
		
        $(this).rules("add",{

            required 	:  true,
            alphanumericSpace	: true,
            maxlength	: 50,
			messages : {
				required	: 	'Required',
                alphanumericSpace	:	'Accept only<br/>alphanumeric',
                maxlength	: 	'Maximum accept 50 character'
			}
        });
						
						
						
    });
						
	
	/***Validation For vc_destination******/				
						
    $(obj).find(".listsr1 select[name *=vc_destination]").each(function(k,v){
						
		parentObj = $(this);
		
        $(this).rules("add",{
			required 	: true,
            alphanumericSpace	: true,
            maxlength	: 50,
			messages : {

                required	: 	'Required',
                alphanumericSpace	:	'Accept only<br/>alphanumeric',
                maxlength	: 	'Maximum accept 50 character'
										

            }
        });
						
						
    });
	
	
	/*************************/


    /***Validation For nu_other_road_km_traveled******/
	
	
	$.validator.addMethod( "onlyNumberWithoutFloatOther",function(value, element) {
			
			return this.optional(element) || Number(value) >= 0 && /^\+?(0|[1-9]\d*)$/.test(value);						
							
			
		}, "Decimal not accepted");	

    $(obj).find(".listsr1 input[name *=nu_other_road_km_traveled]").each(function(){
		
		parentObj = $(this);
		
        $(this).rules("add",{
			
			required 	: true,
			
			positiveNumber    	: true,
			
			//lessThanEqualTo 	: true,
            
			maxlength    		: 15,
			
			checkValueRight 	: true,
            
			onlyNumberWithoutFloatOther : true,
			
			messages 			: {

					positiveNumber     		: 'only number',
					
					maxlength    			: 'Maximum accept 15 characters',
					
					//lessThanEqualTo			: 'Should be <br/>less than <br/> km travled on namibian <br/>road'


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

    /********Main Validations For the 2nd Row*********/
	    function applylogdetailValidation1() {
	
		/***Validation For Date******/
	
	
    $(obj).find(".listsr1 input[name *=dt_log_date]").each(function(){
						
        $(this).rules("add",{

            required 	: true,
            maxlength	: 12,
            date		: true,
            messages : {

                required	: 	'Required',
                date		:	'Should be format',
                maxlength	: 	'Maximum accept 12 character'
									
            }
        });
						
						
						
    });
						
    /***Validation For vc_driver_name1******/
						
    $(obj).find(".listsr1 input[name *=vc_driver_name1]").each(function(){
						
        $(this).rules("add",{

            required 	: true,
            alphabetic	: true,
            maxlength	: 50,
            messages : {

                required	: 	'Required',
                alphabetic	:	'only character',
                maxlength	: 	'Maximum accept 50 character'
										

            }
			
        });
						
						
						
    });
						
						
    /***Validation For nu_start_ometer1 ******/
	$.validator.addMethod( "onlyNumberWithoutFloat",function(value, element) {
						
			return this.optional(element) || Number(value) >= 0 && /^\+?(0|[1-9]\d*)$/.test(value);
			
		}, "Decimal not accepted");	
		
						
    $(obj).find(".listsr1 input[name *=nu_start_ometer1]").each(function(){
						
        $(this).rules("add",{

            required 	: true,
            positiveNumber	: true,
            maxlength	: 15,
			messages : {

                required	: 	'Required',
                positiveNumber		:	'only number',
                maxlength	: 	'Maximum accept 15 character'
										

            }
        });
						
							
						
    });
						
						
    /***Validation For nu_end_ometer1******/
	
	$.validator.addMethod( "greaterThan",function(value, element) {
						
			if( parseInt(value) >  parseInt($(element).parent().parent().find("input[name *=nu_start_ometer1]").val()) ) {
				
				$(element).parent().parent().find("input[name *=nu_other_road_km_traveled1]").val(  parseInt(value) - parseInt($(element).parent().parent().find("input[name *=nu_start_ometer1]").val()) );
						
				return true;
			
			} 
				
			return false;
			
		}, "Should be greater then start");	
						
    $(obj).find(".listsr1 input[name *=nu_end_ometer1]").each(function(){
	
	
						
		parentObj = $(this);
		
        $(this).rules("add",{
			
			required 	: true,
			
            positiveNumber	: true,
			
			greaterThan	:  true,
			         
			maxlength	: 15,
			
			onlyNumberWithoutFloat : true,
            
			messages : {

                required	: 	'Required',
				
                positiveNumber		:	'only number',
				
                maxlength	: 	'Maximum accept 15 character'
										

            }
        });
						
						
    });
						
						
    /***Validation For vc_orign1******/
		
    $(obj).find(".listsr1 select[name *=vc_other_road_orign]").each(function(){
					
		parentObj = $(this);
		
        $(this).rules("add",{

            required 	: true,
			alphanumericSpace	: true,
            maxlength	: 50,
			messages : {
				required	: 	'Required',
                alphanumericSpace	:	'Accept only<br/>alphanumeric',
                maxlength	: 	'Maximum accept 50 character'
			}
        });
						
						
						
    });
						
	
	/***Validation For vc_other_road_destination******/				
						
    $(obj).find(".listsr1 select[name *=vc_other_road_destination]").each(function(k,v){
						
		parentObj = $(this);
		
        $(this).rules("add",{
			required 	: true,
            alphanumericSpace	: true,
            maxlength	: 50,
			messages : {

                required	: 	'Required',
                alphanumericSpace	:	'Accept only<br/>alphanumeric',
                maxlength	: 	'Maximum accept 50 character'
										

            }
        });
						
						
    });
	
	/*************************/
	
    $(obj).find(".listsr1 select[name *=vc_other_road_orign]").each(function(k, v){
		    
			$(this).rules("add",{
			 
				required 	: true,
				alphanumericSpace	: true,
				maxlength	: 50,
				messages : {

						alphanumericSpace	:	'Accept only<br/>alphanumeric',
						maxlength	: 	'Maximum accept 50 character'
												

					}
			});
						
						
						
    });  	
	
	/*************************/

    $(obj).find(".listsr1 select[name *=vc_other_road_destination]").each(function(k,v){
						
        $(this).rules("add",{
			
			required 	: { 

					depends: function(element) {
						
							if( 
								$.trim($(element).parent().parent().find("select[name *=vc_other_road_orign]").val()) != '' 
							
									|| ( 

										$.trim($(element).parent().parent().find("input[name *=nu_other_road_km_traveled]").val()) != ''
										
										&&
										
										$.trim($(element).parent().parent().find("input[name *=nu_other_road_km_traveled]").val()) != 0
										

									)

							) {
								
								return true;
							
							
							} 
								
							return false;
							
							
						
					}
			},
			alphanumericSpace	: true,
			
            maxlength			: 50,
			
			messages : {

                alphanumericSpace	:	'Accept only<br/>alphanumeric',
                maxlength	: 	'Maximum accept 50 character'
										

            }
        });
						
						
						
    });  	
						
    					
    /***Validation For nu_other_road_km_traveled1******/
	
	
	$.validator.addMethod( "rightExist",function(value, element) {
			
			var Rowid = parseInt($(element).attr('id').split("VehicleLogDetail")[1], 16);
			var nambianroaddrpdownvalue = $('#VehicleLogDetail'+Rowid+'Selectedroad').val();
			
			if(nambianroaddrpdownvalue==0){
		
			if(  $(element).parent().parent().find("select[name *='[vc_orign]']").val() != '' 
					&&  $(element).parent().parent().find("select[name *='[vc_destination]']").val() != '' ) { 
			
				if( parseInt(value) >=  parseInt($(element).parent().parent().find("input[name *=eprkmtrl]").val()) ) {
																				
					return  true;
					
					}
												
				  return false;
				}
				
			}else{
			
			
			
			if( $(element).parent().parent().find("select[name *='[vc_orign]']").val() != '' 
					&&  $(element).parent().parent().find("select[name *='[vc_destination]']").val() != '') { 
			
				if( parseInt(value) <  parseInt($(element).parent().parent().find("input[name *=eprkmtrl]").val()) ) {
																				
					return  true;
					
					}
												
				  return false;
				}
			
			}

			return true;	
				
				
		
		}, function (value, element) {
			var Rowid = parseInt($(element).attr('id').split("VehicleLogDetail")[1], 16);
			var nambianroaddrpdownvalue = $('#VehicleLogDetail'+Rowid+'Selectedroad').val();
		//	alert(nambianroaddrpdownvalue+'--lkuo');
		if(nambianroaddrpdownvalue==0){
		return "Should be greater or equal to "+$(element).parent().parent().find("input[name *='[eprkmtrl]']").val()+""
		
		}else{
		return "Should be less than  "+$(element).parent().parent().find("input[name *='[eprkmtrl]']").val()+""
		
		}
		
		});	
		
		
	$.validator.addMethod( "checkValueRight",function(value, element) {		
		
		if( $.trim($(element).parent().parent().find("select[name *='[vc_other_road_orign]']").val()) != '' && $.trim($(element).parent().parent().find("select[name *='[vc_other_road_destination]']").val()) != '' ) {
				
				otherValue = parseInt($.trim($(element).parent().parent().find('input[name *=oteprkmtrl]').val()));
									
				if( parseInt(otherValue) >= parseInt($(element).val()) ) {
						
					return  true;

				} else {

					return  false;

				}


		} else {
			
			return true;

		}
		
		
	
	}, function (value, element) { return "Should be less or equal to "+$(element).parent().parent().find("input[name *='[oteprkmtrl]']").val()+""});

			
    $(obj).find(".listsr1 input[name *=nu_other_road_km_traveled1]").each(function(){


        $(this).rules("add",{

            required 	: true,
            positiveNumber	: true,
			rightExist	: true,
            maxlength	: 15,
            messages : {

                required	: 	'Required',
                positiveNumber		:	'only number',
                maxlength	: 	'Maximum accept 15 character'
											

            }
        });


    });
    /***Validation For nu_other_road_km_traveled******/
	
	
	$.validator.addMethod( "onlyNumberWithoutFloatOther",function(value, element) {
			
			return this.optional(element) || Number(value) >= 0 && /^\+?(0|[1-9]\d*)$/.test(value);						
							
			
		}, "Decimal not accepted");	

    $(obj).find(".listsr1 input[name *=nu_other_road_km_traveled]").each(function(){
		
		parentObj = $(this);
		
        $(this).rules("add",{
			
			required 	: { 

					depends: function(element) {
						
							if( $.trim($(element).parent().parent().find("select[name *=vc_other_road_destination]").val()) != '' || $.trim($(element).parent().parent().find("select[name *=vc_other_road_orign]").val()) != '' ) {
								
								return true;
							
							
							} 
								
							return false;
							
							
						
					}
			},
			
			positiveNumber    	: true,
			
			//lessThanEqualTo 	: true,
            
			maxlength    		: 15,
			
			checkValueRight 	: true,
            
			onlyNumberWithoutFloatOther : true,
			
			messages 			: {

					positiveNumber     		: 'only number',
					
					maxlength    			: 'Maximum accept 15 characters',
					
					//lessThanEqualTo			: 'Should be <br/>less than <br/> km travled on namibian <br/>road'


								}
        });


    });
		
		
        /***Validation For vc_remark******/

        $(obj).find(".listsr1 textarea[name *=vc_remark1]").each(function() {


            $(this).rules("add", {
                maxlength: 500,
                alphanumericSpace: true,
                messages: {
                    maxlength: 'Maximum accept 500 character',
                    alphanumericSpace: 'Accept only<br/>alphanumeric'
                }
            });


        });
		
		
		 $(obj).find(".listsr1 input[name *=uploaddocs1]").each(function() {


            $(this).rules( 
				  "add",	{
					accept:true,
					filesize:true
				});	


        });
		
	}
	
	/*******************End*******************/
	
	
    $(popObj).delegate(".close", 'click', function() {

        $(popObj).find("input[name *='search']").val('');

        $(popObj).find("input[type *='button']").trigger('click');

        $(popObj).css('display', 'none');

    });

    $(obj).find('.innerbody').delegate('[name*="nu_end_ometer1"]', "focus", function() {

        focusEndOdometerValue = $.trim($(this).val());

    });
	
	$("form").submit(function(event) {
		
		if(obj.valid()==true){
			//alert('hua');
			$('#submitbuttonid').attr('disabled', 'disabled');   
					
		
		}
	});
});



function change_value(){

 var end = $('#VehicleLogDetail0NuEndOmeter').val();
 var start= $('#VehicleLogDetail1NuStartOmeter').val();

 if(end !=''){
 $('#VehicleLogDetail1NuStartOmeter').val(end);
 
 }
}

/*****Show/Hide Row *******/
function road_select(){
// 0 means namibian road 1 means other road
//alert($('#idofcheckboxchecked').is(':checked'));
if($('#checked').is(':checked')){
	
	$('#SecondRow').css('display','');
	
				if($('#VehicleLogDetail0Selectedroad').val()=='0'){
						
						  // $("select#VehicleLogDetail1Selectedroad").append($("<option>").val("1"));
						  $("option[value='1']").remove();
						  $('#td_otherdestination_id1').show();
						  $('#td_otherorigin_id1').show();
						  $('#td_destination_id1').hide();
						  $('#td_origin_id1').hide();
						
					
				} else {		
						  $("option[value='0']").remove();
						  // $("option[value='0']").remove();
						  $('#td_otherdestination_id1').hide();
						  $('#td_otherorigin_id1').hide();
						  $('#td_destination_id1').show();
						  $('#td_origin_id1').show();
				 }
	   
	}else{
	    
		/*
		$("option[value='1']").remove();
		$("option[value='0']").remove();
		$('#VehicleLogDetail0Selectedroad').append($('<option>', {value:0,text: 'Namibian Road'},{value:1,text: 'Other Road'}));	
		//
		*/
		if($('#VehicleLogDetail0Selectedroad').val()==0 ){
		
			$('#VehicleLogDetail0Selectedroad').append($('<option>', {value:1,text: 'Other Road'}));
		
		} else {
		
			$('#VehicleLogDetail0Selectedroad').append($('<option>', {value:0,text: 'Namibian Road'}));
		
		}
		
		
		
		$('#SecondRow').css('display','none');
		
		$('#VehicleLogDetail1VcOrign').val('');
		//alert($('#VehicleLogDetail1VcOrign').val());
		$('#VehicleLogDetail1VcDestination').val('');
		$('#VehicleLogDetail1NuEndOmeter').val('');
		$('#VehicleLogDetail1VcDriverName').val('');
		$('#VehicleLogDetail1VcOtherRoadOrign').val('');
		$('#VehicleLogDetail1VcOtherRoadDestination').val('');
		$('#VehicleLogDetail1NuKmTraveled').val('');
		//$('#VehicleLogDetail1VcDriverName').val('');

	}
}
/********End********/
/*******Display options******/

function show_option(){
	
	// 0 means namibian road 1 means other road
	
	if($('#VehicleLogDetail0Selectedroad').val()=='0'){
		$('#VehicleLogDetail0VcOtherRoadOrign').val('');
	    $('#VehicleLogDetail0VcOtherRoadDestination').val('');
			//alert('0');
			// if($('#checked').is(':checked')==false){	
			//	$('#VehicleLogDetail0VcOrign').val('');
			//  $('#VehicleLogDetail0VcDestination').val('');
			// }
			
			$("select#VehicleLogDetail1Selectedroad").empty();
			$("select#VehicleLogDetail1Selectedroad").append($("<option>").val("1").html("Other road"));					
			$('#td_otherdestination_id').hide();
			$('#td_otherorigin_id').hide();
			$('#td_destination_id').show();
			$('#td_origin_id').show();
			
			

	}else{
	$('#VehicleLogDetail0VcOrign').val('');
	$('#VehicleLogDetail0VcDestination').val('');
			//if($('#checked').is(':checked')==false){	
			//	$('#VehicleLogDetail0VcOtherRoadOrign').val('');
				//$('#VehicleLogDetail0VcOtherRoadDestination').val('');
			// }
			// $('#VehicleLogDetail0VcOtherRoadOrign').val('');
			// $('#VehicleLogDetail0VcOtherRoadDestination').val('');
			
			$("select#VehicleLogDetail1Selectedroad").empty();
			$("select#VehicleLogDetail1Selectedroad").append( $("<option>").val("0").html("Namibian Road"));			
			$('#td_otherdestination_id').show();
			$('#td_otherorigin_id').show();
			$('#td_destination_id').hide();
			$('#td_origin_id').hide();
				
	}
}