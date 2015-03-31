var obj = $('#CustomerInactiveVehicleLogInactivevehiclesForm');
var commonPopupObj = $('#commonmessage');
var backproceesingPopupObj = $('#backproceesing');
$(obj).validate();
$(function(){	
	
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
	
	
	$(obj).find("input[name *=vc_driver_name]").each(function(){
				
			$(this).rules("add",{

				required 	: true,
				alphabetic	: true,
				maxlength	: 100,
				messages : {

					required	: 	'Required',
					alphabetic	:	'only character',
					maxlength	: 	'Maximum accept 100 character'


				}
			});
    });
		
	$.validator.addMethod( "notEqual",function(value, element, param) {
	
			return this.optional(element) || value.toLowerCase() != $(param).val().toLowerCase();
		}, "Already used");
		
	$(obj).find("input[name *=vc_vehicle_lic_no]").each(function(){
				
		$(this).rules("add",{

			required 		: true,
			maxlength		: 15,
			alphanumeric	:true,
			notEqual		: $(obj).find("input[name *=vc_vehicle_reg_no]"),
			remote: {
				url: GLOBLA_PATH+"inspectors/checkvehicleresgistered",
				type: "post"
			},

			messages : {

				required		: 	'Required',
				maxlength		: 	'Maximum accept 15 character',
				alphanumeric	: 	'Alpha-numeric<br> only',
				remote			:	'Already used'
			}
		});
    });
	
	$(obj).find("input[name *=vc_vehicle_reg_no]").each(function(){
				
		$(this).rules("add",{

			required 		: true,
			maxlength		: 15,
			alphanumeric	:true,
			notEqual		: $(obj).find("input[name *=vc_vehicle_lic_no]"),
			remote: {
				url: GLOBLA_PATH+"inspectors/checkvehicleresgistered",
				type: "post"
			},

			messages : {

				required		: 	'Required',
				maxlength		: 	'Maximum accept 15 character',
				alphanumeric	: 	'Alpha-numeric<br> only',
				remote			:	'Already used'
			}
		});
    });
		
	/***Validation For nu_start_ometer ******/
	
	$.validator.addMethod( "onlyNumberWithoutFloat",function(value, element) {
						
			return this.optional(element) || Number(value) >= 0 && /^\+?(0|[1-9]\d*)$/.test(value);
			
		}, "Decimal not accepted");	
						
    $(obj).find("input[name *=nu_start_ometer]").each(function(){
						
        $(this).rules("add",{

            required 	: true,
            positiveNumber	: true,
            maxlength	: 15,
			onlyNumberWithoutFloat : true,
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
			
			onlyNumberWithoutFloat : true,
            
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
	
    $(obj).find(".listsr1 select[name *=vc_other_road_orign]").each(function(k, v){
		    
			$(this).rules("add",{
			 
				required 	: { 

					depends: function(element) {
						
							if( $.trim($(element).parent().parent().find("select[name *=vc_other_road_destination]").val()) != '' 
							
									|| ( 
								
										$.trim($(element).parent().parent().find("input[name *=nu_other_road_km_traveled]").val()) != ''
										
										&&
										
										$.trim($(element).parent().parent().find("input[name *=nu_other_road_km_traveled]").val()) != 0
										
								
									) ) {
								return true;
							
							
							} 
								
							
						return false;
							
							
						
					}
				},
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
						
    					
    /***Validation For nu_km_traveled******/
	
	
	$.validator.addMethod( "rightExist",function(value, element) {
					
			if(  $(element).parent().parent().find("select[name *='[vc_orign]']").val() != '' 
					&&  $(element).parent().parent().find("select[name *='[vc_destination]']").val() != '' ) { 
			
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

					return  false;

				}


		} else {
			
			return true;

		}
		
		
	
	}, function (value, element) { return "Should be less or equal to "+$(element).parent().parent().find("input[name *='[oteprkmtrl]']").val()+""});

			
    $(obj).find(".listsr1 input[name *=nu_km_traveled]").each(function(){


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
			
			lessThanEqualTo 	: true,
            
			maxlength    		: 15,
			
			checkValueRight 	: true,
            
			onlyNumberWithoutFloatOther : true,
			
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
		
	
	
});