$(function() {
	
	var obj = $('#MemberLoginForm') || $('#InspectorLoginForm');
	
	$(obj).validate();
	
	$('#reset').click( function(){
	
		var url = GLOBLA_PATH+"members/captcha_image?"+ Math.round(Math.random(0)*1000)+1;
		
		$('#captcha').attr('src', url);
		
	
	});
	


	$("#vc_username").rules(
		"add",	{
			required: true,
			minlength: 9,
			maxlength: 30,
			username: true,
			messages: { 
				required	: 	'Please enter username',
				minlength	: 	'Minimum 9 characters',
				maxlength	:	'Maximum 30 characters only'
				}
		});	
		
	$("#vc_password").rules(
		"add",	{
			required: true,
			minlength: 6,
			maxlength: 50,
			messages: { 
				required	: 	'Please enter password',
				minlength	: 	'Minimum 6 characters ',
				maxlength	:	'Maximum 50 characters only'
				}
		});
	
     $('#account_type').rules(
                "add",	{
                        required: true,
                        messages: { 
				required	: 	'Please select type'
                            }
                        
            });	
			
   $("#vc_captcha_code").rules(
		"add",	{
			required: true,
			minlength: 6,
			maxlength: 6,
			messages: { 
				required	: 	'Please enter code',
				minlength	: 	'Minimum 6 characters ',
				maxlength	:	'Maximum 6 characters only'
				}
		});

});