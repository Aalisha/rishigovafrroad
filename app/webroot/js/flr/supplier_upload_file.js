 var obj = $('#FuelOutletFlrSupplierForm');
$(function() {

   
	
    $(obj).validate();
	$("#supplierdoc").rules(
            "add", {
        required: true,
		acceptsupplierdoc	: true,
		filesizesupplier	: true,
        
        messages: {
            required: 'Please upload document',
			acceptsupplierdoc	:	'File must be .xls or .xlt',			
			filesizesupplier	:	'File must be less than 10MB',
           
        }
    });
	
/*	$("#supplierdoc").rules("add",  {
	
		required	:	true,
	
		//acceptsupplierdoc	: true,
				
		filesizesupplier	: true
			
		
		messages: { 
		
		required	:	'Please upload document',		
		
		//acceptsupplierdoc	:	'File must be .xls or .xlt',
		
		filesizesupplier	:	'File must be less than 10MB'

		
		
		}
	});
	*/

});

$('form').bind('submit', function(e) {
		if($(obj).valid()==true){
			$('.submit').attr('disabled', 'disabled');    
			return true;
			}});