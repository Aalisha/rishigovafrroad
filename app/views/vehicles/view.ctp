<!-- Start breadcrumb here-->
<div class="breadcrumb">
    <ul>
        <li class="first">
            <?php echo $this->Html->link('Home', array('controller' => 'profiles', 'action' => 'index'), array('title' => 'Home', 'class' => 'vtip')) ?>
        </li>

        <li class="last">View Vehicles </li>        
    </ul>
</div>
<!-- end breadcrumb here-->

<!-- Start mainbody here-->
<div class="mainbody">
    <h1><?php echo $mdclocal;?></h1>
    <h3>Customer Detail</h3>
    <!-- Start innerbody here-->
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
                            'onchange' => "formsubmit('VehicleRegistrationCompanyViewForm');",
                            'maxlength' => 30,
                            'class' => 'round_select')
                        );
                        ?></td>
            </tr></table>
						<?php echo $this->Form->end(null); ?>
						</div>
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
                    <!--<input type="text" class="round" />-->
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
				</tr>
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
                    <!--<input type="text" class="round" />-->
                </td>

            </tr>

        </table>

    </div>
    <!-- end innerbody here-->


    <!-- end innerbody here-->
    <h3>Vehicle Detail</h3>
    <!-- Start innerbody here-->
    <div class="innerbody">
        <table width="100%" cellspacing="1" cellpadding="5" border="0" >
            <tr class="listhead vehicleRegsPag">
                <td width="8%">Vehicle <br/>Status</td>
                <td width="8%">Vehicle <br/>License No.</td>
                <td width="8%">Vehicle <br/>Register No.</td>
                <td width="8%">Pay <br/>Frequency</td>
                <td width="7%">Vehicle <br/>Type</td>
                <td width="7%">Start <br/>Odometer</td>
                <td width="7%">Oper <br/>EST KM</td>
                <td width="5%">GVM <br/>Rating</td>
                <td width="5%">D/T <br/>Rating</td>
                <td width="9%">Predefined <br/>Route</td>
                <td width="9%">Created <br/>Date</td>
				<td width="5%">Remarks</td>
				<td width="5%">Action</td>
				<td width="6%">Rate (N$)</td>
            </tr>
            
                <?php if (count($data) > 0) : ?>	
                    <?php $i = 1;
                    foreach ($data as $key => $showdata) : $sr = $i % 2 == 0 ? '' : '1'; ?>

                        <tr class="cont<?php echo $sr; ?>">

                            <td >
                                <?php
									
									echo $showdata['STATUS']['vc_prtype_name'];
								
                                
                                ?> 

                            </td>
                            <td > 
                                <?php echo wordwrap($showdata['VehicleDetail']['vc_vehicle_lic_no'], 10, "<br>\n", true); ?>
                            </td>
                            <td > 
                                <?php echo wordwrap($showdata['VehicleDetail']['vc_vehicle_reg_no'], 10, "<br>\n", true); ?>
                            </td>
                            <td > <?php echo $showdata['PAYFREQUENCY']['vc_prtype_name']; ?>  </td>
                            <td > <?php echo $showdata['VEHICLETYPE']['vc_prtype_name']; ?>  </td>
                            <td align="right"> 
                                <?php
                                echo $this->Number->format($showdata['VehicleDetail']['vc_start_ometer'], array(
                                    'places' => 0,
                                    'before' => false,
                                    'escape' => false,
                                    'decimals' => false,
                                    'thousands' => ','
                                ));
                                ?>
                            </td>
                            <td align="right"> 
                                <?php
                                echo $this->Number->format($showdata['VehicleDetail']['vc_oper_est_km'], array(
                                    'places' => 0,
                                    'before' => false,
                                    'escape' => false,
                                    'decimals' => false,
                                    'thousands' => ','
                                ));
                                ?>
                            </td>
                            <td align="right"> 

                                <?php 
									echo wordwrap(number_format($showdata['VehicleDetail']['vc_v_rating']), 10, "<br>\n", true);
                                ?>

                            </td>
                            <td  align="right"> 
                                <?php
									echo wordwrap(number_format($showdata['VehicleDetail']['vc_dt_rating']), 10, "<br>\n", true);
                                ?>
                                
                           </td>
                            <td > 
                                <?php echo wordwrap($showdata['VehicleDetail']['vc_predefine_route'], 10, "<br>\n", true); ?>
                            </td>
                            <td > <?php echo date('d M Y', strtotime($showdata['VehicleDetail']['dt_created_date'])); ?></td>
							
							<?php if( trim($showdata['VehicleDetail']['vc_vehicle_status']) == 'STSTY05' ) :  ?>
							
								<td  style='text-align:center;' > <?php echo $this->Html->image('remarks.jpg', array('alt' => '', 'id'=>'imgedt'.$key, 'title'=>'View Remarks','style'=>' cursor: pointer;')); ?></td>
							
							<?php else :  ?>
							
								<td >&nbsp; </td>
							
							<?php endif;  ?>
							
							 <td style='text-align:center;'> 
                                <?php
								
								echo $this->Form->input(null, array('label' => false,
										'div' => false,
										'type' => 'hidden',
										'id'=>false,
										'name'=>false,
										'value'=>base64_encode($showdata['VehicleDetail']['vc_registration_detail_id'])));	
										
								if ($showdata['STATUS']['vc_prtype_code'] == 'STSTY05') :

										$url = $this->webroot . 'vehicles/edit/' . base64_encode($showdata['VehicleDetail']['vc_registration_detail_id']);
									
										echo $this->Html->image('editbutton.png', array('alt' => '', 'title'=>'Edit Vehicle Detail', 'onclick' => "javascript: window.location ='".$url."'", 'style'=>' cursor: pointer;')); 
									
                                   
                                elseif ( $showdata['STATUS']['vc_prtype_code'] == 'STSTY03'  ) :

										$url = $this->webroot . 'vehicles/changedetail/' . base64_encode($showdata['VehicleDetail']['vc_registration_detail_id']);

										echo $this->Html->image('editbutton.png', array('alt' => '', 'title'=>'Change Vehicle Detail', 'onclick' => "javascript: window.location ='".$url."'",'style'=>' cursor: pointer;')); 
	
								else :
								
									echo 'N/A';
								
                                endif;?>
								</td>
								<td > <?php 
								
									if($showdata['STATUS']['vc_prtype_code'] == 'STSTY04'){
									
										echo wordwrap(number_format($showdata['VehicleDetail']['vc_rate'], 2, '.', ','), 5, "<br>\n", true); ?></td>
										
									<?php } else{
												echo 'N/A';
											} ?>
							  
							  <tr>

                            <?php $i++;
                        endforeach; ?>

                    <?php else : ?>

                    <tr class="cont1">
                        <td colspan='14' style="text-align:center;" > No Record Found </td>

                    </tr>

                <?php endif; ?>
                <?php echo $this->element('paginationfooter'); ?>
            </table> 

       

    </div>
    <!-- end innerbody here-->  
</div>	
<?php echo $this->element('commonmessagepopup'); ?>

<?php echo $this->element('commonbackproceesing'); ?>
		
<?php echo $this->Html->script('mdc/vehicles-view'); ?>