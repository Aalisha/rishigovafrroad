<!-- Start wrapper here-->
<div class="wrapper">
    <!-- Start breadcrumb here-->
    <div class="breadcrumb">
        <ul>
            <li class="first">
                <a title="Home" class="vtip" href="#">Home</a>
            </li>
            <li class="last">My Profile</li>               
        </ul>
    </div>
    <!-- end breadcrumb here-->
    <!-- Start mainbody here-->
    <div class="mainbody">
        <h1>Welcome to RFA FLR</h1>
        <h3>Client Identification</h3>
        <!-- Start innerbody here-->
        <div class="innerbody">

            <?php echo $this->Form->create('Client', array('url' => array('controller' => 'clients', 'action' => 'index'), 'type' => 'file')); ?>

           
  <table width="100%" border="0" cellpadding="3">
                <tr>

                    <td height="35" colspan="6" align="right" valign="middle">Account Status: <strong>Inactive</strong>
			
						<?php
                        echo $this->Form->input('Client.encemid', array('label' => false,
															'div' => false,
															'type' => 'hidden',
															'value'=>base64_encode(trim($this->Session->read('Auth.Member.vc_email_id')))
															));
                        ?>
						
					</td>

                </tr>

                <tr>
                    <td width="15%" align="left" valign="top"><label class="lab-inner">Business Reg. Id :</label></td>
                    <td width="20%" align="left" valign="top">
                        <?php
                        echo $this->Form->input('Client.vc_id_no', array('label' => false,
                            'div' => false,
                            'type' => 'text',
                            'maxlength' => 50,
                            'class' => 'round'
                        ));
                        ?>

                    </td>
                    <td width="15%" align="left" valign="top"><label class="lab-inner">Client Name :</label></td>
                    <td width="19%" align="left" valign="top">
                        <?php
                        echo $this->Form->input('Client.vc_client_name', array('label' => false,
                            'div' => false,
                            'type' => 'text',
                            'maxlength' => 200,
                            'class' => 'round'
                        ));
                        ?>
                    </td>
                    <td width="16%" align="left" valign="top"><label class="lab-inner">Contact Person :</label></td>
                    <td width="17%" align="left" valign="top">
                        <?php
                        echo $this->Form->input('Client.vc_contact_person', array('label' => false,
                            'div' => false,
                            'type' => 'text',
                            'maxlength' => 200,
                            'class' => 'round'
                        ));
                        ?>
                    </td>
                </tr>

                <tr>
                    <td colspan="6" align="left" valign="top">&nbsp;</td>
                </tr>

                <tr>
                    <td width="15%" height="30" align="left" valign="top"><label class="lab-inner"><strong style="text-decoration:underline;">Postal Address</strong></label></td>
                    <td width="20%" align="left" valign="top">&nbsp;</td>
                    <td width="15%" align="left" valign="top">&nbsp;</td>
                    <td width="19%" align="left" valign="top">&nbsp;</td>
                    <td width="16%" align="left" valign="top">&nbsp;</td>
                    <td width="17" align="left" valign="top">&nbsp;</td>
                </tr>

                <tr>
                    <td width="15%" align="left" valign="top"><label class="lab-inner">Address 1 :</label></td>
                    <td width="20%" align="left" valign="top">
                        <?php
                        echo $this->Form->input('Client.vc_address1', array('label' => false,
                            'div' => false,
                            'type' => 'text',
                            'maxlength' => 100,
                            'class' => 'round'));
                        ?>

                    </td>
                    <td width="15%" align="left" valign="top"><label class="lab-inner">Address 2 :</label></td>
                    <td width="19%" align="left" valign="top">
                        <?php
                        echo $this->Form->input('Client.vc_address2', array('label' => false,
                            'div' => false,
                            'type' => 'text',
                            'maxlength' => 50,
                            'class' => 'round'));
                        ?>
                    </td>
                    <td width="16%" align="left" valign="top"><label class="lab-inner">Address 3 :</label></td>
                    <td width="17" align="left" valign="top">
                        <?php
                        echo $this->Form->input('Client.vc_address3', array('label' => false,
                            'div' => false,
                            'type' => 'text',
                            'maxlength' => 50,
                            'class' => 'round'));
                        ?>
                    </td>
                </tr>
                <tr>
                    <td width="15%" align="left" valign="top"><label class="lab-inner">Postal Code :</label></td>
                    <td width="20%" align="left" valign="top">
                        <?php
                        echo $this->Form->input('Client.vc_postal_code1', array('label' => false,
                            'div' => false,
                            'type' => 'text',
                            'maxlength' => 25,
                            'class' => 'round'));
                        ?>
                    </td>
                    <td width="15%" align="left" valign="top"><label class="lab-inner">Tel. No. :</label></td>
                    <td width="19%" align="left" valign="top">
                        <?php
                        echo $this->Form->input('Client.vc_tel_no', array('label' => false,
                            'div' => false,
                            'type' => 'text',
                            'maxlength' => 15,
                            'class' => 'round'));
                        ?>
                    </td>
                    <td width="16%" align="left" valign="top"><label class="lab-inner">Mobile No. :</label></td>
                    <td width="17" align="left" valign="top">
                        <?php
                        echo $this->Form->input('Client.vc_cell_no', array('label' => false,
                            'div' => false,
                            'type' => 'text',
                            'maxlength' => 15,
                            'class' => 'round'));
                        ?>
                    </td>
                </tr>
                <tr>
                    <td width="15%" align="left" valign="top"><label class="lab-inner">Fax No. :</label></td>
                    <td width="20%" align="left" valign="top">
                        <?php
                        echo $this->Form->input('Client.vc_fax_no', array('label' => false,
                            'div' => false,
                            'type' => 'text',
                            'maxlength' => 15,
                            'class' => 'round'));
                        ?>

                    </td>
                    <td width="15%" align="left" valign="top"><label class="lab-inner">Email :</label></td>
                    <td width="19%" align="left" valign="top">
                        <?php
                        echo $this->Form->input('Client.vc_email', array('label' => false,
                            'div' => false,
                            'type' => 'text',
                            'maxlength' => 50,
                            'disabled' => 'disabled',
                            'value' => trim($this->Session->read('Auth.Member.vc_email_id')),
                            'class' => 'round disabled-field'));
                        ?>

                    </td>
                    <td width="16%" align="left" valign="top">&nbsp;</td>
                    <td width="17" align="left" valign="top">&nbsp;</td>
  </tr>
                <tr>
                    <td width="15%" align="left" valign="top">&nbsp;</td>
                    <td width="20%" align="left" valign="top">&nbsp;</td>
                    <td width="15%" align="left" valign="top">&nbsp;</td>
                    <td width="19%" align="left" valign="top">&nbsp;</td>
                    <td width="16%" align="left" valign="top">&nbsp;</td>
                    <td width="17" align="left" valign="top">&nbsp;</td>
                </tr>
                <tr>
                    <td width="15%" height="30" align="left" valign="middle"><label class="lab-inner"><strong style="text-decoration:underline;">Business Address </strong></label></td>
                    <td width="20%" align="left" valign="middle" style="font-size:11px;">
                        <?php echo $this->Form->checkbox('checkbox2'); ?>
                        Copy Postal Address</td>
                    <td width="15%" align="left" valign="top">&nbsp;</td>
                    <td width="19%" align="left" valign="top">&nbsp;</td>
                    <td width="16%" align="left" valign="top">&nbsp;</td>
                    <td width="17" align="left" valign="top">&nbsp;</td>
                </tr>
                <tr>
                    <td width="15%" align="left" valign="top"><label class="lab-inner">Address 1 :</label></td>
                    <td width="20%" align="left" valign="top">
                        <?php
                        echo $this->Form->input('Client.vc_address4', array('label' => false,
                            'div' => false,
                            'type' => 'text',
                            'maxlength' => 500,
                            'class' => 'round'));
                        ?>
                    </td>
                    <td width="15%" align="left" valign="top"><label class="lab-inner">Address 2 :</label></td>
                    <td width="19%" align="left" valign="top">
                        <?php
                        echo $this->Form->input('Client.vc_address5', array('label' => false,
                            'div' => false,
                            'type' => 'text',
                            'maxlength' => 50,
                            'class' => 'round'));
                        ?>
                    </td>
                    <td width="16%" align="left" valign="top"><label class="lab-inner">Address 3 :</label></td>
                    <td width="17" align="left" valign="top">
                        <?php
                        echo $this->Form->input('Client.vc_address6', array('label' => false,
                            'div' => false,
                            'type' => 'text',
                            'maxlength' => 50,
                            'class' => 'round'));
                        ?>
                    </td>
  </tr>
                <tr>
                    <td width="15%" align="left" valign="top"><label class="lab-inner">Postal Code :</label></td>
                    <td width="20%" align="left" valign="top">
                        <?php
                        echo $this->Form->input('Client.vc_postal_code2', array('label' => false,
                            'div' => false,
                            'type' => 'text',
                            'maxlength' => 25,
                            'class' => 'round'));
                        ?>
                    </td>
                    <td width="15%" align="left" valign="top"><label class="lab-inner">Tel. No. :</label></td>
                    <td width="19%" align="left" valign="top">
                        <?php
                        echo $this->Form->input('Client.vc_tel_no2', array('label' => false,
                            'div' => false,
                            'type' => 'text',
                            'maxlength' => 15,
                            'class' => 'round'));
                        ?>
                    </td>
                    <td width="16%" align="left" valign="top"><label class="lab-inner">Mobile No. :</label></td>
                    <td width="17" align="left" valign="top">
                        <?php
                        echo $this->Form->input('Client.vc_cell_no2', array('label' => false,
                            'div' => false,
                            'type' => 'text',
                            'maxlength' => 15,
                            'class' => 'round'));
                        ?>
                    </td>
  </tr>
                <tr>
                    <td width="15%" align="left" valign="top"><label class="lab-inner">Fax No. :</label></td>
                    <td width="20%" align="left" valign="top">
                        <?php
                        echo $this->Form->input('Client.vc_fax_no2', array('label' => false,
                            'div' => false,
                            'type' => 'text',
                            'maxlength' => 15,
                            'class' => 'round'));
                        ?>

                    </td>
                    <td width="15%" align="left" valign="top"><label class="lab-inner">Email :</label></td>
                    <td width="19%" align="left" valign="top">
                        <?php
                        echo $this->Form->input('Client.vc_email2', array('label' => false,
                            'div' => false,
                            'type' => 'text',
                            'maxlength' => 50,
                            'class' => 'round'));
                        ?>
                    </td>
                    <td width="16%" align="left" valign="top">&nbsp;</td>
                    <td width="17" align="left" valign="top">&nbsp;</td>
  </tr>
            </table>
            <table width="100%" border="0" cellpadding="3">
                <tr>
                    <td width="15%" align="left" valign="top">&nbsp;</td>
                    <td width="20%" align="left" valign="top">&nbsp;</td>
                    <td width="15%" align="left" valign="top">&nbsp;</td>
                    <td width="19%" align="left" valign="top">&nbsp;</td>
                    <td width="16%" align="left" valign="top">&nbsp;</td>
                    <td width="17%" align="left" valign="top">&nbsp;</td>
                </tr>
                <tr>
                    <td width="15%" align="left" valign="top"><label class="lab-inner">Client Category :</label></td>
                    <td width="20%" align="left" valign="top">

                        <?php echo $this->Form->input('ClientHeader.vc_cateogry', array('div' => false, 'class' => 'round_select', 'label' => false, 'type' => 'select', 'default' => '', 'options' => array('' => 'Select') + $flrCategory)) ?>

                    </td>
                    <td width="15%" align="left" valign="top"><label class="lab-inner">Refund % :</label></td>
                    <td width="19%" align="left" valign="top">


                        <?php
                        echo $this->Form->input('ClientHeader.nu_refund', array('label' => false,
                            'div' => false,
                            'type' => 'text',
                            'id'=>'nu_refund',
                            'readonly'=>'readonly',
                            'class' => 'round disabled-field'));
                        ?>



                    </td>
                    <td width="16%" align="left" valign="top"><label class="lab-inner">Fuel Usage Prev. Year  :</label></td>
                    <td width="17%" align="left" valign="top"><?php
                        echo $this->Form->input('ClientHeader.nu_fuel_usage', array('label' => false,
                            'div' => false,
                            'type' => 'text',
                            'maxlength' => 10,
                            'class' => 'round'));
                        ?></td>
                </tr>
				<tr id="rowid_agriculture" style="display:none;">
                    <td width="15%" align="left" valign="top"></td>
                    <td width="20%" align="left" valign="top">
					<fieldset><legend>Agriculture</legend>
					<table border='0' cellpadding='3' width='100%'>
					<tr>
					<td  style='width:50px;'>Agronomic&nbsp;(%)&nbsp;:</td><td><?php
                        echo $this->Form->input('ClientHeader.nu_agronomic_percnt', array('label' => false,
                            'div' => false,
                            'type' => 'text',
                             'maxlength' => 10,
                             'style' => 'width:50px;',
                            'class' => 'round'));//NU_AGRONOMIC_PERCNT
                        ?></td>
					</tr>
					<tr>
					<td  style='width:50px;'>Livestock&nbsp;(%)&nbsp;:</td><td><?php
                        echo $this->Form->input('ClientHeader.nu_livestock_percnt', array('label' => false,
                            'div' => false,
                            'type' => 'text',
                             'maxlength' => 10,
                             'style' => 'width:50px;',
                            'class' => 'round'));//NU_AGRONOMIC_PERCNT
                        ?></td>
					</tr>
					</table>
					</fieldset>
					</td>
                    <td width="15%" align="left" valign="top"></td>
                    <td width="19%" align="left" valign="top"></td>
                    <td width="16%" align="left" valign="top">&nbsp;</td>
                    <td width="17%" align="left" valign="top">&nbsp;</td>
                </tr>
				
				
				<tr id="rowid_construction" style="display:none;">
                    <td width="15%" align="left" valign="top"></td>
                    <td width="20%" align="left" valign="top">
					<fieldset><legend>Construction</legend>
					<table border='0' cellpadding='3' width='100%'>
					<tr>
					<td  style='width:50px;'>Building&nbsp;(%)&nbsp;:</td><td><?php
                        echo $this->Form->input('ClientHeader.nu_building_percnt', array('label' => false,
                            'div' => false,
                            'type' => 'text',
                             'maxlength' => 10,
                             'style' => 'width:50px;',
                            'class' => 'round'));//NU_AGRONOMIC_PERCNT
                        ?></td>
					</tr>
					<tr>
					<td  style='width:50px;'>Civil&nbsp;(%)&nbsp;:</td><td><?php
                        echo $this->Form->input('ClientHeader.nu_civil_percnt', array('label' => false,
                            'div' => false,
                            'type' => 'text',
                             'maxlength' => 10,
                             'style' => 'width:50px;',
                            'class' => 'round'));//NU_AGRONOMIC_PERCNT
                        ?></td>
					</tr>
					</table>
					</fieldset>
					</td>
                    <td width="15%" align="left" valign="top"></td>
                    <td width="19%" align="left" valign="top"></td>
                    <td width="16%" align="left" valign="top">&nbsp;</td>
                    <td width="17%" align="left" valign="top">&nbsp;</td>
                </tr>
                <tr>
                    <td width="15%" align="left" valign="top"><label class="lab-inner">Expected Usages Next Year  :</label></td>
                    <td width="20%" align="left" valign="top"><?php
                        echo $this->Form->input('ClientHeader.nu_expected_usage', array('label' => false,
                            'div' => false,
                            'type' => 'text',
                             'maxlength' => 10,
                            'class' => 'round'));
                        ?></td>
                    <td width="15%" align="left" valign="top"><label class="lab-inner">Off Road Usage Prev. Year :</label></td>
                    <td width="19%" align="left" valign="top"><?php
                        echo $this->Form->input('ClientHeader.nu_off_road_usage', array('label' => false,
                            'div' => false,
                            'type' => 'text',
                            'maxlength' => 10,
                            'class' => 'round'));
                        ?></td>
                    <td width="16%" align="left" valign="top"><label class="lab-inner">Off Road Usages Next Year :</label></td>
                    <td width="17%" align="left" valign="top"><?php
                        echo $this->Form->input('ClientHeader.nu_off_expected_usage', array('label' => false,
                            'div' => false,
                            'type' => 'text',
                            'maxlength' => 10,
                            'class' => 'round'));
                        ?></td>
                </tr>
                <tr>
                    <td width="15%" align="left" valign="top"><label class="lab-inner">Upload Document :</label></td>
                    <td width="20%" align="left" valign="top"><?php
                        echo $this->Form->input('ClientUploadDocs.fuelusagedoc', array('label' => false,
                            'div' => false,
                            'type' => 'file',
                            'class' => 'uploadfile'));
                        ?></td>
                    <td width="15%" align="left" valign="top">&nbsp;</td>
                    <td width="19%" align="left" valign="top">&nbsp;</td>
                    <td width="16%" align="left" valign="top">&nbsp;</td>
                    <td width="17%" align="left" valign="top">&nbsp;</td>
                </tr>
                <tr>
                    <td width="15%" align="left" valign="top">&nbsp;</td>
                    <td width="20%" align="left" valign="top">&nbsp;</td>
                    <td width="15%" align="left" valign="top">&nbsp;</td>
                    <td width="19%" align="left" valign="top">&nbsp;</td>
                    <td width="16%" align="left" valign="top">&nbsp;</td>
                    <td width="17%" align="left" valign="top">&nbsp;</td>
                </tr>
                
                <tr>
                    <td colspan="6" align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="30%" align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td width="75%" height="30" align="left" valign="top"><strong style="text-decoration:underline;">Fuel Outlets</strong></td>
                    <td width="25%" align="left" valign="top" >&nbsp;
                        
                    </td>
                          </tr>						  
						  
						<?php if (count($this->data['ClientFuelOutlet']['fueloutlets']) > 0) : ?>

						<?php foreach ($this->data['ClientFuelOutlet']['fueloutlets'] as $key => $value) : ?>

						<tr>
						<td width="75%" align="left" valign="top">
							<div class='outletslist'>	
								<?php echo $this->Form->input("ClientFuelOutlet.fueloutlets.$key", array('div' => false, 'label' => false, 'id'=>false, 'class' => 'round_select5', 'type' => 'select', 'default' => trim($value['vc_fuel_outlet']), 'options' => array('' => 'Select') + $flrFuelOutLet)) ?>
							</div>
							<?php if( trim($value['vc_fuel_outlet']) != '' ): unset($flrFuelOutLet[$value['vc_fuel_outlet']]);endif; ?>
						</td>
						<td width="25%" align="left" valign="top">
							<div class="button-addmore" style="float:left;">
								<?php if( $key == ( count($this->data['ClientFuelOutlet']['fueloutlets']) -1 ) ){ ?>
									<a id="add">
										<?php echo $this->Html->image('add-more.png', array('width' => "24", "style" => "cursor:pointer", 'height' => '24')); ?>

									</a>
									<?php }  ?>
								<a id="remove" >
									<?php echo $this->Html->image('icon_error.png', array('width' => "19", "style" => "cursor:pointer", 'height' => '20')); ?>

								</a>
							</div>
						</td>

						</tr>
						<?php endforeach; ?>

						<?php else : ?>

						<tr>
						<td width="75%" align="left" valign="top">

						<div class='outletslist' >	
							<?php echo $this->Form->input('ClientFuelOutlet.fueloutlets.0', array('div' => false, 'label' => false,  'id'=>false, 'class' => 'round_select5', 'type' => 'select', 'default' => '', 'options' => array('' => 'Select') + $flrFuelOutLet)) ?>
						</div>

						</td>
						<td width="25%" align="left" valign="top">
						<div class="button-addmore" style="float:left;">
							<a id="add">
								<?php echo $this->Html->image('add-more.png', array('width' => "24", "style" => "cursor:pointer", 'height' => '24')); ?>

							</a>
							<a id="remove" >
								<?php echo $this->Html->image('icon_error.png', array('width' => "19", "style" => "cursor:pointer", 'height' => '20')); ?>

							</a>
						</div>
						</td>
						</tr>

						<?php endif; ?>
				
				</table></td>
                        <td width="4%" align="left" valign="top">&nbsp;</td>
                        <td width="65.5%" align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td width="23%" height="30" align="left" valign="top"><strong style="text-decoration:underline;">Bank Details</strong></td>
                    <td width="28%" height="30" align="left" valign="top">&nbsp;</td>
                    <td width="24%" height="30" align="left" valign="top">&nbsp;</td>
                    <td width="25%" height="30" align="left" valign="top">&nbsp;</td>
                          </tr>
                          <tr>
                            <td width="23%" height="30" align="left" valign="top"><label class="lab-inner">Account Holder Name :</label></td>
                    <td width="28%" height="30" align="left" valign="top"><?php
                        echo $this->Form->input('ClientBank.vc_account_holder_name', array('label' => false,
                            'div' => false,
                            'type' => 'text',
                            'maxlength' => 100,
                            'class' => 'round'));
                        ?></td>
                    <td width="24%" height="30" align="left" valign="top"><label class="lab-inner">Bank Account No. :</label></td>
                    <td width="25%" height="30" align="left" valign="top"><?php
                        echo $this->Form->input('ClientBank.vc_bank_account_no', array('label' => false,
                            'div' => false,
                            'type' => 'text',
                            'maxlength' => 25,
                            'class' => 'round'));
                        ?></td>
                          </tr>
                          <tr>
                            <td width="23%" height="30" align="left" valign="top"><label class="lab-inner">Account Type :</label></td>
                    <td width="28%" height="30" align="left" valign="top"><?php echo $this->Form->input('ClientBank.vc_account_type', array('div' => false, 'class' => 'round_select', 'label' => false, 'type' => 'select', 'default' => '', 'options' => array('' => 'Select') + $accountType)) ?></td>
                    <td width="24%" height="30" align="left" valign="top"><label class="lab-inner">Bank Name :</label></td>
                    <td width="25%" height="30" align="left" valign="top"><?php echo $this->Form->input('ClientBank.vc_bank_name', array('div' => false, 'class' => 'round_select', 'label' => false, 'type' => 'select', 'default' => '', 'options' => array('' => 'Select') + $flrBank)) ?>
                    </td>
                          </tr>
                          <tr>
                            <td width="23%" height="30" align="left" valign="top"><label class="lab-inner">Branch Name :</label></td>
                    <td width="28%" height="30" align="left" valign="top">
                        <?php echo $this->Form->input('ClientBank.vc_bank_branch_name', array('div' => false, 'class' => 'round_select', 'label' => false, 'type' => 'select', 'default' => '', 'options' => array('' => ' Select ') + $bankbranch)) ?>
                    </td>
                    <td width="24%" height="30" align="left" valign="top"><label class="lab-inner">Branch Code :</label></td>
                    <td width="25%" height="30" align="left" valign="top"><?php
                        echo $this->Form->input('ClientBank.vc_branch_code', array('label' => false,
                            'div' => false,
                            'type' => 'text',
                            'readonly' => 'readonly',
                            'maxlength' => 50,
                            'class' => 'round disabled-field'));
							
							 
                        ?>
                    </td>
                          </tr>
                          <tr>
                            <td width="23%" height="30" align="left" valign="top"><label class="lab-inner">Upload Document :</label></td>
                    <td width="28%" height="30" align="left" valign="top"><?php
                        echo $this->Form->input('ClientUploadDocs.bankdoc', array('label' => false,
                            'div' => false,
                            'type' => 'file',
                            'class' => 'uploadfile'));
                        ?></td>
                    <td width="24%" height="30" align="left" valign="top">&nbsp;</td>
                    <td width="25%" height="30" align="left" valign="top">&nbsp;</td>
                          </tr>
                          <tr>
                            <td width="23%" height="30" align="left" valign="top">&nbsp;</td>
                            <td width="28%" height="30" align="left" valign="top">&nbsp;</td>
                            <td width="24%" height="30" align="left" valign="top">&nbsp;</td>
                            <td width="25%" height="30" align="left" valign="top">&nbsp;</td>
                          </tr>
                        </table></td>
                      </tr>
                    </table></td>
                </tr>
                
                
                
                
                
                <tr>
                    <td align="left" valign="top">&nbsp;</td>
                    <td align="left" valign="top">&nbsp;</td>
                    <td align="left" valign="top">&nbsp;</td>
                    <td align="left" valign="top">&nbsp;</td>
                    <td align="left" valign="top">&nbsp;</td>
                    <td align="left" valign="top">&nbsp;</td>
                </tr>

            </table>
			<table  width="100%" border="0" cellpadding="3" >

				<tr>

					<td   width='50%' colspan='3' align="right" valign="top">
						<?php echo $this->Form->submit('Submit', array('div' => false, 'label' => false, 'type' => 'submit', 'class' => 'submit', 'value' => 'submit')); ?>
					</td>
					<td    width='50%'  colspan ='3' align="left" valign="top">
						<?php echo $this->Form->submit('Reset', array('div' => false, 'label' => false, 'type' => 'reset', 'class' => 'submit', 'value' => 'Reset')); ?>
					</td>

			  </tr>

			</table>
            
          
            <?php echo $this->Form->end(null); ?>	
        </div>
        <!-- end innerbody here-->
		
    </div>
    <!-- end mainbody here-->    
</div>
<?php  echo $this->Html->script('flr/index'); ?>
<?php  echo $this->element('commonmessagepopup'); ?>
<?php echo $this->element('commonbackproceesing'); ?>