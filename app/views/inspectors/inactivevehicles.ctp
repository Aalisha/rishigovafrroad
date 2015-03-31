<div class="wrapper">
    <!-- Start breadcrumb here-->
    <div class="breadcrumb">
        <ul>
            <li class="first">
                <?php echo $this->Html->link('Home', array('controller' => 'inspectors', 'action' => 'index'), array('title' => 'Home', 'class' => 'vtip')) ?>
            </li>

			<li class="last">Non Registered Vehicles Log  Form</li>       
		</ul>
    </div>
    <!-- end breadcrumb here-->

    <!-- Start mainbody here-->
    <div class="mainbody" style='width:93% !important;'>
        <h1><?php echo $mdclocal;?></h1>

            <!--<li class="last">Inactive Vehicle Log Registration Form</li>  -->      

        <?php echo $this->Form->create('CustomerInactiveVehicleLog',array('url' => array('controller' => 'inspectors', 'action' => 'inactivevehicles'),'type'=>'file')); ?>
        <!-- Start innerbody here-->     
        <!-- end innerbody here-->
        <h3>Non Registered Vehicles Log  Form </h3>
        <!-- Start innerbody here-->
        <div class="innerbody  listsr1"  style='overflow-y: visible !important;' >
            <table width="100%" cellspacing="1" cellpadding="5" border="0" >
               <thead> 
					<tr class="listhead ">
						<td width="10%">Vehicle Lic No.</td>
						<td width="10%">Vehicle Register No.</td>
						<td width="10%">Select Road</td>
						<td width="10%">Date</td>
						<td width="8%">Driver Name</td>
						<td width="8%">Start Odometer</td>
						<td width="8%">End Odometer</td>
						<td width="8%">Origin Road </td>
						<td width="8%">Destination Road</td>
						<td width="8%">KM Travel on Road</td>
						<td width="6%">Upload Docs.</td>
						<td width="6%">Remarks</td>
					</tr>
				</thead>
				
				<tbody id='tbody1'>
								
				
					   <?php $key = 0;   ?>

    <tr class="cont1">
	<td valign="top" >
                            <?php
                            echo $this->Form->input("VehicleLogDetail.$key.vc_vehicle_lic_no", array('label' => false,
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
                            echo $this->Form->input("VehicleLogDetail.$key.vc_vehicle_reg_no", array('label' => false,
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
		<td valign="top">
		<?php
		echo $this->Form->input("VehicleLogDetail.$key.selectedroad",array('label' => false,
                                'div' => false,
                                'type' => 'select',
								'style' => 'width:74px',
								'options'=>array('Namibian Road','Other Road'),
								'onchange'=>'show_option()',
								'tabindex'=>4,
								//'multiple'=>'true',
                                'class' => 'round3 selectlog'));
						
		?>
		</td>
      <td valign="top" >
            <?php
            echo $this->Form->input("VehicleLogDetail.$key.dt_log_date", array('label' => false,
                'div' => false,
                'type' => 'text',
                'value' => date('d M Y'),
				'tabindex'=>5,
                'readonly' => 'readonly',
                'class' => 'round3 disabled-field'));
            ?> 

        </td>
         <td valign="top" >
            <?php
            echo $this->Form->input("VehicleLogDetail.$key.vc_driver_name", array('label' => false,
                'div' => false,
                'type' => 'text',        
				'tabindex'=>6,				
				'maxlength' => 100,
                'class' => 'round3'));
            ?>

        </td>
       <td valign="top" >
             <?php
                            echo $this->Form->input("VehicleLogDetail.$key.nu_start_ometer", array('label' => false,
                                'div' => false,
                                'type' => 'text',
								'style'=>' width: 82px; !important',
                                'required' => 'required',
                                'tabindex'=>7,
                                'maxlength'=>15,
                                'class' => 'round3')
                            );
                            ?>

        </td>
        <td valign="top" >
            <?php
             echo $this->Form->input("VehicleLogDetail.$key.nu_end_ometer", array('label' => false,
                'div' => false,
                'type' => 'text',
              'tabindex'=>8,
                'maxlength' => 15,
                'class' => 'round3')
            ); 
            ?>

        </td>
		<td valign="top" id="td_origin_id" >
            <?php
            echo $this->Form->input("VehicleLogDetail.$key.vc_orign", array('label' => false,
                'div' => false,
                'type' => 'select',
				'options'=>$OriginCustomerLocationDistance,
                'maxlength' => 50,
				'tabindex'=>9,
				//'required' => 'required',
                'class' => 'round3 selectlog') );
            ?>

        </td>
		
		<td valign="top" id="td_destination_id"  >
            <?php
            echo $this->Form->input("VehicleLogDetail.$key.vc_destination", array('label' => false,
                'div' => false,
                'type' => 'select',
                'maxlength' => 50,
				'tabindex'=>10,
				'options'=>array(''=>' Select '),
                //'required' => 'required ',
				'class' => 'round3 selectlog')
            );
            ?></td>
			<td valign="top" id="td_otherorigin_id" style="display:none;" >
            <?php
            echo $this->Form->input("VehicleLogDetail.$key.vc_other_road_orign", array('label' => false,
                'div' => false,
                'type' => 'text',
				'required' => 'required',
				'maxlength'=>50,
				'tabindex'=>11,
				//'required' => 'required',
                'class' => 'round3 selectlog'));
            ?>

        </td>
        <td valign="top" id="td_otherdestination_id"  style="display:none;" >
            <?php
            echo $this->Form->input("VehicleLogDetail.$key.vc_other_road_destination", array('label' => false,
                'div' => false,
                'type' => 'text',
				'tabindex'=>12,
								'required' => 'required',
								'maxlength'=>50,
				//'options'=>array(''=>' Select '),
                //'required' => 'required ',
				'class' => 'round3 selectlog')
            );
            ?></td><!--
        <td valign="top" >
            <?php
            echo $this->Form->input("VehicleLogDetail.$key.vc_orign", array('label' => false,
                'div' => false,
                'type' => 'select',
				'options'=>$OriginCustomerLocationDistance,
                'maxlength' => 50,
				 'tabindex'=>6,
				
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
				 'tabindex'=>7,
               
				'class' => 'round3 selectlog')
            );
            ?>
</td>-->
		 <td valign="top" >
            <?php
            echo $this->Form->input("VehicleLogDetail.$key.nu_km_traveled", array('label' => false,
                'div' => false,
                'type' => 'text',
				 'tabindex'=>13,
                'maxlength' => 10,
				'readonly' => 'readonly',
                //'required' => 'required',
                'class' => 'round3')
            );
            ?>

        </td>
		
		<td valign="top" width="8%" style='text-align:center;'  >
           <?php
					echo $this->Form->input("VehicleLogDetail.$key.uploaddocs", array('label' => false,
						'div' => false,
						 'tabindex'=>14,
						'type' => 'file',
						"style"=>"width:70px;",
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
				 "style"=>"width:110px;",
                'maxlength' => 500,
				 'tabindex'=>15,
            
			));
            ?>

        </td>
    </tr>
	<?php 
	
	$key=1;
	$tabindex=15;
	?>
    <tr class="cont1" id="SecondRow" style="display:none">
	<td valign="top" >
                            <?php
                           
                            ?>                           
                        </td>
						
                        <td valign="top" >
                            <?php
                           
                            ?>                           
                        </td>
		<td valign="top">
		<?php
		echo $this->Form->input("VehicleLogDetail.$key.selectedroad",array('label' => false,
                                'div' => false,
                                'type' => 'select',
								'style' => 'width:74px',
								'options'=>array('Namibian Road','Other Road'),
								//'multiple'=>'true',
								 'tabindex'=>$tabindex+1,
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
				 'tabindex'=>$tabindex+2,
                'class' => 'round3 disabled-field'));
            ?> 

        </td>
         <td valign="top" >
            <?php
            echo $this->Form->input("VehicleLogDetail.$key.vc_driver_name", array('label' => false,
                'div' => false,
                'type' => 'text',        
 'tabindex'=>$tabindex+3,				
				'maxlength' => 100,
                'class' => 'round3'));
            ?>

        </td>
       <td valign="top" >
             <?php
                            echo $this->Form->input("VehicleLogDetail.$key.nu_start_ometer", array('label' => false,
                                'div' => false,
                                'type' => 'text',
								'style'=>' width: 82px; !important',
                                'required' => 'required',
                                'tabindex'=>$tabindex+4,
                                'maxlength'=>15,
                                'class' => 'round3')
                            );
                            ?>

        </td>
        <td valign="top" >
            <?php
             echo $this->Form->input("VehicleLogDetail.$key.nu_end_ometer", array('label' => false,
                'div' => false,
                'type' => 'text',
              'tabindex'=>$tabindex+5,
                'maxlength' => 15,
                'class' => 'round3')
            ); 
            ?>

        </td>
		  <td valign="top" id="td_origin_id1" style="display:none;">
            <?php
            echo $this->Form->input("VehicleLogDetail.$key.vc_orign", array('label' => false,
                'div' => false,
                'type' => 'select',
				'options'=>$OriginCustomerLocationDistance,
                'maxlength' => 50,
'tabindex'=>$tabindex+6,				
				//'required' => 'required',
                'class' => 'round3 selectlog')
            );
            ?>

        </td>
        <td valign="top" id="td_destination_id1" style="display:none;" >
            <?php
            echo $this->Form->input("VehicleLogDetail.$key.vc_destination", array('label' => false,
                'div' => false,
                'type' => 'select',
                'maxlength' => 50,
				'tabindex'=>$tabindex+7,
				'options'=>array(''=>' Select '),
               // 'required' => 'required ', 
				'class' => 'round3 selectlog')
            );
            ?>
</td>
<td valign="top" id="td_otherorigin_id1"  >
            <?php
            echo $this->Form->input("VehicleLogDetail.$key.vc_other_road_orign", array('label' => false,
                'div' => false,
                'type' => 'text',
								'required' => 'required',
								'maxlength'=>50,
								'tabindex'=>$tabindex+8,
				//'required' => 'required',
                'class' => 'round3 selectlog'));
            ?>

        </td>
        <td valign="top" id="td_otherdestination_id1"   >
            <?php
            echo $this->Form->input("VehicleLogDetail.$key.vc_other_road_destination", array('label' => false,
                'div' => false,
                'type' => 'text',
								'required' => 'required',
								'maxlength'=>50,
								'tabindex'=>$tabindex+9,
				//'options'=>array(''=>' Select '),
                //'required' => 'required ',
				'class' => 'round3 selectlog')
            );
            ?></td>
        <!--
		<td valign="top" >
            <?php
            echo $this->Form->input("VehicleLogDetail.$key.vc_orign", array('label' => false,
                'div' => false,
                'type' => 'select',
				'options'=>$OriginCustomerLocationDistance,
                'maxlength' => 50,
				 'tabindex'=>$tabindex+10,
				
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
				 'tabindex'=>$tabindex+11,
               
				'class' => 'round3 selectlog')
            );
            ?>
</td>
-->
	
	<td valign="top" >
            <?php
            echo $this->Form->input("VehicleLogDetail.$key.nu_km_traveled", array('label' => false,
                'div' => false,
                'type' => 'text',			
                'tabindex'=>$tabindex+10,
				'readonly' => 'readonly',
                //'required' => 'required',
                'class' => 'round3')
            );
            ?>

        </td>
		
		<td valign="top" width="8%" style='text-align:center;'  >
           <?php
					echo $this->Form->input("VehicleLogDetail.$key.uploaddocs", array('label' => false,
						'div' => false,
						'tabindex'=>$tabindex+11,
						'type' => 'file',
						"style"=>"width:70px;",
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
				 "style"=>"width:110px;",
                'maxlength' => 500,
				 	'tabindex'=>$tabindex+12,            
			));
            ?>

        </td>
    </tr>			
<tr><td valign="top" colspan='2' align="left"><label >Do you want to add another row ? :</label></td>
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
	
	</tr>	
				</tbody>
				
				
			</table>	
           
        </div>
        
		 <table width="100%" border="0">
                <tr>
                    <td align="center">


                        &nbsp;&nbsp;&nbsp;&nbsp;			
                        <?php
                        echo $this->Form->button('Submit', array('label' => false,
								'div' => false,
                            'id' => 'submit',
                            'type' => 'submit',
                            'class' => 'submit'));
                        ?>			
                    </td>

                </tr>
            </table>
		<!-- end innerbody here-->    
        <?php echo $this->Form->end(null); ?>
    </div>
    <!-- end mainbody here--> 
</div>
	
<?php echo $this->element('commonmessagepopup'); ?>

<?php echo $this->element('commonbackproceesing'); ?>

<?php  echo $this->Html->script('inspector/inactivevehicles'); ?>