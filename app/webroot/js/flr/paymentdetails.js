$(function() {
  
    $('#PaymentreportFromDate').datepicker({
		 
        maxDate: "0 D",
		 
        defaultDate: "+1w",
		 
        changeMonth: true,
		 
        changeYear: true,
		 
        dateFormat: 'd M yy',
		 
        onClose: function( selectedDate ) {
			
            $( "#PaymentreportToDate" ).datepicker( "option", "minDate", selectedDate );
		
        }
    });
	
    $('#PaymentreportToDate').datepicker({
	
        maxDate: "0 D",
		 
        defaultDate: "+1w",
		 
        changeMonth: true,
		 
        changeYear: true,
		 
        dateFormat: 'd M yy',
		
        onClose: function( selectedDate ) {
		
            $( "#PaymentreportFromDate" ).datepicker( "option", "maxDate", selectedDate );
		
        }   
    });
    

    var obj = $('#ReportFlrPaymentdetailsForm');
   
    $(obj).validate();
   
    $('#PaymentreportFromDate').rules("add",{
        date		: true,
        messages : {
            date		:	'Must be valid date'
        }
    });
									
    $('#PaymentreportToDate').rules("add",{
        date		: true,
        messages : {
            date		:	'Must be valid date'
        }
    });
   

});
