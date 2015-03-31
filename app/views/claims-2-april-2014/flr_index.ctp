<?php $currentUser = $this->Session->read('Auth'); ?>
<!-- Start wrapper here-->
<div class="wrapper">
    <!-- Start breadcrumb here-->
    <div class="breadcrumb">
        <ul>
            <li class="first">
                <?php echo $this->Html->link('Home', array('controller' => 'clients', 'action' => 'view', 'flr' => true), array('title' => 'Home', 'class' => 'vtip')) ?>
            </li>
            <li class="last">Client Claim</li>       <li class="last clientnoclass" style=""  >Client No.&nbsp;:&nbsp;<?php echo ltrim($this->Session->read('Auth.Client.vc_client_no'),'01');?></li>   
        </ul>
    </div>
    <!-- end breadcrumb here-->
    <!-- Start mainbody here-->
    <div class="mainbody" style="width:93%" >
        <h1>Welcome to RFA FLR</h1>
        <h3>Claim Processing</h3>
        <!-- Start innerbody here-->
        <?php
        echo $this->Form->create('Claim', array('url' => array('controller' => 'claims',
                'action' => 'index', 'flr' => true), 'type' => 'file'));
        ?>
        <div class="innerbody">
            <table width="100%" border="0" cellpadding="3">
                <tr>
                    <td><label class="lab-inner1">Client Name :</label></td>
                    <td>
                        <?php
                        echo $this->Form->input('ClaimHeader.vc_client_name', array('label' => false,
                            'div' => false,
                            'disabled' => 'disabled',
                            'type' => 'text',
                            'value' => $currentUser['Client']['vc_client_name'],
                            'class' => 'round'));
                        ?>
                    </td>

                    <td valign="top"><label class="lab-inner">Branch Code :</label></td>
                    <td valign="top">
                        <?php
                        echo $this->Form->input('ClaimHeader.vc_branch_code', array('label' => false,
                            'div' => false,
                            'type' => 'text',
                            'disabled' => 'disabled',
                            'value' => $currentUser['ClientBank']['vc_branch_code'],
                            'class' => 'round'
                        ));
                        ?>

                    </td>
                    <td valign="top"><label class="lab-inner">Bank A/C. No. :</label></td>
                    <td valign="top">
                        <?php
                        echo $this->Form->input('ClaimHeader.vc_account_number', array('label' => false,
                            'div' => false,
                            'type' => 'text',
                            'disabled' => 'disabled',
                            'value' => $currentUser['ClientBank']['vc_bank_account_no'],
                            'class' => 'round number-right'
                        ));
                        ?>
                    </td>
                </tr>
                <tr>
                    <td valign="top"><label class="lab-inner">Mobile No. :</label></td>
                    <td valign="top">
                        <?php
                        echo $this->Form->input('ClaimHeader.vc_cell_no', array('label' => false,
                            'div' => false,
                            'type' => 'text',
                            'disabled' => 'disabled',
                            'value' => $currentUser['Client']['vc_cell_no'],
                            'class' => 'round'
                        ));
                        ?>
                    </td>
                    <td valign="top"><label class="lab-inner">A/C. Holder Name :</label></td>
                    <td valign="top">
                        <?php
                        echo $this->Form->input('ClaimHeader.vc_account_holder', array('label' => false,
                            'div' => false,
                            'type' => 'text',
                            'disabled' => 'disabled',
                            'value' => 'ClaimHeader.vc_account_holder',
                            'value' => $currentUser['ClientBank']['vc_account_holder_name'],
                            'class' => 'round'
                        ));
                        ?>
                    </td>
                    <td><label class="lab-inner1">Email :</label></td>
                    <td>
                        <?php
                        echo $this->Form->input('ClaimHeader.email_id', array('label' => false,
                            'div' => false,
                            'type' => 'text',
                            'disabled' => 'disabled',
                            'value' => $currentUser['Member']['vc_email_id'],
                            'class' => 'round'));
                        ?>
                    </td>


                </tr>
                <tr>
                    <td valign="top"><label class="lab-inner">Bank Name :</label></td>

                    <td valign="top">
                        <?php
                        echo $this->Form->input('ClaimHeader.vc_bank_name', array('label' => false,
                            'div' => false,
                            'type' => 'text',
                            'disabled' => 'disabled',
                            'value' => $currentUser['ClientBank']['vc_bank_name'],
                            'class' => 'round'
                        ));
                        ?>
                    </td>

                    <td valign="top"><label class="lab-inner">Client Category :</label></td>
                    <td valign="top">
                        <?php
                        echo $this->Form->input('ClaimHeader.vc_cagegory', array('label' => false,
                            'div' => false,
                            'type' => 'text',
                            'disabled' => 'disabled',
                            'value' => $currentUser['ClientHeader']['category'],
                            'class' => 'round'
                        ));
                        ?>   
                    </td>
                    <td valign="top"><label class="lab-inner">Status Of Claim :</label></td>
                    <!--<td valign="top"><input type="text" class="round" /></td>-->
                    <td valign="top"><strong>Pending</strong></td>
                </tr>
                <tr>

                    <td><label class="lab-inner1">Process Date :</label></td>
                    <td>
                        <?php
                        echo $this->Form->input('ClaimHeader.dt_party_claim_date', array('label' => false,
                            'div' => false,
                            'type' => 'text',
                            'value' => date('d M Y'),
                            'readonly' => 'readonly',
                            'class' => 'round disabled-field'));
                        ?>
                    </td>
                    <td valign="top"><label class="lab-inner">Claim Period From :</label></td>
                    <td valign="top">
                        <?php
                        echo $this->Form->input('ClaimHeader.dt_claim_from', array('label' => false,
                            'div' => false,
                            'type' => 'text',
                            'readonly' => 'readonly',
                            'class' => 'round'
                        ));
                        ?>
                    </td>
                    <td valign="top"><label class="lab-inner">Claim Period To :</label></td>
                    <td valign="top">
                        <?php
                        echo $this->Form->input('ClaimHeader.dt_claim_to', array('label' => false,
                            'div' => false,
                            'type' => 'text',
                            'readonly' => 'readonly',
                            'class' => 'round'
                        ));
                        ?>
                    </td>
                </tr>
				<tr>
				<td valign="top"><label class="lab-inner">Claim No. :</label></td>
				<td valign="top">
				<?php
					echo $this->Form->input('ClaimHeader.vc_party_claim_no', array('label' =>false,
							'div' => false,
                            'type' => 'text',
                            'maxlength' => 20,
							'required' =>'required',
                            'class' => 'round'
					));
				?>
				</td>
				
				<td valign="top" align="left"><label class="lab-inner"><!--Client No.-->&nbsp;</label></td>
				<td valign="top"><?php // echo $this->Session->read('Auth.Client.vc_client_no');?>
					<?php /*Single Upload :
					echo $this->Form->checkbox('ClaimHeader.singlefileuploadID', array('div'=>false,
					'onclick'=>'multiple_hide();'
					));
				*/
						?>
						
							
				</td>
				<td valign="top" > <?php /*
                        echo $this->Form->button('Upload', array('label' => false,
                            'div' => false,
                            'id'=>'ClaimMultipleDOCID' ,
							'style'=>"display:none;",
                            'tabindex'=>'10',
                            'onclick' => 'uploaddocsAllFiles(\'uploadDocsvehicle0\',0);',
                            'type' => 'button',
                            'class' => 'round3'));*/
                        ?>	</td>
				<td valign="top">
				
				
				</td>
				</tr>
            </table>
        </div>
        <!-- end innerbody here-->
        <!-- Start innerbody here-->
		<!--<div   style="overflow-y:scroll;">
            <table width="100%" cellspacing="1" cellpadding="5" border="1" >
			 <tr>
			 <td></td>
			 </tr>
			</table>
		</div>-->
		<table  width="100%" cellspacing="1" cellpadding="5" border="0" >
			
			<tr class="cont1">
			<td  colspan="10" style="width:75%;"valign='top' align="right">&nbsp;
			</td>
			
				<td valign="top" style="width:10%;text-align:right;" ><label class="lab-inner">Single Upload :</label></td>
				<td valign="top" style="width:5%;text-align:center;">&nbsp;&nbsp;
					<?php
					echo $this->Form->checkbox('ClaimHeader.singlefileuploadID',
					array('div'=>false,
					'onclick'=>'multiple_hide();'
					));				
						?>							
				</td>
				<td valign="top" style="width:10%;text-align:center;"> <?php
                        echo $this->Form->button('Upload', array('label' => false,
                            'div' => false,
                            'id'=>'ClaimMultipleDOCID' ,
							'style'=>"display:none;",
                            'tabindex'=>'10',
                            'onclick' => 'uploaddocsAllFiles(\'uploadDocsvehicle0\',0);',
                            'type' => 'button',
                            'class' => 'round3'));
                        ?></td>
			</tr>
			</table>
        <div class="innerbody" style="overflow-y:scroll;">
            <table width="100%" cellspacing="1" cellpadding="5" border="0" >
                <thead width="100%" cellspacing="1" cellpadding="5" border="1" >
                    <tr class="listhead">
                        <td width="8%" valign='center'>Fuel Outlets</td>
                        <td width="8%" valign='center'>Invoice No.</td>
                        <td width="8%" valign='center' >Invoice Date</td>
                        <td width="7%" valign='center' >Litres</td>
                        <td width="7%" valign='center' >Effect Date</td>
                        <td width="7%" valign='center' >Refund %</td>
                        <td width="7%" valign='center' >Admin Fee %</td>
                        <td width="7%" valign='center' >Refund Rate</td>
                        <td width="7%" valign='center' >Admin Fee</td>
                        <td width="7%" valign='center' >Amount (N$)</td>
                        <td width="6%" valign='center' >Rejection</td>
                        <td width="9%" valign='center' >Reason</td>
                        <td width="10%" valign='center' >Upload Invoice</td>
                    </tr>
                </thead>
                <tbody width="100%" cellspacing="1" id='table_row_claims_id' cellpadding="5" border="1" >
                    <tr class="cont1">
                        <td   valign='top' >
                            <?php
                            echo $this->Form->input('ClaimDetail.0.vc_outlet_code', array('div' => false,
                                'label' => false,
                                'type' => 'select',
                                'default' => '',
                                'options' => array('' => 'Select') + $flrFuelOutLet,
                                'class' => 'round_select1 changevalidations'
                            ));
                            ?>
                        </td>
                        <td  valign='top' >
                            <?php
                            echo $this->Form->input('ClaimDetail.0.vc_invoice_no', array('label' => false,
                                'div' => false,
                                'type' => 'text',
                                'maxlength' => '15',
                                'style' => 'width:67px;',
                                'class' => 'round3 changevalidations'
                            ));
                            ?>
                        </td>
                        <td valign='top' >
                            <?php
                            echo $this->Form->input('ClaimDetail.0.dt_invoice_date', array('label' => false,
                                'div' => false,
                                'type' => 'text',
                                'style' => 'width:67px;',
                                'readonly' => 'readonly',
                                'class' => 'round3 '
                            ));
                            ?>
                        </td>
                        <td  valign='top' >
                            <?php
                            echo $this->Form->input('ClaimDetail.0.nu_litres', array('label' => false,
                                'div' => false,
                                'type' => 'text',
                                'maxlength' => '12',
                                'style' => 'width:67px;',
                                'class' => 'round3 number-right changevalidations'
                            ));
                            ?>
                        </td>

                        <td  valign='top' >
                            <?php
                            $effectiveDate = !empty($refundData['ClaimprocessData']['dt_effective_date']) ? date('d M Y', strtotime($refundData['ClaimprocessData']['dt_effective_date'])) : '';
                            echo $this->Form->input('ClaimDetail.0.dt_effective_date', array('label' => false,
                                'div' => false,
                                'type' => 'text',
                                'readonly' => true,
                                'style' => 'width:67px;',
                                'value' => $effectiveDate,
                                'class' => 'round3 disabled-field'
                            ));
                            ?>
                        </td>
                        <td valign='top' >
                            <?php
                            echo $this->Form->input('ClaimDetail.0.nu_refund_prcnt', array('label' => false,
                                'div' => false,
                                'type' => 'text',
                                'maxlength' => '5',
                                'style' => 'width:67px;',
                                'readonly' => true,
                                'value' => $refundData['ClaimprocessData']['nu_refund_prcnt'],
                                'class' => 'round3 number-right disabled-field'
                            ));
                            ?>
                        </td>
                        <td valign='top' >
                            <?php
                            echo $this->Form->input('ClaimDetail.0.nu_admin_fee_prcnt', array('label' => false, 'div' => false,
                                'type' => 'text',
                                'readonly' => 'readonly',
                                'style' => 'width:67px;',
                                'value' => $refundData['ClaimprocessData']['nu_admin_fee'],
                                'class' => 'round3 number-right disabled-field'
                            ));
                            ?>
                        </td>
                        <td valign='top' >
                            <?php
                            echo $this->Form->input('ClaimDetail.0.nu_refund_rate', array('label' => false,
                                'div' => false,
                                'type' => 'text',
                                'readonly' => 'readonly',
                                'style' => 'width:67px;',
                                'value' => $refundRateValue,
                                'class' => 'round3 number-right disabled-field'
                            ));
                            ?>
                        </td>
                        <td valign='top' >
                            <?php
                            echo $this->Form->input('ClaimDetail.0.nu_admin_fee', array('label' => false,
                                'div' => false,
                                'type' => 'text',
                                'maxlength' => '12',
                                'readonly' => true,
                                'style' => 'width:67px;',
                                'class' => 'round3 number-right disabled-field'
                            ));
                            ?>
                        </td>
                        <td valign='top' >
                            <?php
                            echo $this->Form->input('ClaimDetail.0.nu_amount', array('label' => false,
                                'div' => false,
                                'type' => 'text',
                                'maxlength' => '12',
                                'readonly' => true,
                                'style' => 'width:67px;',
                                'class' => 'round3 number-right disabled-field'
                            ));
                            ?>

                        </td>
                        <td valign='top' >
                            <div id='ch_rejected_td_0'>
                                <?php
                                echo $this->Html->image('without-check.jpg', array('alt' => ''));
                                /* echo $this->Form->checkbox('ClaimDetail.0.ch_rejected', array('label' => false,
                                  'div' => false,
                                  'class' => 'round3 disabled-field',
                                  'style'=>'width:67px;',
                                  'value'=>'1'

                                  )); */
                                ?></div>
                        </td>
                        <td valign='top' >
                            <div>
                                <div  style="float:left;" id="<?php echo 'ClaimDetail0VcReasonsDiv'; ?>">
                                </div>						
                                <div> <?php
                                    echo $this->Form->hidden('ClaimDetail.0.vc_reasons', array('label' => false,
                                        'div' => false,
                                        'class' => 'round3 disabled-field',
                                        'style' => 'width:67px;',
                                    ));

                                    echo $this->Html->image('remarks.jpg', array('alt' => '', 'id' => 'showreason_id_0'
                                        , 'title' => 'View Remarks',
                                        'name' => 'showreason_0',
                                        'style' => ' cursor: pointer;display:none;'));
                                    ?>
                                </div>
                            </div>
                        </td>
                        <td  valign='top' >
                            <?php
                            echo $this->Form->input('InvoiceClaimDoc.0', array('label' => false,
                                'div' => false,
                                'type' => 'file',
                                'id' => 'updoc0',
                                'tabindex' => '10',
                                'class' => 'uploadfile'));
								?>
                           
                        </td>
						
                    </tr>
                </tbody>
				<?php
                    echo $this->Form->input('posted_data', array('label' => false,
                        'div' => false,
                        'id' => 'posted_data_id',
                        'type' => 'hidden',
                        'class' => 'round'));
                  ?>
                <tfoot>
                    <tr style="background-color:#eee;">
                        <td colspan="9" style="text-align:right;" >Total</td>
                        <td  style="text-align:right;"><div id='showtotalamount_id' > 00.00 </div> </td>
                        <td  >&nbsp;</td><td  >&nbsp;</td>
                        <td  >&nbsp;</td>
                    </tr>
                </tfoot>
            </table>
        </div>
        <table width="100%" border="0">
            <tr>
                <td  valign='top' align="center">
                    <?php
                    echo $this->Form->button('Add', array('label' => false,
                        'div' => false,
                        'id' => 'addrow',
                        'type' => 'button',
                        'class' => 'submit'));
                    ?>
                    &nbsp;&nbsp;&nbsp;&nbsp;
                    <?php
                    echo $this->Form->button('Remove', array('label' => false,
                        'div' => false,
                        'id' => 'rmrow',
                        'type' => 'button',
                        'class' => 'submit'));
                    ?>
                    &nbsp;&nbsp;&nbsp;&nbsp;			
                    <?php
                    echo $this->Form->submit('Save', array('label' => false,
                        'div' => false,
                        'id' => 'save',
						'name'=>'Save',
						'onClick' => "posteddata('SAVE');",
                        'type' => 'submit',
                        'class' => 'submit'));
                    ?>			
					&nbsp;&nbsp;&nbsp;&nbsp;			
                    <?php
                    echo $this->Form->submit('Submit', array('label' => false,
                        'div' => false,
                        'id' => 'submit',
						'name'=>'Submit',	
						'onClick' => "posteddata('SUBMIT');",					
                        'type' => 'submit',
                        'class' => 'submit'));
                    ?>	
                </td>
            </tr>
			
			<tr><td>
			<div id="uploadDocsvehicle0" class="ontop">

			<div id="popup0" class="popup2">

            <a href="javascript:void(0);" class="close" onClick='hidepop("uploadDocsvehicle0");' >Close</a>   

           
            <table width="100%" border="0" cellpadding="0" cellspacing="0" align="center">
                
				<tr>
					
					<td valign ='top' colspan='2' align="left" class="content-area">
						<div class="listhead-popup">Upload Document</div>
					</td>

				</tr>

				<tr>

					<td colspan='2' valign ='top' align="left">
						<div class="file-format" >Pdf, Png, Jpeg, Jpg,Gif File Could be uploaded.
						<strong>2 MB</strong> is the maximum size for upload </div>
					</td>

				</tr>

                <tr>
                    <td  valign ='top'  width="100%" align="left">
                <div class="content-area-outer">

					<div class="upload-button"></div>

					<div id="queue"></div>
					<div id="filesdata"></div>
				<input id="file_upload" name="file_upload" type="file" multiple="true">
				<?php
                        echo $this->Form->input('Multiple', array('label' => false,
                            'div' => false,
                            'type' => 'file',
							'style'=>'display:none',
                            'class' => 'uploadfile'));
                        ?>
                        </div>
                    </td>
                </tr>
            </table>       

        </div>
    </div>
			</td></tr>
        </table>
        <!-- end innerbody here-->  
        <?php echo $this->Form->end(); ?>
    </div>
    <!-- end mainbody here-->    
</div>
<!-- end wrapper here-->
<?php echo $this->element('commonmessagepopup'); ?>
<?php echo $this->element('commonbackproceesing'); ?>
<?php echo $this->Html->css('uploadify'); ?>
<?php echo $this->Html->script('jquery.uploadify.min'); 

?><?php $timestamp = time();
						$vc_flr_customer_no = $currentUser['Member']['vc_flr_customer_no'];


?>

<?php echo $this->Html->script('flr/addclaimcheck'); ?>
	<script type="text/javascript">
	$(document).ready(function() {
	
	var arrayfileValue = new Array();
	var divarrayswf    = new Array();
    //	alert( GLOBLA_PATH+'flr/claims/uploadall');
	
	var selectedFile = null;
		
    $('#file_upload').uploadify({
	'formData'     : {
					'timestamp' : '<?php echo $timestamp;?>',
					'token'     : '<?php echo md5('unique_salt' . $timestamp);?>',
					'vc_customer_no'     : '<?php echo $vc_flr_customer_no;?>',
					
				},
		'swf': GLOBLA_PATH+'uploadify.swf',
		'uploader'    : GLOBLA_PATH+'uploadify.php',
		// 'uploader'    : GLOBLA_PATH+'flr/claims/uploadall',
		//'cancelImg' : '/uploadify/cancel.png',
		'fileSizeLimit': '2048KB',
		'fileTypeExts' : '*.jpg; *.png;*.jpeg;*.pdf;*.gif;',
		'removeCompleted': false,	
		'onUploadSuccess': function(fileObj,response,data){   
	
		arrayfileValue[fileObj.name]=response;
		/*
		console.log("pehle=="+arrayfileValue);
		console.log("pehle1=="+fileObj.name);
		console.log("pehle2=="+response);
		*/
		var i=0;
		var lengthOfswfs=0;
		lengthOfswfs = parseInt($('.uploadify-queue-item').length);
		//alert('lenswfs=='+lengthOfswfs);
		//if(lengthOfswfs==0 || lengthOfswfs=='')
		$('#filesdata').html('');
		
		for(var index in arrayfileValue){			
			var textboxname='data[ClaimHeader][input_allfileupload_values]['+i+']';
		    var inputhiddenfile="<input type='hidden' id='input_allfileupload_values_"+i+"' name='"+textboxname+"' value='"+arrayfileValue[index]+"' />";
		    $('#filesdata').append(inputhiddenfile);
		    i++;
		}
		
    },	
	/*'onQueueComplete':function(){
		var lengthOfswfs = parseInt($('.uploadify-queue-item').length);
		var i=0;
		var arradiv=0;
		$("div[id^= SWFUpload_0]").each(function() {
			
			divarrayswf[arradiv] = $(this).attr('id');
			arradiv++;
		});
		console.log('div---'+divarrayswf);
	//alert(lengthOfswfs);
		
		for (var loopval=0;loopval<lengthOfswfs;loopval++){
		
		var dividswf='#'+divarrayswf[loopval];
		var filepath=$('#input_allfileupload_values_'+loopval).val();		
		var removeItem='';		
		var htmldata="<div id='SWF_0_"+loopval+"' ><a id='hrefID"+loopval+"' href='#' onclick=\"removeItem=$('#input_allfileupload_values_"+loopval+"').val();$('#input_allfileupload_values_"+loopval+"').remove();$('"+dividswf+"').remove();\">Remove</a></div>";		
		$('#'+divarrayswf[loopval]).append(htmldata);		
		
	    arrayfileValue = $.grep(arrayfileValue, function(value) {
				      return value != removeItem;
		             });
	    console.log(arrayfileValue);
		}		
	}*/
	/*
	'onQueueComplete':function(){
			
		
		//$('#filesdata').html('');
		
		
		
		for (var loopval=0;loopval<lengthOfswfs;loopval++){
		
		var dividswf='#'+divarrayswf[loopval];
		var filepath=$('#input_allfileupload_values_'+loopval).val();		
		var removeItem='';		
		var htmldata="<div id='SWF_0_"+loopval+"' ><a id='hrefID"+loopval+"' href='#' onclick=\"removeItem=$('#input_allfileupload_values_"+loopval+"').val();$('#input_allfileupload_values_"+loopval+"').remove();$('"+dividswf+"').remove();\">Remove</a></div>";		
		$('#'+divarrayswf[loopval]).append(htmldata);		
		
	    arrayfileValue = $.grep(arrayfileValue, function(value) {
				      return value != removeItem;
		             });
	    //console.log(arrayfileValue);
		}		
	}
		
    */
    });
	
	
	
	
});


function posteddata(NUM){
//alert(NUM);
$('#posted_data_id').val(NUM);

}
</script>

