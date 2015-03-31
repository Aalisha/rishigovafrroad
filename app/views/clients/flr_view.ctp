<!-- Start wrapper here -->
<div class="wrapper">
    <!-- Start breadcrumb here-->
    <div class="breadcrumb">
        <ul>
            <li class="first">
                <?php echo $this->Html->link('Home', array('controller' => 'clients', 'action' => 'view', 'flr' => true), array('title' => 'Home', 'class' => 'vtip'))
                ?>           
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
                    <td height="35" colspan="6" align="right" valign="middle">Account Status: <strong><?php echo $this->Session->read('Auth.Status.vc_prtype_name'); ?></strong> </td>
                </tr>
                <tr>
                    <td width="15%" align="left" valign="top">
                        <label class="lab-inner">Business Reg. Id :</label>
                    </td>
                    <td width="20%" align="left" valign="top">
                        <?php
                        echo $this->Form->input('Client.vc_id_no', array('label' => false,
                            'div' => false,
                            'type' => 'text',
                            'disabled' => 'disabled',
                            'class' => 'round',
                            'value' => $this->Session->read('Auth.Client.vc_id_no'),
                        ));
                        ?>
                    </td>
                    <td width="15%" align="left" valign="top">
                        <label class="lab-inner">Client Name :</label>
                    </td>
                    <td width="19%" align="left" valign="top">
                        <?php
                        echo $this->Form->input('Client.vc_client_name', array('label' => false,
                            'div' => false,
                            'type' => 'text',
                            'disabled' => 'disabled',
                            'class' => 'round',
                            'value' => $this->Session->read('Auth.Client.vc_client_name'),
                        ));
                        ?>
                    </td>
                    <td width="16%" align="left" valign="top">
                        <label class="lab-inner">Contact Person :</label>
                    </td>
                    <td width="17%" align="left" valign="top">
                        <?php
                        echo $this->Form->input('Client.vc_contact_person', array('label' => false,
                            'div' => false,
                            'disabled' => 'disabled',
                            'class' => 'round',
                            'value' => $this->Session->read('Auth.Client.vc_contact_person'),
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
                    <td width="17%" align="left" valign="top">&nbsp;</td>
                </tr>

                <tr>
                    <td width="15%" align="left" valign="top"><label class="lab-inner">Address 1 :</label></td>
                    <td width="20%" align="left" valign="top">
                        <?php
                        echo $this->Form->input('Client.vc_address1', array('label' => false,
                            'div' => false,
                            'type' => 'text',
                            'disabled' => 'disabled',
                            'class' => 'round',
                            'value' => $this->Session->read('Auth.Client.vc_address1'),
                        ));
                        ?>

                    </td>
                    <td width="15%" align="left" valign="top"><label class="lab-inner">Address 2 :</label></td>
                    <td width="19%" align="left" valign="top">
                        <?php
                        echo $this->Form->input('Client.vc_address2', array('label' => false,
                            'div' => false,
                            'type' => 'text',
                            'disabled' => 'disabled',
                            'class' => 'round',
                            'value' => $this->Session->read('Auth.Client.vc_address2')
                        ));
                        ?>
                    </td>
                    <td width="16%" align="left" valign="top"><label class="lab-inner">Address 3 :</label></td>
                    <td width="17%" align="left" valign="top">
                        <?php
                        echo $this->Form->input('Client.vc_address3', array('label' => false,
                            'div' => false,
                            'type' => 'text',
                            'disabled' => 'disabled',
                            'class' => 'round',
                            'value' => $this->Session->read('Auth.Client.vc_address3'),
                        ));
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
                            'disabled' => 'disabled',
                            'class' => 'round',
                            'value' => $this->Session->read('Auth.Client.vc_postal_code1'),
                        ));
                        ?>
                    </td>
                    <td width="15%" align="left" valign="top"><label class="lab-inner">Tel. No. :</label></td>
                    <td width="19%" align="left" valign="top">
                        <?php
                        echo $this->Form->input('Client.vc_tel_no', array('label' => false,
                            'div' => false,
                            'type' => 'text',
                            'disabled' => 'disabled',
                            'class' => 'round',
                            'value' => $this->Session->read('Auth.Client.vc_tel_no')
                        ));
                        ?>
                    </td>
                    <td width="16%" align="left" valign="top"><label class="lab-inner">Mobile No. :</label></td>
                    <td width="17%" align="left" valign="top">
                        <?php
                        echo $this->Form->input('Client.vc_cell_no', array('label' => false,
                            'div' => false,
                            'type' => 'text',
                            'disabled' => 'disabled',
                            'class' => 'round',
                            'value' => $this->Session->read('Auth.Client.vc_cell_no'),
                        ));
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
                            'disabled' => 'disabled',
                            'class' => 'round',
                            'value' => $this->Session->read('Auth.Client.vc_fax_no'),
                        ));
                        ?>

                    </td>
                    <td align="left" valign="top"><label class="lab-inner">Email :</label></td>
                    <td width="19%" align="left" valign="top">
                        <?php

                        echo $this->Form->input('Client.vc_email', array('label' => false,
                            'div' => false,
                            'type' => 'text',
                            'disabled' => 'disabled',
                            'value' => trim($this->Session->read('Auth.Member.vc_email_id')),
                            'class' => 'round'
                        ));
                        ?>

                    </td>
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
                    <td width="15%" height="30" align="left" valign="middle"><label class="lab-inner"><strong style="text-decoration:underline;">Business Address </strong></label></td>
                    <td width="20%" align="left" valign="middle" style="font-size:11px;">
                    <td width="15%" align="left" valign="top">&nbsp;</td>
                    <td width="19%" align="left" valign="top">&nbsp;</td>
                    <td width="16%" align="left" valign="top">&nbsp;</td>
                    <td width="17%" align="left" valign="top">&nbsp;</td>
                </tr>
                <tr>
                    <td width="15%" align="left" valign="top"><label class="lab-inner">Address 1 :</label></td>
                    <td width="20%" align="left" valign="top">
                        <?php
                        echo $this->Form->input('Client.vc_address4', array('label' => false,
                            'div' => false,
                            'type' => 'text',
                            'disabled' => 'disabled',
                            'class' => 'round',
                            'value' => $this->Session->read('Auth.Client.vc_address4'),
                        ));
                        ?>
                    </td>
                    <td align="left" valign="top"><label class="lab-inner">Address 2 :</label></td>
                    <td width="19%" align="left" valign="top">
                        <?php
                        echo $this->Form->input('Client.vc_address5', array('label' => false,
                            'div' => false,
                            'type' => 'text',
                            'disabled' => 'disabled',
                            'class' => 'round',
                            'value' => $this->Session->read('Auth.Client.vc_address5')
                        ));
                        ?>
                    </td>
                    <td width="16%" align="left" valign="top"><label class="lab-inner">Address 3 :</label></td>
                    <td width="17%" align="left" valign="top">
                        <?php
                        echo $this->Form->input('Client.vc_address6', array('label' => false,
                            'div' => false,
                            'type' => 'text',
                            'disabled' => 'disabled',
                            'class' => 'round',
                            'value' => $this->Session->read('Auth.Client.vc_address6')
                        ));
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
                            'disabled' => 'disabled',
                            'class' => 'round',
                            'value' => $this->Session->read('Auth.Client.vc_postal_code2')
                        ));
                        ?>
                    </td>
                    <td align="left" valign="top"><label class="lab-inner">Tel. No. :</label></td>
                    <td width="19%" align="left" valign="top">
                        <?php
                        echo $this->Form->input('Client.vc_tel_no2', array('label' => false,
                            'div' => false,
                            'type' => 'text',
                            'disabled' => 'disabled',
                            'class' => 'round',
                            'value' => $this->Session->read('Auth.Client.vc_tel_no2')
                        ));
                        ?>
                    </td>
                    <td width="16%" align="left" valign="top"><label class="lab-inner">Mobile No. :</label></td>
                    <td width="17%" align="left" valign="top">
                        <?php
                        echo $this->Form->input('Client.vc_cell_no2', array('label' => false,
                            'div' => false,
                            'type' => 'text',
                            'disabled' => 'disabled',
                            'class' => 'round',
                            'value' => $this->Session->read('Auth.Client.vc_cell_no')
                        ));
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
                            'disabled' => 'disabled',
                            'class' => 'round',
                            'value' => $this->Session->read('Auth.Client.vc_fax_no')
                        ));
                        ?>

                    </td>
                    <td align="left" valign="top"><label class="lab-inner">Email :</label></td>
                    <td width="19%" align="left" valign="top">
                        <?php
                        echo $this->Form->input('Client.vc_email2', array('label' => false,
                            'div' => false,
                            'type' => 'text',
                            'disabled' => 'disabled',
                            'class' => 'round',
                            'value' => $this->Session->read('Auth.Client.vc_email2'),
                        ));
                        ?>
                    </td>
                    <td width="16%" align="left" valign="top">&nbsp;</td>
                    <td width="17%" align="left" valign="top">&nbsp;</td>
  </tr>
</table>
            <table width="100%" border="0" cellpadding="3">
                <tr>
                    <td width="15%" align="left" valign="top">&nbsp;</td>
                    <td width="19%" align="left" valign="top">&nbsp;</td>
                    <td width="15%" align="left" valign="top">&nbsp;</td>
                    <td width="19%" align="left" valign="top">&nbsp;</td>
                    <td width="16%" align="left" valign="top">&nbsp;</td>
                    <td width="17%" align="left" valign="top">&nbsp;</td>
                </tr>
                <tr>
                    <td width="15%" align="left" valign="top"><label class="lab-inner">Client Category :</label></td>
                    <td width="19%" align="left" valign="top">
                        <?php
                        echo $this->Form->input('ClientHeader.vc_cateogry', array('div' => false,
                            'label' => false,
                            'type' => 'select',
                            'disabled' => 'disabled',
                            'selected' => $this->Session->read('Auth.ClientHeader.category'),
                            'options' => array($this->Session->read('Auth.ClientHeader.category')),
                            'class' => 'round_select'
                        ));
                        ?>
                    </td>
                    <td width="15%" align="left" valign="top"><label class="lab-inner">Refund % :</label></td>
                    <td width="19%" valign="top"><?php
                        echo $this->Form->input('ClientHeader.nu_refund', array('label' => false,
                            'div' => false,
                            'type' => 'text',
                            'disabled' => 'disabled',
                            'class' => 'round number-right',
                            'value' => $this->Session->read('Auth.ClientHeader.nu_refund')
                        ));
                        ?>
                    </td>
                  <td width="16%" align="left" valign="top">Fuel Usage Prev. Year  :</td>
                    <td width="17%" valign="top"><?php
                        echo $this->Form->input('ClientHeader.nu_fuel_usage', array('label' => false,
                            'div' => false,
                            'type' => 'text',
                            'disabled' => 'disabled',
                            'class' => 'round number-right',
                            'value' => number_format($this->Session->read('Auth.ClientHeader.nu_fuel_usage'))
                        ));
                        ?></td>
                </tr>
				<?php
				 $vc_cateogry = $this->Session->read('Auth.ClientHeader.vc_cateogry');
				
				?>
				<tr id="rowid_agriculture" <?php
				if($vc_cateogry=='A' || $vc_cateogry=='L'){
				}else{
				?>
				style="display:none;"
				<?php
				 }
				?>>
                    <td width="15%" align="left" valign="top"></td>
                    <td width="20%" align="left" valign="top">
					<fieldset><legend>Agriculture</legend>
					<table border='0' cellpadding='3' width='100%'>
					<tr>
					<td  style='width:50px;'>Agronomic &nbsp;(%)&nbsp;:</td><td><?php
					
							
                        echo $this->Form->input('ClientHeader.nu_agronomic_percnt', array('label' => false,
                            'div' => false,
							'value'=>$this->Session->read('Auth.ClientHeader.nu_agronomic_percnt'),
                            'type' => 'text',
                             'maxlength' => 10,
                            'disabled' => 'disabled',
                             'style' => 'width:50px;',
                            'class' => 'round'));//NU_AGRONOMIC_PERCNT
                        ?></td>
					</tr>
					<tr>
					<td  style='width:50px;'>Livestock&nbsp;(%)&nbsp;:</td><td><?php
                        echo $this->Form->input('ClientHeader.nu_livestock_percnt', array('label' => false,
                            'div' => false,
                            'type' => 'text',
							'value'=>$this->Session->read('Auth.ClientHeader.nu_livestock_percnt'),
                             'maxlength' => 10,
                            'disabled' => 'disabled',
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
				
				
				<tr id="rowid_construction"  <?php
				//if($vc_cateogry =='C' || $vc_cateogry == 'B')
				if($vc_cateogry=='C' || $vc_cateogry=='B'){
				}else{
				?>
				style="display:none;"
				<?php
				}
				?>
				>
                    <td width="15%" align="left" valign="top"></td>
                    <td width="20%" align="left" valign="top">
					<fieldset><legend>Construction</legend>
					<table border='0' cellpadding='3' width='100%'>
					<tr>
					<td  style='width:50px;'>Building&nbsp;(%)&nbsp;:</td><td><?php
                        echo $this->Form->input('ClientHeader.nu_building_percnt', array('label' => false,
                            'div' => false,
                            'type' => 'text',
								'value'=>$this->Session->read('Auth.ClientHeader.nu_building_percnt'),
                             'maxlength' => 10,
                            'disabled' => 'disabled',
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
                            'disabled' => 'disabled',
							 'value'=>$this->Session->read('Auth.ClientHeader.nu_civil_percnt'),
                             'style' => 'width:50px;',
                            'class' => 'round'));//NU_AGRONOMIC_PERCNT
                        ?></td>
					</tr>
					</table>
					</fieldset>
					
					<?php
                       
                        ?></td>
                    <td width="15%" align="left" valign="top"></td>
                    <td width="19%" align="left" valign="top">
					</td>
                    <td width="16%" align="left" valign="top">&nbsp;</td>
                    <td width="17%" align="left" valign="top">&nbsp;</td>
                </tr>
				
                <tr>
                    <td width="15%" align="left" valign="top"> <label class="lab-inner">Expected Usages Next Year  :</label></td>
                    <td width="19%" valign="top"><?php
                        echo $this->Form->input('ClientHeader.nu_expected_usage', array('label' => false,
                            'div' => false,
                            'type' => 'text',
                            'disabled' => 'disabled',
                            'class' => 'round number-right',
                            'value' => number_format($this->Session->read('Auth.ClientHeader.nu_expected_usage'))
                        ));
                        ?></td>
                    <td width="15%" align="left" valign="top"> <label class="lab-inner">Off Road Usage Prev. Year :</label></td>
                    <td width="19%" valign="top"><?php
                        echo $this->Form->input('ClientHeader.nu_off_road_usage', array('label' => false,
                            'div' => false,
                            'type' => 'text',
                            'disabled' => 'disabled',
                            'class' => 'round number-right',
                            'value' => number_format($this->Session->read('Auth.ClientHeader.nu_off_road_usage'))
                        ));
                        ?></td>
                  <td width="16%" align="left" valign="top">Off Road Usages Next Year :</td>
                    <td width="17%" valign="top">
                        <?php
                        echo $this->Form->input('ClientHeader.nu_off_expected_usage', array('label' => false,
                            'div' => false,
                            'type' => 'text',
                            'disabled' => 'disabled',
                            'class' => 'round number-right',
                            'value' => number_format($this->Session->read('Auth.ClientHeader.nu_off_expected_usage'))
                        ));
                        ?>
                    </td>
                </tr>
                <tr>
                    <td width="15%" align="left" valign="top"><label class="lab-inner">Download Refund Document :</label></td>
                    <td width="19%" align="left" valign="top">
                        <?php
                        $url = $this->Html->url(array('controller' => 'clients', 'action' => 'downloadrefunddoc'));
                        echo $this->Form->button('Click Here', array(
                            'label' => false,
                            'div' => false,
                            'type' => 'button',
                            'onclick' => "window.location='" . $url . "'",
                            'class' => 'uploadfile'));
                        ?>
                    </td>
                    <td width="15%" align="left" valign="top">&nbsp;</td>
                    <td width="19%" align="left" valign="top">&nbsp;</td>
                    <td width="16%" align="left" valign="top">&nbsp;</td>
                    <td width="17%" align="left" valign="top">&nbsp;</td>
                </tr>
                <tr>
                    <td width="15%" align="left" valign="top">&nbsp;</td>
                    <td width="19%" align="left" valign="top">&nbsp;</td>
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
                            <td width="25%" height="30" align="left" valign="top">&nbsp;</td>
                          </tr>
                          <tr>
                            <td width="15%" height="30" align="left" valign="top">

                        <?php if (count($this->Session->read('Auth.ClientFuelOutlet')) > 0) : ?>

                            <?php foreach ($this->Session->read('Auth.ClientFuelOutlet') as $key => $value) : ?>
                                <div class='outletslist'>	
                                    <?php
                                    echo $this->Form->input('ClientFuelOutlet.fueloutlets.' . $key, array('div' => false,
                                        'label' => false,
                                        'class' => 'round_select5',
										'disabled'=>true,
										'readonly'=>true,
                                        'type' => 'select',
                                        'default' => trim($value['vc_fuel_outlet']),
                                        'options' => array('' => 'Select') + $flrFuelOutLet
                                     ));
                                    ?>
                                </div>
                                <?php
                                if (trim($value['vc_fuel_outlet']) != ''): unset($flrFuelOutLet[$value['vc_fuel_outlet']]);
                                endif;
                            endforeach;
                            ?>

                        <?php else : ?>
                            <div class='outletslist' >	
                                <?php echo $this->Form->input('ClientFuelOutlet.fueloutlets.0',
                                        array('div' => false, 'label' => false, 'class' => 'round', 
                                            'type' => 'select', 'default' => '', 
                                            'options' => array('' => 'Select') + $flrFuelOutLet)) 
                                ?>
                            </div>	
                        <?php endif; ?>
                    </td>
                            <td width="25%" height="30" align="left" valign="top">&nbsp;</td>
                          </tr>
                          <tr>
                            <td width="75%" height="30" align="left" valign="top">&nbsp;</td>
                            <td width="25%" height="30" align="left" valign="top">&nbsp;</td>
                          </tr>
                          <tr>
                            <td width="75%" height="30" align="left" valign="top">&nbsp;</td>
                            <td width="25%" height="30" align="left" valign="top">&nbsp;</td>
                          </tr>
                          <tr>
                            <td width="75%" height="30" align="left" valign="top">&nbsp;</td>
                            <td width="25%" height="30" align="left" valign="top">&nbsp;</td>
                          </tr>
                          <tr>
                            <td width="75%" height="30" align="left" valign="top">&nbsp;</td>
                            <td width="25%" height="30" align="left" valign="top">&nbsp;</td>
                          </tr>
                        </table></td>
                        <td width="4%" align="left" valign="top">&nbsp;</td>
                        <td width="65%" align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td width="23%" height="30" align="left" valign="top"><strong style="text-decoration:underline;">Bank Details</strong></td>
                            <td width="28%" height="30" align="left" valign="top">&nbsp;</td>
                            <td width="24%" height="30" align="left" valign="top">&nbsp;</td>
                            <td width="25%" height="30" align="left" valign="top">&nbsp;</td>
                          </tr>
                          <tr>
                            <td width="23%" height="30" align="left" valign="top"> <label class="lab-inner">Account Holder Name :</label></td>
                            <td width="28%" height="30" align="left" valign="top"><?php
                        echo $this->Form->input('ClientBank.vc_account_holder_name', array('label' => false,
                            'div' => false,
                            'type' => 'text',
                            'disabled' => 'disabled',
                            'class' => 'round',
                            'value' => $this->Session->read('Auth.ClientBank.vc_account_holder_name')
                        ));
                        ?></td>
                            <td width="24%" height="30" align="left" valign="top"><label class="lab-inner">Bank Account No. :</label></td>
                            <td width="25%" height="30" valign="top"><?php
                        echo $this->Form->input('ClientBank.vc_bank_account_no', array('label' => false,
                            'div' => false,
                            'type' => 'text',
                            'disabled' => 'disabled',
                            'class' => 'round number-right',
                            'value' => $this->Session->read('Auth.ClientBank.vc_bank_account_no')
                        ));
                        ?></td>
                          </tr>
                          <tr>
                            <td width="23%" height="30" align="left" valign="top"> <label class="lab-inner">Account Type :</label></td>
                            <td width="28%" height="30" align="left" valign="top"><?php
                        echo $this->Form->input('ClientBank.vc_account_type', array('div' => false,
                            'label' => false,
                            'type' => 'select',
                            'disabled' => 'disabled',
                            'selected' => $this->Session->read('Auth.ClientBank.vc_account_type'),
                            'options' => array($this->Session->read('Auth.ClientBank.vc_account_type')),
                            'class' => 'round_select'
                        ));
                        ?></td>
                            <td width="24%" height="30" align="left" valign="top"><label class="lab-inner">Bank Name :</label></td>
                            <td width="25%" height="30" align="left" valign="top"><?php
                        echo $this->Form->input('ClientBank.vc_bank_name', array('div' => false,
                            'label' => false,
                            'type' => 'select',
                            'disabled' => 'disabled',
                            'selected' => $this->Session->read('Auth.ClientBank.vc_bank_name'),
                            'options' => array($this->Session->read('Auth.ClientBank.vc_bank_name')),
                            'class' => 'round_select'
                        ));
                        ?></td>
                          </tr>
                          <tr>
                            <td width="23%" height="30" align="left" valign="top"><label class="lab-inner">Branch Name :</label></td>
                            <td width="28%" height="30" align="left" valign="top"><?php
                        echo $this->Form->input('ClientBank.vc_bank_branch_name', array('div' => false,
                            'label' => false,
                            'type' => 'select',
                            'disabled' => 'disabled',
                            'selected' => $this->Session->read('Auth.ClientBank.vc_bank_name'),
                            'options' => array($this->Session->read('Auth.ClientBank.vc_bank_name')),
                            'class' => 'round_select'
                        ));
                        ?></td>
                            <td width="24%" height="30" align="left" valign="top"><label class="lab-inner">Branch Code :</label></td>
                            <td width="25%" height="30" align="left" valign="top"><?php
                        echo $this->Form->input('ClientBank.vc_branch_code', array('label' => false,
                            'div' => false,
                            'type' => 'text',
                            'disabled' => 'disabled',
                            'class' => 'round',
                            'value' => $this->Session->read('Auth.ClientBank.vc_branch_code')
                        ));
                        ?></td>
                          </tr>
                          <tr>
                            <td width="23%" height="30" align="left" valign="top"><label class="lab-inner">Download Doc. :</label></td>
                            <td width="28%" height="30" align="left" valign="top"><?php
                        $url = $this->Html->url(array('controller' => 'clients', 'action' => 'downloadbankdoc'));
                        echo $this->Form->button('Click Here', array(
                            'label' => false,
                            'div' => false,
                            'type' => 'button',
                            'onclick' => "window.location='" . $url . "'",
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
            </table>

            <?php echo $this->Form->end(null); ?>	
        </div>
        <!-- end innerbody here-->

    </div>
    <!-- end mainbody here-->    
</div>
