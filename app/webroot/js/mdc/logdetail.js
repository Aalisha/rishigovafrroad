var objDate = new Date();

var commonPopupObj = $('#commonmessage');

var obj = $('#ProfileAddlogdetailForm');

var backproceesingPopupObj = $('#backproceesing');

var validator = $(obj).validate();

var focusEndOdometerValue = 0; 

/************ Reset Value Of Drop Origin and destination ****************/
    
$(function() {
    
    $(obj).find("select[name*='vc_vehicle_']").on('change',function(){
	
        parentObj = $(this);
		
		$(backproceesingPopupObj).css('display','block');
	            
        $.ajax({

            type: "POST",

            url: GLOBLA_PATH+'vehicles/getVehicleDetail',

            data: {

                data : $(this).val()
					
            }
        }).done(function( data ) {

            objJson = jQuery.parseJSON(data);
			
			$(backproceesingPopupObj).css('display','none');
						
            if( objJson.vc_pay_frequency ) {
				
                $('#vc_pay_frequency').val( objJson.vc_pay_frequency).trigger('blur');
							
                $('#vc_vehicle_lic_no').val(objJson.vc_vehicle_lic_no).trigger('blur');
							
                $('#vc_vehicle_reg_no').val(objJson.vc_vehicle_reg_no).trigger('blur');
														
                if( $('#vc_vehicle_reg_no').val() != '' ){
								
                    $('#vc_vehicle_reg_no').removeClass('jserror');
                } 
                if($('#vc_vehicle_lic_no').val()!= '') {
							
                    $('#vc_vehicle_lic_no').removeClass('jserror');
							
                }
						
                /****************Refresh Below Data ******************/
                $(obj).find('.listsr1 table tr').remove();
								
                var rowCount = 0;
								
                addobject = $('.innerbody .listsr1 table');
								
                if( $(addobject).find('#loading').length > 0 ) {



                } else {

                    $(addobject).find('tbody').html("<tr> <td colspan='10'> <div id='loading' style='text-align:center;' ><img width='30px' src='"+GLOBLA_PATH+"img/loading.gif' > </img> </div></td> </tr>");

                }

                $.ajax({

                    type: "POST",

                    url: GLOBLA_PATH+'vehicles/gettabledata',

                    data: {
                        rowCount: rowCount
                    }

                }).done(function( data ) {
								
                    $(addobject).find('tr:last').remove();
									
                    $(addobject).find('tbody').html(data);
									
                    if( ! $(addobject).find('tr:last').find(".addlog").hasClass("hasDatepicker") ) {
										
					if( objJson.dt_created_date != '') {
						date = objJson.dt_created_date;
					}else {
						date='';
					}		
					$(addobject).find('tr:last').find(".addlog").datepicker({
						dateFormat: 'd M yy',
						defaultDate: "+1w",
						minDate:date,
						maxDate: "0 D",
						changeMonth: true,
						changeYear: true,
						numberOfMonths: 1,
						onSelect: function(x,y){
							$(this).trigger('blur');
							$(addobject).find('tr:last').find("input[name *='vc_driver_name']").focus();
						
						}		
					});
  
                     $(addobject).find('tr:last').find('[name*="nu_start_ometer"]').val(objJson.vc_start_ometer);
													
						applylogdetailValidation();					
									
                    }
									
									
                });
						
						
            }else {
			
				$('#vc_vehicle_lic_no').val(objJson.vc_vehicle_lic_no).trigger('blur');
							
                $('#vc_vehicle_reg_no').val(objJson.vc_vehicle_reg_no).trigger('blur');
														
                if( $('#vc_vehicle_reg_no').val() != '' ){
								
                    $('#vc_vehicle_reg_no').removeClass('jserror');
                }
                if( $('#vc_vehicle_lic_no').val() != '' ) {
							
                    $('#vc_vehicle_lic_no').removeClass('jserror');
							
                }
				
				
				/****************Refresh Below Data ******************/
				
                $(obj).find('.listsr1 table tr').remove();
								
                var rowCount = 0;
								
                addobject = $('.innerbody .listsr1 table');
								
                if( $(addobject).find('#loading').length > 0 ) {

                } else {

                    $(addobject).find('tbody').html("<tr> <td colspan='10'> <div id='loading' style='text-align:center;' ><img width='30px' src='"+GLOBLA_PATH+"img/loading.gif' > </img> </div></td> </tr>");

                }

                $.ajax({

                    type: "POST",

                    url: GLOBLA_PATH+'vehicles/gettabledata',

                    data: {
                        rowCount: rowCount
                    }

                }).done(function( data ) {
								
                    $(addobject).find('tr:last').remove();
									
                    $(addobject).find('tbody').html(data);
									
                    if( ! $(addobject).find('tr:last').find(".addlog").hasClass("hasDatepicker") ) {
										
					if( objJson.dt_created_date != '') {
						date = objJson.dt_created_date;
					}else {
						date='';
					}		
					$(addobject).find('tr:last').find(".addlog").datepicker({
						dateFormat: 'd M yy',
						defaultDate: "+1w",
						minDate:date,
						maxDate: "0 D",
						changeMonth: true,
						changeYear: true,
						numberOfMonths: 1,
						onSelect: function(x,y){
							$(this).trigger('blur');
							$(addobject).find('tr:last').find("input[name *='vc_driver_name']").focus();
						
						}		
					});
  
                     $(addobject).find('tr:last').find('[name*="nu_start_ometer"]').val(objJson.vc_start_ometer);
													
						applylogdetailValidation();					
									
                    }
									
                });

                $('#vc_pay_frequency').val('');
						
            }						

        });				

    });
	
    /********* Delete Row *****************/
	
    $(obj).find('.innerbody #rmrow').click(function(){
				
        var setDefautShow = 1;
				
        var rowCount = $('.innerbody .listsr1 table tr').length;
				
        var addobject = $('.innerbody .listsr1 table');
				
        if( setDefautShow !=  rowCount ) { 
				
            $(addobject).find('tr:last').remove();	
				
        }	
					
    });
		
		
    /*************** Add Row***********************/
	
    $(obj).find('.innerbody #addrow ').click(function(){
      
        var setMinNo = 1;
				
        var rowCount = $('.innerbody .listsr1 table tr').length;
				
        if( rowCount >= setMinNo  ) { 
				
            addobject = $('.innerbody .listsr1 table');
			
			if(  $.trim($(addobject).find('tr:last').find('input[name*="nu_start_ometer"]').val()) != ''  
						&& $.trim($(addobject).find('tr:last').find('input[name*="nu_end_ometer"]').val()) != ''
						//&& $.trim($(addobject).find('tr:last').find('select[name*="[vc_orign]"]').val()) != ''
						//&& $.trim($(addobject).find('tr:last').find('select[name*="[vc_destination]"]').val()) != ''
						) {
				
				if( $(addobject).find('#loading').length > 0 ) {
								
								
								
				} else {
						
					$(addobject).find('tr:last').after("<tr> <td colspan='10'> <div id='loading' style='text-align:center;' ><img width='30px' src='"+GLOBLA_PATH+"img/loading.gif' > </img> </div></td> </tr>");
						
				}
				
				$.ajax({

					type: "POST",

					url: GLOBLA_PATH+'vehicles/gettabledata',

					data: {
						rowCount: rowCount
					}

				}).done(function( data ) {

					if( data != '' ){

						$(addobject).find('tr:last').remove();

						previousObj =  $(addobject).find('tr:last');

						if( $(addobject).find('tr:last').find('[name*="nu_start_ometer"]').val() != ''  && $(addobject).find('tr:last').find('[name*="nu_end_ometer"]').val() != ''  ) {

						$(addobject).find('tr:last').after(data);


						if( ! $(addobject).find('tr:last').find(".addlog").hasClass("hasDatepicker") ) {

						$(addobject).find('tr:last').find(".addlog").datepicker({
						maxDate: "0 D",
						minDate : $(previousObj).find('[name*="dt_log_date"]').val() ,
						defaultDate: "+1w",
						changeMonth: true,
						changeYear: true,
						dateFormat: 'd M yy',
						numberOfMonths: 1,
						onSelect: function(x,y){

							$(addobject).find('tr:last').find("input[name *='vc_driver_name']").focus();

						},
						onClose: function() {
							$(this).trigger('blur');
						}	
						});

						}	

						$(addobject).find('tr:last').find(".addlog").focus();

						$(addobject).find('tr:last').find('[name*="nu_start_ometer"]').val( parseInt( $(previousObj).find('[name*="nu_end_ometer"]').val()) );

						applylogdetailValidation();



						} else {
							$(commonPopupObj).find('#messageshow').html('Please fill above fields first');

							$(commonPopupObj).css('display','block');

						}

					} 
				});			
					
			} else {
				
				$(commonPopupObj).find('#messageshow').html('Please fill above fields first');

				$(commonPopupObj).css('display','block');
				
				return false;


			}
			
			
        }	
		
    });
	

	$(obj).find('.listsr1').delegate("tbody tr","click",function(){
	
		licno    = $('#vc_vehicle_lic_no').val();
			
        regno    = $('#vc_vehicle_reg_no').val();
			
        if( licno =='' || regno =='' ) {
			
			$('#vc_vehicle_lic_no').focus();
			
			$(obj)[0].reset();
				
            $(commonPopupObj).find('#messageshow').html('Please select License No. / Registration No.');
				
            $(commonPopupObj).css('display','block');
			
        }
	
	
	});	
    /****************End*****************************/	

    $(obj).find('.listsr1').delegate(".addlog","focus",function(){
	  
        parentObj = $(this);
			
        Value    = $(parentObj).val();
			
        licno    = $('#vc_vehicle_lic_no').val();
			
        regno    = $('#vc_vehicle_reg_no').val();
			
        if( licno =='' || regno =='' ) {
				
            $(parentObj).val('');
				
            $(this).datepicker("destroy");
				
            $(commonPopupObj).find('#messageshow').html('Please select License No. / Registration No.');
				
            $(commonPopupObj).css('display','block');
			
        }else {
			
            getDate();
			
			
        }
		
	
    }); 
	
    $(obj).find('.listsr1').delegate(".addlog:first","mouseover",function(){
				
        licno    = $('#vc_vehicle_lic_no').val();
			
        regno    = $('#vc_vehicle_reg_no').val();
			
        if( licno =='' || regno =='' ) {
			   
            $('#vc_vehicle_lic_no').addClass('jserror');
            $('#vc_vehicle_reg_no').addClass('jserror');
			
        }else{
			
            $('#vc_vehicle_lic_no').removeClass('jserror');
            $('#vc_vehicle_reg_no').removeClass('jserror');
			
			
        }
	
    });
	
    $(obj).find('.listsr1').delegate(".addlog:first","change",function(){
	  
        parentObj = $(this);
			
        licno    = $('#vc_vehicle_lic_no').val();
			
        regno    = $('#vc_vehicle_reg_no').val();
			
        if( licno !='' && regno !='' ) {
				
            $.ajax({

                type: "POST",

                url: GLOBLA_PATH+'vehicles/getVehicleStartOM',

                data: {

                    licno		: licno,
						
                    regno		: regno
						
					
                }
            }).done(function( data ) {

                objJson = jQuery.parseJSON(data);
							
                if( $.trim(objJson.vc_start_ometer) != '' ) {
							
                    $(parentObj).parent().parent().find('[name*="nu_start_ometer"]').val(objJson.vc_start_ometer);
							
                }else {
						
            }
            });	
			
        }else {
			  
            $(commonPopupObj).find('#messageshow').html('Please select License No. / Registration No.');
				
            $(commonPopupObj).css('display','block');
			
        }
		
    });
		
	
    $(obj).find('.listsr1').delegate('[name*="nu_end_ometer"]',"change",function(){

            parentObj 	= $(this);

            endvalue		= /^\+?(0|[1-9]\d*)$/.test($(this).val()) ? parseInt($(parentObj).val()) : 0;

            startValue		=  parseInt($(parentObj).parent().parent().find('[name*="nu_start_ometer"]').val());

            var trObj 		=  $(obj).find('.listsr1').find('[name*="nu_end_ometer"]');

            var total 		=  $(trObj).length;

            var index 		= $(obj).find('.listsr1').find('[name*="nu_end_ometer"]').index(this);
					
			/*------start of select box of RoadID---*/
			var currentID= $(this).attr('id');
			//alert(currentID);
			var Rowid = parseInt($(this).attr('id').split("VehicleLogDetail")[1], 16);
			var chkRoadIDValue = $('#RoadID'+Rowid).val();
			//alert(chkRoadIDValue+'--chkRoadIDValue');
			if(chkRoadIDValue==0){
			
			$(parentObj).parent().parent().find('[name*="nu_km_traveled"]').val(parseInt(endvalue - startValue)).trigger('blur');
			
			}else{
			$(parentObj).parent().parent().find('[name*="nu_other_road_km_traveled"]').val(parseInt(endvalue - startValue)).trigger('blur');
			}
						
			/*------end of select box of RoadID---*/
						
			
			  
			i = 0;
			
			$(trObj).each(function(k,v){
					
					curIndex = $(obj).find('.listsr1').find('input[name*="nu_end_ometer"]').index(this);
					
					if( curIndex ==  index  ) {
					
						if(chkRoadIDValue==1){
			
						$(this).parent().parent().find('input[name*="[nu_other_road_km_traveled]"]').val(parseInt(endvalue - startValue)).trigger('blur');
						}
						
						
					}
					else if( curIndex > index ) {
						
						if( i == 0) {
							
							newenddometer = $(this).parent().parent().prev().find('[name*="nu_end_ometer"]').val();
							
							$(this).parent().parent().find('input[name*="[nu_start_ometer]"]').val(parseInt(newenddometer));
							
							i++;
							
						}else {
						
						
							$(this).parent().parent().find('input[name*="[nu_start_ometer]"]').val('');
						
						
						}
						
						$(this).parent().parent().find('input[name*="[nu_end_ometer]"]').val('');
						
						$(this).parent().parent().find('input[name*="[nu_km_traveled]"]').val('');
						
					$(this).parent().parent().find('input[name*="[nu_other_road_km_traveled]"]').val('');
                    }
            });				   
    });
	
	
	/////////// To Delete LogDetails which are not bind to assessment ///
	
	$(obj).delegate(".qq-upload-remove_log",'click',function(){
			
			callObj = $(this);
			var substrvalue= callObj.attr('id').substring(25, 27);
			 
			var len= callObj.attr('id').length;
		
			var popupidid = parseInt(substrvalue[0]);
			var popupUploadid = parseInt(substrvalue[1]);
			
			$(function() {
				$("<p> Are you sure want delete this file </p>" ).dialog({					
					resizable: false,
					height:140,
					modal: true,
					buttons: {
						"ok": function() {
							alert('hua');
				
							
							
							$( this ).dialog( "close" );
						},
						Cancel: function() {
							$( this ).dialog( "close" );
						}
					}
				});
			});
	
	});
	
	///////////////
   
    $(obj).find('.listsr1').delegate('[name*="nu_end_ometer"]',"focus",function(){
	
        focusEndOdometerValue  = $.trim($(this).val());
	
    });	
	
    
    $(obj).find('.listsr1').delegate('select[name*="[vc_orign]"]',"change",function(){
			
			parentObj = $(this);
			
			$(backproceesingPopupObj).css('display','block'); 
			
			$.ajax({				
				url: GLOBLA_PATH+"vehicles/getdistanceselectedlocationto",
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
	
	$(obj).find('.listsr1').delegate('select[name*="[vc_destination]"]',"change",function(){
			parentObj = $(this);
			$(backproceesingPopupObj).css('display','block'); 
			$.ajax({				
				url: GLOBLA_PATH+"vehicles/calculatedistancelocation",
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

	$(obj).find('.listsr1').delegate('select[name*="[vc_other_road_orign]"]',"change",function(){
			parentObj = $(this);			
			$(backproceesingPopupObj).css('display','block'); 
			$.ajax({				
				url: GLOBLA_PATH+"vehicles/getdistanceselectedlocationto",
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
	
	 $(obj).find('.listsr1').delegate('select[name*="[vc_other_road_destination]"]',"change",function(){
			parentObj = $(this);
			$(backproceesingPopupObj).css('display','block'); 
			$.ajax({				
				url: GLOBLA_PATH+"vehicles/calculatedistancelocationother",
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
					
					$(parentObj).parent().parent().find('input[name*="[nu_other_road_km_traveled]"]').trigger('blur');
				}
			});	
			
	}); /**/

	});

function getDate(){
   
    $(".addlog").datepicker({
        maxDate: " 0 D",
        defaultDate: "+1w",
        changeMonth: true,
        changeYear: true,
        dateFormat: 'd M yy',
		onClose: function() {
							$(this).trigger('blur');
						}	
			
	
    });
      
}

getDate();

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
						
		
	$.validator.addMethod( "floatOnly",function(value, element) {
						
			return this.optional(element) || Number(value) >= 0 && /^\+?(0|[1-9]\d*)$/.test(value);
			
		}, "Decimal not accepted");	
		
    /***Validation For nu_start_ometer ******/
						
    $(obj).find(".listsr1 input[name *=nu_start_ometer]").each(function(){
						
        $(this).rules("add",{
            required 			: true,
            positiveNumber		: true,
			maxlength			: 15,
			floatOnly			: true,
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
				
				$(element).parent().parent().find("input[name *=nu_km_traveled]").val(  parseInt(value) - parseInt($(element).parent().parent().find("input[name *=nu_start_ometer]").val()) );
						
				return true;
			
			} 
				
			return false;
			
		}, "Should be greater then start");	
						
    $(obj).find(".listsr1 input[name *=nu_end_ometer]").each(function(){
						
		parentObj = $(this);
		
        $(this).rules("add",{
			
			required 	: true,
			
            positiveNumber	: true,
			
			greaterThan	:  true,
			         
			maxlength	: 15,
            
			floatOnly	: true,
			
			messages : {

				required	: 	'Required',

				positiveNumber		:	'only number',

				maxlength	: 	'Maximum accept 15 character'
										

            }
        });
						
						
    });
						
					
    /***Validation For vc_orign******/
		
    $(obj).find(".listsr1 select[name *=vc_orign]").each(function(){
		parentObj = $(this);		
        $(this).rules("add",{
            required 	:  {
			depends: function(element) {
			
						var currentID= $(this).attr('id');
						var Rowid = parseInt($(this).attr('id').split("VehicleLogDetail")[1], 16);
						var chkRoadIDValue = $('#RoadID'+Rowid).val();
						if(chkRoadIDValue==0)
						return true;
						else
						return false;
						
			}},
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
			
			required 	:  {
			depends: function(element) {
			
						var currentID= $(this).attr('id');
						var Rowid = parseInt($(this).attr('id').split("VehicleLogDetail")[1], 16);
						var chkRoadIDValue = $('#RoadID'+Rowid).val();
						if(chkRoadIDValue==0)
						return true;
						else
						return false;
						
			}},
            
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
	
	
	/***Validation For vc_other_road_orign******/
		
    $(obj).find(".listsr1 select[name *=vc_other_road_orign]").each(function(){
		parentObj = $(this);		
        $(this).rules("add",{
            required 	:  {
			depends: function(element) {
			
						var currentID= $(this).attr('id');
						var Rowid = parseInt($(this).attr('id').split("VehicleLogDetail")[1], 16);
						var chkRoadIDValue = $('#RoadID'+Rowid).val();
						if(chkRoadIDValue==0)
						return false;
						else
						return true;
						
			}},
            alphanumericSpace	: true,
            maxlength	: 50,
			messages : {
                required	: 	'Required',
                alphanumericSpace	:	'Accept only<br/>alphanumeric',
                maxlength	: 	'Maximum accept 50 character'
			}
        });
	});
	/************************/
	
	
	/***Validation For vc_other_road_destination******/				
						
    $(obj).find(".listsr1 select[name *=vc_other_road_destination]").each(function(k,v){
						
		parentObj = $(this);
		
        $(this).rules("add",{
			
			required 	:  {
				depends: function(element) {
			
						var currentID= $(this).attr('id');
						var Rowid = parseInt($(this).attr('id').split("VehicleLogDetail")[1], 16);
						var chkRoadIDValue = $('#RoadID'+Rowid).val();
						if(chkRoadIDValue==0)
						return false;
						else
						return true;
						
			}},
            
			alphanumericSpace	: true,
            
			maxlength	: 50,
			
			messages : {
				required	: 	'Required',
                alphanumericSpace	:	'Accept only<br/>alphanumeric',
                maxlength	: 	'Maximum accept 50 character'
			}
        });
						
						
    });
	
	/******************************/
	
	/***Validation For ******/
	/*************************/
    					
    /***Validation For nu_km_traveled******/
	
	
	$.validator.addMethod( "rightExist",function(value, element) {
					
			
			if($(element).parent().parent().find("select[name *='[vc_orign]']").val() != '' &&  $(element).parent().parent().find("select[name *='[vc_destination]']").val() != '') { 
				
				if( parseInt(value) >=  parseInt($(element).parent().parent().find("input[name *=eprkmtrl]").val()) ) {
																				
					return  true;
					
				}
												
				return false;
			}

			return true;	
				
		
		}, function (value, element) { return "Should be greater or equal to "+$(element).parent().parent().find("input[name *='[eprkmtrl]']").val()+""});	
		
		
	$.validator.addMethod( "checkValueRight",function(value, element) {
		
		
		if( $.trim($(element).parent().parent().find("select[name *='[vc_other_road_orign]']").val()) != '' && $.trim($(element).parent().parent().find("select[name *='[vc_other_road_destination]']").val()) != '' ) {
				
				otherValue = parseInt($.trim($(element).parent().parent().find('input[name *=oteprkmtrl]').val()));
									
				if( parseInt(otherValue) >= parseInt($(element).val()) ) {
						
						return  true;

				} else {
								//	alert(otherValue);
								//	alert($(element).val());
				
					return  false;
				}


		} else {
			
			return true;

		}
		
	
	}, function (value, element) { return "Should be less or equal to "+$(element).parent().parent().find("input[name *='[oteprkmtrl]']").val()+""});

			
    $(obj).find(".listsr1 input[name *=nu_km_traveled]").each(function(){

		$(this).rules("add",{
            required : //true,
			{	
						depends: function(element) {
			
						var currentID= $(this).attr('id');
						var Rowid = parseInt($(this).attr('id').split("VehicleLogDetail")[1], 16);
						var chkRoadIDValue = $('#RoadID'+Rowid).val();
						//alert(chkRoadIDValue);
						/**/
						if(chkRoadIDValue==0)
						return true;
						else
						return false;
						return true;
			}},
            positiveNumber	: true,
			rightExist		: true,
            maxlength		: 15,
			floatOnly		: true,
            messages : {
				required			: 	'Required',
				positiveNumber		:	'only positive number',
				maxlength			: 	'Maximum accept 15 character'									

            }
        });


    });
    /***Validation For nu_other_road_km_traveled******/
		
    $(obj).find(".listsr1 input[name *=nu_other_road_km_traveled]").each(function(){
		
		$(this).rules("add",{
			
			 required 	: { 
			depends: function(element) {
			
						var currentID= $(this).attr('id');
						var Rowid = parseInt($(this).attr('id').split("VehicleLogDetail")[1], 16);
						var chkRoadIDValue = $('#RoadID'+Rowid).val();
						
						if(chkRoadIDValue==1)
						return true;
						else
						return false;
						return true;
			}
			}, 
			positiveNumber    	: true,
			maxlength    		: 15,
			checkValueRight 	: true,
			//lessThanEqualTo 	: true,
			floatOnly			: true,
			
			messages 			: {
					required			: 	'Required',
	

					positiveNumber     		: 'only positive number',
					
					maxlength    			: 'Maximum accept 15 characters'					
					//lessThanEqualTo			: ' Value should be less than KM Travel on Namibian Road'
				}
        });


    });
	
	
}

applylogdetailValidation();
	/******End*********************/

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

function other_hide(row){

		if($.trim($("#RoadID"+row).val())== '1'){
		
		$('#VehicleLogDetail'+row+'VcOtherRoadOrign').css('display','');
		$('#VehicleLogDetail'+row+'VcOtherRoadDestination').css('display','');
		$('#VehicleLogDetail'+row+'NuOtherRoadKmTraveled').css('display','');
		// $("#headeraddlogID").find('td:nth-child(6)').remove("td:nth-child(6)");
		$('#VehicleLogDetail'+row+'VcOrign').css('display','none');
		$('#VehicleLogDetail'+row+'VcDestination').css('display','none');		
		
		/*
		$("#RoadID"+row).closest('tr').find('td:nth-child(6)').find("div").remove(".error-message");
		$("#RoadID"+row).closest('tr').find('td:nth-child(7)').find("div").remove(".error-message");
		$("#RoadID"+row).closest('tr').find('td:nth-child(8)').find("div").remove(".error-message");	
		
		*/

		$('#VehicleLogDetail'+row+'NuKmTraveled').css('display','none');
		$('#VehicleLogDetail'+row+'VcOrign').prop('selectedIndex',0);
		$('#VehicleLogDetail'+row+'VcDestination').prop('selectedIndex',0);
		$('#VehicleLogDetail'+row+'NuKmTraveled').val('');
		$('#VehicleLogDetail'+row+'NuEndOmeter').val('');
		
	
		/*
		$('#headeraddlogID_6').css('display','none');
		$('#headeraddlogID_7').css('display','none');
		$('#headeraddlogID_8').css('display','none');
		$('#headeraddlogID_9').css('display','');
		$('#headeraddlogID_10').css('display','');
		$('#headeraddlogID_11').css('display','');
		*/
	
		
		$('#td_vc_orign_'+row+'id').css('display','none');
		$('#td_vc_destination_'+row+'id').css('display','none');
		$('#td_nu_km_traveled_'+row+'id').css('display','none');
		$('#td_vc_other_road_orign_'+row+'id').css('display','');
		$('#td_vc_other_road_destination_'+row+'id').css('display','');
		$('#td_nu_other_road_km_traveled_'+row+'id').css('display','');
		
		}else{
		
		/*
		$("#RoadID"+row).closest('tr').find('td:nth-child(9)').find("div").remove(".error-message");
		$("#RoadID"+row).closest('tr').find('td:nth-child(10)').find("div").remove(".error-message");
		$("#RoadID"+row).closest('tr').find('td:nth-child(11)').find("div").remove(".error-message");*/
		
		$('#VehicleLogDetail'+row+'VcOrign').css('display','');
		$('#VehicleLogDetail'+row+'VcDestination').css('display','');
		$('#VehicleLogDetail'+row+'NuKmTraveled').css('display','');
		$('#VehicleLogDetail'+row+'VcOtherRoadOrign').css('display','none');
		$('#VehicleLogDetail'+row+'VcOtherRoadDestination').css('display','none');
		$('#VehicleLogDetail'+row+'NuOtherRoadKmTraveled').css('display','none');
		
		$('#VehicleLogDetail'+row+'VcOtherRoadOrign').prop('selectedIndex',0);
		$('#VehicleLogDetail'+row+'VcOtherRoadDestination').prop('selectedIndex',0);
		$('#VehicleLogDetail'+row+'NuOtherRoadKmTraveled').val('');
		$('#VehicleLogDetail'+row+'NuEndOmeter').val('');
		
		
		
	/*	$('#headeraddlogID_6').css('display','');
		$('#headeraddlogID_7').css('display','');
		$('#headeraddlogID_8').css('display','');
		$('#headeraddlogID_9').css('display','none');
		$('#headeraddlogID_10').css('display','none');
		$('#headeraddlogID_11').css('display','none');*/
		
		
		$('#td_vc_orign_'+row+'id').css('display','');
		$('#td_vc_destination_'+row+'id').css('display','');
		$('#td_nu_km_traveled_'+row+'id').css('display','');
		$('#td_vc_other_road_orign_'+row+'id').css('display','none');
		$('#td_vc_other_road_destination_'+row+'id').css('display','none');
		$('#td_nu_other_road_km_traveled_'+row+'id').css('display','none');
		
		
		}

}	 