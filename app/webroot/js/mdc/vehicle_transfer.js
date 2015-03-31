var obj = $('#VehicleTransferForm');

var commonPopupObj = $('#commonmessage');

 $(obj).validate();

$(function(){
	
   	$('#VehicleTransferFormSearchPop #search').keyup(function(){
	   
		if( $(this).val() != '' ) {

			$.ajax({
								
				type: "POST",

					url: GLOBLA_PATH+'vehicles/getVehicleTransferDetail',

					data: { data: $(this).val() }

				}).done(function( data ) {

						$('#VehicleTransferFormSearchPop').find('#data').html(data);
					
				});		

	
			}	
	
	});
	
	
	$('#VehicleTransferFormSearchPop button').click( function(){
	    
		
			data = $('#VehicleTransferFormSearchPop #search').val();
		
			$.ajax({
								
				type: "POST",

					url: GLOBLA_PATH+'vehicles/getVehicleTransferDetail',

					data: { data: data }

				}).done(function( data ) {

						$('#VehicleTransferFormSearchPop').find('#data').html(data);
					
				});		

	});
	
	
	$('#VehicleTransferFormCustomerSearchPop #search').keyup(function(){
	 // alert('hua');
			$.ajax({
								
				type: "POST",

					url: GLOBLA_PATH+'vehicles/getCustomerTransferDetail',

					data: { data: $(this).val() }

				}).done(function( data ) {

						$('#VehicleTransferFormCustomerSearchPop').find('#data').html(data);
					
				});		

	
	});
	
	$('#VehicleTransferFormCustomerSearchPop button').click( function(){
	    
		
			data = $('#VehicleTransferFormCustomerSearchPop #search').val();
		
			$.ajax({
								
				type: "POST",

					url: GLOBLA_PATH+'vehicles/getCustomerTransferDetail',

					data: { data: data }

				}).done(function( data ) {

						$('#VehicleTransferFormCustomerSearchPop').find('#data').html(data);
					
				});		

	});
	
	
	$("#VehicleTransferFormSearchPop").delegate("#data table tr",'click',function(){
	
		obj = $(this).find('input[type=radio]');
		
		$(obj).prop('checked', true);
				
		$('#VehicleTransferForm').find('#vc_vehicle_lic_no').val( $(this).find('td').eq(1).html() );
		
		$('#VehicleTransferForm').find('#vc_vehicle_reg_no').val( $(this).find('td').eq(2).html() );
			
		$('#VehicleTransferFormSearchPop').css('display','none');		
	
	});
	
	
	$("#VehicleTransferFormCustomerSearchPop").delegate("#data table tr",'click',function(){
			   
		obj = $(this).find('input[type=radio]');
		
		$(obj).prop('checked', true);
		
		$.ajax({
						
			type: "POST",

			url: GLOBLA_PATH+'vehicles/getTransferCustomerDetail',

			data: { data: $(obj).val() }

		}).done(function( data ) {

				$('#VehicleTransferForm #transfercustomer').html(data);
				
				$('#VehicleTransferFormCustomerSearchPop').css('display','none');	
			
		});	
		
	});

	
	
	/**
	 *
	 * Complete Validation  For Vehicle Add 
	 *
	 */

						
	$(obj).find("input[name *=vc_vehicle_]").each(function(){

		$(this).rules("add",{

			required 	: true,
			maxlength	: 15,
			messages : {

				required	: 	'Required',
				maxlength	: 	'Maximum accept 15 character'
			
			}});



	});


	$(obj).find("input[name *=to_vc_customer_name]").each(function(){

		$(this).rules("add",{

				required 	: true,
				maxlength	: 100,
				messages : {

					required	: 	'Required',
					maxlength	: 	'Maximum accept 100 character'
				
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