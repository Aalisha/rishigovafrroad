<!-- Start innerbody here-->
<div class="innerbody">

<table width="100%" border="0" cellpadding="3">
	<tr>

		<td width="13%"><label class="lab-inner">RFA Account No. :</label></td>
		<td  width="18%"><span class="valuetext"><?php echo $this->Session->read('Auth.Profile.vc_customer_no');  ?></span></td>
		<td width="13%"><label class="lab-inner">From Date :</label></td>
		<td width="14%"><span class="valuetext"><?php echo $fromDate; ?></span></td>

	</tr> 
	<tr>
		<td><label class="lab-inner">Customer Name :</label></td>
		<td><span class="valuetext"><?php echo $this->Session->read('Auth.Profile.vc_customer_name');  ?></span></td>              
		<td><label class="lab-inner">To Date :</label></td>
		<td><span class="valuetext"><?php echo $toDate; ?></span></td>
	</tr>    
	<tr>
		<td><label class="lab-inner">Company Name :</label></td>
		<td><span class="valuetext"><?php echo $company_name['Company']['vc_company_name'];  ?></span></td>              
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>    
</table>

<br>
<table width="100%" cellspacing="1" cellpadding="5" border="0" >
	<tr class="listhead">
	
		<td width="10%">Date</td>
		<td width="10%">Vehicle Register No.</td>
		<td width="10%">Vehicle LIC No.</td>    
		<td width="10%">Driver Name</td>
		<td width="10%">Start Odometer</td>
		<td width="10%">End Odometer</td>
		<td width="10%">Road Type</td>
		<td width="10%">Origin</td>
		<td width="10%">Destination</td>
		<td width="10%">KM Travelled</td>
		<!--<td width="10%">Origin Other Road</td>
			<td width="10%">Destination Other Road</td>
		<td width="10%">KM Travel on Other Network</td>-->
	</tr>
	<?php
$maxodometer = array();
$lastvaluetotalkilometer=0;
	foreach ( $detail as $value  )  : 
	
	$maxodometer[]=$value['VehicleLogDetail']['nu_end_ometer'];
	?>

		<tr class="cont1">
			
			<td> 
			<?php echo date('d M Y', strtotime($value['VehicleLogDetail']['dt_log_date'])); ?></td>
			
			<td><?php echo $value['VehicleLogDetail']['vc_vehicle_lic_no']; ?></td>
			
			<td ><?php echo $value['VehicleLogDetail']['vc_vehicle_reg_no']; ?></td>
			
			<td>
			<?php
            echo wordwrap($value['VehicleLogDetail']['vc_driver_name'], 12, "<br>\n", true);
			?>
			</td>
			<td align="right"><?php echo number_format($value['VehicleLogDetail']['nu_start_ometer']); ?></td>
			
			<td align="right"><?php echo number_format($value['VehicleLogDetail']['nu_end_ometer']); ?></td>
			<td valign="top"  align="left">
                             
                                  <?php
								if($value['VehicleLogDetail']['ch_road_type']==1){
								echo 'Other Road';
								}
								else{
								$lastvaluetotalkilometer=$lastvaluetotalkilometer+$value['VehicleLogDetail']['nu_km_traveled'];
								echo 'Namibian Road';
								}
								
                                ?>
                            </td>
			<td>
				<?php
								if($value['VehicleLogDetail']['ch_road_type']==1)
								echo wordwrap($value['VehicleLogDetail']['vc_other_road_orign_name'], 12, "<br>\n", true);
								else                            
								echo wordwrap($value['VehicleLogDetail']['vc_orign_name'], 12, "<br>\n", true);
							?>
			</td>
			<td>
							<?php
							 if($value['VehicleLogDetail']['ch_road_type']==1)
								echo wordwrap($value['VehicleLogDetail']['vc_other_road_destination_name'], 12, "<br>\n", true);
							else
                                echo wordwrap($value['VehicleLogDetail']['vc_destination_name'], 12, "<br>\n", true);
                             ?>
				
			</td>
			
			<td align="right">	
							<?php 
									if($value['VehicleLogDetail']['ch_road_type']==1)
									echo 	isset($value['VehicleLogDetail']['nu_other_road_km_traveled']) ? 
									$this->Number->format($value['VehicleLogDetail']['nu_other_road_km_traveled'], array(
									'places' => false,
									'before' => false,
									'escape' => false,
									'decimals' => false,
									'thousands' => ','
                                )):'';
							else
							echo 	isset($value['VehicleLogDetail']['nu_km_traveled']) ? 
                                $this->Number->format($value['VehicleLogDetail']['nu_km_traveled'], array(
                                'places' => false,
                                'before' => false,
                                'escape' => false,
                                'decimals' => false,
                                'thousands' => ','
                                )):'';
			    ?>
                    </td>
			<!--
			<td align="right"><?php echo $value['VehicleLogDetail']['vc_other_road_orign_name']; ?></td>
			<td align="right"><?php echo $value['VehicleLogDetail']['vc_other_road_destination_name']; ?></td>
			<td align="right"><?php echo number_format($value['VehicleLogDetail']['nu_other_road_km_traveled']); ?></td>
		-->
		</tr>
	
	<?php endforeach; 
	
	?><tr><td>
<input type="hidden" value="<?php if(count($maxodometer)>0)
echo max($maxodometer);
							else
								echo 0;?>" name="lastvalueodometer" id="lastvalueodometerid">
<input type="hidden" value="<?php if($lastvaluetotalkilometer>0)
echo $lastvaluetotalkilometer;
							else
								echo 0;?>" name="lastvaluetotalkilometer" id="lastvaluetotalkilometerid">
</td></tr>
</table>


</div>
<!-- end innerbody here--> 

