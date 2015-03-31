var obj = $('#ProfileOwnershipchangeForm');

var commonPopupObj = $('#commonmessage');

$(obj).validate();
 
$(function(){
    
	
	objpop =$('#CustomerOwnerShipChangeForm')
	
	$(obj).find('input[type="radio"]').change(function(){
	
		ObjSelect = $(this);
		
		objValue = $(ObjSelect).val();
		
		document.getElementById("ProfileOwnershipchangeForm").reset();
		
		$(ObjSelect).prop('checked',true);
		
		
		if (  objValue == 'CUSTAMDTYP01' ) {
				
				$(obj).find('#vc_new_cust_no').parent().prev('td').find('label button').remove();
				
				$(obj).find('#vc_new_customer_name').parent().prev('td').find('label button').remove();
				
				$(obj).find('#vc_new_customer_name').removeAttr('readonly');
				
				$(obj).find('#vc_new_cust_no').removeAttr('readonly');
				
			//	$(obj).find('#vc_new_customer_name').off('click');
				
				//$(obj).find('#vc_new_cust_no').off('click');
				
			/*	$.ajax({
								
					type: "POST",

					url: GLOBLA_PATH+'vehicles/gettransferaddress',

					data: { data: $('#ProfileVcCustomerNo').val() }

				}).done(function( data ) {

					$(obj).find('#changeaddress').html(data);
					
				});		*/
		
		} else {
		
				$('#vc_new_customer_name').val('');
				$('#vc_new_cust_no').val('');

			/*	$(obj).find('#vc_new_cust_no').parent().prev('td').find('label').append('<button class="round5" style="float:right;margin-top:0px; width: 28px;" type="button">...</button> ');
				
				$(obj).find('#vc_new_customer_name').parent().prev('td').find('label').append('<button class="round5" style="float:right;margin-top:0px; width: 28px;" type="button">...</button> ');
				
				
				$(obj).find('#vc_new_customer_name').attr('readonly','readonly');
				
				$(obj).find('#vc_new_cust_no').attr('readonly','readonly');
				
				$(obj).find('#vc_new_cust_no').on('click', function(){
					
					$('#CustomerOwnerShipChangeForm').css('display','block');
				
				});
				
				$(obj).find('#vc_new_cust_no').parent().prev('td').find('label button').click(function(){
				
					$(obj).find('#vc_new_cust_no').trigger('click');
				});
				
				
				$(obj).find('#vc_new_customer_name').parent().prev('td').find('label button').click(function(){
					$(obj).find('#vc_new_customer_name').trigger('click');
				});
				
							
				$(obj).find('#vc_new_customer_name').on('click', function(){
					$('#CustomerOwnerShipChangeForm').css('display','block');
				
				});*/
		
		}

	});
	
	
	
	$(objpop).find('#search').keyup(function(){
   
			$.ajax({
								
				type: "POST",

					url: GLOBLA_PATH+'vehicles/getCustomerTransferDetail',

					data: { data: $(this).val() }

				}).done(function( data ) {

						$(objpop).find('#data').html(data);
					
				});		
	});
	
	
	$(objpop).find('button').click( function(){
	    
		
			data = $(objpop).find('#search').val();
		
			$.ajax({
								
				type: "POST",

					url: GLOBLA_PATH+'vehicles/getCustomerTransferDetail',

					data: { data: data }

				}).done(function( data ) {

						$(objpop).find('#data').html(data);
					
				});		

	});
	
	$(objpop).delegate("#data table tr",'click',function(){

		radioobj = $(this).find('input[type=radio]');

		$(radioobj).prop('checked', true);
		
		$(obj).find('#vc_new_customer_name').val($(this).find('td').eq(1).html());

		$(obj).find('#vc_new_cust_no').val($(this).find('td').eq(2).html());
		
				$.ajax({
								
					type: "POST",

					url: GLOBLA_PATH+'vehicles/gettransferaddress',

					data: { data: $(this).find('td').eq(2).html() }

				}).done(function( data ) {

					$(obj).find('#changeaddress').html(data);
					
				});		
		
		
		$(objpop).css('display','none');		

	});
	
	
	$(obj).find("input[name *=vc_new_customer_name]").each(function(){

		$(this).rules("add",{

				required 	: true,
				maxlength	: 100,
				messages : {

					required	: 	'Required',
					maxlength	: 	'Maximum accept 100 character'
				
				}});
	});
	
	
	$(obj).find("input[name *=vc_new_cust_no]").each(function(){

		$(this).rules("add",{

				required 	: {
				depends:function(){
				
				 if($("#vc_cust_type").val()!='CUSTYPE01'){

						return false;
					}
					return true;

				}
				
				},
				maxlength	: 30,
				messages : {

					required	: 	'Required',
					maxlength	: 	'Maximum accept 30 character'
				
				}});
	});
	
		
	 $(obj).find("input[name *=vc_uploaded_doc_name]").each(function(){

		$(this).rules("add",{

				
				filesize: true,
				
				accept	: true,
							
				messages : {

					
					
				
				}});
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