<?php 	$currentUser = $this->Session->read('Auth'); ?>
<!-- Start wrapper here-->
<div class="wrapper">
 <!-- Start breadcrumb here-->
    <div class="breadcrumb">
        <ul>
        <li class="first">
         <?php echo $this->Html->link('Home', array('controller' => 'customers', 'action' => 'view','cbc' =>true), array('title' => 'Home', 'class' => 'vtip')) ?>
        </li>
        
        <li class="last">Vehicles List </li>        
        </ul>
   </div>
<!-- end breadcrumb here-->
<!-- Start mainbody here-->
    <div class="mainbody">
    <h1>Welcome to RFA CBC</h1>
    <h3>Vehicles List </h3>
    <!-- Start innerbody here-->
							 <?php echo $this->Form->create(array('url' => array('controller' => 'vehicles', 
																				 'action' => 'cbc_vehiclesreg'),
																				 'type'=>'file')); ?>
    <div class="innerbody">
    <table width="100%" border="0" cellpadding="3">
		<tr>
			<td><label class="lab-inner1">Customer Name :</label></td>
			<td>
				<?php echo $this->Form->input('Customer.vc_customer_name', array('label' =>false,
																		'div'=>false, 
																		'disabled'=>'disabled',
																		'type' => 'text',
																		'value'=> $currentUser['Customer']['vc_first_name'] . ' ' . $currentUser['Customer']['vc_surname'],
																		'class'=>'round')); 
				?>
			</td>
			<td><label class="lab-inner1">Address 1 :</label></td>
			<td>
				<?php echo $this->Form->input('Customer.vc_address1', array('label' =>false,
                                                                   'div'=>false, 
                                                                   'type' => 'text',
																   'disabled'=>'disabled',
																   'value'=>$currentUser['Customer']['vc_address1'],
                                                                   'class'=>'round')); 
				?>
			</td>
			<td><label class="lab-inner">Address 2 :</label></td>
			<td>
				<?php echo $this->Form->input('Customer.vc_address2', array('label' =>false,
                                                                   'div'=>false, 
                                                                   'type' => 'text',
																    'value'=>$currentUser['Customer']['vc_address2'],
																   'disabled'=>'disabled',
                                                                   'class'=>'round')); 
				?>
			</td>
		</tr>
		<tr>
			<td><label class="lab-inner1">Address 3 :</label></td>
			<td>
				<?php echo $this->Form->input('Customer.vc_address3', array('label' =>false,
                                                                   'div'=>false, 
                                                                   'type' => 'text',
																   'disabled'=>'disabled',
																   'value'=>$currentUser['Customer']['vc_address3'],
                                                                   'class'=>'round')); 
				?>
			</td>
			<td><label class="lab-inner1">Telephone No. :</label></td>
			<td>
				<?php echo $this->Form->input('Customer.vc_tel_no', array('label' =>false,
                                                                 'div'=>false, 
                                                                 'type' => 'text',
																 'disabled'=>'disabled',
																 'value'=>$currentUser['Customer']['vc_tel_no'],
                                                                 'class'=>'round')); 
				?>
			</td>
			<td><label class="lab-inner">Fax No. :</label></td>
			<td>
				<?php echo $this->Form->input('Customer.vc_fax_n', array('label' =>false,
                                                                'div'=>false, 
                                                                'type' => 'text',
																'disabled'=>'disabled',
																'value'=>$currentUser['Customer']['vc_fax_no'],
                                                                'class'=>'round')); 
				?>
			</td>
		</tr>
        <tr>
            <td><label class="lab-inner1">Email :</label></td>
            <td>
				<?php echo $this->Form->input('Customer.vc_email', array('label' =>false,
																   'div'=>false, 
                                                                   'type' => 'text',
																   'disabled'=>'disabled',
																   'value'=>$currentUser['Customer']['vc_email'],
                                                                   'class'=>'round')); 
				?>
			</td>
            <td><label class="lab-inner1">Mobile No. :</label></td>
            <td>
				<?php echo $this->Form->input('Customer.vc_mobile_no', array('label' =>false,
                                                                    'div'=>false, 
                                                                    'type' => 'text',
																	'disabled'=>'disabled',
																	'value'=>$currentUser['Customer']['vc_mobile_no'],
                                                                    'class'=>'round')); 
				?>
			</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
		</tr>
		<tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
		</tr>
		<tr>
			
     
	 <!-- end mainbody here--> 

</table>	 
</div>
<div class="innerbody">
<table width="100%" cellspacing="1" cellpadding="5" border="0" >
		<tr class="listhead1">
					<td width="4%" align="center">SI. No.</td>
					<td width="10%" align="center">Vehicle Type</td>
                    <td width="12%"  align="center">Vehicle Reg. No.</td>
                    <td width="10%"  align="center">Vehicle Make</td>
                    <td width="10%" align="center">No. of Axles</td>
                    <td width="10%" align="center">V Rating</td>
                    <td width="14%" align="center">D/T Rating</td>
                    <td width="12%" align="center">Vehicle Status</td>
                </tr>
				
		<?php
				$i=0;
				foreach($list as $val){
				$i;
			?>
			
			
			<tr class="cont1">
			<td align="right">
			
					<?php 
						echo $start;
					?>
				</td>
		
			<td align="left">
				<?php 
			           if(isset($val['AddVehicle']['vc_veh_type']) && !empty($val['AddVehicle']['vc_veh_type']))
					echo wordwrap($globalParameterarray[$val['AddVehicle']['vc_veh_type']],15, "<br>\n", true);
					
				?>
			</td>
			
			
			
			<td align="left">
				<?php 
					echo $val['AddVehicle']['vc_reg_no'];
					
				?>
			</td> 
			
			<td align="left">
				<?php 
				if(isset($val['AddVehicle']['vc_make']) && !empty($val['AddVehicle']['vc_make']))
					echo wordwrap($globalParameterarray[$val['AddVehicle']['vc_make']],15, "<br>\n", true);
					
				?>
			</td>
			
			<td align="left">
				<?php 
				if(isset($val['AddVehicle']['vc_axle_type']) && !empty($val['AddVehicle']['vc_axle_type']))
					echo wordwrap($globalParameterarray[$val['AddVehicle']['vc_axle_type']],15, "<br>\n", true);
					
				?>
			</td>
			
			<td align="right">
				<?php 
					echo number_format($val['AddVehicle']['nu_v_rating']);
					
				?>
			</td>
			
			<td align="right">
				<?php 
					echo number_format($val['AddVehicle']['nu_d_rating']);
					
				?>
			</td>
			
			<td align="left">
				<?php 
				
				   echo $globalParameterarray[$val['AddVehicle']['vc_status']];?>
				   &nbsp; &nbsp; &nbsp;
				   <?php
				if ($val['AddVehicle']['vc_status'] == 'STSTY05') :

                                    $url = $this->webroot . 'cbc/vehicles/editvehicle/' . base64_encode($val['AddVehicle']['nu_vehicle_id']);
									
									echo $this->Html->image('editbutton.png', array('alt' => '', 'title'=>'Edit Vehicle Detail', 'onclick' => "javascript: window.location ='".$url."'", 'style'=>' cursor: pointer;'));
									
                                    /* echo $this->Form->button('Edit', array('label' => false,
                                        'div' => false,
                                        'type' => 'button',
                                        'onclick' => "javascript: window.location ='$url'",
                                        'class' => 'round3')); */

                                else :

                                  // echo $globalParameterarray[$val['AddVehicle']['vc_status']];

                                endif;
                                
					
					
					$i++;  $start++; 
					
					}
				?>
				
				

			</td>
			
			
</table>
</div>	
</div>	

 <?php echo $this->element('cbc/paginationfooter'); ?>
	
<!-- end wrapper here-->
</div>
