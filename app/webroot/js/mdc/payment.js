$(function() {

	var obj = $('#PaymentIndexForm');
	var commonPopupObj = $('#commonmessage');

	
	$(obj).validate();
	
	$(obj).find("input[name *=vc_mdc_paid]").each(function(){
			
			$(this).rules("add",{
				required 	: true,
				positiveNumber		:true,
				maxlength	: 10,
				messages : {
					required 		: 'Required',
					maxlength		: 'Maximum accept 10 character',
					positiveNumber	: 'Should be number'	
				}});


	});	
	
	$(obj).find("input[name *=vc_payment_reference_no]").each(function(){
			
			$(this).rules("add",{
				required 	: true,
				minlength	: 6,
				maxlength	: 50,
				messages : {
					required 	: 'Required',
					maxlength	: 'Maximum accept 50 character',
					minlength	:	'Minimm 6 character'
				}});


	});	
	
	$(obj).find("input[name *=vc_bank_struct_code]").each(function(){
			
			$(this).rules("add",{
				required 	: true,
				messages : {
					required 	: 'Required'
			}});


	});	
	$(obj).delegate("#deletedocid",'click',function(){
			
			callObj = $(this);
			var urlvalue = callObj.attr('rel');
			//alert(urlvalue);
			
			$(function() {
				$("<p> Are you sure want delete this file </p>" ).dialog({					
					resizable: false,
					height:150,
					modal: true,
					buttons: {
						"ok": function() {								
							window.location.href=urlvalue;
							$( this ).dialog( "close" );
						},
						Cancel: function() {
							$( this ).dialog( "close" );
						}
					}
				});
			});
	
	});
	
	$(obj).find("input[name *=vc_uploaded_doc_name]").rules(
        "add",	{
			accept:true,
			
        });	
		
	$(obj).bind('submit', function(e) {
		  
		  if((parseFloat($('#PaymentVcMdcPaid').val()) < parseFloat($('#PaymentVcMdcPayableHidden').val()))){
			  
			  $(commonPopupObj).find('#messageshow').html('Amount cannot be less than payable amount. !!');
			  $(commonPopupObj).css('display','block');
			  return false;
		  
		  }
		  
		   if($(this).valid()) {
				
				
				if( $(this).find('input[type ="submit"]').length > 0 ) {
				 
					$(this).find('input[type ="submit"]').attr('disabled', 'disabled');    
				} 
				
				if( $(this).find('button[type ="submit"]').length > 0 ) {
				 
					$(this).find('button[type ="submit"]').attr('disabled', 'disabled');    
				}
				
				$(this).find('button[type ="button"]').attr('disabled', 'disabled');
				
				return true;
		   }
		   
		   return false;

	 });		
	
});