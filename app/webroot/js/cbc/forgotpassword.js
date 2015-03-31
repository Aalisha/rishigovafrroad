

$(function() {

var obj = $('#MemberForgotpasswordForm');

	$(obj).validate();
	
	$("#email").rules(
		"add",	{
			required: true,
			email: true,
			maxlength: 50,
			messages: { 
				required	: 	'Please enter Email id',
				maxlength	:	'Maximum 50 Character Only'
				}
		});	
	
	$('#account_type').rules("add",	{required: true,messages: { 
				required	: 	'Please select type'}});		
	
});