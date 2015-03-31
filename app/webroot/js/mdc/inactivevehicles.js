var obj = $('#CustomerInactiveVehicleLogInactivevehiclesForm');

var commonPopupObj = $('#commonmessage');

var backproceesingPopupObj = $('#backproceesing');

$(obj).validate();

$(function(){

	
	$(obj).find("input[name *=dt_log_date]").datepicker({
			
			minDate: "0 D",
			
			maxDate: "0 D",
			
			defaultDate: "+1w",
			
			changeMonth: true,
			
			changeYear: true,
			
			dateFormat: 'd M yy'


		});
		
		$(obj).find("input[name *=dt_log_date]").each(function(){
				
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
		
		$(obj).find("input[name *=vc_driver_name]").each(function(){
				
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
		
		$.validator.addMethod( "notEqual",function(value, element, param) {
	
			return this.optional(element) || value !== $(param).val();
		},

			"Already used vehicle number");
		
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
					alphanumeric	: 	'Alpha-<br>numeric<br> only',
					remote			:	'Already used Vehicle Lic. No.'
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
					alphanumeric	: 	'Alpha-<br>numeric<br> only',
					remote			:	'Already used Vehicle Reg. No.'
				}
			});
        });
		
		$(obj).find("input[name *=nu_start_ometer]").each(function(){
						
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
						
	$.validator.addMethod( "greaterThan",function(value, element, param) {
	
			if( value > $(param).val() ) {
				
				$(obj).find("input[name *=nu_km_traveled]").val(  value - $(param).val() );
				
				return true;	
				
			}else {
				
				$(obj).find("input[name *=nu_km_traveled]").val('');
				
				return false;
			}			
		},

			"Should be greater then start");					
						
    $(obj).find("input[name *=nu_end_ometer]").each(function(){
						
						
        $(this).rules("add",{

            positiveNumber 	: true,
            maxlength	: 15,
			greaterThan	: $(obj).find("input[name *=nu_start_ometer]"),
            messages : {

                required	: 	'Required',
                positiveNumber	:       'only number',
                maxlength	: 	'Maximum accept 15 character'
										

            }
        });
						
						
    });
		
    
			
						
    /***Validation For vc_orign******/
		
    $(obj).find("select[name *=vc_orign]").each(function(){
						
        $(this).rules("add",{

            required 			: true,
            alphanumericSpace	: true,
            maxlength			: 50,
			remote: {
					url: GLOBLA_PATH+"inspectors/getdistanceselectedlocation",
					type: "post",
					cache: false
				},
				
            messages : {

                required	: 	'Required',
                alphanumericSpace	:	'Accept only<br/>alphanumeric',
                maxlength	: 	'Maximum accept 50 character'
										

            }
        });
						
						
						
    });
						
	/*************************/
	
    $(obj).find("select[name *=vc_destination]").each(function(k, v){
		    
			 $(this).rules("add",{
			 
					alphanumericSpace	: true,
					maxlength	: 50,
					messages : {

						alphanumericSpace	:	'Accept only<br/>alphanumeric',
						maxlength	: 	'Maximum accept 50 character'
												

					}
			});
						
						
						
    });  
	
	
	$(obj).find("input[name *=nu_km_traveled]").each(function(){


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
	
	
	 $(obj).find("input[name *=vc_other_road_orign]").each(function(k, v){
		    
			 $(this).rules("add",{
			 
					alphanumericSpace	: true,
					maxlength	: 50,
					messages : {

						alphanumericSpace	:	'Accept only<br/>alphanumeric',
						maxlength	: 	'Maximum accept 50 character'
												

					}
			});
						
						
						
    }); 
	
	$(obj).find("input[name *=vc_other_road_destination]").each(function(k, v){
		    
			 $(this).rules("add",{
			 
					alphanumericSpace	: true,
					maxlength	: 50,
					messages : {

						alphanumericSpace	:	'Accept only<br/>alphanumeric',
						maxlength	: 	'Maximum accept 50 character'
												

					}
			});
						
						
						
    }); 
	

	
	
	$(obj).find("input[name *=nu_other_road_km_traveled]").each(function(){
		
		
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
       
		
	/*$(backproceesingPopupObj).css('display','none');

	$(commonPopupObj).find('#messagetitle').html('Alert Message .');

	$(commonPopupObj).find('#messageshow').html('Sorry some error has been occured. Please refresh page then try again.!!');

	$(commonPopupObj).css('display','block');
	
	*/
});