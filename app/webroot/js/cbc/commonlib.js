
	/******** Default Accept Image Upload Support Type ***/
	var fileExtension = ['pdf','png','jpeg','jpg'];

	/******* Default Image Upload file Size******/
	var defaultFileSize = 2048000; /***2MB***/
	
	
	
	/****Check User is login or not ********/
	
	/*******Avoid Dbclick*************/
	
    $("form input.submit").bind("dblclick", function(e){
		
		e.preventDefault();
		
		return false;
	});
	
			
	$.ajax({
			
		type: "POST",
			
		url: GLOBLA_PATH+'members/checkUserAccess',

	}).done(function( data ) {
		
		if (  $.trim(data) == 'yes' ||  $.trim(data) == 'no' ) {
			
			if (  $.trim(data) != $.trim(USER_ACCESS) ) {

				window.location.reload();

			}	

		} 
			
		
	});		
	
		
	/*************Default Functionality use in auto remove class after 10 sec ****/
		
	setTimeout( function() {     
		
		$('#flashMessage').fadeOut("slow").delay(12000).remove();

	}, 12000);
	
	setTimeout( function() {     
		
		$('.success-message, .info-message, .error-common').fadeOut("slow").delay(12000).remove();

	}, 12000);
	
	function pop(div) {

		document.getElementById(div).style.display = 'block';
	}

	function hide(div) {

		document.getElementById(div).style.display = 'none';
	}	