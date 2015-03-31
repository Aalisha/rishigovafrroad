<?php
	$key = $rowCount;
    $mod = $rowCount % 2;
    $rowshow = $mod == 0 ? '1' : '';
    ?>		


    <tr class="cont<?php echo $rowshow; ?>">

        <td valign="top" >
            <?php
            echo $this->Form->input("VehicleLogDetail.$key.dt_log_date", array('label' => false,
                'div' => false,
                'type' => 'text',
                'value' => date('d M Y'),
                'readonly' => 'readonly',
                'required' => 'required',
                'class' => 'round3 addlog'));
            ?> 

        </td>
        <td valign="top" >
            <?php
            echo $this->Form->input("VehicleLogDetail.$key.vc_driver_name", array('label' => false,
                'div' => false,
                'type' => 'text',
                'required' => 'required', 'maxlength' => 50,
                'class' => 'round3'));
            ?>

        </td>
        <td valign="top" >
            <?php
            echo $this->Form->input("VehicleLogDetail.$key.nu_start_ometer", array('label' => false,
                'div' => false,
                'type' => 'text', 'required' => 'required',
                'readonly' => 'readonly',
                'maxlength' => 15,
                'class' => 'round3'));
            ?>

        </td>
        <td valign="top" >
            <?php
            echo $this->Form->input("VehicleLogDetail.$key.nu_end_ometer", array('label' => false,
                'div' => false,
                'type' => 'text',
                'required' => 'required',
                'maxlength' => 15,
                'class' => 'round3')
            );
            ?>

        </td>
        <td valign="top" >
            <?php
            echo $this->Form->input("VehicleLogDetail.$key.vc_orign", array('label' => false,
                'div' => false,
                'type' => 'text',
                'maxlength' => 50, 'required' => 'required',
                'class' => 'round3')
            );
            ?>

        </td>
        <td valign="top" >
            <?php
            echo $this->Form->input("VehicleLogDetail.$key.vc_destination", array('label' => false,
                'div' => false,
                'type' => 'text',
                'maxlength' => 50,
                'required' => 'required', 'class' => 'round3')
            );
            ?>

        </td>
        <td valign="top" >
            <?php
            echo $this->Form->input("VehicleLogDetail.$key.nu_km_traveled", array('label' => false,
                'div' => false,
                'type' => 'text', 
                'maxlength' => 10,
                'required' => 'required',
                'readonly' => 'readonly',
                'class' => 'round3')
            );
            ?>

        </td>
        <td valign="top" >
            <?php
            echo $this->Form->input("VehicleLogDetail.$key.nu_other_road_km_traveled", array('label' => false,
                'div' => false,
                'type' => 'text',
                'maxlength' => 10,
                'class' => 'round3')
            );
            ?>

        </td>
		
		<td valign="top" >
            <?php
            echo $this->Form->input("VehicleLogDetail.$key.vc_other_road_orign", array('label' => false,
                'div' => false,
                'type' => 'text',
                'maxlength' => 50,
                'class' => 'round3')
            );
            ?>

        </td>
		
		<td valign="top" >
            <?php
            echo $this->Form->input("VehicleLogDetail.$key.vc_other_road_destination", array('label' => false,
                'div' => false,
                'type' => 'text',
                'maxlength' => 50,
                'class' => 'round3')
            );
            ?>

        </td>
		
		<td valign="top" width="8%" style='text-align:center;'  >
            
			 <?php
					echo $this->Form->input("VehicleLogDetail.$key.uploaddocs", array('label' => false,
						'div' => false,
						'type' => 'file',
						'class' => 'uploadfile')
					);
            ?>
			<?php
			
			 //echo $this->Html->image('upload-photo-icon.jpg', array('alt' => '', 'id'=>'updmg'.$key, 'title'=>'Upload Image','style'=>' cursor: pointer;'));

			 ?>
           
          
        </td>
		

        <td valign="top" >
            <?php
            echo $this->Form->input("VehicleLogDetail.$key.vc_remark", array('label' => false,
                'div' => false,
                'type' => 'textarea',
                'rows' => "1",
                'cols' => "30",
                'class' => '',
                'maxlength' => 500
            ));
            ?>

        </td>
    </tr>