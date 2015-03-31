    var obj = $('#ReportAssessmenthistoryForm');
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
            date		:	'Must be valid date format ',
            maxlength	        : 	'Maximum accept 12 character'

        }
    });
									
    $('#toDate').rules("add",{

        maxlength	: 12,
        date		: true,
        messages : {
            date		:	'Must be valid date format',
            maxlength           : 	'Maximum accept 12 character'
        }
    });
	
	$(popObj).delegate("input[name *='search']", 'keyup', function() {
		
		selectVal = $(this).val();
		//alert(selectVal);

		$.ajax({
		type: "POST",
		url: GLOBLA_PATH + 'reports/getcustomerdetailbysearch',
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
            url: GLOBLA_PATH + 'reports/getcustomerdetailbysearch',
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
