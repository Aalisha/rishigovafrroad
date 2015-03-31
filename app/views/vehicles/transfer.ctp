<!-- Start breadcrumb here-->

<div class="breadcrumb">
    <ul>
        <li class="first">
            <?php echo $this->Html->link('Home', array('controller' => 'profiles', 'action' => 'index'), array('title' => 'Home', 'class' => 'vtip')) ?>
        </li>
        <li class="last">Vehicle Transfer</li>
    </ul>
</div>
<!-- Start mainbody here-->
<div class="mainbody">
    <h1><?php echo $mdclocal;?></h1>
    <h3>Vehicle Transfer From</h3>
	<div class="innerbodyHeader">
<?php echo $this->Form->create('VehicleRegistrationCompany', array('url' => array('controller' => 'vehicles', 'action' => 'companysubmit'), 'type' => 'file','enctype'=>'multipart/form-data')); ?>
           <table> <tr>
                <td align="left" width="2%">
				Company Name :</td>
				<td width="18%"><?php
                        echo $this->Form->input('VehicleDetail.nu_company_id', array('label' => false,
                            'div' => false,
                            'type' => 'select',
                            'tabindex'=>'3',
							'required' => 'required',
                            'options' => $CompanyId,
                            'default' => $nu_company_id,
                            'onchange' => "formsubmit('VehicleRegistrationCompanyTransferForm');",
                            'maxlength' => 30,
                            'class' => 'round_select')
                        );
                        ?></td>
            </tr></table>
			<?php echo $this->Form->end(null); ?>
</div>
    <!-- Start innerbody here-->
    <?php echo $this->Form->create('Vehicle', array('url' => array('controller' => 'vehicles', 'action' => 'transfer'), 'type' => 'file')); ?>
	
    <div class="innerbody">


        <table width="100%" border="0" cellpadding="3">
            <tr>
                <td><label class="lab-inner">Vehicle LIC. No. :</label></td>
                <td>

                    <?php echo $this->Form->button('Find', array('label' => false, 'onclick' => "pop('VehicleTransferFormSearchPop');", 'div' => false, 'type' => 'button', 'style' => 'margin-left:4px; margin-top:0px;', 'class' => 'round5')); ?>

                    <?php
                    echo $this->Form->input('VehicleAmendment.vc_vehicle_lic_no', array('label' => false,
                        'div' => false,
                        'type' => 'text',
                        'id' => 'vc_vehicle_lic_no',
                        'readonly' => 'readonly',
						'style'=>'width:120px;',
                        'required' => 'required',
                        'class' => 'round'));
                    ?>


                <td><label class="lab-inner">Vehicle Register No. :</label></td>
                <td colspan="2">

                    <?php echo $this->Form->button('Find', array('label' => false, 'onclick' => "pop('VehicleTransferFormSearchPop');", 'div' => false, 'type' => 'button', 'style' => 'margin-left:4px; margin-top:0px;', 'class' => 'round5')); ?>	
                    <?php
                    echo $this->Form->input('VehicleAmendment.vc_vehicle_reg_no', array('label' => false,
                        'div' => false,
                        'type' => 'text',
                        'id' => 'vc_vehicle_reg_no',
                        'readonly' => 'readonly',
                        'required' => 'required',
                        'class' => 'round'));
                    ?>



                </td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td><label class="lab-inner">Customer Name</label></td>
                <td>

                    <?php
                    echo $this->Form->input('VehicleAmendment.vc_customer_name', array('label' => false,
                        'div' => false,
                        'type' => 'text',
                        'id' => 'vc_customer_name',
                        'disabled' => 'disabled',
                        'value' => trim($this->Session->read('Auth.Profile.vc_customer_name')),
                        'class' => 'round'));
                    ?>

                </td>
                <td><label class="lab-inner"> Street Name :</label></td>
                <td>
                    <?php
                    echo $this->Form->input('VehicleAmendment.vc_address1', array('label' => false,
                        'div' => false,
                        'type' => 'text',
                        'id' => 'vc_address1',
                        'disabled' => 'disabled',
                        'value' => trim($this->Session->read('Auth.Profile.vc_address1')),
                        'class' => 'round'));
                    ?>


                </td>
                <td><label class="lab-inner">House No. :</label></td>
                <td>
                    <?php
                    echo $this->Form->input('VehicleAmendment.vc_address2', array('label' => false,
                        'div' => false,
                        'type' => 'text',
                        'id' => 'vc_address2',
                        'disabled' => 'disabled',
                        'value' => trim($this->Session->read('Auth.Profile.vc_address2')),
                        'class' => 'round'));
                    ?>


                </td>
            </tr>
            <tr>
			
                <td><label class="lab-inner">P.O Box :</label></td>
                <td>
                    <?php
                    echo $this->Form->input('VehicleAmendment.vc_po_box', array('label' => false,
                        'div' => false,
                        'type' => 'text',
                        'id' => 'vc_po_box',
                        'disabled' => 'disabled',
                        'value' => trim($this->Session->read('Auth.Profile.vc_address3')),
                        'class' => 'round'));
                    ?>
                </td>
				<td><label class="lab-inner">Town/City :</label></td>
				<td>
				 <?php
                    echo $this->Form->input('VehicleAmendment.vc_town', array('label' => false,
                        'div' => false,
                        'type' => 'text',
                        'id' => 'vc_town',
                        'readonly' => 'readonly',
                        'value' => trim($this->Session->read('Auth.Profile.vc_town')),
                        'class' => 'round'));
                    ?>
				</td>
                <td><label class="lab-inner">Telephone No. :</label></td>
                <td>
                    <?php
                    echo $this->Form->input('VehicleAmendment.vc_telephone_no', array('label' => false,
                        'div' => false,
                        'type' => 'text',
                        'id' => 'vc_telephone_no',
                        'disabled' => 'disabled',
                        'value' => trim($this->Session->read('Auth.Profile.vc_tel_no')),
                        'class' => 'round'));
                    ?>
                </td>
			</tr>	
			<tr>
                <td><label class="lab-inner">Fax No. :</label></td>
                <td>
                    <?php
                    echo $this->Form->input('VehicleAmendment.vc_fax_no', array('label' => false,
                        'div' => false,
                        'type' => 'text',
                        'id' => 'vc_fax_no',
                        'disabled' => 'disabled',
                        'value' => trim($this->Session->read('Auth.Profile.vc_fax_no')),
                        'class' => 'round'));
                    ?>
                </td>
            
            
                <td><label class="lab-inner">Mobile No. :</label></td>
                <td>
                    <?php
                    echo $this->Form->input('VehicleAmendment.vc_mobile_no', array('label' => false,
                        'div' => false,
                        'type' => 'text',
                        'id' => 'vc_mobile_no',
                        'disabled' => 'disabled',
                        'value' => trim($this->Session->read('Auth.Profile.vc_mobile_no')),
                        'class' => 'round'));
                    ?>
                </td>
                
                <td><label class="lab-inner">Upload Document :</label></td>
                <td colspan="2">
                    <?php
                    echo $this->Form->input('DocumentUploadVehicle.vc_uploaded_doc_name', array('label' => false,
                        'div' => false,
                        'type' => 'file',
                        'id' => 'vc_uploaded_doc_name',
                        'class' => 'uplaodfile')
                    );
                    ?>
                </td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                
            </tr>

        </table>

    </div>
    <!-- end innerbody here-->
    <h3>Vehicle Transfer To</h3>
    <!-- Start innerbody here-->
    <div class="innerbody" id='transfercustomer'>
        <table width="100%" border="0" cellpadding="3">
            <tr>
                <td><label class="lab-inner">Customer Name</label></td>
                <td colspan="2">

                    <?php echo $this->Form->button('Find', array('label' => false, 'onclick' => "pop('VehicleTransferFormCustomerSearchPop');", 'div' => false, 'type' => 'button', 'style' => 'margin-left:4px; margin-top:0px;', 'class' => 'round5')); ?>		

                    <?php
                    echo $this->Form->input('VehicleAmendment.to_vc_customer_name', array('label' => false,
                        'div' => false,
                        'type' => 'text',
                        'id' => 'to_vc_customer_name',
                        'readonly' => 'readonly',
                        'value' => '',
                        'class' => 'round'));
                    ?>

                </td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td><label class="lab-inner">Street Name :</label></td>
                <td>
                    <?php
                    echo $this->Form->input('VehicleAmendment.to_vc_address1', array('label' => false,
                        'div' => false,
                        'type' => 'text',
                        'id' => 'to_vc_address1',
                        'disabled' => 'disabled',
                        'value' => '',
                        'class' => 'round'));
                    ?>
                </td>
                <td><label class="lab-inner">House No. :</label></td>
                <td>
                    <?php
                    echo $this->Form->input('VehicleAmendment.to_vc_address2', array('label' => false,
                        'div' => false,
                        'type' => 'text',
                        'id' => 'to_vc_address2',
                        'disabled' => 'disabled',
                        'value' => '',
                        'class' => 'round'));
                    ?>

                </td>
                <td><label class="lab-inner">P.O .Box :</label></td>
                <td>
                    <?php
                    echo $this->Form->input('VehicleAmendment.to_vc_po_box', array('label' => false,
                        'div' => false,
                        'type' => 'text',
                        'id' => 'to_vc_po_box',
                        'disabled' => 'disabled',
                        'value' => '',
                        'class' => 'round'));
                    ?>
                </td>
            </tr>
			
            <tr>
				<td><label class="lab-inner">Town/City :</label></td>
				<td>
				 <?php
                    echo $this->Form->input('VehicleAmendment.vc_town', array('label' => false,
                        'div' => false,
                        'type' => 'text',
                        'id' => 'vc_town',
                              'disabled' => 'disabled',
                        'value' => '',
                        'class' => 'round'));
                    ?>
				</td>
                <td><label class="lab-inner">Telephone No. :</label></td>
                <td>
                    <?php
                    echo $this->Form->input('VehicleAmendment.to_vc_telephone_no', array('label' => false,
                        'div' => false,
                        'type' => 'text',
                        'id' => 'to_vc_telephone_no',
                        'disabled' => 'disabled',
                        'value' => '',
                        'class' => 'round'));
                    ?>
                </td>
                <td><label class="lab-inner">Fax No. :</label></td>
                <td>
                    <?php
                    echo $this->Form->input('VehicleAmendment.to_vc_fax_no', array('label' => false,
                        'div' => false,
                        'type' => 'text',
                        'id' => 'to_vc_fax_no',
                        'disabled' => 'disabled',
                        'value' => '',
                        'class' => 'round'));
                    ?>
                </td>
                
            </tr>
            <tr>
                <td><label class="lab-inner">Mobile No. :</label></td>
                <td>
                    <?php
                    echo $this->Form->input('VehicleAmendment.vc_mobile_no', array('label' => false,
                        'div' => false,
                        'type' => 'text',
                        'id' => 'to_vc_mobile_no',
                        'disabled' => 'disabled',
                        'value' => '',
                        'class' => 'round'));
                    ?>
                </td>
                
                
                <td><label class="lab-inner">Transfer Date :</label></td>
                <td>
                    <?php
                    echo $this->Form->input('VehicleAmendment.dt_amend_date', array('label' => false,
                        'div' => false,
                        'type' => 'text',
                        'id' => 'dt_amend_date',
                        'readonly' => 'readonly',
                        'value' => date('d M Y'),
                        'class' => 'round'));
                    ?>
                </td><td>&nbsp;</td>
                <td>&nbsp;</td>
                
            </tr>

        </table>
    </div>

    <!-- end innerbody here-->    


    <table width="100%" border="0">
        <tr>
            <td align="center"><?php echo $this->Form->submit('Submit', array('type' => 'submit', 'class' => 'submit', 'value' => 'submit')); ?></td>
        </tr>
    </table>

</div>
<!-- end mainbody here-->    
<?php echo $this->Form->end(null); ?>

<div id="VehicleTransferFormSearchPop" class="ontop">
    <div id="popup" class="popup3">
        <?php echo $this->Html->link('Close', 'javascript:void(0);', array('class' => 'close', 'onClick' => 'hide("VehicleTransferFormSearchPop");')); ?>
        <table width="100%" border="0" cellpadding="0" cellspacing="0">
            <tr>
                <td align="left" class="content-area"><div class="listhead-popup">Select Vehicle Lic. No. / Register No.</div></td>
            </tr>
            <tr>
                <td width="100%" align="center" class="content-area">
                    <div class="content-area-outer">
                        <table width="100%" border="0">
                            <tr>
                                <td> 

                                    <?php echo $this->Form->input('search', array('div' => false, 'type' => 'text', 'size' => '21', 'label' => false, 'class' => 'tftextinput', 'maxlength' => '30')); ?>
                                    <?php echo $this->Form->button('search', array('div' => false, 'label' => false, 'type' => 'button', 'value' => 'Search', 'class' => 'tfbutton')); ?>

                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <table width="100%" cellspacing="1" cellpadding="5" border="0" >

                                        <tr class="listhead1">
                                            <td width="10%"> &nbsp; </td>
                                            <!-- <td width="40%" align="left">Customer Name</td> -->
                                            <td width="25%">LIC. No.</td>
                                            <td width="25%">Register No.</td>
                                        </tr>
                                    </table>

                                    <div id='data' class='' >			

                                        <table width="100%" cellspacing="1" cellpadding="5" border="0" >

                                            <?php if (count($data) > 0) : ?>

                                                <?php
                                                $i = 0;
                                                foreach ($data as $values) : $i++;
                                                    $str = ( $i % 2 == 0 ) ? '' : '1';
                                                    ?>

                                                    <tr class="cont<?php echo $str ?>"> 
                                                        <td  width="10%" > <input type='radio' name='getVehicleTransfer' value='<?php echo $values['VehicleDetail']['vc_registration_detail_id']; ?>' /> </td>
                                                       <!-- <td width="40%" align="left"><?php echo $this->Session->read('Auth.Profile.vc_customer_name'); ?></td> -->
                                                        <td width="25%"><?php echo $values['VehicleDetail']['vc_vehicle_lic_no']; ?></td>
                                                        <td width="25%"><?php echo $values['VehicleDetail']['vc_vehicle_reg_no']; ?></td>
                                                    </tr>

                                                <?php endforeach; ?>

                                            <?php else : ?>

                                                <tr class="cont1">

                                                    <td width="100%" colspan='3' align="center"> No Record Found </td>

                                                </tr>

                                            <?php endif; ?>

                                        </table>

                                    </div>

                                </td>
                            </tr>
                        </table>
                    </div>
                </td>
            </tr>
        </table>
    </div>
</div>

<div id="VehicleTransferFormCustomerSearchPop" class="ontop">
    <div id="popup" class="popup3">
        <?php echo $this->Html->link('Close', 'javascript:void(0);', array('class' => 'close', 'onClick' => 'hide("VehicleTransferFormCustomerSearchPop");')); ?>
        <table width="100%" border="0" cellpadding="0" cellspacing="0">
            <tr>
                <td align="left" class="content-area"><div class="listhead-popup">Select Customer Name / RFA No.</div></td>
            </tr>
            <tr>
                <td width="100%" align="center" class="content-area">
                    <div class="content-area-outer">
                        <table width="100%" border="0">
                            <tr>
                                <td> 

                                    <?php echo $this->Form->input('search', array('div' => false, 'type' => 'text', 'size' => '21', 'label' => false, 'class' => 'tftextinput', 'maxlength' => '30')); ?>
                                    <?php echo $this->Form->button('search', array('div' => false, 'label' => false, 'type' => 'button', 'value' => 'Search', 'class' => 'tfbutton')); ?>

                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <table width="100%" cellspacing="1" cellpadding="5" border="0" >

                                        <tr class="listhead1">
                                            <td width="10%"> &nbsp; </td>
                                            <td width="30%" align="left">Customer Name</td>
                                            <td width="30%"> RFA Customer No. </td>
                                            <td width="30%">Company Name </td>

                                        </tr>
                                    </table>

                                    <div id='data' class='' >			

                                        <table width="100%" cellspacing="1" cellpadding="5" border="0" >

                                            <?php 
											//pr($profileData);

											if (count($profileData) > 0) : ?>

                                                <?php
                                                $i = 0;
                                                foreach ($profileData as $values) :

                                                    $i++;

                                                    $str = ( $i % 2 == 0 ) ? '' : '1';
                                                    ?>

                                                    <tr class="cont<?php echo $str ?>"> 

                                                        <td  width="10%" > <input type='radio' name='getCustomerTransfer' value='<?php  echo $values['Company']['nu_company_id']; ?>' /> </td>

                                                        <td width="30%" align="left"><?php echo $values['Company']['vc_customer_name']; ?></td>

                                                        <td width="30%"><?php echo $values['Company']['vc_customer_no']; ?></td>
														<td width="30%"><?php echo $values['Company']['vc_company_name']; ?></td>


                                                    </tr>



                                                <?php endforeach; ?>

                                            <?php else : ?>

                                                <tr class="cont1">

                                                    <td width="100%" colspan='3' align="center"> No Record Found </td>

                                                </tr>

                                            <?php endif; ?>

                                        </table>

                                    </div>

                                </td>
                            </tr>
                        </table>
                    </div>
                </td>
            </tr>
        </table>
    </div>
</div>
<?php 
//pr($sqlResult);
echo $this->Html->script('mdc/vehicle_transfer'); ?>