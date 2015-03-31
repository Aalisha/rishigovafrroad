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
    

    var obj = $('#Report');
   
    $(obj).validate();
   
    $('#fromDate').rules("add",{
        date		: true,
        messages : {
            date		:	'Must be valid date'
        }
    });
									
    $('#toDate').rules("add",{
        date		: true,
        messages : {
            date		:	'Must be valid date'
        }
    });
   

});
