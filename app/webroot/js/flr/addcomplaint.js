var obj = $('#CustomerFlrAddcomplaintForm');
$(obj).validate();
$(function() {
    
    $("select[name*='complaint_type']").rules(
            "add", {
        required:true,
           messages: {
               required:'Please select complaint type'
           }
    });
    
    $("select[name*='priority_type']").rules(
            "add", {
        required:true,
           messages:{
               required: 'Please select complaint priority'
           }
    });
    
 
  $("input[name*='logged_by']").rules(
            "add", {
          required:true,
          /*alphabetic : true,*/
          messages:{
              required:'Please enter name'
          }
    });
    
    
    $("input[name*='contact_no']").rules("add",{
            maxlength: 15,
            minlength: 7,
            required:true,
            phoneUS: true,
        messages: {
            maxlength: 'Can not use more than 15 characters',
            minlength: 'Should not be less than  7 characters',
            required:'Please enter contact number',
            phoneUS: 'Please enter a valid phone number'
            
        }
    });
    
    $("textarea[name*='complaint_description']").rules("add", {
            required:true,
            messages:{
                required:'Please enter complaint description'
            }
    });
    
    $("input[name*='[complaint_doc]']").rules(
            "add", {
        accept: true,
        filesize: true
       
    });

});

$(obj).bind('submit', function(e) {

    if ($(this).valid()) {

        if ($(this).find('input[type ="submit"]').length > 0) {

            $(this).find('input[type ="submit"]').attr('disabled', 'disabled');
        }

        if ($(this).find('button[type ="submit"]').length > 0) {

            $(this).find('button[type ="submit"]').attr('disabled', 'disabled');
        }

        return true;
    }
    return false;
});
