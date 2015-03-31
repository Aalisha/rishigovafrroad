<?php $currentUser = $this->Session->read('Auth');?>
<!-- Start wrapper here-->
<div class="wrapper">
    <!-- Start breadcrumb here-->
    <div class="breadcrumb">
        <ul>
            <li class="first">
                <?php echo $this->Html->link('Home', array('controller' => 'clients', 'action' => 'view', 'flr' => true), array('title' => 'Home', 'class' => 'vtip')) ?>
            </li>
            <li class="last">Client Claim</li>      <li class="last clientnoclass"   >Client No.&nbsp;:&nbsp;<?php echo ltrim($this->Session->read('Auth.Client.vc_client_no'),'01');?></li>    
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
					'action' => 'save', 'flr' => true), 'type' => 'file'));
			?>
        <div class="innerbody">
            <table width="100%" border="0" cellpadding="3">
			<tr><td  colspan='4'  style="text-align:right;width:70%;"></td>
			<td style="text-align:right;width:10%;"><label class="lab-inner1">Status Of Claim :</label></td>
			<td><strong>Saved</strong></td></tr>
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
                    <td valign="top"><label class="lab-inner"></label></td>
                    <!--<td valign="top"><input type="text" class="round" /></td>-->
                    <td valign="top"></td>
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
						
                        $singlefileuploadid = $showclaimdetails['ClaimHeader']['singlefileuploadid'];
						//pr($showclaimdetails);
						//pr($showclaimdetails);
						 echo $this->Form->input('ClaimHeader.previousstate', array('label' => false,
						'div' => false,
						'type' => 'hidden',
						'value' => base64_encode($singlefileuploadid)));
				
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
							'value'=> $showclaimdetails['ClaimHeader']['vc_party_claim_no'],
                            'class' => 'round'
					));
				?>
				</td>
				<td valign="top" align="left"><label class="lab-inner"><!--Client No.&nbsp;:--></label></td>
				<td valign="top"><?php //echo $this->Session->read('Auth.Client.vc_client_no');?>
				</tr>

               

            </table>

        </div><?php 
			$InvoicedocdetailssingleValue =	
				$this->Invoicedocdetails->singlegiveDocdetails($showclaimdetails['ClaimHeader']['vc_claim_no']);
			?>
        <!-- end innerbody here-->
		
        <!-- Start innerbody here-->
		<table width="100%" cellspacing="1" cellpadding="5" border="0" >
			<tbody width="100%" cellspacing="1"  cellpadding="5" border="0" >
			<tr class="cont1">
			<td valign='top' style="width:1%;" align="left">
			<?php if($singlefileuploadid!=1){
					?>
			<span class="lab-inner"><b>Note:</b></span>
			<?php }?>
			</td>
			<td valign='top' style="width:70%;" align="left">
			<?php if($singlefileuploadid!=1){					?>
		
			Invoice no. ,Fuel Outlet and Invoice date can be changed after deleting the file.
				<?php }?>
			</td>
			<td  colspan="8" valign='top' style="width:15%;" align="right">&nbsp;
			</td>
			
				<td valign="top" style="width:10%;text-align:right;" ><label class="lab-inner">One time Upload :</label></td>
				<td valign="top" style="width:5%;text-align:center;">&nbsp;&nbsp;
					<?php

					if($singlefileuploadid==1){
					
					echo $this->Form->checkbox('ClaimHeader.singlefileuploadID',array('div'=>false,					
					'checked'=>'checked','onclick'=>'multiple_hide();'));
				}
				else{
					echo $this->Form->checkbox('ClaimHeader.singlefileuploadID',array('div'=>false,
				'onclick'=>'multiple_hide();'));
				
				
				}
						?>
						
							
				</td>
				<td valign="top" style="width:10%;text-align:center;"> <?php
				if($singlefileuploadid==1){
                        echo $this->Form->button('Upload', array('label' => false,
                            'div' => false,
                            'id'=>'ClaimMultipleDOCID' ,							
                            'tabindex'=>'10',
                            'onclick' => 'uploaddocsAllFiles(\'uploadDocsvehicle0\',0);',
                            'type' => 'button',
                            'class' => 'round3'));
							}else{
							
						echo $this->Form->button('Upload', array('label' => false,
                            'div' => false,
                            'id'=>'ClaimMultipleDOCID' ,
							'style'=>"display:none;",
                            'tabindex'=>'10',
                            'onclick' => 'uploaddocsAllFiles(\'uploadDocsvehicle0\',0);',
                            'type' => 'button',
                            'class' => 'round3'));
							
							}
                        ?>	</td>
			</tr></tbody>
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
						<td width="7%" valign='center' >Admin Fee (N$)</td>
						<td width="7%" valign='center' >Amount (N$)</td>
						<td width="6%" valign='center' >Rejection</td>
						<td width="9%" valign='center' >Reason</td>
						<td width="10%" valign='center' >Upload Invoice</td>
						
							<?php 
												

							if($singlefileuploadid!=1){?>
                          <td  valign='top'>
						&nbsp;
						 </td>
								<?php }
                           
							if($singlefileuploadid==1){?>
                          <td  valign='top'> &nbsp; </td>
								<?php }	?>
					</tr>
				</thead>
				<tbody width="100%" cellspacing="1" id='table_row_claims_id' cellpadding="5" border="1" >
					<?php					
				echo $this->Form->input('hidden_call', array('label' => false,
                'div' => false,
                'type' => 'hidden',
                'id' => "singlefileuploadidHidden",
                'value' => $singlefileuploadid));
				
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
							
					//	pr($showclaimdetails['ClaimDetail']);
					//echo '====k======='.$claim_no;
					foreach($showclaimdetails['ClaimDetail'] as $index =>$value) {
					
						
					$InvoicedocdetailsValue =	$this->Invoicedocdetails->giveDocdetails($value['vc_invoice_no'],$value['vc_outlet_code'],strtotime($value['dt_invoice_date']),$claim_no,$vc_client_no);
				    $InvoicedocdetailsValue['InvoiceClaimDoc']['vc_uploaded_doc_name'] ;
						?>
					<tr class="cont1">
                        <td   valign='top' >
                            <?php
							
					echo $this->Form->hidden('ClaimDetail.'.$index.'.vc_claim_dt_id', array('label' => false,
                            'div' => false,
                            'class' => 'round',
							'value'=>base64_encode($value['vc_claim_dt_id'])					
							));
							if($InvoicedocdetailsValue['InvoiceClaimDoc']['vc_uploaded_doc_name']==''){
                            echo $this->Form->input('ClaimDetail.'.$index.'.vc_outlet_code', array('div' => false,
                                'label' => false,
                                'type' => 'select',
                                'default' => $value['vc_outlet_code'],
                                'options' => array('' => 'Select') + $flrFuelOutLet,
                                'class' => 'round_select1'								
                            ));
							
							}else{
							echo $this->Form->input('ClaimDetail.'.$index.'.vc_outlet_code', array('div' => false,
                                'label' => false,
                                'type' => 'select',
								'style'=>'display:none;',
                                'default' => $value['vc_outlet_code'],
                                'options' => array('' => 'Select') + $flrFuelOutLet,
                                'class' => 'round_select1'								
                            ));
							?>
								<div  style="display:'';" id="divoutlet<?php echo $index?>"> <?php
								echo $value['vc_outlet_code'];?>
								</div><?php 
							}
                           ?>

                        </td>
                        <td  valign='top' >
                            <?php
							if($InvoicedocdetailsValue['InvoiceClaimDoc']['vc_uploaded_doc_name']==''){
							
                            echo $this->Form->input('ClaimDetail.'.$index.'.vc_invoice_no', array('label' => false,
                                'div' => false,
                                'type' => 'text',
                                'maxlength' => '15',
								'style'=>'width:67px;',
								'class' => 'round3',
								'value'=>$value['vc_invoice_no']
                            ));
							
							}else{
							
							 echo $this->Form->input('ClaimDetail.'.$index.'.vc_invoice_no', array('label' => false,
                                'div' => false,
                                'type' => 'text',
                                'maxlength' => '15',
								'style'=>'width:67px;display:none;',
								'class' => 'round3',
								'value'=>$value['vc_invoice_no']
                            ));
							?>
							<div  style="display:'';" id="divinvoice<?php echo $index?>"> <?php
								echo $value['vc_invoice_no'];?>
							</div><?php 
							}
                           ?>

                        </td>

                        <td valign='top' >
                            <?php
							if($InvoicedocdetailsValue['InvoiceClaimDoc']['vc_uploaded_doc_name']==''){
                            echo $this->Form->input('ClaimDetail.'.$index.'.dt_invoice_date', array('label' => false,
                                'div' => false,
                                'type' => 'text',
								'style'=>'width:67px;',
                                'class' => 'round3',
								'readonly' =>'readonly',
								'value'=>date('d M Y',strtotime($value['dt_invoice_date']))
                            ));
							}else{
							 echo $this->Form->input('ClaimDetail.'.$index.'.dt_invoice_date', array('label' => false,
                                'div' => false,
                                'type' => 'text',
								'style'=>'width:67px;display:none;',
                                'class' => 'round3',
								'readonly' =>'readonly',
								'value'=>date('d M Y',strtotime($value['dt_invoice_date']))
                            ));
								?>
								<div  style="display:'';" id="divinvoicedate<?php echo $index?>"> <?php
								echo date('d M Y',strtotime($value['dt_invoice_date']));?>
								</div><?php 
							}
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
											
                            ?>

                        </td>
                        <td valign='top' ><?php  ?>
						
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
							 } else 							 
							 {
							 
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
						</div></td>
						
                        <td  valign='top'>
                            <?php			
							
							if($singlefileuploadid==1 ){
						
							     echo $this->Form->input('InvoiceClaimDoc.'.$index, array('label' => false,
                                'div' => false,
                                'type'=>'file',
								'style'=>"display:none;",						
                                'id' => 'updoc'.$index,
                                'tabindex' => '10',
                                'class' => 'uploadfile'));
								
								}elseif($singlefileuploadid!=1 &&  $InvoicedocdetailsValue['InvoiceClaimDoc']['vc_uploaded_doc_name']=='' ) {
									
								 echo $this->Form->input('InvoiceClaimDoc.'.$index, array('label' => false,
                                'div' => false,
                                'type'=>'file',							
                                'id' => 'updoc'.$index,
                                'tabindex' => '10',
                                'class' => 'uploadfile'));
								
								} else {
								$divid='browsedivid'.$index;
								?>
								<div id='<?php echo $divid;?>'></div>
								<?php
								/*if($InvoicedocdetailsValue['InvoiceClaimDoc']['vc_uploaded_doc_name']==''){
								echo $this->Form->input('InvoiceClaimDoc.'.$index, array('label' => false,
                                'div' => false,
                                'type'=>'file',
								'style'=>"display:none;",						
                                'id' => 'updoc'.$index,
                                'tabindex' => '10',
                                'class' => 'uploadfile'));
								}*/
                            }
						if($singlefileuploadid!=1 &&  $InvoicedocdetailsValue['InvoiceClaimDoc']['vc_uploaded_doc_name']!=''){
	//$imagevalue= $this->Html->image('remarks.jpg', array('alt' => '','title'=>'View File','style'=>' cursor: pointer;'));//	$imagevalue ="<img src='/img/remarks.jpg'>";
	
						echo $this->Html->link('View', array('controller' => 'claims', 'action' => 'viewfile',
						  'flr' =>true,$InvoicedocdetailsValue['InvoiceClaimDoc']['vc_upload_id']), array('id'=>'Viewlink_'.$InvoicedocdetailsValue['InvoiceClaimDoc']['vc_upload_id'],'title' => 'View File')) ;
						  echo '<br>';
						  ?>
						  
						  <a  name="<?php echo $index;?>"  href="javascript:void(0)" rel="<?php echo $InvoicedocdetailsValue['InvoiceClaimDoc']['vc_upload_id'];?>" id="deletefileMultiID<?php echo $InvoicedocdetailsValue['InvoiceClaimDoc']['vc_upload_id'];?>" type="<?php echo base64_encode($InvoicedocdetailsValue['InvoiceClaimDoc']['vc_upload_id']);?>" title= "Delete File">Delete <?php //echo $InvoicedocdetailsValue['InvoiceClaimDoc']['vc_upload_id'];?></a>
						  
						  <?php
					     	// echo $InvoicedocdetailsValue['InvoiceClaimDoc']['vc_uploaded_doc_name'];
						  }
						  ?>
                        </td><td></td>
					
                          
                        
					
                    </tr>
					<?php } ?>
				</tbody>
				<!--<input type="text" value ="<?php echo $index; ?>" id="saveindex_id">-->
				<?php
                    echo $this->Form->input('posted_data', array('label' => false,
                        'div' => false,
                        'id' => 'posted_data_id',
                        'type' => 'hidden',
                        'class' => 'round'));
                  ?>
				
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
						<td width="10%" colspan='2'>&nbsp;</td>
						 <?php
					//	echo $value['vc_claim_dt_id'];
		
					if($singlefileuploadid!=1){?>
                          <td  valign='top'>
						<?php   //echo $InvoicedocdetailsValue['InvoiceClaimDoc']['vc_uploaded_doc_name'];?>
						 </td>
								<?php }
                            ?>
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
					
					$savevalue= md5('SAVE');
                    echo $this->Form->button('Save', array('label' => false,
                        'div' => false,
                        'id' => 'savebuttonid',
						'name'=>'Save',
						'onClick' => "posteddata('SAVE');",
                        'type' => 'submit',
                        'class' => 'submit'));
                    ?>			
					&nbsp;&nbsp;&nbsp;&nbsp;			
                    <?php
                    echo $this->Form->button('Submit', array('label' => false,
                        'div' => false,
                        'id' => 'submitbuttonid',
						'name'=>'Submit',	
						'onClick' => "posteddata('SUBMIT');",					
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
					<div class="file-format" >Pdf, Png, Jpeg, Jpg File Could be uploaded.
					<strong>2 MB</strong> is the maximum size for upload </div>
					</td>
				</tr>
                <tr>
                    <td  valign ='top'  width="100%" align="left">
                      <div class="content-area-outer">
                            <div class="upload-button"> </div>
							<div id="queue"></div>
							<div id="filesdata"></div>
							<input id="file_upload" name="file_upload" type="file" multiple="true">
						
				<?php
				$cnt=0;
				if($singlefileuploadid==1){
				?>
				<div>
				<table>
				<?php 
				//pr($InvoicedocdetailssingleValue);
				
				if(count($InvoicedocdetailssingleValue)>0){
				
				foreach($InvoicedocdetailssingleValue as $index=>$value){
				
				?>
				<tr id="rowIDdelete_<?php echo $value['InvoiceClaimDoc']['vc_upload_id'];?>">
				<td>
				<div class='uploadify-queue-item'>				
				<?php echo $value['InvoiceClaimDoc']['vc_uploaded_doc_name'];?>
				</div>
				</td>
				<td>
				<?php echo $this->Html->link('View', array('controller' => 'claims', 'action' => 'viewfile','flr' =>true,$value['InvoiceClaimDoc']['vc_upload_id']), array('title' => 'View File')) ?>&nbsp;&nbsp;&nbsp;
				
				<a  media="<?php echo base64_encode($value['InvoiceClaimDoc']['vc_upload_id']);?>" rel="<?php echo $value['InvoiceClaimDoc']['vc_upload_id'];?>" href="javascript:void(0)" id="deletefileID<?php echo $value['InvoiceClaimDoc']['vc_upload_id'];?>" title= "Delete">Delete</a>
				
				<?php //echo $js->link('title', 'url', array('update'=>'mydiv'))?>				
				<input type='hidden'  name="data['ClaimHeader']['input_allfileupload_values'][<?php echo $cnt;?>]" value="<?php echo $value['InvoiceClaimDoc']['vc_uploaded_doc_name'];?>">			
		    	</td>
				</tr>
				<?php 
				 $cnt++;
					}
				}
				?>
				<tr><td></td><td></td></tr>
				</table>
				</div>
				<?php 
				}
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
<?php 
    echo $this->element('commonmessagepopup');  
	echo $this->element('commonbackproceesing');
    echo $this->Html->script('flr/claimsavecheck'); 
    echo $this->Html->css('uploadify'); 
	echo $this->Html->script('jquery.uploadify.min'); 

	 $timestamp = time();
	 $vc_flr_customer_no = $currentUser['Member']['vc_flr_customer_no'];


?>
<script type="text/javascript">
	$(document).ready(function() {
	
	var arrayfileValue=new Array();
	var divarrayswf    = new Array();
	var selectedFile = null;

   //  alert(GLOBLA_PATH+'uploadify.php');
    
	$('#file_upload').uploadify({
	'formData'     : {
					'timestamp' : '<?php echo $timestamp;?>',
					'token'     : '<?php echo md5('unique_salt' . $timestamp);?>',
					'vc_customer_no'     : '<?php echo $vc_flr_customer_no;?>',					
				},
				
    'swf': GLOBLA_PATH+'uploadify.swf',
    'uploader'    : GLOBLA_PATH+'uploadify.php',
	 // 'uploader'    : GLOBLA_PATH+'flr/claims/uploadall',
     // 'cancelImg' : '/uploadify/cancel.png',
    'fileSizeLimit': '2048KB',
	'fileTypeExts' : '*.jpg; *.png;*.jpeg;*.pdf;',
	'removeCompleted': false,
	'onUploadSuccess': function(fileObj,response,data){
		
		//alert(response);
		arrayfileValue[fileObj.name]=response;		
		var i = parseInt('<?php echo $cnt;?>');
		arrayfileValue[fileObj.name]=response;		
		var lengthOfswfs = 0;
		//alert(parseInt($('.uploadify-queue-item').length));
		lengthOfswfs = parseInt($('.uploadify-queue-item').length)-i;
		//alert(lengthOfswfs+'--diff');
		//alert(i+'--i');
		if(lengthOfswfs>0){
			for(var deldivremove=0;deldivremove<lengthOfswfs;deldivremove++){
				$('#SWF_0_'+deldivremove).remove();
			}
		}
		
		$('#filesdata').html('');
	
    },
	'onSelect':function(fileDetails){
		
		var textdeletehtmlinput ="<input type='hidden' id='divid-"+fileDetails.id+"' value='"+fileDetails.name+"'>";
		$('#'+fileDetails.id).append(textdeletehtmlinput);
	},
	'onQueueComplete':function(){
		
		var lengthOfswfs = parseInt($('.uploadify-queue-item').length);
		var i = parseInt('<?php echo $cnt;?>');
		var arradiv=0;
		$("div[id^= SWFUpload_0]").each(function() {
			
			divarrayswf[arradiv] = $(this).attr('id');
			arradiv++;
		});
		
		
		for(var index in arrayfileValue){
		
			var textboxname='data[ClaimHeader][input_allfileupload_values]['+i+']';
		    var inputhiddenfile="<input type='hidden' id='input_allfileupload_values_"+i+"' name='"+textboxname+"' value='"+arrayfileValue[index]+"' />";
		    $('#filesdata').append(inputhiddenfile);
		    i++;
		
		}
			
			var swfdiffLen = lengthOfswfs-i;
			
			for (var loopval=0;loopval<lengthOfswfs;loopval++){
		
			var dividswf      = '#'+divarrayswf[loopval];			
			var filepath      = $('#input_allfileupload_values_'+loopval).val();		
			var removeItem='';			
			
			var htmldata="<div class='checkexistswfdiv' id='SWF_0_"+loopval+"' ><a rel='"+divarrayswf[loopval]+"' id='hrefID"+loopval+"' href='#' >Remove</a></div>";
			$('#'+divarrayswf[loopval]).append(htmldata);	
			if(parseInt($(dividswf+' .checkexistswfdiv').length) >1){
				$('#SWF_0_'+loopval).remove();
			}
				$("#SWF_0_"+loopval).delegate("#hrefID"+loopval, "click", function () {
				var relvalue = $(this).attr('rel');
				var indexoffilenew    = '';
				$("input[id *='input_allfileupload_values_']").each(function(){
					
					if($.trim($(this).val())==$.trim($('#divid-'+relvalue).val())){
					
						indexoffilenew    = parseInt($(this).attr('id').split("input_allfileupload_values_")[1], 27);
						var textdeletehtmlinputAgain ="<input type='hidden' value='"+indexoffilenew+"'>";
						removeItem=$('#'+$(this).attr('id')).val();
						$.post(GLOBLA_PATH + "flr/claims/deleteajaxuploadify/", { filename: removeItem } );
						arrayfileValue[removeItem]='';
						$('#'+$(this).attr('id')).remove();
											
				 		$('#'+relvalue).remove();						
												
				 		 divarrayswf = $.grep(divarrayswf, function(value) {
						  return (value!=relvalue);
						 });
						
				 	}
				
				 });

				//$('"+dividswf+"').remove();

				});	
			
			}

		}
    
    });
	
});
	

	function posteddata(NUM){

		$('#posted_data_id').val(NUM);

	}

</script>