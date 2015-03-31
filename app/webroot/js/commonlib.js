	
	/*************Default Functionality use in auto remove class after 10 sec ****/
		
setTimeout( function() {     
		
		$('.success-message, .info-message, .error-common').fadeOut("slow").delay(8000).remove();

	}, 8000);
	
	if( $('form').length > 0 ) {
			
		$('form').bind('submit', function(e) {
			  
			   if($(this).valid()==true){
					
					if( $(this).find('input[type ="submit"]').length > 0 ) {
					 
						$(this).find('input[type ="submit"]').attr('disabled', 'disabled');    
					} 
					
					if( $(this).find('button[type ="submit"]').length > 0 ) {
					 
						$(this).find('button[type ="submit"]').attr('disabled', 'disabled');    
					}
					
					
					return true;
			   }

		 });

	}	 	