<?php $currentUser = $this->Session->read('Auth');?>
<!-- Start wrapper here-->
    <div class="wrapper">
        <!-- Start breadcrumb here-->
        <div class="breadcrumb">
            <ul>
                <li class="first">
                     <?php echo $this->Html->link('Home', array('controller' => 'customers', 'action' => 'view','cbc' =>true), array('title' => 'Home', 'class' => 'vtip')) ?>
                </li>

                <li class="last">Online Account Recharge</li>        
            </ul>
        </div>
        <!-- end breadcrumb here-->
        <!-- Start mainbody here-->
        <div class="mainbody">
            <h1>Welcome to RFA CBC</h1>
            <h3>Online Account Recharge</h3>
            <!-- Start innerbody here-->
            <?php echo $this->Form->create('AccountRecharge', array('url' => array('controller' => 'cards', 'action' => 'account_recharge','cbc'=>true),'type' => 'file')); ?>
            <div class="innerbody">
                <table width="100%" border="0" cellpadding="3">
                    <tr>
                        <td><label class="lab-inner">Customer Name :</label></td>
                        <td>
                            <?php
                            echo $this->Form->input('Customer.vc_customer_name', array('label' => false,
                                'div' => false,
                                'type' => 'text',
                                'id' => 'vc_customer_name',
                                'disabled' => 'disabled',
                                'value' => trim($currentUser['Customer']['vc_first_name']) . ' ' . trim($currentUser['Customer']['vc_surname']),
                                'class' => 'round'));
                            ?>
                        </td>
                        <td><label class="lab-inner">Address 1 :</label></td>
                        <td>
                            <?php
                            echo $this->Form->input('Customer.vc_address1', array('label' => false,
                                'div' => false,
                                'type' => 'text',
                                'value' => trim($currentUser['Customer']['vc_address1']),
                                'disabled' => 'disabled',
                                'class' => 'round'));
                            ?>
                        </td>
                        <td><label class="lab-inner">Address 2 :</label></td>
                        <td>
                            <?php
                            echo $this->Form->input('Customer.vc_address2', array('label' => false,
                                'div' => false,
                                'type' => 'text',
                                'value' => trim($currentUser['Customer']['vc_address2']),
                                'disabled' => 'disabled',
                                'class' => 'round'));
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td><label class="lab-inner">Address 3 :</label></td>
                        <td>
                            <?php
                            echo $this->Form->input('Customer.vc_address3', array('label' => false,
                                'div' => false,
                                'type' => 'text',
                                'value' => trim($currentUser['Customer']['vc_address3']),
                                'disabled' => 'disabled',
                                'class' => 'round'));
                            ?>
                        </td>
                        <td><label class="lab-inner">Telephone No. :</label></td>
                        <td>
                            <?php
                            echo $this->Form->input('Customer.vc_tel_no', array('label' => false,
                                'div' => false,
                                'type' => 'text',
                                'value' => trim($currentUser['Customer']['vc_tel_no']),
                                'disabled' => 'disabled',
                                'class' => 'round'));
                            ?>
                        </td>
                        <td><label class="lab-inner">Fax No. :</label></td>
                        <td>
                            <?php
                            echo $this->Form->input('Customer.vc_fax_no', array('label' => false,
                                'div' => false,
                                'type' => 'text',
                                'value' => trim($currentUser['Customer']['vc_fax_no']),
                                'disabled' => 'disabled',
                                'class' => 'round'));
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td><label class="lab-inner">Email :</label></td>
                        <td>
                            <?php
                            echo $this->Form->input('Customer.vc_email', array('label' => false,
                                'div' => false,
                                'type' => 'text',
                                'value' => trim($currentUser['Customer']['vc_email']),
                                'disabled' => 'disabled',
                                'class' => 'round'));
                            ?>
                        </td>
                        <td><label class="lab-inner">Mobile No. :</label></td>
                        <td>
                            <?php
                            echo $this->Form->input('Customer.vc_mobile_no', array('label' => false,
                                'div' => false,
                                'type' => 'text',
                                'value' => trim($currentUser['Customer']['vc_mobile_no']),
                                'disabled' => 'disabled',
                                'class' => 'round'));
                            ?>
                        </td>
                        <td><label class="lab-inner">Account <br/>Balance (N$) :</label></td>
                        <td>
                            <?php
                            echo $this->Form->input('Customer.nu_account_balance', array('label' => false,
                                'div' => false,
                                'type' => 'text',
                                'value' => (!empty($customer['Customer']['nu_account_balance']))? number_format(trim($customer['Customer']['nu_account_balance']), 2, '.', ','):'',
                               'disabled' => 'disabled',
                                'class' => 'round number-right'));
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td valign="top"><label class="lab-inner">Deposit Date :</label></td>
                        <td valign="top">
                            <?php
                            echo $this->Form->input('dt_payment_date', array('label' => false,
                                'div' => false,
                                'type' => 'text',
                                'id' => 'datepicker',
                                'required' => 'required',
                                'readonly' => 'readonly',
                                'class' => 'round Deposit_date'));
                            ?>
                        </td>
                        <td valign="top"><label class="lab-inner">Deposit <br/>Amount (N$) :</label></td>
                        <td valign="top">
                            <?php
                            echo $this->Form->input('nu_amount_un', array('label' => false,
                                'div' => false,
                                'type' => 'text',
								'required' => 'required',
                                'maxlength' => 15,
                                'class' => 'round number-right'));
                            ?>
                        </td>
                        <td valign="top"><label class="lab-inner">Deposit Type :</label></td>
                        <td valign="top">
							<?php
								echo $this->Form->input('ch_tran_type', array('label' => false,
																'div' => false,
																'type' => 'select',
																'options' => $CustType,
																'required' => 'required',
																'class' => 'round_select'));
							?>
                        </td>
                    </tr>
                    <tr>
                        <td valign="top"><label class="lab-inner">Admin <br/>Charges (N$) :</label></td>
                        <td valign="top">
                            <?php
                            echo $this->Form->input('nu_hand_charge', array('label' => false,
                                'div' => false,
                                'type' => 'text',
                                'disabled' => 'disabled',
								'value' => number_format($globalParameterarray['CBCADMINFEE'], 2, '.', ','),
                                'required' => 'required',
                                'class' => 'round number-right'));
                            ?>
                        </td>
                        <td valign="top"><label class="lab-inner">Ref. No. :</label></td>
                        <td valign="top">
                            <?php
                            echo $this->Form->input('vc_ref_no', array('label' => false,
                                'div' => false,
                                'type' => 'text',
                                'required' => 'required',
                                'maxlength' => 20,
                                'pattern' => '|^[0-9a-zA-Z-]*$|',
                                'class' => 'round'));
                            ?>
                        </td>
                        <td valign="top"><label class="lab-inner">Approved <br/>Amount (N$) :</label></td>
                        <td valign="top">
                            <?php
                            echo $this->Form->input('nu_amount', array('label' => false,
                                'div' => false,
                                'type' => 'text',
								'maxlength' => 12,
                                'disabled' => 'disabled',
                                'class' => 'round number-right'));
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td valign="top"><label class="lab-inner">Upload Doc. :</label></td>
                        <td colspan="2" valign="top">
                            <?php
                            echo $this->Form->input('DocumentUploadCbc.vc_upload_doc_name', array('label' => false,
                                'div' => false,
                                'type' => 'file',
                                'required' => 'required',
                                'class' => 'uploadfile'));
                            ?>
                        </td>
                        <td valign="top">&nbsp;</td>
                        <td valign="top"><label class="lab-inner">Recharge Status :</label></td>
                        <td valign="top">
							<?php
								echo $this->Form->input('vc_recharge_status', array('label' => false,
									'div' => false,
									'type' => 'text',
									'value' => $globalParameterarray['STSTY03'],
									'disabled' => 'disabled',
									'class' => 'round'));
							?>
						</td>
                    </tr>

                </table>

            </div>
            <!-- end innerbody here-->
            <table width="100%" border="0">
                <tr>
                    <td align="center">
					
						<?php echo $this->Form->submit('Submit', array('type' => 'submit', 'class' => 'submit', 'value' => 'submit')); ?>
					</td>
                </tr>
            </table>
						<?php echo $this->Form->end(); ?>
        </div>
        <!-- end mainbody here-->    
    </div>
    <!-- end wrapper here-->

						<?php echo $this->Html->script('cbc/accountrecharge'); ?>