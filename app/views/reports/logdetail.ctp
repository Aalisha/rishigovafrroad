<?php $profile = $this->Session->read('Auth'); ?>

<!-- Start wrapper here-->
<div class="wrapper">
    <!-- Start breadcrumb here-->
    <div class="breadcrumb">
        <ul>
            <li class="first">
                <?php echo $this->Html->link('Home', array('controller' => 'profiles', 'action' => 'index'), array('title' => 'Home', 'class' => 'vtip')) ?>
            </li>

            <li class="last">Operator Vehicles Log History Report</li>        
        </ul>
    </div>
    <!-- end breadcrumb here-->
    <!-- Start mainbody here-->
    <div class="mainbody">
        <h1><?php echo $mdclocal;?></h1>
        <h3>Operator Vehicles Log History Report</h3>
        <div class="innerbody">

            <?php echo $this->Form->create('Report', array('url' => array('controller' => 'reports', 'action' => 'logdetail'))); ?>
            <table width="100%" border="0" cellpadding="3">
                <tr>
                    <td width="13%" valign="top"><label class="lab-inner">From Date :</label></td>
                    <td width="18%" valign="top" class="align-left" >
                        <?php
                        echo $this->Form->input('fromdate', array('label' => false,
                            'div' => false,
                            'type' => 'text',
                            'id' => 'fromDate',
                            'readonly'=>'readonly',
                            'maxlength'=>12,
                            'class' => 'round2'));
                        ?>
                    </td>
                    <td width="13%" valign="top"><label class="lab-inner">To Date :</label></td>
                    <td width="17%" valign="top" class="align-left"><?php
                        echo $this->Form->input('todate', array(
                            'label' => false,
                            'div' => false,
                            'id' => 'toDate',
                            'readonly'=>'readonly',
                            'type' => 'text',
                            'maxlength'=>12,
                            'class' => 'round2'));
                        ?>
                    </td>
                    <td width="17%" valign="top"><span class="">Vehicle Type</span></td>
                    <td width="18%" valign="top">
                        <?php
                        echo $this->Form->input('vehicletype', array(
                            'label' => false,
                            'div' => false,
                            'type' => 'select',
                            'id' => 'vehicleType',
                            'options' => $vehiclelist,
                            'default' => $vehicletype,
                            'class' => 'round_select round2'));
                        ?>

                    </td>
					<td width="15%" valign="top" align="center">
                        <?php echo $this->Form->submit('Submit', array('class' => 'submit')); ?>
                    </td>
					</tr>
					<tr>
					<td align="left" valign="top">
				Company Name:</td>
				<td valign="top"><?php 
				//echo 'nu-company-id'.$nu_company_id;
                        echo $this->Form->input('nu_company_id', array('label' => false,
                            'div' => false,
                            'type' => 'select',
                            'options' => array('All') + $CompanyId,
                            'default' => $nu_company_id,
							'class' => 'round_select round2')
                        );
                        ?></td>
						<td valign="top"><label style="width:120px;" class="lab-inner">Vehicle Register No.</label>						
						</td><td colspan='4'>
						<?php
                      echo $this->Form->input('vehiclelicno', array('label' => false,
                            'div' => false,
                            'type' => 'text',
                            'id' => 'vehiclelicnoid',
                            'readonly'=>'readonly',
							'style'=>'width:100px;',
                            'maxlength' => 20,
                            'value' => $vehiclelicno,
                            'class' => ' round2'));
							
							
                        ?>
						&nbsp;<?php echo $this->Form->button('Find', array('label' => false,'div' => false,'type' => 'button','id' => 'addshow',));?>
						</td>
                </tr>      
            </table>
            <?php echo $this->Form->end(null); ?>
        </div>
        <!-- end filterbody here-->
        <!-- Start innerbody here-->
        <div class="innerbody">

            <?php echo $this->Form->create('Report', array('url' => array('controller' => 'reports', 'action' => 'logdetailpdf'))); ?>

            <table width="100%" border="0" cellpadding="3">
                <tr>
                    <td width="10%"><label class="lab-inner">RFA Account No. :</label></td>
                    <td width="20%"><span class="valuetext"><?php echo $profile['Profile']['vc_customer_no'];?></span></td>
                    <td width="10%">
                        <label class="lab-inner">
                            <?php if(!empty($fromdate)) { 
                                    $fromdate = date('d M Y',  strtotime($fromdate));
                            ?>
                            From Date :
                           <?php } ?>
                       </label>
                    </td>
                    <td  width="10%"><span class="valuetext"><?php echo $fromdate; ?></span></td>
                    <td width="10%">
                        <label class="lab-inner">
                           <?php if(!empty($vehicletypename)) { 
                                    
                            ?>
                            Vehicle Type :
                           <?php } ?>
                        </label>
                    </td>
                    <td  width="10%"><span class="valuetext"><?php echo $vehicletypename; ?></span></td>
					<td width="10%" nowrap="nowrap">
                        <label class="lab-inner">
                           <?php if(!empty($vehiclelicno)) { 
                                    
                            ?>
                            Vehicle Register No. : 
                      <?php } ?>
                        </label>
                    </td>
                    <td  > <span class="valuetext"><?php echo $vehiclelicno; ?></span></td>
					
					
                </tr> 
                
                  <tr>
                    <td width="10%"><label class="lab-inner">Customer Name :</label></td>
                    <td width="20%"><span class="valuetext"><?php echo $profile['Profile']['vc_customer_name'];?></span></td>
                    <td width="10%">
                        <label class="lab-inner">
                            <?php if(!empty($todate)) { 
                                    $todate = date('d M Y',  strtotime($todate));
                            ?>
                            To Date :
                           <?php } ?>
                        </label>
                    </td>
                    <td width="10%"><span class="valuetext"><?php echo $todate; ?></span></td>
                    <td width="10%">
                        <label class="lab-inner">
                           <?php if(!empty($nu_company_id)) {
                                    
                            ?>
                            Company Name :
                           <?php } ?>
                        </label>
                    </td>
                    <td  width="20%"><span class="valuetext"><?php echo wordwrap($company_name['Company']['vc_company_name'], 13, "<br>\n", true); ?></span></td>
                    
                    <td colspan='4' width="20%"  align="right">
                        <?php
                        echo $this->Form->hidden('fromdate', array('value' => $fromdate));
                        echo $this->Form->hidden('todate', array('value' => $todate));
                        echo $this->Form->hidden('vehicletype', array('value' => $vehicletype));
                        echo $this->Form->hidden('nu_company_id', array('value' => $nu_company_id));
						echo $this->Form->hidden('vehiclelicno', array('value' => $vehiclelicno));
						if(count($vehiclelogreport)>0) :
							echo $this->Form->button('Print Report', array(
                            'label' => false,
                            'type' => 'submit',
                            'div' => false,
                            'class' => 'textbutton1 submit'));
						endif;	
                        ?>
                    </td>
                </tr> 

            </table> 

            <?php echo $this->Form->end(null); ?>

            <br />

            <table width="100%" cellspacing="1" cellpadding="5" border="0" >
                <tr class="listhead">
                    <td width="4%" align="center">SI. No.</td>
					<?php if(empty($nu_company_id)) {?>
                        <td align="center">Company name</td>
					<?php } ?>
                    <td width="10%" align="center">Log Date</td>
                    <td width="10%" align="center">Vehicle <br/>Register No.</td>
                    <td width="10%" align="center">Vehicle <br/>Licence No.</td>    
                    <td width="8%" align="center">Vehicle Type</td>    
                    <td width="10%" align="center">Driver Name</td>
                    <td width="7%" align="center">Start Odometer</td>
                    <td width="7%" align="center">End Odometer</td>
					<td width="7%" align="center">Road Type</td>
                    <td width="7%" align="center">Origin</td>
                    <td width="7%" align="center">Destination</td>
                    <td width="9%" align="center">KM Travelled</td>

                   
                </tr>

                <?php if (count($vehiclelogreport) > 0) :  ?>	
                    <?php $i = 1;
                    foreach ($vehiclelogreport as $showvehiclelogreport) : $sr = $i % 2 == 0 ? '' : '1';
					
					 if ($showvehiclelogreport['VehicleLogDetail']['vc_remark_by'] != 'USRTYPE03'){
					 
					 	 $HelperCompanyId =	$this->Companydetails->giveCompanyId($showvehiclelogreport['VehicleLogDetail']['vc_vehicle_reg_no']);

        ?><tr class="cont<?php echo $sr; ?> insp-fkd"><?php
 }else{?>
        <tr class="cont<?php echo $sr; ?> "><?php
 }
  ?>
                            <td align="center"><?php echo ((($pagecounter-1)*($limit))+$i); ?></td>
							<?php if(empty($nu_company_id)) {
							
								if($showvehiclelogreport['VehicleLogDetail']['vc_remark_by'] != 'USRTYPE03'){?>
								
                                <td align="left"><?php echo wordwrap($CompanyId[$HelperCompanyId], 10, "<br>\n", true); ?></td>
							
							<?php }else{ ?>
							
							<td align="left"><?php echo wordwrap($CompanyId[$showvehiclelogreport['VehicleLogDetail']['nu_company_id']], 10, "<br>\n", true); ?></td>

							<?php } ?>
							
							<?php } ?>
							
                            <?php 
                                $LogDate = !empty ($showvehiclelogreport['VehicleLogDetail']['dt_log_date']) ? 
                                                 date('d M Y', strtotime($showvehiclelogreport['VehicleLogDetail']['dt_log_date'])):
                                                 '';
                             ?>
                            <td><?php echo $LogDate; ?></td>
                            <td><?php echo $showvehiclelogreport['VehicleLogDetail']['vc_vehicle_reg_no']; ?></td>
                            <td><?php echo $showvehiclelogreport['VehicleLogDetail']['vc_vehicle_lic_no']; ?></td>
                            <td>
                            <?php
                                foreach($vehiclelist as $key => $val) {
                                    if($key == $showvehiclelogreport['VehicleDetail']['vc_vehicle_type']) {
                                        echo @$val;
                                        break;
                                    }
                                }
                             ?>
                            </td>
                            <td>
                            <?php
                                echo wordwrap($showvehiclelogreport['VehicleLogDetail']['vc_driver_name'], 12, "<br>\n", true);
                             ?>
                            </td>
                            <td align="right"><?php 
				echo 	isset($showvehiclelogreport['VehicleLogDetail']['nu_start_ometer']) ? 
                                $this->Number->format($showvehiclelogreport['VehicleLogDetail']['nu_start_ometer'], array(
                                'places' => false,
                                'before' => false,
                                'escape' => false,
                                'decimals' => false,
                                'thousands' => ','
                                )):'';
							?>
                            </td>
                            <td align="right"><?php
                                echo 	isset($showvehiclelogreport['VehicleLogDetail']['nu_end_ometer']) ? 
                                $this->Number->format($showvehiclelogreport['VehicleLogDetail']['nu_end_ometer'], array(
                                'places' => false,
                                'before' => false,
                                'escape' => false,
                                'decimals' => false,
                                'thousands' => ','
                                )):'';

                            ?></td>
							 <td>
                                <?php
								if($showvehiclelogreport['VehicleLogDetail']['ch_road_type']==1)
								echo 'Other Road';
								else
								echo 'Namibian Road';
								
                               // echo wordwrap($showvehiclelogreport['VehicleLogDetail']['ch_road_type'], 12, "<br>\n", true);
                                ?>
                            </td>
                            <td>
                             <?php
								if($showvehiclelogreport['VehicleLogDetail']['ch_road_type']==1)
								echo wordwrap($showvehiclelogreport['VehicleLogDetail']['vc_other_road_orign_name'], 12, "<br>\n", true);
								else                            
								echo wordwrap($showvehiclelogreport['VehicleLogDetail']['vc_orign_name'], 12, "<br>\n", true);
							?>
                            </td>
                            <td>
                             <?php
							 if($showvehiclelogreport['VehicleLogDetail']['ch_road_type']==1)
							echo wordwrap($showvehiclelogreport['VehicleLogDetail']['vc_other_road_destination_name'], 12, "<br>\n", true);
							else
                                echo wordwrap($showvehiclelogreport['VehicleLogDetail']['vc_destination_name'], 12, "<br>\n", true);
                             ?>
                            </td>
                            <td align="right">
                                <?php 
									if($showvehiclelogreport['VehicleLogDetail']['ch_road_type']==1)
									echo 	isset($showvehiclelogreport['VehicleLogDetail']['nu_other_road_km_traveled']) ? 
									$this->Number->format($showvehiclelogreport['VehicleLogDetail']['nu_other_road_km_traveled'], array(
									'places' => false,
									'before' => false,
									'escape' => false,
									'decimals' => false,
									'thousands' => ','
                                )):'';
							else
							echo 	isset($showvehiclelogreport['VehicleLogDetail']['nu_km_traveled']) ? 
                                $this->Number->format($showvehiclelogreport['VehicleLogDetail']['nu_km_traveled'], array(
                                'places' => false,
                                'before' => false,
                                'escape' => false,
                                'decimals' => false,
                                'thousands' => ','
                                )):'';
			    ?>
                            </td>
                            <!--<td align="right">
                                <?php 
								echo 	isset($showvehiclelogreport['VehicleLogDetail']['nu_other_road_km_traveled']) ? 
                                $this->Number->format($showvehiclelogreport['VehicleLogDetail']['nu_other_road_km_traveled'], array(
                                'places' => false,
                                'before' => false,
                                'escape' => false,
                                'decimals' => false,
                                'thousands' => ','
                                )):'';
				?>
                            </td>-->
                           
                        </tr>


                        <?php
                        $i++;
                    endforeach;
                    ?>
                <?php else : ?>
                    <?php if(empty($nu_company_id)) {?>
					<tr class="cont1" style='text-align:center;'>
                        <td colspan='13'> No Record Found </td>
                    </tr>				
				<?php }else{ ?>
					<tr class="cont1" style='text-align:center;'>
                        <td colspan='12'> No Record Found </td>
                    </tr>				
				<?php } ?>
                <?php endif; ?>

            </table>
            <?php
            $this->Paginator->options(array(
                'url' => array(
                    'fromDate' => $fromdate,
                    'todate' => $todate,
                    'vehicletype' => $vehicletype,
					'nu_company_id' => $nu_company_id
                    )));
            ?>
            <?php echo $this->element('paginationfooter'); ?>

        </div>
		
		

    </div>
	<!--*///////////-->
	
	
<div id="popDiv3" class="ontop">
        <div id="popup" class="popup3">

            <a href="javascript:void(0);" class="close" >Close</a>            
            <table width="100%" border="0" cellpadding="0" cellspacing="0">
                <tr>
                    <td align="left" class="content-area"><div class="listhead-popup">Insert Vehicle Lic. No. /  Vehicle Register. No.</div></td>
                </tr>
                <tr>
                    <td width="100%" align="center" class="content-area">
                        <div class="content-area-outer">
                            <table width="100%" border="0">
                                <tr>
                                    <td> 
                                        <input type="text" class="tftextinput" name="search" size="21" maxlength="50">
                                        <input type="button" value="search" class="tfbutton"></td>
                                </tr>
                                <tr>
                                    <td>
                                        <table width="100%" cellspacing="1" cellpadding="5" border="0" >
                                            <tr class="listhead1">

                                                <td width="10%" align="left"></td>

                                                <td width="60%" align="left">Vehicle Lic. No.</td>

                                                <td width="30%"> Vehicle Register No. </td>

                                            </tr>
                                        </table>
									<table id='ajaxshow' width="100%" cellspacing="1" cellpadding="5" border="0" >		
                                            
											<?php if ( count($vehiclelistall) > 0) : ?>

                                                <?php 
														$i = 0;
														
														foreach ($vehiclelistall as $key => $value) : 
														
														$str = $i % 2 == 0 ? '1' : '';
												?>

                                                    <tr class="cont<?php echo $str ?>">

                                                        <td width="10%" align="center">

                                                            <input type='radio' name='vehiclelicno' value='<?php echo trim($value); ?>' />


                                                        </td>

                                                        <td width="60%" align="left"><?php echo trim($key); ?></td>

                                                        <td width="30%"><?php echo trim($value); ?></td>

                                                    </tr>

                                                <?php 
													
													endforeach;
													
													$i++;
												?>

                                            <?php else : ?>

                                                <tr class="cont1" style='text-align:center;'>

                                                    <td colspan='3'>No Records Found</td>

                                                </tr>

                                            <?php endif; ?>		

                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </div>

                    </td>
                </tr>
            </table>

        </div>
    </div> 
	<!--*----->

</div>

<style>
.insp-fkd{background-color: #ABABAB !important;}
</style>
<!-- end wrapper here-->
<?php echo $this->Html->script('mdc/logs-report'); ?>