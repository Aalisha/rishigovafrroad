$(function() {
   
    $('#fromDate').datepicker({
		 
        maxDate: "0 D",
		 
        defaultDate: "+1w",
		 
        changeMonth: true,
		 
        changeYear: true,
		 
        dateFormat: 'd M yy',
		 
        onClose: function( selectedDate ) {
			
			$( "#toDate" ).datepicker( "option", "minDate", selectedDate );
		
		}
    });
	
    $('#toDate').datepicker({
	
        maxDate: "0 D",
		 
        defaultDate: "+1w",
		 
        changeMonth: true,
		 
        changeYear: true,
		 
        dateFormat: 'd M yy',
		
		onClose: function( selectedDate ) {
		
			$( "#fromDate" ).datepicker( "option", "maxDate", selectedDate );
		
		}   
    });
   
   var obj = $('#InspectorPaymenthistoryForm');
   
   $(obj).validate();
   
	$('#fromDate').rules("add",{
		maxlength	: 12,
		date		: true,
		messages : {
			date		:	'Should be format',
			maxlength	: 	'Maximum accept 12 character'

	}});
									
	$('#toDate').rules("add",{

		maxlength	: 12,
		date		: true,
		messages : {
			date		:	'Should be format',
			maxlength	: 	'Maximum accept 12 character'
		}});
		
		$('#vc_customer_name').rules("add",{
			
			alphabetic	: true,
			maxlength	: 100,
			messages : {
				alphabetic	:	'only character',
				maxlength	: 	'Maximum accept 100 character'
		}});		
  
});