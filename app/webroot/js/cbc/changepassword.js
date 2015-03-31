$(function() {
var obj = $('#MemberForgotpasswordForm');
   

    $(obj).validate();
	
	
	/**
	 *
	 * 
	 *
	 */

	$("#email").rules(
		"add",	{
			required: true,
			email: true,
			maxlength: 50,
			messages: { 
				required	: 	'Required',
				email       :   'Should be a valid email address',
				maxlength	:	'Maximum 50 Characters Only'
				}
		});
});		