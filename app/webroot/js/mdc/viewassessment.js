var commonPopupObj = $('#commonmessage');

var backproceesingPopupObj = $('#backproceesing');

$(function(){

	$('.listsr1').delegate("table tr img","click",function(){
	
		parentTr = $(this).parent().parent(); /* Get object of tr which contain img */
		
		getId = $.trim($(parentTr).find("input[type='hidden']:first").val());
		
		$(backproceesingPopupObj).css('display','block');
		
		if( getId !='' ) {				

			 $.ajax({

                    type: "POST",

                    url: GLOBLA_PATH+'vehicles/getassessmentremarksbyid',

                    data: { data: getId }

                }).done(function( data ) {
					
					$(backproceesingPopupObj).css('display','none');
					
					$(commonPopupObj).find('#messageshow').html(data);

					$(commonPopupObj).css('display','block');		
									
                });		
			
		
		
		}else {
				
                $(backproceesingPopupObj).css('display','none');
				
                $(commonPopupObj).find('#messageshow').html('Sorry some error has been occured. Please refresh page then try again.!!');

                $(commonPopupObj).css('display','block');
		
		}
	
	});
});