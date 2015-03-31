var commonPopupObj = $('#commonmessage');

var obj = $('#ProfileViewlogdetailForm');

var backproceesingPopupObj = $('#backproceesing');

var validator = $(obj).validate();


/************ Reset Value Of Drop Origin and destination ****************/
    
$(function() {
	
	/////////// To Delete LogDetails which are not bind to assessment ///

	$(obj).delegate(".qq-upload-remove_log",'click',function(){
			callObj = $(this);
			var substrvalue = callObj.attr('id');
			
			$(function() {
				$("<p> Click Ok to confirm before deleting the Log else cancel </p>" ).dialog({					
					resizable: false,
					height:150,
					width:400,
					modal: true,
					buttons: {
						"ok": function() {
							//alert('hua'+callObj.attr('id'));
							url= GLOBLA_PATH+'vehicles/deletelogs/'+substrvalue;

							window.location.href =   url;

							$(this).dialog( "close" );
						},
						Cancel: function() {
							$( this ).dialog( "close" );
						}
					}
				});
			});
	});
	});


