var obj = $('#VehicleCbcActivationdeactivationForm');
var commonPopupObj = $('#commonmessage');

/**
*
* 
*
*/

$(function() {

	
	$(obj).submit(function(){
	
		total = $(this).find('select').length;
		
		selected =  0;
		
		$(this).find('select').each(function(){
		
			if($(this).val() !== '' ) {
				
				selected++;
				
			}
		
		});
		
				
		if( total === 0 ){
		
			$(commonPopupObj).find('#messageshow').html('No records found !!');
			$(commonPopupObj).css('display','block');
			return false;
		
		}	else if( selected === 0 ){
			
			$(commonPopupObj).find('#messageshow').html('Please select atleast one vehicle to deactivate !!');

			$(commonPopupObj).css('display','block');
			return false;
			
		}else{
			
			if( $(this).valid() ){
					
					if( $(this).find('input[type ="submit"]').length > 0 ) {
					 
						$(this).find('input[type ="submit"]').attr('disabled', 'disabled');    
					} 
					
					if( $(this).find('button[type ="submit"]').length > 0 ) {
					 
						$(this).find('button[type ="submit"]').attr('disabled', 'disabled');    
					}
					
					
					return true;
			}
		
			return false;	
		
		}
		
					
	});	
		
		
});	/*
$('form').bind('submit', function(e) {
	  if($(obj).valid()==true){
		$('.submit').attr('disabled', 'disabled');      
	   return true;
	   }

	 });*/
