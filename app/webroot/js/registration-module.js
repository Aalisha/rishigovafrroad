/********* Below functionality will use for registration module ***********/

$('document').ready(function(){
    
	
	var obj = $('#MemberRegistrationForm');
	
	$('#reset').click( function(){
	
		var url = GLOBLA_PATH+"members/captcha_image?"+ Math.round(Math.random(0)*1000)+1;
		
		$('#captcha').attr('src', url);
		
	
	});
	
	$(obj).validate();

		$("#email").rules(
			"add",	{
			required: true,
			email: true,
			maxlength: 50,
			messages: { 
				required	: 	'Please enter Email',
				maxlength	:	'Maximum 50 characters only'
				}
		});
		
		$("#first_name").rules(
			"add",	{
				required: {depends:function (){//alert(element);
                     if($("#MemberWholesalerSupplier").is(':checked'))
                     {
                         //alert('checked');
                         return false;
                          
                     }
                     else
                     {  //alert('unchecked');
                         return true;
                     }  
                  } } ,
				maxlength: 50,
				messages: { 
					required	: 	'Please enter first name',
					maxlength	:	'Maximum 50 characters only'
					}
		});
		
		
		$("#last_name").rules(
			"add",	{
				required:{ depends:function () {//alert(element);
                     if($("#MemberWholesalerSupplier").is(':checked'))
                     {
                         
                         return false;
                          
                     }
                     else
                     {
                         return true;
                     }  
                  } } ,
				maxlength: 50,
				messages: { 
					required	: 	'Please enter last name',
					maxlength	:	'Maximum 50 characters only'
					}
		});	
		$("#all_name_supplier").rules(
			"add",	{
				required:{depends: function () {
                     if($("#MemberWholesalerSupplier").is(':checked'))
                     {
                         
                         return true;
                          
                     }
                     else
                     {
                         return false;
                     }  
                  } } ,
				maxlength: 100,
				messages: { 
					required	: 	'Please enter wholesaler name',
					maxlength	:	'Maximum 100 characters only'
					}
		});
			/*
	
					
		
		*/
		/**/
	  
	  /*
	  $('#MemberWholesalerSupplier').change(function() {

		if ($('#MemberWholesalerSupplier').is(':checked')) {
		alert('hua');
		 $("#all_name_supplier").rules(
			"add",	{
				required: true,
				maxlength: 50,
				messages: { 
					required	: 	'Please enter first name',
					maxlength	:	'Maximum 50 characters only'
					}
		});

		
		
		}else{
		
		 $("#first_name").rules(
			"add",	{
				required: true,
				maxlength: 50,
				messages: { 
					required	: 	'Please enter first name',
					maxlength	:	'Maximum 50 characters only'
					}
		});

		$("#last_name").rules(
			"add",	{
				required: true,
				maxlength: 50,
				messages: { 
					required	: 	'Please enter last name',
					maxlength	:	'Maximum 50 characters only'
					}
		});
  
			}

		 });
		*/
	
	
    $('#vc_comp_code').rules("add",	{required: true,messages: { 
				required	: 	'Please select type'}});	
			
	$("#vc_captcha_code").rules(
		"add",	{
			required: true,
			minlength: 6,
			maxlength: 6,
			messages: { 
				required	: 	'Please enter code',
				minlength	: 	'Minimum 6 characters',
				maxlength	:	'Maximum 6 characters only'
				}
		});
     
     
    
   var compCode = $(obj).find("select[name*='vc_comp_code']").val();
 
    if(compCode == 'cm3') {
         $("#wholesaler").show();
    }
 
 
    $(obj).delegate("select[name*='vc_comp_code']",'change',function(){
       var  compCode = $(this).val();
        if(compCode == 'cm3') {
            $("#wholesaler").show();
        }
        else 
        {
            $("#wholesaler").hide();
        }
        
    });


$('#MemberWholesalerSupplier').change(function() {
  
  if ($(this).is(':checked')) {
  
	  $('#row_first_id').hide();
	  $('#row_last_id').hide();
	  $('#first_name').val(' ');
	  $('#last_name').val(' ');
	  $('#row_last_id').hide();
	  $('#row_allname_id').show();
	  
  } else {
  
	  $('#row_first_id').show();
	  $('#row_last_id').show();
	  $('#row_allname_id').hide();
	  $('#all_name_supplier').val(' ');
  }
});	
   	
	
});	

