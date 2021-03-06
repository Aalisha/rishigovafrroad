var obj = $('#MemberEditCompanyForm');


/**
*
* 
*
*/

$(function() {
	
    $(obj).validate();	
	
	/*$("input[name*='vc_business_reg']").rules(
            "add", {
        required: true,
        maxlength: 50,
        messages: {
            required: 'Please enter business reg.',
            maxlength: 'Should be less than 50 characters'
        }
    });
	*/
	$("input[name*='vc_business_reg']").rules(
        "add", {
         required: { 
		           depends:function(element) {
		
						if($("#vc_cust_type").val()!='CUSTYPE01'){

							return false;
						}
						return true;
					}
		},
        maxlength: 50,
        remote: {
            url: GLOBLA_PATH+"profiles/checkbusinessregIDCompany",
            type: "POST",
			data : {					
				id : function(){
					return $.trim($('#CompanyNuCompanyId').val());
				}
			}
        },
        messages: {
                        required: 'Please enter business reg.',
						maxlength: 'Should be less than 50 characters',
						remote: 'Business reg no. already in use,try another'
        }
    });
	
	$("input[name*='vc_business_reg_doc']").rules(
      
	  "add", {        
        accept: true,
		filesize : true,
		required : {
			depends: function(element) {
			// alert($("#vc_cust_type").val());
			// alert($("#profilestatusid").val());
			// console.log($("#profilestatusid").val());
			// console.log($('#chbusinesstype').val());
			
			 if($.trim($("#profilestatusid").val())== 'STSTY05' && $('#chbusinesstype').val()=='Y' ){

				return false;
			 }
			 if($.trim($("#profilestatusid").val())== 'STSTY05' && $('#chbusinesstype').val()!='Y' && $("#vc_cust_type").val()!='CUSTYPE01'){

				return false;
			 }
			 
			 
			 if($("#vc_cust_type").val()!='CUSTYPE01' && $.trim($("#profilestatusid").val())!= 'STSTY05'){

				return false;
			 }

			return true;	
						
			 }
			},
				
        messages: {
           
        }
    });

	
	$("select[name*='vc_cust_type']").rules(
            "add", {
        required: true,
        messages: {
            required: 'Please select customer type'
        }
    });
	
	$("input[name*='vc_company_name']").rules(
            "add", {
        required: true,
		maxlength: 100,
		remote: {
            url: GLOBLA_PATH+"profiles/checkcompanynameTable",
            type: "POST",
			data : {					
				id : function(){
					return $.trim($('#CompanyNuCompanyId').val());
				},
				
			}
        },
        messages: {
            required: 'Please enter company name',
			maxlength:	'Maximum 100 characters are allowed',
			remote: 'Company name already in use'

        }
    });
	
	$("#vc_bank_struct_code").rules(
	"add",	{		
		required: true,		
		messages: { 
		
			required	: 	'Please select bank'
		}
	});
	
	$("input[name*='vc_account_no']").rules(
            "add", {
        required: true,
        minlength: 8,
        maxlength: 20,
        alphanumeric: true,
        messages: {
            required: 'Please enter account no.',
            maxlength: 'Should be less than 20 characters',
            minlength: 'Minimum 8 characters required'
        }
    });
	
	$("input[name*='vc_address1']").rules(
            "add", {
        required: true,
        maxlength: 50,
        messages: {
            required: 'Please enter address',
            maxlength: 'Should be less than 50 characters'

        }
    });
	
	$("input[name*='vc_address2']").rules(
            "add", {
        maxlength: 50,
        messages: {
            maxlength: 'Should be less than 50 characters'
        }
    });

    $("input[name*='vc_address3']").rules(
            "add", {
        maxlength: 20,
	    postalCode: true,

        messages: {
            maxlength: 'Should be less than 20 characters'

        }
    });
	
	$("input[name*='vc_uploaded_doc_name']").rules(
            "add", {
        
        accept: true,
		filesize : true,
		required : {
					depends: function(element) {
					//alert($("#profilestatusid").val());

							if($.trim($("#profilestatusid").val())== 'STSTY05' ){

								return false;
							}

							return true;	
						
						}
					},
		
        messages: {
           
        }
    }); 
	
	$("input[name*='vc_municipal_doc_name']").rules(
            "add", {
        
        accept: true,
		filesize : true,
		});	

		$("input[name*='vc_mobile_no']").rules(
            "add", {
        required:true,
		mobileUS: true,
        maxlength: 15,
        minlength: 7,
        messages: {
            required:'Please enter mobile number',
            maxlength: 'Can not use more than 15 characters',
            minlength: 'Should not be less than  7 characters',
            mobileUS: 'Please enter a valid mobile number'
        }
    });

    $("input[name*='vc_tel_no']").rules(
            "add", {
        maxlength: 15,
        minlength: 7,
        phoneUS: true,
        messages: {
            maxlength: 'Can not use more than 15 characters',
            minlength: 'Should not be less than  7 characters',
            phoneUS: 'Please enter a valid phone number'
        }
    });

    $("input[name*='vc_fax_no']").rules(
            "add", {
        maxlength: 15,
        minlength: 7,
        faxUS: true,
        messages: {
            maxlength: 'Can not use more than 15 characters',
            minlength: 'Should not be less than  7 characters',
            faxUS: 'Please enter a valid fax number'
        }
    });
	
	$(obj).bind('submit', function(e) {
		  
		   if($(this).valid()) {
				
				if( $(this).find('input[type ="submit"]').length > 0 ) {
				 
					$(this).find('input[type ="submit"]').attr('disabled', 'disabled');    
				} 
				
				if( $(this).find('button[type ="submit"]').length > 0 ) {
				 
					$(this).find('button[type ="submit"]').attr('disabled', 'disabled');    
				}
				
				
				return true;
		   }
		   
		   return false;

	 });
	
	
});

function upload_hide(){
	 
	 if( $.trim($("#vc_bank_supportive_doc ").val())!= ''){
	 
		$('#vc_uploaded_doc_name').css('display','');
	 }
	 else{
	 
		$('#vc_uploaded_doc_name').css('display','none');
	 
	 }
}	 