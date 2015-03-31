$(function() {

    
    var commonPopupObj = $('#commonmessage');
    
	var backproceesingPopupObj = $('#backproceesing');
	
	var logpopupObj = $('#logpopup');

    $('.listsr1').delegate(".showlog", 'click', function() {
        selectedRow = $(this).parent().parent();
        licenseno = $(selectedRow).find('label[for="vc_vehicle_lic_no"]').text();

        regisatrationno = $(selectedRow).find('label[for="vc_vehicle_reg_no"]').text();

        fromDate = $('#vc_pay_month_from').val() + ' ' + $('#vc_pay_year_from').val();

        toDate = $('#vc_pay_month_to').val() + ' ' + $('#vc_pay_year_to').val();

        if (licenseno !== '' && regisatrationno !== '' && fromDate !== '' && toDate !== '') {
			
				
			$(backproceesingPopupObj).css('display','block'); 
			
            $.ajax({
                type: "POST",
                url: GLOBLA_PATH + 'vehicles/getvehiclelogdetails',
                data: {
                    licenseno: licenseno,
                    regisatrationno: regisatrationno,
                    toDate: toDate,
                    fromDate: fromDate,
                    assessment: true,
                    assessmentno: $.trim($('#assessment_no').val())
                }

            }).done(function(data) {
                $(logpopupObj).find('#showlogdata').html(data);
				$(backproceesingPopupObj).css('display','none');
                $(logpopupObj).css('display', 'block');

            });

        } else {

            $(commonPopupObj).find('#messageshow').html('Some Error has occured please try again ');
            $(commonPopupObj).css('display', 'block');

        }

    });
	
	/*$(obj).bind('submit', function(e) {
		  
		   if($(this).valid()) {
				
				if( $(this).find('input[type ="submit"]').length > 0 ) {
				 
					$(this).find('input[type ="submit"]').attr('disabled', 'disabled');    
				} 
				
				if( $(this).find('button[type ="submit"]').length > 0 ) {
				 
					$(this).find('button[type ="submit"]').attr('disabled', 'disabled');    
				}
				
				$(this).find('button[type ="button"]').attr('disabled', 'disabled');
				
				return true;
		   }
		   
		   return false;

	 });	
*/
}); 