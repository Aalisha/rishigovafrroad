<?php
    $mod = $rowCount % 2;
    $rowshow = $mod == 0 ? '' : '1';
    ?>
    <tr class="cont<?php echo $rowshow; ?>">
					<td valign="top" style="width:100px;">					
					<?php
						echo $this->Form->input("RoadID.$rowCount",array('label' => false,
                                'div' => false,
                                'type' => 'select',
								'onchange' => 'other_hide("'.$rowCount.'")',
								'style' => 'width:74px',
								'options'=>array('Namibian Road','Other Road'),
                                'class' => 'round3 selectlog'));
						
						
						?>
					</td>     

	  <td valign="top" style="width:117px;">
            <?php
            echo $this->Form->input("VehicleLogDetail.$rowCount.dt_log_date", array('label' => false,
                'div' => false,
                'type' => 'text',
                'required' => 'required',
				'readonly'=>'readonly',
				'style' => 'width:63px',
                'class' => 'round3 addlog'));
            ?>

        </td>
        <td valign="top" style="width:100px;">
            <?php
            echo $this->Form->input("VehicleLogDetail.$rowCount.vc_driver_name", array('label' => false,
                'div' => false,
                'type' => 'text',
                'required' => 'required',
				'maxlength'=>100,
				'style' => 'width:70px',
                'class' => 'round3'));
            ?>

        </td>
        <td valign="top" style="width:112px;">
            <?php
            echo $this->Form->input("VehicleLogDetail.$rowCount.nu_start_ometer", array('label' => false,
                'div' => false,
                'type' => 'text',
                'required' => 'required',
				'maxlength'=>10,
				'readonly'=>'readonly',
				'style' => 'width:64px',
                'class' => 'round3'));
            ?>

        </td>
        <td valign="top" style="width:100px;">
            <?php
            echo $this->Form->input("VehicleLogDetail.$rowCount.nu_end_ometer", array('label' => false,
                'div' => false,
                'type' => 'text',
				'maxlength'=>10,
				'style' => 'width:71px',
                'required' => 'required',
				'style' => 'width:71px',
                'class' => 'round3')
            );
            ?>

        </td>
        <td valign="top" style="width:100px;" id='td_vc_orign_<?php echo $rowCount?>id'>
            <?php
            echo $this->Form->input("VehicleLogDetail.$rowCount.vc_orign", array('label' => false,
                'div' => false,
                'type' => 'select',
				'options'=>$OriginCustomerLocationDistance,				
				'maxlength'=>50,
                'required' => 'required',
				'style' => 'width:58px',
                'class' => 'round3 selectlog')
            );
			
            ?>

        </td>
        <td valign="top" style="width:104px;" id='td_vc_destination_<?php echo $rowCount?>id'>
            <?php
            echo $this->Form->input("VehicleLogDetail.$rowCount.vc_destination", array('label' => false,
                'div' => false,
                'type' => 'select',
				'options'=>array(''=>' Select '),
				'maxlength'=>50,
                'required' => 'required',
				'style' => 'width:57px',
                'class' => 'round3 selectlog')
            );
			
            ?>

        </td>
        <td valign="top" style="width:100px;" colspan='4'  id='td_nu_km_traveled_<?php echo $rowCount?>id'>
            <?php
            echo $this->Form->input("VehicleLogDetail.$rowCount.nu_km_traveled", array('label' => false,
                'div' => false,
                'type' => 'text',
                'required' => 'required',
				'maxlength'=>10,
				'style' => 'width:73px',
				'readonly'=>'readonly',
                'class' => 'round3')
            );
            ?>

        </td>

		 <td valign="top" style='width:100px;display:none;' id='td_vc_other_road_orign_<?php echo $rowCount?>id'>
            <?php
				echo $this->Form->input("VehicleLogDetail.$rowCount.vc_other_road_orign", array('label' => false,
                'div' => false,
                'type' => 'text',
                'required' => 'required',
				'maxlength'=>50,
				'style'=>'display:none;width:58px;',				
                'class' => 'round3 selectlog')
            );
            ?>

        </td>
        <td valign="top"  style='width:102px;display:none;' id='td_vc_other_road_destination_<?php echo $rowCount?>id'>
            <?php
            echo $this->Form->input("VehicleLogDetail.$rowCount.vc_other_road_destination", array('label' => false,
                'div' => false,
                  'type' => 'text',
                'required' => 'required',
				'maxlength'=>50,
				'style'=>'display:none;width:57px',			
				'class' => 'round3 selectlog')
            );
            ?>

        </td>
		<td valign="top" 
		  style='display:none;width:112px;'   id='td_nu_other_road_km_traveled_<?php echo $rowCount?>id'>
            <?php
            echo $this->Form->input("VehicleLogDetail.$rowCount.nu_other_road_km_traveled", array('label' => false,
                'div' => false,
                'type' => 'text',
                'maxlength'=>10,
				'required'=>'required',
				'style'=>'width:73px;display:none',
				'readonly'=>'readonly',
				
				//'style'=>'width:76px',
				'value'=>'',
                'class' => 'round3')
            );
            ?>

        </td>
		
	</tr>
