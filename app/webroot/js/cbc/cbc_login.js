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
				required	: 	'Please enter  User Name',
				minlength	: 	'Minimum 9 Character ',
				maxlength	:	'Maximum 30 Character Only',
				}
		});	
		
	$("#vc_password").rules(
		"add",	{
			required: true,
			minlength: 6,
			maxlength: 50,
			messages: { 
				required	: 	'Please enter Password',
				minlength	: 	'Minimum 6 Character ',
				maxlength	:	'Maximum 50 Character Only',
				}
		});
	
    $('#account_type').rules("add",	{required: true,messages: { 
				required	: 	'Please select type'}});	
			
	$("#vc_captcha_code").rules(
		"add",	{
			required: true,
			minlength: 6,
			maxlength: 6,
			messages: { 
				required	: 	'Please enter Captcha',
				minlength	: 	'Minimum 6 Character ',
				maxlength	:	'Maximum 6 Character Only',
				}
		});

});