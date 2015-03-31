var obj = $('#ClaimFlrEditForm');
var commonPopupObj = $('#commonmessage');
$(obj).validate();

var objDate = new Date();

$(function() {

$(obj).find("input[name *='dt_claim_from']").datepicker({
        maxDate: "0 D",
        defaultDate: "+1w",
        changeMonth: true,
        changeYear: true,
        dateFormat: 'd M yy',
        onClose: function(selectedDate) {
            $(obj).find("input[name *='dt_claim_to']").datepicker("option", "minDate", selectedDate);
            $(this).trigger('blur');
        }
    });

    $(obj).find("input[name *='dt_claim_to']").datepicker({
        maxDate: "0 D",
        defaultDate: "+1w",
        changeMonth: true,
        changeYear: true,
        dateFormat: 'd M yy',
        onClose: function(selectedDate) {

            $(obj).find("input[name *='dt_claim_from']").datepicker("option", "maxDate", selectedDate);
            $(this).trigger('blur');
        }
    });

    $(obj).find("input[name *='dt_claim_from']").each(function() {

        $(this).rules("add", {
            required: true,
            date: true,
            messages: {
                required: 'Required'
            }});
    });

    $(obj).find("input[name *='dt_claim_to']").each(function() {

        $(this).rules("add", {
            required: true,
            date: true,
            messages: {
                required: 'Required'
				}});
    });
	
	/*$(obj).validator.addMethod('numericOnly', function (value) { 
		return /[0-9 ]/.test(value); 
    }, 'Please only enter numeric values (0-9)');
	*/
	$(obj).find("input[name *='vc_party_claim_no']").each(function() {	
        $(this).rules("add", {            
			required: true,            
			maxlength: 20,	
			//numericOnly=true,
            number: true,			
			//onlyNumberWithoutFloat:false,
			 remote: {
                    url: GLOBLA_PATH + "flr/claims/getFormCheck/",
                    type: "post",
					 data: {

							VcClaimFormNo :function(){							
								return $('#ClaimDetail'+'VcClaimFormNo').val();							
							},
							ClaimHeaderVcClaimNo :function(){							
							return $('#ClaimHeaderVcClaimNo').val();										
							}
						}						
                }, 
            messages: {
				required: 'Required',
				maxlength	:	'Maximum 20 characters allowed',
				//alphanumeric:	'Alphanumeric only',
				remote:   'Already Used'
            }});
			
			});
			
   function setDatePicker() {

        var addobject = $(obj).find('.innerbody:eq(1)').find('table tbody');
        $(addobject).find("input[name*='dt_invoice_date']").datepicker({
           	
			dateFormat: 'dd M yy',
            defaultDate: "+1w",
            maxDate: "0 D",
            changeMonth: true,
            changeYear: true,
            numberOfMonths: 1,
            onSelect: function() {
			
                var noOfdays = 0;
				var invoicealreadycheck = true;

                var InvoiceDate = $(this).datepicker('getDate');
                var todaydate = new Date();
                noOfdays = Math.floor((todaydate.getTime() - InvoiceDate.getTime()) / 86400000); // ms per day
                var Rowid = parseInt($(this).attr('id').split("ClaimDetail")[1], 10);
                var ltrValue = parseFloat(0);
			
				if ($.trim($("#ClaimDetail" + Rowid + "NuLitres").val()) != null && !isNaN($.trim($("#ClaimDetail" + Rowid + "NuLitres").val())) && $.trim($("#ClaimDetail" + Rowid + "NuLitres").val()).length > 0)
								var ltrValue = parseFloat($("#ClaimDetail" + Rowid + "NuLitres").val());
                else
                    var ltrValue = parseFloat(0);			
			
				/**********Start For the invoice unique check*************/
				invoicealreadycheck = checkAjax(Rowid,ltrValue,InvoiceDate);
					
				/**********Start For the Rejection check cases *************/		
            

                var nu_refund_prcn = $("#ClaimDetail" + Rowid + "NuRefundPrcnt").val();
                var nu_admin_fee_prcnt = $("#ClaimDetail" + Rowid + "NuAdminFeePrcnt").val();
                var nu_refund_rate = $("#ClaimDetail" + Rowid + "NuRefundRate").val();

                if (ltrValue < 200 || noOfdays > 90 || invoicealreadycheck==false ) {

                    var admin_fee = 0;
                    var amount    = 0;

                    $("#ClaimDetail" + Rowid + "NuAdminFee").val(admin_fee).trigger('blur');

                    $("#ClaimDetail" + Rowid + "NuAmount").val(amount).trigger('blur');

                }
                else {

                    var admin_fee = parseFloat(nu_admin_fee_prcnt * ltrValue).toFixed(2);
                    var amount    = parseFloat(nu_refund_rate * ltrValue).toFixed(2);

                    $("#ClaimDetail" + Rowid + "NuAdminFee").val(admin_fee).trigger('blur');
                    $("#ClaimDetail" + Rowid + "NuAmount").val(amount).trigger('blur');

                }

				
                var totalMt = parseFloat(0);

                $(this).parent().parent().parent().find("input[name *='[nu_amount]']").each(function() {

                    if (Number($.trim($(this).val())) >= 0 && $.trim($(this).val()) != '' && $.trim($(this).val()) != null) {

                        var val = parseFloat($.trim($(this).val()));
                        totalMt = parseFloat(totalMt) + parseFloat(val);
                        
                    } else {

                        var val = parseFloat(0);
                        
                    }

                });

                totalMt = parseFloat(totalMt).toFixed(2);
                $('#showtotalamount_id').html(totalMt);
				
				//console.log(invoicealreadycheck+'=jam1=invoicealreadycheck=setdatepicer===1=='+noOfdays+'==ltrValue=='+ltrValue);
								
            },
            onClose: function() {
                $(this).trigger('blur');

            }
        });

    }
	
	
   function amountvalueAdmin(curentNuLitresvalue,noOfdays,litrescurrIndex,rejection){
				
				var nu_refund_prcn = $("#ClaimDetail" + litrescurrIndex + "NuRefundPrcnt").val();
                var nu_admin_fee_prcnt = $("#ClaimDetail" + litrescurrIndex + "NuAdminFeePrcnt").val();
                var nu_refund_rate = $("#ClaimDetail" + litrescurrIndex + "NuRefundRate").val();

					if(curentNuLitresvalue < 200 || noOfdays >90 || rejection==false)
					{
					var admin_fee = 0;
                    var amount    = 0;
					
				//	console.log(litrescurrIndex+'=jam2===litrescurrIndex=2=admin_fee=='+admin_fee+'=='+amount);
					
                    $("#ClaimDetail" + litrescurrIndex + "NuAdminFee").val(admin_fee).trigger('blur');
                    $("#ClaimDetail" + litrescurrIndex + "NuAmount").val(amount).trigger('blur');
					
					}else{
					
					var admin_fee = parseFloat(nu_admin_fee_prcnt * curentNuLitresvalue).toFixed(2);
                    var amount    = parseFloat(nu_refund_rate * curentNuLitresvalue).toFixed(2);
					//console.log(litrescurrIndex+'==jam3==litrescurrIndex=1=admin_fee=='+admin_fee+'=='+amount);

                    $("#ClaimDetail" + litrescurrIndex + "NuAdminFee").val(admin_fee).trigger('blur');
                    $("#ClaimDetail" + litrescurrIndex + "NuAmount").val(amount).trigger('blur');						

					}
}	
	
	
   function getUniqueInAll(value,element){
       //alert(value+','+element);
		var returnpass = true;
		var rejection  = true;
		if ($.trim(value) != '') {
				
				outletObj = $(element).parent().parent().parent().find("select[name*='vc_outlet_code']");					
				dateObj   = $(element).parent().parent().parent().find("input[name*='dt_invoice_date']");                
				Obj       = $(element).parent().parent().parent().find("input[name*='vc_invoice_no']");
				ObjLitres = $(element).parent().parent().parent().find("input[name*='nu_litres']");
				
                currIndex       = parseInt($(Obj).index(element));
                datecurrIndex   = parseInt($(dateObj).index(element));
                outletcurrIndex = parseInt($(outletObj).index(element));
				litrescurrIndex = parseInt($(ObjLitres).index(element));

				//start for litres//				
				//var litrescurrIndex=Rowid;				
				
				if(litrescurrIndex >= 0){
				 
				var curentdatevalue         = $('#ClaimDetail'+litrescurrIndex+'DtInvoiceDate').val();
				var curentVcInvoiceNovalue  = $('#ClaimDetail'+litrescurrIndex+'VcInvoiceNo').val();
			    var curentVcOutletCodevalue = $('#ClaimDetail'+litrescurrIndex+'VcOutletCode').val();
				var todaydate               = new Date();				
				
				if($('#ClaimDetail'+litrescurrIndex+'DtInvoiceDate').val()!=''){
				
                var curentdatevalueConvert = $('#ClaimDetail'+litrescurrIndex+'DtInvoiceDate').datepicker('getDate');
				noOfdays = Math.floor((todaydate.getTime() - curentdatevalueConvert.getTime()) / 86400000); // ms per day
				
				}else {
				 
				noOfdays = Math.floor(0);
				
				}
				
				if ($.trim($("#ClaimDetail" + litrescurrIndex + "NuLitres").val()) != null && !isNaN($.trim($("#ClaimDetail" + litrescurrIndex + "NuLitres").val())) && $.trim($("#ClaimDetail" + litrescurrIndex + "NuLitres").val()).length > 0)
				var curentNuLitresvalue = parseFloat($('#ClaimDetail'+litrescurrIndex+'NuLitres').val());
				else
				var curentNuLitresvalue = parseFloat(0);
				
				}
				//alert(litrescurrIndex);
				$(ObjLitres).each(function() {

		        runObjIndex                = parseInt($(ObjLitres).index(this));
				notcurentVcInvoiceNovalue  = $('#ClaimDetail'+runObjIndex+'VcInvoiceNo').val();
				notcurentdatevalue         = $('#ClaimDetail'+runObjIndex+'DtInvoiceDate').val();
				notcurentVcOutletCodevalue = $('#ClaimDetail'+runObjIndex+'VcOutletCode').val();    
								
				if (litrescurrIndex != runObjIndex) {
					//	alert('thival--'+$(this).val());	
                  if (($.trim(notcurentVcOutletCodevalue) == $.trim(curentVcOutletCodevalue))
					&& ($.trim(notcurentdatevalue)==$.trim(curentdatevalue))
					&& ($.trim(notcurentVcInvoiceNovalue)==$.trim(curentVcInvoiceNovalue)) && 
					$.trim(curentVcInvoiceNovalue)!='' && 
					$.trim(curentVcOutletCodevalue)!='' &&
					$.trim(curentdatevalue)!=''
					) {
					
					rejection=false;
					
                    $("#ch_rejected_td_"+litrescurrIndex).html('<img alt="" src="'+GLOBLA_PATH+'/img/with-check.jpg">');
					$('#ClaimDetail'+litrescurrIndex+'VcInvoiceNo').val('');
					$("#showreason_id_" + litrescurrIndex).hide();
					$("#ClaimDetail" +litrescurrIndex+ "VcReasonsDiv").html(' ');
					$(commonPopupObj).find('#messageshow').html('Invoice No. already exsist.');
					$(commonPopupObj).css('display', 'block');
				//	console.log(noOfdays+'=='+curentNuLitresvalue+'==jam5=getuniuqe=5=litrescurrIndex=='+litrescurrIndex);	
                    amountvalueAdmin(curentNuLitresvalue,noOfdays,litrescurrIndex,rejection);
                	
                    returnpass = false;

                    }else{
					
						//amountvalue(curentNuLitresvalue,noOfdays,litrescurrIndex);
					}
                    }	
				
				});
				
				//end for litres//
				
				
				if(outletcurrIndex>=0){
				 
				curentdatevalue = $('#ClaimDetail'+outletcurrIndex+'DtInvoiceDate').val();
				curentVcInvoiceNovalue = $('#ClaimDetail'+outletcurrIndex+'VcInvoiceNo').val();
			    curentVcOutletCodevalue = $('#ClaimDetail'+outletcurrIndex+'VcOutletCode').val();
				
				var todaydate = new Date();				
				
				if($('#ClaimDetail'+outletcurrIndex+'DtInvoiceDate').val()!=''){
				
                var curentdatevalueConvert = $('#ClaimDetail'+outletcurrIndex+'DtInvoiceDate').datepicker('getDate');
				noOfdays = Math.floor((todaydate.getTime() - curentdatevalueConvert.getTime()) / 86400000); // ms per day
				
				}
				
				if ($.trim($("#ClaimDetail" + outletcurrIndex + "NuLitres").val()) != null && !isNaN($.trim($("#ClaimDetail" + outletcurrIndex + "NuLitres").val())) && $.trim($("#ClaimDetail" + outletcurrIndex + "NuLitres").val()).length > 0)
				var curentNuLitresvalue = parseFloat($('#ClaimDetail'+outletcurrIndex+'NuLitres').val());
				else
				var curentNuLitresvalue = parseFloat(0);
				
				}
				
				$(outletObj).each(function() {

		        runObjIndex = parseInt($(outletObj).index(this));
				notcurentVcInvoiceNovalue = $('#ClaimDetail'+runObjIndex+'VcInvoiceNo').val();
				notcurentdatevalue = $('#ClaimDetail'+runObjIndex+'DtInvoiceDate').val();
				notcurentVcOutletCodevalue = $('#ClaimDetail'+runObjIndex+'VcOutletCode').val();    
				
				
				if (outletcurrIndex != runObjIndex) {
					//	alert('thival--'+$(this).val());	
                  if (($.trim(value) == $.trim($(this).val()))
					&& ($.trim(notcurentdatevalue)==$.trim(curentdatevalue))
					&& ($.trim(notcurentVcInvoiceNovalue)==$.trim(curentVcInvoiceNovalue)) && 
					$.trim(curentVcInvoiceNovalue)!='' && 
					$.trim(value)!='' &&
					$.trim(curentdatevalue)!=''
					) {
                      rejection=false;                   
					
					$('#ClaimDetail'+outletcurrIndex+'VcInvoiceNo').val('');					
					$("#showreason_id_" + outletcurrIndex).hide();
					$("#ClaimDetail" +outletcurrIndex+ "VcReasonsDiv").html(' ');
					$(commonPopupObj).find('#messageshow').html('Invoice No. already exsist.');
					$(commonPopupObj).css('display', 'block');
				//    console.log(noOfdays+'=='+curentNuLitresvalue+'==jam6=getuniuqe=6=litrescurrIndex=='+outletcurrIndex);	
                    amountvalueAdmin(curentNuLitresvalue,noOfdays,outletcurrIndex,rejection);
                	returnpass= false;

                    }
                    }					

				});
				
				if(datecurrIndex >=0 ){
				
				 curentdatevalue = $('#ClaimDetail'+datecurrIndex+'DtInvoiceDate').val();
				 curentVcInvoiceNovalue = $('#ClaimDetail'+datecurrIndex+'VcInvoiceNo').val();
				 curentVcOutletCodevalue = $('#ClaimDetail'+datecurrIndex+'VcOutletCode').val();
				 
				 if ($.trim($("#ClaimDetail" + datecurrIndex + "NuLitres").val()) != null && !isNaN($.trim($("#ClaimDetail" + datecurrIndex + "NuLitres").val())) && $.trim($("#ClaimDetail" + datecurrIndex + "NuLitres").val()).length > 0)
					var curentNuLitresvalue = parseFloat($('#ClaimDetail'+datecurrIndex+'NuLitres').val());
				 else
					var curentNuLitresvalue = parseFloat(0);
					
				var todaydate = new Date();				
				if($('#ClaimDetail'+datecurrIndex+'DtInvoiceDate').val()!='')
                curentdatevalueConvert = $('#ClaimDetail'+datecurrIndex+'DtInvoiceDate').datepicker('getDate');
				noOfdays = Math.floor((todaydate.getTime() - curentdatevalueConvert.getTime()) / 86400000); // ms per day
				
				}
				
				
				$(dateObj).each(function() {	
				
				
                runObjIndex = parseInt($(dateObj).index(this));
				notcurentVcInvoiceNovalue = $('#ClaimDetail'+runObjIndex+'VcInvoiceNo').val();
				notcurentVcOutletCodevalue = $('#ClaimDetail'+runObjIndex+'VcOutletCode').val();    
				
				
				
				if (datecurrIndex != runObjIndex) {
					
                        if (($.trim(value)== $.trim($(this).val()))
						&& ($.trim(notcurentVcInvoiceNovalue)==$.trim(curentVcInvoiceNovalue)) && 
						($.trim(notcurentVcOutletCodevalue)==$.trim(curentVcOutletCodevalue)) 
						&&
						$.trim(curentVcInvoiceNovalue)!='' && 
						$.trim(curentVcOutletCodevalue)!='' &&
						$.trim(value)!=''	) {
						
						rejection=false;
                       					
						$('#ClaimDetail'+datecurrIndex+'VcInvoiceNo').val('');
						$("#showreason_id_" + datecurrIndex).hide();
						$("#ClaimDetail" +datecurrIndex+ "VcReasonsDiv").html(' ');
					    $(commonPopupObj).find('#messageshow').html('Invoice No. already exsist.');
					    $(commonPopupObj).css('display', 'block');
						
					//	console.log(noOfdays+'=='+curentNuLitresvalue+'==jam7=getuniuqe=7=litrescurrIndex=='+datecurrIndex);	
                        amountvalueAdmin(curentNuLitresvalue,noOfdays,datecurrIndex,rejection);
                	
						returnpass= false;                        

                        }

                    }
						

                });
				
				if(currIndex>=0){
				 
				curentdatevalue = $('#ClaimDetail'+currIndex+'DtInvoiceDate').val();
				curentVcInvoiceNovalue = $('#ClaimDetail'+currIndex+'VcInvoiceNo').val();
			    curentVcOutletCodevalue = $('#ClaimDetail'+currIndex+'VcOutletCode').val();
				
				if($('#ClaimDetail'+currIndex+'NuLitres').val()!='')
					var curentNuLitresvalue = parseFloat($('#ClaimDetail'+currIndex+'NuLitres').val());
				 else
					var curentNuLitresvalue = parseFloat(0);
					
				var todaydate = new Date();	
				
				if($('#ClaimDetail'+currIndex+'DtInvoiceDate').val()!=''){		
				
				var  curentdatevalueConvert = $('#ClaimDetail'+currIndex+'DtInvoiceDate').datepicker('getDate');
				noOfdays = Math.floor((todaydate.getTime() - curentdatevalueConvert.getTime()) / 86400000); // ms per day
				
				}				
				}
				
				$(Obj).each(function() {
				
				//alert(Obj.attr('id'));
                runObjIndex = parseInt($(Obj).index(this));
				notcurentdatevalue = $('#ClaimDetail'+runObjIndex+'DtInvoiceDate').val();
				notcurentVcOutletCodevalue = $('#ClaimDetail'+runObjIndex+'VcOutletCode').val();    
				
				if (currIndex != runObjIndex) {
							
                        if (($.trim(value).toLowerCase() == $.trim($(this).val().toLowerCase()))
						&& 
						($.trim(notcurentdatevalue)==$.trim(curentdatevalue))
						&&
						($.trim(notcurentVcOutletCodevalue)==$.trim(curentVcOutletCodevalue))
						&&
						$.trim(notcurentdatevalue)!='' && 
						$.trim(curentdatevalue)!='' && 
						$.trim(notcurentVcOutletCodevalue)!='' &&
						$.trim(curentVcOutletCodevalue)!='' &&
						 $.trim(value)!=''
						) {
                        rejection=false;
					
						$('#ClaimDetail'+currIndex+'VcInvoiceNo').val('');
						$("#showreason_id_" + currIndex).hide();
					    $(commonPopupObj).find('#messageshow').html('Invoice No. already exsist.');
						$("#ClaimDetail" +currIndex+ "VcReasonsDiv").html(' ');
					    $(commonPopupObj).css('display', 'block');
						
					//	console.log(noOfdays+'=='+curentNuLitresvalue+'==jam8=getuniuqe=8=litrescurrIndex=='+currIndex);	
                        amountvalueAdmin(curentNuLitresvalue,noOfdays,currIndex,rejection);
                	
						returnpass= false;                  

                        } 
						}						

                });
            return returnpass;

			}		
		}
	
	
	/*
	*/
	
	$(obj).delegate("input[name *='vc_invoice_no']",'change',function(){

		
		var Rowid = parseInt($(this).attr('id').split("ClaimDetail")[1], 12);
		element = $(this);
        value = $(this).val();
        var	invoicealreadycheck_L = true;
		
		var ltrValue = parseFloat(0);
		
		if ($.trim(value)!= null && $.trim(value)!=0 && $('#ClaimDetail'+Rowid+'NuLitres').val()!='')
			ltrValue = parseFloat($.trim($('#ClaimDetail'+Rowid+'NuLitres').val()));
		else
			ltrValue = parseFloat(0);	

		//ltrValue = parseFloat('012000');
		var todaydate = '';
		var noOfdays = 0;

		if ($('#ClaimDetail' + Rowid + 'DtInvoiceDate').val() != '') {
			var InvoiceDate = $('#ClaimDetail' + Rowid + 'DtInvoiceDate').datepicker('getDate');
			todaydate = new Date();
			noOfdays = Math.floor((todaydate.getTime() - InvoiceDate.getTime()) / 86400000);

		}
		
		if ($('#ClaimDetail' + Rowid + 'DtInvoiceDate').val() != '' &&  $('#ClaimDetail'+Rowid+'VcInvoiceNo').val()!='' 
		&& $('#ClaimDetail'+Rowid+'VcOutletCode').val()!='') {
			  $(this).trigger('blur');

			invoicealreadycheck_L = checkAjax(Rowid,ltrValue,InvoiceDate);
		  }
		  
		  
		});
	
	$(obj).delegate("select[name *='vc_outlet_code']",'change',function(){
	
		var Rowid = parseInt($(this).attr('id').split("ClaimDetail")[1], 12);
		element   = $(this);
        value     = $(this).val();
        var	invoicealreadycheck_L = true;		
		var ltrValue = parseFloat(0);
		
		if ($.trim(value) != null && $.trim(value) !=0 && $('#ClaimDetail' + Rowid + 'NuLitres').val()!='')
		ltrValue = parseFloat($.trim($('#ClaimDetail' + Rowid + 'NuLitres').val()));
		else
		ltrValue = parseFloat(0);	

		//ltrValue = parseFloat('012000');
		var todaydate = '';
		var noOfdays = 0;
		
		if ($('#ClaimDetail' + Rowid + 'DtInvoiceDate').val() != '') {
			var InvoiceDate = $('#ClaimDetail' + Rowid + 'DtInvoiceDate').datepicker('getDate');
			todaydate = new Date();
			noOfdays = Math.floor((todaydate.getTime() - InvoiceDate.getTime()) / 86400000);

		}
		if ($('#ClaimDetail' + Rowid + 'DtInvoiceDate').val() != '' &&  $('#ClaimDetail'+Rowid+'VcInvoiceNo').val()!='' 
		&& $('#ClaimDetail'+Rowid+'VcOutletCode').val()!='') {
			 $(this).trigger('blur');
			invoicealreadycheck_L = checkAjax(Rowid,ltrValue,InvoiceDate);
		}		
		
	});
 
   $('.innerbody').delegate("img[id *='showreason']", "click", function() {
		
        var Rowid = parseInt($(this).attr('id').split("showreason_id_")[1], 14);

        if ($.trim($('#ClaimDetail' + Rowid + 'VcReasons').val()) != '' && $.trim($('#ClaimDetail' + Rowid + 'VcReasons').val()) != null) {

            $(commonPopupObj).find('#messageshow').html($('#ClaimDetail' + Rowid + 'VcReasons').val());
            $(commonPopupObj).css('display', 'block');
        }
        else {
            //$(commonPopupObj).find('#messageshow').html('Invoice is Ok');
            //$(commonPopupObj).css('display','block');		
        }
    });
	
   $(obj).delegate("input[name*='nu_litres']", 'change', function() {

        element = $(this);
        value = $(this).val();
        var Rowid = parseInt($(this).attr('id').split("ClaimDetail")[1], 10);

		var	invoicealreadycheck_L = true;
		
		if (Number(value) >= 0) {

            var ltrValue = parseFloat(0);
           	
			if ($.trim(value) != null && !isNaN($.trim(value)) && $.trim(value).length > 0)
            ltrValue = parseFloat($.trim(value));
			else
			ltrValue = parseFloat(0);	

            //ltrValue = parseFloat('012000');
            var todaydate = '';
            var noOfdays = 0;
            var InvoiceDate = $('#ClaimDetail' + Rowid + 'DtInvoiceDate').datepicker('getDate');

            if ($('#ClaimDetail' + Rowid + 'DtInvoiceDate').val() != '') {

                todaydate = new Date();
                noOfdays = Math.floor((todaydate.getTime() - InvoiceDate.getTime()) / 86400000);

            }
			if ($('#ClaimDetail' + Rowid + 'DtInvoiceDate').val() != '' &&  $('#ClaimDetail'+Rowid+'VcInvoiceNo').val()!='' 
			&& $('#ClaimDetail'+Rowid+'VcOutletCode').val()!='') {
				invoicealreadycheck_L = checkAjax(Rowid,ltrValue,InvoiceDate);
			}
			
			}
			$(this).trigger('blur');
			
   });
	
   function checkAjax(Rowid,ltrValue,InvoiceDate){
		$.ajax({
				type: "POST",
			    url: GLOBLA_PATH + "flr/claims/getAllInvoiceCheck/",
				data: {
				
				ClaimHeaderVcClaimNo :function(){
							
				return $('#ClaimHeaderVcClaimNo').val()
							
				},
				ClaimHeaderVcInvoicedate :function(){
							
				return $('#ClaimDetail'+Rowid+'DtInvoiceDate').val()
							
				},
				ClaimDetailVcInvoiceNo :function(){
							
				return $('#ClaimDetail'+Rowid+'VcInvoiceNo').val()
							
				},
				ClaimHeaderVcOutletCode :function(){
						
				return $('#ClaimDetail'+Rowid+'VcOutletCode').val()
				},
				ClaimHeaderVcInvoiceid :function(){
				return $('#ClaimDetail'+Rowid+'VcClaimDtId').val()
				},
				
				},			
				success : function (data) {

				if(data==false){
				
					var invoicealreadycheck=false;
					 $getUniqueInAllrows =  getUniqueInAll(value,element);
					 totalamountofinvoicesInfun();
					 alert('00000show retrun=='+$getUniqueInAllrows);
					 
					 if($getUniqueInAllrows==true){
					  
					 //   console.log(ltrValue+Rowid+InvoiceDate+'==jam1552===78888invoicealreadycheck_L==againvalue==');
						callAfterajax(ltrValue,Rowid,InvoiceDate,invoicealreadycheck);
					    totalamountofinvoicesInfun();						
					  }else{					  
						// callAfterajax(ltrValue,Rowid,InvoiceDate,invoicealreadycheck);
					//	 console.log(noOfdays+'=='+curentNuLitresvalue+'==jam9=getuniuqe=98=litrescurrIndex=='+Rowid);	
						 amountvalueAdmin(ltrValue,'',Rowid,invoicealreadycheck);                	
						 totalamountofinvoicesInfun();
					//	 console.log(invoicealreadycheck+'===jam16660==111invoicealreadycheck_L==value=='+value+'==element=='+element);				
					}
					
					}
				else {
					// console.log('==jam11===222invoicealreadycheck_L==againvalue=='+value+'==element=='+element);
					 var invoicealreadycheck=true;
					 $getUniqueInAllrows =  getUniqueInAll(value,element);
					 totalamountofinvoicesInfun();
					 // alert('show retrun=='+$getUniqueInAllrows);
					  if($getUniqueInAllrows==true){
					   // console.log(ltrValue+Rowid+InvoiceDate+'==jam12===78888invoicealreadycheck_L==againvalue==');
						callAfterajax(ltrValue,Rowid,InvoiceDate,invoicealreadycheck);
					    totalamountofinvoicesInfun();
					  }
					 
				}
				
	    	 }
			 
		 });
		 //alert('kyabhai=='+invoicealreadycheck);
				//return invoicealreadycheck;
		
	}
		 
		 
  function callAfterajax(ltrValue,Rowid,InvoiceDate,invoicealreadycheck){
				
			var noOfdays = 0;
			// var InvoiceDate = noOfdays;
			var todaydate = new Date();
			//var InvoiceDate = $('#ClaimDetail' + Rowid + 'DtInvoiceDate').datepicker('getDate');
			if(InvoiceDate!='')
			noOfdays = Math.floor((todaydate.getTime() - InvoiceDate) / 86400000); // ms per day			 
			else
			noOfdays = Math.floor(0);
			
			if(invoicealreadycheck == false){
			 amountvalueAdmin(ltrValue,noOfdays,Rowid,invoicealreadycheck);                	
            		
			if(ltrValue ==0 && noOfdays <= 90){
				
				$("#ClaimDetail" + Rowid + "VcReasons").val('Invoice No. already exsist.');
			    $("#ch_rejected_td_" + Rowid).html('<img alt="" src="'+GLOBLA_PATH+'/img/with-check.jpg">');
			    $("#ClaimDetail" + Rowid + "VcReasonsDiv").html('Invoice alr ....');
                $("#showreason_id_" + Rowid).show();
				return false;
	
			}else if(ltrValue >= 200 && noOfdays <= 90){
			//	console.log('=jam13=callAfterajax1');
				$("#ClaimDetail" + Rowid + "VcReasons").val('Invoice No. already exsist.');
			    $("#ch_rejected_td_" + Rowid).html('<img alt="" src="'+GLOBLA_PATH+'/img/with-check.jpg">');
			    $("#ClaimDetail" + Rowid + "VcReasonsDiv").html('Invoice alr ....');
                $("#showreason_id_" + Rowid).show();
				return false;
	
			}else if (ltrValue < 200 && ltrValue!=0 && noOfdays > 90 ) {
			
			//	console.log('=jam14=new-callAfterajax2');
                $("#ch_rejected_td_" + Rowid).html('<img alt="" src="'+GLOBLA_PATH+'/img/with-check.jpg">');
				$("#ClaimDetail" + Rowid + "VcReasons").val('Invoice is older than 3 months & Fuel is less than 200 Ltrs & Invoice No. already exsist.');
            	$("#ClaimDetail" + Rowid + "VcReasonsDiv").html('Invoice is ....');
                $("#showreason_id_" + Rowid).show();
				return false;

            } else if (ltrValue > 200 && noOfdays > 90) {
				
			//	console.log('=jam15=callAfterajax3');		
			
                $("#ch_rejected_td_" + Rowid).html('<img alt="" src="'+GLOBLA_PATH+'/img/with-check.jpg">');
				$("#ClaimDetail" + Rowid + "VcReasons").val('Invoice is older than 3 months & Invoice No. already exsist.');
				$("#ClaimDetail" + Rowid + "VcReasonsDiv").html('Invoice is ...');
                $("#showreason_id_" + Rowid).show();
				return false;

            } else if (ltrValue < 200  && ltrValue!=0 && noOfdays <= 90) {
			
			//	console.log('=jam16=callAfterajax4');
				$("#ch_rejected_td_" + Rowid).html('<img alt="" src="'+GLOBLA_PATH+'/img/with-check.jpg">');
            	$("#ClaimDetail" + Rowid + "VcReasons").val('Fuel is less than 200 Ltrs. & Invoice No. already exsist.');
                $("#ClaimDetail" + Rowid + "VcReasonsDiv").html('Fuel is ...');
                $("#showreason_id_" + Rowid).show();
				return false;

            } else {
			    
			//	console.log('=jam17=callAfterajax5');
			    $("#ch_rejected_td_" + Rowid).html('<img alt="" src="'+GLOBLA_PATH+'/img/without-check.jpg">');
                $("#ClaimDetail" + Rowid + "VcReasons").val('');
                $("#ClaimDetail" + Rowid + "VcReasonsDiv").html('');
                $("#showreason_id_" + Rowid).hide();				
            }			
			
			}
			else{
    			
				var nu_refund_prcn = $("#ClaimDetail" + Rowid + "NuRefundPrcnt").val();
                var nu_admin_fee_prcnt = $("#ClaimDetail" + Rowid + "NuAdminFeePrcnt").val();
                var nu_refund_rate = $("#ClaimDetail" + Rowid + "NuRefundRate").val();

                if (ltrValue < 200 || noOfdays > 90 || invoicealreadycheck==false ) {

                    var admin_fee = 0;
                    var amount    = 0;
					
                    $("#ClaimDetail" + Rowid + "NuAdminFee").val(admin_fee).trigger('blur');
                    $("#ClaimDetail" + Rowid + "NuAmount").val(amount).trigger('blur');

                }
                else {

                    var admin_fee = parseFloat(nu_admin_fee_prcnt * ltrValue).toFixed(2);
                    var amount    = parseFloat(nu_refund_rate * ltrValue).toFixed(2);
					
                    $("#ClaimDetail" + Rowid + "NuAdminFee").val(admin_fee).trigger('blur');
                    $("#ClaimDetail" + Rowid + "NuAmount").val(amount).trigger('blur');
							

                }
				
				/* function to display total amount atlast*/
				totalamountofinvoicesInfun();
				
				
			 
			 
			 if (ltrValue < 200 && ltrValue!=0 && noOfdays > 90 ) {
			
			//	console.log('-=jam18=-new-callAfterajax2111');
                $("#ch_rejected_td_" + Rowid).html('<img alt="" src="'+GLOBLA_PATH+'/img/with-check.jpg">');
				$("#ClaimDetail" + Rowid + "VcReasons").val('Invoice is older than 3 months & Fuel is less than 200 Ltrs.');
            	$("#ClaimDetail" + Rowid + "VcReasonsDiv").html('Invoice is ....');
                $("#showreason_id_" + Rowid).show();
				return false;

            } else if (ltrValue > 200 && noOfdays > 90) {
				
			//	console.log('=jam19=callAfterajax3111');		
			
                $("#ch_rejected_td_" + Rowid).html('<img alt="" src="'+GLOBLA_PATH+'/img/with-check.jpg">');
				$("#ClaimDetail" + Rowid + "VcReasons").val('Invoice is older than 3 months.');
				$("#ClaimDetail" + Rowid + "VcReasonsDiv").html('Invoice is ...');
                $("#showreason_id_" + Rowid).show();
				return false;

            } else if (ltrValue < 200  && ltrValue!=0 && noOfdays <= 90) {
			
			//	console.log('=jam20=callAfterajax4111');
				$("#ch_rejected_td_" + Rowid).html('<img alt="" src="'+GLOBLA_PATH+'/img/with-check.jpg">');
            	$("#ClaimDetail" + Rowid + "VcReasons").val('Fuel is less than 200 Ltrs.');
                $("#ClaimDetail" + Rowid + "VcReasonsDiv").html('Fuel is ...');
                $("#showreason_id_" + Rowid).show();
				
				return false;

            }else {
			    
			//	console.log(ltrValue+'=jam21=callAfterajax5111'+noOfdays);
			    $("#ch_rejected_td_" + Rowid).html('<img alt="" src="'+GLOBLA_PATH+'/img/without-check.jpg">');
                $("#ClaimDetail" + Rowid + "VcReasons").val('');
                $("#ClaimDetail" + Rowid + "VcReasonsDiv").html('');
                $("#showreason_id_" + Rowid).hide();
				
            }
			}
			//console.log(ltrValue+'==jam22===ltrValue====noOfdays='+noOfdays+'callAfterajax2111');
            return true;
	 }
	 
	 // function to display total amount of invoices 
  function totalamountofinvoicesInfun(){
				
				var totalMt = parseFloat(0);
             
			  $('#table_row_claims_id').find("input[name *='[nu_amount]']").each(function() {
			 //   $(this).parent().parent().parent().find("input[name *='[nu_amount]']").each(function() {
				//console.log('=jam23=callAfterajax89995');
                    if (Number($.trim($(this).val())) >= 0 && $.trim($(this).val()) != '' && $.trim($(this).val()) != null) {

                        var val = parseFloat($.trim($(this).val()));
                        totalMt = parseFloat(totalMt) + parseFloat(val);
                        //alert('final-amt1222-'+totalMt);

                    } else {

                        var val = parseFloat(0);
                        //alert('final-amt11-'+totalMt);

                    }

                });

                totalMt = parseFloat(totalMt).toFixed(2);
                $('#showtotalamount_id').html(totalMt);
				
		}	 

		
  function validate() {

        var addobject = $(obj).find('.innerbody:eq(1)').find('table tbody');

        $.validator.addMethod("onlyNumberWithoutFloat", function(value, element) {
		
            if (Number(value) >= 0) {

                return true;

            }
            return false;

        }, "Decimal not accepted");

		
		if($('#ClaimHeaderSinglefileuploadID').is(':checked')==true){
		
		var buttonObject='#ClaimMultipleDOCID';	
		
		//alert(obj.find('.uploadify-queue-item').length+'--len');
		
		if(obj.find('.uploadify-queue-item').length==0 ){ 
				
			if($(buttonObject).hasClass('form-error')==false){
				
				$(buttonObject).addClass('form-error');					
				$(buttonObject).after('<div class="add-error">Required</div>');
			
			}
		
		}else{
		
			$(buttonObject).removeClass('form-error');					
			$(buttonObject).next('.add-error').remove();
			$(buttonObject).closest('div').remove(".add-error");

		}
		
		}
		
		$(addobject).find("input[name *='vc_invoice_no']").each(function() {
	    	
			$(this).rules("add", {
                required: true,
              //  alphanumeric: true,
				dontallowspace:true,
                maxlength: 15,
             }); 
		 });
		 
        $(addobject).find("select[name*='vc_outlet_code']").each(function() {
			
            $(this).rules("add", {
                required: true,
                //getUniqueNo: true,				
                messages: {
                    required: 'Required'

					}});
				});
	 
	 
			
	$(addobject).find("input[name*='dt_invoice_date']").each(function() {

            $(this).rules("add", {
                required: true,
                date: true,
                maxlength: 15,
				//getUniqueNo: true,               
                messages: {
                    required: 'Required'
                }});
        });

        
        $(addobject).find("input[name*='nu_litres']").each(function() {
            $(this).rules("add", {
                required: true,
                positiveNumber: true,
                maxlength: 12,
				//getUniqueNo: true,      
                //onlyNumberWithoutFloat	: true,
                messages: {
                    required: 'Required'
                }});

        });
       
        $(addobject).find("input[type='file']").each(function() {

            $(this).rules("add", {
                required: {
					depends:function (){
					
					if($('#posted_data_id').val()=='SAVE'){
						return false;
					}else{
						return true;
					}					
				}},
				//required:true,	
                accept: true,
                filesize: true,
                messages: {
                    required: 'Please upload document'
                }
            });
        });
		
		

    } // end of if of validate function		

    /*Set DatePicker At Run time and After new row add*/

    setDatePicker();

    /* Apply Validate rule before and after a new add */

    validate();
	
	 /********Add Row**************/
    $(obj).find('#addrow').click(function() {

        var setMinNo = 1;
        //var rowCount = $(obj).find('.innerbody:eq(1)').find('table tbody tr').length;
        var rowCount = $(obj).find('#table_row_claims_id').find('tr').length;		
		$('#hidden_call').val(rowCount);
       // var addobject = $(obj).find('.innerbody:eq(1)').find('table tbody');
        var addobject = $(obj).find('table').find('#table_row_claims_id');

        if (rowCount >= setMinNo) {           

                $(addobject).find('tr:last').after("<tr id='loadingrow'> <td colspan='13'> <div id='loading' style='text-align:center;' ><img width='30px' src='" + GLOBLA_PATH + "img/loading.gif' > </img> </div></td> </tr>");

           			var singlevalue=$('#singlefileuploadidHidden').val();
    
            $.ajax({
                type: "POST",
                url: GLOBLA_PATH + 'flr/claims/addclaim/'+singlevalue,
                data: {
                    rowCount: rowCount,
			    	singlefileuploadidHidden:$('#singlefileuploadidHidden').val(),
           
                }

            }).done(function(data) {

                if (data !== '') {
                    var rowCountId = $(obj).find('#table_row_claims_id').find('tr').length;
					
				
                    /*Set DatePicker At Run time and After new row add*/
					
					if (rowCountId > 1) {
						$('#loadingrow').remove();					
					}
                    

                    /* Apply Validate rule before and after a new add */
                   
                    $(addobject).find('tr:last').after(data);
					var row = $(obj).find('#table_row_claims_id').find('tr').length;
					
					if($('#ClaimHeaderSinglefileuploadID').is(':checked')){
						for(var k=1;k<=row;k++){
							$('#updoc'+k).css('display','none');
							$('#updoc'+k).find("div").remove(".error-message");

						}
					}else{
						for(var k=1;k<=row;k++){
							$('#updoc'+k).css('display','');
						}
					
					}
				//	$('#updoc2').css('display','none');
					validate();
					setDatePicker();					
                }
            });

        }


    });

    /*************Delete Row *************/
    $(obj).find('#rmrow').click(function() {
        var setDefautShow = 1;
        //var rowCount = $(obj).find('.innerbody:eq(1)').find('table tbody tr').length;
        var rowCount = $(obj).find('#table_row_claims_id').find('tr').length;
        var addobject = $(obj).find('.innerbody:eq(1)').find('table tbody');
        if (rowCount > 1) {
            totalamtdisplay(rowCount);
            $(addobject).find('tr:last').remove();
        }
    });
	
	 $(obj).find('a[id*=deletefileMultiID]').on('click',function() {
	 
				var id = $(this).attr('type');
				var rowid= 'Viewlink_'+$(this).attr('rel');
				var deleterowid= 'deletefileMultiID'+$(this).attr('rel');
				var browseid= $(this).attr('name');
				var divindexno = $(this).attr('name');
	
				$("<p> Are you sure want to delete this file </p>" ).dialog({					
					resizable: false,
					height:160,
					width:400,
					modal: true,
					buttons: {
						"ok": function() {
							
							//alert(browseid);

							$.ajax({
							type: "POST",
							url: GLOBLA_PATH + "flr/claims/deletefile/"+browseid,
							data: {
							ClaimDocDetailId : id,			
							},				
							success : function (data) {		//alert(data);		
							if(data){				
								
								//$('#'+rowid)
								$('#'+rowid).css('display', 'none');
								$('#updoc'+browseid).css('display', '');
								$('#'+deleterowid).css('display', 'none');						
								//alert(divindexno);	
								$('#browsedivid'+divindexno).html(data);
								validate();
								setDatePicker();
								$(commonPopupObj).find('#messageshow').html('File deleted successfully!!.');
								$(commonPopupObj).css('display', 'block');	
								$('#'+'ClaimDetail'+divindexno+'VcOutletCode').css('display', '');	
								$('#'+'ClaimDetail'+divindexno+'VcInvoiceNo').css('display', '');	
								$('#'+'ClaimDetail'+divindexno+'DtInvoiceDate').css('display', '');	
								$('#'+'divoutlet'+divindexno).css('display', 'none');	
								$('#'+'divinvoicedate'+divindexno).css('display', 'none');	
								$('#'+'divinvoice'+divindexno).css('display', 'none');	
								
								// window.location.reload();
							}				
							}
							});	
							
							
							$( this ).dialog( "close" );
						},
						Cancel: function() {
							$( this ).dialog( "close" );
						}
					}
				
			});
	          
	 });
	 
	 $(obj).find('a[id*=deletefileID]').click(function() {
	 		   
	 var id = $(this).attr('media');
	 var rowid= 'rowIDdelete_'+$(this).attr('rel');
	 var updocrowid = 'updoc'+$(this).attr('name');
	 $("<p> Are you sure want to delete this file </p>" ).dialog({					
					resizable: false,
					height:160,
					width:400,
					modal: true,
					buttons: {
						"ok": function() {

	//alert(updocrowid);
	 $.ajax({
				type: "POST",
			    url: GLOBLA_PATH + "flr/claims/deletefile/",
				data: {
				ClaimDocDetailId : id,			
				},
				success : function (data) {
				if(data==false){
				
				$('#'+rowid).remove();
				$(commonPopupObj).find('#messageshow').html('File deleted successfully!!.');
				$(commonPopupObj).css('display', 'block');	
				$('#'+updocrowid).css('display', '');	
				
				}			
				}
				});
					$( this ).dialog( "close" );
						},
						Cancel: function() {
							$( this ).dialog( "close" );
						}
					}
				
			});
		});


    var dateDiff = function(d1, d2) {
        var diff = Math.abs(d1 - d2);
        if (Math.floor(diff / 86400000)) {
            return Math.floor(diff / 86400000) + " days";
        } else if (Math.floor(diff / 3600000)) {
            return Math.floor(diff / 3600000) + " hours";
        } else if (Math.floor(diff / 60000)) {
            return Math.floor(diff / 60000) + " minutes";
        } else {
            return "< 1 minute";
        }
    };
	
	$(obj).delegate(".ontop .close",'click',function(){
		
		closeObj = $(this);
		var noOfrows_already = $(obj).find("a[id *= 'Viewlink_']").length;

		var buttonObject='#ClaimMultipleDOCID';		
		
		if(obj.find('.uploadify-queue-item').length==0 && noOfrows_already==0){
		//alert('hua');		
		}else{
		
	 	$(buttonObject).closest('div').remove(".add-error");
		//	alert($(buttonObject).next('.add-error').length);
		$(buttonObject).removeClass('form-error');
		$(buttonObject).next('.add-error').remove();		
		//$( "div" ).remove( ".hello" );
		}
		});
	
	
	

	/***-- Below function is used to get total amount after addition of last claim--- ****/
	
    function totalamtdisplay(len) {

        var finalamt = parseFloat(0);		
        for (var i = 0; i < len - 1; i++) {
        
     		var amountvalue = $('#ClaimDetail' + i + 'NuAmount').val();     
        	 if (Number($.trim(amountvalue)) >= 0 && $.trim(amountvalue) != '' && $.trim(amountvalue) != null) {
			 
               finalamt = parseFloat(finalamt) + parseFloat($.trim(amountvalue));
			   
        	   } else {               
			   var val = parseFloat(0);
                //alert('final-amt11-'+totalMt);
            }
            //alert('funct----'+finalamt);
        }
        finalamt = parseFloat(finalamt).toFixed(2);
        $('#showtotalamount_id').html(finalamt);
    }
	
//	ClaimHeaderSinglefileuploadID



$(obj).bind('submit', function(e) {

        var errroMessage = false;		
		var buttonObject='#ClaimMultipleDOCID';
		if($('#ClaimHeaderSinglefileuploadID').is(':checked')==true){

		if(obj.find('.uploadify-queue-item').length==0 ){ 
				
			if($(buttonObject).hasClass('form-error')==false){
				
				$(buttonObject).addClass('form-error');					
				$(buttonObject).after('<div class="add-error">Required</div>');
			}
						   errroMessage =true;

		
		}else{
			$(buttonObject).removeClass('form-error');					
			$(buttonObject).next('.add-error').remove();
			$(buttonObject).closest('div').remove(".add-error");

		}
		}
	//alert(errroMessage);
	if(errroMessage == false){
	
    if ($(this).valid() ) {


			if ($(this).find('input[type ="submit"]').length > 0) {

				$(this).find('input[type ="submit"]').attr('disabled', 'disabled');
					 $('form#ClaimFlrEditForm').submit();
			}

			if ($(this).find('button[type ="submit"]').length > 0) {

				$(this).find('button[type ="submit"]').attr('disabled', 'disabled');
					 $('form#ClaimFlrEditForm').submit();
			}

        return true;
      }
	}
    return false;
});
		
		
		
});	 

function multiple_hide(){

		var row = $(obj).find('#table_row_claims_id').find('tr').length;
		var noOfrows_already = $(obj).find("a[id *= 'Viewlink_']").length;
		var buttonObject='#ClaimMultipleDOCID';	
		
		if($('#ClaimHeaderSinglefileuploadID').is(':checked')==true){	
		// alert($(obj).find("a[id *= 'Viewlink_']").length);
		// alert($(obj).find("a[id *= 'Viewlink_']").length);
		if(obj.find('.uploadify-queue-item').length==0 && noOfrows_already==0){
			if(!($(buttonObject).hasClass('form-error'))){
				$(buttonObject).addClass('form-error');					
				$(buttonObject).after('<div class="add-error">Required</div>');
			}
		
		}else{
	 
	 	$(buttonObject).removeClass('form-error');					
		$(buttonObject).closest('div').remove(".add-error");
		}
	 
		for(var k=0;k<=row;k++){
		
			$('#updoc'+k).css('display','none');
			$('#updoc'+k).closest('td').find("div").remove(".error-message");
		}
		$('#ClaimMultipleDOCID').css('display','');
	
	}else{
	
	    if($(buttonObject).next('.add-error').length>0){
  		   $(buttonObject).closest('div').remove(".add-error");
			$(buttonObject).removeClass('form-error');
			$(buttonObject).next('.add-error').remove();
		}
		$('#ClaimMultipleDOCID').css('display','none');			
		for(var i=0;i<=row;i++){		
			$('#updoc'+i).css('display','');		
		}
	}

}