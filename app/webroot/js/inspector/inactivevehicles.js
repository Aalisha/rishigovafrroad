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
	
	/**/
	
		$.validator.addMethod( "notEqual",function(value, element, param) {
	
			return this.optional(element) || (value.toLowerCase() != $(param).val().toLowerCase());
		}, "Already used");


		
	$.validator.addMethod( "onlyNumberWithoutFloat",function(value, element) {
					
		return this.optional(element) || Number(value) >= 0 && /^\+?(0|[1-9]\d*)$/.test(value);
		
	}, "Decimal not accepted");	
	

	
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
	
	
	/*
		
	$.validator.addMethod( "rightExist",function(value, element) {
					
			
			if($(element).parent().parent().find("select[name *='[vc_orign]']").val() != '' &&  $(element).parent().parent().find("select[name *='[vc_destination]']").val() != '') { 
				
				if( parseInt(value) >=  parseInt($(element).parent().parent().find("input[name *=eprkmtrl]").val()) ) {
																				
					return  true;
					
				}
												
				return false;
			}

			return true;	
				
		
		}, function (value, element) { return "Should be greater or equal to "+$(element).parent().parent().find("input[name *='[eprkmtrl]']").val()+""});	
		
	
	*/
	
	$.validator.addMethod("rightExist",function(value, element) {
				//				alert(value);
				//			alert($(element).parent().parent().find("input[name *=eprkmtrl]").val());
			var Rowid = parseInt($(element).attr('id').split("VehicleLogDetail")[1], 16);
			var nambianroaddrpdownvalue = $('#VehicleLogDetail'+Rowid+'Selectedroad').val();
			//alert(nambianroaddrpdownvalue+'--ii');//VehicleLogDetail0NuKmTraveled--ii
			if(nambianroaddrpdownvalue==0){
			
			if($(element).parent().parent().find("select[name *='[vc_orign]']").val() != '' && 
			$(element).parent().parent().find("select[name *='[vc_destination]']").val() != '') { 
			
				if(  parseInt(value) >=  parseInt($(element).parent().parent().find("input[name *=eprkmtrl]").val()) ) {
																				
					return  true;
					
				}
												
				return false;
			}
			}else{
			if($(element).parent().parent().find("select[name *='[vc_orign]']").val() != '' && 
			$(element).parent().parent().find("select[name *='[vc_destination]']").val() != '') { 
			
				if(  parseInt(value) <=  parseInt($(element).parent().parent().find("input[name *=eprkmtrl]").val()) ) {
																				
					return  true;
					
				}
												
				return false;
			}
			
			}
			return true;	
		
		}, function (value, element) {
		var Rowid = parseInt($(element).attr('id').split("VehicleLogDetail")[1], 16);
			var nambianroaddrpdownvalue = $('#VehicleLogDetail'+Rowid+'Selectedroad').val();
			//alert(nambianroaddrpdownvalue+'--ii');//VehicleLogDetail0NuKmTraveled--ii
			if(nambianroaddrpdownvalue==0){
		return "Should be greater or equal to "+$(element).parent().parent().find("input[name *='[eprkmtrl]']").val()+"";
		}
		else{
		
		return "Should be less than or equal to "+$(element).parent().parent().find("input[name *='[eprkmtrl]']").val()+"";
		}
		}
		);

		
		
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
	  var focusEndOdometerValue = 0;
				
		$(obj).find('.innerbody').delegate("select[name*='selectedroad']", 'change', function() {
			var Rowid = parseInt($(this).attr('id').split("VehicleLogDetail")[1], 16);
			//alert(Rowid);
			$('#VehicleLogDetail'+Rowid+'VcOrign').val('');
			$('#VehicleLogDetail'+Rowid+'VcDestination').val('');
		
		});
		
    $(obj).find('.innerbody').delegate("input[name*='nu_end_ometer']", 'change', function() {

		 currentTrObj = $(this).parent().parent();
		 //alert(currentTrObj);
		 //alert($(this).attr('id'));
		//$(this).attr('id').split()
		var Rowid = parseInt($(this).attr('id').split("VehicleLogDetail")[1], 16);
		//alert(Rowid);

		
		//VehicleLogDetail0NuEndOmeter
	   if (/^\+?(0|[1-9]\d*)$/.test($(this).val())) {           

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

                     
                        i++;


                    }

                });
				
				$(currentTrObj).find("select[name*='vc_orign']").val('');

				$(currentTrObj).find("select[name*='vc_destination']").val('');
				

            }

        } else {


            $(commonPopupObj).find('#messagetitle').html('Alert message');

            $(commonPopupObj).find('#messageshow').html('Invalid Data type');

            $(commonPopupObj).css('display', 'block');

            $(this).val(focusEndOdometerValue);


        }
		


    });					
				
		
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
	
	$.validator.addMethod( "greaterThan",function(value, element) {
						
			if( parseInt(value) >  parseInt($(element).parent().parent().find("input[name *=nu_start_ometer]").val()) ) {
				
				$(element).parent().parent().find("input[name *=nu_km_traveled]").val(  parseInt(value) - parseInt($(element).parent().parent().find("input[name *=nu_start_ometer]").val()) );
						
				return true;
			
			} 
				
			return false;
			
		}, "Should be greater then start");	
		
		
/*

	$.validator.addMethod("onlyNumberWithoutFloatOther",function(value, element) {
			
			return this.optional(element) || Number(value) >= 0 && /^\+?(0|[1-9]\d*)$/.test(value);
			
		}, "Decimal not accepted");	
		


    
	$(obj).find(".listsr1 textarea[name *=vc_remark]").each(function() {


            $(this).rules("add", {
                maxlength: 500,
                alphanumericSpace: true,
                messages: {
                    maxlength: 'Maximum accept 500 character',
                    alphanumericSpace: 'Accept only<br/>alphanumeric'
                }
            });


        });*/
		
		$("form").submit(function(event) {
		
		if(obj.valid()==true){
			//alert('hua');
			$('#submit').attr('disabled', 'disabled');   
					
		
		}
	});
	
});

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
	//alert('0');
	if($('#VehicleLogDetail0Selectedroad').val()=='0'){
		$('#VehicleLogDetail0VcOtherRoadOrign').val('');
	    $('#VehicleLogDetail0VcOtherRoadDestination').val('');
			
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
/*

function road_select(){
if($('#checked').is(':checked')){

	$('#SecondRow').css('display','');
	if($('#VehicleLogDetail0Selectedroad').val()=='0'){
			
//			$("select#VehicleLogDetail1Selectedroad").append($("<option>").val("1"));
		   $("option[value='1']").remove();
		
		}else{
		 $("option[value='0']").remove();
		//$("option[value='0']").remove();
	}
}else{
if($('#VehicleLogDetail0Selectedroad').val()=='0'){
$("select#VehicleLogDetail0Selectedroad").append($("<option>Other Road</option>").val("1"));

}else{
$("select#VehicleLogDetail0Selectedroad").append($("<option>Namibian </option>").val("0"));


}
$('#SecondRow').css('display','none');
$('#VehicleLogDetail1NuEndOmeter').val('');
$('#VehicleLogDetail1VcOrign').val('');
$('#VehicleLogDetail1VcDestination').val('');

}
}

function show_option(){
if($('#VehicleLogDetail0Selectedroad').val()=='0'){
$("select#VehicleLogDetail1Selectedroad").empty();
$("select#VehicleLogDetail1Selectedroad").append( $("<option>")
    .val("1")
    .html("Other road"));

}else{
$("select#VehicleLogDetail1Selectedroad").empty();
$("select#VehicleLogDetail1Selectedroad").append( $("<option>")
    .val("0")
    .html("Namibian Road"));
}
}
*/
