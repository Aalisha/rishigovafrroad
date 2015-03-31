<!--   <?php $key = 1;   ?>
    <tr class="cont1" id="SecondRow" style="display:none">
		<td valign="top" >
		<?php
		echo $this->Form->input("VehicleLogDetail.$key.selectedroad",array('label' => false,
                                'div' => false,
                                'type' => 'select',
								'style' => 'width:74px',
								'options'=>'Other Road',
                                'class' => 'round3 selectlog'));
						
		?>
		</td>
        <td valign="top" >
            <?php
            echo $this->Form->input("VehicleLogDetail.$key.dt_log_date", array('label' => false,
                'div' => false,
                'type' => 'text',
                'value' => date('d M Y'),
                'readonly' => 'readonly',
                //'required' => 'required',
                'class' => 'round3 disabled-field'));
            ?> 

        </td>
        <td valign="top" >
            <?php
            echo $this->Form->input("VehicleLogDetail.$key.vc_driver_name", array('label' => false,
                'div' => false,
                'type' => 'text',
                //'required' => 'required', 
				'maxlength' => 100,
                'class' => 'round3'));
            ?>

        </td>
        <td valign="top" >
            <?php
            echo $this->Form->input("VehicleLogDetail.$key.nu_start_ometer", array('label' => false,
                'div' => false,
                'type' => 'text',
				//'required' => 'required',
                'readonly' => 'readonly',
                'maxlength' => 15,
                'value' => $start,
				
                'class' => 'round3 disabled-field'));
            ?>

        </td>
        <td valign="top" >
            <?php
             echo $this->Form->input("VehicleLogDetail.$key.nu_end_ometer", array('label' => false,
                'div' => false,
                'type' => 'text',
                //'required' => 'required',
                'maxlength' => 15,
                'class' => 'round3')
            ); 
            ?>

        </td>
        <td valign="top" >
            <?php
            echo $this->Form->input("VehicleLogDetail.$key.vc_orign", array('label' => false,
                'div' => false,
                'type' => 'select',
				'options'=>$OriginCustomerLocationDistance,
                'maxlength' => 50, 
				//'required' => 'required',
                'class' => 'round3 selectlog')
            );
            ?>

        </td>
        <td valign="top" >
            <?php
            echo $this->Form->input("VehicleLogDetail.$key.vc_destination", array('label' => false,
                'div' => false,
                'type' => 'select',
                'maxlength' => 50,
				'options'=>array(''=>' Select '),
               // 'required' => 'required ', 
				'class' => 'round3 selectlog')
            );
            ?>

		 <td valign="top" >
            <?php
            echo $this->Form->input("VehicleLogDetail.$key.nu_km_traveled", array('label' => false,
                'div' => false,
                'type' => 'text',
                'maxlength' => 10,
				'readonly'=>'readonly',
                //'required' => 'required',
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
			
          
        </td>
		

        <td valign="top" >
            <?php
            echo $this->Form->input("VehicleLogDetail.$key.vc_remark", array('label' => false,
                'div' => false,
                'type' => 'textarea',
                'rows' => "1",
                'cols' => "30",
                'class' => '',
				 "style"=>"width:140px;",
                'maxlength' => 500,
            
			));
            ?>

        </td>
    </tr>
	<td valign="top" colspan='2' align="left"><label >Do you want to add another row ? :</label></td>
				<td  colspan='8' valign="top" align="left">
					<?php
					echo $this->Form->input("newrowcheckbox", array('type'=>'checkbox',
					'label' => false,
						'div' =>false,
						'id'=>'checked',
						'onclick'=>'road_select();show_option();'
						//'onclick'=>'road_select();'
						));
						?>
				</td>
	
	
	
	-->
	
	