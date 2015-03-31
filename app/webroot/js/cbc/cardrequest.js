var commonPopupObj = $('#commonmessage');
var obj = $('#RequestCardCbcCardRequestForm');


$(function() {
	
    $(obj).validate();
	
	$.validator.addMethod( "onlyNumberWithoutFloat",function(value, element) {
    
	return this.optional(element) || Number(value) >= 0 && /^\+?(0|[0-9]\d*)$/.test(value);
	
  }, "Decimal not accepted");
  
  $.validator.addMethod( "onlyNumberNozero",function(value, element) {
      
	if( Number(value) === 0 ) {

		return false;
   
   } 
	else{
   
		return true;
	}
	}, "Should be greater than 0");
  
	/**
	 *
	 * 
	 *
	 */
/*
	$("#disread").rules(
	"add",	{
		required: true,
		min:100,
		
		messages: { 
			required	: 	'Required',
			min			:	'Amount must be greater than 100'
			
		}
	});
	*/
	/**
	 *
	 * 
	 *
	 */

	$("#RequestCardVcNoOfCards").rules(
	"add",	{
		required: true,
		maxlength: 15,
		min:1,
		positiveNumber: true,
		onlyNumberWithoutFloat:	true,
		onlyNumberNozero:		true,
		messages: { 
			required	: 	'Please enter number of cards',
			maxlength	:	'Should not be more than 15 numbers ',
			min			:	'No. should be greater than 0 '
			
		}
	});
	
	/**
	 *
	 * 
	 *
	 */
		
	$("#RequestCardNuTotalCharges").rules(
	"add",	{
		required: true,
		messages: { 
			required	: 	'Required',
			
		}
	});
        
        
        
        
    $(obj).delegate( "input[name*='vc_no_of_cards']", "keyup", function() {

          var noOfcards     =  $(obj).find('#RequestCardVcNoOfCards').val();
          var adminfee          =  $(obj).find('#RequestCardVcCardIssueCharges').val();
		  var pendingCardsCost  =  parseInt($(obj).find('#RequestCardPendingCards').val())*adminfee;     
		  var remainingamount   =  noOfcards*adminfee ;
          var PendingCards      =  $(obj).find('#RequestCardPendingCards').val();
        
		  
          
          $(obj).find('#RequestCardNuTotalCharges').val(remainingamount);
           
          //$('#RequestCardNuTotalCharges').val(remainingamount);
         // alert($(obj).find('#disread').val());
		  
		  if($(obj).find('#disread').val()!='')
          var accountbalance = parseFloat($(obj).find('#disread').val());
		  else
		  var accountbalance = parseFloat(0);
		  
    
          var totalcharges  = parseFloat($(obj).find('#RequestCardNuTotalCharges').val());
		              //   alert('--'+accountbalance);

		  if((totalcharges+pendingCardsCost) > accountbalance){

                if(PendingCards>0 && noOfcards>0 && noOfcards!=''){
         		
    				$(commonPopupObj).find('#messageshow').html('Your account balance is not enough for the number of cards requested,request for '+PendingCards+' cards is pending.');
				
				}else if(noOfcards=='' || noOfcards==0) {
				 
					$(commonPopupObj).find('#messageshow').html('No. of cards cannot be blank.');
				
				}else{
					$(commonPopupObj).find('#messageshow').html('Your account balance is not enough for the number of cards requested.');
				}
				$(commonPopupObj).css('display','block');
                 
                 $(obj).find('#RequestCardVcNoOfCards').val('');
                 $(obj).find('#RequestCardNuTotalCharges').val('');
	 	
        }
    
	});
	
	$("#RequestCardCbcCardRequestForm").submit(function( event ) {

		var noOfcards     =  $(obj).find('#RequestCardVcNoOfCards').val();          
	    var adminfee          =  $(obj).find('#RequestCardVcCardIssueCharges').val();
	    var PendingCards      =  $(obj).find('#RequestCardPendingCards').val();
        var pendingCardsCost  =  parseInt($(obj).find('#RequestCardPendingCards').val())*adminfee;
        var remainingamount   =  noOfcards*adminfee ;
       
	    $(obj).find('#RequestCardNuTotalCharges').val(remainingamount);
	   	  
		  if($(obj).find('#disread').val()!='')
          var accountbalance = parseFloat($(obj).find('#disread').val());
		  else
		  var accountbalance = parseFloat(0);
		  
	    var totalcharges  = parseFloat($(obj).find('#RequestCardNuTotalCharges').val());
	    var finaltotal    = totalcharges+pendingCardsCost;
		//	  alert(pendingCardsCost);
		
        if(finaltotal > accountbalance){
                
				 if(PendingCards>0 && noOfcards>0 && noOfcards!=''){
         		
    				$(commonPopupObj).find('#messageshow').html('Your account balance is not enough for the number of cards requested,request for '+PendingCards+' cards is pending.');
				
				}else if(noOfcards=='' || noOfcards==0) {
				 
				 $(commonPopupObj).find('#messageshow').html('No. of cards cannot be blank.');
				
				}else{
				$(commonPopupObj).find('#messageshow').html('Your account balance is not enough for the number of cards requested.');
				}
				
                 $(commonPopupObj).css('display','block');                 
                 $(obj).find('#RequestCardVcNoOfCards').val('');
                 $(obj).find('#RequestCardNuTotalCharges').val('');
				 return false;
	 	
        }
    
});
	 
        
		
});
$('form').bind('submit', function(e) {
		if($(obj).valid()==true){
			$('.submit').attr('disabled', 'disabled');    
			return true;
			}

	});	
