
   var obj = $('#InspectorLogsheetForm');
	var popObj = $('#popDiv3');

   
$(function() {
   
    $('#fromDate').datepicker({
		 
        maxDate: "0 D",
		 
        defaultDate: "+1w",
		 
        changeMonth: true,
		 
        changeYear: true,
		 
        dateFormat: 'd M yy',
		 
        onClose: function( selectedDate ) {
			
			$( "#toDate" ).datepicker( "option", "minDate", selectedDate );
		
		}
    });
	
    $('#toDate').datepicker({
	
        maxDate: "0 D",
		 
        defaultDate: "+1w",
		 
        changeMonth: true,
		 
        changeYear: true,
		 
        dateFormat: 'd M yy',
		
		onClose: function( selectedDate ) {
		
			$( "#fromDate" ).datepicker( "option", "maxDate", selectedDate );
		
		}   
    });
   
   $(obj).validate();
   
	$('#fromDate').rules("add",{
		maxlength	: 12,
		date		: true,
		messages : {
			date		:	'Should be format',
			maxlength	: 	'Maximum accept 12 character'

	}});
									
	$('#toDate').rules("add",{

		maxlength	: 12,
		date		: true,
		messages : {
			date		:	'Should be format',
			maxlength	: 	'Maximum accept 12 character'
		}});
		
	$('#vc_customer_name').rules("add",{
			
			alphabetic	: true,
			maxlength	: 100,
			messages : {
				alphabetic	:	'only character',
				maxlength	: 	'Maximum accept 100 character'
		}});

	$(popObj).delegate("input[name *='search']", 'keyup', function() {
		
		selectVal = $(this).val();
		//alert(selectVal);

		$.ajax({
		type: "POST",
		url: GLOBLA_PATH + 'inspectors/getcustomerdetailbysearchreport',
		data: {
		data: selectVal

		}

		}).done(function(data) {
	//	alert(data);
		$(popObj).find('#ajaxshow').html(data);

		});
		
	});
	
	$(obj).delegate("#addshow", 'click', function() {
      
    	  $(popObj).css('display', 'block');

        selectVal = $(this).prev("input[name *='search']").val();

        $.ajax({
            type: "POST",
            url: GLOBLA_PATH + 'inspectors/getcustomerdetailbysearchreport',
            data: {
                data: selectVal

            }

        }).done(function(data) {

            $(popObj).find('#ajaxshow').html(data);

        });

    });
	
   $(popObj).delegate("input[type *='radio']", 'click', function() {
		value = $(this).val();
		selectObj = $(this);	
		//alert(value);
		//alert(value);
		$('#vehiclelicnoid').val(value);
		$(popObj).css('display', 'none');
		});
   
    $(popObj).delegate(".close", 'click', function() {

        $(popObj).find("input[name *='search']").val('');

        $(popObj).find("input[type *='button']").trigger('click');

        $(popObj).css('display', 'none');

    });		
	
});