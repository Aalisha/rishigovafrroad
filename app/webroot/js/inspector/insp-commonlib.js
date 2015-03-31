/******** Default Accept Image Upload Support Type ***/
var fileExtension = ['pdf','png','jpeg','jpg'];

/******* Default Image Upload file Size******/
var defaultFileSize = 2048000; /***2MB***/

$('document').ready(function(){
		
    
	/****Check User is login or not ********/
	
		
		$.ajax({
				
			type: "POST",
				
			url: GLOBLA_PATH+'inspectors/checkUserAccess'
		
		}).done(function( data ) {
			
			
			if (  $.trim(data) != $.trim(USER_ACCESS) ) {
				
				window.location.reload();
		
			}	
			
		});		
	
	
     /*************Default Functionality use in auto remove class after 10 sec ****/
		
    setTimeout( function() { 
		      	
		$('#flashMessage').fadeOut("slow").delay(5000).remove();
	
    }, 5000); 
		
		
});

function hide(div) {
		
    document.getElementById(div).style.display = 'none';
}