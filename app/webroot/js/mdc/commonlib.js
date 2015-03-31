/******** Default Accept Image Upload Support Type ***/
/******** Default Accept Image Upload Support Type ***/
var fileExtension = ['pdf','png','jpeg','jpg'];

/******* Default Image Upload file Size******/
var defaultFileSize = 2048000; /***2MB***/

$('document').ready(function(){
	
	
	/*******Avoid Dbclick*************/
	
    $("form input.submit").bind("dblclick", function(e){
		e.preventDefault();
		return false;
	});
	/************End*************/

	       
        /****Check User is login or not ********/
	
		
		$.ajax({
				
			type: "POST",
				
			url: GLOBLA_PATH+'members/checkUserAccess'
		
		}).done(function( data ) {
			
			if (  $.trim(data) === 'yes' ||  $.trim(data) === 'no' ) {
				
				if (  $.trim(data) !== $.trim(USER_ACCESS) ) {
			
					window.location.reload();

				}	
		
			} 
			
			
			
		});		
	
	
    /*****Default Date Picker***********/
		
    $(".dateseclect").datepicker();
   
    
		
    /******* End ***********/


    /*************Default Functionality use in auto remove class after 10 sec ****/
		
    setTimeout( function() { 
		      	
		$('#flashMessage').fadeOut("slow").delay(12000).remove();
	
    }, 12000); 
	
	setTimeout( function() {     
		
		$('.success-message').fadeOut("slow").delay(12000).remove();
		$('.info-message').fadeOut("slow").delay(12000).remove();
		$('.error-common').fadeOut("slow").delay(12000).remove();

	}, 12000);

			
});

function changeownnerShip(type) {

    var fieldValue = type;
		
    if(fieldValue === 2)
    {
        $("table.changeaddress").show();
        $("table.changeaddress").find("input,button,textarea").removeAttr("disabled");
    }
    else if(fieldValue === 1)
    {
        $("table.changeaddress").find("input,button,textarea").attr("disabled", "disabled");
        $("table.changeaddress").hide();
    }
}
	
	// for company onchange on each page
function formsubmit(ID){
	//alert(ID);
	$('#'+ID).submit();
}		

function hidepop(div) {
		
    var addobject = $('#'+div);
	
    document.getElementById(div).style.display = 'none';
					
	
}

	/********This Function is used For Vehicle Multiple File Upload*******/
	
function uploaddocs(div, row){
	
	var addobject = $('#'+div);
	
	var ActivefileObj = $(addobject).find(".fileupload-block");
	
	countUploadedFile =  $(ActivefileObj).length;
	
	if( countUploadedFile == 0 ) {
	
		add_fields('uploadDocsvehicle'+row, row);
	
	}
	
	document.getElementById(div).style.display = 'block';
		
}

/********This Function is used For Vehicle Multiple File Upload*******/


/**
*
*
*/

function createUniqueId( row, count ){ 
			
	count = parseInt(count) == NaN ? 0 : parseInt(count);
	
	if( $('#DocumentUploadVehicle'+row+count+'vc_uploaded_doc_name').length == 0  ) {
	
		return  count;
	
	}

	return createUniqueId(row,count+1);

}


	
function add_fields(parentObject, rowNumber){
	    
    var defaultSet = 1;
		
    var addobject =  $('#'+parentObject).find('.upload-button');
		
    var row = rowNumber;
	
	var countRow = createUniqueId( row , $(addobject).find('.row'+row).length );
	
	var empty = false;

	$(addobject).find('.row'+rowNumber).each(function(){
	
		if( $(this).find('.qq-upload-list .qq-upload-file').length == 0) {
		
			empty = true;
		
		}
	
	
	});
   	
	if(  !empty ) {

		$.ajax({
			type: "POST",
			url: GLOBLA_PATH+'vehicles/addfileupload',
			data: {
				countRow: countRow, 
				row: row
			},
			beforeSend : function (){
				
				$('#uploadDocsvehicle'+row+' .close').hide();
				
				$('.button-addmore').hide();
				
				$(addobject).append("<div id='loading' style='text-align:center;' ><img width='30px' src='"+GLOBLA_PATH+"img/loading.gif' > </img> </div>");	
			},
			success : function (data) {					
				
				if( data !== '' ){
				
					$(addobject).find('#loading').remove();
								
					$(addobject).append(data);
						
					
					/****This Function Mention in vehicles.js file ***/
					
					createUploader("DocumentUploadVehicle"+row+countRow+"vc_uploaded_doc_name", row , countRow);
					
				}
			},
			error : function (xhr, textStatus, errorThrown) {
					$('#uploadDocsvehicle'+row+' .close').show();		
			},
			complete : function (){
					$('#uploadDocsvehicle'+row+' .close').show();
					$('.button-addmore').show();	
			}
		});

	} else {

		$(commonPopupObj).find('#messagetitle').html('Alert Message .');

		$(commonPopupObj).find('#messageshow').html('Please upload firstly ');

		$(commonPopupObj).css('display','block');


	}	
}
	
function pop(div) {
		
    document.getElementById(div).style.display = 'block';
}
	
function hide(div) {
		
    document.getElementById(div).style.display = 'none';
}	