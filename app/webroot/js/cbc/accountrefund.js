 var commonPopupObj = $('#commonmessage');
 var obj =$('#CardRefundCbcRefundRequestForm');

$(function() {


 $(obj).validate();
 
 /*
 **
 **
 **
 */			

 $('#CardRefundVcRefundCharges').rules(
  "add", {
		required: true,
		messages: {
			
			required   :   'Required'
			}
			});
			
 $('#CardRefundVcNetRefundable').rules(
  "add" , {
		required: true,
			messages: {

			required   :    'Required'
		
		}
		});
		
		
		$("#CardRefundCbcRefundRequestForm").submit(function( event ) {
		
		//CardRefundVcAccountBalance
		var accountBalance     =  $(obj).find('#CardRefundVcAccountBalance').val();
		if(parseFloat(accountBalance) < 100 ){
			
			 $(commonPopupObj).find('#messageshow').html('Your account balance should be greater than 100 for refund request!!');
			 $(commonPopupObj).css('display','block');                 
             
			 return false;
	 	
        }
    
});
$('#CardRefundCbcRefundRequestForm').bind('submit', function(e) {
	  if($(obj).valid()==true){
	   $('#accountrefundID').attr('disabled', 'disabled');    
	   return true;
	   }

	 });

	
		
});	
	
			