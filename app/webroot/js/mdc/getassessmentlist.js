 $(function() {
	
	var objDate = new Date();
	
	var commonPopupObj = $('#commonmessage');
	
	var popObj = $('#popDiv3');
	
	var obj = $('#InspectorGetassessmentlistForm');
	
	var defaultExist = 0;
	
	var submitValue = false;
 
	$(obj).find('.innerbody').delegate("#addshow",'click',function(){
		
		$(popObj).css('display', 'block');
	
	});
	
	
	$(popObj).delegate("input[type *='radio']",'click',function(){
		
		value = $(this).val();
		 
		selectObj = $(this);
		 
		$.ajax({

			type: "POST",

			url: GLOBLA_PATH+'inspectors/getuserdetail',

			data: {

				data : value
			 
			}

		}).done(function( data ) {

			if( data ) {
				
				$(obj).find('.innerbody:first').html(data);
				
				$.ajax({

					type: "POST",

					url: GLOBLA_PATH+'inspectors/getassessmentdetail',

					data: {

						data : value

					}

				}).done(function( data ) {

					$(obj).find('.listsr1').html(data);

				});
				
				$(popObj).css('display', 'none');
			
			} else {
			   
				$(parentObj).val('');
		
				$(commonPopupObj).find('#messageshow').html('In valid user name try again ');

				$(commonPopupObj).css('display','block');
				
			
			}
		});
		 
			
	});
	
	
 });
 
