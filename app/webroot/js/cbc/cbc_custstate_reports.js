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
	
	
	
	 var obj = $('#CustomerCbcCustomerstatementsForm');
	 
	 
	 
	 $(obj).validate();
   
    $('#fromDate').rules("add",{
        maxlength	: 12,
        date		: true,
        messages : {
            date		:	'Must be valid date format ',
            maxlength	: 	'Maximum accept 12 character'

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


function postReportdata(formname,geturl) 
{ 
    
   var url = GLOBLA_PATH+geturl;
   var data=  $('#'+formname).serialize() ;
   window.open(url+"/"+data,'Download Report','left=20,top=20,width=100,height=100,toolbar=1,resizable=0');
   window.close();
}