$(document).ready(function(){
	
	$( "#datepicker" ).datepicker({ maxDate: new Date, dateFormat: 'd M yy', changeMonth: true, changeYear: true,});

});

/**
*
* 
*
*/

var obj = $('#AccountRechargeCbcAccountRechargeForm');


/**
*
* 
*
*/

$(function() {
	
    $(obj).validate();	
	
	
	$("#datepicker").rules(
	"add",	{		
		required: true,		
		messages: { 
		
			required	: 	'Please select date'
		}
	});
	
/**
*
* 
*
*/
	

	$("#AccountRechargeNuAmountUn").rules(
	"add",	{
		
		required: true,
		
		positiveNumber: true,
			
		min:100,
		
		maxlength: 15,
		
		messages: { 
			required	: 	'Please enter amount',
			min			:	'Amount must be greater<br> than 100',
			maxlength	:	'Should not be more than 15 characters'
		}
	});
	
/**
*
* 
*
*/

	$("#AccountRechargeNuHandCharge").rules(
	"add",	{
		
		required: true,
		
		maxlength: 12,
		
		positiveNumber: true,
		
		messages: { 
			required	: 	'Must not be blank',
			maxlength	:	'Should not be more than 12 characters'
		}
	});

/**
*
* 
*
*/	

	$("#AccountRechargeChTranType").rules(
	"add",	{
		
		required: true,
		
		messages: { 
			required	: 	'Please select an option'
		}
	});

/**
*
* 
*
*/	
		
	$("#AccountRechargeVcRefNo").rules(
	"add",	{
		
		required: true,
		
		maxlength: 20,
		
		alphanumeric:true,
		
		messages: { 
			required	: 	'Please enter reference number',
			maxlength	:	'Should not be more than 20 characters',
			alphanumeric:	'Alphanumeric only'
		}
	});

/**
*
* 
*
*/	
	
	$("#DocumentUploadCbcVcUploadDocName").rules(
	"add",	{
		
		required: true,
		
		accept	: true,
				
		filesize: true,
		
		messages: { 
			required	: 	'Please upload a file'
		}
	});
		
		
});	




$('form').bind('submit', function(e) {
		if($(obj).valid()==true){
			$('.submit').attr('disabled', 'disabled');    
			return true;
			}

	});
	
