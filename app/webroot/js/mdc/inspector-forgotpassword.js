$(function() {
	
	var obj = $('#InspectorForgotpasswordForm');
	
	$(obj).validate();
	
	$("#email").rules(
		"add",	{
			required: true,
			email: true,
			maxlength: 50,
			messages: { 
				required	: 	'Required',
				maxlength	:	'Maximum 50 Characters Only',
				}
		});	
	
		$('#account_type').rules("add",	{required: true,messages: { 
				required	: 	'Required'}});	
	
});