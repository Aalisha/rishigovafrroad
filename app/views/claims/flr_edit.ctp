<?php $currentUser = $this->Session->read('Auth');?>
<!-- Start wrapper here-->
<div class="wrapper">
    <!-- Start breadcrumb here-->
    <div class="breadcrumb">
        <ul>
            <li class="first">
                <?php echo $this->Html->link('Home', array('controller' => 'clients', 'action' => 'view', 'flr' => true), array('title' => 'Home', 'class' => 'vtip')) ?>
            </li>
            <li class="last">Client Claim</li>        
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
					'action' => 'edit', 'flr' => true), 'type' => 'file'));
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
                            'class' => 'round'
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
                    <td valign="top"><strong>Rejected</strong></td>
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
							'readonly'=>'readonly',
                            'class' => 'round',
							'value'=>date('d M Y',strtotime($showclaimdetails['ClaimHeader']['dt_claim_from']))
                        ));
                        ?>
                    </td>
                    <td valign="top"><label class="lab-inner">Claim Period To :</label></td>
                    <td valign="top">
                        <?php
                        echo $this->Form->input('ClaimHeader.dt_claim_to', array('label' => false,
                            'div' => false,
                            'type' => 'text',
							'readonly'=>'readonly',
                            'class' => 'round',
							'value'=> date('d M Y',strtotime($showclaimdetails['ClaimHeader']['dt_claim_to']))
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
							'required'=>'required',
							'value'=> $showclaimdetails['ClaimHeader']['vc_party_claim_no'],
                            'class' => 'round'
					));
				?>
				</td>
				<td valign="top"></td>
				<td valign="top">
					
				</td>
				</tr>
               

            </table>

        </div>
		 <?php  $singlefileuploadid = $showclaimdetails['ClaimHeader']['singlefileuploadid'];?>
        <!-- end innerbody here-->
		
       
            <table width="100%" cellspacing="1" cellpadding="5" border="0" >
			<tbody width="100%" cellspacing="1"  cellpadding="5" border="0" >
			<tr class="cont1">
			<td  colspan="10" style="width:75%;"valign='top' align="right">&nbsp;
			<div id='flashversion' style="vertical-align:top;color:red;">&nbsp;</div>
			
			</td>
			
				<td valign="top" style="width:10%;text-align:right;" ><label class="lab-inner">One Time Upload :</label></td>
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
                            'tabindex'=>'10',
							'style'=>"display:none;",
                            'onclick' => 'uploaddocsAllFiles(\'uploadDocsvehicle0\',0);',
                            'type' => 'button',
                            'class' => 'round3'));
							
						
                        ?>	</td>
			</tr></tbody>
			</table>
			
			 <!-- Start innerbody here-->
        <div class="innerbody" style="overflow-y:scroll;">
			<table width="100%" cellspacing="1" cellpadding="5" border="0" >

				<thead width="100%" cellspacing="1"  cellpadding="5" border="1" >
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
						<td width="7%" valign='center' >Amount</td>
						<td width="6%" valign='center' >Rejection</td>
						<td width="9%" valign='center' >Reason</td>
						<td width="10%" valign='center' >Upload Invoice</td>
					</tr>
				</thead>
				<tbody width="100%" id='table_row_claims_id' cellspacing="1" cellpadding="5" border="1" >
					<?php
                        echo $this->Form->hidden('ClaimHeader.vc_claim_no', array('label' => false,
                            'div' => false,
                            'class' => 'round',
							'value'=>base64_encode($claim_no)						
							));
                        
					$totalamt = 0;
					
					echo $this->Form->hidden('ClaimDetailnumofrows', array('label' => false,
                            'div' => false,
                            'class' => 'round',
							'value'=>count($showclaimdetails['ClaimDetail'])					
							));
					foreach($showclaimdetails['ClaimDetail'] as $index =>$value) {
					
			?>
					<tr class="cont1">
                        <td   valign='top' >
                            <?php
							
					echo $this->Form->hidden('ClaimDetail.'.$index.'.vc_claim_dt_id', array('label' => false,
                            'div' => false,
                            'class' => 'round',
							'value'=>base64_encode($value['vc_claim_dt_id'])					
							));
							
                            echo $this->Form->input('ClaimDetail.'.$index.'.vc_outlet_code', array('div' => false,
                                'label' => false,
                                'type' => 'select',
                                'default' => $value['vc_outlet_code'],
                                'options' => array('' => 'Select') + $flrFuelOutLet,
                                'class' => 'round_select1'								
                            ));
                           ?>

                        </td>
                        <td  valign='top' >
                            <?php
                            echo $this->Form->input('ClaimDetail.'.$index.'.vc_invoice_no', array('label' => false,
                                'div' => false,
                                'type' => 'text',
                                'maxlength' => '15',
								'style'=>'width:67px;',
								'class' => 'round3',
								'value'=>$value['vc_invoice_no']
                            ));
                            ?>

                        </td>

                        <td valign='top' >
                            <?php
                            echo $this->Form->input('ClaimDetail.'.$index.'.dt_invoice_date', array('label' => false,
                                'div' => false,
                                'type' => 'text',
								'style'=>'width:67px;',
                                'class' => 'round3',
								'readonly' =>'readonly',
								'value'=>date('d M Y',strtotime($value['dt_invoice_date']))
                            ));
                            ?>
                        </td>

                        <td  valign='top' >
                            <?php
                            echo $this->Form->input('ClaimDetail.'.$index.'.nu_litres', array('label' => false,
                                'div' => false,
                                'type' => 'text',
                                'maxlength' => '12',
								'style'=>'width:67px;',
                                'class' => 'round3 number-right',
								'value'=>$value['nu_litres']
                            ));
                            ?>
                        </td>

                        <td  valign='top' >
						<?php
						$effectiveDate = !empty($refundData['ClaimprocessData']['dt_effective_date'])?date('d M Y',strtotime($refundData['ClaimprocessData']['dt_effective_date'])):'';
						 echo $this->Form->input('ClaimDetail.'.$index.'.dt_effective_date', array('label' => false,
                                'div' => false,
                                'type' => 'text',
                                'readonly'=>true,
								'style'=>'width:67px;',
                               'value'=>date('d M Y',strtotime($value['dt_effective_date'])),
                                'class' => 'round3 disabled-field'
                            ));
                            ?>
                        </td>

                        <td valign='top' >
                            <?php
                            echo $this->Form->input('ClaimDetail.'.$index.'.nu_refund_prcnt', array('label' => false,
                                'div' => false,
                                'type' => 'text',
								'maxlength' => '5',
								'style'=>'width:67px;',
                                'readonly'=>true,
                                'value' => $refundData['ClaimprocessData']['nu_refund_prcnt'],
                                'class' => 'round3 disabled-field number-right'
                            ));
                            ?>
                        </td>

                        <td valign='top' >
                            <?php
                            echo $this->Form->input('ClaimDetail.'.$index.'.nu_admin_fee_prcnt', 
									array('label' => false,'div' => false,
									'type' => 'text',
									'readonly'=>'readonly',
									'style'=>'width:67px;',
									'value'=>$value['nu_admin_fee_prcnt'], 		
									'class' => 'round3 disabled-field number-right'
                            ));
					
                            ?>
                        </td>
                        <td valign='top' >
                            <?php
                            echo $this->Form->input('ClaimDetail.'.$index.'.nu_refund_rate', array('label' => false,
                                'div' => false,
                                'type' => 'text',
                                'readonly'=>'readonly',
								'style'=>'width:67px;',
                                'value' => $refundRateValue,
                                'class' => 'round3 disabled-field number-right'
                            ));
                            ?>
                        </td>
                        <td valign='top' >
                            <?php
                            echo $this->Form->input('ClaimDetail.'.$index.'.nu_admin_fee', array('label' => false,
                                'div' => false,
								'value'=>$value['nu_admin_fee'],
                                'type' => 'text',
                                'maxlength' => '12',
								'readonly'=>true,  
								'style'=>'width:67px;',								
								'class' => 'round3 disabled-field number-right'
                            ));
                            ?>
                        </td>

                        <td valign='top' >
                            <?php
					 	//$totalamt=$value['nu_amount']+$totalamt;
						$totalamt= (float)$totalamt + (float)$value['nu_amount'];

							echo $this->Form->input('ClaimDetail.'.$index.'.nu_amount', array('label' => false,
											'div' => false,
											'value'=>$value['nu_amount'],
											'type' => 'text',
											'maxlength' => '12',
											'readonly'=>true,
											'style'=>'width:67px;',								
											'class' => 'round3 disabled-field number-right'
											));
											
											//$totalamt  =$totalamt +(float)$value['nu_amount'];
                            ?>

                        </td>
                        <td valign='top' ><?php //echo 'ch--'.$value['ch_rejected']; ?>
							<div id='ch_rejected_td_<?php echo $index?>'>                           
						   <?php
						
							if($value['ch_rejected']=='Y'){
							
								echo $this->Html->image('with-check.jpg', array('alt' => '', ));
							
							} else {
							
								echo $this->Html->image('without-check.jpg', array('alt' => '', ));
								
							}
							
                          
                            ?>
							</div>
                        </td>
                        <td valign='top' >
						<div>
						
						<div style="float:left;" id="<?php echo 'ClaimDetail'.$index.'VcReasonsDiv';?>">
						<?php 
						 if($value['ch_rejected']=='Y')
						echo substr($value['vc_reasons'],0,10).'...';?>&nbsp;
						</div>
						<div>
						<?php 
							 if($value['ch_rejected']=='Y'){
							 echo $this->Html->image('remarks.jpg', array('alt' => '', 'id'=>'showreason_id_'.$index, 'title'=>'View Remarks',
							 'name'=>'showreason_'.$index,
							 'style'=>' cursor: pointer;')); 
							 
							 } else {
							 
							 echo $this->Html->image('remarks.jpg', array('alt' => '', 'id'=>'showreason_id_'.$index, 'title'=>'View Remarks',
							 'name'=>'showreason_'.$index,
							 'style'=>' cursor: pointer;display:none;'));
							
							}									 
							 
							 
							 ?>
							<?php
                            echo $this->Form->hidden('ClaimDetail.'.$index.'.vc_reasons', array('label' => false,
                                'div' => false,
								'value'=>$value['vc_reasons'],
                                'class' => 'round3 disabled-field',
								'style'=>'width:67px;',
                            ));
							
                            
                            ?>
							</div>
						</div>&nbsp;
			
                        </td>
						
                        <td  valign='top' >
                            <?php
                            echo $this->Form->input('InvoiceClaimDoc.'.$index, array('label' => false,
                                'div' => false,
                                'type'=>'file',
                                'id' => 'updoc'.$index,
                                'tabindex' => '10',
                                'class' => 'uploadfile'));
                            ?>
                        </td>
                    </tr>
					<?php } ?>
				</tbody>
				
				<tfoot>
					<tr style="background-color:#eee;">
						<td width="8%"></td>
						<td width="8%">&nbsp;</td>
						<td width="8%">&nbsp;</td>
						<td width="7%">&nbsp;</td>
						<td width="7%">&nbsp;</td>
						<td width="7%">&nbsp;</td>
						<td width="7%">&nbsp;</td>
						<td width="7%">&nbsp;</td>
						<td width="7%">Total&nbsp;</td>
						<td width="7%"><div id='showtotalamount_id'  class='number-right showamt' > 
						<?php echo number_format($totalamt,2,'.',',');?> </div> </td>
						<td width="6%">&nbsp;</td>
						<td width="9%">&nbsp;</td>
						<td width="10%">&nbsp;</td>
					</tr>
				</tfoot>
				
            </table>
        </div>
		 <table width="100%" border="0">
				
				<tr>
					<td  valign='top' align="center">

						<?php
					/*	echo $this->Form->button('Add', array('label' => false,
							'div' => false,
							'id' => 'addrow',
							'type' => 'button',
							'class' => 'submit'));*/
						?>

						&nbsp;&nbsp;&nbsp;&nbsp;

						<?php
					/*	echo $this->Form->button('Remove', array('label' => false,
							'div' => false,
							'id' => 'rmrow',
							'type' => 'button',
							'class' => 'submit'));*/
						?>


						&nbsp;&nbsp;&nbsp;&nbsp;			
						<?php
						echo $this->Form->button('Submit', array('label' => false,
							'div' => false,
							'id' => 'submitclaimid',
							'type' => 'submit',
							'class' => 'submit'));
						?>			
					</td>
					

				</tr>
				
							<tr><td>
			<div id="uploadDocsvehicle0" class="ontop">

			<div id="popup0" class="popup2" style="width:500px;height:330px;" >

            <a href="javascript:void(0);" class="close" onClick='hidepop("uploadDocsvehicle0");' >Close</a>   

           
            <table width="100%" border="0" cellpadding="0" cellspacing="0" align="center">
                
				<tr>					
					<td valign ='top' colspan='2' align="left" class="content-area">
						<div class="listhead-popup">Upload Document</div>
					</td>
				</tr>
				<tr>
					<td colspan='2' valign ='top' align="left">
						<div class="file-format" >Pdf, Png, Jpeg, Jpg  File Could be uploaded.
						<strong>2 MB</strong> is the maximum size for upload </div>
					</td>
				</tr>

                <tr>
                    <td  valign ='top'  width="100%" align="left">
                        <div class="content-area-outer">
							<input id="file_upload" name="file_upload" type="file" multiple="true">
                            <div class="upload-button"> </div>
							<div id="queue"></div>
							<div id="filesdata"></div>
				
							
				<?php 
				$cnt=0;
				if($singlefileuploadid==1){
				?>
				<div>
				<table>
				<?php 
				$InvoicedocdetailssingleValue =	
				$this->Invoicedocdetails->singlegiveDocdetails($showclaimdetails['ClaimHeader']['vc_claim_no']);
				
				if(count($InvoicedocdetailssingleValue)>0){
				
				foreach($InvoicedocdetailssingleValue as $index=>$value){
				
				?>
				<!--<tr id="rowIDdelete_<?php echo $value['InvoiceClaimDoc']['vc_upload_id'];?>">
				<td><?php echo $value['InvoiceClaimDoc']['vc_uploaded_doc_name'];?></td>
				<td>
				<?php echo $this->Html->link('View', array('controller' => 'claims', 'action' => 'viewfile','flr' =>true,$value['InvoiceClaimDoc']['vc_upload_id']), array('title' => 'View File')) ?>&nbsp;&nbsp;&nbsp;
				
				<a  rel="<?php echo $value['InvoiceClaimDoc']['vc_upload_id'];?>" href="javascript:void(0)" id="deletefileID<?php echo $value['InvoiceClaimDoc']['vc_upload_id'];?>" title= "<?php echo base64_encode($value['InvoiceClaimDoc']['vc_upload_id']);?>">Delete</a>
				<?php // echo $this->Html->link('Delete', array(), array('title' => base64_encode($value['InvoiceClaimDoc']['vc_upload_id']),'id'=>'deletefileID'))
				?>
				<?php //echo $js->link('title', 'url', array('update'=>'mydiv'))?>				
				<input type='hidden'  name="data['ClaimHeader']['input_allfileupload_values'][<?php echo $cnt;?>]" value="<?php echo $value['InvoiceClaimDoc']['vc_uploaded_doc_name'];?>">			
		    	</td>
				</tr>-->
				<?php 
				 $cnt++;
				}
				}
				?>
				<tr>
				<td></td>
				<td></td>
				</tr>
				</table>
				</div>
				<?php }
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

<?php echo $this->Html->script('flr/editclaimscheck'); ?>
<?php echo $this->Html->css('uploadify'); ?>
 <?php echo $this->Html->script('jquery.uploadify.min'); 
 $timestamp = time();
 $vc_flr_customer_no = $currentUser['Member']['vc_flr_customer_no'];
 ?>

	<script type="text/javascript">
	$(document).ready(function() {
function getFlashVersion(){
		try {
		try {
      
      var axo = new ActiveXObject('ShockwaveFlash.ShockwaveFlash.6');
		try { axo.AllowScriptAccess = 'always'; }
			catch(e) { return '6,0,0'; }
		} catch(e) {}
		return new ActiveXObject('ShockwaveFlash.ShockwaveFlash').GetVariable('$version').replace(/\D+/g, ',').match(/^,?(.+),?$/)[1];
	// other browsers
	} catch(e) {
		try {
		  if(navigator.mimeTypes["application/x-shockwave-flash"].enabledPlugin){
			return (navigator.plugins["Shockwave Flash 2.0"] || navigator.plugins["Shockwave Flash"]).description.replace(/\D+/g, ",").match(/^,?(.+),?$/)[1];
		  }
		} catch(e) {}
	  }
  return '0,0,0';
}

var version = getFlashVersion().split(',').shift();
if(version < 9){

      $('#flashversion').text('Please upgrade the version of flash in order to use single file upload');

   }else{
    //$('#flashversion').text('The current version of flash on system is '+version);
}
	
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
		'fileTypeExts' : '*.jpg; *.png;*.jpeg;*.pdf;',
		'removeCompleted': false,	
		'onUploadSuccess': function(fileObj,response,data){   
	
		arrayfileValue[fileObj.name]=response;		
		var i=0;
		var lengthOfswfs = 0;
		lengthOfswfs = parseInt($('.uploadify-queue-item').length);
		if(lengthOfswfs>0){
			for(var deldivremove=0;deldivremove<lengthOfswfs;deldivremove++){
				$('#SWF_0_'+deldivremove).remove();
			}
		}
		//alert('lenswfs=='+lengthOfswfs);
		//if(lengthOfswfs==0 || lengthOfswfs=='')
		$('#filesdata').html('');
		
			
    },
	
	'onSelect':function(fileDetails){
		//	alert(fileDetails.id);
		// console.log(fileDetails.toSource());
		
		var textdeletehtmlinput ="<input type='hidden' id='divid-"+fileDetails.id+"' value='"+fileDetails.name+"'>";
		$('#'+fileDetails.id).append(textdeletehtmlinput);
		

	},
	'onQueueComplete':function(){
		var lengthOfswfs = parseInt($('.uploadify-queue-item').length);
		var i=0;
		var arradiv=0;
		$("div[id^= SWFUpload_0]").each(function() {
			
			divarrayswf[arradiv] = $(this).attr('id');
			arradiv++;
		});
		
		for(var a in arrayfileValue){
		 //console.log('hidear==='+arrayfileValue[a]);
		 //console.log('hidear=index=='+a);
		}
		for(var index in arrayfileValue){			
			var textboxname='data[ClaimHeader][input_allfileupload_values]['+i+']';
		    var inputhiddenfile="<input type='hidden' id='input_allfileupload_values_"+i+"' name='"+textboxname+"' value='"+arrayfileValue[index]+"' />";
		    $('#filesdata').append(inputhiddenfile);
		    i++;
		}
		var lengthOfswfs = parseInt($('.uploadify-queue-item').length);
			for (var loopval=0;loopval<lengthOfswfs;loopval++){
		
			var dividswf      = '#'+divarrayswf[loopval];
			var Rowid         = parseInt(divarrayswf[loopval].split("SWFUpload_0_")[1], 12);
			var filepath      = $('#input_allfileupload_values_'+loopval).val();		
			var removeItem='';
			
			//$('#SWF_0_'+loopval).html('');
			
			var htmldata="<div class='checkexistswfdiv' id='SWF_0_"+loopval+"' ><a rel='"+divarrayswf[loopval]+"' id='hrefID"+loopval+"' href='#' >Remove</a></div>";
			$('#'+divarrayswf[loopval]).append(htmldata);	
			//	 console.log($(dividswf+' .checkexistswfdiv').length+'--len value=checkexistswfdiv'+dividswf);
			if(parseInt($(dividswf+' .checkexistswfdiv').length) >1){
				$('#SWF_0_'+loopval).remove();
			}
				$("#SWF_0_"+loopval).delegate("#hrefID"+loopval, "click", function () {
				//alert($(this).attr('rel'));
				var relvalue = $(this).attr('rel');
				var indexoffilenew    = '';
				$("input[id *='input_allfileupload_values_']").each(function(){
					//alert($('#divid-'+relvalue).val());
					//alert($(this).val());
					if($.trim($(this).val())==$.trim($('#divid-'+relvalue).val())){
					//console.log('me--id-='+$(this).attr('id'));
						indexoffilenew    = parseInt($(this).attr('id').split("input_allfileupload_values_")[1], 27);
						var textdeletehtmlinputAgain ="<input type='hidden' value='"+indexoffilenew+"'>";
						removeItem=$('#'+$(this).attr('id')).val();
						$.post(GLOBLA_PATH + "flr/claims/deleteajaxuploadify/", { filename: removeItem } );
						arrayfileValue[removeItem]='';
						$('#'+$(this).attr('id')).remove();
						
						$('#'+relvalue).remove();						
						
						//  console.log('me ===removeItem==='+removeItem);
					    //	arrayfileValue.splice(removeItem,1);
						/*
						  arrayfileValue = $.grep(arrayfileValue, function(value) {
						   return (value!=removeItem);
						  });
						 */
						 divarrayswf = $.grep(divarrayswf, function(value) {
						  return (value!=relvalue);
						 });
						// console.log(divarrayswf.toString());

						for(var m in arrayfileValue){
						 //console.log('me ===hidear==='+arrayfileValue[m]);
						}
									//$('#'+relvalue).append(textdeletehtmlinputAgain);
					}
				
				});

				//$('"+dividswf+"').remove();

			});	
			
			}

	}
	
    });
	
	
	
	
});


	</script>
	