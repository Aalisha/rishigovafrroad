<?php $profile = $this->Session->read('Auth');  ?>

<!-- Start breadcrumb here-->
<div class="breadcrumb">
    <ul>
        <li class="first">
            <?php echo $this->Html->link('Home', array('controller' => 'profiles', 'action' => 'index'), array('title' => 'Home', 'class' => 'vtip')) ?>
        </li>

        <li class="last">View Operator Vehicles Log Detail</li>        
    </ul>
</div>
<!-- end breadcrumb here-->

<!-- Start mainbody here-->
<div class="mainbody">
    <h1><?php echo $mdclocal;?></h1>
    <h3>Customer Detail</h3>
	<div class="innerbody">
	<?php echo $this->Form->create('VehicleRegistrationCompany', array('url' => array('controller' => 'vehicles', 'action' => 'companysubmit'), 'type' => 'file','enctype'=>'multipart/form-data')); ?>
           <table> <tr>
                <td align="left" width="2%">
				Company Name :</td>
				<td width="16%"><?php
				//echo 'nu-company-id'.$nu_company_id;
                        echo $this->Form->input('VehicleDetail.nu_company_id', array('label' => false,
                            'div' => false,
                            'type' => 'select',
                            'tabindex'=>'3',
							'required' => 'required',
                            'options' => $CompanyId,
                            'default' => $nu_company_id,
                            'onchange' => "formsubmit('VehicleRegistrationCompanyViewlogdetailForm');",
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
                <td align="right">

                    <?php echo $this->Html->link('Print Log Details', array('controller' => 'reports', 'action' => 'logdetail'), array('class' => 'textbutton')); ?>

                </td>
            </tr>
            <tr>
                <td align="right">&nbsp;</td>
            </tr>
        </table>

        <table width="100%" border="0" cellpadding="3">
            <tr>
                <td><label class="lab-inner">RFA Account No. :</label></td>
                <td>
                    <?php
                    echo $this->Form->input('VehicleLogMaster.vc_customer_no', array('label' => false,
                        'div' => false,
                        'type' => 'text',
                        'id' => 'vc_rfa_account_no',
                        'disabled' => 'disabled',
                        'value' => $profile['Profile']['vc_customer_no'],
                        'class' => 'round'));
                    ?>

                </td>
                <td><label class="lab-inner">Customer Id</label></td>
                <td>
                    <?php
                    echo $this->Form->input('VehicleLogMaster.vc_customer_id', array('label' => false,
                        'div' => false,
                        'type' => 'text',
                        'id' => 'vc_customer_id',
                        'disabled' => 'disabled',
                        'value' => $profile['Profile']['vc_customer_id'],
                        'class' => 'round'));
                    ?>

                </td>
                <td><label class="lab-inner">Customer Name :</label></td>
                <td>
                    <?php
                    echo $this->Form->input('VehicleLogMaster.vc_customer_name', array('label' => false,
                        'div' => false,
                        'type' => 'text',
                        'id' => 'vc_customer_name',
                        'disabled' => 'disabled',
                        'value' => $profile['Profile']['vc_customer_name'],
                        'class' => 'round'));
                    ?>

                </td>

            </tr>
            <tr>
                <td><label class="lab-inner">Street Name :</label></td>
                <td>
                    <?php
                    echo $this->Form->input('VehicleLogMaster.vc_address1', array('label' => false,
                        'div' => false,
                        'type' => 'text',
                        'id' => 'vc_address1',
                        'disabled' => 'disabled',
                        'value' => $profile['Profile']['vc_address1'],
                        'class' => 'round'));
                    ?>
                    <!--<input type="text" class="round" />-->
                </td>
                <td><label class="lab-inner">House No. :</label></td>
                <td>
                    <?php
                    echo $this->Form->input('VehicleLogMaster.vc_address2', array('label' => false,
                        'div' => false,
                        'type' => 'text',
                        'id' => 'vc_address2',
                        'disabled' => 'disabled',
                        'value' => $profile['Profile']['vc_address2'],
                        'class' => 'round'));
                    ?>
                    <!--<input type="text" class="round" />-->
                </td>
                <td><label class="lab-inner">P.O Box :</label></td>
                <td>
                    <?php
                    echo $this->Form->input('VehicleLogMaster.vc_po_box', array('label' => false,
                        'div' => false,
                        'type' => 'text',
                        'id' => 'vc_po_box',
                        'disabled' => 'disabled',
                        'value' => $profile['Profile']['vc_address3'],
                        'class' => 'round'));
                    ?>
                    <!--<input type="text" class="round" />-->
                </td>
				
            </tr>
            <tr>

              <td><label class="lab-inner">Town/City :</label></td>
                <td>
                    <?php
                    echo $this->Form->input('VehicleLogMaster.vc_town', array('label' => false,
                        'div' => false,
                        'type' => 'text',
                        'id' => 'vc_town',
                        'disabled' => 'disabled',
                        'value' => $profile['Profile']['vc_town'],
                        'class' => 'round'));
                    ?>
                    <!--<input type="text" class="round" />-->
                </td>  <td><label class="lab-inner">Telephone No. :</label></td>
                <td>
                    <?php
                    echo $this->Form->input('VehicleLogMaster.vc_tel_no', array('label' => false,
                        'div' => false,
                        'type' => 'text',
                        'id' => 'vc_tel_no',
                        'disabled' => 'disabled',
                        'value' => $profile['Profile']['vc_tel_no'],
                        'class' => 'round'));
                    ?>
                    <!--<input type="text" class="round" />-->
                </td>
                <td><label class="lab-inner">Fax No. :</label></td>
                <td>
                    <?php
                    echo $this->Form->input('VehicleLogMaster.vc_fax_no', array('label' => false,
                        'div' => false,
                        'type' => 'text',
                        'id' => 'vc_fax_no',
                        'disabled' => 'disabled',
                        'value' => $profile['Profile']['vc_fax_no'],
                        'class' => 'round'));
                    ?>
                    <!--<input type="text" class="round" />-->
                </td>
               
            </tr>
            <tr>
 <td><label class="lab-inner">Mobile No. :</label></td>
                <td>
                    <?php
                    echo $this->Form->input('VehicleLogMaster.vc_mobile_no', array('label' => false,
                        'div' => false,
                        'type' => 'text',
                        'id' => 'vc_mobile_no',
                        'disabled' => 'disabled',
                        'value' => $profile['Profile']['vc_mobile_no'],
                        'class' => 'round'));
                    ?>
                    <!--<input type="text" class="round" />-->
                </td>
                <td><label class="lab-inner">Email :</label></td>
                <td>
                    <?php
                    echo $this->Form->input('VehicleLogMaster.vc_email_id', array('label' => false,
                        'div' => false,
                        'type' => 'text',
                        'id' => 'vc_email_id',
                        'disabled' => 'disabled',
                        'value' => $profile['Profile']['vc_email_id'],
                        'class' => 'round'));
                    ?>
                    <!--<input type="text" class="round" />-->
                </td>
               <!-- <td><label class="lab-inner">Pay Frequency :</label></td>-->
               <!-- <td>
                <?php
                echo $this->Form->input('VehicleLogMaster.vc_pay_frequency', array('label' => false,
                    'div' => false,
                    'type' => 'select',
                    'id' => 'vc_pay_frequency',
                    'required' => 'required',
                    'options' => $payfrequency,
                    'class' => 'round_select'));
                ?>
                   
                </td>
                -->
              <!--  <td><label class="lab-inner">Customer Type :</label></td>-->
                <td>
                    <!--
                    <?php
                    echo $this->Form->input('vc_cust_type', array('label' => false,
                        'div' => false,
                        'type' => 'text',
                        'id' => 'vc_cust_type',
                        'required' => 'required',
                        'value' => $profile['VC_CUST_TYPE']['vc_prtype_name'],
                        'disabled' => 'disabled',
                        'class' => 'round'));
                    ?>
                    -->

                </td>

            </tr>
            <tr>
               <!-- <td><label class="lab-inner">Vehicle Licence No :</label></td>-->
                <!--
                 <td>
                <?php
                echo $this->Form->input('VehicleLogMaster.vc_vehicle_lic_no', array('label' => false,
                    'div' => false,
                    'type' => 'select',
                    'id' => 'ch_vehicle_lic_no',
                    'required' => 'required',
                    'options' => $vehicleNo,
                    'class' => 'round_select')
                );
                ?>

                 </td>
                -->
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;
				
				</td>
            </tr>
        </table>

    </div>
    <!-- end innerbody here-->
	<table border="0" cellspacing="2" align="center" width="100%">
				<tr><td><h3>Operator Vehicles Log Details</h3></td><td>&nbsp;</td>
<td width="5%"><div style="height:30px; width:25px; background-color:#ABABAB ; border-radius:4px;
 text-align:center; margin-left:133px;">&nbsp;</div></td>
<td >&nbsp;&nbsp;Logs added by inspector</td>
				</table>
    
    <!-- Start innerbody here-->
    <div class="innerbody vehicleRegsPag ">
	   <?php echo $this->Form->create(array('url' => array('controller' => 'vehicles', 'action' => 'addlogdetail'))); ?>
        <!-- Start innerbody here-->
        <table width="100%" cellspacing="1" cellpadding="5" border="0" >
            <tr class="listhead">
                <td width="8%">Log Date</td>
                <td width="8%">Driver Name</td>
                <td width="6%">Start Odometer</td>
                <td width="6%">End Odometer</td>
				<td width="6%">Road Type</td>			            
				<td width="8%">Origin</td>
                <td width="8%">Destination</td>
                <td width="8%">Vehicle <br/>Licence No.</td>
                <td width="7%">Pay Frequency </td>
            	<td width="7%">Km Travelled  </td>			
                <td width="6%">Status</td>
                <td width="7%">Action</td>
            </tr>
			<?php if (count($logdetaildata) > 0) : ?>	
                    <?php
                    $i = 1;
                    foreach ($logdetaildata as $showlogdetaildata) : $sr = $i % 2 == 0 ? '' : '1';
                        ?>

                        <tr class="cont<?php echo $sr;?>  <?php if ($showlogdetaildata['VehicleLogDetail']['vc_remark_by'] != 'USRTYPE03'): echo 'insp-fkd'; endif;?>">
                            <?php
                            $logDate = !empty($showlogdetaildata['VehicleLogDetail']['dt_log_date']) ?
                                    date('d M Y', strtotime($showlogdetaildata['VehicleLogDetail']['dt_log_date'])) :
                                    '';
                            ?>
                            <td valign="top" >
                                <?php echo $logDate; ?> 
                            </td>
                            <td valign="top" >
                                <?php
                                echo wordwrap($showlogdetaildata['VehicleLogDetail']['vc_driver_name'], 12, "<br>\n", true);
                                ?>
                            </td>
                            <td valign="top" align="right">
                                <?php
                                echo isset($showlogdetaildata['VehicleLogDetail']['nu_start_ometer']) ?
                                        $this->Number->format($showlogdetaildata['VehicleLogDetail']['nu_start_ometer'], array(
                                            'places' => false,
                                            'before' => false,
                                            'escape' => false,
                                            'decimals' => false,
                                            'thousands' => ','
                                        )) : '';
                                ?>
                            </td>
                            <td valign="top"  align="right">
                                <?php
                                echo isset($showlogdetaildata['VehicleLogDetail']['nu_end_ometer']) ?
                                        $this->Number->format($showlogdetaildata['VehicleLogDetail']['nu_end_ometer'], array(
                                            'places' => false,
                                            'before' => false,
                                            'escape' => false,
                                            'decimals' => false,
                                            'thousands' => ','
                                        )) : '';
                                ?>
                            </td>
							  <td valign="top"  align="right">
                             
                                  <?php
							//	  pr($showlogdetaildata['VehicleLogDetail']);
								if($showlogdetaildata['VehicleLogDetail']['ch_road_type']==1)
								echo 'Other Road';
								else
								echo 'Namibian Road';
								
                               // echo wordwrap($showvehiclelogreport['VehicleLogDetail']['ch_road_type'], 12, "<br>\n", true);
                                ?>
                            </td>
                
                            <td valign="top" >
							 <?php
								if($showlogdetaildata['VehicleLogDetail']['ch_road_type']==1)
								echo wordwrap($showlogdetaildata['VehicleLogDetail']['vc_other_road_orign_name'], 12, "<br>\n", true);
								else                            
								echo wordwrap($showlogdetaildata['VehicleLogDetail']['vc_orign_name'], 12, "<br>\n", true);
							?>
                                

                            </td>
                            <td valign="top" >
                               <?php
							 if($showlogdetaildata['VehicleLogDetail']['ch_road_type']==1)
							echo wordwrap($showlogdetaildata['VehicleLogDetail']['vc_other_road_destination_name'], 12, "<br>\n", true);
							else
                                echo wordwrap($showlogdetaildata['VehicleLogDetail']['vc_destination_name'], 12, "<br>\n", true);
                             ?>
                            </td>
                            <td valign="top" >
                                <?php echo $showlogdetaildata['VehicleLogDetail']['vc_vehicle_lic_no']; ?>
                            </td>
                            <td valign="top" >
                                <?php echo $showlogdetaildata['PAYFREQUENCY']['vc_prtype_name']; ?>
                            </td>
                            <td valign="top"  align="right">
							
							<?php 
							if($showlogdetaildata['VehicleLogDetail']['ch_road_type']==1)
						echo 	isset($showlogdetaildata['VehicleLogDetail']['nu_other_road_km_traveled'])? 
									$this->Number->format($showlogdetaildata['VehicleLogDetail']['nu_other_road_km_traveled'], array(
									'places' => false,
									'before' => false,
									'escape' => false,
									'decimals' => false,
									'thousands' => ','
                                )):'';
							else
							echo isset($showlogdetaildata['VehicleLogDetail']['nu_km_traveled']) ? 
                                $this->Number->format($showlogdetaildata['VehicleLogDetail']['nu_km_traveled'], array(
                                'places' => false,
                                'before' => false,
                                'escape' => false,
                                'decimals' => false,
                                'thousands' => ','
                                )):'';
			    ?>
                               
                            </td>
                             <td valign="top" >
							 <?php
                               
									echo ucfirst($showlogdetaildata['STATUS']['vc_prtype_name']);
								   
                                ?> </td>
							
							<td valign="top"  align="right">
                                <?php                                
								$lastlogregid = $deletelastlog->getLastlogofvehicle($showlogdetaildata['VehicleLogDetail']['vc_vehicle_lic_no']);
					
                                if($lastlogregid==$showlogdetaildata['VehicleLogDetail']['vc_log_detail_id'] && $showlogdetaildata['VehicleLogDetail']['vc_status']=='STSTY01' && $showlogdetaildata['VehicleLogDetail']['vc_remark_by'] == 'USRTYPE03'){
								?>
									<a href="javascript::void(0);" id="<?php echo base64_encode($showlogdetaildata['VehicleLogDetail']['vc_log_detail_id']);?>" class="qq-upload-remove_log" title="Delete Log">Delete</a>
								<?php }	else {								
									echo 'N/A';								 
								 }
								?>
                            </td>
                        </tr>  
                        <?php
                        $i++;
                    endforeach;
                    ?>
                <?php else : ?>
                    <tr class="cont1">
                        <td colspan='12' style="text-align:center;" > No Record Found </td>
                    </tr>
                <?php endif; ?>

            </table>

            <?php echo $this->element('paginationfooter'); ?>

       

    </div>
    <!-- end innerbody here-->    
    <?php echo $this->Form->end(null); ?>
</div>
<!-- end mainbody here--> 
<?php echo $this->element('commonmessagepopup'); ?>
<?php echo $this->Html->script('mdc/viewlogdetail'); ?>