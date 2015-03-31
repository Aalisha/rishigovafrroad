var obj = $('#VehicleRegistrationIndexForm');

var  commonPopupObj = $('#commonmessage');
   
$(function() {
   
	
    $(obj).validate();
	
	
    /**
	 *
	 * Complete Validation  For Vehicle Add 
	 *
	 */

    function VehiclCompleteValidation ( ) {
	
	
		$(obj).find(".listsr input[name *=nu_company_id]").each(function(){
				
            $(this).rules("add",{

					required 	: true,
					messages : {

						required	: 	'Required'
                }
            });



        });
		
				
        $(obj).find(".listsr input[name *=vc_vehicle_lic_no]").each(function(){
				
            $(this).rules("add",{

					required 	: true,
					maxlength	: 15,
					alphanumeric:true,

					messages : {

						required	 : 	'Required',
						maxlength	 : 	'Maximum accept 15 character',
						alphanumeric : 'Alpha-<br>numeric<br> only'

					
                }
            });



        });


        $(obj).find(".listsr input[name *=vc_vehicle_reg_no]").each(function(){

            $(this).rules("add",{

						required 	: true,
						maxlength	: 15,
					alphanumeric:true,
						messages : {

							required	: 	'Required',
							maxlength	: 	'Maximum accept 15 character',
							alphanumeric:    'Alpha-<br>numeric<br> only'

						
                }
            });
        });
			
			
        /* $(obj).find(".listsr input[name *=vc_pay_frequency]").each(function(){

            $(this).rules("add",{

                required 	: true,
						
                messages 	: {

                    required	: 'Required'
							
						
                }
            });
        });
			 */
			
        $(obj).find(".listsr input[name *=vc_vehicle_type]").each(function(){

            $(this).rules("add",{

                required 	: true,
						
                messages : {

                    required	: 	'Required'
							
						
                }
            });
        });
					
        $(obj).find(".listsr input[name *=vc_start_ometer]").each(function(){

            $(this).rules("add",{

                required 	: true,
                positiveNumber		: true,
                maxlength	: 15,
                messages : {

                    required	: 	'Required',
                    positiveNumber		:'Accept only  <br/>number',
                    maxlength	: 	'Maximum accept 15 character'
							
						
                }
            });
        });
			
        $(obj).find(".listsr input[name *=vc_oper_est_km]").each(function(){

            $(this).rules("add",{

                required 	: true,
                positiveNumber		: true,
                maxlength	: 15,
                messages : {

                    required	: 	'Required',
                    positiveNumber		:'Accept only <br/> number',
                    maxlength	: 	'Maximum accept 15 character'
							
						
                }
            });
        });
			
        $(obj).find(".listsr input[name *=vc_v_rating]").each(function(){

            $(this).rules("add",{
						
                positiveNumber		: true,
                maxlength	: 15,
                messages : {

                    positiveNumber		:'Accept only <br/> number',
                    maxlength	: 	'Maximum accept 15 character'
							
						
                }
            });
        });
			
        $(obj).find(".listsr input[name *=vc_dt_rating]").each(function(){

            $(this).rules("add",{

                positiveNumber		: true,
                maxlength	: 15,
                messages : {

							
                    positiveNumber		:'Accept only <br/>number',
                    maxlength	        : 'Maximum accept  15 character'
							
						
                }
            });
        });
			
        $(obj).find(".listsr input[name *=vc_predefine_route]").each(function(){

            $(this).rules("add",{
						
                maxlength	: 50,
                alphanumericSpace	: true,
                messages : {

                    alphanumericSpace	:'Accept only <br/>alphanumeric',
                    maxlength		:'Maximum accept 50 characters'
							
						
                }
            });
        });
					
    }		
	
	
    VehiclCompleteValidation(); 
	
	
    $(obj).find('.listsr').delegate("input[name*='vc_vehicle_']",'change',function(){
		
        parentObj = $(this);
        listAll = $(obj).find(".listsr input[name*='vc_vehicle_']");
		
        error = false;
		
        $(listAll).each(function() {
			

            if ( $.trim($(this).val().toLowerCase()) == $.trim($(parentObj).val().toLowerCase()) && 
			$(this).attr('id') != $(parentObj).attr('id'))
            {		
				
                $(parentObj).val('');
				
                $(commonPopupObj).find('#messagetitle').html('Alert Message .');

                $(commonPopupObj).find('#messageshow').html('This License No or Registration No already exsist.Please try again.!!');

                $(commonPopupObj).css('display','block');
				
                error = true;
                return false;
				
				
            }

        });				
        if( !error ) {
		
		
            $.ajax({

                type: "POST",

                url: GLOBLA_PATH+'vehicles/getVehicleCheck',

                data: {

                    data	: $(this).val(),

                }

            }).done(function( data ) {
               
				if(data==false) {
					
                   $(parentObj).val(''); 
					
                    $(commonPopupObj).find('#messagetitle').html('Alert Message.');

                    $(commonPopupObj).find('#messageshow').html('This License No or Registration No already exist.Please try again.!!');

                    $(commonPopupObj).css('display','block');

                } 
					
            });		
		
        }
		
		
    });

    /********Add Row**************/
		
    $(obj).find('#addrow').click(function(){
		
        var setMinNo = 1;
				
        var rowCount = $(obj).find('.listsr table:first tr:not(tr tr)').length;
			
		var addobject = $(obj).find('.listsr table:first');
				
        if( rowCount >= setMinNo  ) { 
				
            if( $(addobject).find('#loading').length > 0 ) {
									
									
									
            } else {
							
                $(addobject).find('tr:not(tr tr):last').after("<tr> <td colspan='11'> <div id='loading' style='text-align:center;' ><img width='30px' src='"+GLOBLA_PATH+"img/loading.gif' > </img> </div></td> </tr>");
							
            }
			
			$.ajax({
				type: "POST",
				url: GLOBLA_PATH+'vehicles/addvehicle',								
				data: {
					rowCount: rowCount
				},			
				beforeSend : function (){
						$(obj).find('.innerbody:last table:last').hide();	
				},
				success : function (data) {					
					if( data != '' ){								
						$(addobject).find('tr:not(tr tr):last').remove();
						$(addobject).find('tr:not(tr tr):last').after(data);
						VehiclCompleteValidation();
						$(addobject).find('tr:not(tr tr):last').find('input[name *= "[vc_vehicle_lic_no]" ]').focus();
					}
				},
				error : function (xhr, textStatus, errorThrown) {
						$(obj).find('.innerbody:last table:last').show();	
				},
				complete : function (){
						$(obj).find('.innerbody:last table:last').show();	
				}
			});

			/*			
			$.ajax({
								
				type: "POST",
								
				url: GLOBLA_PATH+'vehicles/addvehicle',
								
				data: {
					rowCount: rowCount
				}
							
			}).done(function( data ) {
								
				if( data != '' ){
								
					$(addobject).find('tr:last').remove();
					$(addobject).find('tr:last').after(data);
					VehiclCompleteValidation();
					$(addobject).find('tr:last').find('input[name *= "[vc_vehicle_lic_no]" ]').focus();
				}
			});	*/	
				
        }	
		
		
    });
		
    /********Add Delete**************/
	
	$(obj).find('#rmrow').click(function(){
		
		var setDefautShow = 1;
		
		var addobject = $(obj).find('.innerbody:last .listsr table:first tbody');
		
		var rowCount = $(obj).find('.innerbody:last .listsr	table:first tbody tr:not(tr tr)').length;
		
				
		if( setDefautShow !=  rowCount ) { 				
		
			removeObj = rowCount-1;
							
			count = $(obj).find("input[name *='data[DocumentUploadVehicle]["+removeObj+"]']").length;
						
			if( count > 0 ) {
				
				$(obj).find("input[name *='data[DocumentUploadVehicle]["+removeObj+"]']").each(function(){
								
					$(this).remove();
				
				});
			}            
			
			$(addobject).find('tr:not(tr tr):last').remove();				
				
        }	
		  
		
		
    });
	
    /*********************End**********************************/
		
	
    $(obj).submit(function(){
		
        var trObject =  $(obj).find('.listsr table:first tr:not(tr tr)');
		
		var rowCount = $(trObject).length;
		
        var errroMessage = false;
			
        $(this).find('.listsr table:first tr:not(tr tr)').each(function(){
				
				//	alert($(this).find('button').attr('rel'));
			
            if( $(this).find('button').attr('rel') == 'done'  ) {
				 
                $(this).find('button').removeClass('form-error');
				
                $(this).find('button').next('.add-error').remove();
				 
            
			} else {
					
                if( ! $(this).find('button').hasClass('form-error') ) {
						
                   // $(this).find('button').addClass('form-error');
					
                    //$(this).find('button').after('<div class="add-error">Required</div>');
							
                }
				
                //errroMessage = true;
					
					
				 
            }
				
        });
		if($('div').hasClass('qq-upload-fail')==true){
			errroMessage = true;
			alert('Please remove the invalid file from upload');
			return false;
			
			
		}
			
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
		
});

 

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
                allowedExtensions: ["jpeg", "bmp", "png", "jpg", 'pdf'],
                debug: true
            });
        });
    }
	
	
	$(obj).delegate(".qq-upload-remove",'click',function(){
			
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
							
							$(callObj).parent().closest('.fileupload-block').remove();
							if(popupUploadid==0)
							{
							add_fields('uploadDocsvehicle'+popupidid, popupidid);
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
						
                   // $(buttonObject).addClass('form-error');
					
                    //$(buttonObject).after('<div class="add-error">Required</div>');
							
                }
		
		
		}
	
		
	});
	
	/****Call On CLose *********/
	
/************** End ****************************/