$(document).ready(function(){
	$( "body" ).delegate( "a", "click", function() {		
		
		$('.mainbody').html("<div class='admin-loading'> <img src='"+GLOBLA_PATH+"img/admin-loading.jpg' ></div>");
		
	});
});

