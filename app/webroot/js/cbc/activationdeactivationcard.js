var obj = $('#CardCbcActivationdeactivationForm');
var commonPopupObj = $('#commonmessage');


$(function() {

$(obj).validate();

	$(obj).delegate("select[name *='vc_card_flag']",'change',function(){
		
		$(this).closest('tr').find("textarea[name *='[vc_reason]']").trigger('blur');
		
	});
function CardCompleteValidation ( ) {

	$(obj).find("textarea[name *='[vc_reason]']").each(function(){
				
				$(this).rules("add",{

					required 	: {

						depends: function(element) {
							
							if( $.trim($(element).parent().parent().find("select[name *='vc_card_flag']").val()) != '' ){

								return true;
							}

							return false;	
						
						}
					},
					
					maxlength:	250,
					messages : {

						required	: 	'Required',
						maxlength	:	'Should not be more than 250 characters'
					
					}
				});

	});
	
	}
	
	CardCompleteValidation(); 

	
	$(obj).submit(function(){
	
		total = $(this).find('select').length;
		
		selected =  0;
		
		$(this).find('select').each(function(){
		
			if($(this).val() !== '' ) {
				
				selected++;
				
			}
		
		});
		
				
		if( total === 0 ){
		
			$(commonPopupObj).find('#messageshow').html('No card found to activate / deactivate !!');
                        $(commonPopupObj).css('display','block');
			
			return false;
		
		}	else if( selected === 0 ){
	
			$(commonPopupObj).find('#messageshow').html('Please select atleast one card to activate / deactivate !!');

			$(commonPopupObj).css('display','block');
				
			return false;
			
		}else {
			
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
	
			
});	
