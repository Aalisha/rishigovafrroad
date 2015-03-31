var obj = $('#VehicleCbcEditvehicleForm');

var commonPopupObj = $('#commonmessage');

$(function() {

    $(obj).validate();
	
    /**
     *
     * Complete Validation  For Vehicle Add 
     *
     */

    function VehiclCompleteValidation( ) {


        $(obj).find("input[name *=vc_veh_type]").each(function() {

            $(this).rules("add", {
                required: true,
                messages: {
                    required: 'Required'



                }});

        });

   /*    */
   $(obj).find("input[name *=vc_reg_no]").each(function() {

            $(this).rules("add", {
                required: true,
                maxlength: 15,
                alphanumeric: true,
                messages: {
                    required: 'Required',
                    maxlength: 'Maximum accept 15 character',
                    alphanumeric: 'Alpha-<br>numeric<br> only'

                }});

        });

        $(obj).find("input[name *=vc_type_no]").each(function() {

            $(this).rules("add", {
                required: true,
                maxlength: 15,
                messages: {
                    required: 'Required',
                    maxlength: 'Maximum 15 characters accepted'

                }});



        });

        $(obj).find("input[name *=vc_make]").each(function() {

            $(this).rules("add", {
                required: true,
                maxlength: 15,
                messages: {
                    required: 'Required',
                    maxlength: 'Maximum 15 characters accepted'

                }});



        });


        $(obj).find("input[name *=vc_axle_type]").each(function() {

            $(this).rules("add", {
                required: true,
                maxlength: 15,
                messages: {
                    required: 'Required',
                    maxlength: 'Maximum 15 characters accepted'

                }});



        });


        $(obj).find(" input[name *=vc_series_name]").each(function() {

            $(this).rules("add", {
                required: true,
                alphanumeric: true,
                messages: {
                    required: 'Required',
                    alphanumeric: 'Alpha-<br>numeric<br> only'



                }});

        });


        $(obj).find("input[name *=vc_engine_no]").each(function() {

            $(this).rules("add", {
                required: true,
                alphanumeric: true,
                messages: {
                    required: 'Required',
                    alphanumeric: 'Alpha-<br>numeric<br> only'


                }});




        });

        $(obj).find("input[name *=vc_chasis_no]").each(function() {

            $(this).rules("add", {
                required: true,
                alphanumeric: true,
                messages: {
                    required: 'Required',
                    alphanumeric: 'Alpha-<br>numeric<br> only'



                }});

        });

        $(obj).find("input[name *=nu_v_rating]").each(function() {

            $(this).rules("add", {
                positiveNumber: true,
                messages: {
                    positiveNumber: 'Numbers<br> only'
                }});

        });

        $(obj).find("input[name *=nu_d_rating]").each(function() {

            $(this).rules("add", {
                positiveNumber: true,
                messages: {
                    positiveNumber: 'Numbers<br> only'
                }});

        });
		
    }

    VehiclCompleteValidation();

    $(obj).find('.innerbody:last table:first tbody').delegate("input[name*='vc_reg_no'] ", 'change', function() {

        parentObj = $(this);

        listAll = $(obj).find("input[name*='vc_reg_no']");

        error = false;

        $(listAll).each(function() {

            if ($.trim($(this).val()) === $.trim($(parentObj).val()) && ($(this).attr('id') !== $(parentObj).attr('id')))
            {

                $(parentObj).val('');

                $(commonPopupObj).find('#messageshow').html('This Registration No already exsists.Please try again !!');

                $(commonPopupObj).css('display', 'block');

                error = true;
                return false;

            }
        });

        if (!error) {

            $.ajax({
                type: "POST",
                url: GLOBLA_PATH + 'cbc/vehicles/getVehicleCheck',
                data: {
                    data: $(this).val(),
                    id: $('#id').val()
                }

            }).done(function(response) {


                if (!$.trim(response) || $.trim(response) === '') {

                    $(parentObj).val('');

                    $(commonPopupObj).find('#messageshow').html('This Registration No already exists.Please try again !!');

                    $(commonPopupObj).css('display', 'block');

                }

            });

        }

    });
    
	
	$('#submitcbceditID').click(function() {
	
		var errroMessage = false;
				
		var rowCount = $(obj).find('.innerbody:last table:first tbody tr:not(tr tr)').length;
        $(obj).find('.innerbody:last table:first tbody tr:not(tr tr)').each(function(){
            if( $(this).find('button').attr('rel') === 'done'  ) {
				 
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
		
		if($('div').hasClass('qq-upload-fail')==true){
			errroMessage = true;
			$(commonPopupObj).find('#messageshow').html('Please remove the invalid file from upload. !!');
            $(commonPopupObj).css('display', 'block');
			//alert('Please remove the invalid file from upload');
			return false;
		}
		
		if($('div.qq-upload-list span.qq-upload-success').length==0 ){
		     errroMessage = true;
			 $(commonPopupObj).find('#messageshow').html('Please upload atleast one file for vehicle.!!');
             $(commonPopupObj).css('display', 'block');
			 //alert('Please upload atleast one file for vehicle.');
			 return false;
		}
		
        if( !errroMessage && $('div').hasClass('qq-upload-fail')==false ) {
			if($(obj).valid()==true){
				$('#submitcbceditID').attr('disabled', 'disabled'); 
				$('#VehicleCbcEditvehicleForm').submit();			
				//return true;
			}
			
            return true;
			
        } 
				
        return false;
		
    });
	
});

/**
 *
 */
 
function hidepop(div) {
	
	var addobject = $('#'+div);		
	
	document.getElementById(div).style.display = 'none';				

}

	
	/**
	 *
	 *
	 */
	
	function uploaddocs(div, row){
		
		var addobject = $('#'+div);

		var ActivefileObj = $(addobject).find(".fileupload-block");

		countUploadedFile =  $(ActivefileObj).length;

		if( countUploadedFile == 0 ) {

			add_fields('uploadDocsvehicle'+row, row);

		}

		document.getElementById(div).style.display = 'block';
			
	}	
	 
	/**
	 *
	 *
	 */

	function createUniqueId( row, count ){ 
				
		count = parseInt(count) == NaN ? 0 : parseInt(count);
		
		if( $('#DocumentUploadVehicle'+row+count+'vc_uploaded_doc_name').length == 0  ) {
		
			return  count;
		
		}

		return createUniqueId(row,count+1);

	}
	
	/**
	 *
	 *
	 */
	 
	function add_fields(parentObject, rowNumber){
			
		var defaultSet = 1;
			
		var addobject =  $('#'+parentObject).find('.upload-button');
			
		var row = rowNumber;
		
		var countRow = createUniqueId( row , $(addobject).find('.row'+row).length );
		
		var empty = false;

		$(addobject).find('.row'+rowNumber).each(function(){
		
			if( $(this).find('.qq-upload-list .qq-upload-file').length == 0) {			
				empty = true;			
			}
		
		
		});
		
		if(  !empty ) {

			$.ajax({
				type: "POST",
				url: GLOBLA_PATH+'vehicles/addfileupload',
				data: {
					countRow: countRow, 
					row: row
				},
				beforeSend : function (){
					
					$('#uploadDocsvehicle'+row+' .close').hide();
					
					$('.button-addmore').hide();
					
					$(addobject).append("<div id='loading' style='text-align:center;' ><img width='30px' src='"+GLOBLA_PATH+"img/loading.gif' > </img> </div>");	
				},
				success : function (data) {					
					
					if( data !== '' ){
					
						$(addobject).find('#loading').remove();
									
						$(addobject).append(data);
							
						
						/****This Function Mention in vehicles.js file ***/
						
						createUploader("DocumentUploadVehicle"+row+countRow+"vc_uploaded_doc_name", row , countRow);
						
					}
				},
				error : function (xhr, textStatus, errorThrown) {
						$('#uploadDocsvehicle'+row+' .close').show();		
				},
				complete : function (){
						$('#uploadDocsvehicle'+row+' .close').show();
						$('.button-addmore').show();	
				}
			});

		} else {

			$(commonPopupObj).find('#messagetitle').html('Alert Message .');

			$(commonPopupObj).find('#messageshow').html('Please upload firstly ');

			$(commonPopupObj).css('display','block');


		}	
	}
	
	/**
     *
	 *
     *
	 */
	 
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
                allowedExtensions: ["jpeg", "bmp", "png", "jpg",  'pdf'],
                debug: true
            });
        });
    }
	
	/**
	 *
	 *
	 *
	 */
	 
	$(obj).delegate(".qq-upload-remove",'click',function(){
			
			callObj = $(this);
		     //	alert($(callObj).parent().closest('rowuploadid').val());
		     //	alert($(callObj).parent().closest('input[id *=rowCountuploadid').val());
			 // alert($(this).attr('class'));
			$(function() {
				$("<p> Are you sure want delete this file </p>" ).dialog({					
					resizable: false,
					height:140,
					modal: true,
					buttons: {
						"ok": function() {
							//
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

	/**
	 *
	 *
	 *
	 */
	 
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
						
                    $(buttonObject).addClass('form-error');
					
                    $(buttonObject).after('<div class="add-error">Required</div>');
							
                }
		
		
		}
	
		
	});
	/*$('#submitcbceditID').click(function() {
	alert($(obj).valid());
		if($(obj).valid()==true){
			$('#submitcbceditID').attr('disabled', 'disabled'); 
            $('#VehicleCbcEditvehicleForm').submit();			
			return true;
			}

	});*/
	