
$(function() {

var obj = $('#CbcRefundCbcRefundRequestForm');


$(obj).validate();
	
	$.validator.addMethod( "onlyNumberNozero",function(value, element) {
      
	if( Number(value) === 0 ) {
    
    
   return false;
   } else{
   return true;}
     
   
  }, "Should be greater than 0");
	
	/**
	 *
	 * 
	 *
	 */

	$("#CbcRefundVcPermitNo").rules(
	"add",	{
		required: true,
		maxlength: 20,
		alphanumeric: true,
		messages: { 
			required	: 	'Please enter permit no.',
			maxlength	:	'Should not be more than 20 characters',
			alphanumeric:   'Should be alphanumeric'
		}
		
	});

	$("#CbcRefundNuPermitAmt").rules(
	"add",	{
		required: true,
		maxlength: 12,
		positiveNumber: true,
		onlyNumberNozero:	true,
		messages: { 
			required	: 	'Please enter amount',
			maxlength	:	'Should not be more than 12 characters'
			
		}
	});
		
	$("#CbcRefundVcReason").rules(
	"add",	{
		required: true,
		maxlength: 150,
		
		messages: { 
			required	: 	'Please enter a reason',
			maxlength	:	'Should not be more than 150 characters'
		}
	});
		
	$('#CbcRefundCbcRefundRequestForm').bind('submit', function(e) {
	  if($(obj).valid()==true){
	   $('#cbcrefundID').attr('disabled', 'disabled');    
	   return true;
	   }

	 });
		
	});	
	
		

