var obj = $('#VehicleRegistrationChangedetailForm');

var backproceesingPopupObj = $('#backproceesing');

var commonPopupObj = $('#commonmessage');
   
$(function() {
   
	
    $(obj).validate();
	
	
	/**
	 *
	 * Complete Validation  For Vehicle Add 
	 *
	 */

	function VehiclCompleteValidation () {
		
			$.validator.addMethod( "notEqual",function(value, element, param) {
	
				return this.optional(element) || value.toLowerCase() != $(param).val().toLowerCase();
			
			}, "Already used");
		
			$(obj).find(".list input[name *=vc_vehicle_lic_no]").each(function(){
				
				parentObj = $(this);
				
				$(this).rules("add",{

					required 	: true,
					maxlength	: 15,					
					alphanumeric:true,
					remote: {						
						url: GLOBLA_PATH+"vehicles/getVehicleMainCheck",
						type: "post",
						data : {					
							id : function(){
								return $(obj).find("input[id *=id]").val()
							}
						},
						beforeSend: function (response) {
							$(backproceesingPopupObj).css('display','block'); 
						},
						complete: function () {
							$(backproceesingPopupObj).css('display','none');						
						}
					},
					messages : {

						required		: 	'Required',
						alphanumeric	:	'Alpha-<br>numeric<br> only',
						maxlength		: 	'Maximum accept 15 character',
						remote			: 	'Already used'	
					
					}});



			});


			$(obj).find(".list input[name *=vc_vehicle_reg_no]").each(function(){
				
				parentObj = $(this);
				
				$(this).rules("add",{

						required 	: true,
						maxlength	: 15,
						notEqual		: $(parentObj).parent().parent().find("input[name *=vc_vehicle_lic_no]"),
						alphanumeric:true,
						remote: {						
							url: GLOBLA_PATH+"vehicles/getVehicleMainCheck",
							type: "post",
							data : {					
								id : function(){
									return $(obj).find("input[id *=id]").val()
								}
							},
							beforeSend: function (response) {
								$(backproceesingPopupObj).css('display','block'); 
							},
							complete: function () {
								$(backproceesingPopupObj).css('display','none');						
							}
						},
						messages : {

							required		: 	'Required',
							alphanumeric	: 	'Alpha-<br>numeric<br> only',
							maxlength		: 	'Maximum accept 15 character',
							remote			: 	'Already used'	
						
						}});
			});
			
			
			/* $(obj).find(".list input[name *=vc_pay_frequency]").each(function(){

				$(this).rules("add",{

						required 	: true,
						
						messages 	: {

							required	: 'Required'
							
						
						}});
			}); */
			
			
			$(obj).find(".list input[name *=vc_vehicle_type]").each(function(){

				$(this).rules("add",{

						required 	: true,
						
						messages : {

							required	: 	'Required'
							
						
						}});
			});
					
			$(obj).find(".list input[name *=vc_start_ometer]").each(function(){

				$(this).rules("add",{

						required 	: true,
						positiveNumber		: true,
						maxlength	: 15,
						messages : {

							required	: 	'Required',
							positiveNumber		:'Accept only  <br/>number',
							maxlength	: 	'Maximum accept 15 character'
							
						
						}});
			});
			
			$(obj).find(".list input[name *=vc_oper_est_km]").each(function(){

				$(this).rules("add",{

						required 	: true,
						positiveNumber		: true,
						maxlength	: 15,
						messages : {

							required	: 	'Required',
							positiveNumber		:'Accept only <br/> number',
							maxlength	: 	'Maximum accept 15 character'
							
						
						}});
			});
			
			$(obj).find(".list input[name *=vc_v_rating]").each(function(){

				$(this).rules("add",{
						
						positiveNumber		: true,
						maxlength	: 15,
						messages : {

							positiveNumber		:'Accept only <br/> number',
							maxlength	: 	'Maximum accept 15 character'
							
						
						}});
			});
			
			$(obj).find(".list input[name *=vc_dt_rating]").each(function(){

				$(this).rules("add",{

						positiveNumber		: true,
						maxlength	: 15,
						messages : {

							
							positiveNumber		:'Accept only <br/>number',
							maxlength	        : 'Maximum accept  15 character'
							
						
						}});
			});
			
			$(obj).find(".list input[name *=vc_predefine_route]").each(function(){

				$(this).rules("add",{
						
						maxlength	: 50,
						alphanumericSpace	: true,
						messages : {

							alphanumericSpace   :	'Accept only <br/>alphanumeric',
							maxlength	    : 	'Maximum accept 50 characters'
							
						
						}});
			});
					
		}		
	
	
	VehiclCompleteValidation(); 
		
    /*********************End**********************************/
	 /*
    $(obj).submit(function(){
		
        var trObject =  $(obj).find('.list table:first tr:not(tr tr)');
		
		var rowCount = $(trObject).length;
		
        var errroMessage = false;
		
					
        $(this).find('.list table:first tbody tr:not(tr tr)').each(function(){
				
							
            if( $(this).find('button').attr('rel') == 'done'  ) {
				 
                $(this).find('button').removeClass('form-error');
				
                $(this).find('button').next('.add-error').remove();
				 
            
			} else {
								
                if( ! $(this).find('button').hasClass('form-error') ) {
						
                    $(this).find('button').addClass('form-error');
					
                    $(this).find('button').after('<div class="add-error">Required</div>');
							
                }
				
                errroMessage = true;
					
					
				 
            }
				
        });
				
      
	   if( !errroMessage ) {
			
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
			
        }
				
        return false;
		
    });	
	*/	
});
/*
$("#submitvehiclechangedetailid").click(function () {

if($('div').hasClass('qq-upload-fail')==true){
			//errroMessage = true;
			alert('Please remove the invalid file from upload');
			return false;
			
			
		}
	if($(obj).valid()==true){
			$('#submitvehiclechangedetailid').attr('disabled', 'disabled'); 
			
			$('#VehicleRegistrationChangedetailForm').submit();
			return true;


	}

});*/
	/**
	* 
	* Remove Last Image Uploader File
	*
	*/

	/*function remove_fields() {

		removeObj = $('#slctrow').val();
		
		count = $(obj).find("input[name *='data[DocumentUploadVehicle]["+removeObj+"]']").length;
				
		if(  count > 1 ) {
		
			$(obj).find("input[name *='data[DocumentUploadVehicle]["+removeObj+"]']:last").remove();
		
		}
		
	}*/

	
/*** Multiple File Upload Main Code **********/
		  
	function createUploader(parentObj,  row , countRow ){
       
		$('#'+parentObj).each(function(k,v){   
			id = $.trim($(this).attr('id'));
            var uploader = new qq.FileUploader({
                element: document.getElementById($.trim($(this).attr('id'))),
                action: GLOBLA_PATH+'getuploads/index',
                params: {
                    param1: id,
                    param2: 'vehicleadd',/*serverside folder name  /app/tmp/vehicleadd */
					param3: 'DocumentUploadVehicle', /*** Model Name **/
					param4: row, /**Row Number**/
					param5: countRow /**Element No**/
				},
                allowedExtensions: ["jpeg", "bmp", "png", "jpg", "gif", 'pdf'],
                debug: true
            });
        });
    }
	
	 $(obj).find('a[id*=deletefileID]').click(function() {
	 		   
	 var docid = $(this).attr('rel');
	 var rowid= 'removerowid'+docid;
	// var updocrowid = 'updoc'+$(this).attr('name');
	 $("<p> Are you sure want to delete this file </p>" ).dialog({					
					resizable: false,
					height:160,
					width:400,
					modal: true,
					buttons: {
						"ok": function() {

	 $.ajax({
				type: "POST",
			    url: GLOBLA_PATH + "vehicles/deleteajaxfile/",
				data: {
				VehicleDocId : docid,			
				},
				success : function (data) {
				
				if(data==false){
				
				$('#'+rowid).remove();
				
				$(commonPopupObj).find('#messageshow').html('File deleted successfully!!.');
				$(commonPopupObj).css('display', 'block');	
				//$('#'+alert($(this).attr('id'));).css('display', '');	
				
				}			
				}
				});
					$( this ).dialog( "close" );
				},
						Cancel: function() {
							$( this ).dialog( "close" );
						}
					}
				
			});
		});

	$(obj).delegate(".qq-upload-remove",'click',function(){
			
			callObj = $(this);
			
			$(function() {
				$("<p> Are you sure want delete this file </p>" ).dialog({					
					resizable: false,
					height:140,
					modal: true,
					buttons: {
						"ok": function() {
							
							var lenrows=$('.fileupload-block').length;
							
							$(callObj).parent().closest('.fileupload-block').remove();
							if(lenrows==1){
							add_fields('uploadDocsvehicle0', 0);
							}
							
							$( this ).dialog( "close" );
						},
						Cancel: function() {
							$( this ).dialog( "close" );
						}
					}
				});
			});
	
	});

	$(obj).delegate(".ontop .close",'click',function(){
		
		closeObj = $(this);
		
		var errorCheck = false;
		
		
		$(closeObj).parent().closest('td').find('.qq-upload-list').each(function(){
		
			if( $.trim($(this).html()) == '' ){
			
				$(this).parent().closest('.fileupload-block').remove();
			
			} else {
				
				errorCheck = true;
			
			}
			
						
		
		});
		
		var buttonObject = $(closeObj).parent().closest('td').find('button');
			
		if( errorCheck ) {
							
				$(buttonObject).attr('rel', 'done');
				
				$(buttonObject).removeClass('form-error');
				
                if( $(buttonObject).next('.add-error').length > 0 ) {
					
					$(buttonObject).next('.add-error').remove();
				
				}
				
		} else {
		
		
				if( ! $(buttonObject).hasClass('form-error') ) {
						//alert(buttonObject);
                    //$(buttonObject).addClass('form-error');
					
                   // $(buttonObject).after('<div class="add-error">Required</div>');
							
                }
		
		
		}
	
		
	});
	
	//$(obj).submit(function(){
	$("#submitvehiclechangedetailid").click(function () {
		
        var trObject =  $('#changedetailvehicleID').find('table:first tr');
		
		var rowCount = $(trObject).length;
		//alert(rowCount);
		var errroMessage = false;
			
         $('#changedetailvehicleID').find('tbody:first tr').each(function(){
				//alert($('#changedetailvehicleID').find('tbody:first tr').find('button'));
		    if($('#changedetailvehicleID').find('tbody:first tr').find('button').attr('rel') == 'done'  ) {
		
			$('#changedetailvehicleID').find('tbody:first tr').find('button').removeClass('form-error');
				
                $('#changedetailvehicleID').find('tbody:first tr').find('button').next('.add-error').remove();
				 
            
			} else {
				//	alert('kkk');
                if( ! $('#changedetailvehicleID').find('tbody:first tr').find('button').hasClass('form-error') ) {
						
                // $('#changedetailvehicleID').find('tbody:first tr').find('button').addClass('form-error');
					
                  // $('#changedetailvehicleID').find('tbody:first tr').find('button').after('<div class="add-error">Required</div>');
							
                }
				
                //errroMessage = true;
					
					
				 
            }
				
        });
		if($('div').hasClass('qq-upload-fail')==true){
			errroMessage = true;
			alert('Please remove the invalid file from upload');
			return false;
			
			
		}
			//alert(errroMessage+'--errroMessage');
        if( !errroMessage ) {
		
		//alert(obj.valid());
			if(obj.valid()) {
				
				if( obj.find('input[type ="submit"]').length > 0 ) {
				 
					obj.find('input[type ="submit"]').attr('disabled', 'disabled');   
				    obj.submit();	
					
					
				} 
				
				if( obj.find('button[type ="submit"]').length > 0 ) {
				 
					obj.find('button[type ="submit"]').attr('disabled', 'disabled');    
				obj.submit();
				}
				
						
				obj.find('button[type ="button"]').attr('disabled', 'disabled');   
				
				return true;
		   }
			
            
			
        } 
				
        return false;
		
    });
	
	