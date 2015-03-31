<?php $currentUser = $this->Session->read('Auth'); ?>
<?php //pr($claimslist); die;      ?>
<!-- Start wrapper here-->
<div class="wrapper">
    <!-- Start breadcrumb here-->
    <div class="breadcrumb">
        <ul>
            <li class="first">
                <?php echo $this->Html->link('Home', array('controller' => 'clients', 'action' => 'view', 'flr' => true), array('title' => 'Home', 'class' => 'vtip')) ?>
            </li>
            <li class="last">Client Bank Change Request</li>  <li class="last clientnoclass" style=""  >Client No.&nbsp;:&nbsp;<?php echo ltrim($this->Session->read('Auth.Client.vc_client_no'),'01');?></li>        
        </ul>
    </div>
    <!-- end breadcrumb here-->
    <!-- Start mainbody here-->
    <div class="mainbody">
        <h1>Welcome to RFA FLR</h1>
        <h3>View Bank Change Request</h3>
        <!-- Start innerbody here-->
        <?php echo $this->Form->create(null);
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
                    <td valign="top"><label class="lab-inner">Bank A/C No :</label></td>
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
                    <td valign="top"><label class="lab-inner"><!--Client No.&nbsp;:--><!--Status Of Claim :</label>--></td>
                    <!--<td valign="top"><input type="text" class="round" /></td>-->
                    <td valign="top"><?php // echo $this->Session->read('Auth.Client.vc_client_no');?></td>
                </tr>
            </table>
        </div>

        <div class="innerbody">
            <table width="100%" cellspacing="1" cellpadding="5" border="0">
                <tr class="listhead1">
                    <td width="5%" align="center">SI. No.</td>
                    <td width="10%" align="center">Client No.</td>
                    <td width="10%" align="center">Account <br>Holder Name</td>
                    <td width="15%" align="center">Account No.</td>
                    <td width="10%" align="center">Account Type</td>
                    <td width="12%" align="center">Bank Name</td>
                    <td width="10%" align="center">Bank Branch Name</td>
                    <td width="12%" align="center">Date</td>
                    <td width="16%" align="center">Status</td>
                </tr>
                <?php
                if ($totalrequestAlready > 0) {
                    $i = 1;

                    foreach ($allBankrequest as $index => $details) {
                        ?>
                        <tr class="cont1">
                            <td align="center"><?php echo $index + 1; ?></td>
                            <td align="left">
                                <?php echo $details['ClientBankHistory']['vc_client_no']; ?>
                            </td>
                            <td align="left">					
                                <?php
                                echo $details['ClientBankHistory']['vc_account_holder_name'];
                                ?>
                            </td>
                            <td align="right">
                                <?php
                                echo wordwrap($details['ClientBankHistory']['vc_bank_account_no'], 20, true);
                                ?></td>
                            <td align="left">
                                <?php
                                echo $details['ClientBankHistory']['vc_account_type'];
                                ?>
                            </td>
                            <td align="left">
                                <?php
                                echo $details['ClientBankHistory']['vc_bank_name'];
                                ?></td>

                            <td align="left">
                                <?php
                                echo wordwrap($details['ClientBankHistory']['vc_bank_branch_name'], 20, true);
                                ?>
                            </td>
                            <td align="left"><?php echo date('d M Y', strtotime($details['ClientBankHistory']['dt_date1'])); ?></td>
                            <td align="center">
                                <?php echo $globalParameterarray[$details['ClientBankHistory']['ch_active']]; 
								
								echo $this->Form->input(null, array('label' => false,
										'div' => false,
										'type' => 'hidden',
										'id'=>false,
										'name'=>false,
										'value'=>base64_encode($details['ClientBankHistory']['vc_bank_history_id'])));	
										
								if($details['ClientBankHistory']['ch_active']=='STSTY05'){
								$key =$details['ClientBankHistory']['vc_bank_history_id'];
								?>&nbsp;&nbsp;
								
							
							<?php echo $this->Html->image('remarks.jpg', array('alt' => '', 'id'=>'imgedt'.$key, 'title'=>'View Remarks','style'=>' cursor: pointer;')); ?>
								
								<?php 
								
								//echo $details['ClientBankHistory']['vc_reason'];
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
                        <td colspan='9'> No Record Found  </td>
                    </tr>
                    <?php
                }
                if ($totalrequestAlready > 0) {
                    echo $this->element('paginationfooter');
                }
                ?>
            </table>
        </div>
        <!-- end mainbody here-->  
    </div>
    <!-- end mainbody here-->    
</div>
<!-- end wrapper here-->
<?php echo $this->element('commonmessagepopup'); ?>
<?php echo $this->element('commonbackproceesing'); ?>		
<?php //echo $this->element('logshowpopup'); ?>
<?php  echo $this->Html->script('flr/claim-view'); ?>

<?php //echo $this->Html->script('flr/viewclaim'); ?>
