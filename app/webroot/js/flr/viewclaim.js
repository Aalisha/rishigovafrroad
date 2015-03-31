$(function() {

    
    var commonPopupObj = $('#commonmessage');
    
	var backproceesingPopupObj = $('#backproceesing');
	
	var logpopupObj = $('#logpopup');

    $('.cont1').delegate(".showlog", 'click', function() {
        selectedRow = $(this).parent().parent();
		//claimId= $(this).val();
		var Rowid         = parseInt($(this).attr('id').split("linkId_")[1], 7);
       //alert(Rowid)  ;
		var claimId = $('#hidden_claim_id_'+Rowid).val();
		//alert(claimId);
	if( claimId !='' ) {				

			 $.ajax({

                    type: "POST",

                    url: GLOBLA_PATH+'flr/claims/getclaimdetails',

                    data: { data: claimId }

                }).done(function( data ) {
				//alert(data);
					$(backproceesingPopupObj).css('display','block'); 
					$(backproceesingPopupObj).css('display','none');
					 $(logpopupObj).find('#showlogdata').html(data);
					//$(commonPopupObj).find('#messageshow').html(data);

					  $(logpopupObj).css('display', 'block');
									
                });		
			
		
		
		}else {
				
                $(backproceesingPopupObj).css('display','none');
				
                $(commonPopupObj).find('#messageshow').html('Sorry some error has been occured. Please refresh page then try again.!!');

                $(commonPopupObj).css('display','block');
		
		}
				/*
			$(backproceesingPopupObj).css('display','block'); 
			
                $(logpopupObj).find('#showlogdata').html('hus');
				$(backproceesingPopupObj).css('display','none');
                $(logpopupObj).css('display', 'block');*/
			//	$(commonPopupObj).find('#messageshow').html('Some Error has occured please try again ');
				//$(commonPopupObj).css('display', 'block');

     

    });
	
	});

