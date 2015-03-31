<!-- Start wrapper here-->
<div class="wrapper">
    <!-- Start breadcrumb here-->
    <div class="breadcrumb">
        <ul>
            <li class="first">
                <?php echo $this->Html->link('Home', array('controller' => 'profiles', 'action' => 'index'), array('title' => 'Home', 'class' => 'vtip')) ?>
            </li>

            <li class="last">Customer Vehicle Log History Report</li>        
        </ul>
    </div>
    <!-- end breadcrumb here-->
    <!-- Start mainbody here-->
    <div class="mainbody">
        <h1><?php echo $mdclocal;?></h1>
        <h3>Customer Vehicle Log History Report</h3>
        <div class="innerbody">

            <?php echo $this->Form->create('Inspector', array('url' => array('controller' => 'inspectors', 'action' => 'logsheet'))); ?>
            <table width="100%" border="0" cellpadding="3">
                <tr>
                    <td valign='top' width="13%"><label class="lab-inner">From Date :</label></td>
                    <td valign='top' width="20%">
                        <?php
                        $fromdate = !empty($fromdate)? date('d M Y',  strtotime($fromdate)):'';
                        echo $this->Form->input('fromdate', array('label' => false,
                            'div' => false,
                            'type' => 'text',
                            'id' => 'fromDate',                            
                            'value' => $fromdate,
                            'class' => ' dateseclect round2'));
                        ?>
                    </td>
                    <td valign='top' width="13%"><label class="lab-inner">To Date :</label></td>
                    <td  valign='top' width="15%"><?php
                    $todate = !empty($todate)? date('d M Y',  strtotime($todate)):'';
                        echo $this->Form->input('todate', array(
                            'label' => false,
                            'div' => false,
                            'id' => 'toDate',
                            'type' => 'text',                            
                            'value' => $todate,
                            'class' => 'dateseclect round2'));
                        ?></td>
                    <td valign='top' width="17%"><span class="valuetext">Customer Name</span></td>
                    <td  valign='top' width="18%">
                        <?php
                        echo $this->Form->input('vc_customer_name', array(
                            'label' => false,
                            'div' => false,
                            'type' => 'text',
                            'id' => 'vc_customer_name',
                            'maxlength' => 100,
                            'value' => $vc_customer_name,
                            'class' => 'round2'));
                        ?>
                    </td>
                    <td valign='top' width="15%" align="center">
                        <?php echo $this->Form->submit('Submit', array('class' => 'submit')); ?>
                    </td>
                </tr>    
				<tr>
                    <td valign='top' width="13%"><label style="width:115px;" class="lab-inner">Vehicle Register No.</label></td>
                    <td width="15%" valign="top" colspan='6' class="align-left">
                        <?php
                      echo $this->Form->input('vehiclelicno', array('label' => false,
                            'div' => false,
                            'type' => 'text',
                            'id' => 'vehiclelicnoid',
                            'readonly'=>'readonly',
							'style'=>'width:80px;',
                            'maxlength' => 20,
                            'value' => $vehiclelicno,
                            'class' => ' round2'));
							
							
                        ?>
						
						&nbsp;<?php echo $this->Form->button('Find', array('label' => false,'div' => false,
						'name'=>'search',
						'type' => 'button','id' => 'addshow'));?>
                    </td>
                  
                </tr> 				
            </table>
            <?php echo $this->Form->end(null); ?>
        </div>
        <!-- end filterbody here-->
        <!-- Start innerbody here-->
        <div class="innerbody">

            <?php echo $this->Form->create('Inspector', array('url' => array('controller' => 'inspectors', 'action' => 'logsheetpdf'))); ?>

            <table width="100%" border="0" cellpadding="3">
                <tr>

                    <td width="7%"><label class="lab-inner"><?php if($vc_customer_name!=''){ ?>
					Customer Name :<?php }?></label></td>

                    <td  width="15%"><span class="valuetext"><?php echo $vc_customer_name; ?></span></td>

                    <td width="3%"><label class="lab-inner"><?php if($fromdate!=''){ ?>
					From Date :<?php }?></label></td>

                    <td width="12%"><span class="valuetext"><?php echo !empty($fromdate)? date('d M Y',  strtotime($fromdate)):''; ?></span></td>

                    <td width="3%" align="left" ><label class="lab-inner"><?php if($todate!=''){ ?>To Date :
					<?php }?></label></td>

                    <td width="12%" align="left"><span class="valuetext"><?php echo !empty($todate)? date('d M Y',  strtotime($todate)):''; ?></span></td>
					 

                    <td width="25%"  align="right">
                        <?php
                        echo $this->Form->hidden('fromdate', array('value' => $fromdate));
                        echo $this->Form->hidden('todate', array('value' => $todate));
                        echo $this->Form->hidden('vc_customer_name', array('value' => $vc_customer_name));
						echo $this->Form->hidden('vehiclelicno', array('value' => $vehiclelicno));
	 if (count($vehiclelogreport) > 0) :
							echo $this->Form->button('Print Report', array(
								'label' => false,
								'type' => 'submit',
								'div' => false,
								'class' => 'textbutton1 submit'));
                        endif;
						?>
                    </td>

                </tr> 
				 <tr>
					 <td width="7%" nowrap="nowrap"><label class="lab-inner" ><?php if($vehiclelicno!=''){ ?>
					 Vehicle Register No. 
					<?php }?></label></td>

                    <td width="10%" colspan="7">:<span class="valuetext">&nbsp;
					<?php echo !empty($vehiclelicno)? $vehiclelicno:''; ?></span></td>
                </tr> 

            </table> 
            <?php echo $this->Form->end(null); ?>
            <br />

            <table width="100%" cellspacing="1" cellpadding="5" border="0" >
                <tr class="listhead">
                    <td width="9%">Log Date</td>
                    <td width="">Customer Name</td>
                    <td width="">Vehicle <br/>Register No.</td>
                    <td width="">Vehicle <br/>LIC. No.</td>    
                    <td width="">Driver Name</td>
                    <td width="">Start Odometer</td>
                    <td width="">End Odometer</td>
                    <td width="">Road Type</td>
                    <td width="">Origin</td>
                    <td width="">Destination</td>
                    <td width="">KM Travelled</td>
             	    <!--<td width="">Created Date</td>-->
                </tr>

                <?php if (count($vehiclelogreport) > 0) : ?>	

                    <?php $i = 1;

                    foreach ($vehiclelogreport as $showvehiclelogreport) : $sr = $i % 2 == 0 ? '' : '1'; ?>

                        <tr class="cont<?php echo $sr; ?>">
                            <?php 
                                $LogDate = !empty ($showvehiclelogreport['VehicleLogDetail']['dt_log_date']) ? 
                                                 date('d M Y', strtotime($showvehiclelogreport['VehicleLogDetail']['dt_log_date'])):
                                                 '';
                             ?>
                            <td><?php echo $LogDate; ?></td>
                            <td>
                                <?php
							        echo ucfirst(wordwrap($showvehiclelogreport['VehicleLogMaster']['vc_customer_name'], 12, "<br>\n", true));
                                ?>
                            </td>
                            <td><?php echo $showvehiclelogreport['VehicleLogDetail']['vc_vehicle_reg_no']; ?></td>
                            <td ><?php echo $showvehiclelogreport['VehicleLogDetail']['vc_vehicle_lic_no']; ?></td>
                            <td>
                            <?php
                                echo wordwrap($showvehiclelogreport['VehicleLogDetail']['vc_driver_name'], 12, "<br>\n", true);
                             ?>
                            </td>
                            <td align="right">
                                <?php
                                $StartOMet = isset($showvehiclelogreport['VehicleLogDetail']['nu_start_ometer']) ? 
                                $this->Number->format($showvehiclelogreport['VehicleLogDetail']['nu_start_ometer'], array(
                                'places' => false,
                                'before' => false,
                                'escape' => false,
                                'decimals' => false,
                                'thousands' => ','
                                )):'';

                                echo $StartOMet; 
                               ?>
                             </td>
                            <td align="right">
                                
                                <?php
                                $EndOMet = isset($showvehiclelogreport['VehicleLogDetail']['nu_end_ometer']) ? 
                                $this->Number->format($showvehiclelogreport['VehicleLogDetail']['nu_end_ometer'], array(
                                'places' => false,
                                'before' => false,
                                'escape' => false,
                                'decimals' => false,
                                'thousands' => ','
                                )):'';

                                echo $EndOMet; 
                            ?>
                           </td>
						   <td><?php 
						   if($showvehiclelogreport['VehicleLogDetail']['ch_road_type']==1)
								echo 'Other Road';
								else
								echo 'Namibian Road';?>
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
							 echo $showvehiclelogreport['VehicleLogDetail']['vc_other_road_destination_name'];
							 else
							echo  $showvehiclelogreport['VehicleLogDetail']['vc_destination_name'];
							 
							 /*
							 if($showvehiclelogreport['VehicleLogDetail']['ch_road_type']==1)
							echo wordwrap($showvehiclelogreport['VehicleLogDetail']['vc_other_road_destination_name'], 12, "<br>\n", true);
							else
                                echo wordwrap($showvehiclelogreport['VehicleLogDetail']['vc_destination_name'], 12, "<br>\n", true);
								*/
                             ?>
                            
                            </td>
                            <td align="right">
							<?php 
							
									if($showvehiclelogreport['VehicleLogDetail']['ch_road_type']==1){
									echo $this->Number->format($showvehiclelogreport['VehicleLogDetail']['nu_other_road_km_traveled'], array(
									'places' => false,
									'before' => false,
									'escape' => false,
									'decimals' => false,
									'thousands' => ','
                                ));
								}
							else {
							echo 	
							$this->Number->format($showvehiclelogreport['VehicleLogDetail']['nu_km_traveled'], array(
                                'places' => false,
                                'before' => false,
                                'escape' => false,
                                'decimals' => false,
                                'thousands' => ','
                                ));
								}
			    ?>
                            
                               
                               
                            </td>
                           

                            <?php 
                                $CreatedDate = !empty ($showvehiclelogreport['VehicleLogDetail']['dt_created_date']) ? 
                                                 date('d M Y', strtotime($showvehiclelogreport['VehicleLogDetail']['dt_created_date'])):
                                                 '';
                             ?>
                            <!--
                            <td><?php echo $CreatedDate; ?></td>
                            -->
                        </tr>


                        <?php
                        $i++;
                    endforeach;
                    ?>
                <?php else : ?>

                    <tr class="cont1" style='text-align: center'>
                        <td colspan='12'> No Record Found </td>
                    </tr>

                <?php endif; ?>

            </table>
            <?php
            $this->Paginator->options(array(
                'url' => array(
                    'fromDate' => $fromdate,
                    'todate' => $todate,
                    'vehiclelicno' => $vehiclelicno,
                    'vc_customer_name' => $vc_customer_name
                    )));
            ?>
            <?php echo $this->element('paginationfooter'); ?>

        </div>

    </div>
	
	<!-- start popup here-->
<div id="popDiv3" class="ontop">
        <div id="popup" class="popup3">

            <a href="javascript:void(0);" class="close" >Close</a>            
            <table width="100%" border="0" cellpadding="0" cellspacing="0">
                <tr>
                    <td align="left" class="content-area"><div class="listhead-popup">Insert Vehicle Lic. No. /  Vehicle Register No.</div></td>
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
                                            
											<?php if (isset($vehiclelistall) &&  count($vehiclelistall) > 0) : ?>

                                                <?php 
														$i = 0;
														
														foreach ($vehiclelistall as $key => $value) {
														
														$str = $i % 2 == 0 ? '1' : '';
												?>

                                                    <tr class="cont<?php echo $str ?>">

                                                        <td width="10%" align="center">

                                                            <input type='radio' name='vehiclelicno' value='<?php echo trim($key); ?>' />


                                                        </td>

                                                        <td width="60%" align="left"><?php echo trim($key); ?></td>

                                                        <td width="30%"><?php echo trim($value); ?></td>

                                                    </tr>

                                                <?php 
													
												
													$i++;
													}
												?>

                                            <?php   else : ?>

                                                <tr class="cont1" style='text-align:center;'>

                                                    <td colspan='3'>No Records Found</td>

                                                </tr>

                                            <?php  endif; ?>		

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
<!--popup end here-->	

</div>
<!-- end wrapper here-->
<?php echo $this->Html->script('inspector/insp-logsheet'); ?>