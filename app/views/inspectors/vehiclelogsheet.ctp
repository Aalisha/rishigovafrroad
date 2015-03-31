<!-- Start wrapper here-->
<div class="wrapper">
    <!-- Start breadcrumb here-->
    <div class="breadcrumb">
        <ul>
            <li class="first">
                <?php echo $this->Html->link('Home', array('controller' => 'inspectors', 'action' => 'index'), array('title' => 'Home', 'class' => 'vtip')) ?>
            </li>

            <li class="last">Vehicle Log History Report</li>        
        </ul>
    </div>
    <!-- end breadcrumb here-->
    <!-- Start mainbody here-->
    <div class="mainbody">
        <h1><?php echo $mdclocal;?></h1>
        <h3>Vehicle Log History Report</h3>
        <div class="innerbody">

            <?php echo $this->Form->create('Inspector', array('url' => array('controller' => 'inspectors', 'action' => 'vehiclelogsheet'))); ?>
            <table width="100%" border="0" cellpadding="3">
                <tr>
                    <td valign='top' width="13%"><label class="lab-inner">From Date :</label></td>
                    <td  valign='top' width="20%">
                        <?php
                        echo $this->Form->input('fromdate', array('label' => false,
                            'div' => false,
                            'type' => 'text',
                            'id' => 'fromDate',
                            'class' => 'round2'));
                        ?>
                    </td>
                    <td valign='top' width="13%"><label class="lab-inner">To Date :</label></td>
                    <td  valign='top' width="15%"><?php
                        echo $this->Form->input('todate', array(
                            'label' => false,
                            'div' => false,
                            'id' => 'toDate',
                            'type' => 'text',
                            'class' => 'round2'));
                        ?>
                    </td>
                    <td valign='top' width="17%"><label class="lab-inner">Vehicle Type : </label></td>
                    <td valign='top' width="18%">
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
                    <td valign='top' width="15%" align="center">
                        <?php echo $this->Form->submit('Submit', array('class' => 'submit')); ?>
                    </td>
                </tr>   
 <tr>
                    <td valign='top' width="13%" nowrap="nowrap"><label class="lab-inner">Vehicle Register No.:</label></td>
                    <td  valign='top' width="20%">
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
                    <td valign='top' width="13%"><label class="lab-inner"></label></td>
                    <td  valign='top' width="15%">
                    </td>
                    <td valign='top' width="17%"><span class="valuetext"></span></td>
                    <td valign='top' width="18%">
                       

                    </td>
                    <td valign='top' width="15%" align="center">
                        <?php // echo $this->Form->submit('Submit', array('class' => 'submit')); ?>
                    </td>
                </tr> 				
            </table>
            <?php echo $this->Form->end(null); ?>
        </div>
        <!-- end filterbody here-->
        <!-- Start innerbody here-->
        <div class="innerbody">

            <?php echo $this->Form->create('Inspector', array('url' => array('controller' => 'inspectors', 'action' => 'vehiclelogsheetpdf'))); ?>

            <table width="100%" border="0" cellpadding="3">
                <tr>
                    <td width="10%"><label class="lab-inner"><?php if($vehicletypename!=''){ ?>Vehicle Type :<?php }?></label></td>
                    <td  width="15%"><span class="valuetext"><?php echo $vehicletypename; ?></span></td>
                    <td width="5%"><label class="lab-inner"><?php if($fromdate!=''){ ?>From Date :<?php }?></label></td>
                    <td  width="10%"><span class="valuetext"><?php echo $fromdate; ?></span></td>
                    <td width="5%"><label class="lab-inner"><?php if($todate!=''){ ?>To Date :<?php }?></label></td>
                    <td width="10%"><span class="valuetext"><?php echo $todate; ?></span></td>
					<!--
					<td width="5%"><label class="lab-inner"><?php if(isset($vehiclelicno) && $vehiclelicno!=''){ ?>Vehicle Lic No. :<?php }?></label></td>
                    <td width="10%"><span class="valuetext"><?php if(isset($vehiclelicno) && $vehiclelicno!=''){ echo $vehiclelicno; } ?></span></td>
					-->
                    <td width="10%"  align="right">
                        <?php
                        echo $this->Form->hidden('fromdate', array('value' => $fromdate));
                        echo $this->Form->hidden('todate', array('value' => $todate));
                        echo $this->Form->hidden('vehicletype', array('value' => $vehicletype));
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
					<td width="12%" nowrap="nowrap"><label class="lab-inner"><?php if(isset($vehiclelicno) && $vehiclelicno!=''){ ?>Vehicle Register No. :<?php }?></label></td>
                    <td width="30%" colspan="6"><span class="valuetext"><?php if(isset($vehiclelicno) && $vehiclelicno!=''){ echo $vehiclelicno; } ?></span></td>
                   
                </tr> 

            </table> 

            <?php echo $this->Form->end(null); ?>

            <br />

            <table width="100%" cellspacing="1" cellpadding="5" border="0" >
                <tr class="listhead">
                    <td width="10%">Log Date</td>
                    <td width="9%">Vehicle <br/>Register. No.</td>
                    <td width="9%">Vehicle <br/>LIC. No.</td>    
                    <td width="9%">Driver Name</td>
                    <td width="9%">Start Odometer</td>
                    <td width="9%">End<br/> Odometer</td>
                    <td width="9%">Road<br/> Type</td>
                    <td width="9%">Origin</td>
                    <td width="9%">Destination</td>
                    <td width="9%">KM Travelled</td>
                    <td width="9%">Created Date</td>
                </tr>

                <?php if (count($vehiclelogreport) > 0) : ?>	
                    <?php $i = 1;
                    foreach ($vehiclelogreport as  $key => $showvehiclelogreport) : $sr = $key % 2 == 0 ? '' : '1'; ?>

                            <tr class="cont<?php echo $sr; ?>">
                            <?php
                                  $logDate = !empty($showvehiclelogreport['VehicleLogDetail']['dt_log_date']) ?
                                              date('d M Y', strtotime($showvehiclelogreport['VehicleLogDetail']['dt_log_date'])) :
                                                '';
                             ?>
                            <td><?php echo $logDate; ?> </td>
                            <td><?php echo $showvehiclelogreport['VehicleLogDetail']['vc_vehicle_reg_no']; ?></td>
                            <td><?php echo $showvehiclelogreport['VehicleLogDetail']['vc_vehicle_lic_no']; ?></td>
                            <td><?php
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
                            <td align="right" >
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
							<td>
							<?php 
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
                           
                            <?php 
                                $created_date = $showvehiclelogreport['VehicleLogDetail']['dt_created_date'] ?
                                                date('d M Y', strtotime($showvehiclelogreport['VehicleLogDetail']['dt_created_date'])):
                                                '';
                            ?>
                            <td>
                                <?php echo $created_date; ?>
                            </td>
                        </tr>


                        <?php
                        $i++;
                    endforeach;
                    ?>
                <?php else : ?>
                    <tr class="cont1" style='text-align: center'>
                        <td colspan='11'> No Records Found </td>
                    </tr>
                <?php endif; ?>

            </table>
            <?php
            $this->Paginator->options(array(
                'url' => array(
                    'fromDate' => $fromdate,
                    'todate' => $todate,
                    'vehiclelicno' => $vehiclelicno,
                    'vehicletype' => $vehicletype
                    )));
            ?>
            <?php echo $this->element('paginationfooter'); ?>

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

</div>
<!-- end wrapper here-->
<?php echo $this->Html->script('inspector/insp-vehiclelogsheet'); ?>