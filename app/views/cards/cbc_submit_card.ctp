<?php $currentUser = $this->Session->read('Auth'); ?>
<!-- Start wrapper here-->
<div class="wrapper">
 <!-- Start breadcrumb here-->
    <div class="breadcrumb">
        <ul>
        <li class="first">
         <?php echo $this->Html->link('Home', array('controller' => 'customers', 'action' => 'view','cbc' =>true), array('title' => 'Home', 'class' => 'vtip')) ?>

        </li>
        
        <li class="last">Prepaid Card Request</li>        
        </ul>
   </div>
<!-- end breadcrumb here-->
<!-- Start mainbody here-->
    <div class="mainbody">
    <h1>Welcome to RFA CBC</h1>
    <h3>Prepaid Card Request</h3>
    <!-- Start innerbody here-->
			
			
    <div class="innerbody">
    <table width="100%" border="0" cellpadding="3">
		<tr>
			<td><label class="lab-inner1">Customer Name :</label></td>
			<td>
				<?php echo $this->Form->input('Customer.vc_customer_name', array('label' =>false,
																		'div'=>false, 
																		'disabled'=>'disabled',
																		'type' => 'text',
																		'value' => trim($currentUser['Customer']['vc_first_name']) . ' ' . trim($currentUser['Customer']['vc_surname']),
																		'class'=>'round')); 
				?>
			</td>
			<td><label class="lab-inner1">Address 1 :</label></td>
			<td>
				<?php echo $this->Form->input('Customer.vc_address1', array('label' =>false,
                                                                   'div'=>false, 
                                                                   'type' => 'text',
																   'disabled'=>'disabled',
																   'value'=>trim($currentUser['Customer']['vc_address1']),
                                                                   'class'=>'round')); 
				?>
			</td>
			<td><label class="lab-inner">Address 2 :</label></td>
			<td>
				<?php echo $this->Form->input('Customer.vc_address2', array('label' =>false,
                                                                   'div'=>false, 
                                                                   'type' => 'text',
																    'value'=>trim($currentUser['Customer']['vc_address2']),
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
																   'value'=>trim($currentUser['Customer']['vc_address3']),
                                                                   'class'=>'round')); 
				?>
			</td>
			<td><label class="lab-inner1">Telephone No. :</label></td>
			<td>
				<?php echo $this->Form->input('Customer.vc_tel_no', array('label' =>false,
                                                                 'div'=>false, 
                                                                 'type' => 'text',
																 'disabled'=>'disabled',
																 'value'=>trim($currentUser['Customer']['vc_tel_no']),
                                                                 'class'=>'round')); 
				?>
			</td>
			<td><label class="lab-inner">Fax No. :</label></td>
			<td>
				<?php echo $this->Form->input('Customer.vc_fax_n', array('label' =>false,
                                                                'div'=>false, 
                                                                'type' => 'text',
																'disabled'=>'disabled',
																'value'=>trim($currentUser['Customer']['vc_fax_no']),
                                                                'class'=>'round')); 
				?>
			</td>
		</tr>
        <tr>
            <td><label class="lab-inner1">Email :</label></td>
            <td>
				<?php echo $this->Form->input('Customer.vc_email_id', array('label' =>false,
																   'div'=>false, 
                                                                   'type' => 'text',
																   'disabled'=>'disabled',
																   'value'=>trim($currentUser['Customer']['vc_email']),
                                                                   'class'=>'round')); 
				?>
			</td>
            <td><label class="lab-inner1">Mobile No. :</label></td>
            <td>
				<?php echo $this->Form->input('Customer.vc_mobile_no', array('label' =>false,
                                                                    'div'=>false, 
                                                                    'type' => 'text',
																	'disabled'=>'disabled',
																	'value'=>trim($currentUser['Customer']['vc_mobile_no']),
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
			<td width="10%" align="center">SI. No.</td>
			<td width="25%" align="center"> No. of Cards Requested</td>
			<td width="25%" align="center">Requested Date</td>
			<td width="25%" align="center">Current Status</td>
			<td width="25%" align="center">Total Charges (N$)</td>
		</tr>
		
		<?php 
				foreach( $list as $key => $val ) { 
						
						$str = $key % 2 == 0 ? '' : '1';
		?>
			
			<tr class="cont<?php echo $str; ?>">
			
				<td align="right">
			
					<?php 
						echo $start;
					?>
				</td>
				
			
				<td align="right">
					
					<?php 
						
						echo number_format($val['RequestCard']['vc_no_of_cards']);
						
					?>
					
				</td>
				
				
				
				<td align="left">
					<?php
						echo date('d-M-Y', strtotime($val['RequestCard']['dt_created']));
						
					?>
				</td>
				
				<td align="left">
					<?php 
						echo $globalParameterarray[$val['RequestCard']['vc_status']];
						if($val['RequestCard']['vc_status']=='STSTY05'){
					?>&nbsp;&nbsp;<br><b>Reason</b> &nbsp;:&nbsp;&nbsp;<?php echo $val['RequestCard']['vc_remarks'];?>
					<?php }?>
				</td>
				
				<td align="right">
					<?php 
						echo number_format($val['RequestCard']['nu_total_charges'], 2, '.', ',');
					
						
					
					?>
				</td>
			
			 </tr>
			 <?php  $start++;
							
					?>
			<?php 	}  ?>
			
			
</table>	
</div>	
</div>
 <?php echo $this->element('cbc/paginationfooter'); ?>
	
<!-- end wrapper here-->
</div>