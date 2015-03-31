$(function() {
  
    $('#ClaimdetailsreportFromDate').datepicker({
		 
        maxDate: "0 D",
		 
        defaultDate: "+1w",
		 
        changeMonth: true,
		 
        changeYear: true,
		 
        dateFormat: 'd M yy',
		 
        onClose: function( selectedDate ) {
			
            $( "#ClaimdetailsreportToDate" ).datepicker( "option", "minDate", selectedDate );
		
        }
    });
	
    $('#ClaimdetailsreportToDate').datepicker({
	
        maxDate: "0 D",
		 
        defaultDate: "+1w",
		 
        changeMonth: true,
		 
        changeYear: true,
		 
        dateFormat: 'd M yy',
		
        onClose: function( selectedDate ) {
		
            $( "#ClaimdetailsreportFromDate" ).datepicker( "option", "maxDate", selectedDate );
		
        }   
    });
    

    var obj = $('#ReportFlrClaimdetailsForm');
   
    $(obj).validate();
   
    $('#ClaimdetailsreportFromDate').rules("add",{
        date		: true,
        messages : {
            date		:	'Must be valid date'
        }
    });
									
    $('#ClaimdetailsreportToDate').rules("add",{
        date		: true,
        messages : {
            date		:	'Must be valid date'
        }
    });
    
    
    $(obj).delegate("select[name*='vc_claim_no']",'change',function(){
      
        parentValue = $(this).val();
        
       if(parentValue) {
        ($).ajax({
            type: "POST",
            url: GLOBLA_PATH + 'flr/flrreports/getClaimDetails',
            data: {
                data : $(this).val()
            }
        }).done(function(data){
            objJson = jQuery.parseJSON(data);
        
            $("#ClaimdetailsreportDtEntryDate").val(objJson.dt_entry_date).trigger('blur');
            $("#ClaimdetailsreportVcStatus").val(objJson.vc_status).trigger('blur');
      
        });   
           
       } else {
            $("#ClaimdetailsreportDtEntryDate").val('');
            $("#ClaimdetailsreportVcStatus").val('');
           
       }
       
        
       
    });
        
 

});
