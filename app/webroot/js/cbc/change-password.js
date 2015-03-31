$(function() {
	
    var obj = $('#CustomerCbcChangepasswordForm');
	
    $(obj).validate();

    $("#password").rules(
        "add",	{
            required: true,
			minlength: 6,
			maxlength: 50,
			messages: { 
				required	: 	'Please enter old password',
				minlength	: 	'Password Must contain atleast 6 Characters',
				maxlength	:	'Password Must be less than  50 Characters'
				}
        });
    $("#new_password").rules(
        "add",	{
            required: true,
			minlength: 6,
			maxlength: 50,
			messages: { 
				required	: 	'Please enter new password',
				minlength	: 	'Password Must contain atleast 6 Characters',
				maxlength	:	'Password Must be less than  50 Characters'
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
				minlength	: 	'Password Must contain atleast 6 Characters',
				maxlength	:	'Password Must be less than  50 Characters',
                                equalTo         :       'Passwords must match'
				}
        });
    
	  
});


