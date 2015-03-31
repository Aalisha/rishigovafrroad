$(function() {
	
    var obj = $('#GeneratepasswordGeneratetemporarypasswordForm');
	
    $(obj).validate();

    $("#GeneratepasswordPassword").rules(
        "add",	{
            
			required: true,
			
			minlength: 6,
			
			maxlength: 50,
			
			messages: { 
				
				required	: 	'Please enter password',
				
				minlength	: 	'Password must contain atleast 6 Characters',
				
				maxlength	:	'Password must be less than 50 Characters'
				}
        });
		
    $("#GeneratepasswordConfirmpassword").rules(
        "add",	{
            
			required: true,
			
			minlength: 6,
			
			maxlength: 50,
			
			equalTo : "#GeneratepasswordPassword",
			
			messages: { 
				
				required	: 	'Please enter confirm password',
				
				minlength	: 	'Password must contain atleast 6 Characters',
				
				maxlength	:	'Password must be less than 50 Characters',
				
				equalTo 	:	'Passwords must match'
			}
        });
    
	  
});


