$(function() {
  
    $('#ClaimsummaryreportFromDate').datepicker({
		 
        maxDate: "0 D",
		 
        defaultDate: "+1w",
		 
        changeMonth: true,
		 
        changeYear: true,
		 
        dateFormat: 'd M yy',
		 
        onClose: function( selectedDate ) {
			
            $( "#ClaimsummaryreportToDate" ).datepicker( "option", "minDate", selectedDate );
		
        }
    });
	
    $('#ClaimsummaryreportToDate').datepicker({
	
        maxDate: "0 D",
		 
        defaultDate: "+1w",
		 
        changeMonth: true,
		 
        changeYear: true,
		 
        dateFormat: 'd M yy',
		
        onClose: function( selectedDate ) {
		
            $( "#ClaimsummaryreportFromDate" ).datepicker( "option", "maxDate", selectedDate );
		
        }   
    });
    

    var obj = $('#ReportFlrClaimsummarysForm');
   
    $(obj).validate();
   
    $('#ClaimsummaryreportFromDate').rules("add",{
        maxlength	: 12,
        date		: true,
        messages : {
            date		:	'Must be valid date'
        }
    });
									
    $('#ClaimsummaryreportToDate').rules("add",{

        maxlength	: 12,
        date		: true,
        messages : {
            date		:	'Must be valid date'
        }
    });
   

});
