var objDate = new Date();

var commonPopupObj = $('#commonmessage');

var obj = $('#ProfileEditlogdetailForm');

$(obj).validate();

$(".addlog").datepicker({
    maxDate: "-1D",
    defaultDate: "+1w",
    changeMonth: true,
    changeYear: true,
    dateFormat: 'd M yy'


});

/**** Main Validation ***********/

/***Validation For Date******/

$(obj).find("input[name *=dt_log_date]").each(function() {

    $(this).rules("add", {
        required: true,
        maxlength: 12,
        date: true,
        messages: {
            required: 'Required',
            date: 'Should be format',
            maxlength: 'Maximum accept 12 character'

        }});



});

/***Validation For vc_driver_name******/

$(obj).find("input[name *=vc_driver_name]").each(function() {

    $(this).rules("add", {
        required: true,
        alphabetic: true,
        maxlength: 50,
        messages: {
            required: 'Required',
            alphabetic: 'only character',
            maxlength: 'Maximum accept 50 character'


        }});



});


/***Validation For nu_start_ometer ******/

$(obj).find("input[name *=nu_start_ometer]").each(function() {

    $(this).rules("add", {
        required: true,
        positiveNumber: true,
        maxlength: 15,
        messages: {
            required: 'Required',
            positiveNumber: 'only number',
            maxlength: 'Maximum accept 6 character'


        }});



});


/***Validation For nu_end_ometer******/

$(obj).find("input[name *=nu_end_ometer]").each(function() {


    $(this).rules("add", {
        required: true,
        positiveNumber: true,
        maxlength: 15,
        messages: {
            required: 'Required',
            positiveNumber: 'only number',
            maxlength: 'Maximum accept 6 character'


        }});


});


/***Validation For vc_orign******/

$(obj).find("input[name *=vc_orign]").each(function() {

    $(this).rules("add", {
        required: true,
        alphanumericSpace: true,
        maxlength: 50,
        messages: {
            required: 'Required',
            alphanumericSpace: 'Accept only<br/>alphanumeric',
            maxlength: 'Maximum accept 50 character'


        }});



});



/***Validation For vc_destination******/



$(obj).find("input[name *=vc_destination]").each(function() {


    $(this).rules("add", {
        required: true,
        alphanumericSpace: true,
        maxlength: 50,
        messages: {
            required: 'Required',
            alphanumericSpace: 'Accept only<br/>alphanumeric',
            maxlength: 'Maximum accept 50 character'


        }});


});

/***Validation For nu_km_traveled******/

$(obj).find("input[name *=nu_km_traveled]").each(function() {


    $(this).rules("add", {
        required: true,
        positiveNumber: true,
        maxlength: 15,
        messages: {
            required: 'Required',
            positiveNumber: 'only number',
            maxlength: 'Maximum accept 6 character'


        }});


});

/***Validation For nu_other_road_km_traveled******/

$(obj).find("input[name *=nu_other_road_km_traveled]").each(function() {


    $(this).rules("add", {
        required: true,
        positiveNumber: true,
        lessThanEqualTo: true,
        maxlength: 15,
        messages: {
            required: 'Required',
            positiveNumber: 'only number',
            maxlength: 'Maximum accept 15 characters',
            lessThanEqualTo: 'Should be <br/>less than <br/> km travled on namibian <br/>road'


        }
    });


});



/******End*********************/


$(obj).delegate('[name*="nu_end_ometer"]', "change", function() {

    parentObj = $(this);

    endvalue = parseInt($(parentObj).val());

    startValue = parseInt($(parentObj).parent().parent().find('[name*="nu_start_omete"]').val());

    if (endvalue > startValue) {

        $(parentObj).parent().parent().find('[name*="nu_km_traveled"]').val(parseInt(endvalue - startValue) + 1);

    } else {

        $(parentObj).val();

        $(parentObj).parent().parent().find('[name*="nu_km_traveled"]').val('');

        $(commonPopupObj).find('#messageshow').html('Enter Odometer reading value shoud be greater than Start value');

        $(this).val('');

        $(commonPopupObj).css('display', 'block');

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
				
				$(this).find('button[type ="button"]').attr('disabled', 'disabled');
				
				return true;
		   }
		   
		   return false;

	 });	