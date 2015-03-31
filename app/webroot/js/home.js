$(function() {
	
	var obj = $('#InspectorIndexForm');
	
	$(obj).validate();

	$("#vc_username").rules(
		"add",	{
			required: true,
			minlength: 9,
			maxlength: 15,
			username: true,
			messages: { 
				required	: 	'Required',
				minlength	: 	'Minimum 9 Characters Only',
				maxlength	:	'Maximum 15 Characters Only'
				}
		});	
		
	$("#vc_password").rules(
		"add",	{
			required: true,
			minlength: 6,
			maxlength: 15,
			messages: { 
				required	: 	'Required',
				minlength	: 	'Minimum 6 Characters Only',
				maxlength	:	'Maximum 15 Characters Only'
				}
		});		
  
});