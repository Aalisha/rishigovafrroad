$(function() {
	
    var obj = $('#ProfileChangepasswordForm');
	
    $(obj).validate();

    $("#password").rules(
        "add",	{
            required: true,
			minlength: 6,
			maxlength: 50,
			messages: { 
				required	: 	'Please enter old password',
				minlength	: 	'Password must contain atleast 6 characters',
				maxlength	:	'Password must be less than 50 characters'
				}
        });
    $("#new_password").rules(
        "add",	{
            required: true,
			minlength: 6,
			maxlength: 50,
			messages: { 
				required	: 	'Please enter new password',
				minlength	: 	'Password must contain atleast 6 characters',
				maxlength	:	'Password must be less than 50 characters'
				}
        });
    $("#confirm_password").rules(
        "add",	{
            required: true,
			minlength: 6,
			maxlength: 50,
                        equalTo : "#new_password",
			messages: { 
				required	: 	'Please enter confirm password',
				minlength	: 	'Password must contain atleast 6 characters',
				maxlength	:	'Password must be less than  50 characters',
                                equalTo         :       'Passwords must match'
				}
        });
		
		
	$(obj).bind('submit', function(e) {
		  
		   if($(this).valid()) {
				
				if( $(this).find('input[type ="submit"]').length > 0 ) {
				 
					$(this).find('input[type ="submit"]').attr('disabled', 'disabled');    
				} 
				
				if( $(this).find('button[type ="submit"]').length > 0 ) {
				 
					$(this).find('button[type ="submit"]').attr('disabled', 'disabled');    
				}
				
				
				return true;
		   }
		   
		   return false;

	 });	
    
	  
});


