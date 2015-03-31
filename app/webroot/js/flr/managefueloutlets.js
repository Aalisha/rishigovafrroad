  var obj = $('#ClientFlrManagefueloutletsForm');

$(function() {
  
    var commonPopupObj = $('#commonmessage');

    var backproceesingPopupObj = $('#backproceesing');

    $(obj).validate();


    function ApplyValidateOutlets() {

        $.validator.addMethod('uniqueCheck', function(value, element) {

            index = $(obj).find("select[name*='fueloutlets']").index(element);
            erro = true;

            $(obj).find("select[name*='fueloutlets']").each(function() {

                current = $(obj).find("select[name*='fueloutlets']").index(this);

                if ($.trim(value) == $(this).val() && index != current) {

                    erro = false;

                    return false;
                    ;
                }

            });

            return  erro;

        }, function(value, element) {
            $(element).val('');
            return "Already selected";
        });

        $(obj).find("select[name*='fueloutlets']").each(function() {

            $(this).rules(
                    "add", {
                required: true,
                uniqueCheck: true,
                messages: {
                    required: "Please select fuel outlet "

                }
            });

        });

    }

    ApplyValidateOutlets();



    $(obj).delegate('#add img', 'click', function() {

        var max = 15;

        var callObj = $(this);

        var parentObj = $(obj).find("select[name *='data[ClientFuelOutlet][fueloutlets]']");

        var outlestLenght = parentObj.length;

        var emptyValue = false;

        if (max >= outlestLenght) {

            var addStr = [];

            $(parentObj).each(function(k, v) {

                if ($.trim($(this).val()) == '') {

                    emptyValue = true;

                    return false;

                }
                if ($.trim($(this).val()) !== '') {

                    addStr[k] = $(this).val();

                }

            });

            if (emptyValue) {

                $(commonPopupObj).find('#messagetitle').html('');

                $(commonPopupObj).find('#messageshow').html(' Don\'t Leave Blank before adding a new row');

                $(commonPopupObj).css('display', 'block');

                return false;

            }

            $.ajax({
                type: "POST",
                url: GLOBLA_PATH + 'flr/clients/getselectedoutletsdropdown',
                data: {
                    data: addStr
                },
                beforeSend: function() {
                    $(backproceesingPopupObj).css('display', 'block');
                },
                success: function(response) {
                    if ($(callObj).closest('tr').next('tr').length == 0) {
                        $(callObj).closest('tr').after('<tr><td width="75%" align="left" valign="top">&nbsp;</td><td width="25%" align="left" valign="top">&nbsp;</td></tr>');
                    }
                    var selectTr = $(callObj).closest('tr').next('tr');
                    var index = runtimeIndex(parentObj, '');
                    selectTr.find('td:first').html("<div class='outletslist'><select class='round_select5' name='data[ClientFuelOutlet][fueloutlets][" + index + "]'>" + response + "</select></div>");
                    selectTr.find('td:last').html($(callObj).closest('tr').find('.button-addmore').clone());

                    $(callObj).closest('tr').find('.button-addmore #add').remove();

                    ApplyValidateOutlets();

                },
                error: function(xhr, textStatus, errorThrown) {

                    $(backproceesingPopupObj).css('display', 'none');

                    $(commonPopupObj).find('#messagetitle').html('');

                    $(commonPopupObj).find('#messageshow').html('Internet related error has been come please try again! ');

                    $(commonPopupObj).css('display', 'block');

                },
                complete: function() {

                    $(commonPopupObj).css('display', 'none');

                    $(backproceesingPopupObj).css('display', 'none');
                }

            });

        }

    });


    $(obj).delegate('#remove img', 'click', function() {

        var min = 1;

        var callObj = $(this);

        var outlestLenght = $(obj).find("select[name*='data[ClientFuelOutlet][fueloutlets]']").length;

        var popmessage = $.trim($(this).closest('tr').find("select[name*='data[ClientFuelOutlet][fueloutlets]']").val());

        var message = popmessage != '' ? popmessage : 'this fuel outlet';

        widthdialog = 400 + parseInt(message.length);

        var confirmObj = $('<p> Are you sure, you want to remove ' + message + '.  </p>')

        if (outlestLenght > min) {
            $(function() {
                $(confirmObj).dialog({
                    resizable: false,
                    height: 160,
                    width: widthdialog,
                    modal: true,
                    buttons: {
                        "ok": function() {

                            if ($(callObj).closest('tr').find('#add').length > 0) {

                                $(callObj).closest('tr').prev('tr').find('td:last').html($(callObj).closest('tr').find('.button-addmore').clone());

                            }

                            $(callObj).closest('tr').remove();

                            $(this).dialog("close");
                        },
                        Cancel: function() {
                            $(this).dialog("close");
                        }
                    }
                });
            });

        }

    });

    function runtimeIndex(obj, number) {

        ObjLength = number != '' ? number : $(obj).length;

        if ($(obj).find('[' + ObjLength + ']').length == 0) {

            return ObjLength;

        }

        number = Math.floor(Math.random() * 30) + 1;

        runtimeIndex(obj, number);

    }
});
$('form').bind('submit', function(e) {
		if($(obj).valid()==true){
			$('.submit').attr('disabled', 'disabled');    
			return true;
			}

	});