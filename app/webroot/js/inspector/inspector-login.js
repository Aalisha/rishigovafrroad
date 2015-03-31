$(function() {
	
	var obj = $('#InspectorLoginForm');
	
	$(obj).validate();
	
	$('#reset').click( function(){
	
		var url = GLOBLA_PATH+"inspectors/captcha_image?"+ Math.round(Math.random(0)*1000)+1;
		
		$('#captcha').attr('src', url);
		
	
	});
	

	$("#vc_username").rules(
		"add",	{
			required: true,
			minlength: 9,
			maxlength: 30,
			username: true,
			messages: { 
				required	: 	'Required',
				minlength	: 	'Minimum 9 Characters Only',
				maxlength	:	'Maximum 30 Characters Only',
				}
		});	
		
	$("#vc_password").rules(
		"add",	{
			required: true,
			minlength: 6,
			maxlength: 50,
			messages: { 
				required	: 	'Required',
				minlength	: 	'Minimum 9 Characters Only',
				maxlength	:	'Maximum 50 Characters Only',
				}
		});
	
    $('#account_type').rules("add",	{required: true,messages: { 
				required	: 	'Required'}});	
			
	$("#vc_captcha_code").rules(
		"add",	{
			required: true,
			maxlength: 6,
			messages: { 
				required	: 	'Required',
				maxlength	:	'Maximum 6 Characters Only',
				}
		});

});