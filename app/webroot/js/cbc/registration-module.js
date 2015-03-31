/********* Below functionality will use for registration module ***********/

$('document').ready(function() {


    var obj = $('#MemberRegistrationForm');

    $('#reset').click(function() {

        var url = GLOBLA_PATH + "members/captcha_image?" + Math.round(Math.random(0) * 1000) + 1;

        $('#captcha').attr('src', url);


    });

    $(obj).validate();

    $("#email").rules(
            "add", {
        required: true,
        email: true,
        maxlength: 50,
        messages: {
            required: 'Please enter Email id',
            maxlength: 'Maximum 50 Character Only'
        }
    });

    $("#first_name").rules(
            "add", {
        required: true,
        maxlength: 50,
        alphabetic: true,
        messages: {
            required: 'Please enter first name',
            maxlength: 'Maximum 50 Character Only'
        }
    });

    $("#last_name").rules(
            "add", {
        required: true,
        alphabetic: true,
        maxlength: 50,
        messages: {
            required: 'Please enter Last name',
            maxlength: 'Maximum 50 Character Only'
        }
    });

    $('#vc_comp_code').rules("add", {required: true, messages: {
            required: 'Please select type'}});

    $("#vc_captcha_code").rules(
            "add", {
        required: true,
        maxlength: 6,
        messages: {
            required: 'Please enter Captcha',
            maxlength: 'Maximum 6 Character Only'
        }
    });

});	