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
    

    var obj = $('#ReportPaymenthistoryForm');
   
    $(obj).validate();
   
    $('#fromDate').rules("add",{
        maxlength	: 12,
        date		: true,
        messages : {
            date		:	'Must be valid date format ',
            maxlength	        : 	'Maximum accept 12 character'

        }
    });
									
    $('#toDate').rules("add",{

        maxlength	: 12,
        date		: true,
        messages : {
            date		:	'Must be valid date format',
            maxlength           : 	'Maximum accept 12 character'
        }
    });
   

});
