
   
$(function() {
	var obj = $('#MdcRefundCbcRefundRequestForm');   
	
    $(obj).validate();
	
	$.validator.addMethod("onlyNumberNozero",function(value, element) {
      
	if( Number(value) === 0 ) {   
    
		return false;
	} else{
		return true;
		}   
  }, "Should be greater than 0");
  
	/**
	 *
	 * 
	 *
	 */

	$("#MdcRefundVcPermitNo").rules(
	"add",	{
		required: true,
		maxlength: 20,
		alphanumeric : true,
		messages: { 
			required	: 	'Please enter permit no.',
			maxlength	:	'Should not be more than 20 characters',
			alphanumeric:   'Should be alphanumeric'
		}
	});

	$("#MdcRefundNuPermitAmt").rules(
	"add",	{
		required: true,
		maxlength: 12,
		positiveNumber : true,
		onlyNumberNozero:	true,
		messages: { 
			required	: 	'Please enter amount',
			maxlength	:	'Should not be more than 12 characters'
			
		}
	});
		
	$("#MdcRefundVcReason").rules(
	"add",	{
		required: true,
		maxlength: 150,
		messages: { 
			required	: 	'Please enter a reason',
			maxlength	:	'Should not be more than 150 characters'
		}
	});
		
	$("#MdcRefundVcDestination").rules(
	"add", {
		required:true,
		maxlength:50,
		messages:{
			required   :   'Please enter destination',
			maxlength  :   'Should not be more than 50 characters'
			}
		});
		
	$("#DocumentUploadCbcVcUploadDocName").rules(
	"add" , {
		required: true,
		
		accept	: true,
				
		filesize: true,
		
		messages: { 
			required	: 	'Please upload a file'
		}
	});
	$('#MdcRefundCbcRefundRequestForm').bind('submit', function(e) {
	  if($(obj).valid()==true){
	   $('#mdcrefundID').attr('disabled', 'disabled');    
	   return true;
	   }

	 });
		
	});	
