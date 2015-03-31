var obj = $('#ClaimFlrSaveForm');

var commonPopupObj = $('#commonmessage');

$(obj).validate();

var objDate = new Date();

$(function() {
	
	$(obj).find("input[name *='dt_claim_from']").datepicker({
		 
        maxDate: "0 D",
		 
        defaultDate: "+1w",
		 
        changeMonth: true,
		 
        changeYear: true,
		 
        dateFormat: 'dd M yy',
		
		onClose: function( selectedDate ) {
				
				$(obj).find("input[name *='dt_claim_to']").datepicker( "option", "minDate", selectedDate );
				$(this).trigger('blur');
		}	        
    });
	
   $(obj).find("input[name *='dt_claim_to']").datepicker({
	
        maxDate: "0 D",
		 
        defaultDate: "+1w",
		 
        changeMonth: true,
		 
        changeYear: true,
		 
        dateFormat: 'dd M yy',
						 
       onClose: function( selectedDate ) {
			
			$(obj).find("input[name *='dt_claim_from']").datepicker( "option", "maxDate", selectedDate );
			
			$(this).trigger('blur');
		
		}     
    });
	
	$(obj).find("input[name *='dt_claim_from']").each(function(){
		
			$(this).rules("add",{

			required 	: true,
			
			date		: true,
			
			messages : {

				required	: 	'Required'
				

			}});		
		
		
		});
			
	$(obj).find("input[name *='dt_claim_to']").each(function(){
		
			$(this).rules("add",{

			required 	: true,
			
			date		: true,
			
			messages : {

				required	: 	'Required'
				

			}});		
		
		
		});	
		
	/*function numberWithCommas(x) {
      var parts = x.toString().split(".");
      parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
     return parts.join(".");
   }*/
   
   $('.deletefile_onchange').bind('click',function(){
   
    var r = confirm('Please delete the doc first if you wish to change the invoice or fuel otlet or invoice date. ');
    if(r== true){
		alert('god');
		return false;
     }
   return true;
   });
   
   
   function totalamtdisplay(len){
		
		var finalamt =parseFloat(0);


	  for(var i=0;i< len-1 ;i++){
		
		var amountvalue= $('#ClaimDetail'+i+'NuAmount').val();
		if(Number($.trim(amountvalue)) >= 0  && $.trim(amountvalue)!='' && $.trim(amountvalue)!=null ){
							
							
				finalamt    =   parseFloat(finalamt) + parseFloat($.trim(amountvalue));

				}else {
							
				var val = parseFloat(0);
						
				}
				
		}
		
		finalamt =parseFloat(finalamt).toFixed(2);
		$('#showtotalamount_id').html(finalamt);	
		
				
	}
	
	
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
						var noOfdays      = 0;
						if($(this).datepicker('getDate')!='')
						var InvoiceDate   =	$(this).datepicker('getDate');	
						var todaydate     = new Date();
						noOfdays          = Math.floor((todaydate.getTime() - InvoiceDate.getTime()) / 86400000); // ms per day
						var Rowid         = parseInt($(this).attr('id').split("ClaimDetail")[1], 10);
						var ltrValue = parseFloat(0);
						//alert('rowdid=='+Rowid);
							//alert(InvoiceDate);						
						//alert('saveindex_id=='+saveindex_id);	
						
				/**********Start For the invoice unique check*************/
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
				//alert(data);
				if(data==false){
				$('#ClaimDetail'+Rowid+'VcInvoiceNo').val('');
				$(commonPopupObj).find('#messageshow').html('Invoice already exsist.');
				$(commonPopupObj).css('display', 'block');
				data='';
				
				}				
				}
				});

				
				/**********End For the invoice unique check*************/
						
						
						if( $.trim($("#ClaimDetail" + Rowid + "NuLitres").val())!=null && !isNaN($.trim($("#ClaimDetail" + Rowid + "NuLitres").val())) && $.trim($("#ClaimDetail" + Rowid + "NuLitres").val()).length > 0 )				
						var ltrValue = 	parseFloat($("#ClaimDetail" + Rowid + "NuLitres").val());
						else
						var ltrValue = parseFloat(0);
												

						
						var nu_refund_prcn = $("#ClaimDetail" + Rowid + "NuRefundPrcnt").val();
						var nu_admin_fee_prcnt = $("#ClaimDetail" + Rowid + "NuAdminFeePrcnt").val();
						var nu_refund_rate	= $("#ClaimDetail" + Rowid + "NuRefundRate").val();
						
						
						
						if (ltrValue < 200 || noOfdays > 90 ) {
						   
						   var admin_fee	= 0;					
						   var amount      = 0;					 
						   
						   $("#ClaimDetail"+Rowid+"NuAdminFee").val(admin_fee).trigger('blur');
					
						   $("#ClaimDetail"+Rowid+"NuAmount").val(amount).trigger('blur');
						
						}			
						else {
					
							var admin_fee	= parseFloat(nu_admin_fee_prcnt*ltrValue).toFixed(2);					
							var amount		= parseFloat(nu_refund_rate*ltrValue).toFixed(2) ;
							
							$("#ClaimDetail"+Rowid+"NuAdminFee").val(admin_fee).trigger('blur');
					
						    $("#ClaimDetail"+Rowid+"NuAmount").val(amount).trigger('blur');
							
						}
						
						
						
						
						var totalMt =  parseFloat(0);
						
						$(this).parent().parent().parent().find("input[name *='[nu_amount]']").each(function(){
						
						if(Number($.trim($(this).val())) >= 0  && $.trim($(this).val())!='' && $.trim($(this).val())!=null ){
							
							var val =  parseFloat($.trim($(this).val()));
							totalMt    =   parseFloat(totalMt) + parseFloat(val);

							}else {
							
							var val = parseFloat(0);
						
							}
						
						});
						totalMt =parseFloat(totalMt).toFixed(2);
					    $('#showtotalamount_id').html(totalMt);
							//alert('---'+noOfdays+'--'+ltrValue);
						if(noOfdays>90 && ltrValue > 200) {		
						
							$("#ch_rejected_td_" + Rowid).html('<img alt="" src="'+GLOBLA_PATH+'/img/with-check.jpg">');
							$("#ClaimDetail" + Rowid + "VcReasons").val('Invoice is older than 3 months.');
							$("#ClaimDetail" + Rowid + "VcReasonsDiv").html('Invoice is...');
							$("#showreason_id_"+ Rowid).show();
							
						}else if(noOfdays>90 && ltrValue == 0 ) {					
						
							$("#ch_rejected_td_" + Rowid).html('<img alt="" src="'+GLOBLA_PATH+'/img/with-check.jpg">');
							$("#ClaimDetail" + Rowid + "VcReasons").val('Invoice is older than 3 months.');
							$("#ClaimDetail" + Rowid + "VcReasonsDiv").html('Invoice is...');
							$("#showreason_id_"+ Rowid).show();
							
						}
						else if(noOfdays>90 && ltrValue <= 200  && ltrValue!=0 ) {					
						
							$("#ch_rejected_td_" + Rowid).html('<img alt="" src="'+GLOBLA_PATH+'/img/with-check.jpg">');
							$("#ClaimDetail" + Rowid + "VcReasons").val('Invoice is older than 3 months & Fuel is less than 200 Ltrs.');
							$("#ClaimDetail" + Rowid + "VcReasonsDiv").html('Invoice is...');
							$("#showreason_id_"+ Rowid).show();
							
						}
						else if(ltrValue < 200 && noOfdays < 90 && ltrValue!='') {
							$("#ch_rejected_td_" + Rowid).html('<img alt="" src="'+GLOBLA_PATH+'/img/with-check.jpg">');
							$("#ClaimDetail" + Rowid + "VcReasons").val('Fuel is less than 200 Ltrs.');
							$("#ClaimDetail" + Rowid + "VcReasonsDiv").html('Fuel is...');
							$("#showreason_id_"+ Rowid).show();
							
						}else {
											
					
							
							$("#ch_rejected_td_" + Rowid).html('<img alt="" src="'+GLOBLA_PATH+'/img/without-check.jpg">');
							$("#ClaimDetail" + Rowid + "VcReasons").val('');
							$("#ClaimDetail" + Rowid + "VcReasonsDiv").html('');
							//alert('hua999');
						    $("#showreason_id_"+ Rowid).hide();

							
								
						}
				
							
						},

						onClose: function() {
							//alert('hua');
								$(this).trigger('blur');
					
						}		
		});
		
	}
	
	
	
	/**
	 * On click get reason
	 */
	 $('.innerbody').delegate("img[id *='showreason']","click",function(){
	  
	  var Rowid         = parseInt($(this).attr('id').split("showreason_id_")[1], 14);
	 
  	  if($.trim($('#ClaimDetail'+Rowid+'VcReasons').val())!='' && $.trim($('#ClaimDetail'+Rowid+'VcReasons').val())!=null){
	  
					$(commonPopupObj).find('#messageshow').html($('#ClaimDetail'+Rowid+'VcReasons').val());
					$(commonPopupObj).css('display','block');		
	  }
	     
	  else{
					//$(commonPopupObj).find('#messageshow').html('Invoice is Ok');
					//$(commonPopupObj).css('display','block');		

		 }
	 
	 
	 });
	   

	/**
	 * On change get calculate data
	 */
	 
	$(obj).delegate("input[name*='nu_litres']",'change',function(){
				
				element = $(this);
				
				value	= $(this).val();
				var Rowid = parseInt($(this).attr('id').split("ClaimDetail")[1], 10);
				
				
				if (Number(value) >= 0 ) {
				
				var ltrValue      = parseFloat(0);
				
				if($.trim(value)!=null && !isNaN($.trim(value)) && $.trim(value).length > 0)
					ltrValue          = parseFloat($.trim(value));
				
				//ltrValue = parseFloat('012000');
				var todaydate     = '';
				var noOfdays      = 0;
				var InvoiceDate   =	$('#ClaimDetail'+Rowid+'DtInvoiceDate').datepicker('getDate');	
				
				if ($('#ClaimDetail'+Rowid+'DtInvoiceDate').val()!=''){
						
						 todaydate     = new Date();
						 noOfdays      = Math.floor((todaydate.getTime() - InvoiceDate.getTime()) / 86400000); 
						
				}
				
				if (ltrValue < 200  &&  noOfdays > 90) {
					
					$("#ch_rejected_td_" + Rowid).html('<img alt="" src="'+GLOBLA_PATH+'img/with-check.jpg">');
					$("#ClaimDetail" + Rowid + "VcReasons").val('Invoice is older than 3 months & Fuel is less than 200 Ltrs.');
					$("#ClaimDetail" + Rowid + "VcReasonsDiv").html('Invoice is...');
					$("#showreason_id_"+ Rowid).show();

					
				}else if (ltrValue > 200  &&  noOfdays > 90){
					$("#ch_rejected_td_" + Rowid).html('<img alt="" src="'+GLOBLA_PATH+'img/with-check.jpg">');
					$("#ClaimDetail" + Rowid + "VcReasons").val('Invoice is older than 3 months.');
					$("#ClaimDetail" + Rowid + "VcReasonsDiv").html('Invoice is...');
					$("#showreason_id_"+ Rowid).show();
					
				}else if(ltrValue < 200  &&  noOfdays <= 90){
				
					$("#ch_rejected_td_" + Rowid).html('<img alt="" src="'+GLOBLA_PATH+'img/with-check.jpg">');
					$("#ClaimDetail" + Rowid + "VcReasons").val('Fuel is less than 200 Ltrs.');
					$("#ClaimDetail" + Rowid + "VcReasonsDiv").html('Fuel is...');
					$("#showreason_id_"+ Rowid).show();
					
				} else {
					$("#ch_rejected_td_" + Rowid).html('<img alt="" src="'+GLOBLA_PATH+'img/without-check.jpg">');
					$("#ClaimDetail" + Rowid + "VcReasons").val('');
					$("#ClaimDetail" + Rowid + "VcReasonsDiv").html('');
				//		alert('aya');					
					$("#showreason_id_"+ Rowid).hide();
				}
				 
					
				var nu_refund_prcn = $(element).parent().parent().find("input[name *='[nu_refund_prcn]']").val();
					
				var nu_admin_fee_prcnt	= $(element).parent().parent().find("input[name *='[nu_admin_fee_prcnt]']").val();
					
				var nu_refund_rate	= $(element).parent().parent().find("input[name *='[nu_refund_rate]']").val();
				    
				if (ltrValue < 200 || noOfdays>90) {
					
				 var admin_fee	= parseFloat(0);					
				 var amount    = parseFloat(0);		
				 
				  $(element).parent().parent().find("input[name *='[nu_admin_fee]']").val(admin_fee).trigger('blur');
					
				  $(element).parent().parent().find("input[name *='[nu_amount]']").val(amount).trigger('blur');
					
				} else {
			    
					//alert(ltrValue);
					var admin_fee		= parseFloat(nu_admin_fee_prcnt*ltrValue).toFixed(2);					
					var amount		    = parseFloat(nu_refund_rate*ltrValue).toFixed(2) ;
					$(element).parent().parent().find("input[name *='[nu_admin_fee]']").val(admin_fee).trigger('blur');
					
					$(element).parent().parent().find("input[name *='[nu_amount]']").val(amount).trigger('blur');
				
				
				
				}
					
					
				var totalMt = parseFloat(0);
						
				$(this).parent().parent().parent().find("input[name *='[nu_amount]']").each(function(){
						
					
				if(Number($.trim($(this).val())) >= 0  && $.trim($(this).val())!='' && $.trim($(this).val())!=null ){
							
							var val =  parseFloat($.trim($(this).val()));
							totalMt    =   parseFloat(totalMt) + parseFloat(val);
						//	alert('final-amt1222-'+totalMt);

				}else {
							
							var val = parseFloat(0);
					//		alert('final-amt11-'+totalMt);
						
				}
						
						
				});
					totalMt =parseFloat(totalMt).toFixed(2);
					$('#showtotalamount_id').html(totalMt);
				//parseFloat($('#showtotalamount_id').html(totalMt)).toFixed(2);
				//$(this).parent().parent().parent().parent().find('tfoot tr').find('td:eq(9)').find('.showamt').html( parseFloat(totalMt));	
					
				} else {
				
					$(element).parent().parent().find("input[name *='[nu_admin_fee]']").val('');
						
					$(element).parent().parent().find("input[name *='[nu_amount]']").val('');
					
					var totalMt =  Math.floor(0);
					
					$(this).parent().parent().parent().find("input[name *='[nu_amount]']").each(function(){
						
						
						//if( Number($(this).val()) >= 0 ) {
							
							var val =  parseFloat($.trim($(this).val()));
							
						//} else {
							
							//var val = parseFloat(0);
						
						//}
						totalMt =   parseFloat(totalMt) + parseFloat(val);
						//totalMt    = numberWithCommas(totalMt);

					//	$('#showtotalamount_id').html(totalMt);
						
					});
						//totalamtdisplay(totalMt);
						$('#showtotalamount_id').html(totalMt);
						
						
					//$(this).parent().parent().parent().parent().find('tfoot tr').find('td:eq(9)').find('.showamt').html( parseFloat(totalMt));	
					
				
				}
	});
	

	
	/**
	 *
	 *	Form Validation Function
	 *
	 */
	function validate(){
			
		var addobject = $(obj).find('.innerbody:eq(1)').find('table tbody');
		
		$.validator.addMethod( "onlyNumberWithoutFloat",function(value, element) {
						
			if( Number(value) >= 0 ) {
				
				return true;
			
			} 
				
			return false;
			
		}, "Decimal not accepted");	
		
	/*	
	if($('#ClaimHeaderSinglefileuploadID').is(':checked')==true){
		var buttonObject='#ClaimMultipleDOCID';	
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
		}*/
					
		$(addobject).delegate("select[name *='vc_outlet_code']",'change',function(){
		    var Rowid = parseInt($(this).attr('id').split("ClaimDetail")[1], 12);
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
				}
				},			
				success : function (data) {
				//alert(data);
				if(data==false){
				$('#ClaimDetail'+Rowid+'VcInvoiceNo').val('');
				$(commonPopupObj).find('#messageshow').html('Invoice already exsist.');
				$(commonPopupObj).css('display', 'block');
				
				}
				
				}
				});
			
			//	alert('Rowid'+Rowid);
		});
		
		$(addobject).find("select[name*='vc_outlet_code']").each(function(){
		
			$(this).rules("add",{

			required 	: true,
			getUniqueNo: true,
			
			messages : {

				required	: 	'Required'
				

			}});		
		
		
		});
		
		$.validator.addMethod('getUniqueNo', function(value, element){
			
			returnPass = true;
			var totallength= $('#ClaimClaimDetailnumofrows').val();
				
			if( $.trim(value) != '' ) {
				outletObj = $(element).parent().parent().parent().find("select[name*='vc_outlet_code']");
				outletcurrIndex = parseInt($(outletObj).index(element));
								
				
				dateObj   = $(element).parent().parent().parent().find("input[name*='dt_invoice_date']");
				datecurrIndex = parseInt($(dateObj).index(element));
                				
           
				Obj = $(element).parent().parent().parent().find("input[name*='vc_invoice_no']");
				currIndex = parseInt($(Obj).index(element));
                
				
				
				if(outletcurrIndex>=0 ){

				curentdatevalue = $('#ClaimDetail'+outletcurrIndex+'DtInvoiceDate').val();
				curentVcInvoiceNovalue = $('#ClaimDetail'+outletcurrIndex+'VcInvoiceNo').val();
			    curentVcOutletCodevalue = $('#ClaimDetail'+outletcurrIndex+'VcOutletCode').val();
				
				
				
				$(outletObj).each(function() {

		        runObjIndex = parseInt($(outletObj).index(this));
				notcurentVcInvoiceNovalue = $('#ClaimDetail'+runObjIndex+'VcInvoiceNo').val();
				notcurentdatevalue = $('#ClaimDetail'+runObjIndex+'DtInvoiceDate').val();
				notcurentVcOutletCodevalue = $('#ClaimDetail'+runObjIndex+'VcOutletCode').val();    
				
				
				if (outletcurrIndex != runObjIndex) {
							
                    if (($.trim(value) == $.trim($(this).val()))
					&& ($.trim(notcurentdatevalue)==$.trim(curentdatevalue))
					&& ($.trim(notcurentVcInvoiceNovalue)==$.trim(curentVcInvoiceNovalue)) && 
					$.trim(curentVcInvoiceNovalue)!='' && 
					$.trim(value)!='' &&
					$.trim(curentdatevalue)!=''
					) {

                     //   returnPass = false;
					$('#ClaimDetail'+outletcurrIndex+'VcInvoiceNo').val('');
					$(commonPopupObj).find('#messageshow').html('Invoice already exsist.');
					$(commonPopupObj).css('display', 'block');
                           // return false;
                        }
                    }	
				
				});
				
				}
				
				if(datecurrIndex >=0 ){
				 curentdatevalue = $('#ClaimDetail'+datecurrIndex+'DtInvoiceDate').val();
				 curentVcInvoiceNovalue = $('#ClaimDetail'+datecurrIndex+'VcInvoiceNo').val();
				 curentVcOutletCodevalue = $('#ClaimDetail'+datecurrIndex+'VcOutletCode').val();
				
				
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
						$.trim(value)!=''
						) {

                    //        returnPass = false;
					$('#ClaimDetail'+datecurrIndex+'VcInvoiceNo').val('');
					$(commonPopupObj).find('#messageshow').html('Invoice already exsist.');
					$(commonPopupObj).css('display', 'block');
                   
                            //return false;

                        }

                    }

                });
				}
				
				if(currIndex>=0){
				 
				curentdatevalue = $('#ClaimDetail'+currIndex+'DtInvoiceDate').val();
				curentVcInvoiceNovalue = $('#ClaimDetail'+currIndex+'VcInvoiceNo').val();
			    curentVcOutletCodevalue = $('#ClaimDetail'+currIndex+'VcOutletCode').val();
				
				
				$(Obj).each(function(){
					
					runObjIndex  = parseInt($(Obj).index(this));
					notcurentdatevalue = $('#ClaimDetail'+runObjIndex+'DtInvoiceDate').val();
					notcurentVcOutletCodevalue = $('#ClaimDetail'+runObjIndex+'VcOutletCode').val();
					
					if( currIndex != runObjIndex ){
					
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

                          //  returnPass = false;
					$('#ClaimDetail'+currIndex+'VcInvoiceNo').val('');
					$(commonPopupObj).find('#messageshow').html('Invoice already exsist.');
					$(commonPopupObj).css('display', 'block');
                            //return false;
                        }					
					}				
				});				
				}				
			}
			
			return returnPass;
		
		}, ' Alread used ');
		
		/*
		function deleteFileAjax(){
		
		var r = confirm('Are you sure you want to deletefile ');
		if(r== true){
			alert('good');
			return false;
		}else{alert('bad');
			return false;
		
		}return true;
		
		}
		
		$(addobject).find("input[name *='vc_invoice_no']").bind("keypress",function(){
			//alert("User clicked on 'foo.'");
			var Rowid = parseInt($(this).attr('id').split("ClaimDetail")[1], 11);
			var saveindex_id =parseInt($('#saveindex_id').val());
		    //	alert(Rowid);
			if(Rowid<=saveindex_id){
					deleteFileAjax();
					alert(saveindex_id);
			}
			else{
			
			}			
		});
		$(addobject).find("input[name*='dt_invoice_date']").datepicker("onSelect",function(){
			//alert("User clicked on 'foo.'");
			var Rowid = parseInt($(this).attr('id').split("ClaimDetail")[1], 11);
			var saveindex_id =parseInt($('#saveindex_id').val());
		    //	alert(Rowid);
			if(Rowid<=saveindex_id){
					deleteFileAjax();
					alert(saveindex_id);
			}
			else{
			
			}			
		});
		*/
		
		
		$(addobject).find("input[name *='vc_invoice_no']").each(function(){
			
			var Rowid = parseInt($(this).attr('id').split("ClaimDetail")[1], 11);
			var saveindex_id =parseInt($('#saveindex_id').val());
			//alert(Rowid);
			//alert(saveindex_id+'--saveindex_id');
			if(saveindex_id <= Rowid){
			
				//alert('hua');
			
			}else{
			
			$(this).rules("add",{
			required 			: true,
			alphanumeric        : true,
			maxlength			: 15,			
			getUniqueNo			: true,
			remote: {						
						url: GLOBLA_PATH+"flr/claims/getInvoiceCheck/",
						type: "post",
						data:{
							
							ClaimHeaderVcClaimNo :function(){
							
							return $('#ClaimHeaderVcClaimNo').val()
							
							},
						
							ClaimHeaderVcInvoicedate :function(){
							
								return $('#ClaimDetail'+Rowid+'DtInvoiceDate').val()
							
							},
							ClaimHeaderVcOutletCode :function(){
						
								return $('#ClaimDetail'+Rowid+'VcOutletCode').val()
							},
							ClaimHeaderVcInvoiceid :function(){
							return $('#ClaimDetail'+Rowid+'VcClaimDtId').val()
							},
							
						}
						
					},
			
			messages : {

				required	: 	'Required',
				alphanumeric:   'Alpha<br>numeric<br>only',
				maxlength:   'Please<br>enter less than 15.',
				remote :'Already used'

			}});		
		
		}
		});
		
	
		$(addobject).find("input[name*='dt_invoice_date']").each(function(){
		
			$(this).rules("add",{

			required 	: true,
			
			date		: true,
			
			maxlength	: 15,
			getUniqueNo: true,        
			
			messages : {

				required	: 	'Required'
				

			}});		
		
		
		});
		
		
		
		$(addobject).find("input[name*='nu_litres']").each(function(){
		
			$(this).rules("add",{
			
			required 			: true,            
			positiveNumber		: true,			
			maxlength			: 10,            
			//onlyNumberWithoutFloat	: true,	
								
			messages : {

				required	: 	'Required'
				

			}});
        
		});	

      
		$(addobject).find("input[name*='vc_reasons']").each(function(){
		
			$(this).rules("add",{

				maxlength			: 200,

			});			
		
		});	
		
		$(addobject).find("input[type='file']").each(function(){
		
			$(this).rules("add",{
			
				required:{
					depends:function (){
					
					if($('#posted_data_id').val()=='SAVE'){
						return false;
					}else{
						return true;
					}					
				}},
				
				accept:true,
				
				filesize:true,
				
				messages: { 
				
					required	: 	'Please upload document'
				}
            
			});			
		
		});	
	
	}

	
	/*Set DatePicker At Run time and After new row add*/
	
	setDatePicker();
	
	/* Apply Validate rule before and after a new add */
	
	validate();
	
	/********Add Row**************/
    $(obj).find('#addrow').click(function() {

        var setMinNo = 1;
			
        var rowCount = $(obj).find('#table_row_claims_id').find('tr').length;
		//alert(rowCount);      
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
					 $(addobject).find('tr:last').after(data);

					// alert(rowCountId);
                    /*Set DatePicker At Run time and After new row add*/
					//$(addobject).find('tr').('#loadingrow').remove();		
					
					//var row = $(obj).find('#table_row_claims_id').find('tr').length;
				//	alert(rowCountId);
				/* Apply Validate rule before and after a new add */
                   if (rowCountId > 1) {
						$('#loadingrow').remove();					
					}
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
	 		   
	 var id = $(this).attr('title');
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
	/*************Delete Row *************/
	$(obj).find('#rmrow').click(function(){
		var setDefautShow = 1;
		
		var rowCount = $(obj).find('.innerbody:eq(1)').find('table tbody tr').length;
				

		var addobject = $(obj).find('.innerbody:eq(1)').find('table tbody');
		
		/*if( setDefautShow !==  rowCount ) { 				
		
			$(addobject).find('tr:last').remove();				
		}*/
		
		if(rowCount >setDefautShow) { 				
			totalamtdisplay(rowCount);
			$(addobject).find('tr:last').remove();				
		}
    });
	
	
	var dateDiff = function ( d1, d2 ) {
    var diff = Math.abs(d1 - d2);
    if (Math.floor(diff/86400000)) {
        return Math.floor(diff/86400000) + " days";
    } else if (Math.floor(diff/3600000)) {
        return Math.floor(diff/3600000) + " hours";
    } else if (Math.floor(diff/60000)) {
        return Math.floor(diff/60000) + " minutes";
    } else {
        return "< 1 minute";
    }
};

});



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


$('#submitbuttonid').click(function(event) { 

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
			
			if($(obj).valid()==true){
			
			if ($(obj).find('input[type ="submit"]').length > 0) {

            $(obj).find('input[type ="submit"]').attr('disabled', 'disabled');
			}

			if ($(obj).find('button[type ="submit"]').length > 0) {

				$(obj).find('button[type ="submit"]').attr('disabled', 'disabled');
			}
			
			$('#ClaimFlrSaveForm').submit();
			return true;
			}			
			}
			return false;		
			
			});
			
	$('#savebuttonid').on('click',function(event) { 
		var errroMessage = false;	
		var buttonObject='#ClaimMultipleDOCID';
		if($('#ClaimHeaderSinglefileuploadID').is(':checked')==true){
		//alert(obj.find('.uploadify-queue-item').length);
		
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
			if($(obj).valid()==true){
			
			if ($(obj).find('input[type ="submit"]').length > 0) {

            $(obj).find('input[type ="submit"]').attr('disabled', 'disabled');
			}

			if ($(obj).find('button[type ="submit"]').length > 0) {

				$(obj).find('button[type ="submit"]').attr('disabled', 'disabled');
			}
			$('#ClaimFlrSaveForm').submit();
			return true;
			}}	
			return false;
			
			});
			

/*$('form#ClaimFlrEditForm').bind('submit', function(e) {
		if($(obj).valid()==true){
		    
			$('.submit').attr('disabled', 'disabled');    
			return true;
			}

	});*/