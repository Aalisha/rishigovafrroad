<?php $currentUser = $this->Session->read('Auth'); ?>
<?php //pr($claimslist); die;  ?>
<!-- Start wrapper here-->
<div class="wrapper">
    <!-- Start breadcrumb here-->
    <div class="breadcrumb">
        <ul>
            <li class="first">
                <?php echo $this->Html->link('Home', array('controller' => 'clients', 'action' => 'view', 'flr' => true), array('title' => 'Home', 'class' => 'vtip')) ?>
            </li>
            <li class="last">Client Claim</li>
 <li class="last clientnoclass" style=""  >Client No.&nbsp;:&nbsp;<?php echo ltrim($this->Session->read('Auth.Client.vc_client_no'),'01');?></li> 			
        </ul>
    </div>
    <!-- end breadcrumb here-->
    <!-- Start mainbody here-->
    <div class="mainbody">
        <h1>Welcome to RFA FLR</h1>
        <h3>View Claims</h3>
        <!-- Start innerbody here-->
        <?php echo $this->Form->create(null); ?>
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
                    <td valign="top"><label class="lab-inner">Bank A/C No. :</label></td>
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
                    <td valign="top"><label class="lab-inner">A/C Holder Name :</label></td>
                    <td valign="top">
                        <?php
                        echo $this->Form->input('ClaimHeader.vc_account_holder', array('label' => false,
                            'div' => false,
                            'type' => 'text',
                            'disabled' => 'disabled',
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
					<td valign="top" align="left"><label class="lab-inner">Client No.&nbsp;:</label></td>
				<td valign="top"><?php echo ltrim($this->Session->read('Auth.Client.vc_client_no'),'01');?>
                    </td>
                    <!--<td valign="top"><input type="text" class="round" /></td>-->
                                    </tr>
            </table>

        </div>

        <div class="innerbody">
      <table width="100%" cellspacing="1" cellpadding="5" border="0">
                <tr class="listhead1">
                    <td width="4%" align="center">SI. No.</td>
                    <td width="10%" align="center">System <br>Claim No.</td>
                    <td width="11%" align="center">Claim Date</td>
                    <td width="11%" align="center">Claim From</td>
                    <td width="11%" align="center">Claim To</td>
                    <td width="11%" align="center">Fuel Claimed (ltrs)</td>
                    <td width="11%" align="center">Claim Status</td>
                    <td width="11%" align="center">Amount (N$)</td>
					<td width="9%" align="center">Claim No.</td>
				          <td width="11%" align="center">Action</td>
			
                </tr>
                <?php
                if (count($claimslist) > 0) {
                    $i = 1;
					
                    foreach ($claimslist as $index=> $claims) {
                ?>
                <tr class="cont1">
                    <td align="center"><?php echo $index+1;?></td>
                    <td align="left">
					<input type="hidden" id="hidden_claim_id_<?php echo $index;?>"
					value="<?php echo base64_encode($claims['ClaimHeader']['vc_claim_no']);?>">
					<a  id= "linkId_<?php echo $index;?>" class ='round5 showlog'  href='#'>
					<?php echo $claims['ClaimHeader']['vc_claim_no'];?>
					 
					</a>
					</td>
                    <td align="left">
					<?php echo date('d M Y',strtotime($claims['ClaimHeader']['dt_entry_date']));?></td>
                    <td align="left"><?php echo date('d M Y',strtotime($claims['ClaimHeader']['dt_claim_from']));?></td>
                    <td align="left"><?php echo date('d M Y',strtotime($claims['ClaimHeader']['dt_claim_to']));?></td>
                    <td align="right"><?php echo number_format($claims['ClaimHeader']['nu_tot_litres'], 2, '.', ',');?></td>
                    <td align="left"><?php 
						echo $globalParameterarray[$claims['ClaimHeader']['vc_status']];?></td>
                    <td align="right"><?php 
					echo number_format($claims['ClaimHeader']['nu_tot_amount'], 2, '.', ',');?></td>
					<td align="left">
					<?php echo $claims['ClaimHeader']['vc_party_claim_no']; ?>
					
					</td>
                    <td align="center">
                    
					
					<?php
					if($claims['ClaimHeader']['vc_status']=='STSTY05')     {

				$url = $this->webroot.'flr/claims/edit/'. base64_encode($claims['ClaimHeader']['vc_claim_no']);
					 echo $this->Html->image('editbutton.png', array('alt' => '', 'title'=>'Edit Claim', 'onclick' => "javascript: window.location.href ='".$url."'", 'style'=>' cursor: pointer;')); 
					}              
					
					else if($claims['ClaimHeader']['vc_status']=='STSTY08')     {

					$url = $this->webroot.'flr/claims/save/'. base64_encode($claims['ClaimHeader']['vc_claim_no']);
					 echo $this->Html->image('editbutton.png', array('alt' => '', 'title'=>'Save Claim', 'onclick' => "javascript: window.location.href ='".$url."'", 'style'=>' cursor: pointer;')); 
					}else{
					 echo 'N/A';
					}               
					
		    ?>
                     </td>
					
                </tr>
                <?php
                    $i++;
                    } 
                    } else {
                ?>
           
               <tr class="cont1" style='text-align: center'>
                <td colspan='10'> No Record Found  </td>
                </tr>
                <?php  } ?>
                
              <?php echo $this->element('paginationfooter'); ?>
                
                
            </table>

        </div>
        <!-- end mainbody here-->  
    </div>
    <!-- end mainbody here-->    
</div>
<!-- end wrapper here-->
<?php echo $this->element('logshowpopup'); ?>
<?php echo $this->element('commonbackproceesing'); ?>
<?php echo $this->Html->script('flr/viewclaim'); ?>
