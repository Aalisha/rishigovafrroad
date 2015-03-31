<!-- Start breadcrumb here-->
<div class="breadcrumb">
    <ul>
        <li class="first">
            <?php echo $this->Html->link('Home', array('controller' => 'profiles', 'action' => 'index'), array('title' => 'Home', 'class' => 'vtip')) ?>
        </li>
        <li class="last">View Transfer Request</li>        
    </ul>
</div>
<!-- end breadcrumb here-->

<!-- Start mainbody here-->
<div class="mainbody">
    <h1><?php echo $mdclocal; ?></h1>
    <h3>Customer Detail</h3>
	<div class="innerbodyHeader">
<?php echo $this->Form->create('VehicleRegistrationCompany', array('url' => array('controller' => 'vehicles', 'action' => 'companysubmit'), 'type' => 'file','enctype'=>'multipart/form-data')); ?>
           <table> <tr>
                <td align="left" width="2%">
				Company Name :</td>
				<td width="16%"><?php
                        echo $this->Form->input('VehicleDetail.nu_company_id', array('label' => false,
                            'div' => false,
                            'type' => 'select',
                            'tabindex'=>'3',
							'required' => 'required',
                            'options' => $CompanyId,
                            'default' => $nu_company_id,
                            'onchange' => "formsubmit('VehicleRegistrationCompanyVehicletransferlistForm');",
                            'maxlength' => 30,
                            'class' => 'round_select')
                        );
                        ?></td>
            </tr></table>
						<?php echo $this->Form->end(null); ?>
	</div>
    <!-- Start innerbody here-->
    <div class="innerbody">
        <table width="100%" border="0" cellpadding="3">
            <tr>
                <td><label class="lab-inner">RFA Account No. :</label></td>
                <td>
                    <?php
                    echo $this->Form->input('VehicleHeader.vc_customer_no', array('label' => false,
                        'div' => false,
                        'type' => 'text',
                        'id' => 'vc_customer_no',
                        'readonly' => 'readonly',
                        'disabled' => true,
                        'value' => $customerdetails['Profile']['vc_customer_no'],
                        'class' => 'round'));
                    ?>

                </td>
                <td><label class="lab-inner">Account opp. date :</label></td>
                <td>
                    <?php
                    $AccOpeDate = !empty($customerdetails['Profile']['dt_account_create_date']) ?
                            date('d M Y', strtotime($customerdetails['Profile']['dt_account_create_date'])) :
                            '';
                    echo $this->Form->input('VehicleHeader.dt_account_create_date', array('label' => false,
                        'div' => false,
                        'type' => 'text',
                        'id' => 'dt_account_opened_date',
                        'disabled' => true,
                        'readonly' => 'readonly',
                        'value' => $AccOpeDate,
                        'class' => 'round'));
                    ?>

                </td>
                <td><label class="lab-inner">Customer Id :</label></td>
                <td>
                    <?php
                    echo $this->Form->input('VehicleHeader.vc_customer_id', array('label' => false,
                        'div' => false,
                        'type' => 'text',
                        'id' => 'vc_customer_id',
                        'disabled' => true,
                        'readonly' => 'readonly',
                        'value' => $customerdetails['Profile']['vc_customer_id'],
                        'class' => 'round'));
                    ?>

                </td>
            </tr>
            <tr>
                <td><label class="lab-inner">Customer Name :</label></td>
                <td>
                    <?php
                    echo $this->Form->input('VehicleHeader.vc_customer_name', array('label' => false,
                        'div' => false,
                        'type' => 'text',
                        'id' => 'vc_customer_name',
                        'disabled' => true,
                        'readonly' => 'readonly',
                        'value' => $customerdetails['Profile']['vc_customer_name'],
                        'class' => 'round'));
                    ?>
                    <!--<input type="text" class="round" />-->
                </td>
                <td><label class="lab-inner">Street Name :</label></td>
                <td>
                    <?php
                    echo $this->Form->input('VehicleHeader.vc_address1', array('label' => false,
                        'div' => false,
                        'type' => 'text',
                        'id' => 'vc_address1',
                        'disabled' => true,
                        'readonly' => 'readonly',
                        'value' => $customerdetails['Profile']['vc_address1'],
                        'class' => 'round'));
                    ?>
                </td>
                <td><label class="lab-inner">House No. :</label></td>
                <td>
                    <?php
                    echo $this->Form->input('VehicleHeader.vc_address2', array('label' => false,
                        'div' => false,
                        'type' => 'text',
                        'id' => 'vc_address2',
                        'disabled' => true,
                        'readonly' => 'readonly',
                        'value' => $customerdetails['Profile']['vc_address2'],
                        'class' => 'round'));
                    ?>


                </td>
            </tr>
            <tr>
			
                <td><label class="lab-inner">P.O Box :</label></td>
                <td>
                    <?php
                    echo $this->Form->input('VehicleHeader.vc_po_box', array('label' => false,
                        'div' => false,
                        'type' => 'text',
                        'id' => 'vc_po_box',
                        'disabled' => true,
                        'readonly' => 'readonly',
                        'value' => $customerdetails['Profile']['vc_address3'],
                        'class' => 'round'));
                    ?>


                </td>
				<td><label class="lab-inner">Town/City :</label></td>
				<td>
				
				<?php
                    echo $this->Form->input('VehicleHeader.vc_town', array('label' => false,
                        'div' => false,
                        'type' => 'text',
                        'id' => 'vc_town',
                        'disabled' => true,
                        'readonly' => 'readonly',
                        'value' => $customerdetails['Profile']['vc_town'],
                        'class' => 'round'));
                    ?>
				
				</td>
                <td><label class="lab-inner">Telephone No. :</label></td>
                <td>
                    <?php
                    echo $this->Form->input('VehicleHeader.vc_tel_no', array('label' => false,
                        'div' => false,
                        'type' => 'text',
                        'id' => 'vc_tel_no',
                        'disabled' => true,
                        'readonly' => 'readonly',
                        'value' => $customerdetails['Profile']['vc_tel_no'],
                        'class' => 'round'));
                    ?>

                </td>
			</tr>
				<tr>
                <td><label class="lab-inner">Fax No. :</label></td>
                <td>
                    <?php
                    echo $this->Form->input('VehicleHeader.vc_fax_no', array('label' => false,
                        'div' => false,
                        'type' => 'text',
                        'id' => 'vc_fax_no',
                        'disabled' => true,
                        'readonly' => 'readonly',
                        'value' => $customerdetails['Profile']['vc_fax_no'],
                        'class' => 'round'));
                    ?>

                </td>
            
            
                <td><label class="lab-inner">Mobile No. :</label></td>
                <td>
                    <?php
                    echo $this->Form->input('VehicleHeader.vc_mobile_no', array('label' => false,
                        'div' => false,
                        'type' => 'text',
                        'id' => 'vc_mobile_no',
                        'disabled' => true,
                        'readonly' => 'readonly',
                        'value' => $customerdetails['Profile']['vc_mobile_no'],
                        'class' => 'round'));
                    ?>

                </td>
                <td><label class="lab-inner">Email :</label></td>
                <td>
                    <?php
                    echo $this->Form->input('VehicleHeader.vc_email', array('label' => false,
                        'div' => false,
                        'type' => 'text',
                        'id' => 'vc_email',
                        'disabled' => true,
                        'readonly' => 'readonly',
                        'value' => $customerdetails['Profile']['vc_email_id'],
                        'class' => 'round'));
                    ?>
                </td>
			<tr>
                <td><label class="lab-inner">Customer Type :</label></td>
                <td>
                    <?php
                    echo $this->Form->input('VehicleHeader.vc_cust_type', array('label' => false,
                        'div' => false,
                        'type' => 'text',
                        'id' => 'vc_cust_type',
                        'disabled' => true,
                        'readonly' => 'readonly',
                        'value' => $customerdetails['VC_CUST_TYPE']['vc_prtype_name'],
                        'class' => 'round'));
                    ?>
                </td>
            </tr>
        </table>
    </div>
    <!-- end innerbody here-->

    <!-- end innerbody here-->
    <h3>View Vehicle Transfer Request</h3>
    <!-- Start innerbody here-->
    <div class="innerbody">
        <table width="100%" cellspacing="1" cellpadding="5" border="0" >
            <tr class="listhead vehicleRegsPag">
                <td width="10%">SI.No.</td>
                <td width="20%">Change <br/>Requested date</td>
                <td width="15%">Vehicle License No.</td>
                <td width="15%">Vehicle Register No.</td>
                <td width="20%">Customer Name</td>
                <td width="40%">Request Status</td>
            </tr>
            <?php 
			if (count($ownershipchangedetails) > 0) : ?>	
                <?php
                $i = 1;
                foreach ($ownershipchangedetails as $key => $showdata) : $sr = $i % 2 == 0 ? '' : '1';
                   			
 
					
					?>
                    <tr class="cont<?php echo $sr; ?>">
                        <td align="center"><?php echo $i;?></td>
                        <td>
						<?php echo date('d M Y',strtotime($showdata['VehicleAmendment']['dt_amend_date']));?>
						<?php echo '<br/>';
								if($showdata['VehicleAmendment']['ch_doc_upload']=='Y'){

									//echo $globalParameterarray[$val['Company']['vc_bank_supportive_doc']];			

									echo '<br>';
									
									$url =$this->webroot."vehicles/downloadammned/V/".base64_encode($showdata['VehicleAmendment']['vc_vehicle_amend_no']);
									?>
									<a href="<?php  echo $url;?>">Download Doc.</a>
									<?php 								 
									echo '<br>';

									}
						?>
						</td>
                        <td ><?php echo $showdata['VehicleAmendment']['vc_vehicle_lic_no'];?></td>
                        <td ><?php echo $showdata['VehicleAmendment']['vc_vehicle_reg_no'];?></td>
                        <td ><?php echo ucfirst($showdata['VehicleAmendment']['vc_customer_name']);?></td>
                        <td ><?php 
						
						echo $globalParameterarray[$showdata['VehicleAmendment']['ch_approve']]; 
					
						if($showdata['VehicleAmendment']['ch_approve']=='STSTY05'){?>
						<br><b>Remarks</b> &nbsp;:&nbsp;&nbsp;<?php
						echo $showdata['VehicleAmendment']['vc_remarks'];
						}
						?></td>
                    <tr>

                        <?php
                        $i++;
                    endforeach;
                    ?>

                <?php else : ?>

                <tr class="cont1">
                    <td colspan='5' style="text-align:center;" > No Record Found </td>
                </tr>
            <?php endif; ?>
            <?php echo $this->element('paginationfooter');   ?>
        </table> 

    </div>
    <!-- end innerbody here-->  
</div>	
<?php echo $this->element('commonmessagepopup');  ?>
<?php //echo $this->element('commonbackproceesing');  ?>		
<?php echo $this->Html->script('mdc/vehicles-view'); ?>