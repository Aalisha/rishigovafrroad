<div class="wrapper">
    <!-- Start breadcrumb here-->
    <div class="breadcrumb">
        <ul>
            <li class="first">
                <?php echo $this->Html->link('Home', array('controller' => 'inspectors', 'action' => 'index'), array('title' => 'Home', 'class' => 'vtip')) ?>
            </li>

            <li class="last">Inactive Vehicle Log Registration Form</li>        
        </ul>
    </div>
    <!-- end breadcrumb here-->

    <!-- Start mainbody here-->
	<div class="mainbody" style='width: 93% !important;'>

		<h1><?php echo $mdclocal;?></h1>

        <h3>Operator Vehicles Log </h3>

		<?php echo $this->Form->create('CustomerInactiveVehicleLog',array('url' => array('controller' => 'inspectors', 'action' => 'inactivevehicles'))); ?>
			
		<div class="innerbody listsr1" style='overflow-y: auto !important;' >
           
		   <table width="100%" cellspacing="1" cellpadding="5" border="0" >
                
				<thead> 
				
					<tr class="listhead">
					
						<td >Date</td>
						
						<td >Driver Name</td>
						
						<td>Vehicle Lic. No.</td>
						
						<td>Vehicle Reg. No.</td>
						
						<td>Start Odometer</td>
						
						<td>End Odometer</td>
						
						<td>Origin</td>
						
						<td>Destination</td>
						
						<td>KM Travel on Namibian Road Network</td>
									
						<td>Origin <br/>Other Road </td>
						
						<td>Destination Other Road</td>
						
						<td>KM Travel on Other Road</td>
					
					</tr>
				
				</thead>
				
				<tbody>
				
					<tr class="cont1">
                        <td valign="top" >
                            <?php
                            echo $this->Form->input('dt_log_date', array('label' => false,
                                'div' => false,
                                'type' => 'text',
								'readonly'=>'readonly',
                                'required' => 'required',
								'value'=>date('d M Y'),
								'style'=>' width: 82px; !important',
                                'class' => 'round3 disabled-field'));
                            ?>
                        </td>						
                        <td valign="top" >
                            <?php
                            echo $this->Form->input('vc_driver_name', array('label' => false,
                                'div' => false,
                                'type' => 'text',
                                'tabindex'=>1,
                                'required' => 'required',
								'style'=>' width: 82px; !important',
                                'maxlength'=>100,
                                'class' => 'round3'));
                            ?>                           
                        </td>
						
                        <td valign="top" >
                            <?php
                            echo $this->Form->input('vc_vehicle_lic_no', array('label' => false,
                                'div' => false,
                                'type' => 'text',
                                'maxlength'=>15,
								'style'=>' width: 82px; !important',
                                'tabindex'=>2,
                                'required' => 'required',
                                'class' => 'round3'));
                            ?>                           
                        </td>
						
                        <td valign="top" >
                            <?php
                            echo $this->Form->input('vc_vehicle_reg_no', array('label' => false,
                                'div' => false,
                                'type' => 'text',
                                'maxlength'=>15,
								'style'=>' width: 82px; !important',
                                'tabindex'=>3,
                                'required' => 'required',
                                'class' => 'round3')
                            );
                            ?>                           
                        </td>
						
                        <td valign="top" >
                            <?php
                            echo $this->Form->input('nu_start_ometer', array('label' => false,
                                'div' => false,
                                'type' => 'text',
								'style'=>' width: 82px; !important',
                                'required' => 'required',
                                'tabindex'=>4,
                                'maxlength'=>15,
                                'class' => 'round3')
                            );
                            ?>
                            <!--<input type="text" class="round3" />-->
                        </td>
                        <td valign="top" >
                            <?php
                            echo $this->Form->input('nu_end_ometer', array('label' => false,
                                'div' => false,
                                'type' => 'text',
								'style'=>' width: 82px; !important',
                                'tabindex'=>5,
                                'required' => 'required',
                                'maxlength'=>50,
                                'class' => 'round3')
                            );
                            ?>
                           
                        </td>
                        <td valign="top" >
                            <?php
                            echo $this->Form->input('vc_orign', array('label' => false,
                                'div' => false,
                                'type' => 'select',
								'options'=>$OriginCustomerLocationDistance,
                                'tabindex'=>6,
								'style'=>' width: 82px; !important',
                                'required' => 'required',                               
                                'class' => 'round3 selectlog')
                            );
                            ?>
                        
                        </td>
						<td valign="top" >
                            <?php
                            echo $this->Form->input('vc_destination', array('label' => false,
                                'div' => false,
                                'type' => 'select',
										'options'=>array(''=>' Select '),
										'tabindex'=>7,
										'style'=>' width: 82px; !important',
                                'required' => 'required',
                                'style'=>'width:82px;',                               
                                'class' => 'round3 selectlog')
                            );
                            ?>
                            <!--<input type="text" class="round3" />-->
                        </td>
						
						 <td valign="top" >
                            <?php
                            echo $this->Form->input('nu_km_traveled', array('label' => false,
                                'div' => false,
                                'type' => 'text',
										'required' => 'required',
										'readonly'=>true,
										'style'=>' width: 120px; !important',
                                'tabindex'=>8,
                                'maxlength'=>10,                                
                                'class' => 'round3')
                            );
                            ?>
                            
                        </td>
						 <td valign="top" >
                            <?php
                            echo $this->Form->input('vc_other_road_orign', array('label' => false,
                                'div' => false,
                                'type' => 'select',
										'options'=>$OriginCustomerLocationDistance,
                                'tabindex'=>9,
										'style'=>' width: 82px; !important',
                                'maxlength'=>50,
                                 'class' => 'round3 selectlog')
                            );
                            ?>
                           
                        </td>
						
						 <td valign="top" >
                            <?php
                            echo $this->Form->input('vc_other_road_destination', array('label' => false,
                                'div' => false,
                                'type' => 'select',
										'options'=>array(''=>' Select '),
                                'tabindex'=>10,
										'style'=>' width: 82px; !important',
                                'maxlength'=>50,
                                 'class' => 'round3 selectlog')
                            );
                            ?>
                           
                        </td>
						
						 <td valign="top" >
                            <?php
                            echo $this->Form->input('nu_other_road_km_traveled', array('label' => false,
                                'div' => false,
                                'type' => 'text',
                                'tabindex'=>11,
										'style'=>' width: 82px; !important',
                                'maxlength'=>50,
                                'class' => 'round3')
                            );
                            ?>
                           
                        </td>
						
                    </tr>
				</tbody>
				
            
				

            </table>
          
        </div>
		<table width="100%" border="0">
			<tr>
				<td valign='top' align="center">
							
					&nbsp;&nbsp;&nbsp;&nbsp;							
					<?php
					echo $this->Form->button('Submit', array('label' => false,
						'div' => false,
						'id' => 'submit',
						'type' => 'submit',
						'class' => 'submit'));
					?>		
					&nbsp;&nbsp;&nbsp;&nbsp;
					<?php
					 /* echo $this->Form->button('Reset', array('label' => false,
						'div' => false,
						'id' => 'rmrow',
						'type' => 'reset',
						'class' => 'submit')); */
					?>
											
				</td>

			</tr>
		</table>	
			
		<?php echo $this->Form->end(null); ?>

	</div>
    <!-- end mainbody here--> 
	
</div>	
	<?php echo $this->element('commonmessagepopup'); ?>

	<?php echo $this->element('commonbackproceesing'); ?>
	
	<?php echo $this->Html->script('inspector/inactivevehicles'); ?>